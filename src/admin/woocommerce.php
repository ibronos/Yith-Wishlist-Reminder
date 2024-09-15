<?php

namespace Isaidi\YithWishlistReminder\Admin;


class Woocommerce {

    public function __construct(){  
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_metabox' ), 10, 2 );
    }

    public function add_meta_box( $post_type ) {
        $post_types = array('product');
        global $post;
        $product = wc_get_product( $post->ID );
        if ( in_array( $post_type, $post_types ) && ($product->get_type() == 'simple' ) ) {
            add_meta_box(
                'ywr_from'
                ,__( 'Wishlist Reminder', 'textdomain' )
                ,array( $this, 'render_metabox' )
                ,$post_type
                ,'advanced'
                ,'low'
            );
        }
    }

    public function render_metabox( $post ) {
       require 'view/product-metabox.php';
	}

    public function save_metabox( $post_id, $post ) {
    
        // Check if nonce is valid.
        if( !wp_verify_nonce( $_POST['ywr_meta_box_nonce'], 'ywr_meta_box_action' ) ) {
            return;
        }

		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

        if (isset($_POST['ywr_from'])) {
            update_post_meta($post_id, 'ywr_from', sanitize_text_field($_POST['ywr_from']));
        }
        
        if (isset($_POST['ywr_subject'])) {
            update_post_meta($post_id, 'ywr_subject', sanitize_text_field($_POST['ywr_subject']));
        }

        if (isset($_POST['ywr_content'])) {
            update_post_meta($post_id, 'ywr_content', sanitize_text_field($_POST['ywr_content']));
        }

	}


}

new Woocommerce();
