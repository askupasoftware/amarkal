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
     * Add the following code to the plugin's bootstrap file
     * <pre>
     * function my_plugin_bootstrap()
     * {
     *     $validator = require_once 'vendor/askupa-software/amarkal-framework/EnvironmentValidator.php';
     *     $validator->add_plugin( 'MyPluginName', dirname( __FILE__ ).'/app/MyPlugin.php' );
     * }
     * my_plugin_bootstrap();
     * </pre>
     * <b> Example Usage (for themes): </b><br/>
     * ---------------------------
     * Add the following code to the theme's functions.php file.
     * <pre>
     * $validator = require_once dirname( __FILE__ ) . '/vendor/askupa-software/amarkal-framework/EnvironmentValidator.php';
     * $validator->set_theme( 'Theme Name', dirname( __FILE__ ).'/path/to/MainFile.php' );
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
        static $plugins = array();
        
        /**
         * Contains the name and path of the theme, if applicable.
         * 
         * @see EnvironmentValidator::set_theme()
         * @var type 
         */
        static $theme;
        
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
            // Set the autoloader path and the package if null, or compare the current version with the new version if not null
            if( null == self::$package || version_compare( self::$package->version, $package->version, '<' ))
            {
                self::$autoloader = $path.'/Autoloader.php';
                self::$package = $package;
            }
            $this->set_activation_hook();
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
            self::$plugins[] = array(
                'name'      => $name,
                'path'      => $path
            );
        }
        
        /**
         * Register a theme to be activated after the environment
         * has been validated.
         * 
         * @param type $name
         * @param type $path
         */
        public function set_theme( $name, $path )
        {
            self::$theme = array(
                'name'  => $name,
                'path'  => $path
            );
        }
        
        /**
         * Add an action to the plugins_loaded hook to activate plugins after
         * the environment has been validated.
         */
        public function set_activation_hook()
        {
            if( null == self::$activated )
            {
                add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ));
                
                // Only hook once
                self::$activated = true;
            }
        }
        
        /**
         * This function is called after the after_setup_theme hook has been
         * fired. It validates the PHP version, initiates the Amarkal autoloader
         * and activates all the plugins that has been registered by 
         * EnvironmentValidator::add_plugin. If the PHP version is below the required
         * version, an error message will be printed and the process will be aborted
         * without breaking the application.
         */
        function after_setup_theme()
        {
            // Invalid environment, display admin notification
            if ( version_compare( self::$package->php, phpversion(), '>' ) )
            {
                add_action( 'admin_notices', array( __CLASS__, 'print_message' ) );
                return;
            }
            
            // Initiate the autoloader and activate all plugins.
            self::generate_defines();
            require_once self::$autoloader;

            foreach( self::$plugins as $plugin )
            {
                require_once $plugin['path'];
            }
            
            if( null != self::$theme )
            {
                require_once self::$theme['path'];
            }
        }
        
        /**
         * Generate global defines using package.json
         */
        static function generate_defines()
        {
            $afw_url = self::get_framework_url();
            define( 'AMARKAL_VERSION' , self::$package->version );
            define( 'AMARKAL_DIR' , dirname( self::$autoloader ) );
            define( 'AMARKAL_URL' , $afw_url );
            define( 'AMARKAL_ASSETS_URL' , $afw_url.'Assets/' );
        }
        
        /**
         * Get the url to the Amarkal Framework root directory.
         * This function is able to determine whether this is a plugin or a
         * theme, and return the appropriate url.
         * 
         * @return type
         */
        static function get_framework_url()
        {
            // Theme relative url
            $path = dirname( self::$autoloader );
            $str = 'wp-content/themes';
            $pos = strpos( $path, $str );
            
            if( $pos !== false )
            {
                return substr( get_template_directory_uri(), 0, strpos( get_template_directory_uri(), $str ) ).substr($path, $pos).'/';
            }
            // Plugin relative url
            return \plugin_dir_url( self::$autoloader );
        }
        
        /**
         * Echo the error message.
         */
        static function print_message()
        {
            $message = __(
                '<strong>Amarkal Framework has detected an error:</strong><br/>The %s <strong>%s</strong> requires PHP %s or newer to run (currently installed version: %s). Please upgrade your PHP version.',
                'amarkal'
            );
            // Render error messages for plugins
            foreach( self::$plugins as $plugin )
            {
                echo self::render_message( sprintf(
                    $message,
                    'plugin',
                    $plugin['name'],
                    self::$package->php,
                    phpversion() 
                ), 
                'error' );
            }
            // Render error message for theme
            if( null != self::$theme )
            {
                echo self::render_message( sprintf(
                    $message,
                    'theme',
                    self::$theme['name'],
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
        static function render_message( $message, $type = 'updated' ) 
        {
            return '<div class="'.$type.'"><p>'.$message.'</p></div>';
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
