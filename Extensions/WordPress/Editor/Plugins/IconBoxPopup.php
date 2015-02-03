<?php

namespace Amarkal\Extensions\WordPress\Editor\Plugins;

class IconBoxPopup extends \Amarkal\Extensions\WordPress\Editor\AbstractEditorPlugin
{
    private $config;
    
    public function __construct( $config ) 
    {
        foreach( $config['buttons'] as &$item )
        {
            // Use the button's label as the action callback name
            $item['action'] = \Amarkal\Common\Tools::strtoslug($item['label']);
            
            if( isset( $item['callback'] ) )
            {
                // Register an ajax script with the given callback
                add_action( 'wp_ajax_'.$item['action'], $item['callback'] );
                
                // Unset the callback so it doesnt get echoed in the front end
                unset($item['callback']);
            }
            else
            {
                add_action( 'wp_ajax_'.$item['action'], function( $item ) use ( $item ) {
                    $this->render_form( $item['fields'] );
                });
            }
            
            
        }
        $this->config = $config;
    }
    
    public function render_form( $fields )
    {
        $form = new \Amarkal\Form\Form( $fields );
        $form->set_script_path( dirname( __FILE__ ).'/Form.phtml' );
        $form->updater->update();
        $form->render(true);
        die();
    }
    
    public function get_slug() 
    {
        return $this->config['slug'];
    }

    public function get_config() 
    {
        return $this->config;
    }

    public function get_type() 
    {
        return 'IconBoxPopup';
    }

    public function get_row()
    {
        return $this->config['row'];
    }

}
