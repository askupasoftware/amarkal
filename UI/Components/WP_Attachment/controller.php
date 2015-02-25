<?php

namespace Amarkal\UI\Components;

/**
 * Implements a WordPress attachment UI component.
 * 
 * <b>Note:</b> This field can only be used in a WordPress environment.
 */
class WPAttachment
extends \Amarkal\UI\AbstractComponent
implements \Amarkal\UI\ValueComponentInterface,
           \Amarkal\UI\DisableableComponentInterface
{
    /**
     * Create a new attachment UI component.
     * 
     * @param array $model
     * <ul>
     * <li><b>name</b> <i>string</i> The component's name.</li>
     * <li><b>default</b> <i>string</i> Comma seperated list of values that will be checked by default.</li>
     * <li><b>disabled</b> <i>boolean</i> True to disabled component. False otherwise.</li>
     * <li><b>multiple</b> <i>boolean</i> True to allow multiple attachments.</li>
     * </ul>
     * 
     * <b>Usage Example:</b>
     * <pre>
     * $field = new Checkbox(array(
     *        'name'          => 'my_checkbox',
     *        'disabled'      => false,
     *        'default'       => 'val1',
     *        'multiple'      => false
     * ));
     * </pre>
     */
    public function __construct( array $model ) 
    {
        parent::__construct( $model );
    }
    
    public function default_model() 
    {
        return array(
            'name'          => '',
            'disabled'      => false,
            'default'       => '',
            'multiple'      => false,
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