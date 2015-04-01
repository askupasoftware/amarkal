<?php

namespace Amarkal\Extensions\WordPress\Plugin;

/**
 * Describes a WordPress plugin.
 */
abstract class AbstractPlugin {
    
    /**
     * The path to the main plugin file inside the wp-content/plugins directory. 
     * @var string 
     */
    private $plugin_file;
    
    /**
     * Create a WordPress plugin and register activation/deactivation/uninstall 
     * hooks.
     * 
     * @param type $plugin_file Path to the main plugin file
     */
    public function __construct( $plugin_file ) 
    {
        $this->plugin_file = $plugin_file;
        $this->register_hooks();
    }
    
    /**
     * Register hooks that are fired when the plugin is activated, 
     * deactivated, and uninstalled, respectively. The array's first 
     * argument is the name of the plugin defined in `class-plugin-name.php`
     */
    private function register_hooks() 
    {
        register_activation_hook(
            $this->plugin_file,
            array ( __CLASS__, 'activate' )
        );

        register_deactivation_hook(
            $this->plugin_file,
            array ( __CLASS__, 'deactivate' )
        );

        register_uninstall_hook(
            $this->plugin_file,
            array ( __CLASS__, 'uninstall' )
        );
    }
    
    /**
     * Activation hook
     * 
     * @param type $network_wide
     * @return type
     */
    public static function activate( $network_wide ) 
    {
        if ( ! current_user_can( 'activate_plugins' ) )
        {
            return;
        }
        
        $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
        check_admin_referer( "activate-plugin_{$plugin}" );
    }
    
    /**
     * Deactivation hook
     * 
     * @param type $network_wide
     * @return type
     */
    public static function deactivate( $network_wide ) 
    {
        if ( ! current_user_can( 'activate_plugins' ) )
        {
            return;
        }
        
        $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
        check_admin_referer( "deactivate-plugin_{$plugin}" );
    }
    
    /**
     * Uninstall hook
     * 
     * @param type $network_wide
     * @return type
     */
    public static function uninstall( $network_wide )
    {
        if ( ! current_user_can( 'activate_plugins' ) )
        {
            return;
        }
        
        check_admin_referer( 'bulk-plugins' );

        // Important: Check if the file is the one
        // that was registered during the uninstall hook.
        if ( __FILE__ != WP_UNINSTALL_PLUGIN )
        {
            return;
        }
    }
}
