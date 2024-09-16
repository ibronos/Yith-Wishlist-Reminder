<?php

namespace Isaidi\YithWishlistReminder\Admin;

class AdminHelper {

    function is_plugin_active_by_name($plugin_name) {
      
        if (!function_exists('get_plugins')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
    
        $all_plugins = get_plugins();

        $plugin_name = strtolower($plugin_name);
    
        foreach ($all_plugins as $plugin_path => $plugin_data) {
            if (strtolower($plugin_data['Name']) === $plugin_name) {
                return is_plugin_active($plugin_path);
            }
        }
   
        return false;
    }

    function get_total_wishlist() {
        global $post, $wpdb;
        $user_count = $wpdb->get_results( "SELECT count(*) as total FROM wp_yith_wcwl where prod_id = $post->ID", OBJECT);
        
        return $user_count[0]->total;
    }

}