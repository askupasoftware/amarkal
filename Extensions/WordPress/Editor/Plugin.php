<?php

namespace Amarkal\Extensions\WordPress\Editor;

/**
 * Defines an editor plugin
 * Used as the parent class to all Editor\Editor plugins.
 */
class Plugin
{
    private $config;
    
    /**
     * Create a new editor plugin.
     * 
     * @param array $config
     * <ul>
     * <li><b>slug</b> <i>string</i> The plugin's slug, must be unique.</li>
     * <li><b>row</b> <i>number</i> The row to which the button will be added.</li>
     * <li><b>script</b> <i>string</i> A url to the plugin's script.</li>
     * <li><b>callback</b> <i>AbstractCallback|array</i> The callback or an array of callbacks to use for the popup once the button is clicked. If an array is used, the action of each callback is the plugin's slug + the array index: slug_{index}</li>
     * </ul>
     */
    public function __construct( array $config )
    {
        $this->config = $config;
    }

    /**
     * Register the plugin to the TinyMCE plugin registry and add a form callback
     * or callbacks.
     */
    public function register() 
    {
        add_action( 'admin_head', array( $this, 'add_filters' ) );
        add_action( 'wp_head', array( $this, 'add_filters' ) );
        
        if( is_array( $this->config['callback'] ) )
        {
            foreach( $this->config['callback'] as $handle => $callback )
            {
                $callback->register( $this->config['slug'].'_'.$handle );
            }
        }
        else
        {
            $this->config['callback']->register( $this->config['slug'] );
        }
    }
    
    /**
     * Add a button to the tinyMCE editor, if the user has the required settings.
     */
    public function add_filters()
    {
        // check if WYSIWYG is enabled 
        if ( get_user_option('rich_editing') )
        {
            add_filter( 'mce_external_plugins', array( $this, 'register_plugin' ) ); 
            add_filter( 'mce_buttons'.($this->config['row'] > 1 ? '_'.$this->config['row'] : ''), array( $this, 'register_button' ) ); 
        }
    }
    
    /**
     * Register the plugin's script.
     * 
     * @param array $plugin_array
     * @return type
     */
    public function register_plugin( $plugin_array )
    {
        $plugin_array[$this->config['slug']] = $this->config['script'];
        return $plugin_array;
    }

    /**
     * Add a new button to TinyMCE
     * @param type $buttons
     * @return type
     */
    public function register_button( $buttons ) 
    { 
        array_push( $buttons, $this->config['slug'] );
        return $buttons;
    }
}
