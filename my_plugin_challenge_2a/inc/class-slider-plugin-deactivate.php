<?php
/**
 * Class for Plugin deactivation
 *
 * @package rtcamp_challenge_2a
 */

/**
 * Flush rewrite rules at plugin deactivation
 */
class Slider_Plugin_Deactivate {
	/**
	 * Public function for plugin deactivation
	 */
	public static function deactivate() {
		flush_rewrite_rules();

		global $wpdb;

		$wpdb->query( "DELETE FROM wp_options WHERE option_name = 'images_bar' " );

	}


}
