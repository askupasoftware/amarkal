<?php

namespace Amarkal\Widget;

class WidgetSetup {
	
	private $configuration;
	
	public function __construct( array $config ) {
		
		$defaults = array(
			'name'			=> 'My Plugin',
			'description'	=> 'My Plugin\'s description',
			'version'		=> '1.0'
		);
		
		$config = array_merge( $defaults, $config );
		
		$config['slug'] = $this->auto_slug( $config['name'] );
		
		$this->configuration	= $config;
	}
	
	public function __get( $name ) {
		return $this->configuration[ $name ];
	}
	
	/**
	 * Auto-generate a slug from the widget's name
	 */
	private function auto_slug( $name ) {
		return preg_replace( '/[^a-zA-Z0-9]/s', '', strtolower( $name ) );
	}
}
