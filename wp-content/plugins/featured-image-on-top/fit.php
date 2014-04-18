<?php
/*
Plugin Name: Featured Image on Top
Plugin URI: 
Description: Forces the Featured Image metabox to stay at the top of the second column in the edit post admin screen.
Version: 1.0
Author: Decarbonated Web Services
Author URI: http://www.decarbonated.com/
License: GPL2
*/

if (!class_exists('DWS_FIT')) {
	class DWS_FIT {
		var $slug = 'fit';
		var $name = 'Featured Image on Top';
		var $access = 'manage_options';
		var $installdir;
		var $ver = "1.0";

		function __construct() {
			//define('WP_DEBUG', true);
			$this->installdir = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__),"",plugin_basename(__FILE__));
			$this->name = __($this->name,'dws');
			
			add_action('add_meta_boxes', array(&$this, 'action_add_meta_boxes'));
			add_action('admin_menu', array(&$this, 'action_admin_menu'));

			register_activation_hook(__FILE__, array(&$this, 'plugin_construct'));	// Register construct
			register_deactivation_hook(__FILE__, array(&$this, 'plugin_destruct'));	// Register plugin destruct
		}

		function action_admin_menu() { // Add "Add New Avatar" link under the "Appearance" menu
			add_settings_section($this->slug, $this->name, array(&$this, 'fit_section_text'), 'media');
			add_settings_field($this->slug . '-override-user-custom', __('Allow Users to Customize Order'), array(&$this, 'user_custom_order'), 'media', $this->slug);
			register_setting('media', 'dws_' . $this->slug);
		}
		
		function user_custom_order() {
			$options = get_option('dws_' . $this->slug);
			$field_slug = 'override-user-custom';
			?>
				<input type="checkbox" <?php checked( $options[$field_slug], "on" ); ?> id="<?php echo $this->slug . '-' . $field_slug; ?>" name="<?php echo 'dws_' . $this->slug; ?>[<?php echo $field_slug; ?>]">
			<?php
		}
		
		function fit_section_text() {
			// I don't think we need anything here.  It's pretty self-explanitory.
		}

		function action_add_meta_boxes() {
			if (current_theme_supports('post-thumbnails')) {
				global $wp_meta_boxes;
				$options = get_option('dws_' . $this->slug);
				
				// Fix it to the top by default
				$wp_meta_boxes['post']['side']['core'] = array_merge($wp_meta_boxes['post']['side']['low'],$wp_meta_boxes['post']['side']['core']);
				unset($wp_meta_boxes['post']['side']['low']);
				
				// Here's how we force it for users who have a custom metabox order
				if ($options['override-user-custom'] != "on") {
					$current_user = wp_get_current_user();
					$user_meta = get_user_meta($current_user->ID);
					$current_user_metabox_order = unserialize($user_meta['meta-box-order_post'][0]);
					$current_user_metabox_order_side = explode(",",$current_user_metabox_order['side']);
					$current_user_metabox_order_normal = explode(",",$current_user_metabox_order['normal']);
					$current_user_metabox_order_advanced = explode(",",$current_user_metabox_order['advanced']);
					
					foreach ($current_user_metabox_order as $metabox_area => $metabox_data) {
						$metaboxes = explode(",",$metabox_data);
						if ($found_key = array_search('postimagediv',$metaboxes)) {
							unset($metaboxes[$found_key]);
							array_unshift($metaboxes,'postimagediv');
							$metaboxes = implode(",",$metaboxes);
							$current_user_metabox_order[$metabox_area] = $metaboxes;
							update_user_meta($current_user->ID,'meta-box-order_post',$current_user_metabox_order);
						}
					}
				}
			}
		} 
		
		function plugin_construct() {
			$options = array();
			$options['override-user-custom'] = 'on';
			update_option('dws_' . $this->slug,$options);
		}
	
		function plugin_destruct() {
			delete_option('dws_' . $this->slug);
		}
	}
	$dws_fit = new DWS_FIT();
}