<?php

namespace Amarkal\Extensions\WordPress\Editor;

/**
 * Editor
 * This static class is used to customize the tinyMCE text editor.
 */
class Editor 
{
    /**
     * Prevent instantiation
     */
    private function __construct() {}
    
    /**
     * Add a button to the tinyMCE text editor
     * @param \Amarkal\Extensions\WordPress\Editor\AbstractEditorPlugin $plugin
     */
    static function add_button( Plugin $plugin )
    {
        $plugin->register();
    }
}
