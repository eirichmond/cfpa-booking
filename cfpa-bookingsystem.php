<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.squareonemd.co.uk
 * @since             1.0.0
 * @package           CFPA_Booking_System
 *
 * @wordpress-plugin
 * Plugin Name:       CFPA Booking System
 * Plugin URI:        http://www.squareonemd.co.uk/
 * Description:       All the functionality required for creating accounts and making bookings for the Cheltenham Festival of Perfoming Arts.
 * Version:           1.0.0
 * Author:            Elliott Richmond Square One
 * Author URI:        http://www.squareonemd.co.uk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cfpa-bookingsystem
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cfpa-bookingsystem-activator.php
 */
function activate_CFPA_Booking_System() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cfpa-bookingsystem-activator.php';
	CFPA_Booking_System_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cfpa-bookingsystem-deactivator.php
 */
function deactivate_CFPA_Booking_System() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cfpa-bookingsystem-deactivator.php';
	CFPA_Booking_System_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_CFPA_Booking_System' );
register_deactivation_hook( __FILE__, 'deactivate_CFPA_Booking_System' );

/**
 * The core plugin class specifically for widgets.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cfpa-widgets.php';

/**
 * The core plugin functions .
 */
require plugin_dir_path( __FILE__ ) . 'includes/cfpa-functions.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cfpa-bookingsystem.php';

// Require the main plugin class
require_once plugin_dir_path( __FILE__ ) . 'includes/lib/redux-framework/redux-framework.php';



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_CFPA_Booking_System() {

	$plugin = new CFPA_Booking_System();
	$plugin->run();

}
run_CFPA_Booking_System();