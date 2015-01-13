<?php

namespace Amarkal\Extensions\WordPress\Widget;

/**
 * Describes a component that can hold a value.
 * 
 * Value components include all input components, such as textfields, textareas,
 * radio buttons etc... as opposed to non-value components such as seperators.
 */
interface ValueComponentInterface {
    
    /**
     * Get the component's default value.
     * 
     * @return mixed    The default value
     */
    public function get_default_value();
    
    /**
     * Get the component's name.
     * 
     * This is used updating/retrieving the component's value to/from the database.
     * @return string    The component's name.
     */
    public function get_name();
    
    /**
     * Set the component's value.
     * 
     * @param mixed $value    The value to set.
     */
    public function set_value( $value );
    
    /**
     * Set the component's id attribute.
     * 
     * Called by the widget's form() function to set the appropriate id.
     * 
     * @see Amarkal\Extensions\WordPress\Widget\AbstractWidget::form() 
     *
     * @param string $id The id to set
     */
    public function set_id_attribute( $id );
    
    /**
     * Set the component's name attribute.
     * 
     * Called by the widget's form() function to set the appropriate name.
     * 
     * @see Amarkal\Extensions\WordPress\Widget\AbstractWidget::form()
     * 
     * @param string $name    The name to set.
     */
    public function set_name_attribute( $name );
    
}
