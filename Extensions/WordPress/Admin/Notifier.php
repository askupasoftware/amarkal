<?php

namespace Amarkal\Extensions\WordPress\Admin;

/**
 * Implements an admin notifier.
 * 
 * Use this class to print admin notices. If the $page parameter is specified,
 * the notification will only be printed on that page. Otherwise, the notification
 * will be printed in all admin pages.
 * 
 * Example usage:
 * 
 * \Amarkal\Admin\Notifier::error( 'Oh, dear...' );
 * \Amarkal\Admin\Notifier::notify( 'Oh, dear...', Notifier::ERROR );
 * \Amarkal\Admin\Notifier::notify( 'Oh, dear...', Notifier::SUCCESS, 'plugins.php' );
 * 
 * Available notice types: error, success.
 */
class Notifier
{
    
    /**
     * Notification types.
     */
    const ERROR     = 'error';
    const SUCCESS   = 'updated';
    
    /**
     * Register an admin notification.
     * 
     * @global  string $pagenow The current admin page.
     * @param   string $message The message to print.
     * @param   string $type    The type of notification [self::ERROR|self::SUCCESS].
     * @param   string $page    (optional) A specific admin page in which the
     *                          notification should appear. If no page is specified
     *                          the message will be visible in all admin pages.
     */
    static function notify( $message, $type, $page = null )
    {
        global $pagenow;
        if( ( null != $page && $page == $pagenow ) || 
              null == $page)
        {
            add_action( 'admin_notices', create_function( '',"echo '<div class=\"".$type."\"><p>".$message."</p></div>';" ) );
        }
    }
    
    /**
     * 
     * @param   string $message The message to print.
     * @param   string $page    (optional) A specific admin page in which the
     *                          notification should appear. If no page is specified
     *                          the message will be visible in all admin pages.
     */
    static function error( $message, $page = null )
    {
        Notifier::notify( $message, Notifier::ERROR, $page );
    }
    
    /**
     * 
     * @param   string $message The message to print.
     * @param   string $page    (optional) A specific admin page in which the
     *                          notification should appear. If no page is specified
     *                          the message will be visible in all admin pages.
     */
    static function success( $message, $page = null )
    {
        Notifier::notify( $message, Notifier::SUCCESS, $page );
    }
}