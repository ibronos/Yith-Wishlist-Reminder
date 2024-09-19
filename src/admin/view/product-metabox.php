<?php 

$field_from = 'ywr_from';
$field_subject = 'ywr_subject';
$field_content = 'ywr_content';

// Add an nonce field so we can check for it later.
wp_nonce_field( 'ywr_meta_box_action', 'ywr_meta_box_nonce' );

// Use get_post_meta to retrieve an existing value from the database.
$value_from = get_post_meta( $post->ID, $field_from, true );
$value_subject = get_post_meta( $post->ID, $field_subject, true );
$value_content = get_post_meta( $post->ID, $field_content, true );

$helper = new Isaidi\YithWishlistReminder\Admin\AdminHelper();
$total_wishlist = $helper->get_total_wishlist();
?>

<p><?php echo $total_wishlist . " customers like this item"; ?></p>
<hr>

<table>
    <tr>
        <td>
            <label for="<?= $field_from; ?>">
                <?php _e( 'From', 'textdomain' ); ?>
            </label>
        </td>
        <td>
            <input type="email" id="<?= $field_from; ?>" name="<?= $field_from; ?>" value="<?php echo esc_attr( $value_from ); ?>" size="90" />
        </td>
    </tr>

    <tr>
        <td>
            <label for="<?= $field_subject; ?>">
                <?php _e( 'Subject', 'textdomain' ); ?>
            </label>
        </td>
        <td>
            <input type="text" id="<?= $field_subject; ?>" name="<?= $field_subject; ?>" value="<?php echo esc_attr( $value_subject ); ?>" size="90" />
        </td>
    </tr>

    <tr>
        <td>
            <label for="<?= $field_content; ?>">
                <?php _e( 'Content', 'textdomain' ); ?>
            </label>
        </td>
        <td>
            <textarea name="<?= $field_content; ?>" id="<?= $field_content; ?>" cols="100" rows="10">
                <?php echo esc_attr( $value_content ); ?>
            </textarea>
        </td>
    </tr>

    <tr>
        <td>
        </td>
        <td>
            <button id="ywr-submit" class="button button-primary" style="min-width: 100px;">Send</button>
        </td>
    </tr>

</table>

<div id="ywr-api-response"></div>