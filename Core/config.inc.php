<?php

/**
 * Globally defined constants.
 */
$defines = array(
   'AMARKAL_VERSION'       => '0.1',
   'AMARKAL_DIR'           => plugin_dir_path( __DIR__ ),
   'AMARKAL_URL'           => plugin_dir_url( __DIR__ ),
   'AMARKAL_ASSETS_URL'    => plugin_dir_url( __DIR__ ).'Assets/'
);
foreach( $defines as $name => $value ) {
    define( $name , $value );
}

/**
 * Configuration Array.
 */
return array(
    
    'required_php_version'      => '5.3.0',
    
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
                'handle'        => 'amarkal-script',
                'url'           => AMARKAL_ASSETS_URL.'js/amarkal.min.js',
                'facing'        => 'admin',
                'dependencies'  => array('jquery','jquery-ui')
            ),
            array(
                'handle'        => 'bootstrap-tooltip',
                'url'           => AMARKAL_ASSETS_URL.'js/tooltip.min.js',
                'facing'        => 'admin',
                'dependencies'  => array('jquery')
            ),
            array(
                'handle'        => 'select2',
                'url'           => AMARKAL_ASSETS_URL.'js/select2.min.js',
                'facing'        => 'admin',
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
                'handle'    => 'amarkal-widget',
                'url'       => AMARKAL_ASSETS_URL.'css/widget.min.css',
                'facing'    => 'admin'
            ),
            array(
                'handle'    => 'font-awesome',
                'url'       => '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css',
                'facing'    => 'admin'
            ),
            array(
                'handle'    => 'bootstrap-tooltip',
                'url'       => AMARKAL_ASSETS_URL.'css/tooltip.min.css',
                'facing'    => 'admin'
            ),
            array(
                'handle'    => 'amarkal-options',
                'url'       => AMARKAL_ASSETS_URL.'css/options.min.css',
                'facing'    => 'admin'
            ),
            array(
                'handle'    => 'select2',
                'url'       => AMARKAL_ASSETS_URL.'css/select2.min.css',
                'facing'    => 'admin'
            )
        )
    )
);