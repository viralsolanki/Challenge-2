<?php
/**
 * Class SampleTest
 *
 * @package My_plugin_challenge_2a
 */

/**
 * tests if the file is attached or not
 */
class test_required_files extends WP_UnitTestCase {

	function test_require_file_exists() {

			$required_file = array( 'my_plugin_activate.php', 'my_plugin_deactivate.php', 'slider_settings_page.php', 'slider_display.php', 'slider_settings_index.php' );
		for ( $i = 0; $i < count( $required_file ); $i++ ) {
			$this->assertTrue( file_exists( plugin_dir_path( dirname( __FILE__ ), 2 ) . 'inc/' . $required_file[ $i ] ), $required_file[ $i ] . 'is not exist' );
		}
	}

	function test_files_are_included() {

			$files         = get_included_files();
			$require_path  = str_replace( '/', '\\', plugin_dir_path( dirname( __FILE__ ), 2 ) );
			$required_file = array( 'my_plugin_activate.php', 'my_plugin_deactivate.php', 'slider_settings_page.php', 'slider_display.php', 'class-add-button-visual-editor.php' );

		for ( $i = 0; $i < count( $required_file ); $i++ ) {
			//echo get_template_directory().'/inc/'.$required_file[$i];
			$this->assertTrue( in_array( $require_path . 'inc\\' . $required_file[ $i ], $files ), $required_file[ $i ] . ' file is not included' );
		}
	}
}
