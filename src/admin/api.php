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

        try {

            $from = isset($params['from']) ? sanitize_text_field($params['from']) : '';
            $subject = isset($params['subject']) ? sanitize_text_field($params['subject']) : '';
            $message = isset($params['content']) ? sanitize_text_field($params['content']) : '';
    
            // Get WooCommerce mailer from the instance
            $mailer = WC()->mailer();
            
            // Wrap message in WooCommerce template
            $wrapped_message = $mailer->wrap_message($subject, $message);
            
            // Create new WC_Email instance
            $wc_email = new \WC_Email();
            
            // Style the wrapped message
            $styled_message = $wc_email->style_inline($wrapped_message);

            // Change WooCommerce "From" Email Address
            if( !empty($from) ){
                add_filter('woocommerce_email_from_address', function($from_email) use ($from) {
                        return $from;
                    }
                );
            }

            if (!empty($users)) {
                foreach ($users as $user) {
                    $user_info = get_userdata($user->user_id);
                    $to = $user_info->user_email;

                    // Send the email using WooCommerce
                    $mailer->send($to, $subject, $styled_message, '', '');
                }
            }
            
            return new \WP_REST_Response("email success", 200);

        } catch (\Throwable $th) {
            return new \WP_REST_Response($th->getMessage(), 500);
        }

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





