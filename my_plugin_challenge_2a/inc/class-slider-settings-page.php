<?php
/**
 * Class for create slider settings page
 *
 * @package rtcamp_challenge_2a
 */

/**
 * Class for create menu sections & fields for slider settings page
 */
class Slider_Settings_Page {

	/**
	 * Get plugin name
	 *
	 * @var string $plugin_name for store plugin name
	 */
	public $plugin_name;

		/**
		 * Get plugin name as $plugin_name
		 */
	public function __construct() {

		$this->plugin_name = plugin_basename( dirname( __FILE__, 2 ) ) . '/my_plugin_challenge_2a.php';

	}

	/**
	 * Public function for call methods & add settings link to plugin
	 */
	public function register() {

		add_action( 'admin_menu', array( $this, 'slider_settings_menu' ) );
		add_filter( "plugin_action_links_$this->plugin_name", array( $this, 'plugin_links' ) );

	}

	/**
	 * Public function for register menu
	 */
	public function slider_settings_menu() {

		// Generate Slider admin page.
		add_menu_page( 'Image Slider', 'Slider_Settings', 'manage_options', 'slider_settings', array( $this, 'slider_index' ), 'dashicons-edit', 110 );

		// Active slider settings.
		add_action( 'admin_init', array( $this, 'slider_custom_settings' ) );

	}

	/**
	 * Public function for create slider index
	 */
	public function slider_index() {

		require_once plugin_dir_path( __FILE__ ) . 'slider-settings-index.php';

	}

	/**
	 * Public function for add links to plugin
	 *
	 * @param link $links link to th settings page.
	 */
	public function plugin_links( $links ) {
		$slider_setting_link = '<a href="admin.php?page=slider_settings">Settings</a>';
		array_push( $links, $slider_setting_link );
		return $links;

	}

	/**
	 * Public function for resgister settings sections & fields
	 */
	public function slider_custom_settings() {

		register_setting( 'slider-image-group', 'images_bar' );
		add_settings_section( 'slider-options', 'Slider Settings', array( $this, 'slider_options_section' ), 'slider_settings' );
		add_settings_field( 'slider_field', 'Click to perform action', array( $this, 'slider_setting_field' ), 'slider_settings', 'slider-options' );
	}

	/**
	 * Public function for add caption
	 */
	public function slider_options_section() {

		echo 'Add Images to your slider';

	}

	/**
	 * Public function for create input fields
	 */
	public function slider_setting_field() {
		$images = get_option( 'images_bar' );

		echo '<input type="button" class="button button-primary plugin-button" value="Insert Images" id="upload-button" />
		<input type="button" class="button button-primary plugin-button" value="Remove Images" id="remove-button" style="display:none;"/>
		<input type="button" class="button button-primary plugin-button" value="Change index" id="change-index" style=""/>
		<input type="button" class="button button-primary plugin-button" value="Select & remove" id="selectandremove" style=""/>
		<input type="button" class="button button-primary plugin-button" value="Remove All Images" id="remove-all-button" style=""/>
		<input type="hidden" id="Slider-images" name="images_bar" value=' . esc_attr( $images ) . ' >';

	}

}
