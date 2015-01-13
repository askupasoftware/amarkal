<?php

namespace Amarkal\Extensions\WordPress\Options\UI;

/**
 * Implements a two state switch.
 * 
 * Usage Example:
 * 
 * $field = new Text(array(
 *		'name'			=> 'textfield_1',
 *		'title'			=> 'Title',
 *		'default'		=> 'Enter your title here',
 *		'disabled'		=> false,
 *		'description'	=> 'This is the title',
 *      'help'			=> 'Some helpful text',
 *      'labels'        => array('On','Off')
 * ));
 */
class Switcher
extends \Amarkal\Extensions\WordPress\Options\AbstractField
implements \Amarkal\Extensions\WordPress\Options\ValueFieldInterface,
           \Amarkal\Extensions\WordPress\Options\DisableableFieldInterface
{
    public function default_settings() {
        return array(
            'name'          => '',
            'title'			=> '',
            'disabled'      => false,
            'default'		=> '',
            'help'			=> null,
            'description'	=> '',
            'labels'        => array('ON','OFF'),
            'multivalue'    => false
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
}