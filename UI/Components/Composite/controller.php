<?php

namespace Amarkal\UI\Components;

/**
 * Implements a composite UI component.
 * A composite component consists of multiple UI components that are combined
 * together.
 * 
 * Parameters:
 * <ul>
 * <li><b>name</b> <i>string</i> The component's name.</li>
 * <li><b>template</b> <i>string</i> A string representing the template to use for constructing the field's value. Use <% sub_component_name %> as a placeholder.</li>
 * <li><b>disabled</b> <i>boolean</i> True to disabled component. False otherwise.</li>
 * <li><b>class</b> <i>string</i> Custom CSS class to be used for the component.</li>
 * <li><b>components</b> <i>array</i> A list of UI components.</li>
 * </ul>
 * 
 * Usage Example:
 * <pre>
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
 * </pre>
 */
class Composite
extends \Amarkal\UI\AbstractComponent
implements \Amarkal\UI\ValueComponentInterface
{
    public function __construct( array $model )
    {
        parent::__construct($model);
        
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
    
    /**
     * {@inheritdoc}
     */
    public function default_model()
    {
        return array(
            'name'          => '',
            'disabled'      => false,
            'template'      => '',
            'class'         => '',
            'components'    => array()
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function required_parameters() 
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
        return $this->model['name'];
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