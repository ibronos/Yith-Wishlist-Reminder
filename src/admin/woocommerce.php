<?php

namespace Isaidi\YithWishlistReminder\Admin;


class Woocommerce {

    public function __construct(){  
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
    }

    public function add_meta_box( $post_type ) {
        $post_types = array('product');     //limit meta box to certain post types
        global $post;
        $product = wc_get_product( $post->ID );
        if ( in_array( $post_type, $post_types ) && ($product->get_type() == 'simple' ) ) {
            add_meta_box(
                'ywr_from'
                ,__( 'Wishlist Reminder', 'woocommerce' )
                ,array( $this, 'render_metabox' )
                ,$post_type
                ,'advanced'
                ,'low'
            );
        }
    }

    public function render_metabox( $post ) {

        $fieldFrom = 'ywr_from';
        $fieldSubject = 'ywr_subject';
        $fieldContent = 'ywr_content';

		// Add an nonce field so we can check for it later.
		wp_nonce_field( $fieldFrom .'_custom_box', $fieldFrom .'_custom_box_nonce' );
        wp_nonce_field( $fieldSubject .'_custom_box', $fieldSubject .'_custom_box_nonce' );
        wp_nonce_field( $fieldContent .'_custom_box', $fieldContent .'_custom_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$valueFrom = get_post_meta( $post->ID, $fieldFrom, true );
        $valueSubject = get_post_meta( $post->ID, $fieldSubject, true );
        $valueContent = get_post_meta( $post->ID, $fieldContent, true );

		// Display the form, using the current value.
		?>

        <table>
            <tr>
                <td>
                    <label for="<?= $fieldFrom; ?>">
                        <?php _e( 'From', 'textdomain' ); ?>
                    </label>
                </td>
                <td>
                    <input type="text" id="<?= $fieldFrom; ?>" name="<?= $fieldFrom; ?>" value="<?php echo esc_attr( $valueFrom ); ?>" size="25" />
                </td>
            </tr>

            <tr>
                <td>
                    <label for="<?= $fieldSubject; ?>">
                        <?php _e( 'Subject', 'textdomain' ); ?>
                    </label>
                </td>
                <td>
                    <input type="text" id="<?= $fieldSubject; ?>" name="<?= $fieldSubject; ?>" value="<?php echo esc_attr( $valueSubject ); ?>" size="25" />
                </td>
            </tr>

            <tr>
                <td>
                    <label for="<?= $fieldContent; ?>">
                        <?php _e( 'Content', 'textdomain' ); ?>
                    </label>
                </td>
                <td>
                    <textarea name="<?= $fieldContent; ?>" id="<?= $fieldContent; ?>" cols="100" rows="10">
                        <?php echo esc_attr( $valueContent ); ?>
                    </textarea>
                </td>
            </tr>

        </table>


		<?php
	}


}

new Woocommerce();
