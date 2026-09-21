<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.2
 *
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.2
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/includes
 * @author     Your Name <email@example.com>
 */
class CFPA_Booking_System_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.2
	 */
	public static function deactivate() {

		$subpages = array(
			array('slug' => 'account', 'title' => 'Account'),
			array('slug' => 'profile', 'title' => 'Profile'),
			array('slug' => 'add-performer', 'title' => 'Add Performer'),
			array('slug' => 'enter-performer', 'title' => 'Enter Performer'),
			array('slug' => 'checkout', 'title' => 'Checkout'),
			array('slug' => 'charge', 'title' => 'Charge'),
		);

		$title = 'CFPA User';

		$user_page = get_page_by_title( $title );

		if( $user_page ) {

			wp_delete_post($user_page->ID, true);

		}

		foreach ($subpages as $subpage) {
			$remove = get_page_by_title( $subpage['title'] );
			if( $remove ) {

				wp_delete_post($remove->ID, true);

			}
		}

		$roles = array(
			'multiple' => 'Multiple',
			'individual' => 'Individual',
		);

		foreach ($roles as $k => $role) {
			remove_role($k);
		}

	}

}
