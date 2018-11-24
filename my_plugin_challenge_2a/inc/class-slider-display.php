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
	 * Call methods in the class & create shortcods [slidername]
	 */
	public function register() {
		$list_sliders = get_option( 'slider_type' );
		if ( ! $list_sliders || empty( $list_sliders ) ) {
			return;
		}
		//create shortcode as the name of the slider
		foreach ( $list_sliders as $shortcode ) {
			add_shortcode(
				$shortcode,
				function() use ( $shortcode ) {
					return $this->slider_body( $shortcode );
				}
			);

		}
		add_action( 'wp_head', array( $this, 'add_slider_to_post_header' ) );

	}

	/**
	 * check which post or page will contain slider then add slider to the header post
	 */
	public function add_slider_to_post_header() {
		//get the id of the post which contains any slider
		$meta_values = $GLOBALS['Slider_settings']->get_meta_values( '_slider_meta_value' );
		if ( ! $meta_values ) {
			return;
		}
		$temp = array();
		foreach ( $meta_values as $meta_value ) {
			$meta_values_decode = json_decode( $meta_value );
			$key                = $meta_values_decode[0];
			$data               = $meta_values_decode[1];
			$temp[ $key ]       = $data;
		}
		global $post;

		foreach ( $temp as $page_id => $slider ) {
			if ( $post->ID == $page_id ) {
				return $this->slider_body( $slider );
			}
		}
	}

	/**
	 * create the body of the slider
	 *
	 * @param $slide name of the slider
	 */
	public function slider_body( $slide ) {
		
		if ( ! $slide ) {
			return;
		}
		$list_sliders         = get_option( 'slider_type' );
		$list_sliders_encoded = json_encode( $list_sliders );
		if ( ! $list_sliders ) {
			return;
		}

		//get the list of images
		$temp_encode = get_option( $slide );
		if ( !$temp_encode ) {
			return;
		}
		$temp_data  = html_entity_decode( $temp_encode );
		$temp       = json_decode( $temp_data, true );
		$temp_count = count( $temp );
		if ( 0 == $temp_count ) {
			return;
		}
		echo '<div class="plugin_slider plugin_slider-' . $slide . '">';
		echo '<div class="plugin_slider_images plugin_slider_images-' . $slide . '">';

		echo '<input type ="hidden" id ="slider_type" value ="' . esc_attr( $list_sliders_encoded ) . '" >';

		for ( $i = 0; $i < $temp_count; $i++ ) {
			?>
			<img src= "<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 1 ) ) ); ?>images/loader.gif" class = "load_img" data-src="<?php echo esc_url( $temp[ $i ] ); ?>">
			<?php
		}
		?>
		</div>
		<img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 1 ) ) ); ?>images/slider_next_button.png" class="next_btn next_btn-<?php echo $slide; ?>" style="position:absolute" alt="next" />
		<img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 1 ) ) ); ?>images/slider_button.png" class="prev_btn prev_btn-<?php echo $slide; ?>" style="position:absolute" alt="prev" />
		</div>
		<?php

	}	
}
