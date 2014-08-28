<?php

namespace Amarkal\Options;

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
        
        $this->set_global_variable();
    }
    
    public function register()
    {
        $this->preprocess();
        $this->page->register();
    }
    
    private function get_page()
    {
        if( !isset( $this->page ) )
        {
            $self = $this;
            $page = new \Amarkal\Admin\AdminPage(array(
                'title'         => $this->config->settings['admin-title'],
                'icon'          => $this->config->settings['admin-icon']
            ));
            foreach( $this->config->options['sections'] as $section )
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
        $template = new \Amarkal\Template\Template( __DIR__.'/layout.inc.php', $this->config->get_config() );
        echo $template->render();
        add_filter('admin_footer_text', array( $this, 'footer_credits' ) );
    }
    
    private function preprocess()
    {
        $this->set_section_slugs();
        $this->activate_section( $this->get_current_section() );
        $this->update();
    }
    
    private function set_section_slugs()
    {
        $first = true;
        foreach( $this->config->options['sections'] as $section )
        {
            if( $first )
            {
                $first = false;
                $slug = \Amarkal\Common\Tools::strtoslug( $this->config->settings['admin-title'] );
                $section->set_slug( $slug );
            }
            else
            {
                $slug = \Amarkal\Common\Tools::strtoslug( $section->title );
                $section->set_slug( $slug );
            }
        }
    }
    
    private function activate_section( $slug )
    {
        foreach( $this->config->options['sections'] as $section )
        {
            if( $section->get_slug() == $slug )
            {
                $section->set_current_section();
                break;
            }
        }
    }
    
    private function update()
    {
        $errors = array();
        switch( $this->get_update_type() )
        {
            case 'save':
                $errors = $this->save();
                break;
            case 'reset-section':
                $this->reset( $this->get_current_section() );
                break;
            case 'reset-all':
                $this->reset();
                break;
            // No submission (simple request)
            default:
                $this->load();
        }
        
        foreach( $this->fields as $field )
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
    
    private function reset( $section = null )
    {
        // No values are passed to the OptionsUpdater so that the default values
        // Will be returned.
        $updater = new OptionsUpdater( $this->fields );
        
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
        return \filter_input( INPUT_POST, 'submit' );
    }
    
    private function get_current_section()
    {
        return \filter_input( INPUT_GET, 'page' );
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
        $GLOBALS[$this->page->get_slug().'_options'] = $this->get_old_instance();
    }
}
