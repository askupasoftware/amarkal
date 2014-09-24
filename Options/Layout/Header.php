<?php

namespace Amarkal\Options\Layout;

class Header extends Controller
{   
    public function __construct( $props = array() ) 
    {
        parent::__construct();
        foreach($props as $key => $value)
        {
            $this->{$key} = $value;
        }
    }
}