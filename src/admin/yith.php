<?php

namespace Isaidi\YithWishlistReminder\Admin;

use Isaidi\YithWishlistReminder\Admin\AdminHelper as helper;

class YithCheck {

    protected $admin_helper;

    public function __construct(){  
        add_action('init', array($this, 'plugin_check'));
        $this->admin_helper = new helper();
    }

    function plugin_check() {

        global $pagenow;

        /** 
         * Run only when:
         * - woocommerce active
         * - yith wishlist active
         * - on product edit screen
        */
        if (
            $this->admin_helper->is_plugin_active_by_name('YITH WooCommerce Wishlist') &&
            $this->admin_helper->is_plugin_active_by_name('WooCommerce') && 
            $pagenow == 'post.php'
        ) {
            require 'woocommerce.php';
        }
         
        if
        (
            $this->admin_helper->is_plugin_active_by_name('YITH WooCommerce Wishlist') == false ||
            $this->admin_helper->is_plugin_active_by_name('WooCommerce') == false
        ){
            add_action( 'admin_notices',  array( $this, 'plugin_check_error_notif' ) );
        }

    }

    function plugin_check_error_notif() {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php _e( 'Yith Wishlist Reminder: Please install and activate Woocommerce and YITH Wishlist plugins!', '' ); ?></p>
        </div>
        <?php
    }
    


}

new YithCheck();
