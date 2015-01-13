<?php

namespace Amarkal\Extensions\WordPress\Options\Layout;

class Footer extends \Amarkal\Template\Controller
{   
    public function __construct( $icon, $text ) 
    {
        $this->icon = $icon;
        $this->text = $text;
    }
}