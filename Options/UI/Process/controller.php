<?php

namespace Amarkal\Options\UI;

/**
 * Implements a field that is able to run a function.
 * 
 * Usage Example:
 * 
 * $field = new Text(array(
 *      'name'          => 'process_1',
 *      'title'         => 'Title',
 *      'label'         => 'My Button',
 *      'disabled'      => false,
 *      'help'          => 'Some helpful text',
 *      'description'   => 'This is the title',
 *      'callback'      => function() {}
 *      'hook'          => 'ao_preprocess'
 * ));
 */
class Process
extends \Amarkal\Options\AbstractField
implements \Amarkal\Options\DisableableFieldInterface
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
    
    public function default_settings()
    {
        return array(
            'name'          => '',
            'title'            => '',
            'label'         => '',
            'disabled'        => false,
            'help'            => null,
            'description'    => '',
            'callback'      => function(){},
            'hook'          => 'ao_init'
        );
    }
    
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