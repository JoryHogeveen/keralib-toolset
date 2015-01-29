<?php
/**
 * @package Database
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'KERALIB_TOOLSET_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'KeralibToolset_Database' ) ) {
class KeralibToolset_Database 
{
	protected $pluginManager;
	
	public $dbOptions;

	public function __construct($pluginManager) 
	{
		$this->pluginManager = $pluginManager;
		
		$options[] = $this->pluginManager->get_prefix().'_active_modules';
		
		//add_action('admin_init', array($this, 'prepare_database'));
	}
	
	public function prepare_database() 
	{
		foreach ($dbOptions as $option) {
			if (get_option($option) == false) {
				add_option($option);
			}
		}
	}
		
}
}
