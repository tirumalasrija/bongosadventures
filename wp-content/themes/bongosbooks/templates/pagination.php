<?php
/**
 * Pagination
 *
 * Provides pagination for archives & multi-page posts.
 *
 * Support WP-PageNavi for customizing the output &
 * behavior of pagination.
 *
 * @link https://wordpress.org/plugins/wp-pagenavi/
 */

if(function_exists('wp_pagenavi')) {
    if(is_singular()) {
        wp_pagenavi(array('type' => 'multipart'));
    } else {
        wp_pagenavi();
    }
} else {
    if(is_archive() || is_home()) {
        the_posts_pagination();
    } elseif(is_singular()) {
        wp_link_pages();
    }
}
