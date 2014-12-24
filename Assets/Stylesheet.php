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
            'media'        => 'all' 
        );
    }
    
    /**
     * Register the stylesheet.
     */
    public function register()
    {
        wp_register_style(
            $this->handle,
            $this->url,
            $this->dependencies,
            $this->version,
            $this->media
        );
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
            wp_enqueue_style( $this->handle );
        }
        else
        {
            throw new \RuntimeException("Assets must be registered before enqueuing.");
        }
    }
}
