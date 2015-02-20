<?php

namespace Amarkal\Extensions\WordPress\Editor\Plugins;

/**
 * Implements a popup with icon boxes plugin
 */
class IconBoxPopup extends \Amarkal\Extensions\WordPress\Editor\AbstractEditorPlugin
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
     * <li><b>title</b> <i>string</i> The button's title (shown in tooltip).</li>
     * <li><b>row</b> <i>number</i> The row in which the button will be placed.</li>
     * <li><b>max_cols</b> <i>number</i> The maximum number of icon boxes per line.</li>
     * <li><b>buttons</b> <i>array</i> A list of buttons for the box icons, each of which having the following structure:
     * <ul>
     * <li><b>img</b> <i>string</i> Url to the icon image.</li>
     * <li><b>label</b> <i>string</i> The icon box label.</li>
     * <li><b>title</b> <i>string</i> The popup title.</li>
     * <li><b>width</b> <i>number</i> The popup width.</li>
     * <li><b>height</b> <i>number</i> The popup height.</li>
     * <li><b>template</b> <i>string</i> The template representing the code to be inserted. Placeholders are specified using the syntax <% placeholder_name %></li>
     * <li><b>callback</b> <i>function</i> A function that will be used as the render callback. Only applicable if the 'fields' parameter is not specified.</li>
     * <li><b>fields</b> <i>array</i> A list of Amarkal UI components that will be rendered in the popup. Names should correspond to the placeholders in the 'template' parameter.</li>
     * </ul>
     * </li>
     * </ul>
     * 
     * <b>Example usage:</b>
     * <pre>
     * Editor\Editor::add_button( new Editor\Plugins\IconBoxPopup(array(
     *  'slug'      => 'my_button',
     *  'text'      => null,
     *  'icon'      => 'fa fa-code',
     *  'title'     => 'This is the button\'s title',
     *  'row'       => 1,
     *  'max_cols'  => 3,
     *  'buttons'   => array(
     *      array(
     *          'img'       => 'url/to/icon.gif',
     *          'label'     => 'Icon Box Label',
     *          'title'     => 'Popup Title',
     *          'width'     => 600,
     *          'height'    => 450,
     *          'template'  => '[shortcodetag attr1="<% placeholder1 %>" attr2="<% placeholder2 %>" /]',
     *          'callback'  => function() {},
     *          'fields'    => array(
     *              ...
     *          )
     *      )
     *  )
     * ));
     * </pre>
     * 
     * @param type $config
     */
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