<?php

namespace Amarkal\Extensions\WordPress\Editor\Plugins;

/**
 * Implements a popup with icon boxes plugin
 */
class FormPopup extends \Amarkal\Extensions\WordPress\Editor\AbstractEditorPlugin
{
    private $config;
    
    /**
     * Icon Box Popup plugin
     * 
     * <b>Parameters</b>
     * <ul>
     * <li><b>slug</b> <i>string</i> The plugin's slug, must be unique.</li>
     * <li><b>text</b> <i>string</i> (optional) The button's label.</li>
     * <li><b>icon</b> <i>string</i> A CSS class for the button's icon.</li>
     * <li><b>title</b> <i>string</i> The popup title.</li>
     * <li><b>width</b> <i>number</i> The popup width.</li>
     * <li><b>height</b> <i>number</i> The popup height.</li>
     * <li><b>row</b> <i>number</i> The row in which the button will be placed.</li>
     * <li><b>template</b> <i>string</i> The template representing the code to be inserted. Placeholders are specified using the syntax <% placeholder_name %></li>
     * <li><b>selector</b> <i>array</i> A list of css selectors representing the nodes for which the TinyMCE button will change its state to "pressed".</li>
     * <li><b>fields</b> <i>array</i> A list of Amarkal UI components that will be rendered in the popup. Names should correspond to the placeholders in the 'template' parameter.</li>
     * </ul>
     * 
     * <b>Example usage:</b>
     * <pre>
     * Editor\Editor::add_button( new Editor\Plugins\FormPopup(array(
     *     'img'       => 'url/to/icon.gif',
     *     'label'     => 'Icon Box Label',
     *     'title'     => 'Popup Title',
     *     'width'     => 600,
     *     'height'    => 450,
     *     'template'  => '[shortcodetag attr1="<% placeholder1 %>" attr2="<% placeholder2 %>" /]',
     *     'selector'  => array('div','#my-id'),
     *     'callback'  => function() {},
     *     'fields'    => array(
     *          ...
     * ));
     * </pre>
     * 
     * @param type $config
     */
    public function __construct( $config ) 
    {
        add_action( 'wp_ajax_'.$config['slug'], function( $config ) use ( $config ) {
            $this->render_form( $config['fields'] );
        });
        
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
        return 'FormPopup';
    }

    public function get_row()
    {
        return $this->config['row'];
    }

}