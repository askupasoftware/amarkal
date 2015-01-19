<?php

namespace Amarkal\UI\Components;

/**
 * Implements a Textarea UI component.
 * 
 * Usage Example:
 * 
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
 */
class Textarea
extends \Amarkal\UI\AbstractComponent
implements \Amarkal\UI\ValueComponentInterface,
           \Amarkal\UI\DisableableComponentInterface,
           \Amarkal\UI\FilterableComponentInterface,
           \Amarkal\UI\ValidatableComponentInterface
{
    public function default_settings() {
        return array(
            'name'          => '',
            'disabled'      => false,
            'default'       => '',
            'placeholder'   => 'Enter text...',
            'filter'        => function( $v ) { return $v; },
            'validation'    => function( $v, &$e ) { return true; }
        );
    }
    
    public function required_settings() 
    {
        return array('name');
    }

    /**
     * {@inheritdoc}
     */
    public function get_default_value() 
    {
        return $this->config['default'];
    }

    /**
     * {@inheritdoc}
     */
    public function get_name() 
    {
        return $this->config['name'];
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
        return $this->config['disabled'];
    }

    /**
     * {@inheritdoc}
     */
    public function apply_filter( $value ) 
    {
        $callable = $this->config['filter'];

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
        $callable = $this->config['validation'];
        
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
        $this->validity = ( $validity == self::INVALID );
    }
}