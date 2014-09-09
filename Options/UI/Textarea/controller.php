<?php

namespace Amarkal\Options\UI;

/**
 * Implements a Textarea.
 * 
 * Usage Example:
 * 
 * $field = new Text(array(
 *		'name'			=> 'textfield_1',
 *		'label'			=> 'Title',
 *		'default'		=> 'Enter your title here',
 *		'disabled'		=> false,
 *		'filter'		=> function( $v ) { return trim( strip_tags( $v ) ); },
 *		'validation'	=> function( $v ) { return strlen($v) <= 25; },
 * 		'error_message' => 'Error: the title must be less than 25 characters',
 *		'description'	=> 'This is the title'
 * ));
 */
class Textarea
extends \Amarkal\Options\AbstractField
implements \Amarkal\Options\ValueFieldInterface,
           \Amarkal\Options\DisableableFieldInterface,
           \Amarkal\Options\FilterableFieldInterface,
           \Amarkal\Options\ValidatableFieldInterface
{
    public function default_settings() {
        return array(
            'name'          => '',
            'title'			=> '',
            'disabled'      => false,
            'default'		=> '',
            'help'			=> null,
            'description'	=> '',
            'filter'		=> function( $v ) { return $v; },
            'validation'	=> function( $v ) { return true; },
            'error_message'	=> 'This field is invalid'
        );
    }
    
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
    public function is_disabled() {
        return $this->config['disabled'];
    }

    /**
	 * {@inheritdoc}
	 */
	public function apply_filter( $value ) {

		$callable = $this->config['filter'];

		if( is_callable( $callable ) ) {
			return $callable( $value );
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
    public function set_validity( $validity ) {
        $this->validity = $validity;
        $this->template->invalid = ( $validity == self::INVALID );
    }

}