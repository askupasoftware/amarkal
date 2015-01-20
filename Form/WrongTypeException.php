<?php

namespace Amarkal\Form;

class WrongTypeException extends \RuntimeException 
{
    public function __construct( $type ) 
    {
        $call_stack = debug_backtrace();
        $file = $call_stack[2]['file'];
        $line = $call_stack[2]['line'];
        parent::__construct( "Form component must be of type \Amarkal\UI\AbstractComponent, $type given in $file line $line" );
    }
}
