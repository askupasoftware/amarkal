<?php

namespace Amarkal\UI\Components;

/**
 * Implements a WordPress attachment UI component.
 * 
 * <b>Note:</b> This field can only be used in a WordPress environment.
 */
class WP_Attachment
extends \Amarkal\UI\AbstractComponent
implements \Amarkal\UI\ValueComponentInterface,
           \Amarkal\UI\DisableableComponentInterface
{
    /**
     * Create a new attachment UI component.
     * 
     * @param array $model
     * <ul>
     * <li><b>name</b> <i>string</i> The component's name.</li>
     * <li><b>default</b> <i>string</i> Comma seperated list of values that will be checked by default.</li>
     * <li><b>disabled</b> <i>boolean</i> True to disabled component. False otherwise.</li>
     * <li><b>multi</b> <i>boolean</i> True to allow multiple attachments.</li>
     * <li><b>uploader_title</b> <i>string</i> The media uploader popup title.</li>
     * <li><b>uploader_button_text</b> <i>string</i> The media uploader button text.</li>
     * </ul>
     * 
     * <b>Usage Example:</b>
     * <pre>
     * $field = new Checkbox(array(
     *        'name'          => 'my_checkbox',
     *        'disabled'      => false,
     *        'default'       => 'val1',
     *        'multi'         => false,
     *        'uploader_title' => 'Insert Media',
     *        'uploader_button_text' => 'Insert'
     * ));
     * </pre>
     */
    public function __construct( array $model ) 
    {
        parent::__construct( $model );
        add_action( 'admin_enqueue_scripts', function(){ wp_enqueue_media(); });
    }
    
    public function default_model() 
    {
        return array(
            'name'       => '',
            'disabled'   => false,
            'default'    => '',
            'multi'      => false,
            'uploader_title' => 'Insert Media',
            'uploader_button_text' => 'Insert'
        );
    }
    
    public function required_parameters()
    {
        return array('name');
    }

    /**
     * {@inheritdoc}
     */
    public function get_default_value() 
    {
        return $this->model['default'];
    }

    /**
     * {@inheritdoc}
     */
    public function get_name()
    {
        return $this->model['name'];
    }

    /**
     * {@inheritdoc}
     */
    public function set_value( $value ) 
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function is_disabled() 
    {
        return $this->model['disabled'];
    }
}