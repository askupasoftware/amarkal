<?php

namespace Amarkal\UI\Components;

/**
 * Implements a spinner UI component.
 * 
 * Parameters:
 * <ul>
 * <li><b>name</b> <i>string</i> The component's name.</li>
 * <li><b>default</b> <i>number</i> The component's default value.</li>
 * <li><b>disabled</b> <i>boolean</i> True to disabled component. False otherwise.</li>
 * <li><b>min</b> <i>number</i> The minimum value.</li>
 * <li><b>max</b> <i>number</i> The maximum value.</li>
 * <li><b>step</b> <i>number</i> The step value.</li>
 * </ul>
 * 
 * Usage Example:
 * <pre>
 * $field = new Spinner(array(
 *        'name'          => '',
 *        'disabled'      => false,
 *        'default'       => '',
 *        'min'           => null,
 *        'max'           => null,
 *        'step'          => 1
 * ));
 * </pre>
 */
class Spinner
extends \Amarkal\UI\AbstractComponent
implements \Amarkal\UI\ValueComponentInterface,
           \Amarkal\UI\DisableableComponentInterface
{
    public function default_model() {
        return array(
            'name'          => '',
            'disabled'      => false,
            'default'       => '',
            'min'           => null,
            'max'           => null,
            'step'          => 1
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