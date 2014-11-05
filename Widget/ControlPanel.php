<?php

namespace Amarkal\Widget;

/**
 * Implements a widget control panel.
 * 
 * The ControlPanel class is the control interface for the widget. It is
 * rendered as a part of the WP_Widget::form() function.
 * The control panel class is comprised of a list of 
 * Amarkal\Widget\UI\AbstractComponent type objects, which are the
 * components (fields) of the control panel.
 * 
 * @see WP_Widget::form()
 * @see Amarkal\Widget\AbstractWidget::form()
 * 
 * Example usage:
 * 
 * $cp = new ControlPanel(
 *        array(
 *            new UI\Textfield(array(
 *                'name'            => 'textfield_1',
 *                'label'            => 'Title',
 *                'description'    => 'This is the widget\'s title',
 *                'default'        => '',
 *                'filter'        => function( $v ) { return trim( strip_tags( $v ) ); },
 *                'validation'    => function( $v ) { return strlen < 50; }
 *            )),
 *            new UI\Seperator(array(
 *                'label'            => 'Divider'
 *            )),
 *            new UI\Dropdown(array(
 *                'name'            => 'dropdown_1',
 *                'label'            => 'Drop-Down Menu',
 *                'default'        => 's1',
 *                'values'        => array(
 *                    'Select #1' => 's1',
 *                     'Select #2' => 's2',
 *                     'Select #3' => 's3'
 *                ),
 *                'description'    => 'This is a dropdown menu'
 *            ))
 *        )
 *    );
 * 
 * Note: the components are rendered in the order in which they are recieved by
 * the constructor.
 */
class ControlPanel {
    
    /**
     * The list of control panel components.
     * 
     * @var UI\ComponentInterface[] The list of components.
     */
    private $components;
    
    /**
     * The list of default values for all components, arranged by component
     * (field) name.
     * @var mixed[] Array of default values. 
     */
    private $defaults;
    
    /**
     *
     * @var type $width 
     * @var type $height
     */
    private $width;
    private $height;
    
    /**
     * Create a new control panel for the widget.
     * 
     * @param array $components    An array of UI\ComponentInterface type objects.
     * @param array $dimensions    The width and height of the control panel.
     */
    public function __construct( array $components = array(), array $dimensions = array() )
    {
        $this->add_components( $components );
        $this->height    = $dimensions['height'];
        $this->width    = $dimensions['width'];
    }
    
    /**
     * Add a component to the control panel.
     * 
     * If a component is of type UI\ValueComponentInterface, then it MUST
     * have a unique name, otherwise the updating process will not work
     * properly. To safe-guard against this issue, an exception is thrown.
     * 
     * @param  UI\ComponentInterface $new_component The component to add.
     * @throws UI\DuplicateNameException Thrown when two components share 
     *                                     the same name 
     */
    public function add_component( ComponentInterface $new_component ) 
    {
        
        // First component - no need to check for name uniqueness
        if( NULL === $this->components )
        {
            $this->components[] = $new_component;
        }
        
        // Not the first component - check for name uniqueness
        else 
        {
            // Only value components must have unique names
            if ( $new_component instanceof ValueComponentInterface )
            {
                foreach ( $this->components as $component )
                {
                    if( $component instanceof ValueComponentInterface && 
                        $component->get_name() == $new_component->get_name() )
                    {
                        throw new DuplicateNameException(
                            "A component with the name '{$component->get_name()}' already exists"
                        );
                    }
                }
            }
            
            $this->components[] = $new_component;
        }
    }
    
    /**
     * Bulk add components to the control panel.
     * 
     * @uses self::add_component() Called for each component.
     * 
     * @param array $components The array of components to add.
     */
    public function add_components( array $components ) 
    {
        foreach ($components as $component ) 
        {
            $this->add_component( $component );
        }
    }
    
    /**
     * Get the control panel's compnent array.
     * 
     * @return array The array of components.
     */
    public function get_components() 
    {
        return $this->components;
    }
    
    /**
     * Get the default values for all the value components.
     * 
     * Get an array of 'name' => 'default_value' for each of the control
     * panel's component that implements the UI\ValueComponentInterface interface.
     * 
     * @return array The array of defaults values.
     */
    public function get_defaults() 
    {
        if ( NULL === $this->defaults )
        {    
            $defaults = array();
            foreach ( $this->components as $component ) 
            {
                if ( $component instanceof ValueComponentInterface ) 
                { 
                    $defaults[$component->get_name()] = $component->get_default_value();
                }
            }
            $this->defaults = $defaults;
        }
        return $this->defaults;
    }
    
    /**
     * Render the control panel.
     * 
     * @param array        $instance    The array of field values.
     * @param boolean    $return        True/false to return/echo the results.
     * 
     * @return string    The control panel, rendered as HTML.
     */
    public function render( $instance, $return = FALSE ) 
    {
        $out = '';
        foreach( $this->components as $component ) 
        {    
            if( $component instanceof ValueComponentInterface ) 
            {
                // Set the component's value
                $component->set_value( $instance[$component->get_name()] );
            }
            
            if ( $component instanceof ValidatableComponentInterface ) 
            {
                // Invalid user input: Set error flag.
                if ( true == $instance[$component->get_name().'_error'] )
                {
                    $component->set_error_message( $instance[$component->get_name().'_error_message'] );
                }
            }
            
            // Render component with given value.
            $out .= $component->render();
        }
        
        if( $return ) return $out;
        
        echo $out;
    }
}
