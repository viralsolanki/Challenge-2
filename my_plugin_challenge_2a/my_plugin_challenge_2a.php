<?php
/**
 * Class for rtcamp_challenge_2a
 *
 * @package rtcamp_challenge_2a
 */

/**
	Plugin Name: challenge_2a Slider
	Description: This plugin is for create a custom slider in your theme
	Version: 1.0.0
	Author: Viral Solanki
	License: GPLv2 or latter
	Text Domain: slider
 */

defined( 'ABSPATH' ) || die( "sorry u can't access this directory" );
/**
 * Class for enqueue scriptsand styles
 */
class Slider_Plugin {

	/**
	 * Call all the methods in the class
	 */
	public function register() {

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

	}

	/**
	 * Enqueue required scripts and styles for admin side
	 *
	 * @param string $hook contains the slug of current page.
	 */
	public function admin_enqueue( $hook ) {
		if ( 'toplevel_page_slider_settings' !== $hook ) {
			return;
		}
		// jquery file.
		wp_enqueue_media();

		wp_enqueue_style( 'plugin_css', plugins_url( '/enqueue/style.css', __FILE__ ), array(), '1.0' );
		wp_enqueue_script( 'plugin_js', plugins_url( '/enqueue/plugin_jquery.js', __FILE__ ), array( 'jquery' ), '1.0', true );
	}

	/**
	 * Enqueue required scripts and styles for admin side
	 */
	public function enqueue() {
		wp_deregister_script( 'jquery' );

		wp_register_script( 'jquery', plugins_url( '/enqueue/jquery.js', __FILE__ ), '', true, '' );
		wp_enqueue_script( 'jquery' );

		wp_enqueue_style( 'slider_css', plugins_url( '/enqueue/slider_style.css', __FILE__ ), array(), '1.0' );
		wp_enqueue_script( 'slider_js', plugins_url( '/enqueue/slider_jquery.js', __FILE__ ), array( 'jquery' ), '1.0', true );

	}
}


require_once plugin_dir_path( __FILE__ ) . '/inc/class-slider-plugin-activate.php';
register_activation_hook( __FILE__, array( 'Slider_Plugin_Activate', 'activate' ) );

require_once plugin_dir_path( __FILE__ ) . '/inc/class-slider-plugin-deactivate.php';
register_deactivation_hook( __FILE__, array( 'Slider_plugin_Deactivate', 'deactivate' ) );


require_once plugin_dir_path( __FILE__ ) . '/inc/class-slider-settings-page.php';
require_once plugin_dir_path( __FILE__ ) . '/inc/class-slider-display.php';


if ( class_exists( 'Slider_Plugin' ) ) {

	$GLOBALS['Slider_plugin'] = new Slider_Plugin();
	$GLOBALS['Slider_plugin']->register();

}


if ( class_exists( 'Slider_Settings_Page' ) ) {

	$GLOBALS['Slider_settings'] = new Slider_Settings_Page();
	$GLOBALS['Slider_settings']->register();

}

if ( class_exists( 'Slider_Display' ) ) {

	$slider_display = new Slider_Display();
	$slider_display->register();
}
