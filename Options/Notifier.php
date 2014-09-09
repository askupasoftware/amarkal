<?php

namespace Amarkal\Options;

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
        $template = new \Amarkal\Template\Template(dirname( __FILE__ ).'/Notifier.phtml', array(
            'type'      => $type,
            'message'   => $message
        ));
        add_action( 'ao_notices', function() use ($template) { echo $template->render(); } );
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
