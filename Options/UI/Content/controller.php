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
class Content
extends \Amarkal\Options\AbstractField
{
    public function default_settings() {
        return array(
            'title'			=> '',
            'help'			=> null,
            'description'	=> '',
            'template'      => null
        );
    }
    
    public function required_settings() {
        return array('template');
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