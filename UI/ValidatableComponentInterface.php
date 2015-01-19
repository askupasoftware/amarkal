<?php

namespace Amarkal\UI;

/**
 * Describes a component with a validatable value.
 * 
 * This interface is applicable for component that allow free user input,
 * such as textfields and textareas.
 */
interface ValidatableComponentInterface extends ValueComponentInterface {

    /**
     * Component state after validation.
     * @see self::set_validity()
     */
    const INVALID   = 'invalid';
    const VALID     = 'valid';
    
    /**
     * Validate the component's value.
     * 
     * This function is called when the component is updated by the Updater. It
     * calls the user-defined function under 'validation' to validate the value.
     * If the value is invalid, the function should return FALSE and the component's 
     * value will not be updated with the new value.
     * 
     * @see Amarkal\Form\Updater
     * 
     * @param mixed $value The component's value.
     * @param string $error The error message
     * @return boolean True/false if the value is valid.
     */
    public function validate( $value, &$error );

    /**
     * Set the validity of the component after validation to 
     * one of [self::VALID|self:INVALID]
     * 
     * @param [self::VALID|self:INVALID] $validity
     */
    public function set_validity( $validity );
}