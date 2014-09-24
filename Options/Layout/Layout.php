<?php

namespace Amarkal\Options\Layout;

class Layout extends Controller
{   
    protected $header;
    protected $footer;
    protected $sidebar;
    protected $sections;
    
    public function __construct( $page_slug, $props = array() ) 
    {
        parent::__construct();
        $this->header = new Header($props['header']);
        $this->footer = new Footer($props['footer']);
        $this->sidebar = new Sidebar($props['sections'],$page_slug);
        $this->sections = $props['sections'];
    }
}