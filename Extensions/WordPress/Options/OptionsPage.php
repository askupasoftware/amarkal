<?php

namespace Amarkal\Extensions\WordPress\Options;

/**
 * Implements an admin options page.
 * 
 * This class is a wrapper class to the \Amarkal\Extensions\WordPress\Admin\AdminPage
 * class and can be used to develop options pages for plugins and themes.
 * 
 * Hooks fired on a typical request:
 * <ul>
 * <li><b>afw_options_init</b>: Fires upon initiation.</li>
 * <li><b>afw_options_pre_process</b>: Fires before the fields are updated.</li>
 * <li><b>afw_options_post_process</b>: Fires after the fields are updated.</li>
 * <li><b>afw_options_pre_render</b>: Fires before the options page is rendered.</li>
 * <li><b>afw_options_post_render</b>: Fires after the options page is rendered.</li>
 * </ul>
 * 
 * @see OptionsConfig for configuration instructions.
 * @see OptionsConfigDefaults for a sample configuration and more info.
 */
class OptionsPage
{
    /**
     * Options page configuration.
     * @var OptionsConfig
     */
    private $config;
    
    /**
     * Options page components array.
     * @var array 
     */
    private $components;
    
    /**
     * Updater object. Used to update component values.
     * @var Amarkal\Form\Updater
     */
    private $updater;
    
    /**
     * WordPress admin page.
     * @var AdminPage 
     */
    private $page;
    
    /**
     * Create a new options page.
     * 
     * @see OptionsConfig
     * @param array $config
     */
    public function __construct( array $config )
    {
        $this->config       = new OptionsConfig( $config );
        $this->components   = $this->config->get_fields();
        $this->page         = $this->create_page();
        $this->updater      = new \Amarkal\Form\Updater($this->components);
        Notifier::reset();
        State::set('errors', array());
    }
    
    /**
     * Register the options page.
     */
    public function register()
    {
        // This is the initial activation, save the defaults to the db
        if(!$this->options_exists())
        {
            $this->reset();
        }
        
        // Only preprocess if this is the currently viewed page
        if( $this->page->get_slug() == filter_input(INPUT_GET, 'page') )
        {
            $this->preprocess();
        }
        
        $this->page->register();
        $this->set_global_variable();
        $this->do_action('afw_options_init');
    }
    
    /**
     * Create a new AdminPage.
     * 
     * @return AdminPage
     */
    private function create_page()
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
        return $page;
    }
    
    /**
     * Internally used to render the page.
     * Called by AdminPage to generate the admin page's content.
     */
    private function render()
    {
        $this->do_action('afw_options_pre_render');
        $layout = new Layout\Layout( $this->config );
        $layout->render(true);
        add_filter('admin_footer_text', array( __CLASS__, 'footer_credits' ) );
        $this->do_action('afw_options_post_render');
    }
    
    /**
     * Internally used to update the options page's components.
     */
    private function preprocess()
    {
        $this->do_action('afw_options_pre_process');
        $this->update();
        $this->do_action('afw_options_post_process');
    }
    
    /**
     * Save/reset/load component values.
     */
    private function update()
    {
        $errors = array();
        switch( State::get('action') )
        {
            case 'save':
                $errors = $this->save();
                Notifier::success('Settings saved.');
                break;
            case 'reset-section':
                $section = $this->config->get_section_by_slug(State::get('active_section'));
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
        
        $this->set_errors($errors);
    }
    
    /**
     * Set the state with the given errors.
     * 
     * @param array $errors
     */
    private function set_errors( $errors )
    {
        if( count( $errors ) == 0 )
        {
            return;
        }
        
        $errors_array = array();
        foreach( $this->config->get_sections() as $section )
        {
            foreach( $section->get_fields() as $component )
            {
                if( $component instanceof \Amarkal\UI\ValidatableComponentInterface && $errors[$component->get_name()] )
                {
                    $errors_array[] = array(
                        'section'=> $section->get_slug(),
                        'message'=> $errors[$component->get_name()]
                    );
                }
            }
        }
        State::set('errors', $errors_array);
    }
    
    private function load()
    {
        $this->updater->update($this->get_old_instance());
    }
    
    private function save()
    {
        \update_option(
            $this->page->get_slug(), 
            $this->updater->update($this->get_old_instance())
        );
        
        return $this->updater->get_errors();
    }
    
    private function reset( Section $section = null )
    {
        if( null != $section )
        {
            // Get default values for section
            $names = array();
            foreach( $section->fields as $field )
            {
                if( $field instanceof ValueFieldInterface )
                {
                    $names[] = $field->get_name();
                }
            }
            \update_option(
                $this->page->get_slug(), 
                $this->updater->reset( $names )
            );
        }
        else 
        {
            // No values are passed to the OptionsUpdater so that the default values
            // Will be returned.
            \update_option(
                $this->page->get_slug(), 
                $this->updater->reset()
            );
        }
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
    
    /**
     * Renders Amarkal's credits on the options page footer.
     */
    static function footer_credits()
    {
        echo '<span id="footer-thankyou">Created with <a href="https://github.com/amarkal/amarkal">Amarkal</a> v'.AMARKAL_VERSION.'</span>';
    }
}