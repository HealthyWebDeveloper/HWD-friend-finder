<div class="wrap">
    <form method="post" action="options.php"> 
        <?php @settings_fields('friend_settings-group'); ?>
        <?php @do_settings_fields('friend_settings-group'); ?>
    <?php do_settings_sections('friend_settings'); ?>
        <?php @submit_button(); ?>
    </form>
</div>

<div class="wrap">
    <form method="post"> 
        <h2><?php _e( 'Add Friend Profile', 'hwd' ); ?></h2>
        <?php _e( 'Easily create new profile with API and Fitbit ID', 'hwd' ); ?>
        

    <?php
    if( isset( $_POST['encodedId'] ) && '' != $_POST['encodedId'] ){


      $fitbit_php = new FitBitPHP( HWD_CONSUMER_KEY, HWD_CONSUMER_SECRET, 0, null, 'json' );

      $fitbit_php->setOAuthDetails( HWD_FITBIT_TOKEN, HWD_FITBIT_SECRET );

      $fitbit_php->setUser( $_POST['encodedId'] );

      $profile = $fitbit_php->getProfile();

      // Create post object
      $my_post = array(
        'post_title'    => $profile->user->encodedId,
        'post_content'  => $profile->user->encodedId,
        'post_author'   => 1,
        'post_status'   => 'publish',
        'post_type'     => 'friend'
      );
       
      // Insert the post into the database
      $post_id = wp_insert_post( $my_post, true );

      if( ! is_wp_error( $post_id ) ) {

      foreach($profile->user  as $meta_key => $meta_value){
        add_post_meta($post_id, $meta_key, $meta_value, true);
      }

      ?>
          <div id="message" class="updated">
              <p><strong><?php _e('Friend Added.', 'hwd'); ?></strong></p>
          </div>
      <?php 
      }else{
        ?>
          <div id="message" class="error">
              <p><strong><?php _e('Friend Create Failed.', 'hwd'); ?></strong></p>
          </div>
      <?php 
      }

    }

    ?>
    <table class="form-table">
            <tbody>
              <tr><th scope="row"><?php _e( 'Fitbit ID', 'hwd' ); ?></th><td><input type="text" placeholder="3JDKLR" value="" id="encodedId" name="encodedId"></td></tr>
              
            </tbody></table>
            <p class="submit"><input type="submit" value="<?php _e( 'Create Profile', 'hwd' ); ?>" class="button button-primary" id="submit" name="submit"></p>
    </form>
</div>


