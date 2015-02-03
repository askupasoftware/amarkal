<?php

namespace Amarkal\Extensions\WordPress\Widget;

/**
 * Implements a configuration object to be used with Amarkal Widget.
 */
class WidgetConfig {
    
    private $config;
    
    public function __construct( array $config ) {
        
        $defaults = array(
            'name'          => 'My Plugin',
            'description'   => 'My Plugin\'s description',
            'version'       => '1.0',
            'slug'          => \Amarkal\Common\Tools::strtoslug( $config['name'] ),
            'callback'      => function( $args, $instance ){},  // Overrides WP_Widget::widget()
            'fields'        => array()
        );
        
        $this->config = array_merge( $defaults, $config );
    }
    
    public function __get( $name ) 
    {
        return $this->config[ $name ];
    }
}
