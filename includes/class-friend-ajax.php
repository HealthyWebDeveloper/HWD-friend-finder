<?php
/**
 * Friend Ajax Class
 *
 * @since 1.3.8
 *
 * @package hwd-friend-finder
 */

class Friend_Ajax {

		public static function add_friend() {

			global $wpdb; // this is how you get access to the database

			// check_ajax_referer( 'hwd_add_friend' );

			$whatever = intval( $_POST['whatever'] );

			$whatever += 10;

		    echo $whatever;

			wp_die(); // this is required to terminate immediately and return a proper response

		}

		public static function ajaxurl() {
			?>
			<script type="text/javascript">
			var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
			</script>
			<?php
		}


} // end Friend_Ajax Class


add_action( 'wp_ajax_hwd_add_friend', array( 'Friend_Ajax', 'add_friend' ) );
add_action( 'wp_ajax_nopriv_hwd_add_friend', array( 'Friend_Ajax', 'add_friend' ) );
add_action( 'wp_head', array( 'Friend_Ajax', 'ajaxurl'), 0 );
add_action( 'admin_head', array( 'Friend_Ajax', 'ajaxurl'), 0 );