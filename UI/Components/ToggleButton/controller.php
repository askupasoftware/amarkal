<?php

namespace Amarkal\UI\Components;

/**
 * Implements a toggle button UI component.
 * 
 * Parameters:
 * <ul>
 * <li><b>name</b> <i>string</i> The component's name.</li>
 * <li><b>default</b> <i>number|number[]</i> The component's default value.</li>
 * <li><b>disabled</b> <i>boolean</i> True to disabled component. False otherwise.</li>
 * <li><b>labels</b> <i>array</i> List of labesl, also used as the values. Can be either associative or regular array.</li>
 * <li><b>multivalue</b> <i>boolean</i> Set to true to allow multiple values to be selected.</li>

 * </ul>
 * 
 * Usage Example:
 * <pre>
 * $field = new ToggleButton(array(
 *        'name'          => 'my_toggle',
 *        'disabled'      => false,
 *        'default'       => '',
 *        'labels'        => array('ON','OFF'),
 *        'multivalue'    => false
 * ));
 * </pre>
 */
class ToggleButton
extends \Amarkal\UI\AbstractComponent
implements \Amarkal\UI\ValueComponentInterface,
           \Amarkal\UI\DisableableComponentInterface
{
    public function default_model() 
    {
        return array(
            'name'          => '',
            'disabled'      => false,
            'default'       => '',
            'labels'        => array('ON','OFF'),
            'multivalue'    => false
        );
    }
    
    public function required_parameters()
    {
        return array('name');
    }

    /**
     * {@inheritdoc}
     */
    public function get_default_value() 
    {
        return $this->model['default'];
    }

    /**
     * {@inheritdoc}
     */
    public function get_name()
    {
        return $this->model['name'];
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
        return $this->model['disabled'];
    }
}