<?php
/**
 * Class SampleTest
 *
 * @package My_plugin_challenge_2a
 */

/**
 * tetsts files enqueue
 */
class SampleTest extends WP_UnitTestCase {

	public $test;
	/**
	 * A single example test.
	 */
	/*public function test_sample() {
		// Replace this with some actual testing code.
		$this->assertTrue( true );
	}*/

	function setup() {
		parent::setup();
		//global $Slider_plugin;
		$this->test = $GLOBALS['Slider_plugin'];

	}

	function testPluginInitialized() {

		$this->assertTrue( class_exists( 'Slider_plugin' ) );
		$this->assertFalse( null == $this->test );
	}

	function testEnqueueScripts() {

		$this->assertFalse( wp_script_is( 'jquery' ) );
		$this->assertFalse( wp_script_is( 'slider_js' ) );
		$this->assertFalse( wp_style_is( 'slider_css' ) );

		do_action( $GLOBALS['Slider_plugin']->enqueue() );

		$this->assertTrue( wp_script_is( 'jquery' ) );
		$this->assertTrue( wp_script_is( 'slider_js' ) );
		$this->assertTrue( wp_style_is( 'slider_css' ) );
	}

	function testAdminEnqueueScripts() {

		$this->assertFalse( wp_script_is( 'plugin_js' ) );
		$this->assertFalse( wp_style_is( 'plugin_css' ) );

		do_action( $GLOBALS['Slider_plugin']->admin_enqueue( 'toplevel_page_slider_settings' ) );

		$this->assertTrue( wp_script_is( 'plugin_js' ) );
		$this->assertTrue( wp_style_is( 'plugin_css' ) );
	}

	function test_require_file_exists() {

		$required_file = array( 'my_plugin_activate.php', 'my_plugin_deactivate.php', 'slider_settings_page.php', 'slider_display.php', 'slider_settings_index.php' );
		for ( $i = 0; $i < count( $required_file ); $i++ ) {
			$this->assertTrue( file_exists( plugin_dir_path( dirname( __FILE__ ), 2 ) . 'inc/' . $required_file[ $i ] ), $required_file[ $i ] . 'is not exist' );
		}
	}

	function test_files_are_included() {

		$files         = get_included_files();
		$require_path  = str_replace( '/', '\\', plugin_dir_path( dirname( __FILE__ ), 2 ) );
		$required_file = array( 'my_plugin_activate.php', 'my_plugin_deactivate.php', 'slider_settings_page.php', 'slider_display.php' );

		for ( $i = 0; $i < count( $required_file ); $i++ ) {
			//echo get_template_directory().'/inc/'.$required_file[$i];
			$this->assertTrue( in_array( $require_path . 'inc\\' . $required_file[ $i ], $files ), $required_file[ $i ] . ' file is not included' );
		}
	}

	function test_admin_page_is_loaded() {

		$this->assertTrue( empty( $GLOBALS['admin_page_hooks']['slider_settings'] ) );

		do_action( $GLOBALS['Slider_settings']->slider_settings_menu() );
		$this->assertFalse( empty( $GLOBALS['admin_page_hooks']['slider_settings'] ) );
	}

	function test_database() {

	}
}
