<?php
/**
 * Class for customize slider settings page
 *
 * @package rtcamp_challenge_2a
 */

?>
<h1>Customize Your Slider Here</h1>
<?php settings_errors(); ?>
<?php

$temp = get_option( 'images_bar' );
?>

<form method="post" action="options.php">
	<?php settings_fields( 'slider-image-group' ); ?>
	<?php do_settings_sections( 'slider_settings' ); ?>
	<div class="slider_settings">
		<p id="text">Click on the buttons for make respective changes.....</p>
		<ul id="image_ul" class="connectedSortable">
		<?php
		if ( $temp ) {

			$temp_data  = html_entity_decode( $temp );
			$temp       = json_decode( $temp_data, true );
			$temp_count = count( $temp );
			for ( $i = 0; $i < $temp_count; $i++ ) {
			?>
				<li class="ui-state-default" id=<?php echo esc_attr( $temp[ $i ] ); ?> ><img id="image-list" src= <?php echo esc_url( $temp[ $i ] ); ?> style=""></li>
			<?php
			}
		}
		?>
		</ul>
	</div>
	<?php submit_button(); ?>
</form>
