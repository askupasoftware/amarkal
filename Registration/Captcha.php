<?php

namespace Amarkal\Registration;

/**
 * 
 */
class Captcha extends AbstractField 
{
    public function on_error( $errors ) 
    {
        $errors->add( $this->name, $this->label );
    }

    public function on_success( $user_id ) 
    {
        update_user_meta( $user_id, 'first_name', 'yeyyyy!' );
    }
    
    public function validate()
    {
        return isset( $_POST[$this->name] ) && !empty( trim( $_POST[$this->name] ) );
    }
}
