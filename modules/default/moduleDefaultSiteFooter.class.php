<?php
/**
 * @package Module Default Shortcodes
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'KERALIB_TOOLSET_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'KeralibToolset_ModuleDefaultSiteFooter' ) ) {
class KeralibToolset_ModuleDefaultSiteFooter extends KeralibToolset_ModuleBase
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
			remove_action( 'genesis_footer', 'genesis_do_footer' );
			add_action( 'genesis_footer', array($this, 'customFooter') );
		}
	}
	
	public function customFooter()
	{
		$tmp = '';
		
		// Pods plugin and settings options is required to show older copyright date and web-author in footer
		if (function_exists('pods_field')) {
			$COPYRIGHT_DATE = pods_field('websitedata', false, 'copyright_date', true);
			$AUTHOR = pods_field('websitedata', false, 'website_author', true);
		}
		genesis_widget_area('footer-bottom', array('before'=>'', 'after'=>''));
		$separator = ' <span class="separator">|</span> ';
		$date = '';
		$description = '';
		$author = '';
		$designer = '';
		
		if (isset($COPYRIGHT_DATE) && $COPYRIGHT_DATE != '' && date('Y') != $COPYRIGHT_DATE) { $date = $COPYRIGHT_DATE.'-'.date('Y'); } else { $date = date('Y'); }
		//if ((date('Y') == COPYRIGHT_DATE) || (COPYRIGHT_DATE == '')) { $date = date('Y'); } else { $date = COPYRIGHT_DATE.'-'.date('Y'); }
		
		if (get_bloginfo('description') != '') {$description = $separator.get_bloginfo('description');}
		
		if (isset($AUTHOR) && $AUTHOR != '') {$author = $separator.$AUTHOR;}
		
		$designer = $separator.'<a href="http://www.keraweb.nl" title="Webdesign, hosting &amp; zoekmachine-optimalisatie" target="_blank"><span style="display:none;">Webdesign, hosting &amp; zoekmachine-optimalisatie: </span>Keraweb</a>';
		
		echo '<div class="widget footer bottom copyright"><p>&copy; '.$date.$separator.get_bloginfo('name').$description.$author.$designer.'</p></div>';
	}

}
}
