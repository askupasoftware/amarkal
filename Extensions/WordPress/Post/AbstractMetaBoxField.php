<?php

namespace Amarkal\Extensions\WordPress\Post;

/**
 * Implements an input field for meta boxes.
 */
abstract class AbstractMetaBoxField extends \Amarkal\Template\Controller
{
    protected $settings;
    
    public function __construct( array $settings = array() )
    {
        foreach( $this->required_settings() as $param )
        {
            if( !array_key_exists( $param, $settings ) )
            {
                throw new RequiredParameterException( 'Error: missing required parameter "'.$param.'"' );
            }
        }
        
        $this->settings = array_merge( $this->default_settings(), $settings );
    }
    
    public function get_name()
    {
        return $this->settings['name'];
    }
    
    public function render( $post )
    {
        $this->settings['value'] = $this->get_value( $post );
        parent::render(true);
    }
    
    public function __get( $name ) 
    {
        return $this->settings[$name];
    }
    
    public abstract function default_settings();
    public abstract function required_settings();
    public abstract function get_value( $post );
    public abstract function save( $post_id );
}
