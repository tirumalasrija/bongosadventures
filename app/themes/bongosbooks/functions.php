<?php
/**
 * Theme includes
 *
 * The $theme_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$theme_includes = [
    'lib/options.php',        // Options
    'lib/extras.php',         // Custom functions
    'lib/setup.php',          // Theme setup
    'lib/assets.php',         // Scripts and stylesheets
    'lib/metaboxes.php',      // Metaboxes
    'lib/wrapper.php',        // Theme wrapper class
    'lib/woocommerce.php'     // WooCommerce
];

foreach( $theme_includes as $file ) {
    if( !$filepath = locate_template( $file ) ) {
        trigger_error( sprintf( __( 'Error locating %s for inclusion', 'tmbase' ), $file ), E_USER_ERROR );
    }

    require_once $filepath;
}
unset( $file, $filepath );
add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );
function custom_woocommerce_product_add_to_cart_text( $default) {
	global $product;
	
	$product_type = $product->product_type;
	
	switch ( $product_type ) {
		
		case 'subscription':
			return __( 'Subscribe', 'woocommerce' );
		break;
		default:
			return __("Add to cart" , 'woocommerce' );
		
	}
	
}
add_filter( 'add_to_cart_text', 'woo_custom_single_add_to_cart_text' );                // < 2.1
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_single_add_to_cart_text' );  // 2.1 +
  
function woo_custom_single_add_to_cart_text() {
  
   global $product;
	
	$product_type = $product->product_type;
	
	switch ( $product_type ) {
		
		case 'subscription':
			return __( 'Subscribe', 'woocommerce' );
		break;
		default:
			return __("Add to cart" , 'woocommerce' );
		
	}
  
}