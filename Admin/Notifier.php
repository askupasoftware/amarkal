<?php

namespace Amarkal\Admin;

/**
 * Implements an admin notifyer.
 * 
 * Use this class to print admin notices.
 * Example usage:
 * 
 * \Amarkal\Admin\Notifier::error( 'Oh, dear...' );
 * \Amarkal\Admin\Notifier::notify( 'Oh, dear...', Notifier::ERROR );
 * 
 * Available notice types: error, success.
 */
class Notifier
{
    const ERROR     = 'error';
    const SUCCESS   = 'update';
    
    static function notify( $message, $type )
    {
        add_action( 'admin_notices', create_function( '',"echo '<div class=\"".$type."\"><p>".$message."</p></div>';" ) );
    }
    
    static function error( $message )
    {
        Notifier::notify( $message, Notifier::ERROR);
    }
    
    static function success( $message )
    {
        Notifier::notify( $message, Notifier::SUCCESS);
    }
}