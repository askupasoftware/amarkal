<?php

namespace Amarkal\Extensions\WordPress\Editor;

class Editor 
{
    private function __construct() {}
    
    static function add_button( AbstractEditorPlugin $plugin )
    {
        $plugin->register();
    }
}
