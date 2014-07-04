<?php

namespace Amarkal\Options;

class Section
{
    private $config;
    
    public function __construct( array $config = array() ) {
        $this->config = $config;
    }
    
    public function __get( $name ) {
        return $this->config[$name];
    }
}