<?php

namespace Amarkal\Extensions\WordPress\Options\UI;

/**
 * Implements a slider.
 * 
 * This slider supports 4 kinds of slide types: single, min, max, range.
 * If you choose a range type slider, the default value you provide MUST be
 * an array of 2 values, the first of which is less than the second value.
 * 
 * Usage Example:
 * 
 * // Single value
 * $field = new Text(array(
 *		'name'			=> 'slider_1',
 *		'title'			=> 'Slider',
 *		'default'		=> 50,
 *      'min'           => 0,
 *      'max'           => 100,
 *      'step'          => 5,
 *		'disabled'		=> false,
 *		'description'	=> 'This is a single value slider',
 *      'help'			=> 'Some helpful text'
 * ));
 * 
 * // Range
 * $field = new Text(array(
 *		'name'			=> 'slider_1',
 *		'title'			=> 'Slider',
 *      'type'          => 'range',
 *		'default'		=> array( 25, 75 ),
 *      'min'           => 0,
 *      'max'           => 100,
 *      'step'          => 5,
 *		'disabled'		=> false,
 *		'description'	=> 'This is a single value slider',
 *      'help'			=> 'Some helpful text'
 * ));
 */
class Slider
extends \Amarkal\Extensions\WordPress\Options\AbstractField
implements \Amarkal\Extensions\WordPress\Options\ValueFieldInterface,
           \Amarkal\Extensions\WordPress\Options\DisableableFieldInterface,
           \Amarkal\Extensions\WordPress\Options\ValidatableFieldInterface
{
    public function default_settings()
    {
        return array(
            'name'          => '',
            'title'			=> '',
            'disabled'      => false,
            'default'		=> 0, // Or array(0,0) if range
            'help'			=> null,
            'description'	=> '',
            'min'           => 0,
            'max'           => 100,
            'step'          => 1,
            'type'          => 'single' // Or [range|min|max]
        );
    }
    
    public function required_settings()
    {
        return array('name');
    }

    /**
	 * {@inheritdoc}
	 */
	public function get_default_value()
    {
		return $this->config['default'];
	}

    /**
	 * {@inheritdoc}
	 */
	public function get_name()
    {
		return $this->config['name'];
	}

    /**
	 * {@inheritdoc}
	 */
    public function set_value( $value )
    {
        $this->template->value = $value;
    }

    /**
	 * {@inheritdoc}
	 */
    public function is_disabled()
    {
        return $this->config['disabled'];
    }

    /**
	 * {@inheritdoc}
	 */
	public function validate( $value )
    {
        if( 'range' == $this->type )
        {
            return is_numeric($value[0]) && is_numeric($value[1]) && ( intval($value[0]) <= intval($value[1]) );
        }
        else
        {
            return is_numeric($value);
        }
	}

    /**
	 * {@inheritdoc}
	 */
    public function set_validity( $validity )
    {
        $this->validity = $validity;
        $this->template->invalid = ( $validity == self::INVALID );
    }
}