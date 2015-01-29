<?php
/**
 * @package Module
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'KERALIB_TOOLSET_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'KeralibToolset_Module' ) ) {
class KeralibToolset_Module 
{
	protected $pluginManager;
	
	public $modules = array();
	public $activeModules = array(
		//'ModuleBase' => 1,
		'ModuleDefaultShortcodes' => 1,
		'ModuleDefaultLogo' => 1,
		'ModuleDefaultSiteFooter' => 1
	);
	
	private $regModules = array(); // Module registry
	
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
		
		$this->loadModules();
	}
	
	protected function loadModules() 
	{
		$this->activeModules = array_merge($this->activeModules, get_option( $this->pluginManager->get_prefix().'_active_modules' ));
		foreach ($this->activeModules as $module => $active) {
			if ($active == '1') {
				$class = KERALIB_TOOLSET_CLASS_PREFIX.'_'.$module;
				$this->modules[$module] = $class::getInstance($this->pluginManager);
			}
		}
		unset($reg);
	}

}
}
