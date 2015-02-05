<?php

namespace Amarkal\UI\Components;

/**
 * Implements a content holder.
 * 
 * User this special field to display static content inside the options page.
 * 
 * Parameters:
 * <ul>
 * <li><b>template</b> <i>string</i> The path to the template file.</li>
 * <li><b>callout</b> <i>function</i> A function to be called before the ajax call is made.</li>
 * <li><b>ajax</b> <i>boolean</i> True to use ajax to render the content. False otherwise.</li>
 * <li><b>args</b> <i>array</i> A list of argument to be passed as part of the ajax query.</li>
 * </ul>
 * 
 * Usage Example:
 * <pre>
 * $field = new Content(array(
 *      'template' => 'path-to-file'
 *      'callout'   => function() {},
 *      'ajax'      => true,
 *      'args'      => array(
 *          'key1'   => 'value1',
 *          'key2'   => 'value2'
 *      )
 * ));
 * </pre>
 */
class Content
extends \Amarkal\UI\AbstractComponent
{
    public function __construct(array $model) 
    {
        parent::__construct($model);
        
        $callable = $this->model['callout'];
        
        if( is_callable( $callable ) )
        {
            $callable();
        }
    }
    
    public function default_model() 
    {
        return array(
            'template'  => null,
            'callout'   => null,
            'ajax'      => false,
            'args'      => array()
        );
    }
    
    public function required_parameters() 
    {
        return array('template');
    }
}