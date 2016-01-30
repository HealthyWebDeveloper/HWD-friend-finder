<?php
/*
Plugin Name: HWD Friend Finder
Description: Adds custom post type and fun stuff for Fibit tools on a WordPress site.
Plugin URI: http://healthywebdeveloper.com
Author: Bradford Knowlton
Author URI: http://bradknowlton.com
Version: 1.0.4
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
    		'menu_name'           => __( 'Plural Name', 'hwd' ),
    	);
    
    	$args = array(
    		'labels'                   => $labels,
    		'hierarchical'        => false,
    		'description'         => 'description',
    		'taxonomies'          => array(),
    		'public'              => true,
    		'show_ui'             => true,
    		'show_in_menu'        => false,
    		'show_in_admin_bar'   => false,
    		'menu_position'       => null,
    		'menu_icon'           => 'dashicons-groups',
    		'show_in_nav_menus'   => true,
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