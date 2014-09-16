<?php

namespace Amarkal\Options;

/**
 * Implements an options updater.
 * 
 * The options updater is responsible for the updating process of the options 
 * page. It filters, validates or ignores each field as appropriate.
 * 
 * @see OptionsPage::update()
 */
class OptionsUpdater
{
    /**
     * The list of AbstractField type objects to be updated.
     * 
     * @var AbstractField[] field list.
     */
    private $fields;
    
    /**
     * The old field values array. These values are used if the new values
     * are invalid.
     * Structure: field_name => field_value
     * 
     * @var array Old values array.
     */
    private $old_instance;
    
    /**
     * The new field values array (retrieved from the POST request).
     * Structure: field_name => field_value
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
     * Array of names of fields that were invalid.
     * 
     * @var string[] Array of erroneous field names. 
     */
    private $error_fields = array();
    
    /**
     * Constructor.
     * 
     * @param array $fields      The list of components to update.
     * @param array $new_instance The new component values array.
     * @param array $old_instance The old component values array.
     */
    public function __construct( $fields, $new_instance = array(), $old_instance = array() )
    {
        $this->fields       = $fields;
        $this->old_instance = $old_instance;
        $this->new_instance = $new_instance;
    }
    
    /**
     * Get the updated field values (validated, filtered or ignored).
     * 
     * Loops through each field and acts according to its type:
     * - Disableable fields are ignored if they are disabled.
     * - Validatable fields are validated using their validation function. 
     *   If the new value is invalid, the old value will be used.
     * - Filterable fields are filtered using their filter function.
     *  
     * @return array The validated values array.
     */
    public function update()
    {
        foreach ( $this->fields as $field ) {
            if ( $field instanceof ValueFieldInterface ) {
                $this->update_field( $field );
            }
        }
        
        return $this->final_instance;
    }
    
    /**
     * Get the list of field names that could not be validated.
     * 
     * @return string[] Array of erroneous field names. 
     */
    public function get_error_fields()
    {
        return $this->error_fields;
    }
    
    /**
     * Update the field's value with the new value.
     * 
     * @param ValuefieldInterface $field The component to validate.
     * @param type $new_instance The new component values array.
     * @param type $old_instance The old component values array.
     */
    private function update_field( ValueFieldInterface $field )
    {
        $name = $field->get_name();
        $this->final_instance[$name] = $this->new_instance[$name];
        
        // If this is the first time this widget is created, there are no
        // old values: use default value.
        if( !isset( $this->new_instance[$name] ) )
        {
            $this->final_instance[$name] = $field->get_default_value();
            return;
        }
        
        // Disabled component: no update needed
        if ( $field instanceof DisableableComponentInterface &&
             true == $field->is_disabled() )
        {
            $this->final_instance[$name] = $field->get_default_value();
            return;
        }
        
        // Apply user-defined filter
        if( $field instanceof FilterableFieldInterface )
        {
            $this->update_filterable( $field );
        }
        
        // Validate value
        if( $field instanceof ValidatableFieldInterface )
        {
            $this->update_validatable( $field );
        }
    }
    
    /**
     * Filter the field's value using its filter function.
     * 
     * @param FilterableFieldInterface $field
     */
    private function update_filterable( FilterableFieldInterface $field )
    {
        $this->final_instance[$field->get_name()] = 
            $field->apply_filter( $this->new_instance[$field->get_name()] );
    }
    
    /**
     * Validate the field's value using its validation function.
     * 
     * If the value is invalid, the old value is used, and an error message is
     * saved into the array as {field_name}_error_message.
     * 
     * @param ValidatableComponentInterface $field The component to validate.
     */
    private function update_validatable( ValidatableFieldInterface $field )
    {
        $name = $field->get_name();

        // Invalid input
        if ( !$field->validate( $this->new_instance[$name] ) ) {
            $this->final_instance[$name] = $this->old_instance[$name];
            $this->error_fields[] = $name;
        }
    }
}