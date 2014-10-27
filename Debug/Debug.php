<?php

namespace Amarkal\Debug;

class Debug 
{
    static function print_array( array $arr = array() ) 
    {
        self::print_object($arr);
    }
    
    static function print_object( $obj ) 
    {
        echo '<pre dir="ltr">', print_r($obj, TRUE), '</pre>';
    }
    
    static function display_php_errors()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }
    
    static function hide_php_errors()
    {
        error_reporting(0);
        ini_set('display_errors',0);
    }
}
