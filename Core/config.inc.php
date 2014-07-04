<?php

return array(
    
    'required_php_version'      => '5.3.0',
    
    /**
     * Globally defined constants.
     */
    'defines'       => array(
        'AMARKAL_VERSION'       => '0.1',
        'AMARKAL_DIR'           => plugin_dir_path( __DIR__ ),
        'AMARKAL_URL'           => plugin_dir_url( __DIR__ ),
        'AMARKAL_ASSETS_URL'    => plugin_dir_url( __DIR__ ).'Assets/'
    ),
    
    /**
     * The list of JavaScript files to load.
     */
    'js'       => array(
        
        /**
         * Scripts that have already been registered and need to be enqueued.
         */
        'enqueue'   => array(
            'wp-color-picker',
            'jquery-ui',
            'jquery-ui-datepicker'
        ),
        
        /**
         * Scripts that need to be registered AND enqueued.
         */
        'register'  => array(
            array(
                'handle'    => 'amarkal-widget-script',
                'url'       => 'js/widget.js',
                'facing'    => 'admin'
            ),
            array(
                'handle'    => 'bootstrap-tooltip',
                'url'       => 'js/bootstrap-tooltip.js',
                'facing'    => 'admin'
            )
        )
    ),
    
    /**
     * The list of CSS files to load.
     */
    'css'    => array(
        
        /**
         * Stylesheets that have already been registered and need to be enqueued.
         */
        'enqueue'   => array(
            'wp-color-picker'
        ),
        
        /**
         * Stylesheets that need to be registered AND enqueued.
         */
        'register'  => array(
            array(
                'handle'    => 'amarkal-widget-style',
                'url'       => 'css/widget.css',
                'facing'    => 'admin'
            )
        )
    ),
    
    /**
     * Amarkal dashboard
     */
    'dashboard'     => array(
        'icon-image'    => 'svg/logo-square-white20x20.svg',
        'icon-class'    => 'amarkal-dashboard-icon'
    )
);