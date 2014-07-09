<?php

namespace Amarkal\Options;

class Section
{
    private $config;
    private $active = false;
    private $slug;
    
    public function defaults()
    {
        return array(
            'title'         => '',      // The section's title. MUST be unique.
            'description'   => '',      // The section's description.
            'icon'          => '',      // One of the icon classes from Font Awesome or Dashicons.
            'parent'        => null,    // The parent's title, if applicable.
            'fields'        => array()  // The section's fields.
        );
    }
    
    public function __construct( array $config = array() )
    {
        $this->config = array_merge( $this->defaults(), $config );
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
    
    public function set_slug( $slug )
    {
        $this->slug = $slug;
    }
    
    public function get_slug()
    {
        return $this->slug;
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