<?php
/**
 * Class SampleTest
 *
 * @package My_plugin_challenge_2a
 */

/**
 * Sample test case.
 */
class test_scripts extends WP_UnitTestCase {

	function testEnqueueScripts(){
		
		$this->assertFalse( wp_script_is( 'jquery' ));
		$this->assertFalse( wp_script_is( 'slider_js' ));
		$this->assertFalse( wp_style_is( 'slider_css' ));
		
		do_action($GLOBALS['Slider_plugin']->enqueue());
		
		$this->assertTrue( wp_script_is( 'jquery' ));
		$this->assertTrue( wp_script_is( 'slider_js' ));
		$this->assertTrue( wp_style_is( 'slider_css' ));
	}
	
	function testAdminEnqueueScripts(){
		
		$this->assertFalse( wp_script_is( 'plugin_js' ));
		$this->assertFalse( wp_style_is( 'plugin_css' ));
		
		do_action($GLOBALS['Slider_plugin']->admin_enqueue( 'toplevel_page_slider_settings' ));
		
		$this->assertTrue( wp_script_is( 'plugin_js' ));
		$this->assertTrue( wp_style_is( 'plugin_css' ));
	}
}