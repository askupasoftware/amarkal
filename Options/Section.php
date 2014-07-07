<?php

namespace Amarkal\Options;

class Section
{
    private $config;
    private $active = false;
    
    public function __construct( array $config = array() )
    {
        $this->config = $config;
    }
    
    public function __get( $name )
    {
        return $this->config[$name];
    }
    
    /**
     * Generates the appropriate CSS class for the icon.
     * 
     * Examples: 
     * 'fa-twitter' returns 'fa fa-twitter'
     * 'dashicons-admin-media' returns 'dashicons dashicons-admin-media' 
     * 
     * @return type
     */
    public function get_icon_class()
    {
        return preg_replace( '/(fa|dashicons)(-[\w\-]+)/', '$1 $1$2', $this->config['icon'] );
    }
    
    public function set_current_section()
    {
        $this->active = true;
    }
    
    public function is_current_section()
    {
        return $this->active;
    }
}