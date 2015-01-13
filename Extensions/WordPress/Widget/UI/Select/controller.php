<?php

namespace Amarkal\Extensions\WordPress\Widget\UI;

/**
 * Implements a select (drop-down) component.
 * 
 * Template file: Template/Select.php
 * 
 * Usage Example:
 * 
 * $component = new Select(array(
 *			'name'			=> 'select',
 *			'label'			=> 'My Select',
 *			'default'		=> 'choice_1',
 *			'disabled'		=> false,
 *			'help'			=> 'Some helpful text',
 *			'description'	=> 'Some descriptive text',
 *			'choices'		=> array(
 *				'choice_1'	=> 'Choice 1',
 *				'choice_2'	=> 'Choice 2',
 *				'choice_3'	=> 'Choice 3',
 *			)
 *	));
 */
class Select 
extends \Amarkal\Extensions\WordPress\Widget\AbstractComponent
implements \Amarkal\Extensions\WordPress\Widget\DisableableComponentInterface
{
	
	/**
	 * {@inheritdoc}
	 */
	public function default_settings() {
		return array(
			'name'			=> 'select',
			'label'			=> 'Select',
			'default'		=> 'choice_1',
			'disabled'		=> false,
			'help'			=> NULL,
			'description'	=> NULL,
			'choices'		=> array(
				'choice_1'	=> 'Choice 1',
				'choice_2'	=> 'Choice 2',
				'choice_3'	=> 'Choice 3',
			)
		);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function required_settings() {
		return array('name','choices');
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
