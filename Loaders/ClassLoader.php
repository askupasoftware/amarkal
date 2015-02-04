<?php

namespace Amarkal\Loaders;

/**
 * Implements a universal autoloader for PHP >= 5.3
 * 
 * Classes that are to be loaded with the ClassLoader are to follow the PSR-0 
 * naming standards for namespaces and class names
 * (https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
 * 
 * <b>Example usage:<b>
 * <pre>
 * $loader = new ClassLoader();
 *        
 * // Register the Amarkal namespace, located under __DIR__.'/app'
 * $loader->register_namespace( 'Amarkal', __DIR__.'/app' );
 * 
 * // Register a namespace with multiple paths
 * $loader->register_namespace( 'Amarkal', array( __DIR__.'/src', __DIR__.'/lib/askupa' ) );
 *        
 * // Activate the autoloader
 * $loader->register();
 * </pre>
 */
class ClassLoader {
    
    /**
     * Namespaces array
     * @var array    Array of namespaces and corresponding paths 
     */
    private $namespaces;
    
    /**
     * Autoload filters.
     * @var array Array of filters per namespace.
     */
    private $filters = array();
    
    /**
     * Loads the given class or interface.
     * This function is registered by PHP's spl_autoload_register()
     * 
     * @param    string    $class    The name of the class
     * @return   boolean            True/false if class was loaded
     */
    private function load_class( $class ) 
    {
        $file = $this->find_file( $class );
        if( null !== $file ) 
        {
            require $file;
            return true;
        }
        return false;
    }
    
    /**
     * Register a namespace
     * 
     * @param    string            $namespace    The namespace
     * @param    array|string    $paths        The path(s) to the namespace
     */
    public function register_namespace( $namespace, $paths )
    {
        if ( isset( $this->namespaces[ $namespace ] ) )
        {
            $this->namespaces[ $namespace ] = array_merge(
                $this->namespaces[ $namespace ],
                (array) $paths
            );
        } 
        else 
        {
            $this->namespaces[ $namespace ] = (array) $paths;
            
            // Register PSR_0 as the first autoload filter for every namespace
            $this->register_autoload_filter( $namespace, array( $this, "PSR_0" ) );
        }
    }
    
    /**
     * Finds the path to the file where the class is defined.
     *
     * @param    string $class    The name of the class
     * @return    string            The path, if found
     */
    private function find_file( $class )
    {
        foreach ( $this->namespaces as $namespace => $dirs )
        {
            if ( $class === strstr( $class, $namespace ) ) 
            {
                foreach ( $dirs as $dir )
                {
                    return $this->apply_namespace_filters( $namespace, $class, $dir );
                }
            }
        }
    }
    
    /**
     * Internally used by find_file() to apply namespace filters.
     * 
     * @param string $namespace
     * @param string $class
     * @param string $dir
     * @return string File path
     */
    private function apply_namespace_filters( $namespace, $class, $dir )
    {
        foreach( $this->filters[$namespace] as $filter )
        {
            if( is_callable( $filter ) )
            {
                $file = call_user_func_array( $filter, array( $class, $namespace, $dir ) );
                if ( file_exists( $file ) ) 
                {
                    return $file;
                }
            }
        }
    }
    
    /**
     * Implements the PSR 0 class autoloader.
     * @param type $class
     */
    public function PSR_0( $class, $namespace, $dir )
    {
        return $dir.str_replace(
            array('\\',$namespace), 
            array(DIRECTORY_SEPARATOR,''), 
            $class
        ).'.php';
    }
    
    /**
     * Autoload filters are functions that are used to autoload classes. These 
     * functions accept a class name as an argument and return the appropriate 
     * file path to that class.
     * Autoload filters are applied per namespace. Each namespace can have 
     * multiple autoload filters. The class loader will loop through all the filters
     * until a file is found. The filters are looped through in the order in which
     * they were registered.
     * 
     * @param type $namespace The namespace in which the filter is applied.
     * @param type $filter    A callable that returns the file path for the given class.
     */
    public function register_autoload_filter( $namespace, $filter )
    {
        if(is_callable( $filter ) )
        {
            if( !isset($this->filters[$namespace]) )
            {
                $this->filters[$namespace] = array();
            }
            
            $this->filters[$namespace][] = $filter;
        }
    }
    
    /**
     * Registers this instance as an autoloader.
     *
     * @param bool    $prepend
     */
    public function register( $prepend = false ) 
    {
        spl_autoload_register( array($this, 'load_class'), true, $prepend );
    }

    /**
     * Removes this instance from the registered autoloaders.
     */
    public function unregister() 
    {
        spl_autoload_unregister( array( $this, 'load_class' ) );
    }
}