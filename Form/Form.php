<?php

namespace Amarkal\Form;

/**
 * 
 */
class Form 
{
    private $components;
    
    private $updater;


    public function __construct( array $components = array() )
    {
        $this->set_components( $components );
        $this->updater    = new Updater( $components );
    }
    
    public function get_components()
    {
        return $this->components;
    }
    
    public function update( $old_instance )
    {
        return $this->updater->update( $old_instance );
    }
    
    public function get_errors()
    {
        return $this->updater->get_errors();
    }
    
    public function render( $echo = false )
    {
        foreach( $this->get_components() as $component )
        {
            $component->render( $echo );
        }
    }
    
    private function set_components( $components )
    {
        $names = array();
        foreach( $components as $c )
        {
            $call_stack = debug_backtrace();
            $caller = $call_stack[1];
            
            if( ! $c instanceof \Amarkal\UI\AbstractComponent )
            {
                throw new WrongTypeException( \gettype( $c ) );
            }
            
            if( !in_array( $c->get_name(), $names ) )
            {
                $names[] = $c->get_name();
            }
            else
            {
                throw new DuplicateNameException( $c->get_name() );
            }
        }
        $this->components = $components;
    }
}