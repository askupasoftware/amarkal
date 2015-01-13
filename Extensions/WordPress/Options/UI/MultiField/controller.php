<?php

namespace Amarkal\Extensions\WordPress\Options\UI;

use \Amarkal\Extensions\WordPress\Options;

/**
 * Implements a Text field.
 * 
 * Usage Example:
 * 
 * $field = new Text(array(
 *        'name'            => 'textfield_1',
 *        'label'           => 'Title',
 *        'default'         => 'Enter your title here',
 *        'disabled'        => false,
 *        'filter'          => function( $v ) { return trim( strip_tags( $v ) ); },
 *        'validation'      => function( $v ) { return strlen($v) <= 25; },
 *        'error_message'   => 'Error: the title must be less than 25 characters',
 *        'description'     => 'This is the title'
 * ));
 */
class MultiField
extends \Amarkal\Extensions\WordPress\Options\AbstractField
implements \Amarkal\Extensions\WordPress\Options\ValueFieldInterface
{
    public function __construct( array $config )
    {
        parent::__construct($config);
        
        $this->pre_process();
    }
    
    private function pre_process()
    {
        // Check name unqueness
        $names = array();
        foreach( $this->fields as $field )
        {
            if( in_array( $field->name, $names ) )
            {
                throw new Options\DuplicateNameException( 'A field with with the name '.$field->name.' already exist. Field names MUST be unique.' );
            }
            else
            {
                $names[] = $field->name;
                $field->index = $field->name; // Save the name to be used later by get_value()
                $field->name = $this->name . '['.$field->name.']';
            }
        }
    }
    
    public function default_settings() {
        return array(
            'name'          => '',
            'title'            => '',
            'disabled'      => false,
            'default'        => '',
            'help'            => null,
            'description'    => '',
            'filter'        => function( $v ) { return $v; },
            'fields'        => array()
        );
    }
    
    public function required_settings() {
        return array('name');
    }

    /**
     * {@inheritdoc}
     */
    public function get_default_value() {
        $defaults = array();
        foreach( $this->fields as $field )
        {
            $defaults[$field->index] = $field->get_default_value();
        }
        return $defaults;
    }

    /**
     * {@inheritdoc}
     */
    public function get_name() {
        return $this->config['name'];
    }

    /**
     * {@inheritdoc}
     */
    public function set_value( $value ) {
        foreach( $this->fields as $field )
        {
            $field->value = $value[$field->index];
        }
    }
}