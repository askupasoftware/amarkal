<?php

namespace Amarkal\Extensions\WordPress\Post\UI;

/**
 * Implements a file upload input for meta boxes.
 * 
 * <b>Example Usage</b>
 * <pre>
 * new Amarkal\Extensions\WordPress\Post\UI\UploadFile(array(
 *     'label'             => 'My Field',
 *     'description'       => 'Some descriptive text...',
 *     'name'              => 'myfield',
 *     'callback'          => function( $post_id, $attachment_id ){}
 * ))
 * </pre>
 * retrieval:
 * <pre>
 * $attachment_id = get_post_meta( $post_id, 'field_name', true );
 * // Attachment url
 * wp_get_attachment_url( $this->value );
 * // Attachment path
 * get_attached_file( $attachment_id );
 * </pre>
 */
class Attachment extends \Amarkal\Extensions\WordPress\Post\AbstractMetaBoxField
{   
    public function default_settings()
    {
        return array(
            'label'             => '',
            'description'       => '',
            'name'              => '',
            'callback'          => function( $post_id, $attachment_id ){}
        );
    }

    public function required_settings()
    {
        return array(
            'label',
            'name'
        );
    }
    
    public function get_value( $post )
    {
        return get_post_meta( $post->ID, $this->get_name(), true );
    }
    
    public function save( $post_id )
    {
        // Let WordPress handle the upload.
	$attachment_id = filter_input( INPUT_POST, $this->get_name() );
        update_post_meta( $post_id, $this->get_name(), $attachment_id );
        
        $callable = $this->settings['callback'];
        if( is_callable( $callable ) )
        {
            $callable( $post_id, $attachment_id );
        }
    }
}
