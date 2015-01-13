<?php

namespace Amarkal\Extensions\WordPress\Options;

/**
 * Implements an admin options page.
 * 
 * This class can be used to develop options pages for plugins and themes.
 * 
 * Hooks fired on a typical request:
 * ao_init: Fires upon initiation
 * ao_preprocess: Fires before the fields are updated.
 * ao_postprocess: Fires after the fields are updated.
 * ao_before_render: Fires before the options page is rendered.
 * ao_after_render: Fires after the options page is rendered.
 */
class OptionsPage
{
    private $config;
    
    private $fields;
    
    private $old_instance;
    
    private $new_instance;
    
    private $page;
    
    public function __construct( array $config )
    {
        $this->config       = new OptionsConfig( $config );
        $this->fields       = $this->config->get_fields();
        $this->page         = $this->get_page();
        $this->old_instance = $this->get_old_instance();
        $this->new_instance = $this->get_new_instance();
        
        // This is the initial activation, save the defaults to the db
        if(!$this->options_exists())
        {
            $this->reset();
        }
        Notifier::reset();
        $this->do_action('ao_init');
    }
    
    public function register()
    {
        // Only preprocess if this is the currently viewed page
        if( $this->page->get_slug() == filter_input(INPUT_GET, 'page') )
        {
            $this->preprocess();
        }
        
        $this->page->register();
        $this->set_global_variable();
    }
    
    private function get_page()
    {
        if( !isset( $this->page ) )
        {
            $self = $this;
            $page = new \Amarkal\Extensions\WordPress\Admin\AdminPage(array(
                'title'         => $this->config->sidebar_title,
                'icon'          => $this->config->sidebar_icon,
                'class'         => $this->config->sidebar_icon_class,
                'style'         => $this->config->sidebar_icon_style
            ));
            foreach( $this->config->sections as $section )
            {
                $page->add_page(array(
                    'title'         => $section->title,
                    'capability'    => 'manage_options',
                    'content'       => function() use ( $self ) { $self->render(); }
                ));
            }
            $this->page = $page;
        }
        return $this->page;
    }
    
    public function footer_credits()
    {
        echo '<span id="footer-thankyou">Created with <a href="https://github.com/amarkal/amarkal">Amarkal</a> v'.AMARKAL_VERSION.'</span>';
    }
    
    public function render()
    {
        $this->do_action('ao_before_render');
        $layout = new Layout\Layout( $this->config );
        $layout->render(true);
        add_filter('admin_footer_text', array( $this, 'footer_credits' ) );
        $this->do_action('ao_after_render');
    }
    
    private function preprocess()
    {
        $this->do_action('ao_preprocess');
        $this->set_section_slugs();
        $this->update();
        $this->do_action('ao_postprocess');
    }
    
    private function set_section_slugs()
    {
        if( count($this->config->sections) > 1 )
        {
            foreach( $this->config->sections as $section )
            {
                $slug = \Amarkal\Common\Tools::strtoslug( $section->title );
                $section->set_slug( $slug );
            }
        }
        else
        {
            $slug = \Amarkal\Common\Tools::strtoslug( $this->config->settings['admin-title'] );
            $this->config->sections[0]->set_slug( $slug );
        }
    }
    
    private function update()
    {
        $errors = array();
        switch( $this->get_update_type() )
        {
            case 'save':
                $errors = $this->save();
                Notifier::success('Settings saved.');
                break;
            case 'reset-section':
                $section = $this->config->get_section_by_slug($this->get_current_section());
                $this->reset( $section );
                Notifier::success('<strong>'.$section->title.'</strong> section was reset to its default settings.');
                break;
            case 'reset-all':
                $this->reset();
                Notifier::success('All sections were reset to their default settings.');
                break;
            // No submission (simple request)
            default:
                $this->load();
        }
        
        foreach( $this->fields as $field )
        {
            if( $field instanceof ValueFieldInterface )
            {
                // Set field value
                $field->set_value( $this->new_instance[$field->get_name()] );

                // Invalid user input: Set error flag.
                if ( $field instanceof ValidatableFieldInterface &&
                     in_array($field->get_name(), $errors) ) 
                {
                    $field->set_validity( ValidatableFieldInterface::INVALID );
                }
            }
        }
    }
    
    private function load()
    {
        // No update to field values
        $this->new_instance = $this->old_instance;
    }
    
    private function save()
    {
        $updater = new OptionsUpdater(
            $this->fields,
            $this->new_instance,
            $this->old_instance
        );
        
        \update_option(
            $this->page->get_slug(), 
            $this->new_instance = $updater->update()
        );
        
        return $updater->get_error_fields();
    }
    
    private function reset( Section $section = null )
    {
        if( null != $section )
        {
            // Get default values for section
            $new_instance = $this->get_old_instance();
            foreach( $section->fields as $field )
            {
                if( $field instanceof ValueFieldInterface )
                {
                    $new_instance[$field->name] = $field->get_default_value();
                }
            }
            
            // Update back to defaults
            $updater = new OptionsUpdater( $this->fields, $new_instance, $this->get_old_instance() );
        }
        else 
        {
            // No values are passed to the OptionsUpdater so that the default values
            // Will be returned.
            $updater = new OptionsUpdater( $this->fields );
        }
        
        \update_option(
            $this->page->get_slug(), 
            $this->new_instance = $updater->update()
        );
    }
    
    /**
     * Get the current options instance from the database.
     * @return type
     */
    private function get_old_instance()
    {
        $old_instance = \get_option( $this->page->get_slug() );
        if( $old_instance )
        {
            return $old_instance;
        }
        else
        {
            return array();
        }
    }
    
    /**
     * Get the options instance from the $_post variable.
     * @return type
     */
    private function get_new_instance()
    {
        $new_instance = \filter_input_array( INPUT_POST );
        if( null != $new_instance )
        {
            return $new_instance;
        }
        else
        {
            return array();
        }
    }
    
    private function get_update_type()
    {
        return State::get('action');
    }
    
    private function get_current_section()
    {
        return State::get('active_section');
    }
    
    /**
     * Checks if the database contains a saved instance of these options.
     * 
     * @return bool true, if a saved instance exists.
     */
    private function options_exists()
    {
        return $this->get_old_instance() != array();
    }
    
    /**
     * Set a global variable containing the option values to be used throughout
     * the program.
     */
    private function set_global_variable()
    {
        $var_name = "";
        
        if( isset($this->config->settings['global_variable']) )
        {
            $var_name = $this->config->settings['global_variable'];
        }
        else
        {
            $var_name = $this->page->get_slug().'_options';
        }
        
        $GLOBALS[$var_name] = $this->get_old_instance();
    }
    
    private function do_action( $hook )
    {
        // Make sure the action has not been called before
        if( 0 == did_action( $hook ) )
        {
            do_action( $hook );
        }
    }
}
