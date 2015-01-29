<?php
/**
 * @package Admin
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'KERALIB_TOOLSET_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'KeralibToolset_Admin' ) ) {
class KeralibToolset_Admin 
{
	private static $instance;
	
	protected $pluginManager;
	
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options = array();
	
	private $fields = array();

	public static function getInstance($pluginManager)
	{
		if (empty(self::$instance)) {
			self::$instance = new self($pluginManager);
		}
		return self::$instance;
	}
	
    /**
     * Start up
     */
    public function __construct($pluginManager)
    {
		$this->pluginManager = $pluginManager;
		
		$this->fields['checkbox'] = array();
		$this->fields['checkbox'][] = 'ModuleNaw';
		$this->fields['checkbox'][] = 'ModuleSliderImage';
		$this->fields['checkbox'][] = 'ModuleSliderBackground';
		$this->fields['checkbox'][] = 'ModuleSliderContentImage';
		$this->fields['checkbox'][] = 'ModuleGallery';
		//$this->fields['checkbox'][] = 'module_image-slider';
		
        add_action( 'admin_menu', array( $this, 'add_admin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_admin_page()
    {
        add_menu_page(
            'Keralib Toolset', 
            'Keralib', 
            'manage_options', 
            $this->pluginManager->get_prefix(), 
            array( $this, 'create_admin_page' ),
			plugins_url( 'images/icon-16.png', __FILE__ )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options[$this->pluginManager->get_prefix().'_active_modules'] = get_option( $this->pluginManager->get_prefix().'_active_modules' );
        ?>
        <div class="wrap">
            <?php //screen_icon(); ?>
            <h2>Keralib Toolset</h2>           
            <form method="post" action="options.php">
            <?php
				print_r($this->options[$this->pluginManager->get_prefix().'_active_modules']);
                // This prints out all hidden setting fields
                settings_fields( $this->pluginManager->get_prefix().'_group_active_modules' );   
                do_settings_sections( $this->pluginManager->get_prefix() );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            $this->pluginManager->get_prefix().'_group_active_modules', // Option group
            $this->pluginManager->get_prefix().'_active_modules', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            $this->pluginManager->get_prefix().'_select_active_modules', // ID
            'Select modules', // Title
            array( $this, 'print_section_info' ), // Callback
            $this->pluginManager->get_prefix() // Page
        );  

        /*add_settings_field(
            'module_page-slider', // ID
            '<label for="module_page-slider">Slider in pagina</label', // Title 
            array( $this, 'print_checkbox' ), // Callback
            $this->pluginManager->get_prefix(), // Page
            $this->pluginManager->get_prefix().'_select_active_modules', // Section
			array('option_name' => $this->pluginManager->get_prefix().'_active_modules', 'field_name' => 'module_page-slider')
        );      

        add_settings_field(
            'module_image-slider', 
            '<label for="module_image-slider">Algemene slider (header)</label>', 
            array( $this, 'print_checkbox' ), 
            $this->pluginManager->get_prefix(), 
            $this->pluginManager->get_prefix().'_select_active_modules',
			array('option_name' => $this->pluginManager->get_prefix().'_active_modules', 'field_name' => 'module_image-slider')
        );  */
		
		foreach ($this->fields['checkbox'] as $field_name) {
			add_settings_field(
				$field_name, 
				'<label for="'.$field_name.'">'.$field_name.'</label>', 
				array( $this, 'print_checkbox' ), 
				$this->pluginManager->get_prefix(), 
				$this->pluginManager->get_prefix().'_select_active_modules',
				array('option_name' => $this->pluginManager->get_prefix().'_active_modules' ,'field_name' => $field_name)
			);  
		}
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input ) 
	{
        $new_input = array();
		foreach ($this->fields['checkbox'] as $field_name) {
			//if (sanitize_text_field( $input[$field_name] ) == '1') {
				$new_input[$field_name] = sanitize_text_field( $input[$field_name] );
			//}
		}
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        //print 'Enter your settings below:';
    }	
	
    public function print_checkbox($arg)
    {	
		//$checked = (isset( $this->options[$this->pluginManager->get_prefix().'_active_modules'][$arg['field_name']] ) && $this->options[$this->pluginManager->get_prefix().'_active_modules'][$arg['field_name']] == true) ? 'checked' : '';
        echo '<input type="checkbox" id="'.$arg['field_name'].'" name="'.$arg['option_name'].'['.$arg['field_name'].']" value="1"'.checked( 1 == $this->options[$arg['option_name']][$arg['field_name']], true, false ).' />';
    }

    public function print_textinput($arg)
    {
        printf(
            '<input type="text" id="'.$arg['field_name'].'" name="'.$arg['option_name'].'['.$arg['field_name'].']" value="%s" />',
            isset( $this->options[$arg['option_name']][$arg['field_name']] ) ? esc_attr( $this->options[$arg['option_name']][$arg['field_name']]) : '1'
        );
    }

	
}}