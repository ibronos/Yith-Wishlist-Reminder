<?php

namespace Isaidi\YithWishlistReminder\Admin;

use Isaidi\YithWishlistReminder\Admin\AdminHelper as helper;

class YithCheck {

    protected $adminHelper;

    public function __construct(){  
        add_action('init', array($this, 'plugin_check'));
        $this->adminHelper = new helper();
    }

    function plugin_check() {
        
        //run only when woocommerce and yith wishlist active
        if (
            $this->adminHelper->is_plugin_active_by_name('YITH WooCommerce Wishlist') &&
            $this->adminHelper->is_plugin_active_by_name('WooCommerce')
        ) 
        {
            require 'woocommerce.php';
        }
        else {
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
