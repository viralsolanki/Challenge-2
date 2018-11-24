<?php
/**
 * Class for add button to visual editor
 *
 * @package rtcamp_challenge_2a
 */

/**
 * create button to visualeditor at plugin active
 */
class Add_Button_Visual_Editor {
	/**
	 * Call methods in the class & create shortcode button
	 */
	public function register() {
		add_filter( 'mce_external_plugins', array( $this, 'enqueue_plugin_scripts' ) );
		add_filter( 'mce_buttons', array( $this, 'register_buttons_to_editor' ) );
		add_action( 'admin_head', array( $this, 'my_add_styles_admin' ) );
		add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );
		add_action( 'save_post', array( $this, 'slider_meta_save' ) );

	}

	/**
	 * Public function for add button
	 */
	public function enqueue_plugin_scripts( $plugin_array ) {
		//enqueue TinyMCE plugin script with its ID.

		$plugin_array['shortcode_button'] = plugin_dir_url( dirname( __FILE__ ) ) . 'enqueue/visual_editor_button.js';

		return $plugin_array;
	}

	/**
	 * Public function for register button
	 */
	public function register_buttons_to_editor( $buttons ) {
		//register buttons with their id.
		array_push( $buttons, 'addshortcode' );
		return $buttons;
	}

	/**
	 * Public function for apply on header of post & page edit page
	 */
	public function my_add_styles_admin() {
		//get the list of sliders
		$shortcode_list = get_option( 'slider_type' );
		if ( ! $shortcode_list || empty( $shortcode_list ) ) {
			return;
		}
		$shortcode_list = json_encode( $shortcode_list );

		global $current_screen;
		$type = $current_screen->post_type;

		if ( is_admin() && 'post' == $type || 'page' == $type ) {

			global $post;
			if ( ! is_object( $post ) ) {
				return;
			}
			//if any slider is already selected get the value
			$value = get_post_meta( $post->ID, '_slider_meta_value', true );
			?>
			<script type="text/javascript">
				var shortcodes = '<?php echo $shortcode_list; ?>';
				var posts = '<?php global $post;echo $post->ID;?>';
				var old_value = '<?php echo $value; ?>'; 
			</script>
			<?php

		}
	}

	/**
	 * Public function for add METABOX - metabox contains the value of
	selected slider from the dropndown list
	 */
	public function create_meta_box() {
		add_meta_box( 'slider_meta', 'Example metabox', array( $this, 'slider_meta_fields_callback' ), [ 'Page', 'post' ] );

	}

	/**
	 * Public function for METABOX callback
	 */
	public function slider_meta_fields_callback( $post ) {
		wp_nonce_field( 'slider_meta_save', 'slider_meta_save_nonce' );
		$value = get_post_meta( $post->ID, '_slider_meta_value', true );
		echo '<input type ="hidden" id ="post_id" name ="post_id" value="' . $value . '">';
		?>
		<script type="text/javascript">
			document.getElementById("slider_meta").style.display='none';
		</script>
	<?php
	}

	/**
	 * Public function for save METABOX value
	 */
	public function slider_meta_save( $post_id ) {

		if ( ! isset( $_POST['slider_meta_save_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['slider_meta_save_nonce'], 'slider_meta_save' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( ! isset( $post_id ) ) {
			return;
		}

		if ( ! isset( $_POST['post_id'] ) || $_POST['post_id'] == "[" ) {
			return;
		}

		if ( null == $_POST['post_id'] || '' == $_POST['post_id'] ) {
			delete_post_meta( $post_id, '_slider_meta_value' );
			return;
		}

		update_post_meta( $post_id, '_slider_meta_value', $_POST['post_id'] );
	}
}
