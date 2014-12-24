<?php

namespace Amarkal\Assets;

/**
 * Implements a script (JS) type asset
 * 
 * @see Amarkal\Loaders\AssetLoader for example usage.
 */
class Script extends AbstractAsset {
    
    /**
     * {@inheritdoc}
     */
    public function get_defaults() {
        return parent::get_defaults() + array(
            /**
             * Array of data to localize with the 
             * script using wp_localize_script().
             * Value must be an array with keys 'name' and 'data':
             * array(
             *        'name'    => 'myVar',
             *        'data'    => array( 'One', 'Two', 'Three )
             * )
             */
            'localize' => false,
            
            /**
             * If this parameter is true, the script 
             * is placed before the </body> end tag.
             */
            'footer' => false
        );
    }
    
    /**
     * Enqueue the script and localize the data as needed
     */
    public function register()
    {
        wp_register_script(
            $this->handle,
            $this->url,
            $this->dependencies,
            $this->version,
            $this->footer
        );

        // Localize the script as needed
        if( !empty( $this->localize['data'] ) && !empty( $this->localize['data'] ) ) {
            wp_localize_script(
                $this->handle,
                $this->localize['name'],
                $this->localize['data']
            );
        }
        $this->is_registered = true;
    }

    /**
     * Enqueue the script.
     * @throws \RuntimeException if the script has not been registered.
     */
    public function enqueue()
    {
        if( $this->is_registered )
        {
            wp_enqueue_script( $this->handle );
        }
        else
        {
            throw new \RuntimeException("Assets must be registered before enqueuing.");
        }
    }
}
