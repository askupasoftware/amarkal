<?php

namespace Amarkal\UI;

/**
 * Describes a field with a filterable value.
 */
interface FilterableComponentInterface extends ValueComponentInterface {
    
    /**
     * Apply a filter to the field's value.
     * 
     * This function is called when the options page "save" button is clicked. It
     * calls the user-defined function under 'filter' to filter the value.
     * 
     * @param  string $value  The value to filter (passed by reference).
     * @return string         The filtered value.
     */
    public function apply_filter( $value );
}