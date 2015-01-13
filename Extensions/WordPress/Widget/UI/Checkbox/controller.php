<?php

namespace Amarkal\Extensions\WordPress\Widget\UI;

/**
 * Implements a checkbox component.
 * 
 * Template file: Template/Checkbox.php
 * 
 * Usage Example:
 * 
 * $component = new Textfield(array(
 *		'name'			=> 'textfield_1',
 *		'label'			=> 'Title',
 *		'default'		=> 'off',
 *		'disabled'		=> false,
 *		'description'	=> 'This is the widget's title'
 * ));
 */
class Checkbox 
extends \Amarkal\Extensions\WordPress\Widget\AbstractComponent
implements  \Amarkal\Extensions\WordPress\Widget\DisableableComponentInterface
{
	
	/**
	 * {@inheritdoc}
	 */
	public function default_settings() {
		return array(
			'name'			=> 'checkbox',
			'label'			=> 'Check Box',
			'default'		=> 'off',		// Either 'on' or 'off'
			'disabled'		=> false,
			'description'	=> NULL,
			'help'			=> NULL
		);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function required_settings() {
		return array('name');
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return $this->config['default'];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function get_name() {
		return $this->config['name'];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function set_value( $value ) {
		$this->template->value = $value;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function set_id_attribute( $id ) {
		$this->template->id = $id;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function set_name_attribute( $name ) {
		$this->template->name = $name;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function is_disabled() {
		return $this->config['disabled'];
	}
}
