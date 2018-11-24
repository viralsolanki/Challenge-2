<?php
/**
 * Class SampleTest
 *
 * @package My_plugin_challenge_2a
 */

/**
 * tests if the plugin is initialized
 */
class test_Plugin_Initialized extends WP_UnitTestCase {

	public $test;

	function setup() {
		parent::setup();
		//global $Slider_plugin;
		$this->test = $GLOBALS['Slider_plugin'];

	}

	function testPluginInitialized() {

		$this->assertTrue( class_exists( 'Slider_plugin' ) );
		$this->assertFalse( null == $this->test );
	}
}
