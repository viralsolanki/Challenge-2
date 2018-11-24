<?php
/**
 * Class SampleTest
 *
 * @package My_plugin_challenge_2a
 */

/**
 * check if the admin menu is exist
 */
class test_admin_page extends WP_UnitTestCase {

	function test_admin_page_is_loaded() {

			$this->assertTrue( empty( $GLOBALS['admin_page_hooks']['slider_settings'] ) );

			do_action( $GLOBALS['Slider_settings']->slider_settings_menu() );
			$this->assertFalse( empty( $GLOBALS['admin_page_hooks']['slider_settings'] ) );
	}
}
