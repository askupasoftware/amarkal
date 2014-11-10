<?php

namespace Amarkal\Options;

/**
 * Describes an options page UI field instance.
 * 
 * Each UI field MUST be renderable by the options page that is containing
 * that field.
 * 
 * Each UI field MAY have a default value that will be used for the first time
 * that the widget is activated.
 */
interface FieldInterface {
	
	/**
	 * Get the list of default settings for this field.
	 * 
	 * This function MUST be over-riden by the child class.
	 * 
	 * @return array The list of default field settings
	 */
	public function default_settings();
	
	/**
	 * Get the names of the required setting keys.
	 * 
	 * Returns an array of setting keys that the user must provide when
	 * instantiating the field. 
	 * 
	 * @return array The required settings.
	 */
	public function required_settings();
	
	/**
	 * Render the UI component.
	 * 
	 * @return string The rendered component.
	 */
	public function render();
	
	/**
	 * Get the path to the template file.
	 * 
	 * @return string The template's path.
	 */
	static function get_script_path();
}