<?php
/**
 * Class for Plugin activation
 *
 * @package rtcamp_challenge_2a
 */

/**
 * Flush rewrite rules at plugin activation
 */
class Slider_Plugin_Activate {
	/**
	 * Public function for plugin activation
	 */
	public static function activate() {
		flush_rewrite_rules();

	}


}
