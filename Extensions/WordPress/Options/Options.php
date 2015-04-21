<?php

namespace Amarkal\Extensions\WordPress\Options;

/**
 * Implements a wrapper class for interactions with options 
 * stored in the database.
 */
class Options
{
    /**
     *
     * @var type 
     */
    private $options;
    
    /**
     *
     * @var type 
     */
    private $option_name;
    
    /**
     * 
     * @param type $option_name
     */
    public function __construct( $option_name ) 
    {
        $this->option_name = $option_name;
        $this->options = \get_option( $option_name );
        if( !$this->options )
        {
            $this->options = array();
        }
    }
    
    /**
     * 
     * @param type $name
     * @return type
     */
    public function get( $name = null )
    {
        if( null == $name )
        {
            return $this->options;
        }
        
        if( isset( $this->options[$name] ) )
        {
            return $this->options[$name];
        }
    }
    
    /**
     * Set the value of a key in the options array, and update the database.
     * 
     * @param type $name
     * @param type $value
     */
    public function set( $name, $value )
    {
        $this->options[$name] = $value;
        $this->update();
    }
    
    /**
     * 
     * @param type $options
     */
    public function update( $options = null )
    {
        if( null != $options )
        {
            $this->options = $options;
        }
        \update_option( $this->option_name, $this->options );
    }
    
    /**
     * Checks if the database contains a saved instance of these options.
     * 
     * @return bool true, if a saved instance exists.
     */
    public function exists()
    {
        return $this->options != array();
    }
    
    /**
     * Remove options values from the database.
     */
    public function delete()
    {
        \delete_option( $this->option_name );
    }
}