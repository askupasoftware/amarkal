<?php

namespace Amarkal\UI\Components;

/**
 * Implements a slider UI component.
 * 
 * This slider supports 4 kinds of slide types: single, min, max, range.
 * If you choose a range type slider, the default value you provide MUST be
 * an array of 2 values, the first of which is less than the second value.
 * 
 * Usage Example:
 * 
 * // Single value
 * $field = new Text(array(
 *      'name'          => 'slider_1',
 *      'default'       => 50,
 *      'min'           => 0,
 *      'max'           => 100,
 *      'step'          => 5,
 *      'disabled'      => false
 * ));
 * 
 * // Range
 * $field = new Text(array(
 *      'name'          => 'slider_1',
 *      'type'          => 'range',
 *      'default'       => array( 25, 75 ),
 *      'min'           => 0,
 *      'max'           => 100,
 *      'step'          => 5,
 *      'disabled'      => false
 * ));
 */
class Slider
extends \Amarkal\UI\AbstractComponent
implements \Amarkal\UI\ValueComponentInterface,
           \Amarkal\UI\DisableableComponentInterface,
           \Amarkal\UI\ValidatableComponentInterface
{
    public function default_settings()
    {
        return array(
            'name'          => '',
            'disabled'      => false,
            'default'       => 0, // Or array(0,0) if range
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
        $this->value = $value;
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
    public function validate( $value, &$error )
    {
        $error = 'Invalid slider range for '.$this->get_name();
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
    }
}