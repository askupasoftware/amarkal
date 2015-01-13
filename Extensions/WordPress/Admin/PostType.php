<?php

namespace Amarkal\Extensions\WordPress\Admin;

/**
 * 
 */
class PostType
{
    private $post_type;
    
    private $singular;
    
    private $plural;
    
    private $args;
    
    public function __construct( $post_type, $args = array(), $singular = '', $plural = '' )
    {
        $this->post_type = $post_type;
        
        if (!$singular)
        {
            $singular = $postType;
        }
        
        if (!$plural)
        {
            $plural = $singular . 's';
        }
    }
    
    public function register()
    {
        register_post_type( 'answer',
            array(
                'labels'        => $this->get_labels(),
                'public'        => true,
                'has_archive'   => true,
                'rewrite'       => array('slug' => 'questions'),
                'hierarchical'  => true,
                'show_ui'       => false, 
            )
        );
    }
    
    private function get_labels()
    {
        return array(
            'name' => $this->plural,
            'singular_name' => $this->singular,
            'add_new' => sprintf(__('Add %s', 'cm-answers'), $this->singular),
            'add_new_item' => sprintf(__('Add New %s', 'cm-answers'), $this->singular),
            'edit_item' => sprintf(__('Edit %s', 'cm-answers'), $this->singular),
            'new_item' => sprintf(__('New %s', 'cm-answers'), $this->singular),
            'all_items' => $this->plural,
            'view_item' => sprintf(__('View %s', 'cm-answers'), $this->singular),
            'search_items' => sprintf(__('Search %s', 'cm-answers'), $this->plural),
            'not_found' => sprintf(__('No %s found', 'cm-answers'), $this->plural),
            'not_found_in_trash' => sprintf(__('No %s found in Trash', 'cm-answers'), $this->plural),
            'menu_name' => $this->plural
        );
    }
}
