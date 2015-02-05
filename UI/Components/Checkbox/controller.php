<?php

namespace Amarkal\UI\Components;

/**
 * Implements a Checkbox UI component.
 * 
 * Parameters:
 * <ul>
 * <li><b>name</b> <i>string</i> The component's name.</li>
 * <li><b>default</b> <i>string</i> Comma seperated list of values that will be checked by default.</li>
 * <li><b>disabled</b> <i>boolean</i> True to disabled component. False otherwise.</li>
 * <li><b>options</b> <i>array</i> List of available options as value => label or just values.</li>
 * </ul>
 * 
 * Usage Example:
 * <pre>
 * $field = new Checkbox(array(
 *        'name'          => 'my_checkbox',
 *        'disabled'      => false,
 *        'default'       => 'val1',
 *        'options'       => array(
 *             'val1'   => 'Label1',
 *             'val2'   => 'Label2'
 *        )
 * ));
 * </pre>
 */
class Checkbox
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
            'options'       => array(),
        );
    }
    
    public function required_parameters()
    {
        return array('name','options');
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