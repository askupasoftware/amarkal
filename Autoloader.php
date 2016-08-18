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
     * Initiate the autoloader
     */
    public static function init()
    {
        Autoloader::register_classes();
        \add_action( 'admin_enqueue_scripts', array( __CLASS__, 'register_assets' ) );
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
    static function register_assets() 
    {    
        \wp_enqueue_script( 'jquery' );
        \wp_enqueue_script( 'jquery-ui' );
        \wp_enqueue_script( 'jquery-ui-datepicker' );
        \wp_enqueue_script( 'jquery-ui-spinner' );
        \wp_enqueue_script( 'jquery-ui-slider' );
        \wp_enqueue_script( 'jquery-ui-resizable' );
        \wp_enqueue_script( 'wp-color-picker' );
        
        \wp_enqueue_script( 'amarkal', AMARKAL_ASSETS_URL.'js/amarkal.min.js', array('jquery'), AMARKAL_VERSION, true );
        \wp_enqueue_script( 'select2', AMARKAL_ASSETS_URL.'js/select2.min.js', array('jquery'), '3.5.1', true );
        \wp_enqueue_script( 'ace-editor', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.5/ace.js', array(), '1.2.5', true );
        
        \wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', array(), '4.6.3' );
        \wp_enqueue_style( 'amarkal', AMARKAL_ASSETS_URL.'css/amarkal.min.css', array('wp-color-picker'), AMARKAL_VERSION );
        \wp_enqueue_style( 'select2', AMARKAL_ASSETS_URL.'css/select2.min.css', array(), '3.5.1' );
    }
}
Autoloader::init();
