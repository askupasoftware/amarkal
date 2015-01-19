<?php

namespace Amarkal\UI\Components;

/**
 * Implements a content holder.
 * 
 * User this special field to display static content inside the options page.
 * 
 * Usage Example:
 * 
 * $field = new Content(array(
 *      'template'       => 'path-to-file',
 *      'full_width'     => false
 * ));
 */
class Content
extends \Amarkal\UI\AbstractComponent
{
    public function default_settings() 
    {
        return array(
            'template'      => null,
            'full_width'    => false
        );
    }
    
    public function required_settings() 
    {
        return array('template');
    }
}