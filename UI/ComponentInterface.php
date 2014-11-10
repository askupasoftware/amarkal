<?php

namespace Amarkal\UI;

/**
 * Describes a widget UI component instance
 * 
 * UI components are stricktly visual interface controllers that are used to
 * create UI fields. UI components MUST be renderable by the field. A UI component
 * is a single element while a field may have multiple components.
 * 
 * UI components should not be used to get values from or set values to the UI. This
 * functionality should be accessed through the containing field.
 */
interface ComponentInterface 
{
    /**
     * Get the required component settings.
     */
    public function get_required_settings();
    
    /**
     * Get the default settings.
     */
    public function get_default_settings();
    
    /**
     * Render the UI component
     * 
     * @return    string            The rendered component.
     */
    public function render();
}
