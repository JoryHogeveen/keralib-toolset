<?php
/**
 * @package Module Base
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'KERALIB_TOOLSET_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'KeralibToolset_ModuleBase' ) ) {
class KeralibToolset_ModuleBase
{
	private static $instance;
	
	protected $pluginManager;
	
	protected $moduleDir;
	protected $moduleUrl;
	
	public static function getInstance($pluginManager)
	{
		if (empty(self::$instance)) {
			self::$instance = new self($pluginManager);
		}
		return self::$instance;
	}

	public function __construct($pluginManager) 
	{
		$this->pluginManager = $pluginManager;
		$this->moduleDir = $this->pluginManager->get_pluginDir().'/modules/';
		$this->moduleUrl = $this->pluginManager->get_pluginUrl().'/modules';
		
		$this->initModule();
	}
	
	protected function initModule() 
	{
		return;
	}
	
	protected function enableShortcode($shortcode, $function, $class = KERALIB_TOOLSET_CLASS_PREFIX) 
	{
		add_shortcode($shortcode, array($class, $function));
		add_shortcode('keralib_'.$shortcode, array($class, $function));
	}
}
}
