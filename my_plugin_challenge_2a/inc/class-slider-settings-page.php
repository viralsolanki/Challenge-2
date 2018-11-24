<?php
/**
 * Class for create slider settings page
 *
 * @package rtcamp_challenge_2a
 */

/**
 * Class for create menu sections & fields for slider settings page
 */
class Slider_Settings_Page {

	/**
	 * Get plugin name
	 *
	 * @var string $plugin_name for store plugin name
	 */
	public $plugin_name;

	/**
	 * Get plugin name as $plugin_name
	 */
	public function __construct() {

		$this->plugin_name = plugin_basename( dirname( __FILE__, 2 ) ) . '/my_plugin_challenge_2a.php';

	}

	/**
	 * Public function for call methods & add settings link to plugin
	 */
	public function register() {

		add_action( 'admin_menu', array( $this, 'slider_settings_menu' ) );
		add_filter( "plugin_action_links_$this->plugin_name", array( $this, 'plugin_links' ) );

	}

	/**
	 * Public function for register menu
	 */
	public function slider_settings_menu() {

		// Generate Slider admin page.
		add_menu_page( 'Image Slider', 'Slider_Settings', 'manage_options', 'slider_settings', array( $this, 'slider_index' ), 'dashicons-edit', 110 );

		// Active slider settings.
		add_action( 'admin_init', array( $this, 'slider_type_settings' ) );
		add_action( 'admin_init', array( $this, 'slider_custom_settings' ) );

	}

	/**
	 * Public function for create slider index
	 */
	public function slider_index() {

		require_once plugin_dir_path( __FILE__ ) . 'slider-settings-index.php';

	}

	/**
	 * Public function for add links to plugin
	 *
	 * @param link $links link to th settings page.
	 */
	public function plugin_links( $links ) {
		$slider_setting_link = '<a href="admin.php?page=slider_settings">Settings</a>';
		array_push( $links, $slider_setting_link );
		return $links;

	}

	/**
	 * Public function for resgister settings sections & fields
	 */
	public function slider_type_settings() {

		register_setting( 'slide-type-group', 'slider_type', array( $this, 'slide_type_space_handler' ) );
		add_settings_section( 'slide-type-section', 'How It Works ?', array( $this, 'slide_type_section' ), 'slider_settings' );
		add_settings_field(
			'slider_type',
			'Insert Slide Type',
			array( $this, 'slide_type_field' ),
			'slider_settings',
			'slide-type-section'
		);
	}

	/**
	 * Public function for add caption
	 */
	public function slide_type_section() {

		echo "You can create multiple slides using <strong>'Insert Slider Type'</strong> field. 
		All you have to do is enter name of the slider in field and click on <strong>'Create Slide'</strong> . 
		Then you can insert, delete and change index of slides of your slider easily by clicking on the respective buttons. ";

	}

	/**
	 * Public function for create Slider type input
	 */
	public function slide_type_field() {
		$slide_type = get_option( 'slider_type' );
		$slide_type = json_encode( $slide_type );

		echo '<form method="post" action="options.php">';
		settings_fields( 'slide-type-group' );
		echo '<input type="text" id="slider_text" class="Slide_name" name="slider_type" placeholder="Insert Slide name" > <p class="description">Avoid special characters and blank spaces</p>';
		echo '<input type="hidden" id="slider_type" value = "' . esc_attr( $slide_type ) . '" >';
		submit_button( 'Create Slide' );
		echo '</form>';
	}

	/**
	 * function for sanitize slide_type_field
	 *
	 * @param input $input is slide type created by user
	 */
	public function slide_type_space_handler( $input ) {

		$slide  = sanitize_text_field( $input );
		$slide  = str_replace( ' ', '', $slide );
		$slide  = strtolower( $slide );
		$slide  = ucfirst( $slide );
		$output = get_option( 'slider_type' );
		if ( in_array( $slide, $output ) ) {
			return $output;
		}
		//if clicks on delete button delete slider
		if ( isset( $_POST['delete'] ) ) {

			$key = array_search( $_POST['delete'], $output );
			array_splice( $output, $key, 1 );
			delete_option($_POST['delete']);
			$meta_value = $this->get_meta_values( '_slider_meta_value' );
			if(!$meta_value)
				return $output;
			foreach($meta_value as $meta){
				$meta = json_decode($meta);
				if($meta[1] == $_POST['delete'] )
					delete_post_meta( $meta[0], '_slider_meta_value' );
			}
			
			return $output;
		}
	
		if ( null == $input ) {
			return $output;
		}

		if ( null == $output || ! $output ) {
			$args    = array();
			$args[0] = $slide;

			return $args;
		} else {
			array_push( $output, $slide );
			return $output;

		}
		return $output;
	}


