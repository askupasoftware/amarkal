<?php
/**
 * No namespacing here. The PHP syntax in this file must be valid for older PHP
 * versions.
 */
if(!class_exists('EnvironmentValidator'))
{
    /**
     * Implements an environment validator for Amarkal based plugins and themes.
     * 
     * This file MUST be included by the plugin/theme to verify that the PHP 
     * environment (i.e. the PHP version) is sufficient to run Amarkal.
     * 
     * <b> Example Usage (for plugins): </b><br/>
     * ----------------------------
     * <pre>
     * // Put the following code in the main plugin file
     * function my_plugin_bootstrap()
     * {
     *     $validator = require_once 'vendor/askupa-software/amarkal-framework/EnvironmentValidator.php';
     *     $validator->add_plugin( 'MyPluginName', dirname( __FILE__ ).'/app/MyPlugin.php' );
     * }
     * my_plugin_bootstrap();
     * </pre>
     * <b> Example Usage (for themes): </b><br/>
     * ---------------------------
     * <pre>
     * // Not yet implemented
     * </pre>
     */
    class EnvironmentValidator
    {   
        /**
         * The contents of package.json, decoded to PHP.
         * 
         * @var StdCalss
         */
        static $package;
        
        /**
         * A list of plugins names and their corresponding paths.
         * 
         * @see EnvironmentValidator::on_plugins_loaded
         * @var array 
         */
        static $plugins;
        
        /**
         * An absolute path the the Amarkal autoloader.
         * 
         * @var string 
         */
        static $autoloader;
        
        /**
         * True/false if the EnvironmentValidator::on_plugins_loaded action has been hooked.
         * 
         * @var boolean|null 
         */
        static $activated;
        
        /**
         * Set the package and the path to the Amarkal autoloader.
         * If multiple instances are installed, the newest version will be used.
         * 
         * @param type $package
         * @param type $path
         */
        public function __construct( $package, $path ) 
        { 
            if( null == self::$package->version || version_compare( self::$package->version, $package->version, '<' ))
            {
                self::$autoloader = $path.'/Autoloader.php';
                self::$package = $package;
            }
            $this->register_plugins();
        }
        
        /**
         * Add a plugin to the list of plugins to be activated after the environment
         * has been validated.
         * 
         * @param type $name The plugin's name
         * @param type $path The path to the plugin's main file.
         */
        public function add_plugin( $name, $path )
        {
            if( null == self::$plugins )
            {
                self::$plugins = array();
            }
            
            self::$plugins[] = array(
                'name'      => $name,
                'path'      => $path
            );
        }
        
        /**
         * Add an action to the plugins_loaded hook to activate plugins after
         * the environment has been validated.
         */
        public function register_plugins()
        {
            if( null == self::$activated )
            {
                add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ));
                
                // Only hook once
                self::$activated = true;
            }
        }
        
        /**
         * This function is called after the plugins_loaded hook has been
         * fired. It validates the PHP version, initiates the Amarkal autoloader
         * and activates all the plugins that has been registered by 
         * EnvironmentValidator::add_plugin. If the PHP version is below the required
         * version, an error message will be printed and the process will be aborted
         * without breaking the application.
         */
        function on_plugins_loaded()
        {
            // Invalid environment, display admin notification
            if ( version_compare( self::$package->php, phpversion(), '>' ) )
            {
                add_action( 'admin_notices', array( $this, 'print_message' ) );
            }
            
            // Initiate the autoloader and activate all plugins.
            require_once self::$autoloader;
            foreach( self::$plugins as $plugin )
            {
                require_once $plugin['path'];
            }
        }
        
        /**
         * Echo the error message.
         */
        public function print_message()
        {
            foreach( self::$plugins as $plugin )
            {
                echo $this->render_message( sprintf(
                    __(
                        '<strong>Amarkal Framework has detected an error:</strong><br/>The plugin <strong>%s</strong> requires PHP %s or newer to run (currently installed version: %s). Please upgrade your PHP version.',
                        'amarkal'
                    ),
                    $plugin['name'],
                    self::$package->php,
                    phpversion() 
                ), 
                'error' );
            }
        }
        
        /**
         * Render a message to be used with the admin_notices hook.
         * 
         * @param string $message   The message text.
         * @param string $type      The message type. One of [updated|error].
         * 
         * @return string The HTML representation of the message.
         */
        public function render_message( $message, $type = 'updated' ) 
        {
            return '<div class="'.$type.'"><p>'.$message.'</p></div>';
        }
        
        /**
         * returns package.json contents decoded to PHP.
         * 
         * @return StdClass
         */
        public static function get_package()
        {
            return self::$package;
        }
    }
}

/**
 * Include the package specific to this instance of Amarkal.
 * This is added to a pool from which the newest version of Amarkal will be activated,
 * if multiple versions exists.
 */
ob_start();
include('package.json');
$package = json_decode(ob_get_clean());

// Return a new instance of EnvironmentValidator, with the package specific to this instance
return new EnvironmentValidator( $package, dirname( __FILE__ ) );
