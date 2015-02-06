<?php

namespace Amarkal\Form;

use Amarkal\UI;

/**
 * Implements a Form controller.
 * 
 * The form object is used to encapsulate UI components and the update/validation 
 * process into a single entity. The template script can be overriden by a child
 * class or by 'Form::set_script_path()' to tailor the form rendering output to
 * the application needs.
 */
class Form extends \Amarkal\Template\Controller
{
    private $components;
    
    public $updater;
    
    private $names;
    
    public function __construct( array $components = array() )
    {
        $this->components = $components;
        $this->updater    = new Updater( $components );
        $this->names = array();
        $this->validate_components($components);
    }
    
    public function get_components()
    {
        return $this->components;
    }
    
    /**
     * Internally used to validate each form component.
     * 
     * @param \Amarkal\UI\AbstractComponent[] $components
     * @throws \Amarkal\Form\DuplicateNameException
     */
    private function validate_components( $components )
    {
        foreach( $components as $component )
        {
            if( ! $component instanceof UI\AbstractComponent )
            {
                throw new WrongTypeException( \gettype( $component ) );
            }
            
            if( $component instanceof UI\Components\Composite )
            {
                $this->validate_components( $component->components );
                continue;
            }
            
            if( $component instanceof UI\ValueComponentInterface && in_array( $component->name, $this->names ) )
            {
                throw new DuplicateNameException( $component->name );
            }
            
            $this->names[] = $component->name;
        }
    }
}