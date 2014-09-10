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
     * This file MUST be included by the plugin/theme to verify that Amarkal is
     * installed AND activated.
     * 
     * Example Usage (for plugins):
     * ----------------------------
     * 
     * // Put the following code in the main plugin file
     * function my_plugin_bootstrap()
     * {
     *     $validator = require_once 'vendor/askupa-software/amarkal-framework/EnvironmentValidator.php';
     *     if ( !$validator->is_valid('plugin') )
     *     {
     *         return; // Stop plugin execution
     *     }
     *     // Continue plugin execution
     * }
     * add_action( 'plugins_loaded', 'my_plugin_bootstrap' );
     * 
     * Example Usage (for themes):
     * ---------------------------
     * 
     * // Put the following code at the beginning of the theme's functions.php file
     * 
     * $validator = require_once 'vendor/askupa-software/amarkal-framework/EnvironmentValidator.php';
     * if ( !$validator->is_valid() )
     * {
     *     return; // Stop theme execution
     * }
     */
    class EnvironmentValidator
    {
        /**
         * The required PHP version.
         * @var string The required PHP version. 
         */
        private $php_version = '5.3';
        
        /**
         * Used for the error message.
         * @var string Either 'plugin' or 'theme'.
         */
        private $type;
        
        /**
         * Constructor.
         */
        public function __construct() { }
        
        /**
         * Validate if the installed PHP version is sufficient.
         * 
         * @param string $type Either 'plugin' or 'theme'. Used for the notification.
         * @param string $php_version The required PHP version, if it is greater 
         *                            than Amarkal's minimum requirement.
         * 
         * @return boolean True if Amarkal can be run on this system.
         */
        public function is_valid( $type, $php_version = '' )
        {
            if( $php_version != '' && version_compare( $this->php_version, $php_version, '<' ) )
            {
                $this->php_version = $php_version;
            }
            
            $this->type = $type;
            
            // Invalid environment, display admin notification
            if ( version_compare( $this->php_version, phpversion(), '>' ) )
            {
                add_action( 'admin_notices', array( $this, 'print_message' ) );
                return false;
            }
            
            // Valid Environment, initiate Amarkal.
            if(!class_exists('\\Amarkal\\Autoloader'))
            {
                require_once 'Autoloader.php';
            }
            return true;
        }
        
        /**
         * Echo the error message.
         */
        public function print_message()
        {
            echo $this->render_message( sprintf(
                __(
                    'This %s requires PHP %s or newer to run (currently installed version: %s). please upgrade your PHP or contact your system administrator.',
                    'amarkal'
                ),
                $this->type,
                $this->php_version,
                phpversion() 
            ), 
            'error' );
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
    }
}
return new EnvironmentValidator();