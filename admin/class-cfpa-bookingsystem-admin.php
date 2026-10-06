<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.2
 *
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/admin
 * @author     Your Name <email@example.com>
 */
class CFPA_Booking_System_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.2
	 * @access   private
	 * @var      string    $CFPA_Booking_System    The ID of this plugin.
	 */
	private $CFPA_Booking_System;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.2
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.2
	 * @param      string    $CFPA_Booking_System       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $CFPA_Booking_System, $version ) {

		$this->CFPA_Booking_System = $CFPA_Booking_System;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.2
	 */
	public function enqueue_styles() {

		$screen = get_current_screen();

		//var_dump($screen);

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in CFPA_Booking_System_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The CFPA_Booking_System_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->CFPA_Booking_System, plugin_dir_url( __FILE__ ) . 'css/cfpa-bookingsystem-admin.css', array(), $this->version, 'all' );

		if ($screen->id == 'cfpa-booking/admin/partials/cfpa-reports'
		|| $screen->id == 'reports_page_performers'
		|| $screen->id == 'reports_page_classes'
		|| $screen->id == 'reports_page_baskets'
		|| $screen->id == 'reports_page_invoices'
		|| $screen->id == 'reports_page_entries'
		|| $screen->id == 'reports_page_entries-2018'
		|| $screen->id == 'reports_page_entries-2019'
		|| $screen->id == 'reports_page_entries-2020'
		|| $screen->id == 'reports_page_entries-2021'
		|| $screen->id == 'reports_page_entries-2022'
		|| $screen->id == 'reports_page_entries-2023'
		|| $screen->id == 'reports_page_entries-2024'
		|| $screen->id == 'reports_page_entries-2025'
		|| $screen->id == 'reports_page_entries-2026'
		) {

			wp_enqueue_style( $this->CFPA_Booking_System . '-bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->CFPA_Booking_System . '-tables-inline-css', plugin_dir_url( __FILE__ ) . 'css/tables-inline.css', array(), $this->version, 'all' );

			wp_enqueue_style( $this->CFPA_Booking_System . '-tablesorter-theme-css', plugin_dir_url( __FILE__ ) . 'css/theme.blue.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->CFPA_Booking_System . '-tablesorter-bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/theme.bootstrap.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.2
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in CFPA_Booking_System_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The CFPA_Booking_System_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->CFPA_Booking_System, plugin_dir_url( __FILE__ ) . 'js/cfpa-bookingsystem-admin.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->CFPA_Booking_System . '-bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->CFPA_Booking_System . '-table-sorter', plugin_dir_url( __FILE__ ) . 'js/jquery.tablesorter.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->CFPA_Booking_System.'-table-sorter-widgets', plugin_dir_url( __FILE__ ) . 'js/jquery.tablesorter.widgets.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->CFPA_Booking_System.'-table-sorter-widgets-output', plugin_dir_url( __FILE__ ) . 'js/widgets/widget-output.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->CFPA_Booking_System.'-table-sorter-widgets-parser', plugin_dir_url( __FILE__ ) . 'js/parsers/parser-input-select.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->CFPA_Booking_System.'-resend-invoice', plugin_dir_url( __FILE__ ) . 'js/cfpa-resend-invoice.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->CFPA_Booking_System . '-resend-invoice', 'Resend_Invoice', array(
		    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
		    'nextNonce'     => wp_create_nonce( 'resend-invoice' ))
		);

	}

	public function register_reports_menu_page() {

		add_menu_page( 'Reports', 'Reports', 'manage_options', plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', '', 'dashicons-format-aside', 99 );

		add_submenu_page( plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', 'Classes', 'Classes', 'manage_options', 'classes', array( $this, 'cfpa_classes') );
		add_submenu_page( plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', 'Performers', 'Performers', 'manage_options', 'performers', array( $this, 'cfpa_performers') );
		add_submenu_page( plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', 'Baskets', 'Baskets', 'manage_options', 'baskets', array( $this, 'cfpa_baskets') );
		add_submenu_page( plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', 'Invoices', 'Invoices', 'manage_options', 'invoices', array( $this, 'cfpa_invoices') );
		// add_submenu_page( plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', 'All Entries', 'All Entries', 'manage_options', 'entries', array( $this, 'cfpa_entries') );
		// add_submenu_page( plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', 'Entries 2018', 'Entries 2018', 'manage_options', 'entries-2018', array( $this, 'cfpa_entries_2018') );
		// add_submenu_page( plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', 'Entries 2019', 'Entries 2019', 'manage_options', 'entries-2019', array( $this, 'cfpa_entries_2019') );
		// add_submenu_page( plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', 'Entries 2020', 'Entries 2020', 'manage_options', 'entries-2019', array( $this, 'cfpa_entries_2020') );
		// add_submenu_page( plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', 'Entries 2021', 'Entries 2021', 'manage_options', 'entries-2020', array( $this, 'cfpa_entries_2021') );
		// add_submenu_page( plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', 'Entries 2022', 'Entries 2022', 'manage_options', 'entries-2021', array( $this, 'cfpa_entries_2022') );
		// add_submenu_page( plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', 'Entries 2023', 'Entries 2023', 'manage_options', 'entries-2022', array( $this, 'cfpa_entries_2023') );
		add_submenu_page( plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', 'Entries 2024', 'Entries 2024', 'manage_options', 'entries-2023', array( $this, 'cfpa_entries_2024') );
		add_submenu_page( plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', 'Entries 2025', 'Entries 2025', 'manage_options', 'entries-2025', array( $this, 'cfpa_entries_2025') );
		add_submenu_page( plugin_dir_path( __FILE__ ) . 'partials/cfpa-reports.php', 'Entries 2026', 'Entries 2026', 'manage_options', 'entries-2026', array( $this, 'cfpa_entries_2026') );


		/**
		 * addtional items to school custom post type menu
		 *
		 * @return void
		 */
		add_submenu_page( 'edit.php?post_type=school', 'Import Schools CSV', 'Import CSV', 'manage_options', 'import-schools-csv', array( $this, 'cfpa_import_schools_csv') );

		/**
		 * addtional items to class custom post type menu
		 */
		add_submenu_page( 'edit.php?post_type=class', 'Import Classes CSV', 'Import CSV', 'manage_options', 'import-classes-csv', array( $this, 'cfpa_import_classes_csv') );

	}

	/** add additional menu item to custom post type menu */
	public function cfpa_import_schools_csv() {
		$import = array(
			'title'     => 'Import Schools CSV',
			'page'      => 'edit.php?post_type=school&page=import-schools-csv',
			'transient' => 'cfpa_school_import_',
			'columns'   => $this->school_csv_columns(),
			'modes'     => array( 'update' => 'Schools list for the online system' ),
			'ref_label' => 'URN',
			'help'      => 'Columns: URN, EstablishmentName, EstablishmentTypeGroup (code), EstablishmentTypeGroup (name), Location. Schools not in the file are hidden from the list users choose from, but kept so existing performers still show their school.',
			'validate'  => array( $this, 'validate_school_csv_rows' ),
			'run'       => function( $rows, $mode, $dry_run ) {
				return $this->import_school_csv_rows( $rows, $dry_run );
			},
		);
		include plugin_dir_path( __FILE__ ) . 'partials/cfpa-import-csv.php';

	}

	/** add additional menu item to class custom post type menu */
	public function cfpa_import_classes_csv() {
		$import = array(
			'title'     => 'Import Classes CSV',
			'page'      => 'edit.php?post_type=class&page=import-classes-csv',
			'transient' => 'cfpa_class_import_',
			'columns'   => $this->class_csv_columns(),
			'modes'     => array(
				'update'    => 'New and updated classes',
				'unpublish' => 'Deleted classes (remove from ordering)',
			),
			'ref_label' => 'Class no',
			'help'      => 'Columns: Id, Class title, Category, Class no, Class fee, Class min entrants, Class entrants, Class sub category, Lower age, Upper age. Leave Id blank for a new class; leave an age blank for no limit.',
			'validate'  => array( $this, 'validate_class_csv_rows' ),
			'run'       => function( $rows, $mode, $dry_run ) {
				return $mode === 'update' ? $this->import_class_csv_rows( $rows, $dry_run ) : $this->unpublish_class_csv_rows( $rows, $dry_run );
			},
		);
		include plugin_dir_path( __FILE__ ) . 'partials/cfpa-import-csv.php';

	}

	/**
	 * Column headers expected in the classes CSV, mapped to the field they populate.
	 *
	 * @return array header (lowercase) => field key
	 */
	public function class_csv_columns() {
		return array(
			'id'                 => 'id',
			'class title'        => 'title',
			'category'           => 'category',
			'class no'           => 'class-ref-no',
			'class fee'          => 'class-fee',
			'class min entrants' => 'class-min-entrants',
			'class entrants'     => 'class-entrants',
			'class sub category' => 'class-sub-category',
			'lower age'          => 'lower-age',
			'upper age'          => 'upper-age',
		);
	}

	/**
	 * Column headers expected in the schools CSV, mapped to the field they populate.
	 *
	 * @return array header (lowercase) => field key
	 */
	public function school_csv_columns() {
		return array(
			'urn'                            => 'urn',
			'establishmentname'              => 'title',
			'establishmenttypegroup (code)'  => 'establishment_type_group_code',
			'establishmenttypegroup (name)'  => 'establishment_type_group',
			'location'                       => 'county',
		);
	}

	/**
	 * Read an uploaded CSV into rows keyed by field.
	 *
	 * Handles files saved by Excel on Mac (Mac Roman) or Windows (Windows-1252) as well as UTF-8,
	 * and normalises non-breaking spaces and curly quotes so titles match those already stored.
	 *
	 * @param string $path    path to the uploaded file
	 * @param array  $columns header => field map, see class_csv_columns()
	 * @return array|WP_Error rows ( line number => array field => value )
	 */
	public function read_csv( $path, $columns ) {

		$raw = file_get_contents( $path );
		if ( $raw === false || trim( $raw ) === '' ) {
			return new WP_Error( 'empty', 'The file is empty or could not be read.' );
		}

		// strip a UTF-8 BOM, then convert legacy encodings
		if ( substr( $raw, 0, 3 ) === "\xEF\xBB\xBF" ) {
			$raw = substr( $raw, 3 );
		}
		if ( ! mb_check_encoding( $raw, 'UTF-8' ) ) {
			// Windows-1252 smart quotes/dashes live in 0x91-0x97, Mac Roman ones in 0xCA/0xD0-0xD5
			$windows   = preg_match_all( '/[\x91-\x97]/', $raw );
			$mac_roman = preg_match_all( '/[\xCA\xD0-\xD5]/', $raw );
			$encoding  = $windows > $mac_roman ? 'WINDOWS-1252' : 'MACINTOSH';
			$converted = iconv( $encoding, 'UTF-8//TRANSLIT', $raw );
			if ( $converted === false ) {
				return new WP_Error( 'encoding', 'The file could not be converted to UTF-8. Please save it as "CSV UTF-8" and try again.' );
			}
			$raw = $converted;
		}

		$raw   = str_replace( array( "\r\n", "\r" ), "\n", $raw );
		$lines = explode( "\n", $raw );

		$header = array_map( function( $heading ) {
			return strtolower( trim( $heading ) );
		}, str_getcsv( array_shift( $lines ), ',', '"', '\\' ) );

		$missing = array_diff( array_keys( $columns ), $header );
		if ( $missing ) {
			return new WP_Error( 'header', 'Missing column(s): ' . implode( ', ', $missing ) . '. Expected: ' . implode( ', ', array_keys( $columns ) ) . '.' );
		}

		$rows = array();
		foreach ( $lines as $index => $line ) {
			if ( trim( $line ) === '' ) {
				continue;
			}
			$values = str_getcsv( $line, ',', '"', '\\' );
			$row    = array();
			foreach ( $columns as $heading => $field ) {
				$value = isset( $values[ array_search( $heading, $header ) ] ) ? $values[ array_search( $heading, $header ) ] : '';
				$value = str_replace( array( "\xC2\xA0", "\xE2\x80\x98", "\xE2\x80\x99", "\xE2\x80\x9C", "\xE2\x80\x9D" ), array( ' ', "'", "'", '"', '"' ), $value );
				$row[ $field ] = trim( preg_replace( '/\s+/', ' ', $value ) );
			}
			// +2: header is line 1 and $index is zero based
			$rows[ $index + 2 ] = $row;
		}

		if ( empty( $rows ) ) {
			return new WP_Error( 'no_rows', 'The file has a header but no rows.' );
		}

		return $rows;
	}

	/**
	 * Check every row of the classes CSV before anything is written.
	 *
	 * @param array  $rows rows from read_csv()
	 * @param string $mode 'update' (new and updated classes) or 'unpublish' (deleted classes)
	 * @return array line number => array of error messages
	 */
	public function validate_class_csv_rows( $rows, $mode ) {

		$errors     = array();
		$class_nos  = array();
		$ids        = array();
		$categories = wp_list_pluck( get_terms( array( 'taxonomy' => 'class_cat', 'hide_empty' => false ) ), 'name' );

		foreach ( $rows as $line => $row ) {

			$row_errors = array();

			if ( $row['id'] !== '' ) {
				if ( ! ctype_digit( $row['id'] ) || get_post_type( (int) $row['id'] ) !== 'class' ) {
					$row_errors[] = 'Id ' . $row['id'] . ' is not an existing class.';
				} elseif ( isset( $ids[ $row['id'] ] ) ) {
					$row_errors[] = 'Id ' . $row['id'] . ' is also on line ' . $ids[ $row['id'] ] . '.';
				} else {
					$ids[ $row['id'] ] = $line;
				}
			}

			if ( $mode === 'update' && $row['id'] === '' && $row['class-ref-no'] !== '' && count( $this->find_classes_by_ref_no( $row['class-ref-no'], $rows ) ) > 1 ) {
				$row_errors[] = 'More than one existing class has class no ' . $row['class-ref-no'] . ', please add the Id.';
			}

			if ( $mode === 'unpublish' ) {
				if ( $row['id'] === '' ) {
					$row_errors[] = 'Id is required to remove a class.';
				} elseif ( empty( $row_errors ) && $row['class-ref-no'] !== '' && get_post_meta( (int) $row['id'], 'class-ref-no', true ) !== $row['class-ref-no'] ) {
					$row_errors[] = 'Class no ' . $row['class-ref-no'] . ' does not match class ' . $row['id'] . ' (' . get_post_meta( (int) $row['id'], 'class-ref-no', true ) . ').';
				}
				if ( $row_errors ) {
					$errors[ $line ] = $row_errors;
				}
				continue;
			}

			if ( $row['title'] === '' ) {
				$row_errors[] = 'Class title is empty.';
			}
			if ( ! in_array( $row['category'], $categories, true ) ) {
				$row_errors[] = 'Category "' . $row['category'] . '" must be one of ' . implode( ', ', $categories ) . '.';
			}
			if ( $row['class-ref-no'] === '' ) {
				$row_errors[] = 'Class no is empty.';
			} elseif ( isset( $class_nos[ $row['class-ref-no'] ] ) ) {
				$row_errors[] = 'Class no ' . $row['class-ref-no'] . ' is also on line ' . $class_nos[ $row['class-ref-no'] ] . '.';
			} else {
				$class_nos[ $row['class-ref-no'] ] = $line;
			}
			if ( ! is_numeric( $row['class-fee'] ) || $row['class-fee'] < 0 ) {
				$row_errors[] = 'Class fee "' . $row['class-fee'] . '" is not a number.';
			}
			if ( $row['class-entrants'] !== 'g' && ! $this->is_int_between( $row['class-entrants'], 1, 10 ) ) {
				$row_errors[] = 'Class entrants "' . $row['class-entrants'] . '" must be 1 to 10 or g.';
			}
			if ( $row['class-min-entrants'] !== '' && ! $this->is_int_between( $row['class-min-entrants'], 1, 10 ) ) {
				$row_errors[] = 'Class min entrants "' . $row['class-min-entrants'] . '" must be blank or 1 to 10.';
			}
			if ( $row['class-sub-category'] === '' ) {
				$row_errors[] = 'Class sub category is empty.';
			}
			foreach ( array( 'lower-age' => 'Lower age', 'upper-age' => 'Upper age' ) as $field => $label ) {
				if ( $row[ $field ] !== '' && ! $this->is_int_between( $row[ $field ], 0, 99 ) ) {
					$row_errors[] = $label . ' "' . $row[ $field ] . '" must be blank or a whole number.';
				}
			}
			if ( $row['lower-age'] !== '' && $row['upper-age'] !== '' && (int) $row['lower-age'] > (int) $row['upper-age'] ) {
				$row_errors[] = 'Lower age is above upper age.';
			}

			if ( $row_errors ) {
				$errors[ $line ] = $row_errors;
			}
		}

		return $errors;
	}

	/**
	 * Find classes (in any status) with a class no, ignoring classes the CSV updates by Id
	 * as those may be renumbered by the same file.
	 *
	 * @param string $class_no class-ref-no to look for
	 * @param array  $rows     rows from read_csv()
	 * @return array post IDs
	 */
	public function find_classes_by_ref_no( $class_no, $rows ) {
		return array_values( array_diff( get_posts( array(
			'post_type'      => 'class',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
			'meta_key'       => 'class-ref-no',
			'meta_value'     => $class_no,
			'fields'         => 'ids',
			'posts_per_page' => -1,
		) ), array_map( 'intval', array_filter( wp_list_pluck( $rows, 'id' ) ) ) ) );
	}

	/**
	 * @return bool true if $value is a whole number string between $min and $max
	 */
	private function is_int_between( $value, $min, $max ) {
		return ctype_digit( (string) $value ) && (int) $value >= $min && (int) $value <= $max;
	}

	/**
	 * Create or update classes from the "New and Updated Classes" CSV.
	 * Rows with a blank Id are created; others update the class with that post ID.
	 *
	 * @param array $rows    validated rows from read_csv()
	 * @param bool  $dry_run when true nothing is written, the changes are only reported
	 * @return array list of changes ( line, action, id, ref, title, changes )
	 */
	public function import_class_csv_rows( $rows, $dry_run ) {

		$meta_keys = array( 'class-ref-no', 'class-fee', 'class-min-entrants', 'class-entrants', 'class-sub-category', 'lower-age', 'upper-age' );
		$results   = array();

		wp_defer_term_counting( true );

		foreach ( $rows as $line => $row ) {

			$term    = get_term_by( 'name', $row['category'], 'class_cat' );
			$changes = array();

			// a blank Id with a class no that already exists (e.g. the file was imported before) updates that class
			if ( $row['id'] === '' ) {
				$existing = $this->find_classes_by_ref_no( $row['class-ref-no'], $rows );
				if ( count( $existing ) === 1 ) {
					$row['id'] = (string) $existing[0];
				}
			}

			if ( $row['id'] === '' ) {

				$action  = 'created';
				$post_id = 0;
				$changes = array( 'Category' => array( '', $row['category'] ) );

				if ( ! $dry_run ) {
					$post_id = wp_insert_post( array(
						'post_title'  => $row['title'],
						'post_status' => 'publish',
						'post_type'   => 'class',
					), true );
					if ( is_wp_error( $post_id ) ) {
						$results[] = array( 'line' => $line, 'action' => 'error', 'id' => '', 'ref' => $row['class-ref-no'], 'title' => $row['title'], 'changes' => array( 'Error' => array( '', $post_id->get_error_message() ) ) );
						continue;
					}
				}

			} else {

				$post_id = (int) $row['id'];
				$post    = get_post( $post_id );

				if ( $post->post_title !== $row['title'] ) {
					$changes['Title'] = array( $post->post_title, $row['title'] );
				}
				if ( $post->post_status !== 'publish' ) {
					$changes['Status'] = array( $post->post_status, 'publish' );
				}
				$current_terms = wp_get_object_terms( $post_id, 'class_cat', array( 'fields' => 'names' ) );
				if ( $current_terms !== array( $row['category'] ) ) {
					$changes['Category'] = array( implode( ', ', $current_terms ), $row['category'] );
				}

				$action = 'updated';

				if ( ! $dry_run && ( isset( $changes['Title'] ) || isset( $changes['Status'] ) ) ) {
					wp_update_post( array(
						'ID'          => $post_id,
						'post_title'  => $row['title'],
						'post_status' => 'publish',
					) );
				}
			}

			foreach ( $meta_keys as $key ) {
				$current = $post_id ? (string) get_post_meta( $post_id, $key, true ) : '';
				if ( $current === $row[ $key ] && $action !== 'created' ) {
					continue;
				}
				$changes[ $key ] = array( $current, $row[ $key ] );
				if ( ! $dry_run ) {
					update_post_meta( $post_id, $key, $row[ $key ] );
				}
			}

			if ( ! $dry_run && isset( $changes['Category'] ) && $term ) {
				wp_set_object_terms( $post_id, (int) $term->term_id, 'class_cat' );
			}

			if ( $action === 'updated' && empty( $changes ) ) {
				$action = 'unchanged';
			}

			$results[] = array(
				'line'     => $line,
				'action'   => $action,
				'id'       => $post_id ? $post_id : '',
				'ref'      => $row['class-ref-no'],
				'title'    => $row['title'],
				'changes'  => $changes,
			);
		}

		wp_defer_term_counting( false );

		return $results;
	}

	/**
	 * Remove classes listed in the "Deleted Classes" CSV from the ordering system.
	 * Classes are set to draft rather than deleted so past invoices and entry reports still resolve them.
	 *
	 * @param array $rows    validated rows from read_csv()
	 * @param bool  $dry_run when true nothing is written
	 * @return array list of changes, see import_class_csv_rows()
	 */
	public function unpublish_class_csv_rows( $rows, $dry_run ) {

		$results = array();

		foreach ( $rows as $line => $row ) {

			$post    = get_post( (int) $row['id'] );
			$action  = $post->post_status === 'publish' ? 'removed' : 'unchanged';
			$changes = $action === 'removed' ? array( 'Status' => array( $post->post_status, 'draft' ) ) : array();

			if ( ! $dry_run && $action === 'removed' ) {
				wp_update_post( array(
					'ID'          => $post->ID,
					'post_status' => 'draft',
				) );
			}

			$results[] = array(
				'line'     => $line,
				'action'   => $action,
				'id'       => $post->ID,
				'ref'      => get_post_meta( $post->ID, 'class-ref-no', true ),
				'title'    => $post->post_title,
				'changes'  => $changes,
			);
		}

		return $results;
	}

	/**
	 * Check every row of the schools CSV before anything is written.
	 * Rows repeated exactly are allowed (the second is ignored); a URN repeated with different details is not.
	 *
	 * @param array  $rows rows from read_csv()
	 * @param string $mode unused, schools have one mode
	 * @return array line number => array of error messages
	 */
	public function validate_school_csv_rows( $rows, $mode ) {

		$errors = array();
		$urns   = array();

		foreach ( $rows as $line => $row ) {

			$row_errors = array();

			if ( ! ctype_digit( $row['urn'] ) ) {
				$row_errors[] = 'URN "' . $row['urn'] . '" must be a number.';
			} elseif ( isset( $urns[ $row['urn'] ] ) && $rows[ $urns[ $row['urn'] ] ] !== $row ) {
				$row_errors[] = 'URN ' . $row['urn'] . ' is also on line ' . $urns[ $row['urn'] ] . ' with different details.';
			} elseif ( ! isset( $urns[ $row['urn'] ] ) ) {
				$urns[ $row['urn'] ] = $line;
			}
			if ( $row['title'] === '' ) {
				$row_errors[] = 'EstablishmentName is empty.';
			}
			if ( $row['establishment_type_group_code'] !== '' && ! ctype_digit( $row['establishment_type_group_code'] ) ) {
				$row_errors[] = 'EstablishmentTypeGroup (code) "' . $row['establishment_type_group_code'] . '" must be blank or a number.';
			}

			if ( $row_errors ) {
				$errors[ $line ] = $row_errors;
			}
		}

		return $errors;
	}

	/**
	 * Replace the schools users can choose from with the schools in the CSV, matched on URN.
	 *
	 * Schools in the file are created or updated and published. Published schools not in the file
	 * are set to draft: get_all_schools_data() only offers published schools, while performers
	 * already linked to them still resolve the title. Their urn meta is kept, as
	 * remove_duplicate_schools_without_urn_post_meta() deletes schools without one.
	 *
	 * @param array $rows    validated rows from read_csv()
	 * @param bool  $dry_run when true nothing is written
	 * @return array list of changes ( line, action, id, ref, title, changes )
	 */
	public function import_school_csv_rows( $rows, $dry_run ) {

		global $wpdb;

		$meta_keys = array( 'establishment_type_group_code', 'establishment_type_group', 'county' );
		// Home Schooled, School not listed, No longer in school, see add_special_schools()
		$protected = array( '999001', '999002', '999003' );
		$results   = array();
		$in_file   = array();

		$schools = $wpdb->get_results(
			"SELECT p.ID, p.post_title, p.post_status, pm.meta_value AS urn
			FROM {$wpdb->posts} p
			LEFT JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_key = 'urn'
			WHERE p.post_type = 'school' AND p.post_status NOT IN ( 'trash', 'auto-draft' )
			ORDER BY p.ID"
		);
		update_meta_cache( 'post', wp_list_pluck( $schools, 'ID' ) );

		$by_urn = array();
		foreach ( $schools as $school ) {
			if ( $school->urn !== null && $school->urn !== '' && ! isset( $by_urn[ $school->urn ] ) ) {
				$by_urn[ $school->urn ] = $school;
			}
		}

		foreach ( $rows as $line => $row ) {

			if ( isset( $in_file[ $row['urn'] ] ) ) {
				continue;
			}
			$in_file[ $row['urn'] ] = true;

			$school  = isset( $by_urn[ $row['urn'] ] ) ? $by_urn[ $row['urn'] ] : null;
			$changes = array();

			if ( ! $school ) {

				$action  = 'created';
				$post_id = 0;
				foreach ( $meta_keys as $key ) {
					$changes[ $key ] = array( '', $row[ $key ] );
				}

				if ( ! $dry_run ) {
					$post_id = wp_insert_post( array(
						'post_author' => get_current_user_id(),
						'post_title'  => $row['title'],
						'post_status' => 'publish',
						'post_type'   => 'school',
					), true );
					if ( is_wp_error( $post_id ) ) {
						$results[] = array( 'line' => $line, 'action' => 'error', 'id' => '', 'ref' => $row['urn'], 'title' => $row['title'], 'changes' => array( 'Error' => array( '', $post_id->get_error_message() ) ) );
						continue;
					}
					update_post_meta( $post_id, 'urn', $row['urn'] );
					foreach ( $meta_keys as $key ) {
						update_post_meta( $post_id, $key, $row[ $key ] );
					}
				}

			} else {

				$action  = 'updated';
				$post_id = (int) $school->ID;

				if ( $school->post_title !== $row['title'] ) {
					$changes['Title'] = array( $school->post_title, $row['title'] );
				}
				if ( $school->post_status !== 'publish' ) {
					$changes['Status'] = array( $school->post_status, 'publish' );
				}
				foreach ( $meta_keys as $key ) {
					$current = (string) get_post_meta( $post_id, $key, true );
					if ( $current !== $row[ $key ] ) {
						$changes[ $key ] = array( $current, $row[ $key ] );
					}
				}

				if ( ! $dry_run ) {
					if ( isset( $changes['Title'] ) || isset( $changes['Status'] ) ) {
						wp_update_post( array(
							'ID'          => $post_id,
							'post_title'  => $row['title'],
							'post_status' => 'publish',
						) );
					}
					foreach ( $meta_keys as $key ) {
						if ( isset( $changes[ $key ] ) ) {
							update_post_meta( $post_id, $key, $row[ $key ] );
						}
					}
				}

				if ( empty( $changes ) ) {
					$action = 'unchanged';
				}
			}

			$results[] = array(
				'line'    => $line,
				'action'  => $action,
				'id'      => $post_id ? $post_id : '',
				'ref'     => $row['urn'],
				'title'   => $row['title'],
				'changes' => $changes,
			);
		}

		foreach ( $schools as $school ) {
			if ( $school->post_status !== 'publish' || isset( $in_file[ (string) $school->urn ] ) || in_array( $school->urn, $protected, true ) ) {
				continue;
			}
			if ( ! $dry_run ) {
				wp_update_post( array(
					'ID'          => $school->ID,
					'post_status' => 'draft',
				) );
			}
			$results[] = array(
				'line'    => '',
				'action'  => 'hidden',
				'id'      => (int) $school->ID,
				'ref'     => $school->urn,
				'title'   => $school->post_title,
				'changes' => array( 'Status' => array( 'publish', 'draft' ) ),
			);
		}

		return $results;
	}

	public function cfpa_class_column($columns) {
		return array_merge($columns,
			array(
				'class-ref-no' => __('Class ID')
			)
		);
	}

	// Register the column as sortable
	public function cfpa_register_sortable_columns( $columns ) {
		$columns['class-ref-no'] = 'Class ID';
		return $columns;
	}

	public function cfpa_class_column_data( $columns ) {
		global $post;
		switch ( $columns ) {
		  case 'class-ref-no':
			echo get_post_meta( $post->ID , 'class-ref-no' , true );
			break;
		}
	}


	public function cfpa_classes() {
		include_once(plugin_dir_path( __FILE__ ) . 'partials/cfpa-classes.php');
	}

	public function cfpa_performers() {
		include_once(plugin_dir_path( __FILE__ ) . 'partials/cfpa-performers.php');
	}

	public function cfpa_baskets() {
		include_once(plugin_dir_path( __FILE__ ) . 'partials/cfpa-baskets.php');
	}

	public function cfpa_invoices() {
		include_once(plugin_dir_path( __FILE__ ) . 'partials/cfpa-invoices.php');
	}

	public function cfpa_entries() {
		include_once(plugin_dir_path( __FILE__ ) . 'partials/cfpa-entries.php');
	}

	public function cfpa_entries_2018() {
		include_once(plugin_dir_path( __FILE__ ) . 'partials/cfpa-entries-2018.php');
	}

	public function cfpa_entries_2019() {
		include_once(plugin_dir_path( __FILE__ ) . 'partials/cfpa-entries-2019.php');
	}

	public function cfpa_entries_2020() {
		include_once(plugin_dir_path( __FILE__ ) . 'partials/cfpa-entries-2020.php');
	}

    public function cfpa_entries_2021() {
		include_once(plugin_dir_path( __FILE__ ) . 'partials/cfpa-entries-2021.php');
	}

    public function cfpa_entries_2022() {
		include_once(plugin_dir_path( __FILE__ ) . 'partials/cfpa-entries-2022.php');
	}

    public function cfpa_entries_2023() {
		include_once(plugin_dir_path( __FILE__ ) . 'partials/cfpa-entries-2023.php');
	}

	public function cfpa_entries_2024() {
		include_once(plugin_dir_path( __FILE__ ) . 'partials/cfpa-entries-2024.php');
	}

	public function cfpa_entries_2025() {
		include_once(plugin_dir_path( __FILE__ ) . 'partials/cfpa-entries-2025.php');
	}

	public function cfpa_entries_2026() {
		include_once(plugin_dir_path( __FILE__ ) . 'partials/cfpa-entries-2026.php');
	}

	public function report_for_invoice_headers() {
		$array = array('Inv. Ref', 'Date', 'User', 'Items', 'Progs', 'Status');
		return $array;
	}

	public function report_for_entry_headers($term_year) {

/*
		$current_year = date('Y',strtotime('today'));
		$last_year = date('Y',strtotime('last year'));

		$this_month = new DateTime('August this year');
		$jan_next_year = new DateTime('Jan next year');


		if($this_month < $jan_next_year) {
			$term_year = $last_year;
		} else {
			$term_year = $current_year;
		}
*/

		$array = array('Class No.','Class Description','Entry Fee','Name of Performer or Group','Place of Education','DoB','Parent Email','Tutor/teacher','Age (as of 31st Aug. '.$term_year.')','Category or No. in Choir','Name of Duet Partner','Place of Education','DoB of Duet','Parent Email','Name of Trio Partner','Place of Education','DoB of Trio','Parent Email','Name of Quartet Partner','Place of Education','DoB of Quartet','Parent Email','Title','Account Holder','Position','Address 1','Address 2','Address 3','Town/City','County','Postcode','Email','Telephone','Marketing','INV','Inv Amount','Paid','Date Paid'
		);
		return $array;
	}

	public function performers_as_array($array) {

		$array = str_replace(', ',',', $array);
		$performers = explode(',', $array);
		return $performers;
	}

	public function get_authors_children($author_id){
		global $wpdb;

		$table_name = $wpdb->prefix . 'cfpa_children';
		$children = $wpdb->get_results(
			"
			SELECT child_id, child_name, user_id, registered_date, child_dob, child_exception_date, last_edit, child_school, parent_email
			FROM $table_name
			WHERE user_id = $author_id
			"
		);

		return $children;
	}

	public function get_invoice_total($post_id){

		global $wpdb;

		$table_name = $wpdb->prefix . 'cfpa_purchases';
		$purchase = $wpdb->get_results(
			"
			SELECT post_id, purchase_cost
			FROM $table_name
			WHERE post_id = $post_id
			"
		);
		if ($purchase) {
			foreach ($purchase as $purchase_cost) {
				$total = $purchase_cost->purchase_cost;
			}
			return $total;
		}
		return;
	}

	public function get_child_dob_by_name($authors_children, $child_name) {
		if ($child_name == null){
			return;
		}
		foreach($authors_children as $author_child) {
			if ($author_child->child_name == $child_name) {
				$dob = $author_child->child_dob;
				return $dob;
			}
		}
		return;

	}

	public function get_child_school($authors_children, $child_name) {
		if ($child_name == null){
			return;
		}
		foreach($authors_children as $author_child) {
			if ($author_child->child_name == $child_name) {
				$school = $author_child->child_school;
				if(is_numeric($school)) {
					$spost = get_post($school);
					$school = $spost->post_title;
				}
				return $school;
			}
		}
		return;
	}

	public function get_child_parent_email($authors_children, $child_name) {
		if ($child_name == null){
			return;
		}
		foreach($authors_children as $author_child) {
			if ($author_child->child_name == $child_name) {
				$parent_email = $author_child->parent_email;
				return $parent_email;
			}
		}
		return;
	}

	public function get_performers_age($term_year, $dob) {

		$term_year = new DateTime('31st August ' . $term_year);
		$dob = new DateTime($dob);
		$age = $dob->diff($term_year);
		$years_old = $age->y;
		return $years_old;
	}

	public function get_qualifying_age($class_cat, $dob) {

		$from = new DateTime($dob);
		$to   = new DateTime('today');

		$current_year = date('Y',strtotime('today'));
		$last_year = date('Y',strtotime('last year'));

		$this_month = new DateTime('August this year');

		$jan_next_year = new DateTime('Jan next year');

		if($this_month < $jan_next_year) {

			//$term_year = $current_year;

			$current_music_drama_termstart = new DateTime('31st Aug ' . $current_year);
			$current_dance_termstart = new DateTime('1st Jan ' . $current_year);
		} else {

			//$term_year = $last_year;

			$current_music_drama_termstart = new DateTime('31st Aug ' . $last_year);
			$current_dance_termstart = new DateTime('1st Jan ' . $current_year);
		}


/*
		$current_music_drama_termstart = new DateTime('31st Aug ' . $last_year);
		$current_dance_termstart = new DateTime('1st Jan ' . $current_year);
*/

		if ($class_cat == 'music' || $class_cat == 'drama') {
			$q_age = $from->diff($current_music_drama_termstart)->y;
			return $q_age;
		}
		if ($class_cat == 'dance') {
			$q_age = $from->diff($current_dance_termstart)->y;
			return $q_age;
		}
		return;

	}


	public function get_class_category($post_id) {
		$terms = wp_get_object_terms($post_id, 'class_cat');
		if ($terms) {
			$class_cat = $terms[0]->slug;
			return $class_cat;
		}
		return;
	}

	public function get_invoice_item_programmes($inv_item) {
		if (strpos($inv_item, ' x ')) {
			$programmes = $inv_item;
			return $programmes;
		}
		return;
	}

	/**
	 * Check if a class is eligble for groups
	 */
	public function check_if_group_class($class_id) {
		$is_group = false;
		if(get_post_meta($class_id, 'class-entrants', true) == 'g') {
			$is_group = true;
		}
		return $is_group;
	}

	/**
	 * Get the number of members in a group
	 *
	 * @param int $user_id
	 * @return int $no_in_group
	 */
	public function get_number_of_group_members($user_id) {
		global $wpdb;
		$tablename = $wpdb->prefix;

		$sql = $wpdb->prepare( "SELECT group_number FROM {$wpdb->prefix}cfpa_groups WHERE user_id = %s",$user_id );
		$results = $wpdb->get_results( $sql , ARRAY_A );
		return $results;
	}
	/**
	 * Get all entries.
	 *
	 * @since    1.0.2
	 * @param      string    $date       The date "from" to get entries in db.
	 *
	 * @return  array    $entries    all data needed to output in a data table
	 */
	public function report_for_entries($date = null) {
		$entries = array();
		$invoices = $this->report_for_invoices($date);

		// set the term year for later uses of DOB as at 31st Aug this term
		$term_year = date('Y', strtotime($date));

		$i = 0;
		foreach($invoices as $invoice) {
			$inv_items = get_post_meta( $invoice->ID, 'inv_item' );
			$inv_status = get_post_meta( $invoice->ID, 'inv_status', true );
			$author_id = $invoice->post_author;
			$author_data = get_userdata( $author_id );
			//var_dump($author_data);
			$authors_children = $this->get_authors_children($author_id);

			foreach ($inv_items as $inv_item) {
				$entries[$i]['class_id'] = $inv_item['class_id'];
				$entries[$i]['class_number'] = get_post_meta( $inv_item['class_id'], 'class-ref-no', true );
				$entries[$i]['tutor_teacher'] = $inv_item["tutor_teacher"];
				$entries[$i]['class_description'] = get_the_title( $inv_item['class_id'] );
				$entries[$i]['class_fee'] = number_format( intval(get_post_meta( $inv_item['class_id'], 'class-fee', true )) ,2);
				$performers = $this->performers_as_array($inv_item['performers']);

				$entries[$i]['class_performer_one'] = $performers[0];
				$entries[$i]['class_performer_one_school'] = $this->get_child_school($authors_children, $performers[0]);
				$entries[$i]['class_performer_one_dob'] = $this->get_child_dob_by_name($authors_children, $performers[0]);
				$entries[$i]['class_performer_one_qualifying_age'] = $this->get_performers_age($term_year,$this->get_child_dob_by_name($authors_children, $performers[0]));
				$entries[$i]['class_performer_one_parent_email'] = $this->get_child_parent_email($authors_children, $performers[0]);

				$is_group = $this->check_if_group_class($inv_item['class_id']);
				if($is_group) {
					$no_in_group = $this->get_number_of_group_members($author_id);
					$entries[$i]['class_category'] = $no_in_group[0]['group_number'];
				} else {
					$entries[$i]['class_category'] = ucfirst($this->get_class_category($inv_item['class_id']));
				}

				if (count($performers) >= 2) {
					$entries[$i]['class_performer_two'] = $performers[1];
					$entries[$i]['class_performer_two_school'] = $this->get_child_school($authors_children, $performers[1]);
					$entries[$i]['class_performer_two_dob'] = $this->get_child_dob_by_name($authors_children, $performers[1]);
					$entries[$i]['class_performer_two_qualifying_age'] = $this->get_performers_age($term_year,$this->get_child_dob_by_name($authors_children, $performers[1]));
					$entries[$i]['class_performer_two_parent_email'] = $this->get_child_parent_email($authors_children, $performers[1]);
				}
				if (count($performers) >= 3) {
					$entries[$i]['class_performer_three'] = $performers[2];
					$entries[$i]['class_performer_three_school'] = $this->get_child_school($authors_children, $performers[2]);
					$entries[$i]['class_performer_three_dob'] = $this->get_child_dob_by_name($authors_children, $performers[2]);
					$entries[$i]['class_performer_three_qualifying_age'] = $this->get_performers_age($term_year,$this->get_child_dob_by_name($authors_children, $performers[2]));
					$entries[$i]['class_performer_three_parent_email'] = $this->get_child_parent_email($authors_children, $performers[2]);
				}
				if (count($performers) >= 4) {
					$entries[$i]['class_performer_four'] = $performers[3];
					$entries[$i]['class_performer_four_school'] = $this->get_child_school($authors_children, $performers[3]);
					$entries[$i]['class_performer_four_dob'] = $this->get_child_dob_by_name($authors_children, $performers[3]);
					$entries[$i]['class_performer_four_qualifying_age'] = $this->get_performers_age($term_year,$this->get_child_dob_by_name($authors_children, $performers[3]));
					$entries[$i]['class_performer_four_parent_email'] = $this->get_child_parent_email($authors_children, $performers[3]);
				}

				$entries[$i]['author_title'] = get_user_meta( $author_id, 'salutation', true );
				$entries[$i]['author_name'] = get_user_meta( $author_id, 'nickname', true );
				$entries[$i]['author_position'] = get_user_meta( $author_id, 'user_position', true );
				$entries[$i]['author_address_1'] = get_user_meta( $author_id, 'address_1', true );
				$entries[$i]['author_address_2'] = get_user_meta( $author_id, 'address_2', true );
				$entries[$i]['author_address_3'] = get_user_meta( $author_id, 'address_3', true );
				$entries[$i]['author_town'] = get_user_meta( $author_id, 'town', true );
				$entries[$i]['author_city'] = get_user_meta( $author_id, 'city', true );
				$entries[$i]['author_postcode'] = get_user_meta( $author_id, 'postcode', true );
				$entries[$i]['author_email'] = $author_data->user_email;
				$entries[$i]['author_tel'] = get_user_meta( $author_id, 'telephone', true );
				$entries[$i]['marketing_permission'] = get_user_meta( $author_id, 'marketing_permission', true );
				$entries[$i]['invoice_ref'] = get_the_title( $invoice->ID );
				$entries[$i]['invoice_cost'] = number_format($this->get_invoice_total($invoice->ID) / 100, 2);
				$entries[$i]['invoice_status'] = $inv_status;
				$entries[$i]['invoice_paid_date'] = $invoice->post_date;
				//var_dump($performers);
				$i++;
			}
			//var_dump($inv_items);
		}
		//var_dump($entries);
		return $entries;
	}

	public function report_for_invoices($date = null) {
		global $wpdb;
		$tablename = $wpdb->prefix;

		$enddate = date('Y-m-d', strtotime($date . ' + 1 year')) . ' 00:00:00';

		if ($date) {
			$sql = $wpdb->prepare( "SELECT ID, post_author FROM {$wpdb->prefix}posts WHERE post_type = %s AND post_date >= '{$date}' AND post_date <= '{$enddate}'",'invoice' );
		} else {
			$sql = $wpdb->prepare( "SELECT ID, post_author FROM {$wpdb->prefix}posts WHERE post_type = %s",'invoice' );
		}

		$results = $wpdb->get_results( $sql , ARRAY_A );

		$invoices = array();
		foreach ($results as $result) {
			$invoices[] = get_post($result['ID']);
		}

		return $invoices;
	}

	public function report_for_classes() {
		global $wpdb;
		$tablename = $wpdb->prefix;

		$sql = $wpdb->prepare( "
			SELECT ID, post_title
			FROM {$wpdb->prefix}posts
			WHERE post_type = %s
			AND post_status = 'publish'",'class' );

		$results = $wpdb->get_results( $sql , ARRAY_A );

		$array = array();
		$i=0;
		foreach ($results as $k => $result) {
			$array[$k]['id'] = $result['ID'];
			$array[$k]['class_title'] = $result['post_title'];
			$array[$k]['class_no'] = get_post_meta( $result['ID'], 'class-ref-no', true );
			$array[$k]['lower_age'] = get_post_meta( $result['ID'], 'lower-age', true );
			$array[$k]['upper_age'] = get_post_meta( $result['ID'], 'upper-age', true );
			$array[$k]['class_fee'] = get_post_meta( $result['ID'], 'class-fee', true );
			$array[$k]['class_entrants'] = get_post_meta( $result['ID'], 'class-entrants', true );
			$array[$k]['class_min_entrants'] = get_post_meta( $result['ID'], 'class-min-entrants', true );
			$array[$k]['class_sub_category'] = get_post_meta( $result['ID'], 'class-sub-category', true );
			$i++;
		}

		return $array;
	}

	public function report_for_performers() {
		global $wpdb;
		$tablename = $wpdb->prefix;

		$sql = $wpdb->prepare( "SELECT child_id, child_name, child_school, user_id, registered_date, child_dob, parent_email FROM {$wpdb->prefix}cfpa_children",$tablename );
		$results = $wpdb->get_results( $sql , ARRAY_A );

		return $results;
	}

	public function report_for_classes_headers() {
		$results = $this->report_for_classes();
		foreach ($results as $result) {
			$keys = array_keys($result);
		}

		$results = array_unique($keys);

		return $results;
	}

	public function report_for_performers_headers() {
		$results = $this->report_for_performers();
		foreach ($results as $result) {
			$keys = array_keys($result);
		}

		$results = array_unique($keys);

		return $results;
	}

	public function report_for_baskets($date = null) {
		global $wpdb;
		$tablename = $wpdb->prefix;

		if ($date) {
			$sql = $wpdb->prepare( "SELECT basket_id, user_id, basket_items, basket_generate_date FROM {$wpdb->prefix}cfpa_basket_meta WHERE basket_generate_date >= '{$date}'",$date );
		} else {
			$sql = $wpdb->prepare( "SELECT basket_id, user_id, basket_items, basket_generate_date FROM {$wpdb->prefix}cfpa_basket_meta",$tablename );
		}
		$results = $wpdb->get_results( $sql , ARRAY_A );

		return $results;

	}

	public function report_for_baskets_headers() {
		$results = $this->report_for_baskets();
		foreach ($results as $result) {
			$keys = array_keys($result);
		}

		$results = array_unique($keys);

		return $results;
	}



	public function cfpa_booking_widgets_init() {

		register_sidebar( array(
			'name'          => __( 'Account Booking', 'cfpa_theme' ),
			'id'            => 'account-booking',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="wgt %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="leader"><i class="fa fa-shopping-basket" aria-hidden="true"></i> ',
			'after_title'   => '</h3>',
		) );

	}

/*
	public function cfpa_login_stylesheet() {
		wp_enqueue_style( $this->CFPA_Booking_System, plugin_dir_url( __FILE__ ) . 'css/cfpa-login-styles.css', array(), $this->version, 'all' );
	    //wp_enqueue_script( 'custom-login', get_template_directory_uri() . '/style-login.js' );
	}
*/

	/**
	 * Get the value of a settings field
	 *
	 * @param string $option settings field name
	 * @param string $section the section name this field belongs to
	 * @param string $default default text if it's not found
	 * @return mixed
	 */
	public function my_cfpa_option( $option, $section, $default = '' ) {

	    $options = get_option( $section );

	    if ( isset( $options[$option] ) ) {
	        return $options[$option];
	    }

	    return $default;
	}

	public function cfpa_login_extra_note($message) {

		//var_dump($_GET);
		if (isset($_GET) && $_GET['action'] == 'rp') {
			$message = '<p class="message reset-pass">Enter a memorable password below or use suggested, then click "Reset Password"</p>';
			echo $message;
		}

		if (isset($_GET) && !empty($_GET['action'])) {
			if ($_GET['action'] == 'resetpass') {
				echo '<p class="message">Your password was reset, <a href="/wp-login.php">login here.</a></p>';
			}
			return;
		}

		$options = $this->my_cfpa_option('login_message','wedevs_login');

		if ($options) { ?>

<div class="create-account message">

    <?php echo $options; ?>

</div>

<?php }

	}

	/**
	 * Create the custom post type for all Classes
	 */
	public function register_cpt_class() {

		$labels = array(
			'name' => __( 'Classes', 'class' ),
			'singular_name' => __( 'Class', 'class' ),
			'add_new' => __( 'Add New', 'class' ),
			'add_new_item' => __( 'Add New Class', 'class' ),
			'edit_item' => __( 'Edit Class', 'class' ),
			'new_item' => __( 'New Class', 'class' ),
			'view_item' => __( 'View Class', 'class' ),
			'search_items' => __( 'Search Classes', 'class' ),
			'not_found' => __( 'No classes found', 'class' ),
			'not_found_in_trash' => __( 'No classes found in Trash', 'class' ),
			'parent_item_colon' => __( 'Parent Class:', 'class' ),
			'menu_name' => __( 'Classes', 'class' ),
		);

		$args = array(
			'labels' => $labels,
			'hierarchical' => false,
			// 'custom-fields' is required for the REST API to expose the meta registered below;
			// the classic Custom Fields box it adds is removed in remove_class_custom_fields_box().
			'supports' => array( 'title','editor','custom-fields' ),
			'taxonomies' => array( 'classcat' ),
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 20,
			'menu_icon' => 'dashicons-groups',
			'show_in_nav_menus' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'has_archive' => false,
			'query_var' => true,
			'can_export' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'show_in_rest' => true
		);

		register_post_type( 'class', $args );

		$this->register_class_meta();
	}

	/**
	 * Expose the class meta keys to the REST API / block editor.
	 * Values are stored as strings by the CMB fields, so they are registered as such.
	 */
	public function register_class_meta() {

		$meta_keys = array(
			'class-ref-no',
			'class-fee',
			'class-min-entrants',
			'class-entrants',
			'class-sub-category',
			'lower-age',
			'upper-age',
		);

		foreach ( $meta_keys as $key ) {
			register_post_meta( 'class', $key, array(
				'type'         => 'string',
				'single'       => true,
				'show_in_rest' => true,
			) );
		}
	}

	/**
	 * Keep the class edit screen as it was: class meta is managed by the CMB box,
	 * not the generic Custom Fields box that 'custom-fields' support switches on.
	 */
	public function remove_class_custom_fields_box() {
		remove_meta_box( 'postcustom', 'class', 'normal' );
	}

	// Register Custom Taxonomy
	public function classcat() {

		$labels = array(
			'name'                       => _x( 'Category', 'Taxonomy General Name', 'cfpa_booking' ),
			'singular_name'              => _x( 'Categories', 'Taxonomy Singular Name', 'cfpa_booking' ),
			'menu_name'                  => __( 'Categories', 'cfpa_booking' ),
			'all_items'                  => __( 'All Items', 'cfpa_booking' ),
			'parent_item'                => __( 'Parent Item', 'cfpa_booking' ),
			'parent_item_colon'          => __( 'Parent Item:', 'cfpa_booking' ),
			'new_item_name'              => __( 'New Item Name', 'cfpa_booking' ),
			'add_new_item'               => __( 'Add New Item', 'cfpa_booking' ),
			'edit_item'                  => __( 'Edit Item', 'cfpa_booking' ),
			'update_item'                => __( 'Update Item', 'cfpa_booking' ),
			'view_item'                  => __( 'View Item', 'cfpa_booking' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'cfpa_booking' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'cfpa_booking' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'cfpa_booking' ),
			'popular_items'              => __( 'Popular Items', 'cfpa_booking' ),
			'search_items'               => __( 'Search Items', 'cfpa_booking' ),
			'not_found'                  => __( 'Not Found', 'cfpa_booking' ),
			'no_terms'                   => __( 'No items', 'cfpa_booking' ),
			'items_list'                 => __( 'Items list', 'cfpa_booking' ),
			'items_list_navigation'      => __( 'Items list navigation', 'cfpa_booking' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'show_in_rest'               => true,
		);
		register_taxonomy( 'class_cat', array( 'class' ), $args );

	}

	/**
	 * Create the custom post type for all Invoices
	 */
	public function register_cpt_invoice() {

		$labels = array(
			'name' => __( 'Invoices', 'invoice' ),
			'singular_name' => __( 'Invoice', 'invoice' ),
			'add_new' => __( 'Add New', 'invoice' ),
			'add_new_item' => __( 'Add New Invoice', 'invoice' ),
			'edit_item' => __( 'Edit Invoice', 'invoice' ),
			'new_item' => __( 'New Invoice', 'invoice' ),
			'view_item' => __( 'View Invoice', 'invoice' ),
			'search_items' => __( 'Search Invoices', 'invoice' ),
			'not_found' => __( 'No invoices found', 'invoice' ),
			'not_found_in_trash' => __( 'No invoices found in Trash', 'invoice' ),
			'parent_item_colon' => __( 'Parent Invoice:', 'invoice' ),
			'menu_name' => __( 'Invoices', 'invoice' ),
		);

		$args = array(
			'labels' => $labels,
			'hierarchical' => false,
			'supports' => array( 'title', 'author', 'revisions' ),
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_icon' => 'dashicons-list-view',
			'show_in_nav_menus' => false,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'has_archive' => false,
			'query_var' => true,
			'can_export' => true,
			'rewrite' => true,
			'capability_type' => 'post'
		);

		register_post_type( 'invoice', $args );
	}

	/**
	 * Registers the `school` post type.
	 */
	public function school_init() {
		register_post_type( 'school', array(
			'labels'                => array(
				'name'                  => __( 'Schools', 'cfpa-booking' ),
				'singular_name'         => __( 'School', 'cfpa-booking' ),
				'all_items'             => __( 'All Schools', 'cfpa-booking' ),
				'archives'              => __( 'School Archives', 'cfpa-booking' ),
				'attributes'            => __( 'School Attributes', 'cfpa-booking' ),
				'insert_into_item'      => __( 'Insert into School', 'cfpa-booking' ),
				'uploaded_to_this_item' => __( 'Uploaded to this School', 'cfpa-booking' ),
				'featured_image'        => _x( 'Featured Image', 'school', 'cfpa-booking' ),
				'set_featured_image'    => _x( 'Set featured image', 'school', 'cfpa-booking' ),
				'remove_featured_image' => _x( 'Remove featured image', 'school', 'cfpa-booking' ),
				'use_featured_image'    => _x( 'Use as featured image', 'school', 'cfpa-booking' ),
				'filter_items_list'     => __( 'Filter Schools list', 'cfpa-booking' ),
				'items_list_navigation' => __( 'Schools list navigation', 'cfpa-booking' ),
				'items_list'            => __( 'Schools list', 'cfpa-booking' ),
				'new_item'              => __( 'New School', 'cfpa-booking' ),
				'add_new'               => __( 'Add New', 'cfpa-booking' ),
				'add_new_item'          => __( 'Add New School', 'cfpa-booking' ),
				'edit_item'             => __( 'Edit School', 'cfpa-booking' ),
				'view_item'             => __( 'View School', 'cfpa-booking' ),
				'view_items'            => __( 'View Schools', 'cfpa-booking' ),
				'search_items'          => __( 'Search Schools', 'cfpa-booking' ),
				'not_found'             => __( 'No Schools found', 'cfpa-booking' ),
				'not_found_in_trash'    => __( 'No Schools found in trash', 'cfpa-booking' ),
				'parent_item_colon'     => __( 'Parent School:', 'cfpa-booking' ),
				'menu_name'             => __( 'Schools', 'cfpa-booking' ),
			),
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => array( 'title', 'author', 'revisions' ),
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => 20,
			'menu_icon'             => 'dashicons-welcome-learn-more',
			'show_in_rest'          => true,
			'rest_base'             => 'school',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		) );

	}

	// Register Custom Taxonomy
	// public function towncity() {

	// 	$labels = array(
	// 		'name'                       => _x( 'Town Cities', 'Taxonomy General Name', 'cfpa_booking' ),
	// 		'singular_name'              => _x( 'Town City', 'Taxonomy Singular Name', 'cfpa_booking' ),
	// 		'menu_name'                  => __( 'Town City', 'cfpa_booking' ),
	// 		'all_items'                  => __( 'All Items', 'cfpa_booking' ),
	// 		'parent_item'                => __( 'Parent Item', 'cfpa_booking' ),
	// 		'parent_item_colon'          => __( 'Parent Item:', 'cfpa_booking' ),
	// 		'new_item_name'              => __( 'New Item Name', 'cfpa_booking' ),
	// 		'add_new_item'               => __( 'Add New Item', 'cfpa_booking' ),
	// 		'edit_item'                  => __( 'Edit Item', 'cfpa_booking' ),
	// 		'update_item'                => __( 'Update Item', 'cfpa_booking' ),
	// 		'view_item'                  => __( 'View Item', 'cfpa_booking' ),
	// 		'separate_items_with_commas' => __( 'Separate items with commas', 'cfpa_booking' ),
	// 		'add_or_remove_items'        => __( 'Add or remove items', 'cfpa_booking' ),
	// 		'choose_from_most_used'      => __( 'Choose from the most used', 'cfpa_booking' ),
	// 		'popular_items'              => __( 'Popular Items', 'cfpa_booking' ),
	// 		'search_items'               => __( 'Search Items', 'cfpa_booking' ),
	// 		'not_found'                  => __( 'Not Found', 'cfpa_booking' ),
	// 		'no_terms'                   => __( 'No items', 'cfpa_booking' ),
	// 		'items_list'                 => __( 'Items list', 'cfpa_booking' ),
	// 		'items_list_navigation'      => __( 'Items list navigation', 'cfpa_booking' ),
	// 	);
	// 	$args = array(
	// 		'labels'                     => $labels,
	// 		'hierarchical'               => false,
	// 		'public'                     => true,
	// 		'show_ui'                    => true,
	// 		'show_admin_column'          => true,
	// 		'show_in_nav_menus'          => true,
	// 		'show_tagcloud'              => true,
	// 	);
	// 	register_taxonomy( 'towncity', array( 'school' ), $args );

	// }


	/**
	 * Sets the post updated messages for the `school` post type.
	 *
	 * @param  array $messages Post updated messages.
	 * @return array Messages for the `school` post type.
	 */
	public function school_updated_messages( $messages ) {
		global $post;

		$permalink = get_permalink( $post );

		$messages['school'] = array(
			0  => '', // Unused. Messages start at index 1.
			/* translators: %s: post permalink */
			1  => sprintf( __( 'School updated. <a target="_blank" href="%s">View School</a>', 'cfpa-booking' ), esc_url( $permalink ) ),
			2  => __( 'Custom field updated.', 'cfpa-booking' ),
			3  => __( 'Custom field deleted.', 'cfpa-booking' ),
			4  => __( 'School updated.', 'cfpa-booking' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'School restored to revision from %s', 'cfpa-booking' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			/* translators: %s: post permalink */
			6  => sprintf( __( 'School published. <a href="%s">View School</a>', 'cfpa-booking' ), esc_url( $permalink ) ),
			7  => __( 'School saved.', 'cfpa-booking' ),
			/* translators: %s: post permalink */
			8  => sprintf( __( 'School submitted. <a target="_blank" href="%s">Preview School</a>', 'cfpa-booking' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
			/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
			9  => sprintf( __( 'School scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview School</a>', 'cfpa-booking' ),
			date_i18n( __( 'M j, Y @ G:i', 'cfpa-booking' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
			/* translators: %s: post permalink */
			10 => sprintf( __( 'School draft updated. <a target="_blank" href="%s">Preview School</a>', 'cfpa-booking' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		);

		return $messages;
	}

	/**
	 * Define the metabox and field configurations.
	 *
	 * @param  array $meta_boxes
	 * @return array
	 */
	function school_cmb( array $meta_boxes ) {


		$fields = array(

			array(
				'id' => 'urn',
				'name' => 'Uniform Resource Name',
				'type' => 'number',
				'disabled' => true
			),
			array(
				'id' => 'establishment_type_group_code',
				'name' => 'Establishment Type Group (code)',
				'type' => 'text',
			),
			array(
				'id' => 'establishment_type_group',
				'name' => 'Establishment Type Group',
				'type' => 'text',
			),
			array(
				'id' => 'county',
				'name' => 'County',
				'type' => 'text',
			),
			array(
				'id' => 'main_email',
				'name' => 'Main Email',
				'type' => 'email'
			),
			array(
				'id' => 'head_title',
				'name' => 'Head Title',
				'type' => 'text'
			),
			array(
				'id' => 'head_first_name',
				'name' => 'Head First Name',
				'type' => 'text',
			),
			array(
				'id' => 'head_last_name',
				'name' => 'Head Last Name',
				'type' => 'text',
			),

		);

		$meta_boxes[] = array(
			'title' => 'School Data',
			'pages' => 'school',
			'context' => 'normal',
			'fields' => $fields
		);

		// Examples of Groups and Columns


		return $meta_boxes;

	}



	/**
	 * Define the metabox and field configurations.
	 *
	 * @param  array $meta_boxes
	 * @return array
	 */
	public function invoice_cmb( array $meta_boxes ) {

		// Example of all available fields

		$invoice_items = array(

			array( 'id' => 'class_id', 'name' => 'Class', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'class', 'posts_per_page' => -1 ),'cols' => 4 ),
			array( 'id' => 'performers',  'name' => 'Performers', 'type' => 'text','cols' => 3  ),
			array( 'id' => 'tutor_teacher',  'name' => 'Tutor/teacher', 'type' => 'text','cols' => 3  ),
			array( 'id' => 'cost',  'name' => 'Cost', 'type' => 'text','cols' => 2  ),
/*
	 		array( 'id' => 'field-3', 'name' => 'Repeatable text input field', 'type' => 'text', 'desc' => 'Add up to 5 fields.', 'repeatable' => true, 'repeatable_max' => 5, 'sortable' => true, 'cols' => 4 ),

			array( 'id' => 'field-4',  'name' => 'Small text input field', 'type' => 'text_small' ),
			array( 'id' => 'field-5',  'name' => 'URL field', 'type' => 'url' ),

			array( 'id' => 'field-6',  'name' => 'Radio input field', 'type' => 'radio', 'options' => array( 'Option 1', 'Option 2' ) ),
			array( 'id' => 'field-7',  'name' => 'Checkbox field', 'type' => 'checkbox' ),

			array( 'id' => 'field-8',  'name' => 'WYSIWYG field', 'type' => 'wysiwyg', 'options' => array( 'editor_height' => '100' ), 'repeatable' => true, 'sortable' => true ),

			array( 'id' => 'field-9',  'name' => 'Textarea field', 'type' => 'textarea' ),
			array( 'id' => 'field-10',  'name' => 'Code textarea field', 'type' => 'textarea_code' ),

			array( 'id' => 'field-11', 'name' => 'File field', 'type' => 'file', 'file_type' => 'image', 'repeatable' => 1, 'sortable' => 1 ),
			array( 'id' => 'field-12', 'name' => 'Image upload field', 'type' => 'image', 'repeatable' => true, 'show_size' => true ),

			array( 'id' => 'field-13', 'name' => 'Select field', 'type' => 'select', 'options' => array( 'option-1' => 'Option 1', 'option-2' => 'Option 2', 'option-3' => 'Option 3' ), 'allow_none' => true, 'sortable' => true, 'repeatable' => true ),
			array( 'id' => 'field-14', 'name' => 'Select field', 'type' => 'select', 'options' => array( 'option-1' => 'Option 1', 'option-2' => 'Option 2', 'option-3' => 'Option 3' ), 'multiple' => true ),
			array( 'id' => 'field-15', 'name' => 'Select taxonomy field', 'type' => 'taxonomy_select',  'taxonomy' => 'category' ),
			array( 'id' => 'field-15b', 'name' => 'Select taxonomy field', 'type' => 'taxonomy_select',  'taxonomy' => 'category',  'multiple' => true ),
			array( 'id' => 'field-16', 'name' => 'Post select field', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'cat' => 1 ) ),
			array( 'id' => 'field-17', 'name' => 'Post select field (AJAX)', 'type' => 'post_select', 'use_ajax' => true ),
			array( 'id' => 'field-17b', 'name' => 'Post select field (AJAX)', 'type' => 'post_select', 'use_ajax' => true, 'query' => array( 'posts_per_page' => 8 ), 'multiple' => true  ),

			array( 'id' => 'field-18', 'name' => 'Date input field', 'type' => 'date', 'cols' => 4 ),
			array( 'id' => 'field-19', 'name' => 'Time input field', 'type' => 'time',  'cols' => 4),
			array( 'id' => 'field-20', 'name' => 'Date (unix) input field', 'type' => 'date_unix' ),
			array( 'id' => 'field-21', 'name' => 'Date & Time (unix) input field', 'type' => 'datetime_unix' ),

			array( 'id' => 'field-22', 'name' => 'Color', 'type' => 'colorpicker' ),

			array( 'id' => 'field-23', 'name' => 'Location', 'type' => 'gmap' ),

			array( 'id' => 'field-24', 'name' => 'Title Field', 'type' => 'title' ),
*/

		);


		$programmes_ordered = array(
			array( 'id' => 'program_quantity', 'name' => 'Quantity', 'type' => 'text', 'cols' => 4 ),
			array( 'id' => 'program_description',  'name' => 'Description', 'type' => 'text','cols' => 6  ),
			array( 'id' => 'program_cost',  'name' => 'Cost', 'type' => 'text','cols' => 2  ),
		);

		$pandp = array(
			array( 'id' => 'pandp_quantity', 'name' => 'Quantity', 'type' => 'text', 'cols' => 4 ),
			array( 'id' => 'pandp_description',  'name' => 'Description', 'type' => 'text','cols' => 6  ),
			array( 'id' => 'pandp_cost',  'name' => 'Cost', 'type' => 'text','cols' => 2  ),
		);

		$invoice_status = array(
			array( 'id' => 'inv_status', 'name' => 'Status', 'type' => 'select', 'options' => array( 'unpaid' => 'Unpaid', 'paid' => 'Paid' ), 'allow_none' => false ),
	 		array( 'id' => 'inv_notify', 'name' => 'Notifications', 'type' => 'text', 'desc' => 'Add up to 5 email addresses.', 'repeatable' => true, 'repeatable_max' => 5, 'sortable' => true ),
		);


		$meta_boxes[] = array(
			'title' => 'Invoice Settings',
			'pages' => 'invoice',
			'context' => 'side',
			'fields' => $invoice_status
		);


		// Example of repeatable group. Using all fields.
		// For this example, copy fields from $fields, update I
		$group_fields = $invoice_items;
		foreach ( $group_fields as &$field ) {
			$field['id'] = str_replace( 'field', 'gfield', $field['id'] );
		}

		$meta_boxes[] = array(
			'title' => 'Invoice Items',
			'pages' => 'invoice',
			'fields' => array(
				array(
					'id' => 'inv_item',
// 					'name' => 'My Repeatable Group',
					'type' => 'group',
					'repeatable' => true,
					'sortable' => true,
					'fields' => $group_fields,
// 					'desc' => 'This is the group description.'
				)
			)
		);

		$meta_boxes[] = array(
			'title' => 'Programmes',
			'pages' => 'invoice',
			'fields' => $programmes_ordered
		);

		$meta_boxes[] = array(
			'title' => 'Postage',
			'pages' => 'invoice',
			'fields' => $pandp
		);


		return $meta_boxes;

	}


	/**
	 * Define the metabox and field configurations.
	 *
	 * @param  array $meta_boxes
	 * @return array
	 */
	function cfpa_cmb( array $meta_boxes ) {


		$fields = array(

			array(
				'id' => 'class-ref-no',
				'name' => 'Class No.',
				'type' => 'text',
				'cols' => 3
			),
			array(
				'id' => 'class-fee',
				'name' => 'Class Fee',
				'type' => 'text',
				'cols' => 3,
			),
			array(
				'id' => 'class-min-entrants',
				'name' => 'Class Min. Entrants',
				'type' => 'select',
				'cols' => 3,
				'options' => array(
					'' => 'N/A',
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
					'7' => '7',
					'8' => '8',
					'9' => '9',
					'10' => '10',
				)
			),
			array(
				'id' => 'class-entrants',
				'name' => 'Class Entrants',
				'type' => 'select',
				'cols' => 3,
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
					'7' => '7',
					'8' => '8',
					'9' => '9',
					'10' => '10',
					'g' => 'Group'
				)
			),
			array(
				'id' => 'class-sub-category',
				'name' => 'Class Sub Category',
				'type' => 'select',
				'allow_none' => true,
				'cols' => 4,
				'desc' => 'Optional sub category only applicable to music classes',
				'options' => array(
					'all' => 'All',
					'--dance--' => '--Dance--',
					'ballet' => 'Ballet',
					'classical' => 'Classical',
					'character' => 'Character',
					'national' => 'National',
					'cabaret' => 'Cabaret',
					'tap' => 'Tap',
					'modern' => 'Modern',
					'lyrical' => 'Lyrical',
					'--drama--' => '--Drama--',
					'verse speaking' => 'Verse Speaking',
					'prose reading' => 'Prose Reading',
					'acting' => 'Acting',
					'--music--' => '--Music--',
					'choir' => 'Choir',
					'piano' => 'Piano',
					'string' => 'String',
					'string or wind' => 'String or Wind',
					'vocal' => 'Vocal',
					'wind' => 'Wind',
				)
			),
			array(
				'id' => 'lower-age',
				'name' => 'Age group over',
				'type' => 'select',
				'cols' => 4,
				'allow_none' => true,
				'desc' => 'Only use if setting multiple age groups from and to',
				'options' => array(
					'4' => '4',
					'5' => '5',
					'6' => '6',
					'7' => '7',
					'8' => '8',
					'9' => '9',
					'10' => '10',
					'11' => '11',
					'12' => '12',
					'13' => '13',
					'14' => '14',
					'15' => '15',
					'16' => '16',
					'17' => '17',
					'18' => '18',
					'19' => '19',
					'20' => '20',
					'21' => '21',
					'22' => '22',
					'23' => '23',
					'24' => '24',
					'25' => '25',
					'26' => '26',
					'27' => '27',
					'28' => '28',
					'29' => '29',
					'30' => '30',
					'35' => '35',
					'40' => '40',
					'50' => '50',
					'60' => '60',
				)
			),
			array(
				'id' => 'upper-age',
				'name' => 'Age group under',
				'type' => 'select',
				'cols' => 4,
				'allow_none' => true,
				'desc' => 'When setting ages under, only use this Age group setting',
				'options' => array(
					'4' => '4',
					'5' => '5',
					'6' => '6',
					'7' => '7',
					'8' => '8',
					'9' => '9',
					'10' => '10',
					'11' => '11',
					'12' => '12',
					'13' => '13',
					'14' => '14',
					'15' => '15',
					'16' => '16',
					'17' => '17',
					'18' => '18',
					'19' => '19',
					'20' => '20',
					'21' => '21',
					'22' => '22',
					'23' => '23',
					'24' => '24',
					'25' => '25',
					'26' => '26',
					'27' => '27',
					'28' => '28',
					'29' => '29',
					'30' => '30',
					'35' => '35',
					'40' => '40',
					'50' => '50',
					'60' => '60',
				)
			),


		);

		$meta_boxes[] = array(
			'title' => 'Class Meta Data',
			'pages' => 'class',
			'context' => 'normal',
			'fields' => $fields
		);

		// Examples of Groups and Columns


		return $meta_boxes;

	}




    /**
     * Adds the meta box container.
     */
    public function add_meta_box( $post_type ) {
        // Limit meta box to certain post types.
        $post_types = array( 'invoice' );

        if ( in_array( $post_type, $post_types ) ) {
            add_meta_box(
                'resend_invoice',
                __( 'Resend Invoice', 'cfpa_theme' ),
                array( $this, 'render_meta_box_content' ),
                $post_type,
                'side',
                'default'
            );
        }
    }



    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content( $post ) {

        ?>

<a class="button-primary" id="resend-invoice" data-post_id="<?php echo esc_attr( $post->ID ); ?>" href="#" title="<?php esc_attr_e( 'Resend Invoice' ); ?>"><?php esc_attr_e( 'Resend Invoice' ); ?></a>
<div id="sentmsg" style="display: none;">Invoice has been resent!</div>

<?php
    }


	public function resend_invoice() {

		$post_id = $_POST['post_id'];

		$public_class = new CFPA_Booking_System_Public('public class', '1.0.2');
		$public_class->notify_users_of_invoice($post_id);

	    // Don't forget to stop execution afterward.
	    wp_die();
	}

	public function get_school_by_urn($urn) {
		$args = array(
			'post_type' => 'school',
			'meta_key' => 'urn',
			'meta_value' => $urn,
			'post_status' => 'any',
			'posts_per_page' => -1
		);
		$school = get_posts($args);
		return $school[0];
	}

	public function add_special_schools() {

		$shools = array(
			array(
				'title' => 'Home Schooled',
				'slug' => 'home-schooled'
			),
			array(
				'title' => 'School not listed',
				'slug' => 'school-not-listed'
			),
			array(
				'title' => 'No longer in school',
				'slug' => 'no-longer-in-school'
			)
		);
		foreach ($shools as $shool) {
			$post_id = wp_insert_post(
				array(
					'post_author' => 2,
					'post_name' => $shool["slug"],
					'post_title' => $shool["title"],
					'post_status' => 'publish',
					'post_type' => 'school'
				)
			);
			update_post_meta( $post_id, 'urn', '999001' );
		}
	}

}
