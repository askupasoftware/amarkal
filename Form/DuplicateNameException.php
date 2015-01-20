<?php

namespace Amarkal\Form;

/**
 * Thrown if two components have the same name
 */
class DuplicateNameException extends \RuntimeException 
{
    public function __construct( $name ) 
    {
        $call_stack = debug_backtrace();
        $file = $call_stack[2]['file'];
        $line = $call_stack[2]['line'];
        parent::__construct( "Form component names must be unique, duplication detected for the name \"$name\" in $file line $line");
    }
}
