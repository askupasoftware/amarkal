<?php

namespace Amarkal\Extensions\WordPress\Options;

/**
 * Implements an OptionsPage notification manager.
 */
class Notifier
{
    /**
     * Notification types.
     */
    const ERROR     = 'errors'; // 'error' was causing it to show 6 times (!?)
    const SUCCESS   = 'success';
    const INFO      = 'info';
    
    /**
     * Register a notification.
     * 
     * @param   string $message The message to print.
     * @param   string $type    The type of notification [self::ERROR|self::SUCCESS|self::INFO].
     */
    static function notify( $message, $type )
    {
        $nots = State::get( 'notifications' );
        array_push( $nots, array( 'message' => $message, 'type' => $type ) );
        State::set( 'notifications', $nots );
    }
    
    static function reset()
    {
        State::set( 'notifications', array() );
    }
    
    /**
     * Register an error notification.
     * 
     * @param   string $message The message to print.
     */
    static function error( $message )
    {
        self::notify( $message, self::ERROR );
    }
    
    /**
     * Register a success notification.
     * 
     * @param   string $message The message to print.
     */
    static function success( $message )
    {
        self::notify( $message, self::SUCCESS );
    }
    
    /**
     * Register an info notification.
     * 
     * @param   string $message The message to print.
     */
    static function info( $message )
    {
        self::notify( $message, self::INFO );
    }
}
