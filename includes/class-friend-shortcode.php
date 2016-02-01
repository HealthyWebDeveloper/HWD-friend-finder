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
				                    // array(
				                    //     'key' => 'active',
				                    //     'value' => '1',
				                    // ),
					        	)
	    ) );  

	    if (have_posts()):

		     while (have_posts()) : the_post();

		 		$displayName = get_post_meta( get_the_id(), 'displayName', true );
		 		$avatar = get_post_meta( get_the_id(), 'avatar150', true );

		 		$return .= sprintf('<div class="col-lg-3 col-sm-3 focus-box">
		 								<div class="service-icon">
		 									<i style="background:url(%s) no-repeat center;width:100%%; height:100%%;" class="pixeden"></i>
		 								</div>
		 								<h3 class="red-border-bottom">%s</h3>
		 								<a class="btn btn-primary btn-block green-btn btn-sm" href="https://www.fitbit.com/user/%s"><i class="fa fa-plus"></i> Add Friend</a>
		 								<br/>
		 							</div>', $avatar, $displayName, get_the_title(), get_the_content() );

		     endwhile;

		$return = '<div class="hwd-wrapper"><div class="row">'.$return.'</div></div>';
	     
	     else:

	     	$return = 'No Friends Found';

	     endif;
	     wp_reset_query();

		return $return;
	}
}

add_shortcode( 'friend_list', array( 'Friend_Shortcode', 'friend_list_func' ) );