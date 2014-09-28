<?php

namespace Amarkal\Registration;

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
        //3. Finally, save our extra registration user meta.
        add_action( 'user_register', array( $field, 'user_register_action' ) );
    }
}
