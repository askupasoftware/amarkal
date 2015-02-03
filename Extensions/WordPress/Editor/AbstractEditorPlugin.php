<?php

namespace Amarkal\Extensions\WordPress\Editor;

abstract class AbstractEditorPlugin
{
    public function register() 
    {
        add_action('admin_head', array( $this, 'add_filters' ) );
        add_action('admin_head', array( $this, 'config_script' ) );
    }
    
    public function add_filters()
    {
        global $typenow; // check user permissions 
        if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) 
        { 
            return; 
        } 
        
        // verify the post type 
        if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        {
            return;
        }
        
        // check if WYSIWYG is enabled 
        if ( get_user_option('rich_editing') )
        {
            add_filter( 'mce_external_plugins', array( $this, 'register_plugin' ) ); 
            add_filter( 'mce_buttons'.($this->get_row() > 1 ? '_'.$this->get_row() : ''), array( $this, 'register_button' ) ); 
        }
    }
    
    public function register_plugin( $plugin_array )
    {
        $plugin_array[$this->get_slug()] = $this->get_script_path();
        return $plugin_array;
    }

    public function register_button( $buttons ) 
    { 
        array_push( $buttons, $this->get_slug() );
        return $buttons;
    }
    
    function config_script()
    {
        $type = $this->get_type();
        $config = json_encode($this->get_config());
        echo "<script>jQuery(document).ready(function(){Amarkal.Editor.addButton('$type', $config);});</script>";
    }
    
    public function get_script_path() 
    {
        return AMARKAL_ASSETS_URL.'js/Editor/Placeholder.js';
    }
    
    abstract public function get_config();
    abstract public function get_type();
    abstract public function get_slug();
    abstract public function get_row();
}
