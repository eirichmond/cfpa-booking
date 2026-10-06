<?php

    /**
     * ReduxFramework Barebones Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "cfpa";
    
	$args = array(
		'post_type' => 'page',
		'posts_per_page' =>	-1,
		'order' => 'ASC',
		'orderby' => 'menu_order',
		'post_status' => 'publish',
	);
	$pages = get_posts($args);
	$featured_pages = array();
	foreach ($pages as $page) {
		$featured_pages[$page->ID] = $page->post_title;
	}
	
	
    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'CFPA Options', 'cfpa-options' ),
        'page_title'           => __( 'CFPA Options', 'cfpa-options' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '_options',
        // Page slug used to denote the panel
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        //'compiler'             => true,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
/*
    $args['admin_bar_links'][] = array(
        'id'    => 'redux-docs',
        'href'  => 'http://docs.reduxframework.com/',
        'title' => __( 'Documentation', 'cfpa-options' ),
    );

    $args['admin_bar_links'][] = array(
        //'id'    => 'redux-support',
        'href'  => 'https://github.com/ReduxFramework/redux-framework/issues',
        'title' => __( 'Support', 'cfpa-options' ),
    );

    $args['admin_bar_links'][] = array(
        'id'    => 'redux-extensions',
        'href'  => 'reduxframework.com/extensions',
        'title' => __( 'Extensions', 'cfpa-options' ),
    );

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
        'title' => 'Visit us on GitHub',
        'icon'  => 'el el-github'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://twitter.com/reduxframework',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://www.linkedin.com/company/redux-framework',
        'title' => 'Find us on LinkedIn',
        'icon'  => 'el el-linkedin'
    );
*/

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'cfpa-options' ), $v );
    } else {
        $args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'cfpa-options' );
    }

    // Add content after the form.
    $args['footer_text'] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'cfpa-options' );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'cfpa-options' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'cfpa-options' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'cfpa-options' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'cfpa-options' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'cfpa-options' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START Basic Fields
