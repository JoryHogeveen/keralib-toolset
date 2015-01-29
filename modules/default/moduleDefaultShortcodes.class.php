<?php
/**
 * @package Module Default Shortcodes
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'KERALIB_TOOLSET_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'KeralibToolset_ModuleDefaultShortcodes' ) ) {
class KeralibToolset_ModuleDefaultShortcodes extends KeralibToolset_ModuleBase
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
		add_filter('widget_text','do_shortcode');
		add_shortcode('url','get_site_url');

	}
}
}
