<?php

namespace Amarkal\Extensions\WordPress\Options;

/**
 * Implements an options page section that can have tabs.
 */
class TabbedSection extends Section
{
    /**
     * Construct default settings.
     * @return mixed[] The default settings.
     */
    public function defaults()
    {
        return parent::defaults() + array(
            'labels'    => array(
                'singular'  => 'Tab',
                'plural'    => 'Tabs'
            )
        );
    }
    
    public function __construct(array $config = array())
    {
        parent::__construct($config);
        $fields = array();
        foreach( $this->get_tabs() as $tab )
        {
            $fields = array_merge( $fields, $this->gen_tab_fields($this->fields,\Amarkal\Common\Tools::strtoslug($tab)) );
        }
        $this->fields = $fields;
    }

    public function render()
    {
        $tabs = array();
        foreach ( $this->get_tabs() as $name )
        {
            $tab_slug = \Amarkal\Common\Tools::strtoslug($name);
            $tabs[] = new \Amarkal\Template\Template(
                dirname(__FILE__).'/Section.phtml',
                array(
                    'current_section'   => $this->is_current_tab( $tab_slug ),
                    'slug'              => $tab_slug,
                    'icon'              => $this->get_icon_class(),
                    'title'             => $this->title.' ('.$name.')',
                    'fields'            => $this->get_tab_fields( $tab_slug ),
                    'class'             => 'ao-tab'
                )
            );
        }
        
        // New tab template
        $tabs[] = new \Amarkal\Template\Template(
            dirname(__FILE__).'/Section.phtml',
            array(
                'current_section'   => $this->is_current_tab( 'create' ),
                'slug'              => 'create',
                'icon'              => 'fa fa-plus',
                'title'             => 'Add New '.$this->labels['singular'],
                'class'             => 'ao-tab',
                'fields'            => array(
                    new UI\Text(array(
                        'name'      => 'new_'.strtolower( $this->labels['singular'] ),
                        'title'     => $this->labels['singular'].' Name'
                    )),
                    new UI\Process(array(
                        'name'      => 'create_'.strtolower( $this->labels['singular'] ),
                        'label'     => 'Create',
                        'callback'  => function(){
                            
                        }
                    ))
                )
            )
        );
        
        $template = new \Amarkal\Template\Template( 
            dirname( __FILE__ ).'/TabbedSection.phtml',
            array(
                'current_section'   => $this->is_current_section(),
                'slug'              => $this->get_slug(),
                'tabs'              => $tabs
            )    
        );
        
        echo $template->render();
    }
    
    public function get_tabs()
    {
        return array(
            'Register',
            'Newsletter'
        );
    }
    
    public function get_tab_fields( $tab_slug )
    {
        $fields = array();
        foreach( $this->fields as $field )
        {
            if( $field instanceof ValueFieldInterface && strpos($field->name, $tab_slug) === 0)
            {
                $fields[] = $field;
            }
        }
        return $fields;
    }
    
    public function gen_tab_fields( $fields, $tab_slug )
    {
        $tab_fields = array();
        foreach ( $fields as $field )
        {   
            $class = get_class($field);
            $tab_field = new $class($field->get_config());
            $tab_field->name = $tab_slug.'_'.$tab_field->name;
            $tab_fields[] = $tab_field;
        }
        return $tab_fields;
    }
    
    public function is_current_tab( $tab_slug )
    {
        return $this->is_current_section() && filter_input(INPUT_GET, 'tab') == $tab_slug;
    }
}
