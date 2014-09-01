<?php

namespace Amarkal\Options\UI;

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
class Spinner
extends \Amarkal\Options\AbstractField
implements \Amarkal\Options\ValueFieldInterface,
           \Amarkal\Options\DisableableFieldInterface
{
    public function default_settings() {
        return array(
            'name'          => '',
            'title'			=> '',
            'disabled'      => false,
            'default'		=> '',
            'help'			=> null,
            'description'	=> '',
            'minvalue'      => null,
            'maxvalue'      => null,
            'step'          => 1
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