<div class="wrap">
    <form method="post" action="options.php"> 
        <?php @settings_fields('friend_settings-group'); ?>
        <?php @do_settings_fields('friend_settings-group'); ?>
		<?php do_settings_sections('friend_settings'); ?>
        <?php @submit_button(); ?>
    </form>
</div>

<?php

$consumer_key = get_option( 'hwd_consumer_key', false );
$consumer_secret = get_option( 'hwd_consumer_secret', false );
$fitbit_token = get_option( 'hwd_fitbit_token', false );
$fitbit_secret = get_option( 'hwd_fitbit_secret', false );

define( 'HWD_CONSUMER_KEY', $consumer_key );
define( 'HWD_CONSUMER_SECRET', $consumer_secret );
define( 'HWD_FITBIT_TOKEN', $fitbit_token );
define( 'HWD_FITBIT_SECRET', $fitbit_secret );

$fitbit_php = new FitBitPHP( HWD_CONSUMER_KEY, HWD_CONSUMER_SECRET, 0, null, 'json' );

$fitbit_php->setOAuthDetails( HWD_FITBIT_TOKEN, HWD_FITBIT_SECRET );

$fitbit_php->setUser('37CW3Q');

$profile = $fitbit_php->getProfile();

// var_dump($profile->user->encodedId);

// Create post object
$my_post = array(
  'post_title'    => $profile->user->encodedId,
  'post_content'  => $profile->user->encodedId,
  'post_status'   => 'publish',
  'post_author'   => 1,
  // 'post_category' => array( 8,39 ),
  'post_type'     => 'friend'
);
 
// Insert the post into the database
$post_id = wp_insert_post( $my_post );

foreach($profile->user  as $meta_key => $meta_value){
  add_post_meta($post_id, $meta_key, $meta_value, true);
}


?>