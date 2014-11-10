<?php

namespace Amarkal\UI\Components;

/**
 * Implements an Input component.
 * 
 * Template file: Template/Input.php
 * 
 * Input is the most common form control. The input component supports
 * for all HTML5 types: text, password, datetime, datetime-local, date, month, 
 * time, week, number, email, url, search, tel, and color.
 * 
 * Usage Example:
 * 
 * $component = new Textfield(array(
 *        'name'           => 'textfield_1',
 *        'type'           => 'text'
 *        'disabled'       => fals-e,
 * ));
 */
class Input 
extends \Amarkal\UI\AbstractComponent
{
    /**
     * {@inheritdoc}
     */
    public function get_default_settings() 
    {
        return array(
            'name'          => null,
            'type'          => 'text',
            'disabled'      => false,
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function get_required_settings() 
    {
        return array('name');
    }
}
