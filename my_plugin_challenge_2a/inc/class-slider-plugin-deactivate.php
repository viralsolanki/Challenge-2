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
		//delete values from the database
		$list_slide = get_option( 'slider_type' );
		foreach ( $list_slide as $slide ) {

			delete_option($slide);
		}
		
		delete_option('slider_type');
		$posts = get_posts(
			array(
				'post_type'      => array( 'post', 'page' ),
				'meta_key'       => '_slider_meta_value',
				'posts_per_page' => -1,
			)
		);

		foreach ( $posts as $post ) {
			delete_post_meta( $post->ID, '_slider_meta_value' );

		}
	}


}
