<?php

namespace Amarkal\Extensions\WordPress\Registration;

/**
 * Implements a communicator class for the registration form.
 */
class Form 
{
    static function add_field( AbstractField $field )
    {
        //1. Add a new form element...
        add_action( 'register_form', array( $field, 'register_form_action' ) );
        //2. Add validation. In this case, we make sure first_name is required.
        add_filter( 'registration_errors', array( $field, 'registration_errors_action' ), 10, 3 );
    }
    
    /**
     * Add a callback function to be called upon successfull registration.
     * 
     * Multiple calls to this function are allowed.
     * The callback function is passed the user id as an argument.
     * 
     * Example usage:
     * 
     * Amarkal\Extensions\WordPress\Registration\Form::add_callback( 
     *     function( $user_id ) { //Do something with the user id } 
     * );
     * 
     * @param \Amarkal\Extensions\WordPress\Registration\callable $func
     */
    static function add_callback( callable $func )
    {
        add_action( 'user_register', $func );
    }
}
