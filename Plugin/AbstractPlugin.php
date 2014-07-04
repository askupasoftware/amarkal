<?php

namespace Amarkal\Plugin;

abstract class AbstractPlugin {
	
	private $plugin_file = '';

    public $setup = NULL;
	
	public function __construct( $plugin_file, PluginSetup $setup = NULL ) {
        $this->plugin_file = $plugin_file;
        $this->setup       = $setup;
		
		$this->register_hooks();
    }
	
	private function register_hooks() {
		/**
         * Register hooks that are fired when the plugin is activated, 
		 * deactivated, and uninstalled, respectively. The array's first 
		 * argument is the name of the plugin defined in `class-plugin-name.php`
         */
		if ( ! is_null( $this->setup ) ) {
            register_activation_hook(
                $this->plugin_file,
                array ( $this->setup, 'activate' )
            );

            register_deactivation_hook(
                $this->plugin_file,
                array ( $this->setup, 'deactivate' )
            );
			
			register_uninstall_hook(
				$this->plugin_file,
                array ( $this->setup, 'uninstall' )
			);
        }
	}
}
