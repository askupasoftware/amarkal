<?php

namespace Amarkal\Options;

class Config
{
    private $config;
    
    public function __construct( array $config = array() ) {
        $this->set_config( $config );
    }
    
    public function set_config( $config )
    {
        $this->config = $config;
    }
    
    public function get_config()
    {
        return $this->config;
    }

    public function __get( $name ) {
        if( isset( $this->config ) )
        {
            return $this->config[ $name ];
        }
    }
}