	/**
	 * Public function for resgister settings sections & fields
	 */
	public function slider_custom_settings() {
		$slides = get_option( 'slider_type' );
		if ( ! $slides ) {
			$slides = array();
		}
		foreach ( $slides as $slide ) {
			register_setting( 'slide-image-group-' . $slide, $slide, array( $this, 'slide_image_group_callback' ) );
			//add_settings_section( 'slider-options-'.$slide, 'Slider-type : '.$slide,array( $this, 'slider_options_section' ), 'slider_settings' );
			add_settings_field(
				$slide,
				'<strong>Slider Type : ' . $slide . '</strong>',
				array( $this, 'slider_setting_field' ),
				'slider_settings',
				'slide-type-section',
				array( 'label' => $slide )
			);

		}

	}



	/**
	 * Public function for add caption
	 */

	public function slider_options_section( $args ) {

		echo 'Add Images to your slider';

	}

		/**
	 * Public function for create input fields
	 */

	public function slider_setting_field( $args ) {

		$temp        = get_option( $args['label'] );
		$temp_encode = json_encode( $temp );

		echo '<input type="button" class="button button-primary plugin-button-' . $args['label'] . '" value="Insert Images" id="upload-button-' . $args['label'] . '" />
		<input type="button" class="button button-primary plugin-button-' . $args['label'] . '" value="Remove Images" id="remove-button-' . $args['label'] . '" style="display:none;"/>
		<input type="button" class="button button-primary plugin-button-' . $args['label'] . '" value="Change index" id="change-index-' . $args['label'] . '" style=""/>
		<input type="button" class="button button-primary plugin-button-' . $args['label'] . '" value="Select & remove" id="selectandremove-' . $args['label'] . '" style=""/>
		<input type="button" class="button button-primary plugin-button-' . $args['label'] . '" value="Remove All Images" id="remove-all-button-' . $args['label'] . '" style=""/>';
		?>	
		<div class="slider_settings slider_settings-<?php echo esc_attr( $args['label'] ); ?>">
			<p id="text-<?php echo esc_attr( $args['label'] ); ?>">Click on the buttons for make respective changes.....</p>
			<ul id="image_ul-<?php echo esc_attr( $args['label'] ); ?>" class="connectedSortable">
			<?php
			if ( $temp ) {

				$temp_data  = html_entity_decode( $temp );
				$temp_data  = json_decode( $temp_data, true );
				$temp_count = count( $temp_data );
				for ( $i = 0; $i < $temp_count; $i++ ) {
				?>
					<li class="ui-state-default ui-state-default-<?php echo esc_attr( $args['label'] ); ?>" id="<?php echo esc_url( $temp_data[ $i ] ); ?>" ><img id="image-list" src= <?php echo esc_url( $temp_data[ $i ] ); ?> style=""></li>
					<?php
				}
			}
				?>
			</ul>
		</div>
		<form method="post" action="options.php" class = "save_dlt_form" >
			<?php settings_fields( 'slide-image-group-' . $args['label'] ); ?>
			<input type="hidden" id="Slider-images-<?php echo esc_attr( $args['label'] ); ?>" name = "<?php echo $args['label']; ?>" value="<?php echo esc_attr( $temp ); ?>" >	
			<?php submit_button( '', 'button button-primary', 'submit', false ); ?>
		</form>	
		<form method="post" action="options.php" class = "save_dlt_form" >
			<?php settings_fields( 'slide-type-group' ); ?>
			<input type="hidden" name = "delete" value="<?php echo esc_attr( $args['label'] ); ?>" > 
			<?php
			submit_button(
				'Delete Slider',
				'delete button button-primary',
				'submit',
				false,
				array( 'onclick' => 'return confirm("Are you sure you want to delete this slider and it\'s data.");' )
			);
			?>
		</form>
		<?php

	}
	/**
	 * callback function for slide-image-group
	 */
	public function slide_image_group_callback( $input ) {
		return $input;
	}
	/**
	* get all the valuess of meta box available
	*
	* @param $meta_key key of the metabox
	*/
	function get_meta_values( $meta_key ) {

		$posts = get_posts(
			array(
				'post_type'      => array( 'post', 'page' ),
				'meta_key'       => $meta_key,
				'posts_per_page' => -1,
			)
		);

		$meta_values = array();
		foreach ( $posts as $post ) {
			$meta_values[] = get_post_meta( $post->ID, $meta_key, true );
		}

		return $meta_values;

	}

}
