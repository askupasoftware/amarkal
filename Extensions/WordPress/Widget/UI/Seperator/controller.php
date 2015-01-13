<?php

namespace Amarkal\Extensions\WordPress\Widget\UI;

/**
 * Implements a horizontal seperator
 * 
 * Template file: Template/Seperator.php
 * 
 * Usage Example:
 * 
 * $component = new Seperator(array(
 *		'label'	=>	'My Label'
 * ));
 */
class Seperator extends \Amarkal\Extensions\WordPress\Widget\AbstractComponent {
	
	/**
	 * {@inheritdoc}
	 */
	public function default_settings() {
		return array(
			'label'			=> 'Seperator',
		);
	}
}