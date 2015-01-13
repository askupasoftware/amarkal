<?php

namespace Amarkal\Extensions\WordPress\Widget\UI;

/**
 * Implements a textarea input
 * 
 * Template file: Template/Textarea.php
 * 
 * Usage Example:
 * 
 * $component = new Textarea(array(
 *		'name'			=> 'textarea_1',
 *		'label'			=> 'Text',
 *		'default'		=> 'Enter your text here',
 *		'disabled'		=> false,
 *		'filter'		=> function( $v ) { return trim( strip_tags( $v ) ); },
 *		'validation'	=> function( $v ) { return strlen($v) <= 250; },
 * 		'error_message' => 'Error: text must be less than 250 characters',
 *		'description'	=> 'This is the widget's text'
 * ));
 */
class Textarea 
extends \Amarkal\Extensions\WordPress\Widget\AbstractComponent
implements  \Amarkal\Extensions\WordPress\Widget\ValidatableComponentInterface,
			\Amarkal\Extensions\WordPress\Widget\FilterableComponentInterface,
			\Amarkal\Extensions\WordPress\Widget\DisableableComponentInterface
{
	
	/**
	 * {@inheritdoc}
	 */
	public function default_settings() {
		return array(
			'name'			=> 'textarea',
			'label'			=> 'Text Area',
			'default'		=> 'Enter your text here',
			'disabled'		=> false,
			'filter'		=> function( $v ) { return $v; },
			'validation'	=> function( $v ) { return true; },
			'error_message' => 'Error: invalid value',
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
	public function apply_filter( &$value ) {

		$callable = $this->config['filter'];

		if( is_callable( $callable ) ) {
			$value = $callable( $value );
		}
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function validate( $value ) {
		
		$callable = $this->config['validation'];
		
		if( is_callable( $callable ) ) {
			return $callable( $value );
		}
		
		return false;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function set_error_message( $message ) {
		$this->template->error = true;
		$this->template->error_message = $message;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function get_error_message() {
		return $this->config['error_message'];
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