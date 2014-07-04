<?php

namespace Amarkal\Core;

class Dashboard {
	public static function init() {
        $config = include( 'config.inc.php' );
        $page = new \Amarkal\Admin\MenuPage(array(
            'title'         => 'Amarkal',
            'icon'          => AMARKAL_ASSETS_URL.$config['dashboard']['icon-image'],
            'class'         => $config['dashboard']['icon-class'],
            'style'         => array(
                'padding-top' => '7px'
            )
        ));
        $page->add_page(array(
            'title'         => 'Amarkal 1', // Not requiered for a single page menu
            'capability'    => 'manage_options',
            'content'       => function(){include('dashboard.inc.php');}
        ));
        $page->register();
	}
}