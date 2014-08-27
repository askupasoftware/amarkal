<?php

namespace Amarkal\Loaders;

/**
 * Implements a script and stylesheet loader
 * 
 * Use this class to easily enqueue assets (scripts and stylesheets) for your 
 * project. Using the AssetLoader, you can load scripts and stylesheets as a 
 * front-end (public) or admin facing asset. Scripts can also be localized using 
 * the AssetLoader.
 * 
 * @see \Amarkal\Assets\AbstractAsset::get_defaults for available parameters
 * 
 * Example Usage:
 * 
 * $al = new AssetLoader();
 * 
 * // Bulk asset registering
 * $al->register_assets(array(
 *        new \Amarkal\Assets\Stylesheet(array(
 *            'handle'    => 'myStyle',
 *            'url'        => 'http://www.website.com/path/to/style.css',
 *            'facing'    => 'public'
 *        )),
 *        new \Amarkal\Assets\Script(array(
 *            'handle'    => 'myScript',
 *            'url'        => 'http://www.website.com/path/to/script.js',
 *            'facing'    => 'admin'
 *        ))
 * ));
 * 
 * // Single asset registering with localized data
 * $al->register_asset(
 *        new \Amarkal\Assets\Script(array(
 *            'handle'    => 'myScript',
 *            'url'       => 'http://www.website.com/path/to/script.js',
 *            'facing'    => 'public',
 *            'localize   => array(
 *                'name'    => 'myVar'                    // The name of the variable holding the data
 *                'data'    => array('One', 'Two', 'Three')    // The data to be stored in the array
 *            )
 *        ))
 * );
 * 
 * $al->enqueue();
 * 
 */
class AssetLoader {
    
    /**
     * The list of assets
     * @var mixed    Assets array 
     */
    private $assets;
    
    /**
     * Bulk registering of assets
     * 
     * @param mixed[] $assets The list of assets to enqueue
     */
    public function register_assets( array $assets ) {
        foreach ( $assets as $asset ) {
            $this->register_asset( $asset );
        }
    }
    
    /**
     * Register a single asset
     * 
     * @param \Amarkal\Assets\AbstractAsset $new_asset The asset to enqueue
     * @throws DuplicateAssetException    If the a duplicated asset handle exists
     */
    public function register_asset( \Amarkal\Assets\AbstractAsset $new_asset )
    {
        if( NULL == $this->assets ) {
            $this->assets = array();
            $this->assets[] = $new_asset;
        }
        else {
            foreach( $this->assets as $asset ) {
                if( $asset->handle == $new_asset->handle && get_class($asset) == get_class($new_asset) ) {
                    throw new DuplicateAssetException("An asset with the handle {$new_asset->handle} already exists");
                }
            }
            $this->assets[] = $new_asset;
        }
    }
    
    /**
     * Enqueues all registered assets.
     */
    public function enqueue() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_styles' ) );
    }
    
    /**
     * Enqueue the registered assets of type $type.
     * 
     * Internally used to enqueue assets by type (Stylesheet/Script)
     * and where it is facing (public/admin)
     * 
     * @param string    $facing    public/admin facing
     * @param string    $type    Script/Stylesheet
     */
    public function enqueue_assets( $facing, $type ) {

        $type = 'Amarkal\\Assets\\'.$type;
        
        foreach ( $this->assets as $asset ) {
            if ( $asset instanceof $type && $asset->facing == $facing ) {
                $asset->register();
                $asset->enqueue();
            }
        }
    }
    
    /**
     * Enqueue admin facing scripts
     */
    public function enqueue_admin_scripts() {
        $this->enqueue_assets( 'admin', 'Script' );
    }
    
    /**
     * Enqueue admin facing styles
     */
    public function enqueue_admin_styles() {
        $this->enqueue_assets( 'admin', 'Stylesheet' );
    }
    
    /**
     * Enqueue public facing scripts
     */
    public function enqueue_public_scripts() {
        $this->enqueue_assets( 'public', 'Script' );
    }
    
    /**
     * Enqueue public facing scripts
     */
    public function enqueue_public_styles() {
        $this->enqueue_assets( 'public', 'Stylesheet' );
    }
    
}
