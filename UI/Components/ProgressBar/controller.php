<?php

namespace Amarkal\UI\Components;

/**
 * Implements a progress bar UI controller.
 * 
 * <b>Parameters:</b>
 * <ul>
 * <li><b>value</b> <i>number</i> The current value.</li>
 * <li><b>max</b> <i>number</i> The maximum value.</li>
 * </ul>
 * 
 * <b>Usage Example:</b>
 * <pre>
 * $field = new Content(array(
 *      'value'     => 125,
 *      'max'       => 180
 * ));
 * </pre>
 */
class ProgressBar
extends \Amarkal\UI\AbstractComponent
{
    public function default_model() 
    {
        return array(
            'value'     => null,
            'max'       => null
        );
    }
    
    public function required_parameters() 
    {
        return array('max');
    }
}