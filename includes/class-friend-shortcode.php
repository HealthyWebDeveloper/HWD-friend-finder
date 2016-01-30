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
	        'showposts' => $atts['per_page'],
	        'meta_query' => array(
	        						'relation' => 'AND',
					        		array(
				                        'key' => 'avatar150',
				                        'value' => 'https://static0.fitbit.com/images/profile/defaultProfile_100_male.gif',
				                        'compare' => 'NOT LIKE',
				                    ),
				                    array(
				                        'key' => 'avatar150',
				                        'value' => 'https://static0.fitbit.com/images/profile/defaultProfile_100_female.gif',
				                        'compare' => 'NOT LIKE',
				                    ),
					        	)
	    ) );  

	    if (have_posts()):

		     while (have_posts()) : the_post();

		 		$displayName = get_post_meta( get_the_id(), 'displayName', true );
		 		$avatar = get_post_meta( get_the_id(), 'avatar150', true );

		        $return .=  sprintf('<div class="hwd-profile-list-item small-12 medium-4 columns"><img src="%s" /><h2>%s</h2><p class="hide">%s</p></div>', $displayName, $avatar, get_the_content() );
		     endwhile;
	     
	     else:

	     	$return = 'No Friends Found';

	     endif;
	     wp_reset_query();

		return $return;
	}
}

add_shortcode( 'friend_list', array( 'Friend_Shortcode', 'friend_list_func' ) );