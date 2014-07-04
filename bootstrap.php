<?php

/**
 * Amarkal - a WordPress development framework.
 *
 * @package   Amarkal
 * @author    Askupa Software <contact@askupasoftware.com>
 * @link      http://amarkal.askupasoftware.com/
 * @copyright 2014 Askupa Software
 *
 * @wordpress-plugin
 * Plugin Name:		Amarkal
 * Plugin URI:		http://amarkal.askupasoftware.com/
 * Description:		Development framework for WordPress 
 * Version:			0.1
 * Author:			Askupa Software
 * Author URI:		http://www.askupasoftware.com
 * Text Domain:		amarkal
 * Domain Path:		/languages
 */

/**
 * Change the plugin load order so that Amarkal is the first loaded plugin.
 * 
 * This function must be hooked to the 'activated_plugin' action.
 */
function load_amarkal_first()
{
   $path = str_replace( WP_PLUGIN_DIR . '/', '', __FILE__ );
   if ( $plugins = get_option( 'active_plugins' ) )
   {
       if ( $key = array_search( $path, $plugins ) )
       {
           array_splice( $plugins, $key, 1 );
           array_unshift( $plugins, $path );
           update_option( 'active_plugins', $plugins );
       }
   }
}
add_action( 'activated_plugin', 'load_amarkal_first' );

/**
 * Amarkal bootstrap process.
 * This function, as well as this file, MUST be backward compatible for older
 * PHP versions since it may be compiled by an old PHP compiler. If the PHP
 * version is new enough, the execution will continue to the non-compatible
 * files (files with PHP syntax that requires PHP >= 5.3.0).
 */
function amarkal_bootstrap() 
{
    // Verify PHP version
    $min_php_version = '5.3.0';
    if( version_compare( phpversion(), $min_php_version, '<' ) ) 
    {
        $message = "<strong>Amarkal</strong> requires PHP version ".$min_php_version." or newer.".
                   "<br />Your system is currently running PHP version <span style=\"color:red;\">".phpversion()."</span>".
                   "<br />Some of your plugins and themes depend on <strong>Amarkal</strong>, and therfore it is highly recommended that you update your PHP version.";
        $type    = "error";
        add_action( 'admin_notices', create_function( '',"echo '<div class=\"".$type."\"><p>".$message."</p></div>';" ) );
        define( 'AMARKAL_ERROR', true ); // Needed for the environment validator
    }
    
    // Continue with Amarkal execution
    else
    {
        require_once( dirname( __FILE__ ) . '/Autoloader.php' );
        call_user_func_array( array( '\Amarkal\Autoloader', 'init' ), array() );
    }
}
add_action( 'plugins_loaded', 'amarkal_bootstrap' );
