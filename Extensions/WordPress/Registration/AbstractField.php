<?php

namespace Amarkal\Extensions\WordPress\Registration;

/**
 * 
 */
abstract class AbstractField 
{
    protected $template;
    
    public function __construct( $props ) {
        $this->template = new \Amarkal\Template\Template($this->get_script_path());
        
        foreach(array_merge( $this->defaults(), $props ) as $key => $value)
        {
            $this->{$key} = $value;
        }
    }
   
    public function render( $echo = false )
    {
        $this->value = $this->get_value();
        $props = get_object_vars($this);
        unset($props['template']);
        
        $this->template->set_properties($props);
        
        if( $echo )
        {
            echo $this->template->render();
        }
        else
        {
            return $this->template->render();
        }
    }
   
    protected function get_script_path()
    {
         $class_name =  substr( get_called_class() , strrpos( get_called_class(), '\\') + 1);
         return __DIR__ . '/' . $class_name . '.phtml';
    }
    
    public function register_form_action()
    {
        $this->render( true );
    }
    
    public function registration_errors_action( $errors, $sanitized_user_login, $user_email )
    {
        if( false == $this->validate() )
        {
            $this->on_error( $errors );
        }
        return $errors;
    }
    
    public function get_value()
    {
        return filter_input(INPUT_POST, $this->name);
    }
    
    abstract function on_error( &$errors );
    abstract function defaults();
    abstract function validate();
}
