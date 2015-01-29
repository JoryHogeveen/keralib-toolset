<?php
/**
 * @package Module Base
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'KERALIB_TOOLSET_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'KeralibToolset_ModuleSlider' ) ) {
class KeralibToolset_ModuleSlider extends KeralibToolset_ModuleBase
{
	private static $instance;
		
	protected $images;
	
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
		$this->createShortcodes();
		$this->initSlider();
		//$this->loadImages();
		$this->writeSlider();
	}
	
	protected function createShortcodes() 
	{
		$this->enableShortcode('test', 'echoTest', $this);
	}
	
	protected function getShotcodeAtts() 
	{
		
	}
	
	protected function initSlider()
	{
		
	}
	
	public function echoTest($atts) {return 'test23';}
	
	protected function writeSlider()
	{
		
	}
	
	protected function loadImages($object, $fieldname)
	{
		return array_filter(get_post_meta($object->ID, $fieldname));
	}	
	
}
}
