<?php

/*
 * WooCommerce Helpers and Modifications
 */

add_filter('woocommerce_add_to_cart_redirect', 'woo_redirect_to_checkout');
add_filter('woocommerce_product_add_to_cart_text', 'woo_cart_button_text');
add_filter('woocommerce_product_single_add_to_cart_text', 'woo_cart_button_text');
add_filter('body_class', 'active_member_body_class');

// Redirect to checkout on "Join Now"
function woo_redirect_to_checkout()
{
    $checkout_url = wc_get_checkout_url();

    return $checkout_url;
}

// Change "Add to Cart" button text to "Join Now!"
function woo_cart_button_text()
{
    if(is_page(get_page_by_title('Join Now'))) {
        return __('Join Now!', 'woocommerce');
    } else {
        return __('Buy Now', 'woocommerce');
    }
}

/**
 * Add "is_active_member" body class if user is active member and logged in
 *
 * @param $classes
 * @return array
 */
function active_member_body_class($classes)
{
    if (is_user_logged_in() && wc_memberships_is_user_active_member(get_current_user_id(), 'premium-membership-plan')) {
        $classes[] = 'is_active_member';
    }

    return $classes;
}