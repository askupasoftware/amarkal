<?php

namespace Amarkal\UI;

abstract class AbstractComponent
extends \Amarkal\Template\Controller
implements ComponentInterface
{
    /**
     * The field's configurations array. The data varies between each field 
     * implementation.
     * 
     * @var mixed[] The configurations array.
     */
    protected $config;
    
    /**
     * @see FieldInterface
     */
    public function required_settings()
    {
        return array();
    }
    
    /**
     * @see FieldInterface
     */
    public function default_settings() 
    {
        return array();
    }
    
    /**
     * Component constructor.
     * 
     * @param     mixed[] $config    The component's configuration.
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
        $this->config = array_merge( $this->default_settings(), $config );
    }
    
    /**
     * Get the path to the template (script).
     * @return string    The path.
     */
    protected function get_script_path() 
    {
        $class_name =  substr( get_called_class() , strrpos( get_called_class(), '\\') + 1);
        return __DIR__ . '/Components/' . $class_name . '/template.phtml';
    }
    
    /**
     * Get field's configuration.
     * 
     * @return mixed[]
     */
    public function get_config()
    {
        return $this->config;
    }
    
    /**
     * Get field settings by name.
     * 
     * @param string $name The settings' parameter name.
     * 
     * @return mixed the settings' parameter value.
     */
    public function __get( $name )
    {
        return $this->config[$name];
    }
    
    /**
     * Set field settings by name.
     * 
     * @param string $name The settings' parameter name.
     * @param mixed $value The value to set.
     * 
     * @return mixed the settings' parameter value.
     */
    public function __set( $name, $value )
    {
        $this->config[$name] = $value;
    }
}