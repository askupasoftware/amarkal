<?php

namespace Amarkal\Extensions\WordPress\Widget;

/**
 * Describes a widget UI component instance
 * 
 * Each UI component MUST be renderable by the control panel
 * that is containing that component.
 * 
 * Each UI component MAY have a default value that will be used
 * for the first time that the widget is activated.
 */
interface ComponentInterface {
    
    /**
     * Get the list of default settings for this component.
     * 
     * This function MUST be over-riden by the child class.
     * 
     * @return array The list of default component settings
     */
    public function default_settings();
    
    /**
     * Get the names of the required setting keys.
     * 
     * Returns an array of setting keys that the user must provide when
     * instantiating the component. 
     * 
     * @return array The required 
     */
    public function required_settings();
    
    /**
     * Render the UI component
     * 
     * @return    string            The rendered component.
     */
    public function render();
    
    /**
     * Get the path to the template file
     * 
     * @return string The template's path
     */
    static function get_script_path();
}
