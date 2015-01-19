<?php

namespace Amarkal\UI\Components;

/**
 * Implements a spinner UI component.
 * 
 * Usage Example:
 * 
 * $field = new Spinner(array(
 *        'name'          => '',
 *        'disabled'      => false,
 *        'default'       => '',
 *        'min'           => null,
 *        'max'           => null,
 *        'step'          => 1
 * ));
 */
class Spinner
extends \Amarkal\UI\AbstractComponent
implements \Amarkal\UI\ValueComponentInterface,
           \Amarkal\UI\DisableableComponentInterface
{
    public function default_settings() {
        return array(
            'name'          => '',
            'disabled'      => false,
            'default'       => '',
            'min'           => null,
            'max'           => null,
            'step'          => 1
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
}