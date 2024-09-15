<?php 

$fieldFrom = 'ywr_from';
$fieldSubject = 'ywr_subject';
$fieldContent = 'ywr_content';

// Add an nonce field so we can check for it later.
// wp_nonce_field( 'ywr_meta_box', 'ywr_meta_box_nonce' );
wp_nonce_field( 'ywr_meta_box_action', 'ywr_meta_box_nonce' );

// Use get_post_meta to retrieve an existing value from the database.
$valueFrom = get_post_meta( $post->ID, $fieldFrom, true );
$valueSubject = get_post_meta( $post->ID, $fieldSubject, true );
$valueContent = get_post_meta( $post->ID, $fieldContent, true );

?>

<table>
    <tr>
        <td>
            <label for="<?= $fieldFrom; ?>">
                <?php _e( 'From', 'textdomain' ); ?>
            </label>
        </td>
        <td>
            <input type="email" id="<?= $fieldFrom; ?>" name="<?= $fieldFrom; ?>" value="<?php echo esc_attr( $valueFrom ); ?>" size="90" />
        </td>
    </tr>

    <tr>
        <td>
            <label for="<?= $fieldSubject; ?>">
                <?php _e( 'Subject', 'textdomain' ); ?>
            </label>
        </td>
        <td>
            <input type="text" id="<?= $fieldSubject; ?>" name="<?= $fieldSubject; ?>" value="<?php echo esc_attr( $valueSubject ); ?>" size="90" />
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
