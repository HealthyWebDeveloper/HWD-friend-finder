<?php
/*
Plugin Name: HWD Friend Finder
Description: Adds custom post type and fun stuff for Fibit tools on a WordPress site.
Plugin URI: http://healthywebdeveloper.com
Author: Bradford Knowlton
Author URI: http://bradknowlton.com
Version: 1.1.0
License: GPL2
Text Domain: hwd
Domain Path: /languages

GitHub Plugin URI: https://github.com/HealthyWebDeveloper/HWD-friend-finder
GitHub Branch: master

Requires PHP: 5.3.0
Requires WP: 4.4
*/

/*

    Copyright (C) 2016  Bradford Knowlton brad@healthywebdeveloper.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Help with setting up gulp
// https://travismaynard.com/writing/getting-started-with-gulp

define( 'HWD_PLUGIN_VERSION', '1.0.8' );  

// possible future global
// define( 'PLUGIN_DIR', dirname(__FILE__).'/' );  

/** Requiring required class files */

require_once( plugin_dir_path( __FILE__ ) . 'includes/class-fitbit-api.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-friend-shortcode.php');


/**
 * Enqueue scripts
 *
 * @param string $handle Script name
 * @param string $src Script url
 * @param array $deps (optional) Array of script names on which this script depends
 * @param string|bool $ver (optional) Script version (used for cache busting), set to null to disable
 * @param bool $in_footer (optional) Whether to enqueue the script before </head> or before </body>
 */
function hwd_enqueue_scripts() {
	wp_enqueue_script( 'hwd-scripts', plugins_url( '/assets/js/hwd-scripts.min.js' , __FILE__ ), array( 'jquery' ), HWD_PLUGIN_VERSION, false);
	wp_enqueue_style( 'hwd-styles', plugins_url( '/assets/css/hwd-styles.min.css' , __FILE__ ), $deps, HWD_PLUGIN_VERSION );
}

add_action( 'wp_enqueue_scripts', 'hwd_enqueue_scripts' );


/**
* Registers a new post type
* @uses $wp_post_types Inserts new post type object into the list
*
* @param string  Post type key, must not exceed 20 characters
* @param array|string  See optional args description above.
* @return object|WP_Error the registered post type object, or an error object
*/
function hwd_register_name() {

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
		'public'              => true,
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

add_action( 'init', 'hwd_register_name' );

function hwd_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry, 
    // when you add a post of this CPT.
    hwd_register_name();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'hwd_rewrite_flush' );