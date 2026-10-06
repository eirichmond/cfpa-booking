<?php
/**
 * Reset Performer Schools, under Schools > Reset Performer Schools.
 *
 * Part of the yearly roll over: clears the Place of Education on every performer so that
 * school age performers have to have it re-entered before they can be entered into a class.
 *
 * @since      2.0.0
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/admin/partials
 */

$cleared = null;
$error   = '';

if ( isset( $_POST['cfpa_reset_performer_schools'] ) && current_user_can( 'manage_options' ) ) {
	check_admin_referer( 'cfpa_reset_performer_schools' );
	if ( empty( $_POST['confirm'] ) ) {
		$error = 'Please tick the box to confirm.';
	} else {
		$cleared = $this->reset_performer_schools();
	}
}

$with_school = $this->count_performers_with_school();
?>

<div class="wrap">

	<h1>Reset Performer Schools</h1>

	<?php if ( $error ) { ?>
		<div class="notice notice-error"><p><?php echo esc_html( $error ); ?></p></div>
	<?php } ?>

	<?php if ( $cleared !== null ) { ?>
		<div class="notice notice-success"><p>The Place of Education has been cleared on <?php echo (int) $cleared; ?> performers.</p></div>
	<?php } ?>

	<p>Use this once a year when the entry system rolls over to a new festival. It clears the Place of Education on <strong>every</strong> performer, so that performers under 17 have to have their school entered again before they can be entered into a class.</p>
	<p>Performers 17 and over can still be entered without one. Groups are not affected. This cannot be undone.</p>

	<p><strong><?php echo (int) $with_school; ?></strong> performers currently have a Place of Education.</p>

	<?php if ( $with_school ) { ?>
		<form method="post" onsubmit="return confirm( 'Clear the Place of Education on all <?php echo (int) $with_school; ?> performers? This cannot be undone.' );">
			<?php wp_nonce_field( 'cfpa_reset_performer_schools' ); ?>
			<input type="hidden" name="cfpa_reset_performer_schools" value="1">
			<p><label><input type="checkbox" name="confirm" value="1"> I understand this clears the Place of Education on every performer</label></p>
			<?php submit_button( 'Reset performer schools', 'delete' ); ?>
		</form>
	<?php } ?>

</div>
