<?php
/**
 * Custom post types, taxonomies and fields
 *
 * @package srms
 */

/**
 * =================================================================
 * Order Field
 * =================================================================
 * Add an 'order' field to posts to allow for custom sorting
 */

/**
 * Add the reorder Meta Box
 */ 
function srms_add_order_meta_box()
{
    $screens = array('post', 'tile');

    foreach ($screens as $screen) {

        add_meta_box(
            'srms-post-order',
            __('Post Display Order', 'srms'),
            'srms_order_meta_box_callback',
            $screen, 'side', 'core'
        );
    }
}

add_action('add_meta_boxes', 'srms_add_order_meta_box');

/**
 * Prints the box content.
 *
 * @param object $post WP_Post object for the current post/page.
 */
function srms_order_meta_box_callback($post)
{
    // Add an nonce field so we can check for it later.
    wp_nonce_field('srms_order_meta_box', 'srms_order_meta_box_nonce');

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $value = get_post_meta($post->ID, 'order', true);

    if (!$value) {
        $value = 10;
    }

    echo '<label for="srms_order">';
    _e('Enter a Number > 0', 'srms');
    echo '</label> ';
    echo '<input type="number" id="srms_order" name="srms_order" value="' . esc_attr($value) . '" />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function srms_save_order_meta_box_data($post_id)
{
    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if (!isset($_POST['srms_order_meta_box_nonce'])) {
        return;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['srms_order_meta_box_nonce'], 'srms_order_meta_box')) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {

        if (!current_user_can('edit_page', $post_id)) {
            return;
        }

    } else {

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if (!isset($_POST['srms_order'])) {
        return;
    }

    // Sanitize user input.
    $input = sanitize_text_field($_POST['srms_order']);

    // Update the meta field in the database.
    update_post_meta($post_id, 'order', $input);
}
add_action('save_post', 'srms_save_order_meta_box_data');

/**
 * Display 'Order' in Columns
 */
add_filter('manage_posts_columns', 'srms_order_column');
function srms_order_column($columns)
{
    $columns['order'] = 'Order';
    return $columns;
}

add_action('manage_posts_custom_column', 'srms_show_columns');
function srms_show_columns($name)
{
    global $post;
    switch ($name) {
        case 'order':
            $order = get_post_meta($post->ID, 'order', true);
            echo $order;
    }
}

add_action('quick_edit_custom_box',  'srms_add_quick_edit', 10, 2);
function srms_add_quick_edit($column_name, $post_id) {
	if ($column_name != 'order') return;
	?>
	<fieldset class="inline-edit-col-left">
		<div class="inline-edit-col">
			<span class="title">Display Order</span>
			<?php $value = get_post_meta($post_id, 'order', true);

			if (!$value) {
			$value = 10;
			}

			echo '<label for="srms_order">';
				_e('Enter a Number > 0', 'srms');
				echo ' ID: '. $post_id .'</label> ';
			echo '<input type="number" id="srms_order" name="srms_order" value="' . esc_attr($value) . '" />';
			?>
		</div>
	</fieldset>
	<?php
}

/**
 * =================================================================
 * Home Page Tiles
 * =================================================================
 * Custom post type and related fields for front page tiles
 */

/**
 * Register Home Page Tile post type
 */
function tile_post_type()
{
    $labels = array(
        'name' => _x('Home Tiles', 'Post Type General Name', 'srms'),
        'singular_name' => _x('Home Tiles', 'Post Type Singular Name', 'srms'),
        'menu_name' => __('Home Tiles', 'srms'),
        'name_admin_bar' => __('Home Tiles', 'srms'),
        'archives' => __('Tile Archives', 'srms'),
        'parent_item_colon' => __('Parent Item:', 'srms'),
        'all_items' => __('All Tiles', 'srms'),
        'add_new_item' => __('Add New Tile', 'srms'),
        'add_new' => __('Add New', 'srms'),
        'new_item' => __('New Tile', 'srms'),
        'edit_item' => __('Edit Tile', 'srms'),
        'update_item' => __('Update Tile', 'srms'),
        'view_item' => __('View Tile', 'srms'),
        'search_items' => __('Search Tiles', 'srms'),
        'not_found' => __('Not found', 'srms'),
        'not_found_in_trash' => __('Not found in Trash', 'srms'),
        'featured_image' => __('Featured Image', 'srms'),
        'set_featured_image' => __('Set Tile Image', 'srms'),
        'remove_featured_image' => __('Remove Tile image', 'srms'),
        'use_featured_image' => __('Use as Tile image', 'srms'),
        'uploaded_to_this_item' => __('Uploaded to this Tile', 'srms'),
        'items_list' => __('Tile list', 'srms'),
        'items_list_navigation' => __('Tile list navigation', 'srms'),
        'filter_items_list' => __('Filter Tile list', 'srms'),
    );
    $args = array(
        'label' => __('Home Tile', 'srms'),
        'description' => __('Home Page Tiles', 'srms'),
        'labels' => $labels,
        'menu_icon' => 'dashicons-admin-home',
        'supports' => array('title', 'editor', 'thumbnail',),
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => false,
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'capability_type' => 'post',
    );
    register_post_type('tile', $args);

}

add_action('init', 'tile_post_type', 0);

/**
 * Add the tile link Meta Box
 */
function srms_add_tile_link()
{
    $screens = array('tile');

    foreach ($screens as $screen) {

        add_meta_box(
            'srms-tile-link',
            __('Link to page', 'srms'),
            'srms_tile_link_meta_box_callback',
            $screen, 'side', 'core'
        );
    }
}

add_action('add_meta_boxes', 'srms_add_tile_link');

/**
 * Prints the box content.
 *
 * @param object $post WP_Post object for the current post/page.
 */
function srms_tile_link_meta_box_callback($post)
{

    // Add an nonce field so we can check for it later.
    wp_nonce_field('srms_tile_link_meta_box', 'srms_tile_link_meta_box_nonce');

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $link = get_post_meta($post->ID, 'tilelink', true);

    if (!$link) {
        $link = '';
    }

    $pages = get_pages();

    echo '<label for="srms_link">';
    _e('Choose a page to link to:', 'srms');
    echo '</label> ';

    echo '<select name="srms_link">';

    foreach ($pages as $page) {
        $selected = '';
        if ($link == $page->ID) {
           $selected = ' selected';
        }
        $option = '<option value="' . $page->ID . '"' . $selected . '>';
        $option .= $page->post_title;
        $option .= '</option>';
        echo $option;
    }
    echo '</select>';
    echo '<p>Current URL: ' . get_page_link( $link ) . '</p>';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function srms_save_tile_link_meta_box_data($post_id)
{
    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if (!isset($_POST['srms_tile_link_meta_box_nonce'])) {
        return;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['srms_tile_link_meta_box_nonce'], 'srms_tile_link_meta_box')) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'tile' == $_POST['post_type']) {

        if (!current_user_can('edit_page', $post_id)) {
            return;
        }

    } else {

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if (!isset($_POST['srms_link'])) {
        return;
    }

    // Sanitize user input.
    $input = sanitize_text_field($_POST['srms_link']);

    // Update the meta field in the database.
    update_post_meta($post_id, 'tilelink', $input);
}

add_action('save_post', 'srms_save_tile_link_meta_box_data');

/**
 * =================================================================
 * Category Selection for Pages
 * =================================================================
 */

function srms_category_meta_box()
{
    $screens = array('page');

    foreach ($screens as $screen) {

	    global $post;

	    if(!empty($post))
	    {
		    $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

		    //Only show on Page of Posts pages
		    if($pageTemplate == 'page-templates/pageofposts.php' ) {

			    add_meta_box(
				    'srms-page-category',
				    __( 'Page Posts Category', 'srms' ),
				    'srms_category_meta_box_callback',
				    $screen, 'normal', 'core'
			    );
		    }
	    }
    }
}

add_action('add_meta_boxes', 'srms_category_meta_box');

/**
 * Prints the box content.
 *
 * @param object $post WP_Post object for the current post/page.
 */
function srms_category_meta_box_callback($post)
{
    // Add an nonce field so we can check for it later.
    wp_nonce_field('srms_category_meta_box', 'srms_category_meta_box_nonce');

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $current_cat = get_post_meta($post->ID, '_category', true);

    echo '<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="srms_category">';
    _e('Choose a category to display', 'srms');
    echo '</label></p>';
    wp_dropdown_categories( 'name=srms_category&selected=' . $current_cat );
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function srms_save_category_meta_box_data($post_id)
{
    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if (!isset($_POST['srms_category_meta_box_nonce'])) {
        return;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['srms_category_meta_box_nonce'], 'srms_category_meta_box')) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {

        if (!current_user_can('edit_page', $post_id)) {
            return;
        }

    } else {

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if (!isset($_POST['srms_category'])) {
        return;
    }

    // Sanitize user input.
    $input = sanitize_text_field($_POST['srms_category']);

    // Update the meta field in the database.
    update_post_meta($post_id, '_category', $input);
}

add_action('save_post', 'srms_save_category_meta_box_data');