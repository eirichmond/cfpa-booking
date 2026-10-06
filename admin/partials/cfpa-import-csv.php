<?php
/**
 * Shared CSV import screen, used by Classes > Import CSV and Schools > Import CSV.
 *
 * Expects $import, set by the calling menu callback:
 * - title     page heading
 * - page      admin URL of this screen, relative to wp-admin
 * - transient prefix for the per-user preview transient
 * - columns   header => field map passed to read_csv()
 * - modes     mode => label, a choice is shown when there is more than one
 * - ref_label heading of the reference column (Class no, URN)
 * - help      description shown under the file field
 * - validate  callable( $rows, $mode ) returning line => error messages
 * - run       callable( $rows, $mode, $dry_run ) returning a list of results
 *             ( line, action, id, ref, title, changes )
 *
 * The upload is always previewed first; the previewed rows are kept in a transient and
 * only written when "Apply these changes" is pressed.
 *
 * @since      2.0.0
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/admin/partials
 */

$transient_key = $import['transient'] . get_current_user_id();
$errors        = array();
$results       = null;
$applied       = false;
$mode          = key( $import['modes'] );

if ( isset( $_POST['cfpa_csv_import'] ) && current_user_can( 'manage_options' ) ) {

	check_admin_referer( 'cfpa_csv_import' );

	if ( $_POST['cfpa_csv_import'] === 'preview' ) {

		$mode = isset( $_POST['mode'] ) && isset( $import['modes'][ $_POST['mode'] ] ) ? $_POST['mode'] : $mode;
		$file = isset( $_FILES['csv_file'] ) ? $_FILES['csv_file'] : null;

		if ( ! $file || $file['error'] !== UPLOAD_ERR_OK || ! is_uploaded_file( $file['tmp_name'] ) ) {
			$errors[0] = array( 'Please choose a CSV file to upload.' );
		} elseif ( strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) ) !== 'csv' ) {
			$errors[0] = array( 'The file must be a .csv file.' );
		} else {
			$rows = $this->read_csv( $file['tmp_name'], $import['columns'] );
			if ( is_wp_error( $rows ) ) {
				$errors[0] = array( $rows->get_error_message() );
			} else {
				$errors = call_user_func( $import['validate'], $rows, $mode );
				if ( empty( $errors ) ) {
					$results = call_user_func( $import['run'], $rows, $mode, true );
					set_transient( $transient_key, array( 'mode' => $mode, 'rows' => $rows, 'file' => $file['name'] ), HOUR_IN_SECONDS );
				}
			}
		}

	} elseif ( $_POST['cfpa_csv_import'] === 'apply' ) {

		$pending = get_transient( $transient_key );
		if ( ! $pending ) {
			$errors[0] = array( 'The preview has expired, please upload the file again.' );
		} else {
			$mode = $pending['mode'];
			// re-check in case anything changed since the preview
			$errors = call_user_func( $import['validate'], $pending['rows'], $mode );
			if ( empty( $errors ) ) {
				set_time_limit( 600 );
				$results = call_user_func( $import['run'], $pending['rows'], $mode, false );
				$applied = true;
				delete_transient( $transient_key );
				error_log( $import['title'] . ' "' . $pending['file'] . '" (' . $mode . ') applied by user ' . get_current_user_id() );
			}
		}

	}
}

$labels = array(
	'created'   => 'New',
	'updated'   => 'Updated',
	'removed'   => 'Removed from ordering',
	'hidden'    => 'Hidden from list',
	'unchanged' => 'Unchanged',
	'error'     => 'Error',
);
?>

<div class="wrap">

	<h1><?php echo esc_html( $import['title'] ); ?></h1>

	<?php if ( $errors ) { ?>
		<div class="notice notice-error">
			<p><strong>Nothing has been imported.</strong> Please fix the following and upload the file again:</p>
			<ul>
				<?php foreach ( $errors as $line => $messages ) {
					foreach ( $messages as $message ) { ?>
						<li><?php echo $line ? 'Line ' . (int) $line . ': ' : ''; echo esc_html( $message ); ?></li>
					<?php }
				} ?>
			</ul>
		</div>
	<?php } ?>

	<?php if ( $results !== null ) {
		$counts = array_count_values( wp_list_pluck( $results, 'action' ) ); ?>

		<div class="notice <?php echo $applied ? 'notice-success' : 'notice-info'; ?>">
			<p>
				<strong><?php echo $applied ? 'Import complete' : 'Preview, nothing has been changed yet'; ?>:</strong>
				<?php foreach ( $labels as $action => $label ) {
					if ( ! empty( $counts[ $action ] ) ) {
						echo esc_html( $label . ': ' . $counts[ $action ] ) . '. ';
					}
				} ?>
			</p>
		</div>

		<?php if ( ! $applied ) { ?>
			<form method="post">
				<?php wp_nonce_field( 'cfpa_csv_import' ); ?>
				<input type="hidden" name="cfpa_csv_import" value="apply">
				<p>
					<?php submit_button( 'Apply these changes', 'primary', 'submit', false ); ?>
					<a class="button" href="<?php echo esc_url( admin_url( $import['page'] ) ); ?>">Cancel</a>
				</p>
			</form>
		<?php } ?>

		<table class="widefat striped">
			<thead>
				<tr>
					<th>Line</th>
					<th></th>
					<th><?php echo esc_html( $import['ref_label'] ); ?></th>
					<th>Title</th>
					<th>Changes</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $results as $result ) {
					if ( $result['action'] === 'unchanged' ) {
						continue;
					} ?>
					<tr>
						<td><?php echo $result['line'] ? (int) $result['line'] : '&ndash;'; ?></td>
						<td><?php echo esc_html( $labels[ $result['action'] ] ); ?></td>
						<td>
							<?php if ( $result['id'] ) { ?>
								<a href="<?php echo esc_url( get_edit_post_link( $result['id'] ) ); ?>"><?php echo esc_html( $result['ref'] ); ?></a>
							<?php } else {
								echo esc_html( $result['ref'] );
							} ?>
						</td>
						<td><?php echo esc_html( $result['title'] ); ?></td>
						<td>
							<?php foreach ( $result['changes'] as $field => $change ) {
								echo '<code>' . esc_html( $field ) . '</code> ';
								echo $change[0] === '' ? '' : esc_html( $change[0] ) . ' &rarr; ';
								echo esc_html( $change[1] === '' ? '(blank)' : $change[1] ) . '<br>';
							} ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>

	<?php } ?>

	<?php if ( $results === null || $applied ) { ?>

		<form method="post" enctype="multipart/form-data">
			<?php wp_nonce_field( 'cfpa_csv_import' ); ?>
			<input type="hidden" name="cfpa_csv_import" value="preview">

			<table class="form-table">
				<?php if ( count( $import['modes'] ) > 1 ) { ?>
					<tr>
						<th scope="row">Type of file</th>
						<td>
							<?php foreach ( $import['modes'] as $value => $label ) { ?>
								<label><input type="radio" name="mode" value="<?php echo esc_attr( $value ); ?>" <?php checked( $mode, $value ); ?>> <?php echo esc_html( $label ); ?></label><br>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
				<tr>
					<th scope="row"><label for="csv_file">CSV file</label></th>
					<td>
						<input type="file" name="csv_file" id="csv_file" accept=".csv">
						<p class="description"><?php echo esc_html( $import['help'] ); ?></p>
					</td>
				</tr>
			</table>

			<?php submit_button( 'Preview import' ); ?>
		</form>

	<?php } ?>

</div>
