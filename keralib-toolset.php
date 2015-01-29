<?php
/**
 * Plugin Name: Keraweb library - Toolset
 * Description: Add various tools to WordPress
 * Plugin URI:  http://www.keraweb.nl
 * Version:     0.1
 * Author:      Jory Hogeveen
 * Author URI:  http://www.keraweb.nl
 * Text Domain: keralib-toolset
 * #Domain Path: #/languages
 * #Network:     #true
 */
 
! defined( 'ABSPATH' ) and exit;

define('KERALIB_TOOLSET_DEBUG', false);

if (KERALIB_TOOLSET_DEBUG == true) {
	//if (is_user_logged_in()) {
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', E_ALL);
	//}
}

define('KERALIB_TOOLSET_VERSION', 0.1);
define('KERALIB_TOOLSET_DIR', plugin_dir_path( __FILE__ ));
define('KERALIB_TOOLSET_SLUG', 'keralib-toolset');
define('KERALIB_TOOLSET_CLASS_PREFIX', 'KeralibToolset');

require_once (plugin_dir_path( __FILE__ ) . 'loaders/ClassMapAutoloader.php');

function initKeralibToolset() {
	$keralibToolset = new KeralibToolset();
	//$keralibToolset->run();
}
add_action('init','initKeralibToolset');//initKeralibToolset();

class KeralibToolset 
{
	public $enabledDependencies = array();
	public $adminNotices = array();
		
	protected $loaderManager; // Loader main class
	protected $databaseManager; // Includes main class
	protected $moduleManager; // Includes main class
	protected $adminManager; // Admin main class
	protected $includesManager; // Includes main class
	
	private $pluginSlug;
	private $pluginDir;
	private $pluginUrl;
	private $prefix;

	private $version;
	
	public function __construct(  ) //$version = KERALIB_TOOLSET_VERSION
	{
		$this->version = KERALIB_TOOLSET_VERSION;
		$this->pluginSlug = KERALIB_TOOLSET_SLUG;
		$this->pluginDir = plugin_dir_path( __FILE__ );
		$this->pluginUrl = plugins_url().'/'.$this->pluginSlug;
		$this->prefix = 'keralib-toolset';
		
		$classLoader = ClassMapAutoloader::getInstance();
		$classLoader->registerAutoloadMaps(array($this->pluginDir.'loaders/autoload_classmap.php'));
		$classLoader->register();
		
		$this->load_dependencies();
		$this->load_toolset();
		$this->define_admin_hooks();
	}
	
	private function load_dependencies() 
	{
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if (is_plugin_active('pods/init.php')) {
			$enabledDependencies[] = 'pods';
		}
		if (get_template() == 'genesis') {
			$enabledDependencies[] = 'genesis';
		}
		if (get_stylesheet() == 'dynamik-gen') {
			$enabledDependencies[] = 'dynamik-gen';
		}
		
		//add_action( 'admin_notices', 'add_notices' );
	}
	
	private function load_toolset() 
	{
		$this->databaseManager = new KeralibToolset_Database($this);
		$this->moduleManager = new KeralibToolset_Module($this);
		
		if (is_admin()) {
			$this->adminManager = new KeralibToolset_Admin($this);
		}
		
		$this->includesManager = new KeralibToolset_Includes($this);
		$this->loaderManager = new KeralibToolset_Loader($this);
	}
	
	private function define_admin_hooks() 
	{
	}
	
	public static function echoTest($atts) {return 'test2';}
	
	public function run() 
	{
		//$this->loader->run();
	}
	
	public function add_notice($type, $content) 
	{
		$adminNotices[] = '<div class="'.$type.'"><p>'.$content.'</p></div>';
	}
		
	public function podsImport($packagename, $replace = false)
	{
		$package = file_get_contents($this->get_pluginDir().'/pods/'.$packagename.'.tpl');
		if (function_exists('pods_api')) {
			// Load PodsAPI and import required package if it does not exists
			$PodsAPI = pods_api();//PodsAPI::init();
			if (($PodsAPI->pod_exists('companyprofile') == false) || ($replace == true)) {
				$return = $PodsAPI->import_package($package, $replace);
			}
		}
	}
	
	public function podsAddPostMeta($types, $name, $packagename, $context = 'normal', $priority = 'default', $type = null)
	{
		$package = file_get_contents($this->get_pluginDir().'/pods/'.$packagename.'.tpl');
		$packageArr = json_decode($package, true);
		if (function_exists('pods_group_add')) {
			$return = pods_group_add( $types, $name, $packageArr, $context, $priority, $type ); 
		}
		/*if (function_exists('pods_register_field')) {
			$return = pods_register_field($types, $name, $packageArr);
		}*/
		//var_dump($fieldReturn);
	}
	
	public function get_version() 			{ return $this->version; }
	public function get_pluginSlug() 		{ return $this->pluginSlug; }
	public function get_pluginDir() 		{ return $this->pluginDir; }
	public function get_pluginUrl() 		{ return $this->pluginUrl; }
	public function get_prefix() 			{ return $this->prefix; }
	
}