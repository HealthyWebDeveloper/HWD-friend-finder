<?php
/**
 * Friend Custom Post Type Class
 *
 * @since 1.1.2
 *
 * @package hwd-friend-finder
 */

class Friend_Post_Type {

	/**
	* Registers a new post type
	* @uses $wp_post_types Inserts new post type object into the list
	*
	* @param string  Post type key, must not exceed 20 characters
	* @param array|string  See optional args description above.
	* @return object|WP_Error the registered post type object, or an error object
	*/
	public static function register_custom_post_type() {

		$labels = array(
			'name'                => __( 'Friends', 'hwd' ),
			'singular_name'       => __( 'Friend', 'hwd' ),
			'add_new'             => _x( 'Add New Friend', 'hwd' ),
			'add_new_item'        => __( 'Add New Friend', 'hwd' ),
			'edit_item'           => __( 'Edit Friend', 'hwd' ),
			'new_item'            => __( 'New Friend', 'hwd' ),
			'view_item'           => __( 'View Friend', 'hwd' ),
			'search_items'        => __( 'Search Friends', 'hwd' ),
			'not_found'           => __( 'No Friends found', 'hwd' ),
			'not_found_in_trash'  => __( 'No Friends found in Trash', 'hwd' ),
			'parent_item_colon'   => __( 'Parent Friend:', 'hwd' ),
			'menu_name'           => __( 'Friends', 'hwd' ),
		);

		$args = array(
			'labels'                   => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array(),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => false,
			'menu_position'       => 6,
			'menu_icon'           => plugins_url( '/assets/images/fitbit-logo-16x16.png', __FILE__ ),
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'supports'            => array(
				'title', 'editor', 'author', 'thumbnail',
				'excerpt','custom-fields', 'trackbacks', 'comments',
				'revisions', 'page-attributes', 'post-formats'
				)
		);

		register_post_type( 'friend', $args );
	}
}

add_shortcode( 'init', array( 'Friend_Post_Type', 'register_custom_post_type' ) );