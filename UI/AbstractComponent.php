<?php

namespace Amarkal\UI;

abstract class AbstractComponent
extends \Amarkal\Template\Controller
implements ComponentInterface
{   
    /**
     * @see FieldInterface
     */
    public function required_parameters()
    {
        return array();
    }
    
    /**
     * Component constructor.
     * 
     * @param     mixed[] $model    The component's model data.
     * @throws    RequiredParameterException If user did not provide a required
     *            parameter as specified in ComponentInterface::required_parameters()
     */
    public function __construct( array $model )
    {
        parent::__construct( $model );
        
        // Check that the required parameters are provided.
        foreach( $this->required_parameters() as $key )
        {
            if ( !$model[$key] )
            {
                throw new RequiredParameterException('The required parameter "'.$key.'" was not provided for '.get_called_class());
            }
        }
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
}