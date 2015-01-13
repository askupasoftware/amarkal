<?php

namespace Amarkal\Extensions\WordPress\Post\UI;

/**
 * Implements a text input for meta boxes.
 * 
 * <b>Example Usage</b>
 * <pre>
 * new Amarkal\Extensions\WordPress\Post\UI\Text(array(
 *     'label'             => 'My Field',
 *     'description'       => 'Some descriptive text...',
 *     'name'              => 'myfield',
 *     'callback'          => function( $post_id, $value ){}
 * ))
 * </pre>
 */
class Text extends \Amarkal\Extensions\WordPress\Post\AbstractMetaBoxField 
{
    /**
     * {@inheritdoc}
     */
    public function default_settings()
    {
        return array(
            'label'         => '',
            'description'   => '',
            'name'          => '',
            'callback'      => function( $post_id, $value ) {}
        );
    }

    /**
     * {@inheritdoc}
     */
    public function required_settings()
    {
        return array(
            'label',
            'name'
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function get_value( $post )
    {
        return get_post_meta( $post->ID, $this->get_name(), true );
    }
    
    public function save($post_id) 
    {
        // Sanitize the user input.
        $value = sanitize_text_field( filter_input( INPUT_POST, $this->get_name() ) );

        // Update the meta field.
        update_post_meta( $post_id, $this->get_name(), $value );
        
        // Callback
        $callable = $this->settings['callback'];
        if(is_callable( $callable ) )
        {
            $callable( $post_id, $value );
        }
    }
}
