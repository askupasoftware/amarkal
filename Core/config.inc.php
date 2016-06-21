<?php

/**
 * Configuration Array.
 */
return array(
    
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
            'jquery-ui-datepicker',
            'jquery-ui-spinner',
            'jquery-ui-slider',
            'jquery-ui-resizable'
        ),
        
        /**
         * Scripts that need to be registered AND enqueued.
         */
        'register'  => array(
            array(
                'handle'        => 'amarkal',
                'url'           => AMARKAL_ASSETS_URL.'js/amarkal.min.js',
                'facing'        => array('admin', 'public'),
                'dependencies'  => array('jquery','jquery-ui')
            ),
            array(
                'handle'        => 'select2',
                'url'           => AMARKAL_ASSETS_URL.'js/select2.min.js',
                'facing'        => array('admin', 'public'),
                'dependencies'  => array('jquery')
            ),
            array(
                'handle'        => 'ace-editor',
                'url'           => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js',
                'facing'        => array('admin'),
                'dependencies'  => array('jquery')
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
                'handle'    => 'font-awesome',
                'url'       => '//maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css',
                'facing'    => array( 'admin', 'public' )
            ),
            array(
                'handle'    => 'amarkal',
                'url'       => AMARKAL_ASSETS_URL.'css/amarkal.min.css',
                'facing'    => array( 'admin', 'public' )
            ),
            array(
                'handle'    => 'select2',
                'url'       => AMARKAL_ASSETS_URL.'css/select2.min.css',
                'facing'    => array( 'admin', 'public' )
            )
        )
    )
);
