<?php

namespace Amarkal\Loaders;

/**
 * Implements a universal autoloader for PHP >= 5.3
 * 
 * Classes that are to be loaded with the ClassLoader are to follow the PSR-0 
 * naming standards for namespaces and class names
 * (https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
 * 
 * Example usage:
 * 
 *		$loader = new ClassLoader();
 *		
 *		// Register the Amarkal namespace, located under __DIR__.'/Amarkal'
 *		$loader->register_namespace( 'Amarkal', __DIR__ );
 * 
 *		// Register a namespace with multiple paths
 *		$loader->register_namespace( 'Amarkal', array( __DIR__.'/src', __DIR__.'/lib/askupa' ) );
 *		
 *		// Activate the autoloader
 *		$loader->register();
 */
class ClassLoader {
	
	/**
	 * Namespaces array
	 * @var array	The array of namespaces and corresponding paths 
	 */
	private $namespaces;
	
	/**
	 * Loads the given class or interface
	 * 
	 * @param	string	$class	The name of the class
	 * @return	boolean			True/false if class was loaded
	 */
	private function load_class( $class ) {
		$file = $this->find_file( $class );
		if( null !== $file ) {
			require $file;
			return true;
		}
		return false;
	}
	
	/**
	 * Register a namespace
	 * 
	 * @param	string			$namespace	The namespace
	 * @param	array|string	$paths		The path(s) to the namespace
	 */
	public function register_namespace( $namespace, $paths ) {
		if ( isset( $this->namespaces[ $namespace ] ) ) {
            $this->namespaces[ $namespace ] = array_merge(
                $this->namespaces[ $namespace ],
                (array) $paths
            );
        } else {
            $this->namespaces[ $namespace ] = (array) $paths;
        }
	}
	
	/**
     * Finds the path to the file where the class is defined.
     *
     * @param	string $class	The name of the class
     * @return	string			The path, if found
     */
	private function find_file( $class ) {
		if ( false !== $pos = strrpos( $class, '\\' ) ) {
            $class_path = str_replace( '\\', DIRECTORY_SEPARATOR, substr( $class, 0, $pos ) ).DIRECTORY_SEPARATOR;
            $class_name = substr( $class, $pos + 1 );
        }
		
		$class_path .= $class_name.'.php';
		
		foreach ( $this->namespaces as $namespace => $dirs ) {
            if ( $class === strstr( $class, $namespace ) ) {
                foreach ( $dirs as $dir ) {
                    if ( file_exists($dir.DIRECTORY_SEPARATOR.$class_path ) ) {
                        return $dir.DIRECTORY_SEPARATOR.$class_path;
                    }
                }
            }
		}
	}
	
	/**
     * Registers this instance as an autoloader.
     *
     * @param bool    $prepend
     */
    public function register( $prepend = false ) {
        spl_autoload_register( array($this, 'load_class'), true, $prepend );
    }

    /**
     * Removes this instance from the registered autoloaders.
     */
    public function unregister() {
        spl_autoload_unregister( array( $this, 'load_class' ) );
    }
}
