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
     * Array of references to all components.
     * @var type 
     */
    private $fields;
    
    /**
     * 
     * @param array $config
     */
    public function __construct( array $config = array() )
    {
        $this->fields = array();
        $this->config = $this->validate_config( array_merge( include('OptionsConfigDefaults.php'), $config ) );
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
        $this->section_names  = array();
        
        foreach( $config['sections'] as $section )
        {
            
            if( in_array( $section->title, $this->section_names ) )
            {
                throw new DuplicateSectionException( $section->title );
            }
            
            // Component name uniqueness is validated by the from object, not here
            foreach( $section->get_fields() as $field )
            {
                $this->fields[] = $field;
            }
            
            $this->section_names[] = $section->title;
        }
        return $config;
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
        return $this->fields;
    }
    
    public function get_section_fields( $section_slug )
    {
        return $this->get_section_by_slug( $section_slug )->fields;
    }
    
    /**
     * @return null|Section
     */
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