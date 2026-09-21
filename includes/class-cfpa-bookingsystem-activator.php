<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.2
 *
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.2
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/includes
 * @author     Your Name <email@example.com>
 */
class CFPA_Booking_System_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.2
	 */
	public static function activate() {

		// setup the database structure
	    global $wpdb;

	    $child_table = $wpdb->prefix . 'cfpa_children';
	    $child = "CREATE TABLE " . $child_table . " (
			child_id int(11) NOT NULL AUTO_INCREMENT,
			child_name VARCHAR(60) NOT NULL,
			child_school VARCHAR(120) NOT NULL,
			user_id BIGINT(20) NOT NULL,
			registered_date DATETIME NOT NULL,
			child_dob DATETIME NOT NULL,
			child_exception_date DATETIME NOT NULL,
			parent_email VARCHAR(120) NOT NULL,
			last_edit VARCHAR(60) NOT NULL,
			UNIQUE KEY child_id (child_id)
	    );";

	    $group_table = $wpdb->prefix . 'cfpa_groups';
	    $group = "CREATE TABLE " . $group_table . " (
			group_id int(11) NOT NULL AUTO_INCREMENT,
			group_name VARCHAR(60) NOT NULL,
			user_id BIGINT(20) NOT NULL,
			group_number BIGINT(20) NOT NULL,
			registered_date DATETIME NOT NULL,
			associated_info LONGTEXT,
			last_edit VARCHAR(60) NOT NULL,
			UNIQUE KEY group_id (group_id)
	    );";


	    $basket_name = $wpdb->prefix . 'cfpa_basket_meta';
	    $basket = "CREATE TABLE " . $basket_name . " (
			basket_id int(11) NOT NULL AUTO_INCREMENT,
			user_id BIGINT(20) NOT NULL,
			basket_items LONGTEXT NOT NULL,
			basket_generate_date DATETIME NOT NULL,
			basket_status VARCHAR(60) NOT NULL,
			UNIQUE KEY basket_id (basket_id)
	    );";


	    $puchase_table = $wpdb->prefix . 'cfpa_purchases';
	    $puchase = "CREATE TABLE " . $puchase_table . " (
			invoice_id int(11) NOT NULL AUTO_INCREMENT,
			post_id LONGTEXT NOT NULL,
			user_id BIGINT(20) NOT NULL,
			purchase_cost BIGINT(20) NOT NULL,
			billing_address_line_1 VARCHAR(60) NOT NULL,
			billing_zip VARCHAR(9) NOT NULL,
			billing_city VARCHAR(60) NOT NULL,
			billing_country VARCHAR(60) NOT NULL,
			billing_country_code VARCHAR(4) NOT NULL,
			payment_status VARCHAR(20) NOT NULL,
			purchase_generate_date DATETIME NOT NULL,
			UNIQUE KEY invoice_id (invoice_id)
	    );";

	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	    dbDelta( $basket );
	    dbDelta( $child );
	    dbDelta( $group );
	    dbDelta( $puchase );

		// setup some basic pages
		$subpages = array(
			array('slug' => 'account', 'title' => 'Account'),
			array('slug' => 'profile', 'title' => 'Profile'),
			array('slug' => 'purchase-history', 'title' => 'Purchase History'),
			array('slug' => 'add-performer', 'title' => 'Add Performer'),
			array('slug' => 'enter-performer', 'title' => 'Enter Performer'),
			array('slug' => 'checkout', 'title' => 'Checkout'),
			array('slug' => 'charge', 'title' => 'Charge'),
			array('slug' => 'user-account-registration', 'title' => 'User Account Registration'),
		);

		$account_menu = array();
		for($i = 0; $i <= 3; $i++) {
			$account_menu[] =$subpages[$i]['title'];
		}

		// Initialize the page ID to -1. This indicates no action has been taken.
		$users_page = -1;

		// Setup the author, slug, and title for the post
		$author_id = 1;
		$slug = 'cfpa-user';
		$title = 'CFPA User';

		// If the page doesn't already exist, then create it
		if( null == get_page_by_title( $title ) ) {

			// Set the post ID so that we know the post was created successfully
			$users_page = wp_insert_post(
				array(
					'comment_status'	=>	'closed',
					'ping_status'		=>	'closed',
					'post_author'		=>	$author_id,
					'post_name'		=>	$slug,
					'post_title'		=>	$title,
					'post_status'		=>	'publish',
					'post_type'		=>	'page'
				)
			);

		// Otherwise, we'll stop
		} else {

	    		// Arbitrarily use -2 to indicate that the page with the title already exists
	    		$users_page = -2;

		} // end if


		foreach ($subpages as $subpage) {

			// Setup the author, slug, and title for the post
			$author_id = 1;
			$slug = $subpage['slug'];
			$title = $subpage['title'];

			// If the page doesn't already exist, then create it
			if( null == get_page_by_title( $title ) ) {

				// Set the post ID so that we know the post was created successfully
				$post_id = wp_insert_post(
					array(
						'comment_status'	=>	'closed',
						'ping_status'		=>	'closed',
						'post_author'		=>	$author_id,
						'post_name'		=>	$slug,
						'post_title'		=>	$title,
						'post_status'		=>	'publish',
						'post_type'		=>	'page',
						'post_parent'		=>	$users_page
					)
				);

			}
		}

		/*
			Check if the menu exists
			if not then set it up
		*/
		$menu_name = 'Account Menu';
		$menu_exists = wp_get_nav_menu_object( $menu_name );

		// If it doesn't exist, let's create it.
		if( !$menu_exists){
		    $menu_id = wp_create_nav_menu($menu_name);

			foreach ($account_menu as $menu_title) {
				// Set up default menu items
			    wp_update_nav_menu_item($menu_id, 0, array(
			        'menu-item-title' =>  $menu_title,
			        'menu-item-status' => 'publish'
		        ));
			}

		} else {

			$current_account_menu = get_term_by('name', $menu_name, 'nav_menu');
			$menu_id = $term->term_id;

			foreach ($subpages as $subpage) {
				$page_id = get_page_by_path('cfpa-user/'.$subpage['slug']);
				$menu_array = array(
			    	'menu-item-title' => $subpage['title'],
					'menu-item-object' => 'page',
					'menu-item-object-id' => $page_id->ID,
					'menu-item-type' => 'post_type',
					'menu-item-status' => 'publish'
				);

				// Set up default menu items
			    wp_update_nav_menu_item($menu_id, $menu_id, $menu_array);
			}



		}

		/*
			END Check if the menu exists
		*/


		$roles = array(
			'multiple' => 'Multiple',
			'individual' => 'Individual',
		);

		foreach ($roles as $k => $v) {
			add_role( $k, $v, array( 'read' => true ) );
		}



	}



}
