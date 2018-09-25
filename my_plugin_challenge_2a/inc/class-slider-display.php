<?php
/**
 * Class slider_dispplay
 *
 * @package rtcamp_challenge_2a
 */

/**
 * Create shortcode & display slider
 */
class Slider_Display {
	/**
	 * Call methods in the class & create shortcode 'myslideshow'
	 */
	public function register() {

		add_shortcode( 'myslideshow', array( $this, 'page_check_not_home_page' ) );
		add_action( 'wp_head', array( $this, 'page_check' ) );
	}
	/**
	 * Check if is the homepage
	 */
	public function page_check() {
		if ( ! is_home() ) {
			return;
		}
		return $this->slider_body();

	}
	/**
	 * Check if is not the homepage
	 */
	public function page_check_not_home_page() {
		if ( is_home() ) {
			return;
		}
		return $this->slider_body();

	}
	/**
	 * Call methods in the class
	 */
	public function slider_body() {

		$temp = get_option( 'images_bar' );

		if ( ! $temp ) {
			return;
		}

		$temp_data = html_entity_decode( $temp );
		$temp      = json_decode( $temp_data, true );

		if ( null === $temp ) {
			return;
		}

		echo '<div class="plugin_slider">';
		echo '<div class="plugin_slider_images">';
		$temp_count = count( $temp );
		for ( $i = 0; $i < $temp_count; $i++ ) {
			?>
			<img src= "<?php echo esc_url( $temp[ $i ] ); ?>" alt="">
			<?php
		}
		?>
		</div>
		<img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 1 ) ) ); ?>images/slider_next_button.png" class="next_btn" style="position:absolute" alt="next" />
		<img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 1 ) ) ); ?>images/slider_button.png" class="prev_btn" style="position:absolute" alt="prev" />
		</div>
		<?php

	}



}
