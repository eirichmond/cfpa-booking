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
$invoices = $admin_class->report_for_invoices('2019-09-01 00:00:00');
$invoice_headers = $admin_class->report_for_invoice_headers();
//var_dump($invoices);
?>

<div class="wrap">

    <div id="icon-options-general" class="icon32"></div>
    <h2><span class="dashicons dashicons-admin-page"></span> Invoices</h2>

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
                                            <?php foreach ($invoice_headers as $invoice_header) { ?>
                                                <th><?php echo esc_html(ucfirst(str_replace('_',' ',$invoice_header))); ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach ($invoices as $invoice) { $items = get_post_meta( $invoice->ID, 'inv_item', false ); ?>
                                        <tr>
	                                        <td><?php echo esc_html( get_the_title($invoice->ID) );?></td>
	                                        <td><?php echo esc_html( date('d M Y, h:m:s', strtotime($invoice->post_date)) );?></td>
	                                        <td><?php echo get_author_name( $invoice->post_author );?></td>
	                                        <td><?php foreach($items as $dataitem) {
		                                            	//var_dump($dataitem);
		                                            	foreach ($dataitem as $k => $item){
			                                            	if ($k == 'class_id' && $item != '') {
				                                            	echo get_the_title($item) . ', ';
			                                            	}
			                                            	if ($k == 'child_id' && $item != '') {
				                                            	echo esc_html($public_class->get_child_by_id($item, 'name'));
			                                            	}
			                                            	if ($k == 'group_class_id' && $item != '') {
				                                            	echo get_the_title($item) . ', ';
			                                            	}
			                                            	if ($k == 'group_id' && $item != '') {
				                                            	echo esc_html($public_class->get_group_by_id($item, 'name'));
			                                            	}
			                                            	if ($k == 'prog_quant' && $item != '') {
				                                            	echo esc_html('Programmes ordered: '.$item);
			                                            	}
		                                            	}
		                                            	echo '<br>';

		                                            	} ?></td>
	                                        <td><?php echo get_post_meta( $invoice->ID, 'programmes_ordered', true ); ?></td>
	                                        <td><?php echo get_post_meta( $invoice->ID, 'inv_status', true ); ?></td>
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