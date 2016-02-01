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
$fitbit_key = get_option( 'hwd_fitbit_key', false );
$fitbit_secret = get_option( 'hwd_fitbit_secret', false );

define( 'HWD_CONSUMER_KEY', $consumer_key );
define( 'HWD_CONSUMER_SECRET', $consumer_secret );
define( 'HWD_FITBIT_TOKEN', $fitbit_key );
define( 'HWD_FITBIT_SECRET', $fitbit_secret );

$fitbit_php = new FitBitPHP( HWD_CONSUMER_KEY, HWD_CONSUMER_SECRET, 0, null, 'json' );

$fitbit_php->setOAuthDetails( HWD_FITBIT_TOKEN, HWD_FITBIT_SECRET );

$fitbit_php->setUser('37CW3Q');

$profile = $fitbit_php->getProfile();

var_dump($profile);

?>
