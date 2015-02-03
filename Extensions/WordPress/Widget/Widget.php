<?php

namespace Amarkal\Extensions\WordPress\Widget;

/**
 * Describes an abstract widget instance.
 * 
 * Use this class as a parent class to your widget. WidgetConfig should 
 * the self::widget() function to generate their widget code.
 * 
 * <b>Example Usage:</b>
 * <pre>
 * $widget = new Widget( new WidgetConfig(array(
 *      ...
 * )));
 * $widget->register();
 *</pre>
 * 
 * @see Widget\WidgetConfig For instructions on how to create a configuration object.
 */
class Widget extends \WP_Widget implements WidgetInterface 
{   
    /**
     * The widget's configuration.
     * 
     * @var WidgetConfig 
     */
    private $config;
    
    /**
     * The widget's form class, used to render and update the widget's form.
     * 
     * @var type 
     */
    private $form;
    
    /**
     * Widget constructor
     * 
     * Set the widget's settings and control panel.
     * 
     * @param \Amarkal\Extensions\WordPress\Widget\WidgetConfig $config    The widget configuration
     */
    public function __construct( WidgetConfig $config )
    {
        // Set the widget's parameters
        parent::__construct(
            $config->slug,
            $config->name, // This is shown in the 'widgets' panel
            array(
                'classname'   =>  $config->slug.'-class',
                'description' =>  $config->description
            )
        );
        
        $this->config = $config;
        $this->form   = new \Amarkal\Form\Form( $config->fields );
        $this->form->set_script_path(dirname(__FILE__).'/Form.phtml');
        $this->set_field_names();
        
        // Hooks fired when the Widget is activated and deactivated
        register_activation_hook( __FILE__, array( $this, 'on_activation' ) );
        register_deactivation_hook( __FILE__, array( $this, 'on_deactivation' ) );
    }
    
    /**
     * Register the widget 
     * 
     * Call this function to bind the widget to the 'widgets_init' hook.
     */
    public function register() 
    {
        // A little hack to allow a constructor with arguments
        add_action('widgets_init', function(){
            global $wp_widget_factory;
            $class = $this->config->slug;
            $wp_widget_factory->widgets[$class] = $this;
        });
    }
    
    /**
     * Since the widget's form sets custom names and ids to each field,
     * the original field name must be stored seperately using this function.
     */
    private function set_field_names()
    {
        foreach ( $this->config->fields as $field )
        {
            $field->init_name = $field->name;
        }
    }
    
    /**
     * Generates the administration form for the widget
     * 
     * @param array $instance    The array of keys and 
     *                            values for the widget
     */
    public function form( $instance ) 
    {
        // Reset the names so that the form's update function works properly
        foreach ( $this->config->fields as $field )
        {
            $field->name = $field->init_name;
        }
        // Update values
        $this->form->updater->set_new_instance( $instance );
        $this->form->updater->update();
        
        // Set the widget specific field names and ids
        foreach ( $this->config->fields as $field )
        {
            $field->id   = $this->get_field_id( $field->init_name );
            $field->name = $this->get_field_name( $field->init_name );
        }
        
        // Print the form
        $this->form->render(true);
    }
    
    /**
     * Processes the widget's options to be saved.
     *
     * @param    array    new_instance    The previous instance 
     *                                    of values before the update.
     * @param    array    old_instance    The new instance of 
     *                                    values to be generated via the update.
     */
    public function update( $new_instance, $old_instance ) 
    {   
        $this->form->updater->set_new_instance( $new_instance );
        return $this->form->updater->update( $old_instance );
    }
    
    public function widget( $args, $instance ) 
    {
        $callable = $this->config->callback;
        
        if( is_callable( $callable ) ) 
        {
            $callable( $args, $instance );
        }
    }
    
    /**
     * Delete the widget's cached options.
     */
    public function flush_widget_cache() 
    {
        wp_cache_delete( $this->setup->slug, 'widget' );
    }
    
    /**
     * Get the widget's options from the database.
     * 
     * @return array The widget options.
     */
    public function get_widget_option() 
    {
        return get_option( 'widget_' . $this->setup->slug );
    }
    
    /**
     * Fired when the plugin is activated.
     *
     * @param boolean $network_wide True if WPMU superadmin uses "Network Activate" 
     *                                action, false if WPMU is disabled or plugin 
     *                                is activated on an individual blog.
     */
    public function on_activation( $network_wide )
    {
        // Override in child's class to define activation functionality.
    }

    /**
     * Fired when the plugin is deactivated.
     *
     * @param boolean $network_wide True if WPMU superadmin uses "Network Activate" 
     *                                action, false if WPMU is disabled or plugin 
     *                                is activated on an individual blog.
     */
    public function on_deactivation( $network_wide ) 
    {
        // Override in child's class to define deactivation functionality.
    }
}
