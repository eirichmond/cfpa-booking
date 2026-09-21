<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.2
 *
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.2
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/includes
 * @author     Your Name <email@example.com>
 */
class CFPA_Booking_System_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.2
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'cfpa-bookingsystem',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
