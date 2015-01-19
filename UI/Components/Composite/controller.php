<?php

namespace Amarkal\UI\Components;

/**
 * Implements a composite UI component.
 * A composite component consists of multiple UI components that are combined
 * together.
 * 
 * Usage Example:
 * 
 * $field = new Composite(array(
 *        'name'            => 'composite_component',
 *        'template'        => '<% spinner %>px <% ddl %> <% color %>',
 *        'disabled'        => false,
 *        'class'           => 'custom-css-class',
 *        'components'      => array( // List of UI components
 *              new DropDown(
 *                  'title' => 'Drop Down List',
 *                  'name'  => 'ddl'
 *              ),
 *              new Spinner(
 *                  'title' => 'Spinner',
 *                  'name'  => 'spinner'
 *              ),
 *              new Color(
 *                  'name'  => 'color'
 *              )
 *        )
 * ));
 */
class Composite
extends \Amarkal\UI\AbstractComponent
implements \Amarkal\UI\ValueComponentInterface
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
        foreach( $this->components as $component )
        {
            if( in_array( $component->name, $names ) )
            {
                throw new \Amarkal\Form\DuplicateNameException( 'Composite component names must be unique, duplication detected for the name '.$component->name );
            }
            else
            {
                $names[] = $component->name;
            }
        }
    }
    
    public function default_settings()
    {
        return array(
            'name'          => '',
            'disabled'      => false,
            'template'      => '',
            'class'         => '',
            'components'    => array()
        );
    }
    
    public function required_settings() 
    {
        return array('name','template');
    }

    /**
     * {@inheritdoc}
     */
    public function get_default_value() 
    {
        $default = $this->template;
        foreach( $this->components as $component )
        {
            $name = $component->get_name();
            $default = str_replace("<% $name %>", $component->get_default_value(), $default);
        }
        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function get_name() 
    {
        return $this->config['name'];
    }

    /**
     * {@inheritdoc}
     * The Updater takes care of updating sub-components.
     * @see Form\Updater();
     */
    public function set_value( $value ) 
    {
        $this->value = $value;
    }
}