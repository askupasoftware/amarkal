<?php

namespace Amarkal\Extensions\WordPress\Editor;

/**
 * 
 */
class FormCallback extends AbstractCallback
{
    private $fields;
    
    /**
     * Create a new popup callback.
     * 
     * @param array $fields A list of Amarkal UI components that will be rendered in the popup.
     */
    public function __construct( $fields ) 
    {
        $this->fields = $fields;
    }
    
    public function register( $slug )
    {
        $fields = $this->fields;
        add_action( 'wp_ajax_'.$slug, function() use ( $fields ) {
            $this->render_form( $fields );
        });
    }
    
    public function render_form( array $fields = array() )
    {
        $form = new \Amarkal\Form\Form( $fields );
        $form->set_script_path( dirname( __FILE__ ).'/FormCallback.phtml' );
        $form->updater->update();
        $form->render(true);
        die();
    }
}
