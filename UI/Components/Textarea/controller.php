<?php

namespace Amarkal\UI\Components;

/**
 * Implements a Textarea UI component.
 * 
 * Parameters:
 * <ul>
 * <li><b>name</b> <i>string</i> The component's name.</li>
 * <li><b>default</b> <i>number|number[]</i> The component's default value.</li>
 * <li><b>disabled</b> <i>boolean</i> True to disabled component. False otherwise.</li>
 * <li><b>placeholder</b> <i>string</i> Text to be used when the input is empty.</li>
 * <li><b>filter</b> <i>function</i> Filter callback function, accepts the value as an argument.</li>
 * <li><b>validation</b> <i>function</i> Validation callback function, accepts two arguments:
 *  <ul>
 *      <li><b>$v</b> <i>mixed</i> The component's value.</li>
 *      <li><b>&$e</b> <i>mixed</i> The error message.</li>
 *      <li><b>Returns</b> True if valid, false otherwise.</li>
 *  </ul>
 * </li>
 * </ul>
 * 
 * Usage Example:
 * <pre>
 * $field = new Textarea(array(
 *        'name'            => 'textarea_1',
 *        'default'         => 'Enter your text here',
 *        'placeholder'     => 'Enter text...',
 *        'disabled'        => false,
 *        'filter'          => function( $v ) { return trim( strip_tags( $v ) ); },
 *        'validation'      => function( $v, &$e ) {
 *                                  $valid = strlen($v) <= 25;
 *                                  $e = 'Text must be less than 25 characters long'
 *                                  return $valid;
 *                             }
 * ));
 * </pre>
 */
class Textarea
extends \Amarkal\UI\AbstractComponent
implements \Amarkal\UI\ValueComponentInterface,
           \Amarkal\UI\DisableableComponentInterface,
           \Amarkal\UI\FilterableComponentInterface,
           \Amarkal\UI\ValidatableComponentInterface
{
    public function default_model() {
        return array(
            'name'          => '',
            'disabled'      => false,
            'default'       => '',
            'placeholder'   => '',
            'filter'        => function( $v ) { return $v; },
            'validation'    => function( $v, &$e ) { return true; }
        );
    }
    
    public function required_parameters() 
    {
        return array('name');
    }

    /**
     * {@inheritdoc}
     */
    public function get_default_value() 
    {
        return $this->model['default'];
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
     */
    public function set_value( $value ) 
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function is_disabled() 
    {
        return $this->model['disabled'];
    }

    /**
     * {@inheritdoc}
     */
    public function apply_filter( $value ) 
    {
        $callable = $this->model['filter'];

        if( is_callable( $callable ) ) 
        {
            return $callable( $value );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validate( $value, &$error ) 
    {   
        $callable = $this->model['validation'];
        
        if( is_callable( $callable ) ) 
        {
            return $callable( $value, $error );
        }
        
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function set_validity( $validity ) 
    {
        $this->invalid = ( $validity == self::INVALID );
    }
}