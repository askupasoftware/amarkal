<?php

namespace Amarkal\Extensions\WordPress\Widget;

/** 
 * Describes a Widget instance
 */
interface WidgetInterface {
    
    /** 
     * Echo the widget content.
     *
     * Subclasses should over-ride this function to generate their widget code.
     *
     * @param array $args        Display arguments including before_title, 
     *                            after_title, before_widget, and after_widget.
     * @param array $instance    The settings for the particular instance of the 
     *                            widget
     */
    public function widget( $args, $instance );
    
    /** 
     * Update a particular instance.
     *
     * This function should check that $new_instance is set correctly.
     * The newly calculated value of $instance should be returned.
     * If "false" is returned, the instance won't be saved/updated.
     *
     * @param    array $new_instance        New settings for this instance as input 
     *                                    by the user via form()
     * @param    array $old_instance        Old settings for this instance
     * @return    array                    Settings to save or bool false to cancel 
     *                                    saving
     */
    public function update( $new_instance, $old_instance );
    
    /** 
     * Echo the settings update form (i.e. the contorl panel)
     * 
     * @param array $instance Current settings
     */
    public function form( $instance );
}
