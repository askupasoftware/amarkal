<?php

namespace Amarkal\Extensions\WordPress\Widget\UI;

/**
 * Implements a date picker component.
 * 
 * Template file: Template/DatePicker.php
 * 
 * Usage Example:
 * 
 * $component = new DatePicker(array(
 *		'name'			=> 'datepicker_1',
 *		'label'			=> 'Date Picker',
 *		'default'		=> '00/00/00',
 *		'disabled'		=> false,
 *		'description'	=> 'Some descriptive text...',
 *		'help'			=> 'Some helpful text...'
 * ));
 */
class DatePicker
extends \Amarkal\Extensions\WordPress\Widget\AbstractComponent
implements \Amarkal\Extensions\WordPress\Widget\DisableableComponentInterface
{
	
	/**
	 * {@inheritdoc}
	 */
	public function default_settings() {
		return array(
			'name'			=> 'datepicker',
			'label'			=> 'Date Picker',
			'default'		=> '00/00/00',
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

