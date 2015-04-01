<?php

namespace Amarkal\Debug;

class Debug 
{
    private static $enabled = false;
    
    public static function enable()
    {
        if (static::$enabled) {
            return;
        }
        
        static::$enabled = true;
        
        error_reporting(-1);
    }
    
    public static function disable()
    {
        if (!static::$enabled) {
            return;
        }
        
        static::$enabled = false;
        
        error_reporting(0);
    }
    
    static function print_array( array $arr = array() ) 
    {
        self::print_object($arr);
    }
    
    static function print_object( $obj ) 
    {
        echo '<pre dir="ltr">', print_r($obj, TRUE), '</pre>';
    }
}
