<?php

namespace Amarkal\UI;

/**
 * Describes a field that can hold a value.
 * 
 * Value fields include all input fields, such as textfields, textareas,
 * radio buttons etc... as opposed to non-value components such as seperators
 * or plain HTML.
 */
interface ValueComponentInterface
{
    /**
     * Get the field's default value.
     * 
     * @return mixed    The default value.
     */
    public function get_default_value();
    
    /**
     * Get the field's name.
     * 
     * This is used updating/retrieving the field's value to/from the database.
     * @return string    The component's name.
     */
    public function get_name();
    
    /**
     * Set the field's value.
     * 
     * @param mixed $value    The value to set.
     */
    public function set_value( $value );
}