<?php

namespace Amarkal\Assets;

/**
 * Implements a stylesheet (CSS) type asset
 * 
 * @see Amarkal\Loaders\AssetLoader for example usage.
 */
class Stylesheet extends AbstractAsset { 
	
	/**
	 * {@inheritdoc}
	 */
	public function get_defaults() {
		return parent::get_defaults() + array(
			/**
			 * String specifying the media for which this 
			 * stylesheet has been defined. Examples: 'all', 
			 * 'screen', 'handheld', 'print'. 
			 * See http://www.w3.org/TR/CSS2/media.html#media-types
			 * for the full range of valid CSS-media-types.
			 */
			'media'		=> 'all' 
		);
	}
	
	/**
	 * Register the stylesheet.
	 */
	public function register()
    {
		$this->is_registered = true;
	}
    
    /**
     * Enqueue the stylesheet
     * @throws \RuntimeException if the asset has not been registered.
     */
    public function enqueue()
    {
        if( $this->is_registered )
        {
            add_action( 'wp_print_styles', array( $this, 'print_style'), 8 );
        }
        else
        {
            throw new \RuntimeException("Assets must be registered before enqueuing.");
        }
    }
    
    /**
     * Hooks to the wp_print_styles action
     */
    public function print_style()
    {
        wp_register_style(
			$this->handle,
			$this->url,
			$this->dependencies,
			$this->version,
			$this->media
		);
        wp_enqueue_style( $this->handle );
    }
}
