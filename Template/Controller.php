<?php

namespace Amarkal\Template;

/**
 * Implements a web element controller.
 */
abstract class Controller
{  
    /**
     * Render the template with the local properties.
     * 
     * @return string                        The rendered template.
     * @throws TemplateNotFoundException    Thrown if the template file can 
     *                                        not found.
     */
    public function render( $echo = false ){
        
        $rendered_image = '';
        
        if( file_exists( $this->get_script_path() ) ) 
        {
            ob_start();
            include( $this->get_script_path() );
            $rendered_image = ob_get_clean();
        } 
        else 
        {
            throw new TemplateNotFoundException( "Error: cannot render HTML, template file not found at " . $this->get_script_path() );
        }
        
        if( !$echo )
        {
            return $rendered_image;
        }
        echo $rendered_image;
    }
    
    /**
     * Get the full path to the template file.
     * 
     * @return string The full path.
     */
    private function get_script_path()
    {
        if( !isset( $this->script_path ) )
        {
            $class_name =  substr( get_called_class() , strrpos( get_called_class(), '\\') + 1);
            $this->script_path = $this->get_dir() . '/' . $class_name . '.phtml';
        }
        return $this->script_path;
    }
    
    /**
     * Get the directory of the file where the derived class is defined.
     * 
     * @return string The directorty to the file.
     */
    protected function get_dir() 
    {
        $rc = new \ReflectionClass(get_class($this));
        return dirname($rc->getFileName());
    }
}