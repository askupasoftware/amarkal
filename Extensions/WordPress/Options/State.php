<?php

namespace Amarkal\Extensions\WordPress\Options;

/**
 * 
 */
class State
{
    static $data;
    
    private function __construct() {}
    
    static function get( $param = null )
    {
        if( null == self::$data )
        {
            self::init();
        }
        if( null !== $param )
        {
            if( isset( self::$data->$param ) )
            {
                return self::$data->$param;
            }
            return;
        }
        return self::$data;
    }
    
    static function set( $param, $value )
    {
        if( null == self::$data )
        {
            self::init();
        }
        self::$data->$param = $value;
    }
    
    static function init()
    {
        if( isset( $_POST['state'] ) )
        {
            self::$data = \json_decode( \filter_input( INPUT_POST, 'state' ) );
        }
        else
        {
            self::$data = (object) array(
                'page'              => filter_input( INPUT_GET, 'page' ),
                'active_section'    => filter_input( INPUT_GET, 'section' ),
                'notifications'     => array()
            );
        }
    }
}
