<?php

namespace Amarkal\Extensions\WordPress\Registration;

/**
 * 
 */
class Captcha extends AbstractField 
{
    public function __construct( $props ) {
        parent::__construct( $props );
        
        session_start();
        
        if( !isset( $_POST[$this->name] ) )
        {
            $this->captcha = $this->generate_captcha();
        }
    }
    
    public function defaults()
    {
        return array(
            'name'      => '',
            'type'      => 'math',
            'label'     => '',
            'error'     => ''
        );
    }
    
    public function on_error( &$errors ) 
    {
        $errors->add( $this->name, $this->error );
    }
    
    public function validate()
    {
        // Validate
        $valid = filter_input(INPUT_POST, $this->name) == $_SESSION['captcha'];
        
        // Regenerate captcha
        $this->captcha = $this->generate_captcha();
        
        return $valid;
    }
    
    public function generate_captcha()
    {
        $numbers = ['zero','one','two','three','four','five','six','seven','eight','nine'];
        
        $num_1 = rand(1,9);
        $num_2 = rand(1,9);
        
        $_SESSION['captcha'] = $num_1 + $num_2;
        
        return ' = '.$numbers[$num_1].' + '.$num_2;
    }
    
    /**
     * Don't remeber form values for captcha.
     * @return string
     */
    public function get_value() 
    {
        return '';
    }
}
