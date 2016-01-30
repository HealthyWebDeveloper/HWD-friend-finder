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
			'per_page' => '100',			
		), $atts, 'friend_list' );

		$return = "";

	    query_posts(array( 
	        'post_type' => 'friend',
	        'showposts' => $atts['per_page'] 
	    ) );  

	    if (have_posts()):

		     while (have_posts()) : the_post();

		 		$displayName = get_post_meta( get_the_id(), 'displayName', true );
		 		$avatar = get_post_meta( get_the_id(), 'avatar150', true );

		        $return .=  sprintf('<div class="small-12 medium-4 columns"><p><h2>%s</h2><img src="%s" />%s</p></div>', $displayName, $avatar, get_the_content() );
		     endwhile;
	     
	     else:

	     	$return = 'No Friends Found';

	     endif;
	     wp_reset_query();

		return $return;
	}
}

add_shortcode( 'friend_list', array( 'Friend_Shortcode', 'friend_list_func' ) );