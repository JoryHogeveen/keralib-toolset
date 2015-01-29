<?php
/**
 * @package Module Default Shortcodes
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'KERALIB_TOOLSET_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'KeralibToolset_ModuleDefaultLogo' ) ) {
class KeralibToolset_ModuleDefaultLogo extends KeralibToolset_ModuleBase
{
	private static $instance;
	
	public static function getInstance($pluginManager)
	{
		if (empty(self::$instance)) {
			self::$instance = new self($pluginManager);
		}
		return self::$instance;
	}
	
	public function __construct($pluginManager)
	{
		parent::__construct($pluginManager);
	}
	
	public function initModule() 
	{
		if (get_template() == 'genesis') {
			/*
			 * 10 = (default) before title-area
			 * 11 = after title-area
			 */
			add_action('genesis_header', array($this, 'customHeaderLogo')); // 5
		}
		$this->enableCustomHeader();
	}
	
	public function enableCustomHeader() 
	{
		// Add support for custom header
		
		$custom_header_defaults = array(
			'default-image'          => '',//get_stylesheet_directory_uri().'/images/logo.png',
			'random-default'         => false,
			'width'                  => '',
			'height'                 => '',
			'flex-height'            => false,
			'flex-width'             => false,
			'default-text-color'     => '',
			'header-text'            => true,
			'uploads'                => true,
			'wp-head-callback'       => '',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		);
		add_theme_support( 'custom-header', $custom_header_defaults );
	}
	
	public function customHeaderLogo()
	{
		$tmp = '';
		
		// (dependent on theme) generate header image with an <img> tag instead of background-image
		if (get_stylesheet() == 'dynamik-gen') {
			$uploadDir = wp_upload_dir();
			$logo = $uploadDir['baseurl'].'/'.get_stylesheet().'/theme/images/'.dynamik_get_design('logo_image');
			$tmp .= '<div class="header-img">';
			$tmp .= '<a href="'.get_bloginfo('url').'" title="'.get_bloginfo('name').' | '.get_bloginfo('description').'">';
			$tmp .= '<img src="'.$logo.'" alt="'.get_bloginfo('name').' | '.get_bloginfo('description').'" />';
			$tmp .= '</a>';
			$tmp .= '</div>';
		} else if (get_custom_header()->url != '') {
			$tmp = '';
			$tmp .= '<div class="header-img">';
			$tmp .= '<a href="'.get_bloginfo('url').'" title="'.get_bloginfo('name').' | '.get_bloginfo('description').'">';
			$tmp .= '<img src="'.get_custom_header()->url.'" alt="'.get_bloginfo('name').' | '.get_bloginfo('description').'" witdh="'.get_custom_header()->width.'" height="'.get_custom_header()->height.'" />';
			$tmp .= '</a>';
			$tmp .= '</div>';
		}
		echo $tmp;
	}

}
}
