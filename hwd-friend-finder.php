<?php
/*
Plugin Name: HWD Friend Finder
Description: Adds custom post type and fun stuff for Fibit tools on a WordPress site.
Plugin URI: http://healthywebdeveloper.com
Author: Bradford Knowlton
Author URI: http://bradknowlton.com
Version: 1.0.2
License: GPL2
Text Domain: hwd
Domain Path: /languages

GitHub Plugin URI: https://github.com/HealthyWebDeveloper/HWD-friend-finder

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
    		'name'                => __( 'Plural Name', 'text-domain' ),
    		'singular_name'       => __( 'Singular Name', 'text-domain' ),
    		'add_new'             => _x( 'Add New Singular Name', 'text-domain', 'text-domain' ),
    		'add_new_item'        => __( 'Add New Singular Name', 'text-domain' ),
    		'edit_item'           => __( 'Edit Singular Name', 'text-domain' ),
    		'new_item'            => __( 'New Singular Name', 'text-domain' ),
    		'view_item'           => __( 'View Singular Name', 'text-domain' ),
    		'search_items'        => __( 'Search Plural Name', 'text-domain' ),
    		'not_found'           => __( 'No Plural Name found', 'text-domain' ),
    		'not_found_in_trash'  => __( 'No Plural Name found in Trash', 'text-domain' ),
    		'parent_item_colon'   => __( 'Parent Singular Name:', 'text-domain' ),
    		'menu_name'           => __( 'Plural Name', 'text-domain' ),
    	);
    
    	$args = array(
    		'labels'                   => $labels,
    		'hierarchical'        => false,
    		'description'         => 'description',
    		'taxonomies'          => array(),
    		'public'              => true,
    		'show_ui'             => true,
    		'show_in_menu'        => true,
    		'show_in_admin_bar'   => true,
    		'menu_position'       => null,
    		'menu_icon'           => null,
    		'show_in_nav_menus'   => true,
    		'publicly_queryable'  => true,
    		'exclude_from_search' => false,
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
    
    	register_post_type( 'slug', $args );
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