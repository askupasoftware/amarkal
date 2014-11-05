<?php

namespace Amarkal\Widget;

/**
 * Describes a component with a filterable value.
 */
interface FilterableComponentInterface extends ValueComponentInterface {
    
    /**
     * Apply a filter to the component's value.
     * 
     * This function is called when the widget's "save" button is clicked. It
     * calls the user-defined function under 'filter' to filter the value.
     * 
     * @param string $value The value to filter (passed by reference).
     * @return void         This function does not return a value.
     */
    public function apply_filter( &$value );
}