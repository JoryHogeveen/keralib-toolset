<?php 

# Configuration defining both a file-based class map, and an array map
return array(	
	KERALIB_TOOLSET_CLASS_PREFIX.'_Loader' 						=> KERALIB_TOOLSET_DIR . 'loaders/loader.class.php',
	KERALIB_TOOLSET_CLASS_PREFIX.'_Database' 					=> KERALIB_TOOLSET_DIR . 'database/database.class.php',
	KERALIB_TOOLSET_CLASS_PREFIX.'_Admin' 						=> KERALIB_TOOLSET_DIR . 'admin/admin.class.php',
	KERALIB_TOOLSET_CLASS_PREFIX.'_Includes' 					=> KERALIB_TOOLSET_DIR . 'includes/includes.class.php',
	KERALIB_TOOLSET_CLASS_PREFIX.'_Module' 						=> KERALIB_TOOLSET_DIR . 'modules/module.class.php',
	
	//Modules
	KERALIB_TOOLSET_CLASS_PREFIX.'_ModuleBase' 					=> KERALIB_TOOLSET_DIR . 'modules/moduleBase.class.php',
	KERALIB_TOOLSET_CLASS_PREFIX.'_ModuleDefaultShortcodes' 	=> KERALIB_TOOLSET_DIR . 'modules/default/moduleDefaultShortcodes.class.php',
	KERALIB_TOOLSET_CLASS_PREFIX.'_ModuleDefaultLogo' 			=> KERALIB_TOOLSET_DIR . 'modules/default/moduleDefaultLogo.class.php',
	KERALIB_TOOLSET_CLASS_PREFIX.'_ModuleDefaultSiteFooter' 	=> KERALIB_TOOLSET_DIR . 'modules/default/moduleDefaultSiteFooter.class.php',
	KERALIB_TOOLSET_CLASS_PREFIX.'_ModuleNaw' 					=> KERALIB_TOOLSET_DIR . 'modules/naw/moduleNaw.class.php',
	KERALIB_TOOLSET_CLASS_PREFIX.'_ModuleSlider' 				=> KERALIB_TOOLSET_DIR . 'modules/sliders/moduleSlider.class.php',
	
	//Pods API 2.x
	//'PodsComponent' 											=> ABSPATH . 'wp-content/plugins/pods/classes/PodsComponent.php',
	'PodsAPI' 													=> ABSPATH . 'wp-content/plugins/pods/classes/PodsAPI.php',
	//'Pods_Migrate_Packages'										=> ABSPATH . 'wp-content/plugins/pods/components/Migrate-Packages/Migrate-Packages.php',
);

