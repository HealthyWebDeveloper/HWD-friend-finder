<?php
/*
Plugin Name: HWD Friend Finder
Description: Adds custom post type and fun stuff for Fibit tools on a WordPress site.
Plugin URI: http://healthywebdeveloper.com
Author: Bradford Knowlton
Author URI: http://bradknowlton.com
Version: 1.4.1
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

define( 'HWD_PLUGIN_VERSION', '1.4.1' );  

// possible future global
// define( 'PLUGIN_DIR', dirname(__FILE__).'/' );  

/** Requiring required class files */

require_once( plugin_dir_path( __FILE__ ) . 'includes/class-fitbit-api.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-friend-shortcode.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-friend-post-type.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-friend-settings.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-friend-ajax.php');

$consumer_key = get_site_option( 'hwd_consumer_key', false );
$consumer_secret = get_site_option( 'hwd_consumer_secret', false );
$fitbit_token = get_site_option( 'hwd_fitbit_token', false );
$fitbit_secret = get_site_option( 'hwd_fitbit_secret', false );

define( 'HWD_CONSUMER_KEY', $consumer_key );
define( 'HWD_CONSUMER_SECRET', $consumer_secret );
define( 'HWD_FITBIT_TOKEN', $fitbit_token );
define( 'HWD_FITBIT_SECRET', $fitbit_secret );

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
add_action( 'admin_enqueue_scripts', 'hwd_enqueue_scripts' );

function hwd_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry, 
    // when you add a post of this CPT.
    Friend_Post_Type::register_custom_post_type();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'hwd_rewrite_flush' );