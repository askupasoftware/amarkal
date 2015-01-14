<?php

namespace Amarkal\Extensions\WordPress\Options\Layout;

class Layout extends \Amarkal\Template\Controller
{   
    protected $header;
    protected $footer;
    protected $sidebar;
    protected $sections;
    
    public function __construct( $config = array() ) 
    {
        $this->header = new Header( 
            $config->title, 
            $config->version, 
            $config->author,
            $config->author_url,
            $config->banner,
            $config->sections
        );
        
        $this->footer = new Footer(
            $config->footer_icon,
            $config->footer_text
        );
        
        $this->sections = $config->sections;
        $this->subfooter_text = $config->subfooter_text;
    }
}