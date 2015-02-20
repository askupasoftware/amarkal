<?php

namespace Amarkal\Assets;

/**
 * Describes an asset instance
 * 
 * Assets are JavaScript/CSS files that describes the application's behavior
 * and appearance. Amarkal uses WordPress' script enqueuing functions
 * to enqueue and print assets. The advantages of using Amarkal over WordPress
 * for loading assets is the easy script localization and the 'facing' parameter
 * that allows to define where the assets are facing (admin/public etc..)
 * 
 * @see Amarkal\Loaders\AssetLoader for example usage.
 */
abstract class AbstractAsset {
    
    /**
     * List of asset parameters.
     * 
     * @see self::get_defaults for a list of available parameters
     * 
     * @var mixed[]    List of asset parameters 
     */
    private $config;
    
    /**
     * Set to true once the asset is registered.
     * 
     * @var boolean True if the asset has been registered. 
     */
    protected $is_registered = false;
    
    /**
     * Constructor
     * 
     * @param mixed[] $config    Asset parameters
     * 
     * @throws \RuntimeException    If a handle was not provided
     */
    public function __construct( array $config )
    {
        
        if( !isset($config['handle']) || '' == $config['handle'] )
        {
            throw new \RuntimeException("Assets MUST have a handle");
        }
        
        if( !isset($config['facing']) || '' == $config['facing'] )
        {
            throw new \RuntimeException("Assets MUST have a \"facing\" attribute");
        }
        
        $config = array_merge( $this->get_defaults(), $config );    
        
        $this->config = $config;
    }
    
    /**
     * Get the default asset parameter values
     * 
     * This function is overriden by the child classes Stylesheet and Script
     * 
     * @return array    List of default parameter values
     */
    public function get_defaults() 
    {
        return array(
            'handle'        => NULL,        // The script handle
            'url'           => false,       // The URL to the file
            'version'       => false,       // The version
            'facing'        => array(),     // Facing [public|admin|admin-specific_page.php|
            'dependencies'  => array()      // List (array) of script handles on which this script depends
        );
    }
    
    /**
     * Get asset parameter
     * 
     * @param    sting    $name    Parameter name
     * @return    mixed            Parameter value
     */
    public function __get( $name ) 
    {
        return $this->config[ $name ];
    }
    
    /**
     * Register this asset to be enqueued later.
     * 
     * Overriden by the child class.
     */
    public abstract function register();
    
    /**
     * Enqueue this asset (if it has been registered).
     * 
     * Overriden by the child class.
     */
    public abstract function enqueue();
}
