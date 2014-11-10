<?php

namespace Amarkal\UI;

/**
 * Implements an abstract UI component.
 */
abstract class AbstractComponent 
extends \Amarkal\Template\Controller 
implements ComponentInterface 
{
    /**
     * The component's configurations array. The data varies between
     * each component's implementation.
     * 
     * @var mixed[] The configurations array.
     */
    protected $config;

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
    }
    
    /**
     * Get the configuration settings value.
     * @param string $name the configuration array index
     * @return mixed
     */
    public function __get( $name ) 
    {
        return $this->config[$name];
    }
    
    /**
     * 
     * @param type $name
     * @param type $value
     */
    public function __set( $name, $value ) 
    {
        $this->config[$name] = $value;
    }
}
