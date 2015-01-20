<?php

namespace Amarkal\Extensions\WordPress\Options;

/**
 * Thrown if two sections have the same title
 */
class DuplicateSectionException extends \RuntimeException 
{
    public function __construct( $title ) 
    {
        $call_stack = debug_backtrace();
        $file = $call_stack[2]['file'];
        $line = $call_stack[2]['line'];
        parent::__construct( "Section titles MUST be unique, duplication detected for the title \"$title\" in $file line $line" );
    }
}
