<div class="wrap">
    <form method="post" action="options.php"> 
        <?php @settings_fields('friend_settings-group'); ?>
        <?php @do_settings_fields('friend_settings-group'); ?>
		<?php do_settings_sections('friend_settings'); ?>
        <?php @submit_button(); ?>
    </form>
</div>