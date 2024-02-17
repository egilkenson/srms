<?php
/**
 * SRMS functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package srms
 */

if (!function_exists('srms_setup')) :

    function srms_setup()
    {
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');
        /**
         * Add default posts and comments RSS feed links to head
         */
        add_theme_support('automatic-feed-links');

        /**
         * Enable support for Post Thumbnails
         */

        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(825, 510, true);

        /**
         * Add cropped image size for Home Tiles
         */
        add_image_size('home-tile', '400', '600', 'true');
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ));

        /** This theme uses wp_nav_menu() in one location. */

        register_nav_menus(array(
            'primary' => __('Primary Menu', 'ao_starter'),
        ));

    }

endif; // srms_setup

add_action('after_setup_theme', 'srms_setup');

// Setup Widget Area

function srms_setup_sidebars()
{
    $args = array(
        'name' => __('Sidebar Widgets', 'srms'),
        'id' => 'footer-widget-area',
        'before_widget' => '<section class="widget">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>'
    );
    register_sidebar($args);
}

add_action('widgets_init', 'srms_setup_sidebars');

/**
 * Enqueue scripts and styles
 */

function srms_scripts_and_styles()
{
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery',
            ("//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), false);
        wp_enqueue_script('jquery');
    }

    wp_enqueue_style('style', get_stylesheet_uri(), '', '1.4.2');
    wp_register_script('main', get_template_directory_uri() . '/js/main.js', [], '1.4.2', true);
    wp_enqueue_script('main');;
}

add_action('wp_enqueue_scripts', 'srms_scripts_and_styles');

/*
 *  Clean up dashboard options to remove unnecessary items
 *  NOTE: Users with appropriate permissions will still be able to access these
 *  features be entering a URL. They are only hidden from the dashboard sidebar.
 */

function srms_custom_menu_page_items() {
    // remove_menu_page( 'index.php' );                     //Dashboard
    remove_menu_page( 'jetpack' );                       //Jetpack
    // remove_menu_page( 'edit.php' );                      //Posts
    remove_menu_page( 'upload.php' );                    //Media
    // remove_menu_page( 'edit.php?post_type=page' );       //Pages
    remove_menu_page( 'edit-comments.php' );             //Comments
    // remove_menu_page( 'themes.php' );                    //Appearance
    // remove_menu_page( 'plugins.php' );                   //Plugins
    // remove_menu_page( 'users.php' );                     //Users
    remove_menu_page( 'tools.php' );                     //Tools
    // remove_menu_page( 'options-general.php' );           //Settings
}
add_action( 'admin_menu', 'srms_custom_menu_page_items' );

add_filter(
	'wpcf7_stripe_payment_intent_parameters',

	function ( $params ) {
		// Get the WPCF7_Submission object
		$submission = WPCF7_Submission::get_instance();

		$tuition = (array) $submission->get_posted_data( 'tuition-amount' );
		$tuition = (float) array_shift( $tuition );

		// Calculate the amount
		$amount = 100 * $tuition;
		$params['amount'] = $amount;

		// Retrieve the buyer's email from the 'your-email' field value
		$receipt_email = $submission->get_posted_data( 'your-email' );

		if ( is_email( $receipt_email ) ) {
			$params['receipt_email'] = $receipt_email;
		}

		return $params;
	},

	10, 1
);

/**
 * Include additional custom functions
 */

require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/custom-post-types.php';
require get_template_directory() . '/inc/srms_customizer.php';
