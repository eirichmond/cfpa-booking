<?php

/**
 * Registers the `school` post type.
 */
function school_init() {
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
		'supports'              => array( 'title', 'editor' ),
		'has_archive'           => true,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_position'         => null,
		'menu_icon'             => 'dashicons-welcome-learn-more',
		'show_in_rest'          => true,
		'rest_base'             => 'school',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'school_init' );

/**
 * Sets the post updated messages for the `school` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `school` post type.
 */
function school_updated_messages( $messages ) {
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
add_filter( 'post_updated_messages', 'school_updated_messages' );
