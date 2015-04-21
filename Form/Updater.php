<?php

namespace Amarkal\Form;

use Amarkal\UI;

/**
 * Implements a form updater.
 * 
 * The Updater class is responsible for the updating process of the of each form
 * component. It filters, validates or ignores each field as appropriate.
 * 
 * @see Form::update()
 */
class Updater
{
    /**
     * The list of AbstractComponent type objects to be updated.
     * 
     * @var Amarkal\UI\AbstractComponent[] field list.
     */
    private $components;
    
    /**
     * The old component values array. These values are used if the new values
     * are invalid.
     * Structure: component_name => component_value
     * 
     * @var array Old values array.
     */
    private $old_instance;
    
    /**
     * The new component values array (retrieved from the POST request).
     * Structure: component_name => component_value
     * 
     * @var array New values array.
     */
    private $new_instance;
    
    /**
     * The final values array, after filtering and validation.
     * This is returned by the update function.
     * 
     * @var array Final values array. 
     */
    private $final_instance = array();
    
    /**
     * Array of names of components that were invalid,
     * and the error message recieved.
     * Structure: component_name => error_message
     * 
     * @var string[] Array of error messages. 
     */
    private $errors = array();
    
    /**
     * Constructor.
     * 
     * @param array $components   The list of components to update.
     */
    public function __construct( array $components )
    {
        $this->components   = $components;
        $this->new_instance = \filter_input_array( INPUT_POST );
    }
    
    /**
     * Get the updated component values (validated, filtered or ignored).
     * 
     * Loops through each component and acts according to its type:
     * - Disableable components are ignored if they are disabled.
     * - Validatable components are validated using their validation function. 
     *   If the new value is invalid, the old value will be used.
     * - Filterable components are filtered using their filter function.
     * - Non-value components are skipped altogether.
     * 
     * Each component is also set with its new value.
     * 
     * @param array $old_instance The old component values array.
     * @return array The updated values array.
     */
    public function update( array $old_instance = array() )
    {
        $this->old_instance = $old_instance;
        $this->update_components( $this->components );
        return $this->final_instance;
    }
    
    /**
     * Reset all fields to their default values.
     * 
     * @param array $names List of component names to be set to their defaults. If no names are specified, all components will be reset
     * @return array The updated values array.
     */
    public function reset( array $names = array() )
    {
        if( array() == $names )
        {
            // Unset new instance to force reset
            $this->new_instance = array();
            return $this->update();
        }
        else
        {
            foreach( $this->components as $c )
            {
                if( in_array($c->get_name(), $names) )
                {
                    $this->new_instance[$c->get_name()] = $c->get_default_value();
                }
            }
            return $this->update();
        }
    }
    
    /**
     * Update the given list of components.
     * Recursively calls itself fpr composite components.
     * 
     * @param UI\AbstractComponent $components
     */
    private function update_components( $components )
    {
        foreach ( $components as $component ) 
        {
            // Update each component in the composite collection
            if ( $component instanceof UI\Components\Composite )
            {
                $this->update_components( $component->components );
            }
            
            // Update individual fields, as well as the composite parent field.
            if ( $component instanceof UI\ValueComponentInterface )
            {
                $this->update_component( $component );
            }
        }
    }
    
    /**
     * Update the component's value with the new value.
     * NOTE: this function also updates the $final_instance
     * array.
     * 
     * @param ValueComponentInterface $component The component to validate.
     * @param type $new_instance The new component values array.
     * @param type $old_instance The old component values array.
     */
    private function update_component( UI\ValueComponentInterface $component )
    {
        $comp_name = $component->get_name();
        
        // Use default values if:
        // 1. There is no old value (this is the first initiation of the form)
        //    and no new instance (this is not a form submission), or
        // 2. This field is disabled
        if( (
                !isset( $this->old_instance[$comp_name] ) &&
                !isset( $this->new_instance[$comp_name] )
            ) || ( 
                $component instanceof UI\DisableableComponentInterface &&
                true == $component->is_disabled() 
            ) )
        {
            $this->update_default( $component );
            return;
        }
        
        // No form submission
        if( !isset( $this->new_instance[$comp_name] ) )
        {
            $this->update_value( $component, $this->old_instance[$comp_name] );
            return;
        }
        
        $this->update_value( $component, $this->new_instance[$comp_name] );

        // Apply user-defined filter
        if( $component instanceof UI\FilterableComponentInterface )
        {
            $this->update_filterable( $component );
        }
        
        // Validate value
        if( $component instanceof UI\ValidatableComponentInterface )
        {
            $this->update_validatable( $component );
        }
    }
    
    /**
     * Update the component's value and the final instance with the
     * given value.
     * 
     * @param UI\AbstractComponent $component
     * @param string $value
     */
    private function update_value( $component, $value )
    {
        $component->set_value( $value );
        $this->final_instance[$component->get_name()] = $value;
    }
    
    /**
     * Set the component's to its default value .
     * 
     * @param \Amarkal\UI\ValueComponentInterface $component
     */
    private function update_default( UI\ValueComponentInterface $component )
    {
        $this->update_value( 
            $component, 
            $component->get_default_value() 
        );
    }
    
    /**
     * Filter the component's value using its filter function.
     * 
     * @param UI\FilterableComponentInterface $component
     */
    private function update_filterable( UI\FilterableComponentInterface $component )
    {
        $this->update_value( 
            $component, 
            $component->apply_filter( $this->new_instance[$component->get_name()] ) 
        );
    }
    
    /**
     * Validate the component's value using its validation function.
     * 
     * If the value is invalid, the old value is used, and an error message is
     * saved into the errors array as component_name => error_message.
     * 
     * @param ValidatableComponentInterface $component The component to validate.
     */
    private function update_validatable( UI\ValidatableComponentInterface $component )
    {
        $name   = $component->get_name();
        $error  = '';
        
        // Invalid input, use old instance or default value
        if ( !$component->validate( $this->new_instance[$name], $error ) ) 
        {
            $this->update_value( 
                $component, 
                $this->old_instance[$name]
            );
            $this->errors[$name] = $error;
            $component->set_validity($component::INVALID);
        }
    }
    
    /**
     * Set a custom new instance, to override the values taken from the 
     * $_POST array by default
     * 
     * @param type $instance
     */
    public function set_new_instance( $instance )
    {
        $this->new_instance = $instance;
    }
    
    /**
     * Get the list of error messages for components that could not be validated.
     * Structure: components_name => error_message
     * 
     * @return string[] Array of error messages. 
     */
    public function get_errors()
    {
        return $this->errors;
    }
}
