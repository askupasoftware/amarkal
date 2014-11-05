<?php

namespace Amarkal\Widget;

/**
 * Describes a component that is capabale of being disabled.
 * 
 * This interface is applicable any component that allow user input.
 */
interface DisableableComponentInterface extends ValueComponentInterface {
    
    /**
     * Check if the component has been disabled.
     * 
     * @return boolean True/false if the component is disabled.
     */
    public function is_disabled();
}