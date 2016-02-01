<?php

/**
 * Class for Friend Settings
 *
 * @since 1.2.1
 *
 * @package hwd-friend-finder
 * @author http://www.yaconiello.com/blog/how-to-handle-wordpress-settings/
 */

if(!class_exists('Friend_Settings'))
{
    class Friend_Settings
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            // register actions
            add_action('admin_init', array(&$this, 'admin_init'));
            add_action('admin_menu', array(&$this, 'add_menu'));
        } // END public function __construct
    
        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init()
        {
            // register your plugin's settings
            register_setting('friend_settings-group', 'consumer_key');
            register_setting('friend_settings-group', 'consumer_secret');

            // add your settings section
            add_settings_section(
                'friend_settings-section', 
                __( 'Friend Settings', 'hwd' ), 
                array(&$this, 'settings_section_friend_settings'), 
                'friend_settings'
            );
        
            // add your setting's fields
            add_settings_field(
                'friend_settings-consumer_key', 
                __( 'Consumer Key', 'hwd' ), 
                array(&$this, 'settings_field_input_text'), 
                'friend_settings', 
                'friend_settings-section',
                array(
                    'field' => 'consumer_key'
                )
            );
            add_settings_field(
                'friend_settings-consumer_secret', 
                __( 'Consumer Secret', 'hwd' ), 
                array(&$this, 'settings_field_input_text'), 
                'friend_settings', 
                'friend_settings-section',
                array(
                    'field' => 'consumer_secret'
                )
            );
            // Possibly do additional admin_init tasks
        } // END public static function activate
    
        public function settings_section_friend_settings()
        {
            // Think of this as help text for the section.
            _e('These settings do things for the WP Plugin Template.', 'hwd');
        }
    
        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text($args)
        {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
        } // END public function settings_field_input_text($args)
    
        /**
         * add a menu
         */     
        public function add_menu()
        {
            // Add a page to manage this plugin's settings
            // add_options_page(
            //     'WP Plugin Template Settings', 
            //     'WP Plugin Template', 
            //     'manage_options', 
            //     'friend_settings', 
            //     array(&$this, 'plugin_settings_page')
            // );

            // http://www.billrobbinsdesign.com/custom-post-type-admin-page/
            add_submenu_page(
            	'edit.php?post_type=friend', 
            	__('Friend Admin', 'hwd'), 
            	__('Friend Settings', 'hwd'), 
            	'edit_posts', 
            	basename(__FILE__), 
            	array(&$this, 'plugin_settings_page')
            	);

        } // END public function add_menu()

        /**
         * Menu Callback
         */     
        public function plugin_settings_page()
        {
            if(!current_user_can('manage_options'))
            {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }

            // Render the settings template
            include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
        } // END public function plugin_settings_page()


    } // END class Friend_Settings

    $friend_settings_Settings = new Friend_Settings();    
} // END if(!class_exists('Friend_Settings'))
