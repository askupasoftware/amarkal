<?php

namespace Amarkal\UI\Components;

/**
 * Implements a component able to run a function.
 * 
 * Parameters:
 * <ul>
 * <li><b>name</b> <i>string</i> The component's name.</li>
 * <li><b>label</b> <i>string</i> The button's label.</li>
 * <li><b>disabled</b> <i>boolean</i> True to disabled component. False otherwise.</li>
 * <li><b>callback</b> <i>function</i> The callback function.</li>
 * <li><b>hook</b> <i>string</i> The hook to which the callback function will be attached.</li>
 * </ul>
 * 
 * Usage Example:
 * <pre>
 * $field = new Process(array(
 *      'name'          => 'process_1',
 *      'label'         => 'My Button',
 *      'disabled'      => false,
 *      'callback'      => function() {}
 *      'hook'          => 'afw_options_pre_process'
 * ));
 * </pre>
 */
class Process
extends \Amarkal\UI\AbstractComponent
implements \Amarkal\UI\DisableableComponentInterface
{
    public function __construct( $model )
    {
        parent::__construct( $model );
        
        $callable = $this->model['callback'];
        
        if( is_callable( $callable ) && isset( $_POST[$this->name] ) )
        {
            add_action($this->model['hook'],$callable,4);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function default_model()
    {
        return array(
            'name'          => '',
            'label'         => '',
            'disabled'      => false,
            'callback'      => function(){},
            'hook'          => 'afw_options_init'
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function required_parameters()
    {
        return array('name');
    }

    /**
     * {@inheritdoc}
     */
    public function is_disabled()
    {
        return $this->model['disabled'];
    }
}