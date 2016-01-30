<?php

/**
 * Shortcode Class Header
 *
 *
 * @since 1.0.6
 *
 * @package hwd-friend-finder
 */


class Friend_Shortcode {

	public static function friend_list_func( $atts, $content = "" ) {
		$atts = shortcode_atts( array(
			'per_page' => '10',			
		), $atts, 'friend_list' );

		return "content = $content";
	}
}

add_shortcode( 'friend_list', array( 'Friend_Shortcode', 'friend_list_func' ) );