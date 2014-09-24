<?php

namespace Amarkal\Options\Layout;

/**
 * Implements a web element controller.
 */
class Controller
{
    protected $template;
   
    public function __construct() {
        $this->template = new \Amarkal\Template\Template($this->get_script_path());
    }
   
    public function render( $echo = false )
    {
        $props = get_object_vars($this);
        unset($props['template']);
        $this->template->set_properties(get_object_vars($this));
        
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
}
