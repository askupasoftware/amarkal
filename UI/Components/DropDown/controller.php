<?php

namespace Amarkal\UI\Components;

/**
 * Implements a dropdown (select2) UI component.
 * 
 * Parameters:
 * <ul>
 * <li><b>name</b> <i>string</i> The component's name.</li>
 * <li><b>default</b> <i>string</i> The component's default value.</li>
 * <li><b>disabled</b> <i>boolean</i> True to disabled component. False otherwise.</li>
 * <li><b>options</b> <i>array</i> A list of choices, either associative or not.</li>
 * </ul>
 * 
 * Usage Example:
 * <pre>
 * $field = new DropDown(array(
 *        'name'            => 'textfield_1',
 *        'default'         => 'Enter your title here',
 *        'disabled'        => false,
 *        'options'         => array(
 *            'key1'    => 'value1',
 *            'key2'    => 'value2'
 *        )
 * ));
 * </pre>
 */
class DropDown
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
            'options'       => array()
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