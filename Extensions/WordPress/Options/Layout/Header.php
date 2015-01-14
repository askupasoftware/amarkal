<?php

namespace Amarkal\Extensions\WordPress\Options\Layout;

class Header extends \Amarkal\Template\Controller
{   
    public function __construct( $title, $version, $author, $author_url, $banner, $sections ) 
    {
        $this->title        = $title;
        $this->version      = $version;
        $this->author       = $author;
        $this->author_url   = $author_url;
        $this->sections     = $sections;
        $this->banner       = $banner;
    }
}