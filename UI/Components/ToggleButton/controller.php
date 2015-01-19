<?php

namespace Amarkal\UI\Components;

/**
 * Implements a toggle button UI component.
 * 
 * Usage Example:
 * 
 * $field = new ToggleButton(array(
 *        'name'          => 'my_toggle',
 *        'disabled'      => false,
 *        'default'       => '',
 *        'labels'        => array('ON','OFF'),
 *        'multivalue'    => false
 * ));
 */
class ToggleButton
extends \Amarkal\UI\AbstractComponent
implements \Amarkal\UI\ValueComponentInterface,
           \Amarkal\UI\DisableableComponentInterface
{
    public function default_settings() 
    {
        return array(
            'name'          => '',
            'disabled'      => false,
            'default'       => '',
            'labels'        => array('ON','OFF'),
            'multivalue'    => false
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