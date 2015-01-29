<?php
/**
 * @package Includes
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'KERALIB_TOOLSET_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'keralibToolset_Includes' ) ) {
class keralibToolset_Includes {
	
	protected $pluginManager;
	
	public function __construct($init)
	{
		$this->pluginManager = $init;
		
		if (is_admin()) {
			add_action( 'wp_enqueue_scripts', array( $this, 'register_css_js_admin') );
		} else {
			add_action( 'wp_enqueue_scripts', array( $this, 'register_css_js') );
		}
	}
	
	public function register_css_js()
	{		
		/**
		 * Register scripts and styles for use in tools
		 * When updating tools, update version in register
		 */
		
		// Flexslider
		wp_register_style( 'flexslider', $this->pluginManager->get_pluginUrl().'/tools/flexslider/flexslider.custom.css', array(), '2.2.2' );
		wp_register_script( 'flexslider', $this->pluginManager->get_pluginUrl().'/tools/flexslider/jquery.flexslider-min.js', array('jquery'), '2.2.2' );
		// Masonry
		wp_register_script( 'masonry', $this->pluginManager->get_pluginUrl().'/tools/javascript/masonry.pkgd.min.js', array('jquery'), '3.1.5' );
		// Slidebars
		wp_register_script( 'slidebars', $this->pluginManager->get_pluginUrl().'/tools/javascript/slidebars.js', array('jquery'), '0.10' );
		
		
		// Load default script for admin and non-admin
		wp_enqueue_script( 'script', $this->pluginManager->get_pluginUrl().'/tools/javascript/script.default.js', array('jquery'), $this->pluginManager->get_version(), true );
	}
	
	public function register_css_js_admin()
	{
		//wp_enqueue_script( 'script', $this->pluginManager->get_pluginUrl().'/tools/javascript/script.default.admin.js', array('jquery'), $this->version, true );
	}
}
}
