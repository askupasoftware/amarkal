<?php

namespace Amarkal\Options\Layout;

class Sidebar extends Controller
{
    protected $sections;
    protected $page_slug;
    
    public function __construct( $sections, $page_slug ) {
        parent::__construct();
        $this->sections = $sections;
        $this->page_slug = $page_slug;
    }
}