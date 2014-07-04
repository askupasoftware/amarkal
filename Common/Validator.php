<?php

namespace Amarkal\Common;

class Validator
{
    static function validate( $input, $type )
    {
        $func = 'validate_'.$type;
        return self::$func( $input );
    }
    
    static function validate_email( $input )
    {
        
    }
}