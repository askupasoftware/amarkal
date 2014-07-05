<?php

namespace Amarkal\Widget;

/**
 * Describes a component with a validatable value.
 * 
 * This interface is applicable for components that allow free user input,
 * such as textfields and textareas.
 */
interface ValidatableComponentInterface extends ValueComponentInterface {
	
	/**
	 * Validate the component's value.
	 * 
	 * This function is called when the widget's "save" button is clicked. It
	 * calls the user-defined function under 'validation' to validate the value.
	 * If the value is invalid, the function should return FALSE and the database
	 * will not be updated with the new value. This will tell the component 
	 * renderer to render that field as erroneuos.
	 * 
	 * @see self::render() to see how a component is rendered with or without a
	 *					   validation error.
	 * @see Amarkal\Widget\AbstractWidget::update() to see how errors
	 *		are passed between saves.
	 * 
	 * @param	mixed $value	The component's (input) value.
	 * @return	boolean			True/false if the value is valid.
	 */
	public function validate( $value );
	
	/**
	 * Flag this field as erroneous and set the error message for it.
	 * 
	 * Tells the renderer to display an error message containing $message.
	 * 
	 * @param string $message	The message to display.
	 */
	public function set_error_message( $message );
	
	/**
	 * Get the saved error message, if one exists.
	 * 
	 * @return string The error message.
	 */
	public function get_error_message();
	
}