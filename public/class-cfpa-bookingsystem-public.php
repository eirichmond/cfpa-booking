<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.2
 *
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    CFPA_Booking_System
 * @subpackage CFPA_Booking_System/public
 * @author     Your Name <email@example.com>
 */
class CFPA_Booking_System_Public {

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
	 * @param      string    $CFPA_Booking_System       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $CFPA_Booking_System, $version ) {

		$this->CFPA_Booking_System = $CFPA_Booking_System;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.2
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->CFPA_Booking_System, plugin_dir_url( __FILE__ ) . 'css/cfpa-bookingsystem-public.css', array(), $this->version, 'all' );


	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->CFPA_Booking_System . '-validation', plugin_dir_url( __FILE__ ) . 'js/jquery.validate.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->CFPA_Booking_System . '-browser-detect', plugin_dir_url( __FILE__ ) . 'js/jquery.detect.browser.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('jquery-ui-autocomplete','',array('jquery','',false) );

		wp_enqueue_script( $this->CFPA_Booking_System, plugin_dir_url( __FILE__ ) . 'js/cfpa-bookingsystem-public.js', array( 'jquery' ), $this->version, false );


		if (is_page( 'jstest' ) ) {
			wp_enqueue_script( $this->CFPA_Booking_System . '-jstest', plugin_dir_url( __FILE__ ) . 'js/cfpa-jstest.js', array( 'jquery' ), $this->version, false );

			$all_children = $this->jstest_get_children();

			wp_localize_script( $this->CFPA_Booking_System . '-jstest', 'Parent_Children', $all_children);
		}

		if (is_page( 'enter-performer' ) ) {

			wp_enqueue_script( $this->CFPA_Booking_System . '-enter-performer', plugin_dir_url( __FILE__ ) . 'js/cfpa-enter-performers.js', array( 'jquery' ), $this->version, false );
/*
			wp_localize_script( $this->CFPA_Booking_System . '-enter-performer', 'Enter_Classes', array(
			    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			    'nextNonce'     => wp_create_nonce( 'enter-performer' ))
			);
*/
			wp_localize_script( $this->CFPA_Booking_System . '-enter-performer', 'Retrieve_Performers', array(
			    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			    'nextNonce'     => wp_create_nonce( 'retrieve-performers' ))
			);

			wp_localize_script( $this->CFPA_Booking_System . '-enter-performer', 'Check_Min_Max', array(
			    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			    'nextNonce'     => wp_create_nonce( 'check-min-max' ))
			);

			wp_localize_script( $this->CFPA_Booking_System . '-enter-performer', 'Get_Children', array(
			    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			    'nextNonce'     => wp_create_nonce( 'get-children' ))
			);

			wp_localize_script( $this->CFPA_Booking_System . '-enter-performer', 'Get_Groups', array(
			    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			    'nextNonce'     => wp_create_nonce( 'get-groups' ))
			);

			wp_localize_script( $this->CFPA_Booking_System . '-enter-performer', 'Check_Group_Numbers', array(
			    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			    'nextNonce'     => wp_create_nonce( 'check-group-numbers' ))
			);

		}

		if (is_user_logged_in()) {

			wp_enqueue_script( $this->CFPA_Booking_System.'-add-to-basket', plugin_dir_url( __FILE__ ) . 'js/cfpa-add-to-basket.js', array( 'jquery' ), $this->version, false );
			// Now we can localize the script with our data.
			wp_localize_script( $this->CFPA_Booking_System . '-add-to-basket', 'Add_To_Basket', array(
			    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			    'nextNonce'     => wp_create_nonce( 'add-to-basket' ))
			);

			wp_localize_script( $this->CFPA_Booking_System . '-add-to-basket', 'Add_Group_To_Basket', array(
			    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			    'nextNonce'     => wp_create_nonce( 'add-group-to-basket' ))
			);

			wp_localize_script( $this->CFPA_Booking_System . '-add-to-basket', 'Add_Programme_To_Basket', array(
			    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			    'nextNonce'     => wp_create_nonce( 'add-programme-to-basket' ))
			);

			wp_enqueue_script( $this->CFPA_Booking_System.'-remove-from-basket', plugin_dir_url( __FILE__ ) . 'js/cfpa-remove-from-basket.js', array( 'jquery' ), $this->version, false );
			// Now we can localize the script with our data.
			wp_localize_script( $this->CFPA_Booking_System . '-remove-from-basket', 'Remove_From_Basket', array(
			    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			    'nextNonce'     => wp_create_nonce( 'remove-from-basket' ))
			);

			wp_enqueue_script( $this->CFPA_Booking_System . '-remove-child', plugin_dir_url( __FILE__ ) . 'js/cfpa-remove-child.js', array( 'jquery' ), $this->version, false );
			wp_localize_script( $this->CFPA_Booking_System . '-remove-child', 'Remove_Child', array(
			    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			    'nextNonce'     => wp_create_nonce( 'remove-child' ))
			);

			wp_localize_script( $this->CFPA_Booking_System . '-remove-child', 'Remove_Group', array(
			    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			    'nextNonce'     => wp_create_nonce( 'remove-group' ))
			);

			if (is_page( 'add-performer' ) ) {

				$schools = $this->get_all_schools_data();
				$opts = get_option('cfpa');
				$pivotDate = date('Y-m-d', strtotime($opts["age-at-date"]));

				wp_enqueue_script( $this->CFPA_Booking_System . '-schools-data', plugin_dir_url( __FILE__ ) . 'js/cfpa-schools-data.js', array( 'jquery' ), $this->version, false );
				wp_localize_script( $this->CFPA_Booking_System . '-schools-data', 'Schools', array(
					'ajaxurl'   => admin_url( 'admin-ajax.php' ),
					'nextNonce' => wp_create_nonce( 'schools-data' ),
					'schools'   => $schools,
					'pivotDate' => $pivotDate
				)
				);


			}

			if (is_page( 'checkout' ) ) {
				wp_enqueue_script( $this->CFPA_Booking_System . '-marketing-permission', plugin_dir_url( __FILE__ ) . 'js/cfpa-marketing-permission.js', array( 'jquery' ), $this->version, false );
				wp_localize_script( $this->CFPA_Booking_System . '-marketing-permission', 'Marketing_Permission', array(
					'ajaxurl'   => admin_url( 'admin-ajax.php' ),
					'nextNonce' => wp_create_nonce( 'update-marketing-permission' )
				) );
			}

		}

	}

	/**
	 * A function to return the plugin single template for invoices.
	 *
	 * @since    1.0.2
	 * @param    string    $single_template
	 * @return   string    $single_template    the new single page reference.
	 */
	public function get_invoice_template($single_template) {
	     global $post;

	     if ($post->post_type == 'invoice') {
	          $single_template = plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/single-invoice.php';
	     }
	     return $single_template;
	}

	/**
	 * A function to return min max entrants per class ID.
	 *
	 * @since    1.0.2
	 * @param    int    $class_id    the class ID.
	 * @return   array    $minmax    the minimum and maximum entrants.
	 */
	public function return_min_max_entrants($class_id) {

		$minmax = array();
		if ($class_id) {
			$minmax['min'] = get_post_meta($class_id, 'class-min-entrants', true);
			$minmax['max'] = get_post_meta($class_id, 'class-entrants', true);
		}
		return $minmax;
	}

	public function remove_duplicate_schools_without_urn_post_meta() {
		global $wpdb;

		$schools = $wpdb->get_results("
			SELECT ID
			FROM {$wpdb->posts}
			WHERE post_type = 'school'
		");

		$schools_urn = array();

		foreach ($schools as $school) {
			$school_urn = get_post_meta($school->ID, 'urn', true);
			if(empty($school_urn)) {
				wp_delete_post($school->ID, true);
			}
		}

	}

	public function check_child_licence_notice() {
		$nonce = $_POST['nextNonce'];
		if ( ! wp_verify_nonce( $nonce, 'schools-data' ) ) {
		    die( 'Security check busted!' );
		} else {
			$json = array(
				'bool' => false,
				'childID' => $_POST["childID"]
			);
			$school_status = array('4','5');
			$school_status = array(); // set an empty array as no longer needed for now.
			if(intval($_POST["childAge"]) <= 16) {
				$establishment_type_group_code = get_post_meta( $_POST["schoolID"], 'establishment_type_group_code', true );
				if( in_array($establishment_type_group_code, $school_status) ) {
					$json['bool'] = true;
				}
			}

			wp_send_json($json);

		    die(); // this is required to terminate immediately and return a proper response
		}

	}

	public function check_headmaster_approval_notice() {
		$nonce = $_POST['nextNonce'];
		if ( ! wp_verify_nonce( $nonce, 'schools-data' ) ) {
		    die( 'Security check busted!' );
		} else {
			$json = array(
				'bool' => false,
				'childID' => $_POST["childID"]
			);
			$school_status = array('3','4','5','11','10');
			if(intval($_POST["childAge"]) <= 16) {
				$establishment_type_group_code = get_post_meta( $_POST["schoolID"], 'establishment_type_group_code', true );
				if( in_array($establishment_type_group_code, $school_status) ) {
					$json['bool'] = true;
				}
			}

			wp_send_json($json);

		    die(); // this is required to terminate immediately and return a proper response
		}


	}

	/**
	 * Ajax check on min max entrants to pass back to javascript.
	 *
	 * @since    1.0.2
	 * @return   array    $minmax    the minimum and maximum entrants.
	 */
	public function check_min_max_entrants() {

		$nonce = $_POST['nextNonce'];
		if ( ! wp_verify_nonce( $nonce, 'check-min-max' ) ) {
		    die( 'Security check busted!' );
		} else {

			$minmax = $this->return_min_max_entrants($_POST['classid']);

			$this->render_html_additional_entrants($minmax, $_POST['child_id']);

		    die(); // this is required to terminate immediately and return a proper response
		}
	}

	/**
	 * Render element class to show if class numbers have been met.
	 *
	 * @since    1.0.2
	 * @echo   string    under or qualified.
	 */
	public function qualify_class_numbers($x, $range_check) {
		if (in_array($x, $range_check)) {
			echo 'qualified';
		} else {
			echo 'under';
		}
	}

	/**
	 * Render extra inputs based on min and max per class.
	 *
	 * @since    1.0.2
	 * @echo   string    the form inputs required based on min an max.
	 */
	public function render_html_additional_entrants($minmax, $child_id) {

		$range_check = $this->create_range_based_on_minmax($minmax);
		// die early as we don't need to render anything unless it is more than 2
		if (in_array('1', $range_check)) {
			return;
		}

		$children = $this->pre_get_children($child_id);

		$users_performers = $this->get_users_children($_POST['user_id']);

		// $eligible_performers = $this->get_eligible_performers($_POST['classid'],$users_performers);
		// $eligible_performers = $eligible_performers['child_id'];
		// $filteredChildren = array_filter($children, function ($key) use ($eligible_performers) {
		// 	return in_array($key, $eligible_performers);
		// }, ARRAY_FILTER_USE_KEY);


		/**
		 *  no longer needed as per enhancements 2025/26
		 *  donot use $filteredChildren, instead use $users_performers to populate additional performers
		 *
		 *
	     * $eligible_performers = $this->get_eligible_performers($_POST['classid'],$users_performers);
		 * $eligible_performers = $eligible_performers['child_id'];

		* Filter the values array to include only the keys from the indexes array
		* this is a check for other qualified children by their age.
		* Filter the $children array to return only the entries whose keys are in $child_id


		* $filteredChildren = array_filter($children, function ($key) use ($eligible_performers) {
		*	return in_array($key, $eligible_performers);
		* }, ARRAY_FILTER_USE_KEY);

		* if ( empty( $filteredChildren ) ) {
		* 	echo '<p class="error">No other performers qualified for this class due to age eligibility requirements.</p>';
		* 	return;
		* }

		*/


		echo '<div class="col span_10_of_12"><div class="input-field">';
			for ($x = 2; $x <= $minmax['max']; $x++) {  ?>

				<div class="input-field select-field">
					<select class="additional-entrant" id="additiona-entrant-<?php echo esc_html($x); ?>" name="childname" required>
						<option value="" selected>Perfomer <?php echo esc_html($x); ?></option>
						<?php foreach ($children as $k => $v) { ?>
							<option value="<?php echo esc_attr( $k );?>" <?php $this->check_performance_disabled($k); ?> data-min="<?php echo esc_html( $minmax['min'] );?>" data-max="<?php echo esc_html( $minmax['max'] );?>"><?php echo esc_html( $v );?><?php $this->check_performance_disabled($k, true); ?></option>
						<?php } ?>
					</select>
				</div>


<!-- 				<input class="<?php $this->qualify_class_numbers($x, $range_check); ?>" id="entrant-<?php echo esc_html($x); ?>" type="text" name="childname" placeholder="Please Enter Additional Child Name" value=""> -->
			<?php }
		echo '</div></div>';

		for ($x = 2; $x <= $minmax['max']; $x++) {  ?>
			<input class="xchild" id="child-entrant-id-<?php echo esc_html($x); ?>" type="hidden" value="">
		<?php }

	}

	public function check_performance_disabled($child_id, $append = false ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'cfpa_children';
		$performer = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT *
				FROM $table_name
				WHERE child_id = %d
				",
				array($child_id)
			)
		);
		$age = $this->get_performers_age($performer[0]->child_dob);
		$upper_age = intval( get_post_meta($_POST["classid"], 'upper-age', true) );
		if($age > $upper_age || $performer[0]->child_school == '' ) {
			if($append) {
				echo $age > $upper_age ? ' - Disabled due to age eligibility requirements' : ' - Disabled due to Performer\'s Place of Education missing';
			} else {
				echo 'disabled';
			}
		}


	}

	/**
	 * A mechanism for creating a range of entrants starting and ending as a qualifier.
	 *
	 * @since    1.0.2
	 * @param   array    $minmax the min and max based on a class.
	 * @return  array    $range the range starting at min and running through to max eg: 4,5,6 or 2,3,4 etc
	 */
	public function create_range_based_on_minmax($minmax) {
		if (isset($minmax['min']) & !empty($minmax['min'])) {
			$range = range($minmax['min'], $minmax['max']);
		} else {
			$range[] = $minmax['max'];
		}

		return $range;
	}

	public function refactored_retrieve_eligible_performers() {

	}

	/**
	 * Ajax mechanism for retrieving performers for js per class.
	 *
	 * @since    1.0.2
	 * @return array
	 */
	public function retrieve_eligible_performers(){

		$nonce = $_POST['nextNonce'];
		if ( ! wp_verify_nonce( $nonce, 'retrieve-performers' ) ) {
		    die( 'Security check busted!' );
		} else {

			$minmax = $this->return_min_max_entrants($_POST['classid']);

			$array['loop'] = $minmax['max'];

			$users_performers = $this->get_users_children($_POST['user_id']);

			$eligible_performers = $this->get_eligible_performers($_POST['classid'],$users_performers);

			$array = $array + $eligible_performers;

			echo json_encode($array);
			//wp_send_json($array);

			die();
		}
	}

	/**
	 * Filter Performers who qualify for this class.
	 *
	 * @param int $class_id class ID.
	 * @param array $perfomers array of users performers.
	 * @return array $performers all performers that qualify for this class
	 */
	public function get_eligible_performers($class_id, $users_performers) {

		$terms = wp_get_post_terms( $class_id, 'class_cat' );
		$category = $terms[0]->slug;

		$performers = array();
		foreach ($users_performers as $users_performer) {
			$dob = $users_performer->child_dob;
			$age = (date('Y') - date('Y',strtotime($dob)));
			$qualifying_age = $this->get_qualifying_age_array($dob);

			if ($category == 'drama' || $category == 'music') {
				$qualifying_age = $qualifying_age['music_drama_age'];
			} else {
				$qualifying_age = $qualifying_age['dance_age'];
			}
			$age_range = $this->get_class_age_range($class_id);

			if (in_array($qualifying_age, $age_range)) {
				$performers['child_id'][] = $users_performer->child_id;
				$performers['children'][] = $users_performer->child_name;
			}
		}

		return $performers;

	}

	public function cfpa_wp_mail_from( $original_email_address ) {
		//Make sure the email is from the same domain
		//as your website to avoid being marked as spam.
		return get_option('admin_email');
	}

	public function cfpa_mail_from_name( $name ) {
		//Make sure the email is from the same domain
		//as your website to avoid being marked as spam.

		return get_option('blogname');
	}

	public function public_pages() {
		$array = array(
			'account' => array(
				'slug' => '/cfpa-user/account/',
				'template' => 'partials/user-account.php'
			),
			'profile' => array(
				'slug' => '/cfpa-user/profile/',
				'template' => 'partials/user-profile.php'
			),
			'purchase-history' => array(
				'slug' => '/cfpa-user/purchase-history/',
				'template' => 'partials/purchase-history.php'
			),
			'add-performer' => array(
				'slug' => '/cfpa-user/add-performer/',
				'template' => 'partials/add-performer.php'
			),
			'enter-performer' => array(
				'slug' => '/cfpa-user/enter-performer/',
				'template' => 'partials/enter-performer.php'
			),
			'checkout' => array(
				'slug' => '/cfpa-user/checkout/',
				'template' => 'partials/checkout.php'
			),
			'charge' => array(
				'slug' => '/cfpa-user/charge/',
				'template' => 'partials/charge.php'
			),
			'multiple-entry-form' => array(
				'slug' => '/multiple-entry-form/',
				'template' => 'partials/multiple-entry-form.php'
			),
		);
		return $array;
	}

	public function registration_page() {
		$array = array(
			'user-account-registration' => array(
				'slug' => '/cfpa-user/user-account-registration/',
				'template' => 'partials/user-account-registration.php'
			)
		);
		return $array;
	}

	// register Foo_Widget widget
	public function register_cfpa_widgets() {
	    register_widget( 'Basket_Widget' );
	}


	/**
	 * A function to return a page as included via this plugin.
	 *
	 * @since    1.0.2
	 * @param    string    $original_template    the path of the original template.
	 * @return   string    $original_template    the conditionally filtered path of the template.
	 */
	public function registration_page_includes( $original_template ) {

		global $post;
		$registration_page = $this->registration_page();

		foreach ($registration_page as $k => $registration) {
			if ( is_page( $k ) ) {
				$original_template = plugin_dir_path( __FILE__ ) . $registration['template'];
			}
		}

		return $original_template;
	}

	/**
	 * A function to return a page as included via this plugin.
	 *
	 * @since    1.0.2
	 * @param    string    $original_template    the path of the original template.
	 * @return   string    $original_template    the conditionally filtered path of the template.
	 */
	public function jstestpage( $original_template ) {

		if ( is_page( 'jstest' ) ) {
			$original_template = plugin_dir_path( __FILE__ ) . '/partials/jstestpage.php';
		}

		return $original_template;
	}



	/**
	 * A function to return a page as included via this plugin.
	 *
	 * @since    1.0.2
	 * @param    string    $original_template    the path of the original template.
	 * @return   string    $original_template    the conditionally filtered path of the template.
	 */
	public function page_includes( $original_template ) {

		global $post;
		$public_pages = $this->public_pages();

		if (is_user_logged_in()) {
			foreach ($public_pages as $k => $public_page) {
				if ( is_page( $k ) ) {
					$original_template = plugin_dir_path( __FILE__ ) . $public_page['template'];
				}
			}
		} else {
			foreach ($public_pages as $k => $public_page) {
				if ( is_page( $k ) ) {
				    if( file_exists(plugin_dir_path( __FILE__ ) . 'partials/error.php') ) {
						$original_template = plugin_dir_path( __FILE__ ) . 'partials/error.php';
				    }
				}
			}
		}

		return $original_template;
	}

	/**
	 * Get child-licencing-text in options
	 *
	 * @return void
	 */
	public function child_licence_notice_text() {
		$opt = get_option('cfpa');
		return $opt['child-licencing-text'];
	}

	/**
	 * Get child-licencing-tick-description in options
	 *
	 * @return void
	 */
	public function child_licence_notice_checkbox_label() {
		$opt = get_option('cfpa');
		return $opt['child-licencing-tick-description'];

	}

	/**
	 * Get headmaster_approval_notice_text in options
	 *
	 * @return void
	 */
	public function headmaster_approval_notice_text() {
		$opt = get_option('cfpa');
		return $opt['headmaster-approval-text'];
	}

	/**
	 * Get child-licencing-tick-description in options
	 *
	 * @return void
	 */
	public function headmaster_approval_notice_checkbox_label() {
		$opt = get_option('cfpa');
		return $opt['headmaster-approval-tick-description'];

	}

	/**
	 * A function to create a group fields.
	 *
	 * @since    1.0.2
	 * @return   array    $array    an array of input information.
	 */
	public function group_profile_inputs_fields() {

		$array = array(
			array(
				'label' => 'Group Name',
				'placeholder' => 'Group Name',
				'key' => 'group_name',
				'type' => 'text'
			),
			array(
				'label' => 'Group Number',
				'placeholder' => 'How many members (approx)',
				'key' => 'group_number',
				'type' => 'number'
			)
		);

		return $array;

	}

	/**
	 * A function to create all children fields.
	 *
	 * @since    1.0.2
	 * @return   array    $array    an array of input information.
	 */
	public function children_profile_inputs_fields() {

		$days = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
		$months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec');
		$year_start = date('Y', strtotime('now -2 years'));
		$year_end = date('Y', strtotime('now -81 years'));
		$year_range = range($year_start, $year_end);

		$array = array(
			array('label' => 'Performer Name', 'key' => 'child_name', 'type' => 'text'),
			array('label' => 'Date of birth', 'key' => 'child_dob_date', 'type' => 'select', 'options' => $days),
			array('label' => 'Month of birth', 'key' => 'child_dob_month', 'type' => 'select', 'options' => $months),
			array('label' => 'Year of birth', 'key' => 'child_dob_year', 'type' => 'select', 'options' => $year_range),
			array('label' => 'Place of Education', 'key' => 'child_school', 'type' => 'text', 'required' => true ),
			array('label' => 'Parent Email', 'key' => 'parent_email', 'type' => 'email'),
		);

		return $array;
	}


	/**
	 * A function to create all extra user profile infomation.
	 *
	 * @since    1.0.2
	 * @return   array    $array    an array of input information.
	 */
	public function user_profile_inputs_fields() {

		$array = array(
			array(
				'label' => 'Salutation (Mr, Mrs, Ms etc)',
				'key' => 'salutation',
				'type' => 'text'
			),
			array(
				'label' => 'First Name',
				'key' => 'first_name',
				'type' => 'text'
			),
			array('label' => 'Last Name', 'key' => 'last_name', 'type' => 'text'),
			array('label' => 'Email', 'key' => 'email', 'type' => 'email'),
			array(
				'label' => 'Your Position',
				'key' => 'user_position',
				'type' => 'select',
				'options' => array(
					'parent' => 'Parent',
					'guardian' => 'Guardian',
					'carer' => 'Carer',
					'performer' => 'Performer',
					'chior' => 'Choir',
					'teacher' => 'Teacher',
					'private_teacher' => 'Private Teacher',
					)
				),
			array('label' => 'Address 1', 'key' => 'address_1', 'type' => 'text'),
			array('label' => 'Address 2', 'key' => 'address_2', 'type' => 'text'),
			array('label' => 'Address 3', 'key' => 'address_3', 'type' => 'text'),
			array('label' => 'Town', 'key' => 'town', 'type' => 'text'),
			array('label' => 'City or County', 'key' => 'city', 'type' => 'text'),
			array('label' => 'Postcode', 'key' => 'postcode', 'type' => 'text'),
			array('label' => 'Telephone', 'key' => 'telephone', 'type' => 'text'),
			array('label' => 'Alternative Telephone', 'key' => 'alt_telephone', 'type' => 'text'),
			array(
				'label' => 'Pay by Invoice Enabled',
				'key' => 'pay_by_invoice',
				'type' => 'checkbox'
			),
		);

		return $array;
	}


	/**
	 * A function to create users preference infomation.
	 *
	 * @since    1.0.2
	 * @return   array    $array    an array of preferences.
	 */
	public function user_class_preferences() {

		$array = array(
			array('label' => 'Your Preferences', 'key' => 'user_class_preferences', 'type' => 'checkbox', 'section' =>
				array(
					array(
						'label' => 'Music',
						'options' => array('Wind','String','Piano'
						)
					),
					array(
						'label' => 'Dance',
						'options' => array('Ballet','Jazz','Tap'
						)
					),
					array(
						'label' => 'Drama',
						'options' => array('Solo','Monologue','Impro'
						)
					),
				)
			),
		);

		return $array;
	}

	/**
	 * enable/disable required email field
	 *
	 */
	public function check_user_position_field_requirement($type, $user_id) {
		if($type == 'email') {
			$position = get_user_meta($user_id, 'user_position', true);
			if($position == 'teacher' || $position == 'private_teacher');
			echo esc_attr(' required');
		}
	}


	/**
	 * A function to render user profile information.
	 *
	 * @since    1.0.2
	 * @param    object    $user    the currently logged in user object.
	 */
	public function user_profile_data( $user )
	{
		$profiles = $this->user_profile_inputs_fields();
		foreach ($profiles as $k => $v) {
			if ($v['key'] == 'first_name' || $v['key'] == 'last_name' || $v['key'] == 'email') {
				unset($profiles[$k]);
			}
		}

	    ?>
	        <h3>User Information</h3>

	        <table class="form-table">
		        <?php foreach($profiles as $profile) { ?>
		        	<?php if ($profile['type'] == 'text') { ?>
			            <tr>
			                <th><label for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label></th>
			                <td><input type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" value="<?php echo esc_attr(get_the_author_meta( $profile['key'], $user->ID )); ?>" class="regular-text" /></td>
			            </tr>
		        	<?php } ?>

		        	<?php if ($profile['type'] == 'email') { ?>
			            <tr>
			                <th><label for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label></th>
			                <td><input type="<?php echo esc_attr($profile['type']); ?>" name="<?php echo esc_attr($profile['key']); ?>" value="<?php echo esc_attr(get_the_author_meta( $profile['key'], $user->ID )); ?>" class="regular-text" /></td>
			            </tr>
		        	<?php } ?>

		        	<?php if ($profile['type'] == 'select') { ?>
			            <tr>
				            <th><label for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label></th>
							<td>
								<select name="<?php echo esc_attr($profile['key']); ?>" id="<?php echo esc_attr($profile['key']); ?>">

									<?php foreach ($profile['options'] as $key => $value) { ?>

										<option value="<?php echo esc_attr($key); ?>" <?php selected( get_the_author_meta( $profile['key'], $user->ID ), $key, TRUE ); ?>><?php echo esc_attr($value); ?></option>

									<?php } ?>

								</select>
							</td>
						</tr>
		        	<?php } ?>


		        	<?php if ($profile['type'] == 'checkbox') { ?>
			            <tr>
				            <th><label for="<?php echo esc_attr($profile['key']); ?>"><?php echo esc_html($profile['label']); ?></label></th>
							<td>
								<input type="checkbox" name="<?php echo esc_attr($profile['key']); ?>" id="<?php echo esc_attr($profile['key']); ?>" value="1" <?php checked( get_the_author_meta( $profile['key'], $user->ID ), '1' ); ?> />

							</td>
						</tr>
		        	<?php } ?>

					<?php } ?>

	        </table>
	    <?php
	}

	/**
	 * A function to save all user profile information.
	 *
	 * @since    1.0.2
	 * @param    int    $user_id    the currently logged in users ID.
	 */
	public function save_profile_data( $user_id ) {
		//var_dump($_POST);
		$profiles = $this->user_profile_inputs_fields();
		foreach($profiles as $profile) {
			if ($profile['type'] == 'checkbox' && !array_key_exists($profile['key'], $_POST)) {
				delete_user_meta($user_id, $profile['key']);
			} else {
				update_user_meta( $user_id, $profile['key'], sanitize_text_field( $_POST[$profile['key']] ) );
			}
		}
		//wp_die();
	}

	public function process_form() {
		do_action('process_form');
	}

	public function perform_form_processing() {

		if (isset($_POST) && !empty($_POST)) {

			if ( ! isset( $_POST['front_end_post_nonce'] ) || ! wp_verify_nonce( $_POST['front_end_post_nonce'], 'front_end_post' ) ) {

				wp_die('Sorry, security did not verify.');

			} else {

				if (isset($_POST['action']) && $_POST['action'] == 'update-profile') {
					$profiles = $this->user_profile_inputs_fields();

					foreach ($profiles as $k => $v) {
						if ($v['type'] == 'text' || $v['type'] == 'select') {
							update_user_meta($_POST['user_id'], $v['key'], sanitize_text_field($_POST[$v['key']]) );
						}
						if ( $v['type'] == 'email' ) {
							// Get the current user ID
    						$user_id = get_current_user_id();
							// Check if a user is logged in
							if ($user_id) {
								// Sanitize the email input
								$new_email = sanitize_email($_POST[$v['key']]);

								// Validate the email
								if (is_email($new_email)) {
									// Update the user's email
									$result = wp_update_user([
										'ID' => $user_id,
										'user_email' => $new_email,
									]);

									// Check for errors
									if (is_wp_error($result)) {
										wp_die( 'Error updating email: ' . $result->get_error_message() );
									}
								} else {
									wp_die( 'Please enter a valid email address.' );
								}
							} else {
								wp_die( 'You must be logged in to update your email.' );
							}
						}

					}

				}

				if (isset($_POST['action']) && $_POST['action'] == 'add-child') {

					// if no school was selected then we assume this is a new school so add it to the database
					$this->update_school_entries($_POST);

					global $wpdb; // this is how you get access to the database

					$table_name = $wpdb->prefix . 'cfpa_children';

					$timenow = date('Y-m-d H:i:s', strtotime('now'));
					$dob = sanitize_text_field($_POST['child_dob_year']) . '-' . sanitize_text_field($_POST['child_dob_month']) . '-' . sanitize_text_field($_POST['child_dob_date']);


					$child_name = sanitize_text_field($_POST['child_name']);
					$child_school = sanitize_text_field($_POST["input_child_school_id"]);
					$child_licence_agreed = $_POST['child_licence_agreed'] ? $_POST["child_licence_agreed"] : null;
					$headmaster_approval_agreed = $_POST['headmaster_approval_agreed'] ? $_POST["headmaster_approval_agreed"] : null;
					$child_school = sanitize_text_field($_POST["input_child_school_id"]);
					$parent_email = sanitize_text_field($_POST['parent_email']);
					$user_id = (int) sanitize_text_field($_POST['user_id']);
					$registered_date = sanitize_text_field($timenow);
					$child_dob = date('Y-m-d', strtotime($dob));
					$last_edit = sanitize_text_field(strtotime('now').':'.$_POST['user_id']);

					//var_dump($child_dob); wp_die();

					$wpdb->query( $wpdb->prepare(
						"
							INSERT INTO $table_name
							( child_name, child_school, child_licence_agreed, headmaster_approval_agreed, parent_email, user_id, registered_date, child_dob, child_exception_date, last_edit )
							VALUES ( %s, %s, %d, %d, %s, %d, %s, %s, %s, %s )
						",
					        array(
							$child_name,
							$child_school,
							$child_licence_agreed,
							$headmaster_approval_agreed,
							$parent_email,
							$user_id,
							$registered_date,
							$child_dob,
							$child_dob,
							$last_edit,
						)
					) );

				}

				if (isset($_POST['action']) && $_POST['action'] == 'edit-child') {

					//$this->update_school_entries($_POST);

					global $wpdb; // this is how you get access to the database

					$table_name = $wpdb->prefix . 'cfpa_children';

					$dob = sanitize_text_field($_POST['child_dob_year']) . '-' . sanitize_text_field($_POST['child_dob_month']) . '-' . sanitize_text_field($_POST['child_dob_date']);

					$child_id = sanitize_text_field($_POST['child_id']);
					$child_name = sanitize_text_field($_POST['child_name']);
					$child_school = sanitize_text_field($_POST['input_child_school_id']);
					$child_licence_agreed = $_POST['child_licence_agreed'] ? $_POST["child_licence_agreed"] : null;
					$headmaster_approval_agreed = $_POST['headmaster_approval_agreed'] ? $_POST["headmaster_approval_agreed"] : null;
					$parent_email = sanitize_text_field($_POST['parent_email']);
					$user_id = (int) sanitize_text_field($_POST['user_id']);
					$child_dob = $dob;
					$last_edit = sanitize_text_field(strtotime('now').':'.$_POST['user_id']);

				/*
					$wpdb->query( $wpdb->prepare(
						"
							UPDATE $table_name
							SET
							( child_name, user_id, registered_date, child_dob, child_school, last_edit )
							VALUES ( %s, %d, %s, %s, %s, %s )
						",
					        array(
							$child_name,
							$user_id,
							$registered_date,
							$child_dob,
							$child_school,
							$last_edit
						)
					) );
				*/

					$wpdb->update(
						$table_name,
						array(
							'child_name' => $child_name,	// string
							'child_school' => $child_school,	// string
							'child_licence_agreed' => $child_licence_agreed,	// string
							'headmaster_approval_agreed' => $headmaster_approval_agreed,	// string
							'parent_email' => $parent_email,	// string
							'user_id' => $user_id,	// integer (number)
							'child_dob' => $child_dob,
							'last_edit' => $last_edit
						),
						array( 'child_id' => $child_id ),
						array(
							'%s',
							'%s',
							'%d',
							'%d',
							'%s',
							'%d',
							'%s',
							'%s'
						),
						array( '%d' )
					);

				}

				if (isset($_POST['action']) && $_POST['action'] == 'add-group') {


					global $wpdb; // this is how you get access to the database

					$table_name = $wpdb->prefix . 'cfpa_groups';

					$timenow = date('Y-m-d H:i:s', strtotime('now'));

					$group_name = stripslashes(sanitize_text_field($_POST['group_name']));
					$group_number = stripslashes(sanitize_text_field($_POST['group_number']));
					$user_id = (int) sanitize_text_field($_POST['user_id']);
					$registered_date = sanitize_text_field($timenow);
					$last_edit = sanitize_text_field(strtotime('now').':'.$_POST['user_id']);

					//var_dump($child_dob); wp_die();

					$wpdb->query( $wpdb->prepare(
						"
							INSERT INTO $table_name
							( group_name, group_number, user_id, registered_date, last_edit )
							VALUES ( %s, %d, %d, %s, %s )
						",
					        array(
							$group_name,
							$group_number,
							$user_id,
							$registered_date,
							$last_edit,
						)
					) );

				}

				if (isset($_POST['action']) && $_POST['action'] == 'edit-group') {

					global $wpdb; // this is how you get access to the database

					$table_name = $wpdb->prefix . 'cfpa_groups';

					$group_id = sanitize_text_field($_POST['group_id']);
					$group_name = stripslashes(sanitize_text_field($_POST['group_name']));
					$group_number = stripslashes(sanitize_text_field($_POST['group_number']));
					$user_id = (int) sanitize_text_field($_POST['user_id']);
					$last_edit = sanitize_text_field(strtotime('now').':'.$_POST['user_id']);

					$wpdb->update(
						$table_name,
						array(
							'group_name' => $group_name,	// string
							'group_number' => $group_number,	// integer (number)
							'user_id' => $user_id,	// integer (number)
							'last_edit' => $last_edit
						),
						array( 'group_id' => $group_id ),
						array(
							'%s',
							'%d',
							'%d',
							'%s'
						),
						array( '%d' )
					);

				}

				if (isset($_POST['action']) && $_POST['action'] == 'register-profile') {


					if((! isset( $_POST['add-nonce'] ) || ! wp_verify_nonce( $_POST['add-nonce'], 'add-user' ) )) {
						wp_die('Naught!! Lets have egg and beans instead! We don\'t like spam!');
					} else {

						$school = array('teacher','private_teacher','chior');
						$independent = array('parent','guardian','carer','performer');

						if (in_array($_POST['user_position'], $school)) {
							$user_role = 'multiple';
						} elseif (in_array($_POST['user_position'], $independent)) {
							$user_role = 'individual';
						} else {
							$user_role = 'subscriber';
						}


						$user_name = esc_attr( $_POST['first_name'] ) . ' ' . esc_attr( $_POST['last_name'] );


						// setup new user
						$userdata = array(
							'user_login' => $user_name,
							'user_email' => esc_attr( $_POST['email'] ),
							'first_name' => esc_attr( $_POST['first_name'] ),
							'last_name' => esc_attr( $_POST['last_name'] ),
							'role' => $user_role,
						);

						// setup some error checks
						if ( empty($userdata['user_login']) )
							$error = '<div class="default alert">A username is required for registration.</div>';
						elseif ( username_exists($userdata['user_login']) )
							$error = '<div class="default alert">Sorry, that username already exists!</div>';
						elseif ( !is_email($userdata['user_email']) )
							$error = '<div class="default alert">You must enter a valid email address.</div>';
						elseif ( email_exists($userdata['user_email']) )
							$error = '<div class="default alert">Sorry, that email address is already used!</div>';
						// setup new users and send notification
						else {
							$new_user = wp_insert_user( $userdata );
							$new_user_metas = array(
								'salutation' => $_POST['salutation'],
								'user_position' => $_POST['user_position'],
								'address_1' => $_POST['address_1'],
								'address_2' => $_POST['address_2'],
								'address_3' => $_POST['address_3'],
								'town' => $_POST['town'],
								'city' => $_POST['city'],
								'postcode' => $_POST['postcode'],
								'telephone' => $_POST['telephone'],
								'alt_telephone' => $_POST['alt_telephone'],
								'_first_time_login' => true,
								);
							foreach ($new_user_metas as $k => $v) {
								update_user_meta( $new_user, $k, $v );
							}
							wp_new_user_notification($new_user, 'both');
						}

						if ($error) {
							return $error;
						}

					}
				}



			}

		}

		if (isset($_FILES['upload'])) {

			if ( ! isset( $_POST['front_end_post_nonce'] ) || ! wp_verify_nonce( $_POST['front_end_post_nonce'], 'front_end_post' ) ) {

				wp_die('Sorry, security did not verify.');

			} else {


				if(isset($_FILES['upload']['name']) && $_FILES['upload']['name'] == '' ) {
					wp_redirect( esc_url( $_SERVER['HTTP_REFERER'] . '?upload=error' ) );
				} else {
					//var_dump($_SERVER);

					$upload_dir = wp_upload_dir();
					$timenow = strtotime('now');

					$fileloc = $upload_dir['path'] .'/uid-' . $_POST['user_id'] . '-' . $timenow . '-' . $_FILES['upload']['name'];

					move_uploaded_file($_FILES['upload']['tmp_name'], $fileloc);

					$file_size = $this->process_multi_line_upload($fileloc, $timenow, $_POST['user_id']);

					wp_redirect( esc_url( $_SERVER['HTTP_REFERER'] . '?childrenadded=1' ) );
				}



			}

		}

	}

	public function init_schools() {

		$schools = array(
			array('title' =>'Abbey Rose School','town'=>'Tewkesbury'),
			array('title' =>'Abbeymead Primary School','town'=>'Gloucester'),
			array('title' =>'Airthrie School With Hillfield Dyslexia Trust','town'=>'Cheltenham'),
			array('title' =>'Al-Ashraf Primary School','town'=>'Gloucester'),
			array('title' =>'Al-Ashraf Secondary School for Girls','town'=>'Gloucester'),
			array('title' =>'Alderman Knight School','town'=>'Tewkesbury'),
			array('title' =>'All Saints Academy Cheltenham','town'=>'Cheltenham'),
			array('title' =>'Amberley Parochial School','town'=>'Stroud'),
			array('title' =>'Ampney Crucis Church of England Primary School','town'=>'Cirencester'),
			array('title' =>'Andoversford Primary School','town'=>'Cheltenham'),
			array('title' =>'Ann Cam Church of England Primary School','town'=>'Dymock'),
			array('title' =>'Ann Edwards Church of England Primary School','town'=>'Cirencester'),
			array('title' =>'Archway School','town'=>'Stroud'),
			array('title' =>'Ashchurch Primary School','town'=>'Tewkesbury'),
			array('title' =>'Ashleworth Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Avening Primary School','town'=>'Tetbury'),
			array('title' =>'Aylburton Church of England Primary School','town'=>'Lydney'),
			array('title' =>'Balcarras School','town'=>'Cheltenham'),
			array('title' =>'Barnwood Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Barnwood Park Arts College','town'=>'Gloucester'),
			array('title' =>'Battledown Centre for Children and Families','town'=>'Cheltenham'),
			array('title' =>'Beaudesert Park School','town'=>'Stroud'),
			array('title' =>'Beaufort Co-operative Academy','town'=>'Gloucester'),
			array('title' =>'Beech Green Primary School','town'=>'Gloucester'),
			array('title' =>'Belmont School','town'=>'Cheltenham'),
			array('title' =>'Benhall Infant School','town'=>'Cheltenham'),
			array('title' =>'Berkeley Primary School','town'=>'Berkeley'),
			array('title' =>'Berkhampstead School','town'=>'Cheltenham'),
			array('title' =>'Berry Hill Primary School','town'=>'Coleford'),
			array('title' =>'Bettridge School','town'=>'Cheltenham'),
			array('title' =>'Bibury Church of England Primary School','town'=>'Cirencester'),
			array('title' =>'Bibury Church of England Primary School','town'=>'Cirencester'),
			array('title' =>'Birdlip Primary School','town'=>'Gloucester'),
			array('title' =>'Bishops Cleeve Primary Academy','town'=>'Cheltenham'),
			array('title' =>'Bisley Blue Coat Church of England Primary School','town'=>'Stroud'),
			array('title' =>'Blakeney Primary School','town'=>'Blakeney'),
			array('title' =>'Bledington Primary School','town'=>'Chipping Norton'),
			array('title' =>'Blockley Church of England Primary School','town'=>'Moreton-in-Marsh'),
			array('title' =>'Blue Coat CofE Primary School','town'=>'Wotton-under-Edge'),
			array('title' =>'Bourton-on-the-Water Primary School','town'=>'Cheltenham'),
			array('title' =>'Bream Church of England Primary School','town'=>'Lydney'),
			array('title' =>'Brimscombe Church of England (VA) Primary School','town'=>'Stroud'),
			array('title' =>'Brockworth Primary Academy','town'=>'Gloucester'),
			array('title' =>'Bromesberrow St Marys Church of England (Aided) Primary School','town'=>'Ledbury'),
			array('title' =>'Bussage Church of England Primary School','town'=>'Stroud'),
			array('title' =>'Callowell Primary School','town'=>'Stroud'),
			array('title' =>'Calton Primary School','town'=>'Gloucester'),
			array('title' =>'Cam Everlands Primary School','town'=>'Dursley'),
			array('title' =>'Cam Hopton Church of England Primary School','town'=>'Dursley'),
			array('title' =>'Cam Woodfield Infant School','town'=>'Dursley'),
			array('title' =>'Cam Woodfield Junior School','town'=>'Dursley'),
			array('title' =>'Cam Woodfield Junior School','town'=>'Dursley'),
			array('title' =>'Cambian Southwick Park School','town'=>'Tewkesbury'),
			array('title' =>'Carrant Brook Junior School','town'=>'Tewkesbury'),
			array('title' =>'Cashes Green Primary School','town'=>'Stroud'),
			array('title' =>'Castle Hill Primary School','town'=>'Gloucester'),
			array('title' =>'Chalford Hill Primary School','town'=>'Stroud'),
			array('title' =>'Charlton Kings Infants School','town'=>'Cheltenham'),
			array('title' =>'Charlton Kings Junior School','town'=>'Cheltenham'),
			array('title' =>'Cheltenham Bournside School and Sixth Form Centre','town'=>'Cheltenham'),
			array('title' =>'Cheltenham College','town'=>'Cheltenham'),
			array('title' =>'Cheltenham Ladies College','town'=>'Cheltenham'),
			array('title' =>'Chesterton Primary School','town'=>'Cirencester'),
			array('title' =>'Chesterton Primary School','town'=>'Cirencester'),
			array('title' =>'Chipping Campden School','town'=>'Chipping Campden'),
			array('title' =>'Chosen Hill School','town'=>'Gloucester'),
			array('title' =>'Christ Church Church of England Primary School','town'=>'Stroud'),
			array('title' =>'Christ Church CofE Primary School','town'=>'Cheltenham'),
			array('title' =>'Churcham Primary School','town'=>'Gloucester'),
			array('title' =>'Churchdown Parton Manor Infant School','town'=>'Gloucester'),
			array('title' =>'Churchdown Parton Manor Junior School','town'=>'Gloucester'),
			array('title' =>'Churchdown School','town'=>'Gloucester'),
			array('title' =>'Churchdown Village Infant School','town'=>'Gloucester'),
			array('title' =>'Churchdown Village Junior School','town'=>'Gloucester'),
			array('title' =>'Cirencester College','town'=>'Cirencester'),
			array('title' =>'Cirencester Deer Park School','town'=>'Cirencester'),
			array('title' =>'Cirencester Kingshill School','town'=>'Cirencester'),
			array('title' =>'Cirencester Primary School','town'=>'Cirencester'),
			array('title' =>'Clearwater Church of England Primary Academy','town'=>'Gloucester'),
			array('title' =>'Clearwell Church of England Primary School','town'=>'Coleford'),
			array('title' =>'Cleeve School','town'=>'Cheltenham'),
			array('title' =>'Coaley Church of England Primary Academy','town'=>'Dursley'),
			array('title' =>'Coaley Church of England Primary School','town'=>'Dursley'),
			array('title' =>'Coalway Community Infant School','town'=>'Coleford'),
			array('title' =>'Coalway Junior School','town'=>'Coleford'),
			array('title' =>'Coberley Church of England Primary School','town'=>'Cheltenham'),
			array('title' =>'Cold Aston Church of England Primary School','town'=>'Cheltenham'),
			array('title' =>'Community Mentoring and Support School','town'=>'Lydney'),
			array('title' =>'Coney Hill Community Primary School','town'=>'Gloucester'),
			array('title' =>'Coopers Edge School','town'=>'Brockworth'),
			array('title' =>'Cotswold Chine School','town'=>'Stroud'),
			array('title' =>'Cranham Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Dean Close Preparatory School','town'=>'Cheltenham'),
			array('title' =>'Dean Close School','town'=>'Cheltenham'),
			array('title' =>'Dean Close St Johns','town'=>'Chepstow'),
			array('title' =>'Deerhurst and Apperley Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Dene Magna School','town'=>'Mitcheldean'),
			array('title' =>'Denmark Road High School','town'=>'Gloucester'),
			array('title' =>'Dinglewell Infant School','town'=>'Gloucester'),
			array('title' =>'Dinglewell Junior School','town'=>'Gloucester'),
			array('title' =>'Dormer House School','town'=>'Moreton-in-Marsh'),
			array('title' =>'Down Ampney Church of England Primary School','town'=>'Cirencester'),
			array('title' =>'Drybrook Primary School','town'=>'Drybrook'),
			array('title' =>'Dunalley Primary School','town'=>'Cheltenham'),
			array('title' =>'Dursley Church of England Primary Academy','town'=>'Dursley'),
			array('title' =>'Eastcombe Primary School','town'=>'Stroud'),
			array('title' =>'Eastington Primary School','town'=>'Stonehouse'),
			array('title' =>'Edward Jenner School','town'=>'Gloucester'),
			array('title' =>'Ellwood Primary School','town'=>'Coleford'),
			array('title' =>'Elmbridge Primary School','town'=>'Gloucester'),
			array('title' =>'English Bicknor Church of England Primary School','town'=>'Coleford'),
			array('title' =>'Fairford Church of England Primary School','town'=>'Fairford'),
			array('title' =>'Farmors School','town'=>'Fairford'),
			array('title' =>'Field Court Church of England Infant Academy','town'=>'Gloucester'),
			array('title' =>'Field Court Junior School','town'=>'Gloucester'),
			array('title' =>'Finlay Community School','town'=>'Gloucester'),
			array('title' =>'Five Acres High School','town'=>'Coleford'),
			array('title' =>'Forest View Primary School','town'=>'Cinderford'),
			array('title' =>'Foxmoor Primary School','town'=>'Stroud'),
			array('title' =>'Gardners Lane Primary School','town'=>'Cheltenham'),
			array('title' =>'Gastrells Community Primary School','town'=>'Stroud'),
			array('title' =>'Glebe Infants School','town'=>'Newent'),
			array('title' =>'Glenfall Community Primary School','town'=>'Cheltenham'),
			array('title' =>'Gloucester Academy','town'=>'Gloucester'),
			array('title' =>'Gloucester Road Primary School','town'=>'Cheltenham'),
			array('title' =>'Gloucestershire College','town'=>'Cheltenham'),
			array('title' =>'Gotherington Primary School','town'=>'Cheltenham'),
			array('title' =>'Grange Primary School','town'=>'Gloucester'),
			array('title' =>'Grange Primary School','town'=>'Gloucester'),
			array('title' =>'Grangefield Primary School','town'=>'Cheltenham'),
			array('title' =>'Greatfield Park Primary School','town'=>'Cheltenham'),
			array('title' =>'Greenfield Academy','town'=>'Dursley'),
			array('title' =>'Gretton Primary School','town'=>'Cheltenham'),
			array('title' =>'Hardwicke Parochial Academy','town'=>'Gloucester'),
			array('title' =>'Haresfield Church of England Primary School','town'=>'Stonehouse'),
			array('title' =>'Harewood Infant School','town'=>'Gloucester'),
			array('title' =>'Harewood Junior School','town'=>'Gloucester'),
			array('title' =>'Hartmore School','town'=>'Gloucester'),
			array('title' =>'Hartpury Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Hartpury Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Hartpury College','town'=>'Gloucester'),
			array('title' =>'Hartpury College','town'=>'Gloucester'),
			array('title' =>'Hatherley Infant School','town'=>'Gloucester'),
			array('title' =>'Hatherop Castle School','town'=>'Cirencester'),
			array('title' =>'Hatherop Church of England Primary School','town'=>'Cirencester'),
			array('title' =>'Heart of the Forest Community Special School','town'=>'Coleford'),
			array('title' =>'Hempsted Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Henley Bank High School','town'=>'Gloucester'),
			array('title' =>'Heron Primary School','town'=>'Gloucester'),
			array('title' =>'Hesters Way Primary School','town'=>'Cheltenham'),
			array('title' =>'Highnam CofE Primary Academy','town'=>'Gloucester'),
			array('title' =>'Hillesley Church of England Primary School','town'=>'Wotton-under-Edge'),
			array('title' =>'Hillview Primary School','town'=>'Gloucester'),
			array('title' =>'Holmleigh Park High School','town'=>'Gloucester'),
			array('title' =>'Holy Apostles Church of England Primary School','town'=>'Cheltenham'),
			array('title' =>'Holy Trinity Church of England Primary School','town'=>'Cheltenham'),
			array('title' =>'Hope Brook CofE Primary School','town'=>'Longhope'),
			array('title' =>'Hopelands Preparatory School','town'=>'Stonehouse'),
			array('title' =>'Horsley Church of England Primary School','town'=>'Stroud'),
			array('title' =>'Huntley Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Hunts Grove Primary Academy','town'=>'Gloucester'),
			array('title' =>'Innsworth Infant School','town'=>'Gloucester'),
			array('title' =>'Innsworth Junior School','town'=>'Gloucester'),
			array('title' =>'Isbourne Valley School','town'=>'Cheltenham'),
			array('title' =>'Katharine Lady Berkeleys School','town'=>'Wotton-under-Edge'),
			array('title' =>'Kemble Primary School','town'=>'Cirencester'),
			array('title' =>'Kemble Primary School','town'=>'Cirencester'),
			array('title' =>'Kempsford Church of England Primary School','town'=>'Fairford'),
			array('title' =>'Kings Stanley CofE Primary School','town'=>'Stonehouse'),
			array('title' =>'Kingsholm Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Kingsway Primary School','town'=>'Gloucester'),
			array('title' =>'Kingswood Primary School','town'=>'Wotton-under-Edge'),
			array('title' =>'Lakefield CofE Primary School','town'=>'Gloucester'),
			array('title' =>'Lakeside Primary School','town'=>'Cheltenham'),
			array('title' =>'Leckhampton Church of England Primary School','town'=>'Cheltenham'),
			array('title' =>'Leighterton Primary School','town'=>'Tetbury'),
			array('title' =>'Leonard Stanley Church of England Primary School','town'=>'Stonehouse'),
			array('title' =>'Linden Primary School','town'=>'Gloucester'),
			array('title' =>'Littledean Church of England Primary School','town'=>'Cinderford'),
			array('title' =>'Longborough Church of England Primary School','town'=>'Moreton-in-Marsh'),
			array('title' =>'Longford Park Primary Academy','town'=>'Gloucester'),
			array('title' =>'Longlevens Infant School','town'=>'Gloucester'),
			array('title' =>'Longlevens Junior School','town'=>'Gloucester'),
			array('title' =>'Longney Church of England Primary Academy','town'=>'Gloucester'),
			array('title' =>'Lydbrook Primary School','town'=>'Lydbrook'),
			array('title' =>'Lydney Church of England Community School (VC)','town'=>'Lydney'),
			array('title' =>'Maidenhill School','town'=>'Stonehouse'),
			array('title' =>'Marling School','town'=>'Stroud'),
			array('title' =>'Meadowside Primary School','town'=>'Gloucester'),
			array('title' =>'Meysey Hampton Church of England Primary School','town'=>'Cirencester'),
			array('title' =>'Mickleton Primary School','town'=>'Chipping Campden'),
			array('title' =>'Millbrook Academy','town'=>'Gloucester'),
			array('title' =>'Minchinhampton Primary Academy','town'=>'Stroud'),
			array('title' =>'Minsterworth Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Miserden Church of England Primary School','town'=>'Stroud'),
			array('title' =>'Mitcheldean Endowed Primary School','town'=>'Mitcheldean'),
			array('title' =>'Mitton Manor Primary School','town'=>'Tewkesbury'),
			array('title' =>'Moat Primary School','town'=>'Gloucester'),
			array('title' =>'Nailsworth Church of England Primary School','town'=>'Stroud'),
			array('title' =>'Naunton Park Primary School','town'=>'Cheltenham'),
			array('title' =>'Newent Community School and Sixth Form Centre','town'=>'Newent'),
			array('title' =>'Newnham St Peters Church of England Primary School','town'=>'Newnham'),
			array('title' =>'North Cerney Church of England Primary Academy','town'=>'Cirencester'),
			array('title' =>'North Nibley Church of England Primary School','town'=>'Dursley'),
			array('title' =>'Northleach Church of England Primary School','town'=>'Cheltenham'),
			array('title' =>'Northway Infant School','town'=>'Tewkesbury'),
			array('title' =>'Norton Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Norton College Tewkesbury','town'=>'Tewkesbury'),
			array('title' =>'Oak Hill Church of England Primary School','town'=>'Tewkesbury'),
			array('title' =>'Oakridge Parochial School','town'=>'Stroud'),
			array('title' =>'Oakwood Primary School','town'=>'Cheltenham'),
			array('title' =>'Offas Mead Academy','town'=>'Chepstow'),
			array('title' =>'Oneschool Global Uk Gloucester Campus','town'=>'Gloucester'),
			array('title' =>'Oneschool Global Uk Bristol Campus','town'=>'Berkeley'),
			array('title' =>'Park Junior School','town'=>'Stonehouse'),
			array('title' =>'Parkend Primary School','town'=>'Lydney'),
			array('title' =>'Paternoster School','town'=>'Cirencester'),
			array('title' =>'Paternoster School','town'=>'Cirencester'),
			array('title' =>'Pates Grammar School','town'=>'Cheltenham'),
			array('title' =>'Pauntley Church of England Primary School','town'=>'Newent'),
			array('title' =>'Peak Academy','town'=>'Dursley'),
			array('title' =>'Picklenash Junior School','town'=>'Newent'),
			array('title' =>'Pillowell Community Primary School','town'=>'Lydney'),
			array('title' =>'Pittville School','town'=>'Cheltenham'),
			array('title' =>'Powells Church of England Primary School','town'=>'Cirencester'),
			array('title' =>'Prestbury St Marys Church of England Junior School','town'=>'Cheltenham'),
			array('title' =>'Primrose Hill Church of England Primary Academy','town'=>'Lydney'),
			array('title' =>'Queen Margaret Primary School','town'=>'Tewkesbury'),
			array('title' =>'Randwick Church of England Primary School','town'=>'Stroud'),
			array('title' =>'Redbrook Church of England Primary School','town'=>'Monmouth'),
			array('title' =>'Redmarley Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Rednock School','town'=>'Dursley'),
			array('title' =>'Rendcomb College','town'=>'Cirencester'),
			array('title' =>'Ribston Hall High School','town'=>'Gloucester'),
			array('title' =>'Robinswood Primary Academy','town'=>'Gloucester'),
			array('title' =>'Rodborough Community Primary School','town'=>'Stroud'),
			array('title' =>'Rodmarton School','town'=>'Cirencester'),
			array('title' =>'Rowanfield Infant School','town'=>'Cheltenham'),
			array('title' =>'Rowanfield Junior School','town'=>'Cheltenham'),
			array('title' =>'Ruardean Church of England Primary School','town'=>'Ruardean'),
			array('title' =>'Sapperton Church of England Primary School','town'=>'Cirencester'),
			array('title' =>'Severn Vale School','town'=>'Gloucester'),
			array('title' =>'Severn View Academy','town'=>'Stroud'),
			array('title' =>'Severnbanks Primary School','town'=>'Lydney'),
			array('title' =>'SGS Berkeley Green UTC','town'=>'Berkeley'),
			array('title' =>'Sharpness Primary School','town'=>'Berkeley'),
			array('title' =>'Sheepscombe Primary School','town'=>'Stroud'),
			array('title' =>'Sherborne Church of England Primary School','town'=>'Cheltenham'),
			array('title' =>'Shurdington Church of England Primary School','town'=>'Cheltenham'),
			array('title' =>'Siddington Church of England Primary School','town'=>'Cirencester'),
			array('title' =>'Siddington Church of England Primary School','town'=>'Cirencester'),
			array('title' =>'Sir Thomas Richs School','town'=>'Gloucester'),
			array('title' =>'Sir William Romneys School','town'=>'Tetbury'),
			array('title' =>'Slimbridge Primary School','town'=>'Gloucester'),
			array('title' =>'Soudley School','town'=>'Cinderford'),
			array('title' =>'Southrop Church of England Primary School','town'=>'Lechlade'),
			array('title' =>'Springbank Primary Academy','town'=>'Cheltenham'),
			array('title' =>'St Andrews Church of England Primary School','town'=>'Cheltenham'),
			array('title' =>'St Anthonys School','town'=>'Cinderford'),
			array('title' =>'St Briavels Parochial Church of England Primary School','town'=>'Lydney'),
			array('title' =>'St Catharines Catholic Primary School','town'=>'Chipping Campden'),
			array('title' =>'St Davids Church of England Primary School','town'=>'Moreton-in-Marsh'),
			array('title' =>'St Dominics Catholic Primary School','town'=>'Stroud'),
			array('title' =>'St Edwards Preparatory School','town'=>'Cheltenham'),
			array('title' =>'St Edwards School','town'=>'Cheltenham'),
			array('title' =>'St James and Ebrington Church of England Primary School','town'=>'Chipping Campden'),
			array('title' =>'St James Church of England Junior School','town'=>'Gloucester'),
			array('title' =>'St James Church of England Primary School','town'=>'Cheltenham'),
			array('title' =>'St Johns C of E Academy','town'=>'Coleford'),
			array('title' =>'St Johns Church of England Primary School','town'=>'Cheltenham'),
			array('title' =>'St Josephs Catholic Primary School','town'=>'Stonehouse'),
			array('title' =>'St Lawrence Church of England Primary School','town'=>'Lechlade'),
			array('title' =>'St Lawrence Church of England Primary School','town'=>'Lechlade'),
			array('title' =>'St Marks Church of England Junior School','town'=>'Cheltenham'),
			array('title' =>'St Marys Catholic Primary School','town'=>'Gloucester'),
			array('title' =>'St Marys Church of England Infant School','town'=>'Cheltenham'),
			array('title' =>'St Marys Church of England VA Primary School','town'=>'Tetbury'),
			array('title' =>'St Matthews Church of England Primary School','town'=>'Stroud'),
			array('title' =>'St Matthews Church of England Primary School','town'=>'Stroud'),
			array('title' =>'St Pauls Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'St Peters Catholic High School and Sixth Form Centre','town'=>'Gloucester'),
			array('title' =>'St Peters Catholic Primary School','town'=>'Gloucester'),
			array('title' =>'St Roses Special School','town'=>'Stroud'),
			array('title' =>'St Thomas More Catholic Primary School','town'=>'Cheltenham'),
			array('title' =>'St Whites Primary School','town'=>'Cinderford'),
			array('title' =>'Staunton and Corse Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Steam Mills Primary School','town'=>'Cinderford'),
			array('title' =>'Stone with Woodford Church of England Primary School','town'=>'Berkeley'),
			array('title' =>'Stonehouse Park Infant School','town'=>'Stonehouse'),
			array('title' =>'Stow-on-the-Wold Primary School','town'=>'Cheltenham'),
			array('title' =>'Stratton Church of England Primary School','town'=>'Cirencester'),
			array('title' =>'Stroud High School','town'=>'Stroud'),
			array('title' =>'Stroud Valley Community Primary School','town'=>'Stroud'),
			array('title' =>'Swell Church of England Primary School','town'=>'Cheltenham'),
			array('title' =>'Swindon Village Primary School','town'=>'Cheltenham'),
			array('title' =>'Temple Guiting Church of England School','town'=>'Cheltenham'),
			array('title' =>'Tewkesbury Church of England Primary School','town'=>'Tewkesbury'),
			array('title' =>'Tewkesbury School','town'=>'Tewkesbury'),
			array('title' =>'The Acorn School','town'=>'Stroud'),
			array('title' =>'The British School','town'=>'Wotton-under-Edge'),
			array('title' =>'The Catholic School of Saint Gregory the Great','town'=>'Cheltenham'),
			array('title' =>'The Cotswold Academy','town'=>'Cheltenham'),
			array('title' =>'The Croft Primary School','town'=>'Stroud'),
			array('title' =>'The Crypt School','town'=>'Gloucester'),
			array('title' =>'The Dean Academy','town'=>'Lydney'),
			array('title' =>'The Forest High School','town'=>'Cinderford'),
			array('title' =>'The John Moore Primary School','town'=>'Tewkesbury'),
			array('title' =>'The Kings School Gloucester','town'=>'Gloucester'),
			array('title' =>'The Milestone School','town'=>'Gloucester'),
			array('title' =>'The Milestone School','town'=>'Gloucester'),
			array('title' =>'The Richard Pate School','town'=>'Cheltenham'),
			array('title' =>'The Ridge Academy','town'=>'Cheltenham'),
			array('title' =>'The Rissington School','town'=>'Cheltenham'),
			array('title' =>'The Rosary Catholic Primary School','town'=>'Stroud'),
			array('title' =>'The Shrubberies School','town'=>'Stonehouse'),
			array('title' =>'Thomas Keble School','town'=>'Stroud'),
			array('title' =>'Thrupp School','town'=>'Stroud'),
			array('title' =>'Tibberton Community Primary School','town'=>'Gloucester'),
			array('title' =>'Tirlebrook Primary School','town'=>'Tewkesbury'),
			array('title' =>'Tredington Community Primary School','town'=>'Tewkesbury'),
			array('title' =>'Tredworth Infant and Nursery Academy','town'=>'Gloucester'),
			array('title' =>'Tredworth Junior School','town'=>'Gloucester'),
			array('title' =>'Tuffley Primary School','town'=>'Gloucester'),
			array('title' =>'Tutshill Church of England Primary School','town'=>'Chepstow'),
			array('title' =>'Twyning School','town'=>'Tewkesbury'),
			array('title' =>'Uley Church of England Primary School','town'=>'Dursley'),
			array('title' =>'Uplands Community Primary School','town'=>'Stroud'),
			array('title' =>'Upton St Leonards Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Walmore Hill Primary School','town'=>'Gloucester'),
			array('title' =>'Warden Hill Primary School','town'=>'Cheltenham'),
			array('title' =>'Watermoor Church of England Primary School','town'=>'Cirencester'),
			array('title' =>'Waterwells Primary Academy','town'=>'Gloucester'),
			array('title' =>'Westbury-on-Severn Church of England Primary School','town'=>'Westbury-on-Severn'),
			array('title' =>'Westonbirt School','town'=>'Tetbury'),
			array('title' =>'Whiteshill Primary School','town'=>'Stroud'),
			array('title' =>'Whitminster Endowed Church of England Primary School','town'=>'Gloucester'),
			array('title' =>'Widden Primary School','town'=>'Gloucester'),
			array('title' =>'Willersey Church of England Primary School','town'=>'Broadway'),
			array('title' =>'Winchcombe Abbey Church of England Primary School','town'=>'Cheltenham'),
			array('title' =>'Winchcombe School','town'=>'Cheltenham'),
			array('title' =>'Withington Church of England Primary School','town'=>'Cheltenham'),
			array('title' =>'Woodchester Endowed Church of England Aided Primary School','town'=>'Stroud'),
			array('title' =>'Woodmancote School','town'=>'Cheltenham'),
			array('title' =>'Woodside Primary School','town'=>'Ruardean'),
			array('title' =>'Woolaston Primary School','town'=>'Lydney'),
			array('title' =>'Wotton House International School','town'=>'Gloucester'),
			array('title' =>'Wycliffe College','town'=>'Stonehouse'),
			array('title' =>'Wyedean School and 6th Form Centre','town'=>'Chepstow'),
			array('title' =>'Wynstones School','town'=>'Gloucester'),
			array('title' =>'Yorkley Primary School','town'=>'Lydney')
		  );

		// foreach ($schools as $school) {

		// 	// Initialize the page ID to -1. This indicates no action has been taken.
		// 	$post_id = -1;

		// 	// Setup the author, slug, and title for the post
		// 	$author_id = 2;

		// 	// Set the post ID so that we know the post was created successfully
		// 	$post_id = wp_insert_post(
		// 		array(
		// 			'comment_status'	=>	'closed',
		// 			'ping_status'		=>	'closed',
		// 			'post_author'		=>	$author_id,
		// 			'post_title'		=>	$school['title'],
		// 			'post_status'		=>	'publish',
		// 			'post_type'		=>	'school'
		// 		)
		// 	);
		// 	wp_set_post_terms( $post_id, $school['town'], 'towncity' );

		// }

		// wp_die('Schools added, disable this function');

	}

	/**
	 * Add a new school if it wasn't select from autopopulated list by the user
	 *
	 * param 	$postdata 	the post data sent by $_POST
	 *
	 * @return void
	 */
	public function update_school_entries($postdata) {


		if( null == get_page_by_title( $postdata['child_school'], 'OBJECT', 'school' ) ) {

			// Create post object
			$school = array(
				'post_title'    => wp_strip_all_tags( $postdata['child_school'] ),
				'post_status'   => 'publish',
				'post_author'   => $postdata['user_id'],
				'post_type' 	=> 'school'
			);

			// Insert the post into the database
			wp_insert_post( $school );
		}

	}

	/**
	 * Process csv uploaded line by line.
	 *
	 * @since    1.0.2
	 * @param    string    $fn    the location of the filename uploaded.
	 */
	public function process_multi_line_upload($fn, $timenow, $user_id) {

		$timenow = date('Y-m-d H:i:s', $timenow);

		$c = 0; $h = fopen($fn, "r");
		while(!feof($h)){

			//var_dump(fgetcsv($h, 5000, ","));
			$process_line = fgetcsv($h, 5000, ",");

			//var_dump($process_line); wp_die();

			global $wpdb; // this is how you get access to the database
			$table_name = $wpdb->prefix . 'cfpa_children';

			$dob_pieces = explode('/', $process_line[1]);
			$dob = sanitize_text_field($dob_pieces[2]) . '-' . sanitize_text_field($dob_pieces[1]) . '-' . sanitize_text_field($dob_pieces[0]);
			$child_name = sanitize_text_field($process_line[0]);
			$child_school = sanitize_text_field($process_line[2]);
			$user_id = (int) sanitize_text_field($user_id);
			$registered_date = sanitize_text_field($timenow);
			$child_dob = date('Y-m-d', strtotime($dob));
			$last_edit = sanitize_text_field(strtotime('now').':'.$user_id);

			//var_dump($child_dob); wp_die();

			$wpdb->query( $wpdb->prepare(
				"
					INSERT INTO $table_name
					( child_name, child_school, user_id, registered_date, child_dob, child_exception_date, last_edit )
					VALUES ( %s, %s, %d, %s, %s, %s, %s )
				",
			        array(
					$child_name,
					$child_school,
					$user_id,
					$registered_date,
					$child_dob,
					$child_dob,
					$last_edit,
				)
			) );


			$c++;
		}
		fclose($h);
		return $c;
	}

	/**
	 * check if the group has a pre filled number of members
	 *
	 * @param	$group_id	int	the db ID for the group entry
	 * @return	boolean
	 */
	public function check_group_numbers() {

		$nonce = $_POST['nextNonce'];

		if ( ! wp_verify_nonce( $nonce, 'check-group-numbers' ) ) {
		    die( 'Security check busted!' );
		} else {
			global $wpdb;
			$group_id = $_POST['group_id'];
			$table_name = $wpdb->prefix . 'cfpa_groups';
			$group = $wpdb->get_results(
				"
				SELECT group_id, group_name, group_number, user_id, registered_date, last_edit
				FROM $table_name
				WHERE group_id = $group_id
				"
			);
			$group_numbers = false;
			if($group[0]->group_number > 0) {
				$group_numbers = true;
			}

			wp_send_json($group_numbers);


		}
	}

	/**
	 * Some ajax for entering classes.
	 *
	 * @since    1.0.2
	 */
	public function get_groups() {
		$nonce = $_POST['nextNonce'];

		if ( ! wp_verify_nonce( $nonce, 'get-groups' ) ) {
		    die( 'Security check busted!' );
		} else {
			$user_id = get_current_user_id();

			$groups = $this->get_users_groups($user_id);

			$array = array();
			$i = 0;
			foreach ($groups as $group){
				$array['group_id'][] = $group->group_id;
				$array['group'][] = $group->group_name;

				$i++;
			}

			echo json_encode($array);
		    die(); // this is required to terminate immediately and return a proper response
		}

	}

	/**
	 * Check if user has children/performers.
	 *
	 * @param int $user_id user's ID.
	 * @return boolean
	 */
	public function check_user_has_performers($user_id) {
		$childrens = $this->get_users_children($user_id);
		$groups = $this->get_users_groups($user_id);
		if ($childrens || $groups) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check the users position .
	 *
	 * @param int $user_id user's ID.
	 * @return string $users_position
	 */
	public function get_users_position($user_id) {
		$users_position = get_usermeta($user_id, 'user_position');
		return $users_position;
	}

	/**
	 * Superseeds get_children() and loads the children with the script.
	 *
	 * @since    1.0.2
	 */
	public function pre_get_children($child_id = false) {
		$user_id = get_current_user_id();
		$childrens = $this->get_users_children($user_id);
		foreach ($childrens as $child){
			if($child_id == $child->child_id) {
				continue;
			}
			$array[$child->child_id] = $child->child_name;
		}
		return $array;
	}

	/**
	 * Get groups associated to a user
	 *
	 * @return array $array
	 */
	public function pre_get_groups() {
		$array = array();
		$user_id = get_current_user_id();
		$groups = $this->get_users_groups($user_id);
		foreach( $groups as $group ) {
			$array[$group->group_id] = $group->group_name;
		}
		return $array;
	}

	/**
	 * Get users children.
	 *
	 * @since    1.0.2
	 */
	public function jstest_get_children() {

		$array = array();

		$user_id = get_current_user_id();
		$childrens = $this->get_users_children($user_id);
		$i = 0;
		foreach ($childrens as $child){
			$array['user_id'][] = $child->user_id;
			$array['child_id'][] = $child->child_id;
			$array['children'][] = $child->child_name;
			$array['registered'][] = $child->registered_date;
			$array['dob'][] = $child->child_dob;
			$array['exception_date'][] = $child->child_exception_date;

			$i++;
		}

		return $array;

	}

	/**
	 * Some ajax for entering classes.
	 *
	 * @since    1.0.2
	 */
	public function get_children() {
		$nonce = $_POST['nextNonce'];

		if ( ! wp_verify_nonce( $nonce, 'get-children' ) ) {
		    die( 'Security check busted!' );
		} else {

			$array = array();

			$user_id = get_current_user_id();
			$childrens = $this->get_users_children($user_id);
			$i = 0;
			foreach ($childrens as $child){
				$array['child_id'][] = $child->child_id;
				$array['children'][] = $child->child_name;

				$i++;
			}

			echo json_encode($array);
		    die(); // this is required to terminate immediately and return a proper response
		}

	}

	/**
	 * Get all schools post type data for use with javascript
	 *
	 * @return $schools
	 */
	public function get_all_schools_data() {
		$args = array(
			'post_type'  => 'school',
			'posts_per_page' => -1,
			'orderby'          => 'date',
			'order'            => 'ASC',
			'post_status' => 'publish',
		);
		$schools = get_posts( $args );
		$array = array(); $i = 0;
		foreach ($schools as $school) {
			$array[$i]['value'] = $school->ID;
			$array[$i]['label'] = $school->post_title;
			$i++;
		}

		return $array;
	}

	/**
	 * Get qualifiying group classes.
	 *
	 */
	public function get_qualifying_group_classes() {

		$args = array(
			'post_type'  => 'class',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'meta_key' => 'class-entrants',
			'meta_value' => 'g'
		);
		$classes = get_posts( $args );

		$array = array();
		$i = 0;

		$terms = get_terms( array( 'taxonomy' => 'class_cat', 'hide_empty' => false ) );

		foreach ($classes as $class) {
			$lower_age = get_post_meta($class->ID, 'lower-age', true);
			$upper_age = get_post_meta($class->ID, 'upper-age', true);

			if (empty($lower_age)) {
				$lower_age = 0;
			}
			if (empty($upper_age)) {
				$upper_age = 99;
			}

			$age_range = range($lower_age, $upper_age);


			//if (in_array($age, $age_range)) {
				$array['all'][$class->ID] = get_post_meta($class->ID, 'class-ref-no', true) . ' - ' . $class->post_title;

				$post_class_cats = wp_get_object_terms($class->ID, 'class_cat');

				foreach ($terms as $term) {
					if ($term->slug == $post_class_cats[0]->slug) {
						$array[$term->slug][$class->ID] = get_post_meta($class->ID, 'class-ref-no', true) . ' - ' . $class->post_title;
					}
				}

			//}

			$i++;
		}

		return $array;
	}



	/**
	 * Some ajax for entering classes.
	 *
	 * @since    1.0.2
	 * @return array $array qualifiying classes by key (post id) and value (post title) for this competitor
	 */
	public function get_qualifying_group_classes_by_id() {

		$nonce = $_POST['nextNonce'];

		if ( ! wp_verify_nonce( $nonce, 'get-groups' ) ) {
		    die( 'Security check busted!' );
		} else {

			global $wpdb;

			$group_id = $_POST['group_id'];

			$table_name = $wpdb->prefix . 'cfpa_groups';
			$group = $wpdb->get_results(
				"
				SELECT group_id, group_name, user_id, registered_date, last_edit
				FROM $table_name
				WHERE group_id = $group_id
				"
			);

			$array['classes'] = $this->get_qualifying_group_classes();

			echo json_encode($array);

		    die(); // this is required to terminate immediately and return a proper response
		}

	}

	/**
	 * Some ajax for entering classes.
	 *
	 * @since    1.0.2
	 * @return array $array qualifiying classes by key (post id) and value (post title) for this competitor
	 */
	public function get_qualifying_classes_by_id() {



		$nonce = $_POST['nextNonce'];

		if ( ! wp_verify_nonce( $nonce, 'get-children' ) ) {
		    die( 'Security check busted!' );
		} else {

			global $wpdb;

			$child_id = $_POST['child_id'];

			$table_name = $wpdb->prefix . 'cfpa_children';
			$child = $wpdb->get_results(
				"
				SELECT child_id, child_name, user_id, registered_date, child_dob, child_exception_date, child_school, last_edit
				FROM $table_name
				WHERE child_id = $child_id
				"
			);

			//$q_age = $this->get_qualifying_age($child[0]->child_dob);
			$q_age = $this->get_qualifying_age_array($child[0]->child_dob);

			$years_old = $this->get_performers_age($child[0]->child_dob);
			if($years_old < 17 && empty($child[0]->child_school)) {
				$array['error'] = '<p>The Performer\'s Place of Education must now be entered (except see <small><sup>**</sup></small> below).</p>
				<p>Please go to <a href="/cfpa-user/add-performer/">Add/Edit Performer(s)</a>, click on the performer\'s \'Edit\' icon using <i class="fa fa-pencil-square fa-2x" aria-hidden="true" style="color: #3ba3da;"></i> and enter the school or college name in the Place of Education box that will appear.  You will then be able to use Enter Performer to enter the performer into a class.</p>
				<br>
				<p><sup>**</sup> Please enter and select \'Home schooled\' or \'No longer in school\' or \'School not listed\' if any of these apply.</p>';
			} else {
				$array['classes'] = $this->get_qualifying_classes($q_age, $child[0]->child_dob);
			}


			//echo json_encode($array);
			wp_send_json( $array );

		    die(); // this is required to terminate immediately and return a proper response
		}

	}

	/**
	 * Get qualifiying classes a competitor can enter based on age range.
	 *
	 * @param array $ages the qualifiying ages of the competitor.
	 * @param string $dob the date of birth of the competitor.
	 * @return array $class_ids the ids of qualifiying classes for this competitor
	 */
	public function get_qualifying_classes($ages, $dob) {

		$array = array();
		//echo json_encode($ages);

		foreach ($ages as $k => $age) {

			if ($k == 'dance_age') {
				$args = array(
					'post_type'  => 'class',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'order' => 'ASC',
					'orderby' => 'title',
					'meta_key'     => 'class-entrants',
					'meta_value'   => 'g',
					'meta_compare' => '!=',
					'tax_query' => array(
						array(
							'taxonomy' => 'class_cat',
							'field'    => 'slug',
							'terms'    => array('dance'),
						),
					),

				);
			}
			if ($k == 'music_drama_age') {
				$args = array(
					'post_type'  => 'class',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'order' => 'ASC',
					'orderby' => 'title',
					'meta_key'     => 'class-entrants',
					'meta_value'   => 'g',
					'meta_compare' => '!=',
					'tax_query' => array(
						array(
							'taxonomy' => 'class_cat',
							'field'    => 'slug',
							'terms'    => array('music','drama'),
						),
					),

				);
			}

			$classes = get_posts( $args );

			$terms = get_terms( array( 'taxonomy' => 'class_cat', 'hide_empty' => false ) );

			$i = 0;
			foreach ($classes as $class) {
				$lower_age = get_post_meta($class->ID, 'lower-age', true);
				$upper_age = get_post_meta($class->ID, 'upper-age', true);

				if (empty($lower_age)) {
					$lower_age = 0;
				}
				if (empty($upper_age)) {
					$upper_age = 99;
				}

				$age_range = range($lower_age, $upper_age);


				if (in_array($age, $age_range)) {
					$array['all'][$class->ID] = get_post_meta($class->ID, 'class-ref-no', true) . ' - ' . $class->post_title;

					$post_class_cats = wp_get_object_terms($class->ID, 'class_cat');

					foreach ($terms as $term) {
						if ($term->slug == $post_class_cats[0]->slug) {
							$array[$term->slug][$class->ID] = get_post_meta($class->ID, 'class-ref-no', true) . ' - ' . $class->post_title;
						}
					}

				}

				$i++;
			}

		}

		return $array;
	}


	public function remove_child() {
		$nonce = $_POST['nextNonce'];
		print_r($_POST);
		if ( ! wp_verify_nonce( $nonce, 'remove-child' ) ) {
		    die( 'Security check busted!' );
		} else {
			global $wpdb; // this is how you get access to the database
			$table_name = $wpdb->prefix . 'cfpa_children';

			$wpdb->delete( $table_name, array( 'child_id' => $_POST['child_id'] ), array( '%d' ) );

		    die(); // this is required to terminate immediately and return a proper response
		}
	}

	public function remove_group() {
		$nonce = $_POST['nextNonce'];
		print_r($_POST);
		if ( ! wp_verify_nonce( $nonce, 'remove-group' ) ) {
		    die( 'Security check busted!' );
		} else {
			global $wpdb; // this is how you get access to the database
			$table_name = $wpdb->prefix . 'cfpa_groups';

			$wpdb->delete( $table_name, array( 'group_id' => $_POST['group_id'] ), array( '%d' ) );

		    die(); // this is required to terminate immediately and return a proper response
		}
	}


	/**
	 * Add user account details to primary menu.
	 *
	 * @since    1.0.2
	 * @param    int    $items    the currently logged in users ID.
	 */
	public function cfpa_loginout_menu_link( $items, $args ) {

		if ($args->theme_location == 'primary') {
			if (is_user_logged_in()) {
				$items .= '<li class="right"><a href="/user/account/">'. __("Your Account") .'</a></li>';
				$items .= '<li class="right"><a href="'. wp_logout_url() .'">'. __("Logout") .'</a></li>';
			} else {
				$items .= '<li class="right"><a href="'. wp_login_url(get_permalink()) .'">'. __("Login") .'</a></li>';
			}
		}
		return $items;

	}

	/**
	 * Redirect user after successful login.
	 *
	 * @param string $redirect_to URL to redirect to.
	 * @param string $request URL the user is coming from.
	 * @param object $user Logged user's data.
	 * @return string
	 */
	public function cfpa_redirect( $redirect_to, $request, $user ) {
		//is there a user to check?
		$account_url = home_url(). '/cfpa-user/account/';

		if ( isset( $user->roles ) && is_array( $user->roles ) ) {
			//check for admins
			if ( in_array( 'administrator', $user->roles ) ) {
				// redirect them to the default place
				// return admin_url();
				return $account_url;
			} else {
				return $account_url;
			}
		} else {
			return $account_url;
		}
	}

	/**
	 * Get all users children associated with their account.
	 *
	 * @param int $user_id user's ID.
	 * @return array $array of all the children
	 */
	public function jstest_get_users_children() {

		global $wpdb;

		$table_name = $wpdb->prefix . 'cfpa_children';

		$childrens = $wpdb->get_results(
			"
			SELECT child_id, user_id, child_name, child_school, registered_date, child_dob, child_exception_date, last_edit
			FROM $table_name
			"
		);

		foreach ($childrens as $children) {
			$day = date('d', strtotime($children->child_dob));
			$month = date('m', strtotime($children->child_dob));
			$year = date('Y', strtotime($children->child_dob));
			$children->child_d = $day;
			$children->child_m = $month;
			$children->child_y = $year;
		}

		return $childrens;

	}

	/**
	 * Get all users children associated with their account.
	 *
	 * @param int $user_id user's ID.
	 * @return array $array of all the children
	 */
	public function get_users_children($user_id) {

		global $wpdb;

		$table_name = $wpdb->prefix . 'cfpa_children';
		$childrens = $wpdb->get_results(
			"
			SELECT child_id, child_name, child_school, parent_email, registered_date, child_dob, child_exception_date, last_edit
			FROM $table_name
			WHERE user_id = $user_id
			"
		);

		foreach ($childrens as $children) {
			$age = $this->get_performers_age($children->child_dob);
			$day = date('d', strtotime($children->child_dob));
			$month = date('m', strtotime($children->child_dob));
			$year = date('Y', strtotime($children->child_dob));
			$children->child_d = $day;
			$children->child_m = $month;
			$children->child_y = $year;
			$children->child_school_id = $children->child_school ? $children->child_school : '';
			if(intval($age) <= 16 && empty($children->child_school)) {
				$children->child_performance_disabled = true;
			} else {
				$children->child_performance_disabled = false;
			}
			$children->child_school = $children->child_school ? $this->get_school_title_from_id($children->child_school) : '';
			$children->age = $age;
		}

		return $childrens;

	}

	/**
	 * Get school title from post id
	 *
	 * @param [type] $post_id
	 * @return void
	 */
	public function get_school_title_from_id($post_id) {
		$school = get_post($post_id);
		return $school->post_title;
	}

	/**
	 * Get all users groups associated with their account.
	 *
	 * @param int $user_id user's ID.
	 * @return array $array of all the groups
	 */
	public function get_users_groups($user_id) {

		global $wpdb;

		$table_name = $wpdb->prefix . 'cfpa_groups';
		$groups = $wpdb->get_results(
			"
			SELECT group_id, group_name, group_number, registered_date, last_edit
			FROM $table_name
			WHERE user_id = $user_id
			"
		);

		return $groups;

	}

	/**
	 * Get the qualifying age of a competitor.
	 *
	 * @param int $dob YYYY-MM-DD h:i:s.
	 * @return string $q_age the qualifying age of competitor

		// @TODO drama & music 1st Sept
		// @TODO dance 1st Jan

	 */
	public function get_qualifying_age($dob) {

		$age = (date('Y') - date('Y',strtotime($dob)));
		$year = date('Y',strtotime($dob));

		$termstart = strtotime('1st Sept ' . $year);
		$unix_dob = strtotime($dob);


		if ($unix_dob > $termstart) {
			$q_age = $age;
		} else {
			$q_age = --$age;
		}

		return $q_age;
	}

	public function get_performers_age($dob) {

		$now = new DateTime('today');
		$august_this_year = new DateTime('31st August this year');

		if($now < $august_this_year) {
			$term_year = date('Y',strtotime('last year'));
		} else {
			$term_year = date('Y',strtotime('today'));
		}

		$term_year = new DateTime('31st August ' . $term_year);
		$dob = new DateTime($dob);
		$age = $dob->diff($term_year);
		$years_old = $age->y;

		return $years_old;
	}

	/**
	 * Get the qualifying age of a competitor.
	 *
	 * @param int $dob YYYY-MM-DD h:i:s.
	 * @return string $q_age the qualifying age of competitor

		// @TODO drama & music 1st Sept
		// @TODO dance 1st Jan

	 */
	public function get_qualifying_age_array($dob) {

		$years_old = $this->get_performers_age($dob);

		$q_age = array();
		$q_age['music_drama_age'] = $years_old;
		$q_age['dance_age'] = $years_old;

		return $q_age;

		// we currently go not further than this as this is now for ages as at 31st August term year
		$from = new DateTime($dob);
		$to   = new DateTime('today');

		$current_year = date('Y',strtotime('today'));
		$last_year = date('Y',strtotime('last year'));

		$this_month = new DateTime('August this year');
		$jan_next_year = new DateTime('Jan next year');


		if($this_month < $jan_next_year) {
			$term_year = $current_year;
		} else {
			$term_year = $last_year;
		}


		$current_music_drama_termstart = new DateTime('31st Aug ' . $term_year);
		$current_dance_termstart = new DateTime('31st Aug ' . $term_year);

		$q_age = array();
		$q_age['music_drama_age'] = $from->diff($current_music_drama_termstart)->y;
		$q_age['dance_age'] = $from->diff($current_dance_termstart)->y;

		//echo $current_year;

		return $q_age;
	}

	/**
	 * Get all classes ID's.
	 *
	 * @param string $post_type.
	 * @return array $class_ids for the registered post type
	 */
	public function get_all_posts_from_post_type($post_type) {

		$args = array(
			'posts_per_page' => -1,
			'post_type' => $post_type,
			'post_status' => 'publish',
		);
		$post_type_array = get_posts( $args );

		return $post_type_array;

	}

	/**
	 * Get classes available to a users children sets.
	 *
	 * @param int $post_id post ID.
	 * @return array $age_range of all the children
	 */
	public function get_class_age_range($post_id) {

		$lower_age = get_post_meta($post_id, 'lower-age', true);
		$upper_age = get_post_meta($post_id, 'upper-age', true);

		if (empty($lower_age)) {
			$lower_age = 0;
		}

		if (empty($upper_age)) {
			$upper_age = 90;
		}
		$age_range = range($lower_age, $upper_age);

		return $age_range;
	}

	/**
	 * Get classes available to a users children sets.
	 *
	 * @param int $user_id user's ID.
	 * @return array $array of all the children
	 */
	public function get_eligible_classes($user_id) {

		$childrens = $this->get_users_children($user_id);

		$classes = $this->get_all_posts_from_post_type('class');

		foreach ($childrens as $children) {
			$dob = $children->child_dob;
			$age = (date('Y') - date('Y',strtotime($dob)));

			$qualifying_age = $this->get_qualifying_age($dob);

			$eligible_classes = array();
			foreach ($classes as $class) {
				$age_range = $this->get_class_age_range($class->ID);
				if (in_array($qualifying_age, $age_range)) {
					$eligible_classes[] = $class->ID;
				}
			}

		}

		return $eligible_classes;
	}


	/**
	 * Some ajax for adding to the basket.
	 *
	 * @since    1.0.2
	 * @return @TODO
	 */
	public function add_group_to_basket() {

		$nonce = $_POST['nextNonce'];

		if ( ! wp_verify_nonce( $nonce, 'add-group-to-basket' ) ) {
		    die( 'Security check busted!' );
		} else {

			global $wpdb; // this is how you get access to the database
			// store basket meta
			$basket_table = $wpdb->prefix . 'cfpa_basket_meta';

			$timenow = date('Y-m-d H:i:s', strtotime('now'));

			$user_id = $_POST['user_id'];
			$basket_item = $_POST;
			$unsets = array('nextNonce','action','user_id');
			foreach ($unsets as $k) {
				unset($basket_item[$k]);
			}

			// check class entrants and add to items
			$number_entrants = get_post_meta($basket_item['group_class_id'], 'class-entrants', true);
			$basket_item['max_entrants'] = $number_entrants;

			// check if this user already has a basket, if not then create one
			$users_basket = $this->check_users_basket($user_id);

			$baskets = array();
			$baskets[] = $basket_item;

			if (isset($errors) && !empty($errors)) {
				foreach ($errors as $error) {
					echo '<li id="basket-error" class="warning alert">'.$error['error'].'</li>';
					echo '<p class="alert-info">'.$error['info'].'</p>';
				}
			} else {
				if (!empty($users_basket) && isset($users_basket)) {

					$baskets = array_merge($baskets, unserialize( $users_basket[0]['basket_items']));

					$basket_table = $wpdb->prefix . 'cfpa_basket_meta'; // children table
					$wpdb->update(
						$basket_table,
						array(
							'basket_items' => serialize($baskets),	// string
						),
						array( 'basket_id' => $users_basket[0]['basket_id'] ),
						array(
							'%s',	// value1
						)
					);

				} else {

					$wpdb->query( $wpdb->prepare(
						"
							INSERT INTO $basket_table
							( user_id, basket_items, basket_generate_date )
							VALUES ( %d, %s, %s )
						",
					        array(
							$user_id,
							serialize($baskets),
							$timenow
						)
					) );

				}
			}

			// if under add to array incomplete
			// log error


			// if users basksets add these items to the basket id
			// else create a new basket



			$this->render_basket_items($user_id);

		    die(); // this is required to terminate immediately and return a proper response
		}
	}

	/**
	 * Some ajax for adding to the basket.
	 *
	 * @since    1.0.2
	 * @return @TODO
	 */
	public function add_programme_to_basket() {
		$nonce = $_POST['nextNonce'];

		if ( ! wp_verify_nonce( $nonce, 'add-programme-to-basket' ) ) {
		    die( 'Security check busted!' );
		} else {

			global $wpdb; // this is how you get access to the database
			// store basket meta
			$basket_table = $wpdb->prefix . 'cfpa_basket_meta';

			$timenow = date('Y-m-d H:i:s', strtotime('now'));

			$user_id = $_POST['user_id'];
			$basket_item = $_POST;
			$unsets = array('nextNonce','action','user_id');
			foreach ($unsets as $k) {
				unset($basket_item[$k]);
			}

			// check if this user already has a basket, if not then create one
			$users_basket = $this->check_users_basket($user_id);

			$baskets = array();
			$baskets[] = $basket_item;

			if (!empty($users_basket) && isset($users_basket)) {

				$baskets = array_merge($baskets, unserialize( $users_basket[0]['basket_items']));

				$basket_table = $wpdb->prefix . 'cfpa_basket_meta'; // children table
				$wpdb->update(
					$basket_table,
					array(
						'basket_items' => serialize($baskets),	// string
					),
					array( 'basket_id' => $users_basket[0]['basket_id'] ),
					array(
						'%s',	// value1
					)
				);

			} else {

				$wpdb->query( $wpdb->prepare(
					"
						INSERT INTO $basket_table
						( user_id, basket_items, basket_generate_date )
						VALUES ( %d, %s, %s )
					",
				        array(
						$user_id,
						serialize($baskets),
						$timenow
					)
				) );

			}

			$this->render_basket_items($user_id);

			die;
		}

	}

	/**
	 * Some ajax for adding to the basket.
	 *
	 * @since    1.0.2
	 * @return @TODO
	 */
	public function add_to_basket() {
		$nonce = $_POST['nextNonce'];

		if ( ! wp_verify_nonce( $nonce, 'add-to-basket' ) ) {
		    die( 'Security check busted!' );
		} else {

			global $wpdb; // this is how you get access to the database
			// store basket meta
			$basket_table = $wpdb->prefix . 'cfpa_basket_meta';

			$timenow = date('Y-m-d H:i:s', strtotime('now'));

			$user_id = $_POST['user_id'];
			$basket_item = $_POST;
			$unsets = array('nextNonce','action','user_id');
			foreach ($unsets as $k) {
				unset($basket_item[$k]);
			}

			// sanitize tutor_teacher field if present
			if (isset($basket_item['tutor_teacher'])) {
				$basket_item['tutor_teacher'] = sanitize_text_field($basket_item['tutor_teacher']);
			}

			// check class entrants and add to items
			$number_entrants = get_post_meta($basket_item['class_id'], 'class-entrants', true);
			$basket_item['max_entrants'] = $number_entrants;

			// check if this user already has a basket, if not then create one
			$users_basket = $this->check_users_basket($user_id);

			$baskets = array();
			$baskets[] = $basket_item;

			if (isset($errors) && !empty($errors)) {
				foreach ($errors as $error) {
					echo '<li id="basket-error" class="warning alert">'.$error['error'].'</li>';
					echo '<p class="alert-info">'.$error['info'].'</p>';
				}
			} else {
				if (!empty($users_basket) && isset($users_basket)) {

					$baskets = array_merge($baskets, unserialize( $users_basket[0]['basket_items']));

					$basket_table = $wpdb->prefix . 'cfpa_basket_meta'; // children table
					$wpdb->update(
						$basket_table,
						array(
							'basket_items' => serialize($baskets),	// string
						),
						array( 'basket_id' => $users_basket[0]['basket_id'] ),
						array(
							'%s',	// value1
						)
					);

				} else {

					$wpdb->query( $wpdb->prepare(
						"
							INSERT INTO $basket_table
							( user_id, basket_items, basket_generate_date )
							VALUES ( %d, %s, %s )
						",
					        array(
							$user_id,
							serialize($baskets),
							$timenow
						)
					) );

				}
			}

			// if under add to array incomplete
			// log error


			// if users basksets add these items to the basket id
			// else create a new basket



			$this->render_basket_items($user_id);

		    die(); // this is required to terminate immediately and return a proper response
		}
	}

	/**
	 * Get users baskets.
	 *
	 * @param int $user_id user's ID.
	 * @return array $baskets of all the users basket items
	 */
	public function check_users_basket($user_id) {

		global $wpdb; // this is how you get access to the database
		$basket_table = $wpdb->prefix . 'cfpa_basket_meta'; // children table
		$sql = $wpdb->prepare( "SELECT * FROM $basket_table WHERE user_id = %d", $user_id);
		$baskets = $wpdb->get_results( $sql , ARRAY_A );

		return $baskets;
	}

	/**
	 * Get users baskets.
	 *
	 * @param int $user_id user's ID.
	 * @return array $baskets of all the users basket items
	 */
	public function get_users_basket($user_id) {

		global $wpdb; // this is how you get access to the database
		$basket_table = $wpdb->prefix . 'cfpa_basket_meta'; // children table
		$sql = $wpdb->prepare( "SELECT * FROM $basket_table WHERE user_id = %d", $user_id);
		$baskets = $wpdb->get_results( $sql , ARRAY_A );

		if (!empty($baskets)) {
			$basket_id = $baskets[0]['basket_id'];

			$return_basket = array();
			foreach ($baskets as $basket) {
				$return_basket = unserialize($basket['basket_items']);
			}

			$return_basket['basket_id'] = $basket_id;
			return $return_basket;
		}
	}

	public function entrance_check($users_basket, $baskets) {

		$users_basket = unserialize($users_basket[0]['basket_items']);



/*
		example of arrays before merge
		$users_basket = array(
			array(
				'class_id'=>'2785',
				'child_id'=>'1',
			),
			array(
				'class_id'=>'2786',
				'child_id'=>'2',
			),
			array(
				'class_id'=>'2786',
				'child_id'=>'2',
			),
			array(
				'class_id'=>'2786',
				'child_id'=>'2',
			),
			array(
				'class_id'=>'2787',
				'child_id'=>'3',
			),
			array(
				'class_id'=>'2787',
				'child_id'=>'3',
			),
			array(
				'class_id'=>'2786',
				'child_id'=>'4',
			),
		);

		$baskets = array(
			array(
				'class_id'=>'2787',
				'child_id'=>'5',
			),
		);
*/

		if ($users_basket) {
			$merged_basket = array_merge($users_basket, $baskets);
		}

		if ($merged_basket) {
			$class_ids = wp_list_pluck($merged_basket, 'class_id');
			$class_entrants = array_count_values($class_ids);
		} elseif ($baskets) {
			$class_ids = wp_list_pluck($baskets, 'class_id');
			$class_entrants = array_count_values($class_ids);
		} else {
			$class_entrants[$baskets[0]['class_id']] = (int)1;
		}

		$errors_array = array();
		$i = 0;
		foreach ($class_entrants as $k_id => $class_entrant) {
			$index = get_post_meta($k_id, 'class-entrants', true);

			if ($index == 'g') {
				continue;
			} elseif ($class_entrant %$index != 0) {
				//echo $class_entrant . ' is not divisable by ' . $index;
			    $errors_array[$i]['class_id'] = $k_id;
			    $errors_array[$i]['class_entrants'] = $index;
			}
			$i++;
		}



		return $errors_array;

	}

	/**
	 * Get group object items.
	 *
	 * @param string $group_id the childs id.
	 * @param string $type the childs object element.
	 * @return string $item the item requested in the params
	 */
	public function get_group_by_id($group_id, $type) {

		global $wpdb;

		$table_name = $wpdb->prefix . 'cfpa_groups';
		$group = $wpdb->get_results(
			"
			SELECT group_id, group_name, user_id, registered_date, last_edit
			FROM $table_name
			WHERE group_id = $group_id
			"
		);

		if ($type == 'name') {
			$item = $group[0]->group_name;
		}

		return $item;

	}

	/**
	 * Get child object items.
	 *
	 * @param string $child_id the childs id.
	 * @param string $type the childs object element.
	 * @return string $item the item requested in the params
	 */
	public function get_child_by_id($child_id, $type) {

		global $wpdb;

		$table_name = $wpdb->prefix . 'cfpa_children';
		$child = $wpdb->get_results(
			"
			SELECT child_id, child_name, user_id, registered_date, child_dob, child_exception_date, last_edit
			FROM $table_name
			WHERE child_id = $child_id
			"
		);

		if ($type == 'name') {
			$item = $child[0]->child_name;
		}

		return $item;

	}

	/**
	 * Get child object items.
	 *
	 * @param string $child_id the childs id.
	 * @param string $type the childs object element.
	 * @return string $item the item requested in the params
	 */
	public function get_the_class_cost($class_id) {

		$cost = (float) get_post_meta($class_id, 'class-fee', true);
		return $cost;

	}

	public function remove_programmes($string, $baskets) {
		if ($string == 'pgs') {
			$baskets = $this->clear_out_programmes($baskets);
		}
		return $baskets;
	}

	/**
	 * Some ajax for removing to the basket item.
	 *
	 * @since    1.0.2
	 * @return @TODO
	 */
	public function remove_from_basket() {
		$nonce = $_POST['nextNonce'];

		if ( ! wp_verify_nonce( $nonce, 'remove-from-basket' ) ) {
		    die( 'Security check busted!' );
		} else {


			global $wpdb; // this is how you get access to the database
			$basket_table = $wpdb->prefix . 'cfpa_basket_meta'; // children table

			$user_id = $_POST['user_id'];
			$baskets = $this->get_users_basket($_POST['user_id']);

			// lets check if we are removing programmes then return them without if we are
			$baskets = $this->remove_programmes($_POST['basket_item_key'], $baskets);

			$basket_id = $baskets['basket_id'];
			unset($baskets['basket_id']);
			unset($baskets[$_POST['basket_item_key']]);

			$count = count($baskets);
			//print_r($baskets);
			if ($count == 0) {
				// Default usage.
				$wpdb->delete( $basket_table, array( 'basket_id' => $basket_id ) );
				echo '<div id="cfpabasket" class="contents">';
				echo '<p>Your basket is empty!</p>';
				echo '</div>';
				die;

			} else {
				$wpdb->update(
					$basket_table,
					array(
						'basket_items' => serialize($baskets),	// string
					),
					array( 'basket_id' => $basket_id ),
					array(
						'%s',	// value1
					)
				);
			}

			$totals = $this->get_basket_totals($baskets);
			$this->calculate_totals_in_basket($totals);

			$this->render_proceed_checkout();

		    die(); // this is required to terminate immediately and return a proper response

		}
	}

	/**
	 * Get totals from invoice items.
	 *
	 * @param array $invoice_items an array of the invoice items.
	 * @return int $total the total to 2 decimals
	 */
	public function get_invoice_totals($invoice_items) {
		$costs = wp_list_pluck($invoice_items, 'cost');
		$costs = array_sum($costs)/100;

		$progs_costs = $invoice_items['progs']['program_cost']/100;

		$costs = $costs + $progs_costs;

		return number_format_i18n($costs,2);
	}

	public function calculate_totals_in_basket($totals) {
		//var_dump($totals);
		?>
			<div id="totals" class="item total">
				<?php foreach ($totals as $k => $total) { ?>
					<?php if (null == $total){ continue; } ?>
					<div class="section group">
						<div class="col span_8_of_12">
							<p class="tot"><?php if ($k == 'minus') { echo esc_html('Minimum entrants not met'); } else { echo ucfirst(esc_html($k)); } ?></p>
						</div>
						<div class="col span_4_of_12 rt">
							<p class="cost"><?php if ($k == 'minus') { echo esc_html('-'); } ?>&pound;<?php echo number_format_i18n( $total, 2 ); ?></p>
						</div>
					</div>
				<?php } ?>
			</div>

			<div class="totals-loading-data" style="display:none;">
				<i class="fa fa-cog fa-spin fa-2x fa-fw" aria-hidden="true"></i>
			</div>
		<?php
	}

	/**
	 * Show error if min. entrants aren't met.
	 *
	 * @param array $entrance_check an array of the classes short of entrants.
	 * @param array $basket current users basket.
	 * outputs and error on the item it class is short.
	 */
	public function display_entrant_error($entrance_check, $basket) {

		foreach($entrance_check as $check) {
			if (in_array($basket['class_id'], $check)) { ?>
				<div id="alert-<?php echo esc_attr($basket['class_id']); ?>" class="alert error">Requires a min. <?php echo $check['class_entrants']; ?> entrants.</div>
			<?php }
		}
	}


	/**
	 * Get basket totals.
	 *
	 * @param array $baskets an array of basket items.
	 * @param array $programmes an array of programmes if in basket items.
	 * @return string $totals the sum of costs per class fees in a single basket
	 */
	public function get_basket_totals($baskets, $programmes = null) {

		$classes_to_array = array();
		foreach ($baskets as $basket) {
			if(is_array($basket) && array_key_exists('class_id', $basket)) {
				$classes_to_array[] = $basket;
			}
		}

		$class_ids = wp_list_pluck($classes_to_array, 'class_id');

		$group_class_to_array = array();
		foreach ($baskets as $basket) {
			if(is_array($basket) && array_key_exists('group_class_id', $basket)) {
				$group_class_to_array[] = $basket;
			}
		}

		$group_class_ids = wp_list_pluck($group_class_to_array, 'group_class_id');
		$class_ids = array_merge($class_ids, $group_class_ids);
		$class_ids = array_filter($class_ids);

		$costs = array();

		if (isset($class_ids)) {
			foreach ($class_ids as $class_id) {
				$costs[] = get_post_meta($class_id, 'class-fee', true);
			}
		}

		if($programmes['total']) {
			$costs[] = $programmes['total'];
		}

 		$costs = array_sum($costs);


/*
		$entrant_counts = array_count_values($class_ids);
		$costs = array();
		foreach ($entrant_counts as $class_id => $count) {
			$index = get_post_meta($class_id, 'class-entrants', true);
			$class_fee = get_post_meta($class_id, 'class-fee', true);

			if ($index == 'g' || $index <= 1) {
				$costs[] = $class_fee * $count;
			}
			elseif ($count %$index != 0) {
				$minus[] = $class_fee * $count;
			}
			else {
				$costs[] = $class_fee;
			}
		}

		$sub_total = (array_sum($minus) + array_sum($costs));
		if ($minus) {
			$minus = array_sum($minus);
		}
		$costs = array_sum($costs);
*/

		//$totals['subtotal'] = $sub_total;
		//$totals['minus'] = $minus;
		$totals['total'] = $costs;

		return $totals;
	}

	/**
	 * Get basket totals.
	 *
	 * @param array $baskets an array of basket items.
	 * @param array $programmes an array of programmes if in basket items.
	 * @return string $totals the sum of costs per class fees in a single basket
	 */
	public function get_basket_totals_refactored($baskets) {
		foreach ($baskets as $basket) {
			$cost[] = $basket["cost"];
		}
		$costs = array_sum($cost) / 100;

		$totals['total'] = $costs;

		return $totals;
	}

	/**
	 * render xtra children if they are in the basket.
	 *
	 * @param array $xperformers an array of the additional performers.
	 * echo a span comma separated performer names.
	 */
	public function display_extra_performers($xperformers = null) {

		// die early if array is empty
		if ($xperformers == null) {
			return;
		}

		$performers = array();
		foreach ($xperformers as $id) {
			$performers[] = $this->get_child_by_id($id, 'name');
		}

		$performers = join(', ', $performers);
		echo $performers;

	}

	/**
	 * render basket to match previous logic.
	 *
	 * @param array $basket an array of the basket.
	 * @return array $basket an array to match the current logic.
	 */
	public function rendering_group_basket_item($basket) {

		if (in_array('g', $basket)) {
			$remap = array();
			foreach ($basket as $k => $v) {
				if ($k == 'group_class_id') {
					$remap['class_id'] = $v;
				}
			}

			$basket = array_merge_recursive($remap, $basket);
		}

		return $basket;
	}

	/**
	 * check if any programmes have been added to the basket.
	 *
	 * @param array $baskets an array of the basket.
	 * @return boolen $programmes true if programmes in basket.
	 */
	public function check_programmes_in_basket($baskets) {

		//var_dump($baskets);

		$programmes = false;
		foreach ($baskets as $basket) {
			if( is_array($basket) && array_key_exists('prog_quant', $basket)) {
				$programmes = true;
			}
		}
		return $programmes;
	}

	/**
	 * get total programmes in basket.
	 *
	 * @param array $baskets an array of the basket.
	 * @return int $programmes the number of programmes in the basket.
	 */
	public function get_total_programmes_in_basket($baskets) {

		unset($baskets['basket_id']);

		$progs_to_array = array();
		foreach ($baskets as $basket) {
			if(is_array($basket) && array_key_exists('prog_quant', $basket)) {
				$progs_to_array[] = $basket;
			}
		}

		if ($progs_to_array) {
			$prog_quantity = wp_list_pluck($progs_to_array, 'prog_quant');
		}

		if ($prog_quantity) {
			$prog_quantity = array_sum($prog_quantity);
			return $prog_quantity;
		}

	}

	/**
	 * clear out programmes in basket so we can render calulations just for classes.
	 *
	 * @param array $baskets an array of the basket.
	 * @return array $baskets without any programmes.
	 */
	public function clear_out_programmes($baskets) {
		foreach ($baskets as $k => $basket) {
			if(is_array($basket) && array_key_exists('prog_quant', $basket)) {
				unset($baskets[$k]);
			}
		}
		return $baskets;
	}

	public function programe_unit_cost() {
		return 5;
	}

	public function render_programmes_in_basket($total_programmes,$basket_id) {

		$programmes = array();

		$programmes['programmes'] = $total_programmes;
		$programmes['basket_id'] = $basket_id;
		$programmes['description'] = 'Festival Programmes';
		$programmes['sub_total'] = $total_programmes * $this->programe_unit_cost();
		//$programmes['pandp'] = 2;
		$programmes['total'] = ($total_programmes * $this->programe_unit_cost());
		return $programmes;
	}

	public function render_basket_items($user_id) {
		$baskets = $this->get_users_basket($user_id);

		// die early if user has an inactive basket
		if (!isset($baskets)) {
			echo '<div id="cfpabasket" class="contents">';
			echo '<p>Your basket is empty!</p>';
			echo '</div>';
			return;
		}

		if ($this->check_programmes_in_basket($baskets)) {
			$total_programmes = $this->get_total_programmes_in_basket($baskets);
			$programmes = $this->render_programmes_in_basket($total_programmes, $baskets['basket_id']);
			$baskets = $this->clear_out_programmes($baskets);
		}

		$basket_id = $baskets['basket_id'];
		unset($baskets['basket_id']);
		//$entrance_check = $this->entrance_check($users_basket, $baskets);
		?>

				<div id="cfpabasket" class="contents">

					<?php foreach($baskets as $k => $basket) { $basket = $this->rendering_group_basket_item($basket); ?>

						<div id="<?php echo esc_attr($basket['class_id']); ?>" class="item" data-user-id="<?php echo esc_attr($user_id); ?>" data-basket-id="<?php echo esc_attr($basket_id); ?>" data-basket-item-key="<?php echo esc_attr($k); ?>">

							<div class="section group">
								<div class="col span_8_of_12">
									<p><?php echo get_post_meta($basket['class_id'], 'class-ref-no', true); ?> - <?php echo get_the_title($basket['class_id']); ?></p>

									<?php  if (isset($basket['group_id'])) { ?>
										<p><?php $dothis = $this->get_group_by_id($basket['group_id'], 'name'); echo esc_html( $this->get_group_by_id($basket['group_id'], 'name') ); ?></p>
									<?php } else { ?>
										<p><?php echo esc_html( $this->get_child_by_id($basket['child_id'], 'name') ); ?><?php if (isset($basket['xchildren'])) { echo ', <span>'; $this->display_extra_performers($basket['xchildren']); echo '</span>'; } ?></p>
									<?php } ?>


								</div>
								<div class="col span_4_of_12 rt">
									<i class="fa fa-minus-square red remove-item" aria-hidden="true"></i>
								</div>
							</div>

							<div class="section group">
								<div class="col span_8_of_12">
									<p>Cost</p>
								</div>
								<div class="col span_4_of_12 rt">
									<p class="cost">&pound;<?php echo number_format_i18n( floatval($this->get_the_class_cost($basket['class_id'])), 2 ); ?></p>
								</div>
							</div>

						</div>

						<?php //$this->display_entrant_error($entrance_check, $basket); ?>


						<div class="loading-data" style="display:none;">
							<i class="fa fa-cog fa-spin fa-2x fa-fw" aria-hidden="true"></i>
						</div>

					<?php } ?>


					<?php if (!empty($programmes)) { ?>

						<div id="programmes-item" class="item" data-user-id="<?php echo esc_attr($user_id); ?>" data-basket-id="<?php echo esc_attr($programmes['basket_id']); ?>" data-basket-item-key="pgs">

							<div class="section group">
								<div class="col span_8_of_12">
									<p><?php echo esc_html($programmes['description']); ?> x <?php echo esc_html($programmes['programmes']); ?></p>

								</div>
								<div class="col span_4_of_12 rt">
									<i class="fa fa-minus-square red remove-item" aria-hidden="true"></i>
								</div>
							</div>

							<div class="section group">
								<div class="col span_8_of_12">
									<p>Programme Sub Total</p>
								</div>
								<div class="col span_4_of_12 rt">
									<p class="cost">&pound;<?php echo number_format_i18n( $programmes['sub_total'],2 ); ?></p>
								</div>
							</div>

<!--
							<div class="section group">
								<div class="col span_8_of_12">
									<p>P&P @</p>
								</div>
								<div class="col span_4_of_12 rt">
									<p class="cost">&pound;<?php echo number_format_i18n( $programmes['pandp'],2 ); ?></p>
								</div>
							</div>
-->

						</div>

						<?php //$this->display_entrant_error($entrance_check, $basket); ?>


						<div class="loading-data" style="display:none;">
							<i class="fa fa-cog fa-spin fa-2x fa-fw" aria-hidden="true"></i>
						</div>

					<?php } ?>



<!--
					<div class="item subtotal">
						<div class="section group">
							<div class="col span_8_of_12">
								<p class="sub">Sub Total</p>
							</div>
							<div class="col span_4_of_12 rt">
								<p class="cost">&pound20.00</p>
							</div>
						</div>
					</div>
-->

					<?php
						if (!empty($programmes)) {
							$totals = $this->get_basket_totals($baskets, $programmes);
						} else {
							$totals = $this->get_basket_totals($baskets);
						}
						if ($totals) {
							$this->calculate_totals_in_basket($totals);
						} ?>

					<?php $this->render_proceed_checkout(); ?>

				</div>

		<?php
	}

	public function render_proceed_checkout($entrance_check = null) {
		if (empty($entrance_check)) { ?>
			<div id="go-to-checkout" class="section group">
				<div class="col span_12_of_12">
					<a href="/cfpa-user/checkout/" class="checkout">Proceed to checkout</a>
				</div>
			</div>
		<?php }
	}

	/**
	 * Create a payment and charge via stripe.
	 *
	 * @param array $post_data an array of data from $_POST.
	 * echo a span comma separated performer names.
	 */
	public function stripe_create_charge($stripeToken, $stripeEmail, $stripe_charge ) {

		$informations = array();

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/lib/stripe-php-3.22.0/init.php';

		$stripe = ( defined('STRIPE_TEST') && STRIPE_TEST === true ) ? $this->get_stripe_test() : $this->get_stripe_live();

		\Stripe\Stripe::setApiKey($stripe['secret_key']);

		// take payment
		$token  = $stripeToken;

		if ($token) {
			$informations[] = 'Token created successfully!';
		} else {
			$informations[] = 'Unable to create Token!';
		}

		$customer = \Stripe\Customer::create(array(
		  'email' => $stripeEmail,
		  'card'  => $token
		));

		if ($customer) {
			$informations[] = 'Customer created successfully!';
		} else {
			$informations[] = 'Unable to create Customer!';
		}

		$charge = \Stripe\Charge::create(array(
		  'customer' => $customer->id,
		  'amount'   => $stripe_charge,
		  'currency' => 'gbp'
		));

		if ($charge) {
			$informations[] = 'Payment was made successfully!';
			$informations['charged'] = true;
		} else {
			$informations[] = 'There was an error, please consult the administrator and check the Stripe logs!';
		}

		return $informations;
	}

	/**
	 * Update invoice with basket items.
	 *
	 * @param int $post_id the id of the post to update.
	 * @param array $baskets the basket items.
	 *
	 * @return array $items serialised array of each item
	 *
	 */
	public function insert_basket_items($post_id, $baskets) {

		if ($this->check_programmes_in_basket($baskets)) {
			$total_programmes = $this->get_total_programmes_in_basket($baskets);
			$programmes = $this->render_programmes_in_basket($total_programmes, $baskets['basket_id']);
			$baskets = $this->clear_out_programmes($baskets);
		}

		$basket_id = $baskets['basket_id'];
		unset($baskets['basket_id']);

		$array = array(); $i = 0;


		foreach ($baskets as $basket){

			$performers = array();

			if (isset($basket['group_id'])) {
				$performers[] = $this->get_group_by_id($basket['group_id'], 'name');
			}

			if (isset($basket['child_id'])) {
				$performers[] = $this->get_child_by_id($basket['child_id'], 'name');
			}

			if (isset($basket['group_class_id'])) {
				$array[$i]['class_id'] = $basket['group_class_id'];
				$array[$i]['performers'] = $this->get_group_by_id($basket['group_id'], 'name');
				$array[$i]['cost'] = get_post_meta($basket['group_class_id'], 'class-fee', true) * 100;
			}

			if (isset($basket['class_id'])) {
				$array[$i]['class_id'] = $basket['class_id'];
				$array[$i]['performers'] = $this->get_child_by_id($basket['child_id'], 'name');
				$array[$i]['cost'] = get_post_meta($basket['class_id'], 'class-fee', true) * 100;
				if (isset($basket['tutor_teacher']) && !empty($basket['tutor_teacher'])) {
					$array[$i]['tutor_teacher'] = $basket['tutor_teacher'];
				}
			}

			if (isset($basket['xchildren'])) {
				foreach ($basket['xchildren'] as $xchild) {
					$performers[] = $this->get_child_by_id($xchild, 'name');
				}
				$array[$i]['performers'] = join(', ', $performers);
			}
			$i++;
		}

		if (isset($programmes) && !empty($programmes)) {
			update_post_meta($post_id, 'programmes_ordered', $programmes['programmes']);
			$progs = array(
				'program_quantity' => $programmes['programmes'],
				'program_description' => $programmes['description'],
				'program_cost' => $programmes['sub_total'] * 100
			);
/*
			$pandp = array(
				'pandp_quantity' => '1',
				'pandp_description' => 'Post & Packing',
				'pandp_cost' => $programmes['pandp'] * 100
			);
*/
			foreach ($progs as $k => $v) {
				add_post_meta($post_id, $k, $v);
			}
/*
			foreach ($pandp as $k => $v) {
				add_post_meta($post_id, $k, $v);
			}
*/
		}

		foreach ($array as $update_meta) {
			add_post_meta($post_id, 'inv_item', $update_meta);
		}

	}

	public function add_programmes_pandp($post_id, $invoice_items){
		$no_progs = get_post_meta( $post_id, 'program_quantity', true );
		if(empty($no_progs) || $no_progs == '') {
			return $invoice_items; // return early to stop processing
		}
		$invoice_items['progs'] = array(
			'program_quantity' => $no_progs,
			'program_description' => get_post_meta( $post_id, 'program_description', true ),
			'program_cost' => get_post_meta( $post_id, 'program_cost', true ),
		);
/*
		$invoice_items['pandp'] = array(
			'pandp_quantity' => '1',
			'pandp_description' => get_post_meta( $post_id, 'pandp_description', true ),
			'pandp_cost' => get_post_meta( $post_id, 'pandp_cost', true ),
		);
*/
		return $invoice_items;
	}

	/**
	 * Notify user via email of this invoice.
	 *
	 * @param int $post_id the invoice id.
	 *
	 */
	public function notify_users_of_invoice($post_id) {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/email-invoice.php';

	}

	/**
	 * Update purchase record.
	 *
	 * @param array $post_data an array of data from $_POST.
	 *
	 */
	public function create_invoice($user_id, $baskets, $paid = false) {

		// Initialize the page ID to -1. This indicates no action has been taken.
		$post_id = -1;

		// Setup the author, slug, and title for the post
		$author_id = $user_id;

		$user_info = get_userdata($user_id);
		$unique_id = uniqid();

		$slug = $user_info->first_name . '-' . $user_info->last_name . '-' . $user_info->ID . '-' . $unique_id;
		$title = $user_info->user_login . '-' . $unique_id;

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
					'post_type'		=>	'invoice'
				)
			);

			$this->insert_basket_items($post_id, $baskets);

			// if payment comes from stripe the $paid param is passed as true so update the meta 'inv_status' to paid
			if ($paid) {
				update_post_meta($post_id, 'inv_status', 'paid');
			} else {
				update_post_meta($post_id, 'inv_status', 'unpaid');
			}

		// Otherwise, we'll stop
		} else {

	    		// Arbitrarily use -2 to indicate that the page with the title already exists
	    		$post_id = -2;

		} // end if

		$this->notify_users_of_invoice($post_id);

		return $post_id;

	}

	/**
	 * Check payment status.
	 *
	 * @param boolean $paid true/false results is string "paid/unpaid".
	 *
	 * @return string $payment_status;
	 */
	public function check_payment_status($paid) {
		if ($paid == true) {
			$payment_status = 'paid';
		} else {
			$payment_status = 'unpaid';
		}
		return $payment_status;
	}

	/**
	 * check if invoice is paid or pay on account.
	 *
	 * @param array $post_data an array of data from $_POST.
	 *
	 * @return string $post_id
	 */
	public function set_invoice_to_paid($post_id) {
		update_post_meta($post_id, 'inv_status', 'paid');
	}

	/**
	 * check if invoice exists, if it does set it to paid if not then create an invoice as its been created as pay on account.
	 *
	 * @param array $post_data an array of data from $_POST.
	 *
	 * @return string $post_id
	 */
	public function check_if_paid_on_account($post_data, $baskets, $paid) {

		if (isset($post_data['post_id']) && $post_data['post_id'] != '') {
			$post_id = $post_data['post_id'];
			$this->set_invoice_to_paid($post_id);
		} else {
			$post_id = $this->create_invoice($post_data['user_id'], $baskets, $paid);
		}
		return $post_id;

	}

	public function consolidate_invoic_costs_for_purchase_record($post_id) {
		$invoice_items = get_post_meta($post_id, 'inv_item', false);
		$invoice_items = $this->get_invoice_totals($invoice_items);
		$invoice_cost = $invoice_items * 100;

		// $programmes = get_post_meta($post_id, 'programmes_ordered', true);
		// if ($programmes) {
		// 	$prog_costs = ($programmes * 3) + 2;
		// 	$invoice_cost = ($prog_costs * 100) + $invoice_cost;
		// }
		return $invoice_cost;
	}

	/**
	 * Update purchase record.
	 *
	 * @param array $post_data an array of data from $_POST.
	 * @param array $baskets an array of data from users current baskets.
	 * @param boolean $paid true/false to provide if paid via stripe or on account.
	 *
	 */
	public function update_purchase_record($post_data, $baskets, $paid = false) {

		global $wpdb; // this is how you get access to the database
		$table_name = $wpdb->prefix . 'cfpa_purchases';
		$purchase_generate_date = date('Y-m-d h:i:s');

		$post_id = $this->check_if_paid_on_account($post_data, $baskets, $paid);
		$payment_status = $this->check_payment_status($paid);

		/* if this is a stripe payment then it should be registered as paid
		 *
		 * @todo if a payment is taken by cheque or other method there is currently
		 * no function to register this as in the purchase table in the db
		 */

		if ($payment_status == 'unpaid') {

			$all_meta_for_user = array_map( function( $a ){ return $a[0]; }, get_user_meta( $post_data['user_id'] ) );
			$charge = $this->consolidate_invoic_costs_for_purchase_record($post_id);

			$purchase_data = array(
				'post_id' => $post_id,
				'user_id' => $post_data['user_id'],
				'purchase_cost' => $charge,
				'billing_address_line_1' => $all_meta_for_user['address_1'],
				'billing_zip' => $all_meta_for_user['postcode'],
				'billing_city' => $all_meta_for_user['town'],
				'billing_country' => 'United Kingdom',
				'billing_country_code' => 'GB',
				'payment_status' => $payment_status,
				'purchase_generate_date' => $purchase_generate_date
			);
		}

		if ($payment_status == 'paid') {

			$purchase_data = array(
				'post_id' => $post_id,
				'user_id' => $post_data['user_id'],
				'purchase_cost' => $post_data['stripe_charge'],
				'billing_address_line_1' => $post_data['stripeBillingAddressLine1'],
				'billing_zip' => $post_data['stripeBillingAddressZip'],
				'billing_city' => $post_data['stripeBillingAddressCity'],
				'billing_country' => $post_data['stripeBillingAddressCountry'],
				'billing_country_code' => $post_data['stripeBillingAddressCountryCode'],
				'payment_status' => $payment_status,
				'purchase_generate_date' => $purchase_generate_date
			);

		}

		if (isset($purchase_data) && !empty($purchase_data)) {
			$wpdb->insert(
				$table_name,
				$purchase_data,
				array(
					'%s',
					'%d',
					'%d',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s'
				)
			);
		}
	}



	/**
	 * Remove basket once paymment or an invoice has been created.
	 *
	 * @param int $basket_id an id of the basket to delete.
	 *
	 */
	public function remove_basket( $basket_id ) {
		global $wpdb; // this is how you get access to the database
		// remove basket
		$basket_table = $wpdb->prefix . 'cfpa_basket_meta'; // children table
		$wpdb->delete( $basket_table, array( 'basket_id' => $basket_id ) );
	}

	/**
	 * Process the payment.
	 *
	 * @param array $post_data an array of data from $_POST.
	 *
	 */
	public function process_cfpa_payment( $post_data ) {

		$errors = array();
		$information = array();

		$nonce = $post_data['purchase_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'purchase_cfpa' ) ) {

		    $errors[] = 'Security check busted!';

		} else {

			$baskets = $this->get_users_basket($post_data['user_id']);

			if (isset($post_data['stripe_charge']) && !empty($post_data['stripe_charge'])) {
				$informations = $this->stripe_create_charge($post_data['stripeToken'], $post_data['stripeEmail'], $post_data['stripe_charge']);

				// update purchase records
				if ($informations['charged'] == true) {
					$this->update_purchase_record($post_data, $baskets, $paid = true);
					$this->remove_basket($baskets['basket_id']);
				}

			} else {
				$this->update_purchase_record($post_data, $baskets, $paid = false);
				$this->remove_basket($baskets['basket_id']);
			}



/*
			$informations[] = 'Purchase record inserted successfully!';

			// update post numbers
			$event_clock_downs = clockdown_event_posts($baskets);

			$informations[] = 'Event numbers clocked down successfully!';

			// save post data to post
			$attendance = update_post_attendance($baskets);

			$informations[] = 'Attendance updated successfully!';

			// now send email notification to user and cc'd admin
			$baskets = sh_do_checkout(get_current_user_id());
			email_booking_notification(get_bloginfo('admin_email'), get_current_user_id(), $baskets,$coupon_code);


			$informations[] = 'Basket removed successfully!';

*/
		}


	}

	/**
	 * Profile address for invoice.
	 *
	 * @param string $post_id the post id.
	 * @return array $profile_address
	 *
	 */
	public function get_profile_invoice_address($post_id) {
		$post_object = get_post($post_id);
		$user_data = get_userdata($post_object->post_author);

		$keys = array('salutation',  'first_name', 'last_name', 'address_1','address_2','address_3','town','city','postcode');

		$profile_address = array();

		foreach ($keys as $v) {
			if ($v == 'salutation' || $v == 'first_name' || $v == 'last_name') {
				$users_name .= get_user_meta( $user_data->ID, $v, true ).' ';
				$profile_address['user'] = $users_name;
			} else {
				$profile_address[$v] = get_user_meta( $user_data->ID, $v, true );
			}

		}

		$profile_address = array_filter($profile_address);

		return $profile_address;
	}

	/**
	 * get purchase history of current user
	 *
	 * @return array $purchases
	 *
	 */
	public function cfpa_user_purchase_histroy() {

		$current_user = wp_get_current_user();
		$args = array(
			'author'         => $current_user->ID,
			'orderby'        => 'post_date',
			'order'          => 'ASC',
			'posts_per_page' => -1,
			'post_type'      => 'invoice'
		);
		$invoices = get_posts( $args );

		//
		$purchases = array();
		$i = 0;
		foreach ($invoices as $invoice) {
			$total_cost = $this->consolidate_invoic_costs_for_purchase_record($invoice->ID);
			$purchases[$i]['ID'] = $invoice->ID;
			$purchases[$i]['ref'] = $invoice->post_title;
			$purchases[$i]['date'] = $invoice->post_date;
			$purchases[$i]['cost'] = $total_cost;
			$purchases[$i]['info'] = 'info';
			$purchases[$i]['invoice'] = 'invoice link';
			$i++;
		}

		return $purchases;

	}

	/**
	 * Festival address for invoice.
	 *
	 * @return array $festival_address
	 *
	 */
	public function get_cfpa_invoice_address() {
		global $cfpa;

		$keys = array('building', 'address_1','address_2','address_3','town','city','postcode');

		$festival_address = array();
		$festival_address['name'] = get_bloginfo('name');
		foreach ($keys as $v) {
			$festival_address[$v] = $cfpa[$v];
		}

		$festival_address = array_filter($festival_address);

		return $festival_address;
	}


	public function get_stripe_test() {
		// @TODO put in database
		$stripe = array(
			"secret_key"      => 'sk_test_4NIEraxYt0ECrVNUtUJG40S6',
			"publishable_key" => 'pk_test_cK1ybMWAzj95tDOeLPHpNr5r'
		);
		return $stripe;
	}

	public function get_stripe_live() {
		// @TODO put in database
		$stripe = array(
			"secret_key"      => 'sk_live_0z0nq2mQpoA1kmpfsPNkCb9M',
			"publishable_key" => 'pk_live_08t2x2nsJE8B35h4OhOqzOni'
		);
/*
		$stripe = array(
			"secret_key"      => 'sk_test_4NIEraxYt0ECrVNUtUJG40S6',
			"publishable_key" => 'pk_test_cK1ybMWAzj95tDOeLPHpNr5r'
		);
*/
		return $stripe;
	}

	public function entries_closed() {

		$entries_closed = false;
		$options = get_option('wedevs_cfpa_advanced');
		if($options['festival_entries'] == 'disabled') {
			$entries_closed = true;
		}
		return $entries_closed;

	}

	public function entries_closed_msg() {

		$entries_closed = false;
		$options = get_option('wedevs_cfpa_advanced');
		if($options['festival_entries'] == 'disabled') {
			$entries_closed_msg = $options['festival_entries_closed_msg'];
		}
		return $entries_closed_msg;

	}

	public function delete_classes_callback() {
		$classes = array('96','98','107','112','125','126','129','134','136','178','179','180','181','182','183','184','185','186','187','188','189','190','191','192','193','194','195','196','197','198','199','2154','5209');
		foreach ($classes as $id) {
			// Delete post meta
			$post_meta_keys = get_post_custom_keys($id);
			if ($post_meta_keys) {
				foreach ($post_meta_keys as $key) {
					delete_post_meta($id, $key);
				}
			}

			// Delete the post
			wp_delete_post($id, true); // Set the second parameter to true to force delete
		}
	}

    // Method to register all shortcodes
    public function register_shortcodes() {
        add_shortcode('show_content', array($this, 'display_content_shortcode'));
    }

    // Shortcode callback function
    public function display_content_shortcode($atts, $content = null) {
        // Use the content provided between the shortcode tags
        return $content ? do_shortcode($content) : 'Default message here!';
    }

	// helper function

	public function delete_all_custom_post_type_posts_callback($post_type) {
		$posts = get_posts(array(
			'post_type' => $post_type,
			'numberposts' => -1,
			'post_status' => 'any'
		));

		foreach ($posts as $post) {
			wp_delete_post($post->ID, true); // true = force delete (bypasses trash)
		}
	}

	/**
	 * AJAX handler to update marketing permission user meta.
	 *
	 * @since    1.0.2
	 */
	public function update_marketing_permission() {
		// Verify nonce
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'update-marketing-permission' ) ) {
			wp_send_json_error( array( 'message' => 'Security check failed.' ) );
			return;
		}

		// Check if user is logged in
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'User must be logged in.' ) );
			return;
		}

		$user_id = get_current_user_id();
		$permission_value = isset( $_POST['permission'] ) ? sanitize_text_field( wp_unslash( $_POST['permission'] ) ) : 'false';
		$permission = ( $permission_value === 'true' ) ? '1' : '0';

		// Update user meta
		$updated = update_user_meta( $user_id, 'marketing_permission', $permission );

		if ( $updated !== false ) {
			wp_send_json_success( array(
				'message' => 'Marketing permission updated successfully.',
				'permission' => $permission
			) );
		} else {
			wp_send_json_error( array( 'message' => 'Failed to update marketing permission.' ) );
		}
	}


}
