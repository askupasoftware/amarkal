<?php

namespace Amarkal\Template;

/**
 * A Light templating engine.
 * 
 * Example usage:
 * 
 * $template = new Amarkal\Template\Template( 
 *     __DIR__.'/template.php',
 *     array(
 *         'title' => "Hello World!"
 *     )    
 * );
 * // Or
 * $template = new Amarkal\Template\Template( __DIR__.'/template.php' );
 * $template->title = "Hello World!";
 * // Render
 * echo $template->render();
 */
class Template {
    
    /**
     * Path to the template file.
     * 
     * @var string The path.
     */
    private $script_path;
    
    /**
     * The template's properties array.
     * 
     * @var mixed[] The properties array.
     */
    public    $properties;
    
    /**
     * Constructor.
     * 
     * @param type    $script_path    The path to the template.
     * @param array $properties        (Optional) The templates properties as
     *                                an associative array.
     */
    public function __construct( $script_path, array $properties = array() ) 
    {
        $this->set_script_path( $script_path );
        $this->set_properties( $properties );
    }
    
    /**
     * Set the templates script path.
     * 
     * @param type $script_path The template's path.
     */
    public function set_script_path( $script_path ){
        $this->script_path = $script_path;
    }
    
    /**
     * Set the template's properties.
     * 
     * @param array $properties The properties.
     */
    public function set_properties( array $properties ) 
    {
        $this->properties = $properties;
    }
    
    /**
     * Render the template with the local properties.
     * 
     * @return string                        The rendered template.
     * @throws TemplateNotFoundException    Thrown if the template file can 
     *                                        not found.
     */
    public function render(){
        
        $rendered_image = '';
        
        if( file_exists( $this->script_path ) ) 
        {
            ob_start();
            include( $this->script_path );
            $rendered_image = ob_get_clean();
        } 
        else throw new TemplateNotFoundException("The following file could not be found: " . $this->script_path);
        
        return $rendered_image;
    }
    
    /**
     * Returns the rendered template string.
     * 
     * @return Rendered template as HTML.
     */
    public function __toString() {
        try {
            return $this->render();
        } catch (\Exception $e) {
            return "ERROR: " . $e;
        }
    }
    
    /**
     * Set a local property.
     * 
     * @param type $key        The property's key.
     * @param type $value    The property's value.
     */
    public function __set( $key, $value ) 
    {
        $this->properties[$key] = $value;
    }
    
    /**
     * Get a local property.
     * 
     * @param string $key The property's index.
     */
    public function __get( $key ) 
    {
        if( !isset( $this->properties[$key] ) )
        {
            return null;
        }
        return $this->properties[$key];
    }
    
    /**
     * Check if a property exists and that it is not null.
     * 
     * @param    string    $prop    The name of the property.
     * @return    bool            True, if exists.
     */
    public function has_property( $prop ) 
    {
        return isset( $this->properties[$prop] );
    }
}
