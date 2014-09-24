<?php

namespace Amarkal\Options;

class OptionsConfig
{
    private $config;
    
    public function __construct( array $config = array() ) {
        $this->set_config( $config );
    }
    
    public function set_config( $config )
    {
        $names = array();
        $this->config = $config;
        
        foreach( $this->get_fields() as $field )
        {
            if( $field instanceof ValueFieldInterface && in_array( $field->name, $names ) )
            {
                throw new DuplicateNameException( 'A field with with the name '.$field->name.' already exist. Field names MUST be unique.' );
            }
            else
            {
                $names[] = $field->name;
            }
        }
        $this->config = $config;
    }
    
    public function get_config()
    {
        return $this->config;
    }

    public function __get( $name ) {
        if( isset( $this->config ) )
        {
            return $this->config[ $name ];
        }
    }
    
    public function get_fields()
    {
        if( !isset( $this->fields ) )
        {
            $fields = array();
            foreach( $this->config['sections'] as $section )
            {
                foreach( $section->fields as $field )
                {
                    $fields[] = $field;
                }
            }
            $this->fields = $fields;
        }
        return $this->fields;
    }
    
    public function get_section_fields( $section_slug )
    {
        $section = $this->get_section_by_slug( $section_slug );
        return $section->fields;
    }
    
    public function get_section_by_slug( $section_slug )
    {
        foreach( $this->config['sections'] as $section )
        {
            if( $section->get_slug() == $section_slug )
            {
                return $section;
            }
        }
    }
}