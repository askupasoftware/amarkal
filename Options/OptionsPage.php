<?php

namespace Amarkal\Options;

class OptionsPage
{
    private $config;
    
    public function __construct( Config $config ) {
        $this->config = $config;
    }
    
    public function register()
    {
        $this->set_admin_page();
    }
    
    public function set_admin_page()
    {
        $self = $this;
        $page = new \Amarkal\Admin\MenuPage(array(
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
        $page->register();
    }
    
    public function footer_credits()
    {
        echo '<span id="footer-thankyou">Created with <a href="#">Amarkal</a> v'.AMARKAL_VERSION.'</span>';
    }
    
    private function render()
    {
        $template = new \Amarkal\Template\Template( __DIR__.'/layout.inc.php', $this->config->get_config() );
        echo $template->render();
        add_filter('admin_footer_text', array( $this, 'footer_credits' ) );
    }
}
