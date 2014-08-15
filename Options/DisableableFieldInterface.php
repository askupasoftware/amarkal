<?php

namespace Amarkal\Options;

/**
 * Describes a field that is capabale of being disabled.
 * 
 * This interface is applicable for any field that allows user input.
 */
interface DisableableFieldInterface extends ValueFieldInterface {
	
	/**
	 * Check if the field has been disabled.
	 * 
	 * @return boolean True/false if the field is disabled.
	 */
	public function is_disabled();
}