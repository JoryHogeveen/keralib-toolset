<?php
/**
 * @package ModuleNaw
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'KERALIB_TOOLSET_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'KeralibToolset_ModuleNaw' ) ) {
class KeralibToolset_ModuleNaw extends KeralibToolset_ModuleBase
{
	private static $instance;

	public static function getInstance($pluginManager)
	{
		if (empty(self::$instance)) {
			self::$instance = new self($pluginManager);
		}
		return self::$instance;
	}
	
	protected function initModule() 
	{
		$this->createShortcode();
		$this->podsSetup();
	}
	
	protected function createShortcode() {
		$this->enableShortcode('show_naw', 'write', $this);
	}
	
	public function write($atts) 
	{
		// Pods plugin and "Company Profile" settings page is required
		if (function_exists('pods') && pods('companyprofile')->exists()) {
			if (function_exists('pods_field')) {
				$COMPANY_ADDRESS = pods_field('companyprofile', false, 'address', true);
				$COMPANY_POSTAL_ADDRESS = pods_field('companyprofile', false, 'postal_address', true);
				$COMPANY_CITY = pods_field('companyprofile', false, 'city', true);
				$COMPANY_COUNTRY = pods_field('companyprofile', false, 'country', true);
				$COMPANY_PHONE = pods_field('companyprofile', false, 'phone', true);
				$COMPANY_MOBILE = pods_field('companyprofile', false, 'mobile', true);
				$COMPANY_FAX = pods_field('companyprofile', false, 'fax', true);
				$COMPANY_EMAIL = pods_field('companyprofile', false, 'email', true);
			}
			
			//$companyprofile = pods('companyprofile')->fields;
			//var_dump($companyprofile);
			
			$c = '';
			
			$c .= '<p class="naw-address" itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">';
			if ($COMPANY_ADDRESS || $COMPANY_POSTAL_ADDRESS || $COMPANY_CITY || $COMPANY_COUNTRY) {
				$c .= '<a target="_blank" rel="address" href="http://maps.google.com/?q=';
				if ($COMPANY_ADDRESS) {$c .= $COMPANY_ADDRESS;}
				if ($COMPANY_POSTAL_ADDRESS) {$c .= ', '.$COMPANY_POSTAL_ADDRESS;}
				if ($COMPANY_CITY) {$c .= ', '.$COMPANY_CITY;}
				if ($COMPANY_COUNTRY) {$c .= ', '.$COMPANY_COUNTRY;}
				$c .= '">';
			}
			if ($COMPANY_ADDRESS) {$c .= '<span itemprop="streetAddress">'.$COMPANY_ADDRESS.'</span>';}
			if ($COMPANY_POSTAL_ADDRESS || $COMPANY_CITY) { $c .= '<br />'; }
			if ($COMPANY_POSTAL_ADDRESS) {$c .= '<span itemprop="postalCode">'.$COMPANY_POSTAL_ADDRESS.'</span>';}
			if ($COMPANY_POSTAL_ADDRESS && $COMPANY_CITY) {$c .= ' ';}
			if ($COMPANY_CITY) {$c .= '<span itemprop="addressLocality">'.$COMPANY_CITY.'</span>';}
			if ($COMPANY_COUNTRY != '') {$c .= '<br /><span itemprop="countryName">'.$COMPANY_COUNTRY.'</span>';}
			if ($COMPANY_ADDRESS || $COMPANY_POSTAL_ADDRESS || $COMPANY_CITY || $COMPANY_COUNTRY) { $c .= '</a>'; }
			$c .= '</p>';
			$c .= '<p class="naw-contact">';
			if ($COMPANY_PHONE != '') {$c .= 'T: <span itemprop="telephone" class="bold"><a href="tel:'.$this->formatPhoneLink($COMPANY_PHONE).'">'.$COMPANY_PHONE.'</a></span>';}
			if ($COMPANY_MOBILE != '') {$c .= '<br />M: <span class="bold"><a href="tel:'.$this->formatPhoneLink($COMPANY_MOBILE).'">'.$COMPANY_MOBILE.'</a></span>';}
			if ($COMPANY_FAX != '') {$c .= '<br />F: <span itemprop="faxNumber">'.$COMPANY_FAX.'</span>';}
			if ($COMPANY_EMAIL != '') {$c .= '<br />E: <span itemprop="email"><a href="mailto:'.$COMPANY_EMAIL.'">'.$COMPANY_EMAIL.'</a></span>';}
			$c .= '</p>';
			
			return $c;
		} else {
			return 'Geen NAW gegevens';
		}
	}
	
	protected function formatPhoneLink($l) 
	{
		$l = str_replace(array('+31','(0)'), '', $l);
		$l = str_replace(array('+','-'), '', $l);
		if (substr($l, 0, 1) == '0') {
			$l = substr($l, 1);
		}
		$l = '0031'.filter_var($l, FILTER_SANITIZE_NUMBER_FLOAT);
		
		return $l;
	}
	
	public function podsSetup()
	{
		$this->pluginManager->podsImport('companyprofile', false); // Optional boolean to force re-import the package
		
		$package = file_get_contents($this->pluginManager->get_pluginDir().'/pods/images_fields.tpl');
		$packageArr = json_decode($package, true);
		//var_dump($packageArr['images']);
		if (function_exists('pods_register_field')) {
			$fieldReturn = pods_register_field('page', 'Images', $packageArr['images']);
		}
		add_action( 'pods_meta_groups', array($this, 'podsMetaTest'), 5, 2 );
	}
	
	public function podsMetaTest($type, $name)
	{
		$this->pluginManager->podsAddPostMeta('page', 'Images', 'images_fields', 'advanced', 'high', 'post_type');
	}
		
}
}