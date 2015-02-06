<?php

namespace Amarkal\UI\Components;

/**
 * Implements a Code Editor UI component.
 * 
 * Parameters:
 * <ul>
 * <li><b>name</b> <i>string</i> The component's name.</li>
 * <li><b>default</b> <i>string</i> The component's default value.</li>
 * <li><b>file</b> <i>string</i> A path to a file to load the content from and save the updated content to. NOTE: This will override the default value.</li>
 * <li><b>disabled</b> <i>boolean</i> True to disabled component. False otherwise.</li>
 * <li><b>language</b> <i>string</i> The programming language to use for the editor. see http://cdnjs.com/libraries/ace/ for available languages.</li>
 * <li><b>theme</b> <i>string</i> The Ace theme to use for the editor. See http://cdnjs.com/libraries/ace/ for available themes.</li>
 * <li><b>filter</b> <i>function</i> Filter callback function, accepts the value as an argument.</li>
 * </ul>
 * 
 * Usage Example:
 * <pre>
 * $field = new Amarkal\UI\Components\Text(array(
 *        'name'            => 'textfield_1',
 *        'default'         => 'Some JavaScript code...',
 *        'file'            => 'path/to/file.php',
 *        'language'        => 'javascript',
 *        'theme'           => 'github',
 *        'disabled'        => false,
 *        'filter'          => function( $v ) { return trim( strip_tags( $v ) ); }
 * ));
 * </pre>
 */
class CodeEditor
extends \Amarkal\UI\AbstractComponent
implements \Amarkal\UI\ValueComponentInterface,
           \Amarkal\UI\DisableableComponentInterface,
           \Amarkal\UI\FilterableComponentInterface
{
    public function __construct( $model )
    {
        parent::__construct( $model );
        if( null != $this->file  )
        {
            if( !file_exists($this->file) )
            {
                throw new \RuntimeException( "The file $this->file could not be found" );
            }
            // Overwrite the default value with the file contents
            $this->default = \file_get_contents( $this->file );
            
            // Update file on save
            if( isset( $_POST[$this->name] ) && !$this->is_disabled() )
            {
                // NOTE: this is the content before the filter is applied! Will need to fix that.
                file_put_contents( $this->file, filter_input( INPUT_POST, $this->name ) );
            }
        }
        
    }
    public function default_model() 
    {
        return array(
            'name'          => '',
            'disabled'      => false,
            'default'       => '',
            'language'      => '',
            'theme'         => 'github',
            'file'          => null,
            'filter'        => function( $v ) { return $v; }
        );
    }
    
    public function required_parameters() 
    {
        return array('name','language');
    }

    /**
     * {@inheritdoc}
     */
    public function get_default_value() 
    {
        return $this->model['default'];
    }

    /**
     * {@inheritdoc}
     */
    public function get_name() 
    {
        return $this->model['name'];
    }

    /**
     * {@inheritdoc}
     */
    public function set_value( $value ) 
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function is_disabled() 
    {
        return $this->model['disabled'];
    }

    /**
     * {@inheritdoc}
     */
    public function apply_filter( $value ) 
    {
        $callable = $this->model['filter'];

        if( is_callable( $callable ) ) 
        {
            return $callable( $value );
        }
    }
    
    private function get_file_contents( $path )
    {
        ob_start();
        include $path;
        return ob_get_clean();
    }
}