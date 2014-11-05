<?php

namespace Amarkal\Widget;

/**
 * Implements an abstract component for the widget's control panel.
 * 
 * Components are inputs/buttons/seperators etc... that are the building
 * blocks of a widget control panel.
 * 
 * @see Amarkal\Widget\ControlPanel for example usage.
 */
abstract class AbstractComponent implements ComponentInterface {
    
    /**
     * The component's configurations array. The data varies between
     * each component implementation.
     * 
     * @var mixed[] The configurations array.
     */
    protected $config;
    
    /**
     * The component's HTML template.
     * 
     * @var Amarkal\Template\Template The template .
     */
    protected $template;
    
    /**
     * @see ComponentInterface
     */
    public function required_settings() {
        return array();
    }
    
    /**
     * Component constructor.
     * 
     * @param    mixed[] $config    The component's configuration.
     * @throws    RequiredParameterException If user did not provide a required
     *            parameter as specified in ComponentInterface::required_settings()
     */
    public function __construct( array $config )
    {
        // Check that the required parameters are provided.
        foreach( $this->required_settings() as $key )
        {
            if ( !$config[$key] )
            {
                throw new RequiredParameterException('The required parameter "'.$key.'" was not provided for '.get_called_class());
            }
        }
        
        // Combine defaults with user-provided settings.
        $defaults = $this->default_settings();
        $this->config = array_merge( $defaults, $config );

        // Create a new template and set the configuration
        $this->template = new \Amarkal\Template\Template(
            self::get_script_path(),
            $this->config
        );
    }
    
    /**
     * Get the path to the template (script).
     * @return string    The path.
     */
    static function get_script_path() {
        $class_name =  substr( get_called_class() , strrpos( get_called_class(), '\\') + 1);
        return __DIR__ . '/UI/' . $class_name . '/template.php';
    }
    
    /**
     * Render the component.
     * 
     * Render the component using the associated template.
     * 
     * @return    string            The rendered component (HTML).
     */
    public function render() {
        return $this->template->render();
    }
}
