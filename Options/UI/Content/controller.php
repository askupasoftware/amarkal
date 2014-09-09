<?php

namespace Amarkal\Options\UI;

/**
 * Implements a content holder for.
 * 
 * User this special field to display static content inside the options page.
 * 
 * Usage Example:
 * 
 * $field = new Text(array(
 *		'title'			=> 'Title',
 *		'description'	=> 'This is the title',
 *      'help'			=> 'Some helpful text',
 *      'template'      => 'path-to-file'
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
            'template'      => null,
            'full_width'    => false
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