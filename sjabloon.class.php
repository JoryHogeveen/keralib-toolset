<?php
/**
 * @package Sjabloon
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'KERALIB_TOOLSET_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'KeralibToolset_Sjabloon' ) ) {
class KeralibToolset_Sjabloon 
{
	protected $pluginManager;

	public function __construct($pluginManager) 
	{
		$this->pluginManager = $pluginManager;

	}
		
}
}
