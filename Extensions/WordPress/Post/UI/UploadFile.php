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
 *     'callback'          => function( $post_id, $file ){},
 *     'file_types'        => array() // Leave blank to support all types
 * ))
 * </pre>
 */
class UploadFile extends \Amarkal\Extensions\WordPress\Post\AbstractMetaBoxField
{
    public function __construct(array $settings = array()) 
    {
        parent::__construct($settings);
        
        // Change the form to accept file uploads
        add_action('post_edit_form_tag', function() {
            echo ' enctype="multipart/form-data"';
        });
    }
    
    public function default_settings()
    {
        return array(
            'label'             => '',
            'description'       => '',
            'name'              => '',
            'callback'          => function( $post_id, $file ){},
            'file_types'        => array()      // Leave blank to support all
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
    
    public function is_supported( $file_path )
    {
        $file_type = wp_check_filetype( basename( $file_path ) );
        return ( array() == $this->settings['file_types'] || in_array( $file_type['ext'], $this->settings['file_types'] ) );
    }
    
    public function upload_file( $file )
    {
        // Use the WordPress API to upload the file
        $upload = wp_upload_bits( $file['name'], null, file_get_contents( $file['tmp_name'] ) );

        if(isset( $upload['error']) && $upload['error'] != 0 ) 
        {
            wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
        } 
        
        return $upload;
    }
    
    public function save( $post_id )
    {
        // Make sure the file array isn't empty
        if(!empty($_FILES[$this->settings['name']]['name'])) 
        {
            $file = $_FILES[$this->settings['name']];
            
            // Check if the type is supported. If not, throw an error.
            if( $this->is_supported( $file['name'] ) )
            {
                // Delete previous file, if exists
                $prev_file = get_post_meta( $post_id, $this->settings['name'], true);
                if( '' != $prev_file && file_exists( $prev_file['file'] ) )
                {
                    unlink( $prev_file['file'] );
                }
                
                $upload = $this->upload_file($file);
                add_post_meta( $post_id, $this->settings['name'], $upload);
                update_post_meta( $post_id, $this->settings['name'], $upload);
                
                $callable = $this->settings['callback'];
                if( is_callable( $callable ) )
                {
                    $callable( $post_id, $upload );
                }
            } 
            else 
            {
                wp_die("The file type that you've uploaded is not supported.");
            }
        }
    }
}