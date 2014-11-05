<?php

namespace Amarkal\Widget;

/**
 * Describes an abstract widget instance.
 * 
 * Use this class as a parent class to your widget. WidgetConfig should 
 * the self::widget() function to generate their widget code.
 * 
 * @see Widget\ControlPanel For instructions on how to create a control panel
 *      for the widget.
 * @see Widget\WidgetConfig For instructions on how to create a configuration object.
 * 
 * Example Usage:
 * 
 * $widget = new Widget( new WidgetConfig(array(
 *      ...
 * )));
 * $widget->register();
 *
 */
class Widget extends \WP_Widget implements WidgetInterface {
    
    private $config;
    private $cpanel;
    
    /**
     * Widget constructor
     * 
     * Set the widget's settings and control panel.
     * 
     * @param \Amarkal\Widget\WidgetConfig $config    The widget configuration
     */
    public function __construct( WidgetConfig $config )
    {
        $this->config = $config;
        
        // Set the widget's parameters
        parent::__construct(
            $this->config->slug ,
            __( $this->config->name , $this->config->slug ), // This is shown in the 'widgets' panel
            array(
                'classname'        =>    $this->config->slug.'-class' ,
                'description'    =>    __( $this->config->description, $this->config->slug )
            )
        );
        
        // This line must be called after the parent's constructor
        $this->set_control_panel( $config->cpanel );
        
        // Hooks fired when the Widget is activated and deactivated
        register_activation_hook( __FILE__, array( $this, 'on_activation' ) );
        register_deactivation_hook( __FILE__, array( $this, 'on_deactivation' ) );
    }
    
    /**
     * Register the widget 
     * 
     * Call this function to bind the widget to the 'widgets_init' hook.
     */
    public function register() {
        // A little hack to allow a constructor with arguments
        add_action('widgets_init', function(){
            global $wp_widget_factory;
            $class = $this->config->slug;
            $wp_widget_factory->widgets[$class] = new Widget( $this->config );
        });
    }
    
    /**
     * Set a control panel for the widget.
     * 
     * @param \Amarkal\Widget\ControlPanel $panel The control panel to set.
     */
    public function set_control_panel( ControlPanel $panel )
    {
        $this->cpanel = $panel;
    }
    
    /**
     * Generates the administration form for the widget
     * 
     * @param array $instance    The array of keys and 
     *                            values for the widget
     */
    public function form( $instance ) {
        
        // Field id's and names must be generated as a part 
        // of the form function process.
        foreach( $this->cpanel->get_components() as $component ) {
            if ( $component instanceof ValueComponentInterface ) {
                $name = $component->get_name();
                $component->set_id_attribute( $this->get_field_id( $name ) );
                $component->set_name_attribute( $this->get_field_name( $name ) );
            }
        }
        
        // Merge defaults with new values
        $instance = array_merge( 
            $this->cpanel->get_defaults(), 
            (array) $instance 
        );
        
        // Render the form
        $this->cpanel->render( $instance );
    }
    
    /**
     * Processes the widget's options to be saved.
     *
     * @param    array    new_instance    The previous instance 
     *                                    of values before the update.
     * @param    array    old_instance    The new instance of 
     *                                    values to be generated via the update.
     */
    public function update( $new_instance, $old_instance ) {
        
        $updater = new WidgetUpdater(
            $this->cpanel->get_components(),
            $new_instance,
            $old_instance
        );
        
        return  $updater->update();
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
    public function on_activation( $network_wide ) {
        // Override in child's class to define activation functionality.
    }

    /**
     * Fired when the plugin is deactivated.
     *
     * @param boolean $network_wide True if WPMU superadmin uses "Network Activate" 
     *                                action, false if WPMU is disabled or plugin 
     *                                is activated on an individual blog.
     */
    public function on_deactivation( $network_wide ) {
        // Override in child's class to define deactivation functionality.
    }

    public function widget( $args, $instance ) {
        $callable = $this->config->callback;
        
        if( is_callable( $callable ) ) {
            $callable( $args, $instance );
        }
    }

}