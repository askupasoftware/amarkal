<?php

namespace Amarkal\UI\Components;

/**
 * Implements a component able to run a function.
 * 
 * Usage Example:
 * 
 * $field = new Process(array(
 *      'name'          => 'process_1',
 *      'label'         => 'My Button',
 *      'disabled'      => false,
 *      'callback'      => function() {}
 *      'hook'          => 'afw_options_pre_process'
 * ));
 */
class Process
extends \Amarkal\UI\AbstractComponent
implements \Amarkal\UI\DisableableComponentInterface
{
    public function __construct( $config )
    {
        parent::__construct( $config );
        
        $callable = $this->config['callback'];
        
        if( is_callable( $callable ) && isset( $_POST[$this->name] ) )
        {
            add_action($this->config['hook'],$callable,4);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function default_settings()
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
    public function required_settings()
    {
        return array('name');
    }

    /**
     * {@inheritdoc}
     */
    public function is_disabled()
    {
        return $this->config['disabled'];
    }
}