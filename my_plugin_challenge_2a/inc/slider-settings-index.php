<?php
/**
 * Class for customize slider settings page
 *
 * @package rtcamp_challenge_2a
 */

?>
<h1>Add Slider To Your Page</h1>
<?php settings_errors(); ?>

<form method="post" action="options.php">
	<?php settings_fields( 'slide-type-group' ); ?>
	<?php do_settings_sections( 'slider_settings' ); ?>

</form>
<?php
