<?php

namespace Isaidi\YithWishlistReminder\Admin;

Class ApiYwr {

    function init(){
        add_action('rest_api_init', array($this, 'list_api'));
        add_action('admin_enqueue_scripts', array($this, 'ywr_api_admin_scripts'));
    }

    function list_api() {
        register_rest_route('ywr-api/v1', '/email', array(
            'methods' => 'POST',
            'callback' => [$this, 'post_cb'],
            'permission_callback' => function() {
                return current_user_can('manage_options');
            }
        ));
    }

    function post_cb($request) {

        global $wpdb;

        $params = $request->get_params();
        $post_id = isset($params['post_id']) ? sanitize_text_field($params['post_id']) : '';

        $users = $wpdb->get_results( "SELECT user_id FROM wp_yith_wcwl where prod_id = $post_id", OBJECT);
        $emails = [];

        if (!empty($users)) {
            foreach ($users as $user) {
                $user_info = get_userdata($user->user_id);
                $email = $user_info->user_email;
                array_push($emails, $email);
            }
        }

        return new \WP_REST_Response($emails, 200);
    }

    function ywr_api_admin_scripts() {
        wp_enqueue_script('ywr-api-admin-js', plugin_dir_url(__FILE__) . 'assets/ywr.js', array('jquery'), null, true);
        wp_localize_script('ywr-api-admin-js', 'ywrApiData', array(
            'root' => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest')
        ));
    }


}

$app = new ApiYwr();
$app->init();





