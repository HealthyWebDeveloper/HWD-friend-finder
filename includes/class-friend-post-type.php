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
			'menu_icon'           => plugins_url( '../assets/images/fitbit-logo-16x16.png', __FILE__ ),
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

		add_filter( 'manage_edit-friend_columns', array( 'Friend_Post_Type', 'edit_friend_columns' ) );

		add_action( 'manage_friend_posts_custom_column', array( 'Friend_Post_Type', 'manage_friend_columns' ), 10, 2 );

		add_filter( 'manage_edit-friend_sortable_columns', array( 'Friend_Post_Type', 'friend_sortable_columns' ) );

		/* Only run our customization on the 'edit.php' page in the admin. */
		add_action( 'load-edit.php', array( 'Friend_Post_Type', 'edit_friend_load' ) );
	}


	/**
	  * Custom columns for friend custom post type edit screen
	  *
	  */
	public static function edit_friend_columns( $columns ) {

		// possible value
		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Id' ),
			'displayName' => __( 'Display Name' ),
			'location' => __( 'Location' ),
			// 'country' => __( 'Country' ),
			'gender' => __( 'Gender' ),
			// 'phonenumber' => __( 'Phone Number' ),
			'landingpage' => __( 'Fitbit Profile' )
			
		);

		return $columns;
	}

	/**
	  * Returns values for columns for friend custom post type edit screen
	  *
	  */  
	public static function manage_friend_columns( $column, $post_id ) {
		global $post;

		switch( $column ) {

			/* If displaying the 'gender' column. */
			case 'gender' :

				/* Get the post meta. */
				$gender = get_post_meta( $post_id, 'gender', true );

				/* If no phone number is found, output a default message. */
				if ( empty( $gender ) )
					echo __( 'N/A' );

				/* If there is a phone number, format it to the text string. */
				else
					echo $gender;

			break;
			
			/* If displaying the 'landingpage' column. */
			case 'landingpage' :

				/* Get the post meta. */
				$landingpage = get_post_meta( $post_id, 'encodedId', true );

				/* If no duration is found, output a default message. */
				if ( empty( $landingpage ) )
					echo __( 'N/A' );

				/* If there is a landing page, format it to the text string. */
				else
					// echo '<a href="'.get_permalink($city).'">'.get_the_title($city).'</a>';
					printf( __( '<a href="https://www.fitbit.com/user/%s" target="_BLANK">%s</a>' ), $landingpage, get_the_title($post_id) );
					

			break;

			/* If displaying the 'city' column. */
			case 'location' :

				/* Get the post meta. */
				$city = get_post_meta( $post_id, 'city', true );
				$country = get_post_meta( $post_id, 'country', true );

				/* If no duration is found, output a default message. */
				if ( empty( $city ) || empty( $country ) )
					echo __( '' );

				/* If there is a city, format it to the text string. */
				else
					echo $city.', '.$country;

			break;

			/* If displaying the 'displayName' column. */
			case 'displayName' :

				/* Get the post meta. */
				$displayName = get_post_meta( $post_id, 'displayName', true );

				/* If no duration is found, output a default message. */
				if ( empty( $displayName ) )
					echo __( '' );

				/* If there is a displayName, format it to the text string. */
				else
					echo $displayName;

			break;
			

			/* Just break out of the switch statement for everything else. */
			default :
				break;
		}
	}


	 /**
	  * Adds sortable columns to friend custom post type edit screen
	  *
	  * @param array $columns Array of sortable columns
	  *
	  */
	public static function friend_sortable_columns( $columns ) {

		$columns['location'] = 'location';
		// $columns['country'] = 'country';
		$columns['displayName'] = 'displayName';
		// landing page values are numeric, may not be logical to sort
		// $columns['landingpage'] = 'landingpage';

		return $columns;
	}

	 /**
	  * Returns values for columns for friend custom post type edit screen
	  *
	  */
	public static function edit_friend_load() {
		add_filter( 'request', array( 'Friend_Post_Type',  'sort_friend' ) );
	}

	/**
	  * Returns custom sort values for post type edit screen
	  *
	  * @param array $vars Array of custom query variables
	  *
	  */
	function sort_friend( $vars ) {

		/* Check if we're viewing the 'friend' post type. */
		if ( isset( $vars['post_type'] ) && 'friend' == $vars['post_type'] ) {

			/* Check if 'orderby' is set to 'location'. */
			if ( isset( $vars['orderby'] ) && 'location' == $vars['orderby'] ) {

				/* Merge the query vars with our custom variables. */
				$vars = array_merge(
					$vars,
					array(
						'meta_key' => 'city',
						'orderby' => 'meta_value'
					)
				);
			} else
			/* Check if 'orderby' is set to 'displayName'. */
			if ( isset( $vars['orderby'] ) && 'displayName' == $vars['orderby'] ) {

				/* Merge the query vars with our custom variables. */
				$vars = array_merge(
					$vars,
					array(
						'meta_key' => 'displayName',
						'orderby' => 'meta_value'
					)
				);
			}
		}

		return $vars;
	}


} // end Friend_Post_Type Class


add_action( 'init', array( 'Friend_Post_Type', 'register_custom_post_type' ) );
