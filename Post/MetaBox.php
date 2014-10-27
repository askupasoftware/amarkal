<?php

namespace Amarkal\Post;

/**
 * Implements a post meta settings box.
 */
class MetaBox {
    
    /**
     * @var mixed[] Meta box settings. 
     */
    private $settings;
    
    /**
     * Add a meta box to the administrative interface of a post.
     * 
     * @see http://codex.wordpress.org/Function_Reference/add_meta_box
     * 
     * @param $settings mixed[] 
     * <ul>
     * <li>title (string) (required) Title of the edit screen section, visible to user</li>
     * <li>post_types (array) (required) The type of Write screen on which to show the edit screen section ('post', 'page', 'dashboard', 'link', 'attachment' or 'custom_post_type' where custom_post_type is the custom post type slug)</li>
     * <li>id (string) (optional) HTML 'id' attribute of the edit screen section. Also used for the nonce. Auto generated if none provided.</li>
     * <li>context (string) (optional) The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side')</li>
     * <li>priority (string) (optional) The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')</li>
     * </ul>
     */
    public function __construct( array $settings = array() )
    {
        foreach( $this->required_settings() as $param )
        {
            if( !array_key_exists( $param, $settings ) )
            {
                throw new RequiredParameterException( 'Error: missing required parameter "'.$param.'"' );
            }
        }
        
        if( !isset( $settings['id'] ) )
        {
            $settings['id'] = \Amarkal\Common\Tools::strtoslug($settings['title']);
        }
        
        $this->settings = array_merge( $this->default_settings(), $settings );
    }
    
    /**
     * Constructor default settings.
     * @return mixed[] The default settings.
     */
    private function default_settings()
    {
        return array(
            'id'            => null,
            'title'         => null,
            'post_types'    => array(),
            'context'       => 'advanced',
            'priority'      => 'default'
        );
    }
    
    /**
     * Constructor required settings.
     * @return mixed[] The required settings.
     */
    private function required_settings()
    {
        return array(
            'title',
            'post_types'
        );
    }
    
    public function nonce_name()
    {
        return $this->settings['id'].'_nonce';
    }
    
    public function action_name()
    {
        return $this->settings['id'].'_action';
    }
    
    /**
     * Register the meta box for existing and new posts.
     */
    public function register()
    {
        add_action( 'load-post.php', array( $this, 'hook' ) );
        add_action( 'load-post-new.php', array( $this, 'hook' ) );
    }
    
    /**
     * Hook meta box generating and saving action.
     */
    public function hook()
    {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save' ) );
    }

    /**
     * Adds the meta box container.
     */
    public function add_meta_boxes( $post_type )
    {    
        if ( in_array( $post_type, $this->settings['post_types'] )) {
            add_meta_box(
                $this->settings['id'],
                $this->settings['title'],
                array( $this, 'render' ),
                $post_type,
                $this->settings['context'],
                $this->settings['priority']
            );
        }
    }

    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save( $post_id ) {
    
        /**
         * A note on security:
         * 
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times. since metaboxes can 
         * be removed - by having a nonce field in only one metabox there is no 
         * guarantee the nonce will be there. By placing a nonce field in each 
         * metabox you can check if data from that metabox has been sent 
         * (and is actually from where you think it is) prior to processing any data.
         * @see http://wordpress.stackexchange.com/a/49460/25959
         */

        // Check if our nonce is set.
        if ( ! isset( $_POST[$this->nonce_name()] ) )
        {
            return $post_id;
        }

        // Verify that the nonce is valid.
        $nonce = filter_input( INPUT_POST, $this->nonce_name() );
        if ( ! wp_verify_nonce( $nonce, $this->action_name() ) )
        {
            return $post_id;
        }
        
        // Bail if this is an autosave (nothing has been submitted)
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        {
            return $post_id;
        }
        
        // Check the user's permissions.
        $post_type = filter_input( INPUT_POST, 'post_type' );
        if( in_array( $post_type, $this->settings['post_types'] ) )
        {
            // NOTE: this might not work for custom post types, unless Amarkal
            // is used to register them (custom post types might have labels different 
            // than 'edit_{post_type}'
            $capability = 'edit_'.$post_type;
            if ( !current_user_can( $capability, $post_id ) )
            {
                return $post_id;
            }
        }
        else
        {
            return $post_id;
        }

        // OK, it is safe to process data.
        foreach( $this->settings['fields'] as $field )
        {
            $field->save( $post_id );
        }
    }

    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render( $post ) {
    
        // Add an nonce field so we can check for it later.
        wp_nonce_field( $this->action_name(), $this->nonce_name() );

        foreach( $this->settings['fields'] as $field )
        {
            $field->render( $post );
        }
    }
}
