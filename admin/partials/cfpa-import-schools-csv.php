<?php
$admin_class = new CFPA_Booking_System_Admin ('booking system', '1.0');
/**
 * This file provides reporting as a landing page.
 *
 * @since      1.0.2
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/includes
 * @author     Elliott Richmond <elliott@squareonemd.co.uk>
 */


?>

<div class="wrap">

    <div id="icon-options-general" class="icon32"></div>
    <h2>Import Schools CSV</h2>

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2">

            <?php if (isset($_POST['submit'])) {
                $csv_file = $_FILES['csv_file'];
                $csv_to_array = array_map('str_getcsv', file($csv_file['tmp_name']));

                $user = wp_get_current_user();

                foreach ($csv_to_array as $key => $value) {
                    if ($key == 0) continue;
                        $urn = $value[0];
                        $metas = array(
                            'urn' => $value[0],
                            'establishment_type_group' => $value[2],
                            'county' => $value[3],
                            'main_email' => $value[4],
                            'head_title' => $value[5],
                            'head_first_name' => $value[6],
                            'head_last_name' => $value[7]
                        );
                        $title = $value[1];
                        $slug = sanitize_title( $value[1] );
                        $author_id = $user->ID;
                        $school = $admin_class->get_school_by_urn($urn);

                        if($school) {
                            // update school
                            wp_update_post( 
                                array(
                                    'ID' => $school->ID,
                                    'post_author' => $author_id,
                                    'post_name' => $slug,
                                    'post_title' => $title,
                                    'post_status' => 'publish',
                                    'post_type' => 'school'
                                )
                            );
                            foreach($metas as $k => $meta) {
                                update_post_meta( $school->ID, $k, $meta );
                            }
                            error_log($school->ID . ' updated!');
                        } else {
                            // insert school
                            $post_id = wp_insert_post(
                                array(
                                    'post_author' => $author_id,
                                    'post_name' => $slug,
                                    'post_title' => $title,
                                    'post_status' => 'publish',
                                    'post_type' => 'school'
                                )
                            );
                            foreach($metas as $k => $meta) {
                                update_post_meta( $post_id, $k, $meta );
                            }
                            error_log($post_id . ' added!');
                        }
                        

                    }
                    echo 'Upload complete!';
                } else {
                    echo '<form action="" method="post" enctype="multipart/form-data">';
                    echo '<input type="file" name="csv_file">';
                    echo '<input type="submit" name="submit" value="submit">';
                    echo '</form>';
                } ?>



        </div>
        <!-- #post-body .metabox-holder .columns-2 -->

        <br class="clear">
    </div>
    <!-- #poststuff -->

</div> <!-- .wrap -->