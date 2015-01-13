<?php

namespace Amarkal\Extensions\WordPress\Options;

/**
 * Describes a field with a validatable value.
 * 
 * This interface is applicable for field that allow free user input,
 * such as textfields and textareas.
 */
interface ValidatableFieldInterface extends ValueFieldInterface {
	
    /**
     * Field state after validation.
     * @see self::set_validity()
     */
    const INVALID   = 'invalid';
    const VALID     = 'valid';
    
	/**
	 * Validate the field's value.
	 * 
	 * This function is called when the widget's "save" button is clicked. It
	 * calls the user-defined function under 'validation' to validate the value.
	 * If the value is invalid, the function should return FALSE and the database
	 * will not be updated with the new value. This will tell the field 
	 * renderer to render that field as erroneuos.
	 * 
	 * @see self::render() to see how a field is rendered with or without a
	 *					   validation error.
	 * @see Amarkal\Widget\AbstractWidget::update() to see how errors
	 *		are passed between saves.
	 * 
	 * @param	mixed $value	The field's (input) value.
	 * @return	boolean			True/false if the value is valid.
	 */
	public function validate( $value );
	
    /**
     * Set the validity of the field after validation to one of self::VALID,
     * self:INVALID
     * 
     * @param string $validity
     */
    public function set_validity( $validity );
}