<?php

/**
 * This file provides reporting as a landing page.
 *
 * @since      1.0.2
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/includes
 * @author     Elliott Richmond <elliott@squareonemd.co.uk>
 */

$admin_class = new CFPA_Booking_System_Admin('Booking System', '1.0.2');
$public_class = new CFPA_Booking_System_Public('Booking System', '1.0.2');

if ( false === ( $entries = get_transient( 'entries_2020' ) ) ) {
    // It wasn't there, so regenerate the data and save the transient
    $entries = $admin_class->report_for_entries('2020-09-01 00:00:00');
    set_transient( 'entries_2020', $special_query_results, 20 * MINUTES_IN_SECONDS );
}

$entries = $admin_class->report_for_entries('2020-09-01 00:00:00');


$entry_headers = $admin_class->report_for_entry_headers('2020');
?>

<div class="wrap">

    <div id="icon-options-general" class="icon32"></div>
    <h2><span class="dashicons dashicons-admin-page"></span> Entries - 2021</h2>

    <div id="poststuff">

        <div id="post-body" class="metabox-holder">

            <!-- main content -->
            <div id="post-body-content">

                <div class="meta-box-sortables ui-sortable">

                    <div class="postbox">


                        <div class="inside">

                            <div id="myTable" class="tablesorter">
                                <h4>All incomplete baskets</h4>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default reset">Reset</button> <!-- targeted by the "filter_reset" option -->

                                    <!-- Split button -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default download">Download</button>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><h5><strong>Output options</strong></h5></li>
                                            <li>
                                                <label>Separator: <input class="output-separator-input" type="text" size="2" value="," /></label>
                                                <button type="button" class="output-separator btn btn-default btn-xs active" title="comma">,</button>
                                                <button type="button" class="output-separator btn btn-default btn-xs" title="semi-colon">;</button>
                                                <button type="button" class="output-separator btn btn-default btn-xs" title="tab">	</button>
                                                <button type="button" class="output-separator btn btn-default btn-xs" title="space"> </button>
                                                <button type="button" class="output-separator btn btn-default btn-xs" title="output JSON">json</button>
                                                <button type="button" class="output-separator btn btn-default btn-xs" title="output Array (see note)">array</button>
                                            </li>
                                            <li>
                                                <div class="btn-group output-download-popup" data-toggle="buttons" title="Download file or open in Popup window">
                                                    <label class="btn btn-default btn-sm active">
                                                        <input type="radio" name="delivery2" class="output-popup" checked> Popup
                                                    </label>
                                                    <label class="btn btn-default btn-sm">
                                                        <input type="radio" name="delivery2" class="output-download"> Download
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="btn-group output-filter-all" data-toggle="buttons" title="Output only filtered, visible or all rows">
                                                    <label class="btn btn-default btn-sm active">
                                                        <input type="radio" name="getrows2" class="output-filter" checked> Filtered
                                                    </label>
                                                    <label class="btn btn-default btn-sm">
                                                        <input type="radio" name="getrows2" class="output-visible"> Visible
                                                    </label>
                                                    <label class="btn btn-default btn-sm">
                                                        <input type="radio" name="getrows2" class="output-all"> All
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <label>Replace quotes: <input class="output-replacequotes" type="text" size="2" value="'" /></label>
                                                <button type="button" class="output-quotes btn btn-default btn-xs active" title="single quote">'</button>
                                                <button type="button" class="output-quotes btn btn-default btn-xs" title="left double quote">&#x201c;</button>
                                                <button type="button" class="output-quotes btn btn-default btn-xs" title="escaped quote">\"</button>
                                            </li>
                                            <li><label title="Remove extra white space from each cell">Trim spaces: <input class="output-trim" type="checkbox" checked /></label></li>
                                            <li><label title="Include HTML from cells in output">Include HTML: <input class="output-html" type="checkbox" /></label></li>
                                            <li><label title="Wrap all values in quotes">Wrap in Quotes: <input class="output-wrap" type="checkbox" /></label></li>
                                            <li><label title="Include both header rows in output">Include both header rows: <input class="output-headers" type="checkbox" checked /></label></li>
                                            <li><label title="Choose a download filename">Filename: <input class="output-filename" type="text" size="15" value="mytable.csv"/></label></li>
                                        </ul>
                                    </div>

                                </div>

                                <table id="table2">
                                    <thead>
                                        <tr>
                                            <?php foreach ($entry_headers as $entry_header) { ?>
                                                <th><?php echo esc_html(ucfirst(str_replace('_',' ',$entry_header))); ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach ($entries as $entry) {  ?>
                                        <tr>
	                                        <td><?php echo esc_html( $entry['class_number'] );?></td>
	                                        <td><?php echo esc_html( $entry['class_description'] );?></td>
	                                        <td><?php echo esc_html( $entry['class_fee'] );?></td>

	                                        <td><?php echo esc_html( $entry['class_performer_one'] );?></td>

	                                        <td><?php echo esc_html( $entry['class_performer_one_school'] );?></td>

	                                        <td><?php echo esc_html( $entry['class_performer_one_dob'] );?></td>
	                                        <td><?php echo esc_html( $entry['class_performer_one_parent_email'] );?></td>
	                                        <td><?php echo esc_html( $entry['class_performer_one_qualifying_age'] );?></td>
	                                        <td><?php echo esc_html( $entry['class_category'] );?></td>

	                                        <td><?php if (isset($entry['class_performer_two'])) { echo esc_html( $entry['class_performer_two'] ); } ?></td>
	                                        <td><?php if (isset($entry['class_performer_two_school'])) {  echo esc_html( $entry['class_performer_two_school'] ); } ?></td>
	                                        <td><?php if (isset($entry['class_performer_two_dob'])) {  echo esc_html( $entry['class_performer_two_dob'] ); }?></td>
	                                        <td><?php if (isset($entry['class_performer_two_parent_email'])) {  echo esc_html( $entry['class_performer_two_parent_email'] ); }?></td>

	                                        <td><?php if (isset($entry['class_performer_three'])) {  echo esc_html( $entry['class_performer_three'] ); }?></td>
	                                        <td><?php if (isset($entry['class_performer_three_school'])) {  echo esc_html( $entry['class_performer_three_school'] ); }?></td>
	                                        <td><?php if (isset($entry['class_performer_three_dob'])) {  echo esc_html( $entry['class_performer_three_dob'] ); }?></td>
	                                        <td><?php if (isset($entry['class_performer_three_parent_email'])) {  echo esc_html( $entry['class_performer_three_parent_email'] ); }?></td>

	                                        <td><?php if (isset($entry['class_performer_four'])) {  echo esc_html( $entry['class_performer_four'] ); }?></td>
	                                        <td><?php if (isset($entry['class_performer_four_school'])) {  echo esc_html( $entry['class_performer_four_school'] ); }?></td>
	                                        <td><?php if (isset($entry['class_performer_four_dob'])) {  echo esc_html( $entry['class_performer_four_dob'] ); }?></td>
	                                        <td><?php if (isset($entry['class_performer_four_parent_email'])) {  echo esc_html( $entry['class_performer_four_parent_email'] ); }?></td>

	                                        <td><?php echo esc_html( $entry['author_title'] );?></td>
	                                        <td><?php echo esc_html( $entry['author_name'] );?></td>
	                                        <td><?php echo esc_html( $entry['author_position'] );?></td>
	                                        <td><?php echo esc_html( $entry['author_address_1'] );?></td>
	                                        <td><?php echo esc_html( $entry['author_address_2'] );?></td>
	                                        <td><?php echo esc_html( $entry['author_address_3'] );?></td>
	                                        <td><?php echo esc_html( $entry['author_town'] );?></td>
	                                        <td><?php echo esc_html( $entry['author_city'] );?></td>
	                                        <td><?php echo esc_html( $entry['author_postcode'] );?></td>
	                                        <td><?php echo esc_html( $entry['author_email'] );?></td>
	                                        <td><?php echo esc_html( $entry['author_tel'] );?></td>
	                                        <td><?php echo esc_html( $entry['invoice_ref'] );?></td>
	                                        <td><?php echo esc_html( $entry['invoice_cost'] );?></td>
	                                        <td><?php echo esc_html( $entry['invoice_status'] );?></td>
	                                        <td><?php echo esc_html( date('d M Y, h:m:s', strtotime($entry['invoice_paid_date'])) );?></td>

                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>

                            </div>

                        </div>
                        <!-- .inside -->

                    </div>
                    <!-- .postbox -->

                </div>
                <!-- .meta-box-sortables .ui-sortable -->

            </div>
            <!-- post-body-content -->


        </div>
        <!-- #post-body .metabox-holder .columns-2 -->

        <br class="clear">
    </div>
    <!-- #poststuff -->

</div> <!-- .wrap -->