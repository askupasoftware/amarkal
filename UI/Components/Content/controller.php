<?php

namespace Amarkal\UI\Components;

/**
 * Implements a content holder.
 * 
 * User this special field to display static content inside the options page.
 * 
 * Parameters:
 * <ul>
 * <li><b>template</b> <i>string</i> The path to the template file.</li>
 * </ul>
 * 
 * Usage Example:
 * <pre>
 * $field = new Content(array(
 *      'template' => 'path-to-file'
 * ));
 * </pre>
 */
class Content
extends \Amarkal\UI\AbstractComponent
{
    public function default_settings() 
    {
        return array(
            'template'      => null
        );
    }
    
    public function required_settings() 
    {
        return array('template');
    }
}