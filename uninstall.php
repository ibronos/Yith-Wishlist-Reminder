<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

// Query all WooCommerce products.
$args = array(
    'post_type' => 'product',
    'posts_per_page' => -1, 
    'fields' => 'ids', 
);

$products = get_posts( $args );

if ( $products ) {
    foreach ( $products as $product_id ) {
        delete_post_meta( $product_id, 'ywr_from' );
        delete_post_meta( $product_id, 'ywr_subject' );
        delete_post_meta( $product_id, 'ywr_content' );
    }
}
