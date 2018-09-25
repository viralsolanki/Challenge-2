<?php
/**
 * Clear stored data in databases.
 *
 * @package rtcamp_challenge_2a
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {

	die;
}

global $wpdb;

$wpdb->query( "DELETE FROM wp_options WHERE option_name = 'images_bar' " );
