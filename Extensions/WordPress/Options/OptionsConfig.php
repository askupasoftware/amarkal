<?php

namespace Amarkal\Extensions\WordPress\Options;

/**
 * Implements a configuration class to be used with 
 * Amarkal\Extensions\WordPress\Options\OptionsPage()
 */
class OptionsConfig
{
    /**
     * Configuration array 
     * @var array 
     */
    private $config;
    
    /**
     * 
     * @param array $config
     */
    public function __construct( array $config = array() )
    {
        $this->config = $this->validate_config( $config );
        $this->set_section_slugs();
    }
    
    /**
     * Validate the integrity of the provided configuration array
     * 
     * @param array $config
     * @throws DuplicateNameException On duplicate field name
     */
    private function validate_config( $config )
    {
        $names  = array();
        $merged_conf = array_merge( include('OptionsConfigDefaults.php'), $config );
        
        foreach( $merged_conf['sections'] as $section )
        {
            foreach( $section->fields as $field )
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
        }
        
        return $merged_conf;
    }
    
    /**
     * Set slugs to each section, according the number of sections.
     */
    private function set_section_slugs()
    {
        // For more than 1 sections, set section specific slugs
        if( count( $this->sections ) > 1 )
        {
            foreach( $this->sections as $section )
            {
                $section->set_slug( \Amarkal\Common\Tools::strtoslug( $section->title ) );
            }
        }
        
        // For a single section, use the page's title as the slug
        else
        {
            $this->sections[0]->set_slug( \Amarkal\Common\Tools::strtoslug( $this->title ) );
        }
    }

    public function __get( $name ) 
    {
        if( isset( $this->config ) )
        {
            return $this->config[ $name ];
        }
    }
    
    public function get_sections()
    {
        return $this->config['sections'];
    }
    
    public function get_fields()
    {
        if( !isset( $this->fields ) )
        {
            $fields = array();
            foreach( $this->config['sections'] as $section )
            {
                foreach( $section->get_fields() as $field )
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
        return $this->get_section_by_slug( $section_slug )->fields;
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