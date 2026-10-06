<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.2
 *
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.2
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/includes
 * @author     Your Name <email@example.com>
 */
class CFPA_Booking_System {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.2
	 * @access   protected
	 * @var      CFPA_Booking_System_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.2
	 * @access   protected
	 * @var      string    $CFPA_Booking_System    The string used to uniquely identify this plugin.
	 */
	protected $CFPA_Booking_System;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.2
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.2
	 */
	public function __construct() {

		$this->CFPA_Booking_System = 'cfpa-bookingsystem';
		$this->version = '1.0.4';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - CFPA_Booking_System_Loader. Orchestrates the hooks of the plugin.
	 * - CFPA_Booking_System_i18n. Defines internationalization functionality.
	 * - CFPA_Booking_System_Admin. Defines all hooks for the admin area.
	 * - CFPA_Booking_System_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.2
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cfpa-bookingsystem-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cfpa-bookingsystem-i18n.php';

		/**
		 * The class responsible for defining general settings
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-settings.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/cfpa-settings.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/Custom-Meta-Boxes/custom-meta-boxes.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cfpa-bookingsystem-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cfpa-bookingsystem-public.php';

		/**
		 * Responsible for defining all settings
		 * swap out sample for checking settings
		 */
		//require_once plugin_dir_path(dirname(__FILE__) ) . 'includes/lib/redux-framework-master/sample/sample-config.php';
		require_once plugin_dir_path(dirname(__FILE__) ) . 'includes/cfpa/cfpa-config.php';


		$this->loader = new CFPA_Booking_System_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the CFPA_Booking_System_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.2
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new CFPA_Booking_System_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.2
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new CFPA_Booking_System_Admin( $this->get_CFPA_Booking_System(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_admin, 'register_cpt_class' );
		$this->loader->add_action( 'init', $plugin_admin, 'classcat', 0 );

		$this->loader->add_action( 'init', $plugin_admin, 'register_cpt_invoice' );
		$this->loader->add_action( 'cmb_meta_boxes', $plugin_admin, 'invoice_cmb' );

		$this->loader->add_action( 'init', $plugin_admin, 'school_init' );
		//$this->loader->add_action( 'init', $plugin_admin, 'towncity', 0 );

		$this->loader->add_action( 'cmb_meta_boxes', $plugin_admin, 'school_cmb' );
		$this->loader->add_filter( 'post_updated_messages', $plugin_admin, 'school_updated_messages' );


		$this->loader->add_action( 'cmb_meta_boxes', $plugin_admin, 'cfpa_cmb');


		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		//$this->loader->add_action( 'login_enqueue_scripts', $plugin_admin, 'cfpa_login_stylesheet' );
		$this->loader->add_action( 'login_message', $plugin_admin, 'cfpa_login_extra_note' );

		$this->loader->add_action( 'widgets_init', $plugin_admin, 'cfpa_booking_widgets_init' );

        $this->loader->add_action( 'admin_menu', $plugin_admin, 'register_reports_menu_page' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'unslash_performer_names' );

        $this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_meta_box' );
        $this->loader->add_action( 'add_meta_boxes_class', $plugin_admin, 'remove_class_custom_fields_box', 20 );

        $this->loader->add_action( 'wp_ajax_nopriv_resend_invoice', $plugin_admin, 'resend_invoice' );
        $this->loader->add_action( 'wp_ajax_resend_invoice', $plugin_admin, 'resend_invoice' );

		$this->loader->add_action( 'manage_class_posts_columns', $plugin_admin, 'cfpa_class_column' );
		$this->loader->add_action( 'manage_class_posts_custom_column', $plugin_admin, 'cfpa_class_column_data', 1, 10 );

		$this->loader->add_filter( 'manage_edit-class_sortable_columns', $plugin_admin, 'cfpa_register_sortable_columns' );
		$this->loader->add_action( 'create_special_pages', $plugin_admin, 'add_special_schools' );



	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.2
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new CFPA_Booking_System_Public( $this->get_CFPA_Booking_System(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		// template includes
		$this->loader->add_filter( 'template_include', $plugin_public, 'page_includes' );
		$this->loader->add_filter( 'template_include', $plugin_public, 'registration_page_includes' );
		$this->loader->add_filter( 'template_include', $plugin_public, 'jstestpage' );
		// single template
		$this->loader->add_filter( 'single_template', $plugin_public, 'get_invoice_template' );
		// extra user profile data
		//$this->loader->add_action( 'show_user_profile', $plugin_public, 'user_profile_data' );
		$this->loader->add_action( 'edit_user_profile', $plugin_public, 'user_profile_data' );
		$this->loader->add_action( 'personal_options_update', $plugin_public, 'save_profile_data' );
		$this->loader->add_action( 'edit_user_profile_update', $plugin_public, 'save_profile_data' );
		// form processing from frontent
		$this->loader->add_action( 'process_form', $plugin_public, 'perform_form_processing' );
		// add account to menu items
		$this->loader->add_action( 'wp_nav_menu_items', $plugin_public, 'cfpa_loginout_menu_link', 10, 2);

		$this->loader->add_action( 'login_redirect', $plugin_public, 'cfpa_redirect', 10, 3);

		// some ajax actions for removing children
		$this->loader->add_action( 'wp_ajax_nopriv_remove_child', $plugin_public, 'remove_child' );
		$this->loader->add_action( 'wp_ajax_remove_child', $plugin_public, 'remove_child' );

		// some ajax actions for removing groups
		$this->loader->add_action( 'wp_ajax_nopriv_remove_group', $plugin_public, 'remove_group' );
		$this->loader->add_action( 'wp_ajax_remove_group', $plugin_public, 'remove_group' );

		// some ajax actions for entering classes
		$this->loader->add_action( 'wp_ajax_nopriv_add_to_basket', $plugin_public, 'add_to_basket' );
		$this->loader->add_action( 'wp_ajax_add_to_basket', $plugin_public, 'add_to_basket' );

		$this->loader->add_action( 'wp_ajax_nopriv_add_group_to_basket', $plugin_public, 'add_group_to_basket' );
		$this->loader->add_action( 'wp_ajax_add_group_to_basket', $plugin_public, 'add_group_to_basket' );

		$this->loader->add_action( 'wp_ajax_nopriv_add_programme_to_basket', $plugin_public, 'add_programme_to_basket' );
		$this->loader->add_action( 'wp_ajax_add_programme_to_basket', $plugin_public, 'add_programme_to_basket' );

		$this->loader->add_action( 'wp_ajax_nopriv_remove_from_basket', $plugin_public, 'remove_from_basket' );
		$this->loader->add_action( 'wp_ajax_remove_from_basket', $plugin_public, 'remove_from_basket' );

		$this->loader->add_action( 'wp_ajax_nopriv_get_children', $plugin_public, 'get_children' );
		$this->loader->add_action( 'wp_ajax_get_children', $plugin_public, 'get_children' );

		$this->loader->add_action( 'wp_ajax_nopriv_get_groups', $plugin_public, 'get_groups' );
		$this->loader->add_action( 'wp_ajax_get_groups', $plugin_public, 'get_groups' );

		$this->loader->add_action( 'wp_ajax_nopriv_check_group_numbers', $plugin_public, 'check_group_numbers' );
		$this->loader->add_action( 'wp_ajax_check_group_numbers', $plugin_public, 'check_group_numbers' );

		$this->loader->add_action( 'wp_ajax_nopriv_get_qualifying_classes_by_id', $plugin_public, 'get_qualifying_classes_by_id' );
		$this->loader->add_action( 'wp_ajax_get_qualifying_classes_by_id', $plugin_public, 'get_qualifying_classes_by_id' );

		$this->loader->add_action( 'wp_ajax_nopriv_get_qualifying_group_classes_by_id', $plugin_public, 'get_qualifying_group_classes_by_id' );
		$this->loader->add_action( 'wp_ajax_get_qualifying_group_classes_by_id', $plugin_public, 'get_qualifying_group_classes_by_id' );

		$this->loader->add_action( 'wp_ajax_nopriv_check_min_max_entrants', $plugin_public, 'check_min_max_entrants' );
		$this->loader->add_action( 'wp_ajax_check_min_max_entrants', $plugin_public, 'check_min_max_entrants' );

		$this->loader->add_action( 'wp_ajax_nopriv_retrieve_eligible_performers', $plugin_public, 'retrieve_eligible_performers' );
		$this->loader->add_action( 'wp_ajax_retrieve_eligible_performers', $plugin_public, 'retrieve_eligible_performers' );

		$this->loader->add_action( 'wp_ajax_nopriv_check_child_licence_notice', $plugin_public, 'check_child_licence_notice' );
		$this->loader->add_action( 'wp_ajax_check_child_licence_notice', $plugin_public, 'check_child_licence_notice' );

		$this->loader->add_action( 'wp_ajax_nopriv_check_headmaster_approval_notice', $plugin_public, 'check_headmaster_approval_notice' );
		$this->loader->add_action( 'wp_ajax_check_headmaster_approval_notice', $plugin_public, 'check_headmaster_approval_notice' );

		// AJAX action for updating marketing permission
		$this->loader->add_action( 'wp_ajax_nopriv_update_marketing_permission', $plugin_public, 'update_marketing_permission' );
		$this->loader->add_action( 'wp_ajax_update_marketing_permission', $plugin_public, 'update_marketing_permission' );

		$this->loader->add_filter( 'wp_mail_from', $plugin_public, 'cfpa_wp_mail_from' );
		$this->loader->add_filter( 'wp_mail_from_name', $plugin_public, 'cfpa_mail_from_name' );

		$this->loader->add_action( 'widgets_init', $plugin_public, 'register_cfpa_widgets' );

		$this->loader->add_action( 'init', $plugin_public, 'remove_duplicate_schools_without_urn_post_meta' );

        $this->loader->add_action( 'init', $plugin_public, 'register_shortcodes');

		$this->loader->add_action( 'delete_all_custom_post_type_posts', $plugin_public, 'delete_all_custom_post_type_posts_callback', 10, 1 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.2
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.2
	 * @return    string    The name of the plugin.
	 */
	public function get_CFPA_Booking_System() {
		return $this->CFPA_Booking_System;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.2
	 * @return    CFPA_Booking_System_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.2
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