/*
    Redux::setSection( $opt_name, array(
        'title'  => __( 'Basic Field', 'cfpa-options' ),
        'id'     => 'basic',
        'desc'   => __( 'Basic field with no subsections.', 'cfpa-options' ),
        'icon'   => 'el el-home',
        'fields' => array(
            array(
                'id'       => 'opt-text',
                'type'     => 'text',
                'title'    => __( 'Example Text', 'cfpa-options' ),
                'desc'     => __( 'Example description.', 'cfpa-options' ),
                'subtitle' => __( 'Example subtitle.', 'cfpa-options' ),
                'hint'     => array(
                    'content' => 'This is a <b>hint</b> tool-tip for the text field.<br/><br/>Add any HTML based text you like here.',
                )
            )
        )
    ) );
*/
	

    Redux::setSection( $opt_name, array(
        'title' => __( 'Home Page', 'cfpa-options' ),
        'id'    => 'homepage',
        'desc'  => __( 'Basic fields as subsections.', 'cfpa-options' ),
        'icon'  => 'el el-home'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Featured Sections', 'redux-framework-demo' ),
        'id'         => 'featured-sortable',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'featured-pages',
                'type'     => 'sortable',
                'mode'     => 'checkbox', // checkbox or text
                'title'    => __( 'Featured Sections', 'redux-framework-demo' ),
                'subtitle' => __( 'Define and reorder these however you want.', 'redux-framework-demo' ),
                'desc'     => __( 'What is checked here will appear on the homepage.', 'redux-framework-demo' ),
                'options'  => $featured_pages,
            ),
        )
    ) );


    Redux::setSection( $opt_name, array(
        'title'            => __( 'Festival Address', 'redux-framework-demo' ),
        'desc'             => __( 'Input the festival address details here for use through-out the site.', 'cfpa-options' ),
        'id'               => 'festival-address',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'          => 'building',
                'type'        => 'text',
                'title'       => __( 'House or building', 'redux-framework-demo' ),
                'subtitle'    => __( 'House or building', 'redux-framework-demo' ),
                'desc'        => __( 'House or building', 'redux-framework-demo' ),
                'placeholder' => 'House or building',
            ),
            array(
                'id'          => 'address_1',
                'type'        => 'text',
                'title'       => __( 'Address 1', 'redux-framework-demo' ),
                'subtitle'    => __( 'Address 1', 'redux-framework-demo' ),
                'desc'        => __( 'Address 1', 'redux-framework-demo' ),
                'placeholder' => 'Address 1',
            ),
            array(
                'id'          => 'address_2',
                'type'        => 'text',
                'title'       => __( 'Address 2', 'redux-framework-demo' ),
                'subtitle'    => __( 'Address 2', 'redux-framework-demo' ),
                'desc'        => __( 'Address 2', 'redux-framework-demo' ),
                'placeholder' => 'Address 2',
            ),
            array(
                'id'          => 'address_3',
                'type'        => 'text',
                'title'       => __( 'Address 3', 'redux-framework-demo' ),
                'subtitle'    => __( 'Address 3', 'redux-framework-demo' ),
                'desc'        => __( 'Address 3', 'redux-framework-demo' ),
                'placeholder' => 'Address 3',
            ),
             array(
                'id'          => 'town',
                'type'        => 'text',
                'title'       => __( 'Town', 'redux-framework-demo' ),
                'subtitle'    => __( 'Town', 'redux-framework-demo' ),
                'desc'        => __( 'Town', 'redux-framework-demo' ),
                'placeholder' => 'Town',
            ),
             array(
                'id'          => 'city',
                'type'        => 'text',
                'title'       => __( 'City', 'redux-framework-demo' ),
                'subtitle'    => __( 'City', 'redux-framework-demo' ),
                'desc'        => __( 'City', 'redux-framework-demo' ),
                'placeholder' => 'City',
            ),
             array(
                'id'          => 'postcode',
                'type'        => 'text',
                'title'       => __( 'Post Code', 'redux-framework-demo' ),
                'subtitle'    => __( 'Post Code', 'redux-framework-demo' ),
                'desc'        => __( 'Post Code', 'redux-framework-demo' ),
                'placeholder' => 'Post Code',
            ),
       )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Checkout Consent', 'redux-framework-demo' ),
        'id'         => 'checkout-consent',
        'desc'       => __( 'The text for the checkbox to confirm consent in the checkout process.', 'redux-framework-demo' ),
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'consent-text',
                'type'     => 'textarea',
                'title'    => __( 'Consent text', 'redux-framework-demo' ),
            )
        )
    ) );


    Redux::setSection( $opt_name, array(
        'title' => __( 'Performer Settings', 'cfpa-options' ),
        'id'    => 'performer-settings',
        'desc'  => __( 'Performer Settings.', 'cfpa-options' ),
        'icon'  => 'el el-user'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Age 16 @', 'cfpa-options' ),
        'id'         => 'age-at',
        'desc'       => __( 'Set the pivot date for checking age 16 at.', 'cfpa-options' ),
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'age-at-date',
                'type'     => 'date',
                'title'    => __( 'Age 16 at...', 'cfpa-options' ),
            )
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Child Licencing', 'cfpa-options' ),
        'id'         => 'child-licencing',
        'desc'       => __( 'The text for child licencing.', 'cfpa-options' ),
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'child-licencing-text',
                'type'     => 'editor',
                'title'    => __( 'Child Licencing Text', 'cfpa-options' ),
            ),
            array(
                'id'       => 'child-licencing-tick-description',
                'type'     => 'text',
                'title'    => __( 'Child Licencing Checkbox Label', 'cfpa-options' ),
                'desc'     => __( 'Appears as the description for the checkbox.', 'cfpa-options' ),
            )
        )
    ) );


    Redux::setSection( $opt_name, array(
        'title'      => __( 'Headmaster Approval', 'cfpa-options' ),
        'id'         => 'headmaster-approval',
        'desc'       => __( 'The text for Headmaster Approval.', 'cfpa-options' ),
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'headmaster-approval-text',
                'type'     => 'editor',
                'title'    => __( 'Headmaster Approval Text', 'cfpa-options' ),
            ),
            array(
                'id'       => 'headmaster-approval-tick-description',
                'type'     => 'text',
                'title'    => __( 'Headmaster Approval Checkbox Label', 'cfpa-options' ),
                'desc'     => __( 'Appears as the description for the checkbox.', 'cfpa-options' ),
            )

        )
    ) );




    /*
     * <--- END SECTIONS
     */
