<?php

namespace Amarkal\Extensions\WordPress\Widget\UI;

/**
 * Implements a multiselect component.
 * 
 * Template file: Template/MultiSelect.php
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
class MultiSelect 
extends \Amarkal\Extensions\WordPress\Widget\AbstractComponent
implements \Amarkal\Extensions\WordPress\Widget\DisableableComponentInterface
{
	
	/**
	 * {@inheritdoc}
	 */
	public function default_settings() {
		return array(
			'name'			=> 'checkbox',
			'label'			=> 'Check Box',
			'disabled'		=> false,
			'default'		=> array(), // Array of choice values
			'description'	=> NULL,
			'help'			=> NULL,
			'choices'		=> array()
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
