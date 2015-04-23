<?php

namespace Amarkal\Template;

/**
 * Implements a web element controller.
 */
abstract class Controller
{  
    /**
     * An associative array holding the model to be used by this controller
     * @var array 
     */
    protected $model;
    
    /**
     * Create a new web element controller
     * @param array $model
     */
    public function __construct( array $model = array() ) 
    {
        $this->model = array_merge( $this->default_model(), $model );
    }
    
    /**
     * Get model parameter value by name.
     * 
     * @param string $name The parameter's name.
     * 
     * @return mixed the parameter's value.
     */
    public function __get( $name ) 
    {
        if( isset( $this->model[$name] ) )
        {
            return $this->model[$name];
        }
    }
    
    /**
     * Set model parameter by name.
     * 
     * @param string $name The parameter's name.
     * @param mixed $value The value to set.
     * 
     * @return mixed the settings' parameter value.
     */
    public function __set( $name, $value )
    {
        $this->model[$name] = $value;
    }
    
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
    protected function get_script_path()
    {
        if( null == $this->script_path )
        {
            $class_name =  substr( get_called_class() , strrpos( get_called_class(), '\\') + 1);
            $this->script_path = $this->get_dir() . '/' . $class_name . '.phtml';
        }
        return $this->script_path;
    }
    
    /**
     * Set a custom script path.
     * 
     * @param string $path
     */
    public function set_script_path( $path )
    {
        $this->script_path = $path;
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
    
    /**
     * This method should be overriden by child class
     * @return array
     */
    public function default_model()
    {
        return array();
    }
}