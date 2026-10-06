<?php
/**
 * Import Classes CSV, under Classes > Import CSV.
 *
 * Yearly roll over of the class list. Two files are supported, both using the header
 * Id,Class title,Category,Class no,Class fee,Class min entrants,Class entrants,Class sub category,Lower age,Upper age
 *
 * - New and updated classes: rows with an Id update that class, rows with a blank Id create a new class.
 * - Deleted classes: listed classes are set to draft so they can no longer be entered,
 *   but past invoices and entry reports still resolve them.
 *
 * The upload is always previewed first; the previewed rows are kept in a transient and
 * only written when "Apply these changes" is pressed.
 *
 * @since      2.0.0
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/admin/partials
 */

$transient_key = 'cfpa_class_import_' . get_current_user_id();
$modes         = array(
	'update'    => 'New and updated classes',
	'unpublish' => 'Deleted classes (remove from ordering)',
);
$errors        = array();
$results       = null;
$applied       = false;
$mode          = 'update';

if ( isset( $_POST['cfpa_class_import'] ) && current_user_can( 'manage_options' ) ) {

	check_admin_referer( 'cfpa_class_import' );

	if ( $_POST['cfpa_class_import'] === 'preview' ) {

		$mode = isset( $_POST['mode'] ) && isset( $modes[ $_POST['mode'] ] ) ? $_POST['mode'] : 'update';
		$file = isset( $_FILES['csv_file'] ) ? $_FILES['csv_file'] : null;

		if ( ! $file || $file['error'] !== UPLOAD_ERR_OK || ! is_uploaded_file( $file['tmp_name'] ) ) {
			$errors[0] = array( 'Please choose a CSV file to upload.' );
		} elseif ( strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) ) !== 'csv' ) {
			$errors[0] = array( 'The file must be a .csv file.' );
		} else {
			$rows = $this->read_class_csv( $file['tmp_name'], $this->class_csv_columns() );
			if ( is_wp_error( $rows ) ) {
				$errors[0] = array( $rows->get_error_message() );
			} else {
				$errors = $this->validate_class_csv_rows( $rows, $mode );
				if ( empty( $errors ) ) {
					$results = $mode === 'update' ? $this->import_class_csv_rows( $rows, true ) : $this->unpublish_class_csv_rows( $rows, true );
					set_transient( $transient_key, array( 'mode' => $mode, 'rows' => $rows, 'file' => $file['name'] ), HOUR_IN_SECONDS );
				}
			}
		}

	} elseif ( $_POST['cfpa_class_import'] === 'apply' ) {

		$pending = get_transient( $transient_key );
		if ( ! $pending ) {
			$errors[0] = array( 'The preview has expired, please upload the file again.' );
		} else {
			$mode = $pending['mode'];
			// re-check in case classes changed since the preview
			$errors = $this->validate_class_csv_rows( $pending['rows'], $mode );
			if ( empty( $errors ) ) {
				set_time_limit( 300 );
				$results = $mode === 'update' ? $this->import_class_csv_rows( $pending['rows'], false ) : $this->unpublish_class_csv_rows( $pending['rows'], false );
				$applied = true;
				delete_transient( $transient_key );
				error_log( 'Classes CSV "' . $pending['file'] . '" (' . $mode . ') applied by user ' . get_current_user_id() );
			}
		}

	}
}

$labels = array(
	'created'   => 'New',
	'updated'   => 'Updated',
	'removed'   => 'Removed from ordering',
	'unchanged' => 'Unchanged',
	'error'     => 'Error',
);
?>

<div class="wrap">

	<h1>Import Classes CSV</h1>

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
				<?php wp_nonce_field( 'cfpa_class_import' ); ?>
				<input type="hidden" name="cfpa_class_import" value="apply">
				<p>
					<?php submit_button( 'Apply these changes', 'primary', 'submit', false ); ?>
					<a class="button" href="<?php echo esc_url( admin_url( 'edit.php?post_type=class&page=import-classes-csv' ) ); ?>">Cancel</a>
				</p>
			</form>
		<?php } ?>

		<table class="widefat striped">
			<thead>
				<tr>
					<th>Line</th>
					<th></th>
					<th>Class no</th>
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
						<td><?php echo (int) $result['line']; ?></td>
						<td><?php echo esc_html( $labels[ $result['action'] ] ); ?></td>
						<td>
							<?php if ( $result['id'] ) { ?>
								<a href="<?php echo esc_url( get_edit_post_link( $result['id'] ) ); ?>"><?php echo esc_html( $result['class_no'] ); ?></a>
							<?php } else {
								echo esc_html( $result['class_no'] );
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
			<?php wp_nonce_field( 'cfpa_class_import' ); ?>
			<input type="hidden" name="cfpa_class_import" value="preview">

			<table class="form-table">
				<tr>
					<th scope="row">Type of file</th>
					<td>
						<?php foreach ( $modes as $value => $label ) { ?>
							<label><input type="radio" name="mode" value="<?php echo esc_attr( $value ); ?>" <?php checked( $mode, $value ); ?>> <?php echo esc_html( $label ); ?></label><br>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="csv_file">CSV file</label></th>
					<td>
						<input type="file" name="csv_file" id="csv_file" accept=".csv">
						<p class="description">Columns: Id, Class title, Category, Class no, Class fee, Class min entrants, Class entrants, Class sub category, Lower age, Upper age. Leave Id blank for a new class; leave an age blank for no limit.</p>
					</td>
				</tr>
			</table>

			<?php submit_button( 'Preview import' ); ?>
		</form>

	<?php } ?>

</div>
