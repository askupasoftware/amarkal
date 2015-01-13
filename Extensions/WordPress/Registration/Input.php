<?php

namespace Amarkal\Extensions\WordPress\Registration;

/**
 * 
 */
class Input extends AbstractField 
{
    public function defaults()
    {
        return array(
            'name'      => '',
            'label'     => '',
            'error'     => '',
            'validation'=> function( $val ) {}
        );
    }
    
    public function on_error( &$errors ) 
    {
        $errors->add( $this->name, $this->error );
    }
    
    public function validate()
    {
        $callable = $this->validation;
        
        if( is_callable( $callable ) )
        {
            $val = filter_input(INPUT_POST, $this->name);
            return $callable( $val );
        }
        
        return false;
    }
}
