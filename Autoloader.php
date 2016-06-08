<?php

namespace Amarkal;

/**
 * Autoloads Amarkal classes
 * 
 * To use the autolaoder, simply require this file as a part of your
 * bootstrap process.
 */
class Autoloader 
{
    /**
     * Amarkal configuration (from file Core/config.inc.php)
     * @var mixed[] Amarkal configuration. 
     */
    private static $config;
    
    /**
     * Initiate the autoloader
     */
    public static function init()
    {
        self::$config = include('Core/config.inc.php');
        Autoloader::register_classes();
        Autoloader::register_assets();
    }
    
    /**
     * Register the class autoloader for Amarkal classes
     */
    private static function register_classes() 
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));        
    }
    
    /**
     * Loads the given class or interface
     * 
     * @param    string    $class    The name of the class
     * @return    null|boolean            True/false if class was loaded
     */
    public static function autoload( $class ) 
    {    
        // Verify that the base namespace is Amarkal
        if (0 !== strpos($class, __NAMESPACE__)) {
            return;
        }
        // UI classes
        if( strpos( $class, "Amarkal\UI\Components" ) === 0 )
        {
            $class .= "\controller";
        }
        // Widget UI classes
        if( strpos( $class, "Amarkal\Extensions\WordPress\Widget\UI" ) === 0 )
        {
            $class .= "\controller";
        }
        // Options UI classes
        if( strpos( $class, "Amarkal\Extensions\WordPress\Options\UI" ) === 0 )
        {
            $class .= "\controller";
        }
        
        $fileName = dirname(__FILE__).str_replace(array(__NAMESPACE__, '\\'), array('',DIRECTORY_SEPARATOR), $class).'.php';
        
        if ( is_file( $fileName ) ) {
            require $fileName;
            return true;
        }
        else return false;
    }
    
    /**
     * Register Amarkal Scripts and Stylesheets
     */
    private static function register_assets() 
    {    
        $ac = new \Amarkal\Loaders\AssetLoader();
        
        foreach ( self::$config['css']['register'] as $asset ) {
            $ac->register_asset(
                new Assets\Stylesheet(array(
                    'handle'    => $asset['handle'],
                    'url'       => $asset['url'],
                    'version'   => AMARKAL_VERSION,
                    'facing'    => $asset['facing'],
                    'footer'    => true
                ))    
            );
        };
        foreach ( self::$config['css']['enqueue'] as $handle ) {
            $ac->register_asset(
                new Assets\Stylesheet(array(
                    'handle'    => $handle,
                    'facing'    => array( 'admin' ),
                    'footer'    => true
                ))    
            );
        };
        foreach ( self::$config['js']['register'] as $asset ) {
            $ac->register_asset(
                new Assets\Script(array(
                    'handle'        => $asset['handle'],
                    'url'           => $asset['url'],
                    'version'       => AMARKAL_VERSION,
                    'facing'        => $asset['facing'],
                    'dependencies'  => $asset['dependencies'],
                    'footer'        => true
                ))    
            );
        };
        foreach ( self::$config['js']['enqueue'] as $handle ) {
            $ac->register_asset(
                new Assets\Script(array(
                    'handle'    => $handle,
                    'facing'    => array( 'admin' ),
                    'footer'    => true
                ))    
            );
        };
        $ac->enqueue();
    }
}
Autoloader::init();
