<?php

namespace TMProd\Base\Extras;

use TMProd\Base\Options;
use TMProd\Base\Setup;

/**
 * Add <body> classes
 */
function body_class($classes)
{

    // Add page-slug as a body class
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    // Sidebar is active
    if (Setup\display_sidebar() && is_active_sidebar('main-sidebar')) {
        $classes[] = 'main-sidebar';
    }

    // Page has rotator
    if (Setup\display_rotator()) {
        $classes[] = 'has-rotator';
    }

    // Site has a custom logo
    if (\has_custom_logo(get_current_blog_id())) {
        $classes[] = 'has-logo';
    }

    // Add a class based on Google Tag Manager or Analytics
    // Allows DOM-based routing to determine what js methods to use.
    if (Options\get_option('tmbase_tracking_type') === 'google_analytics') {
        $classes[] = 'google-analytics';
    } elseif (Options\get_option('tmbase_tracking_type') === 'google_tag_manager') {
        $classes[] = 'google-tag-manager';
    }

    return $classes;
}

add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Add a "read more" button to excerpts
 */
function excerpt_read_more()
{
    return '&hellip;';
}

add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_read_more');

/**
 * Convert nav-item classes
 * Converts navigation menu-item classes to classes compatible with Bourbon Refills.
 * http://refills.bourbon.io
 */
function translate_nav_classes($classes, $item)
{
    $new_classes = array();

    // $classes[0] will contain user-defined class in the admin menu editor.
    if (array_key_exists(0, $classes)) {
        $new_classes[] = $classes[0];
    }

    // Add .nav-link class if it's a top-level item.
    if (!$item->menu_item_parent) {
        $new_classes[] = 'nav-link';
    }

    // Add .active-nav-item class if it's the current page.
    if (in_array('current-menu-item', $classes)) {
        $new_classes[] = 'active-nav-item';
    }

    // Add .more class if nav-item has a sub-menu
    if (in_array('menu-item-has-children', $classes)) {
        $new_classes[] = 'more';
    }

    return $new_classes;
}

add_filter('nav_menu_css_class', __NAMESPACE__ . '\\translate_nav_classes', 10, 2);

/**
 * Remove the id attribute from nav-items
 */
function remove_nav_menu_item_id()
{
    return '';
}

add_filter('nav_menu_item_id', __NAMESPACE__ . '\\remove_nav_menu_item_id', 99, 3);

/**
 * Adds a title attribute to a menu item if the title is empty.
 *
 * @param $atts , current menu item classes
 * @param $item , nav-menu object
 * @return array, html attributes to output on menu-item.
 */
function menu_item_title_fallback($atts, $item)
{

    if ($atts['title'] === '') {
        $atts['title'] = $item->title;
    }

    return $atts;
}

add_filter('nav_menu_link_attributes', __NAMESPACE__ . '\\menu_item_title_fallback', 10, 3);

/**
 * Filter out unnecessary classes from the post_class() template tag.
 * Remove some classes from the output of post_class().
 */
function cleaner_post_class($classes)
{
    foreach ($classes as $id => $class) {
        if ((strpos($class, "tag-") !== false)
            || (strpos($class, "status-") !== false)
            || (strpos($class, "post-") !== false)
            || $class == ""
        ) {
            unset($classes[$id]);
        }
    }

    return $classes;
}

add_filter('post_class', __NAMESPACE__ . '\\cleaner_post_class');

/**
 * Disable emoji's
 */
function disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', __NAMESPACE__ . '\\disable_emojis_tinymce');
}

add_action('init', __NAMESPACE__ . '\\disable_emojis');

/**
 * Filter function used to remove emoji's from TinyMCE
 *
 * @param    array $plugins
 * @return   array             Difference between the two arrays
 */
function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

/*
 * Override "send to" email recipient when in development environments.
 *
 * Requires .env variable WP_MAILTO containing a recipient email address.
 * Requires .env variable WP_ENV to not be in production mode.
 */
function dev_mail_to_override($mail_params)
{

    // Get environment variables
    $environment = env('WP_ENV');
    $env_recipient = env('WP_MAILTO');

    // If we're not in production, override the email address using WP_MAILTO
    if ($environment != 'production' && !empty($env_recipient)) {
        $mail_params['to'] = $env_recipient;
    }

    return $mail_params;
}

//add_filter('wp_mail', __NAMESPACE__ . '\\dev_mail_to_override');

/*
 * Wrap content in an .entry-content element
 */
function wrap_the_content($content)
{
    return '<div class="entry-content">' . $content . '</div>';
}

add_filter('the_content', __NAMESPACE__ . '\\wrap_the_content');

/**
 * Get the title of a page or archive.
 */
function get_page_title()
{
    if (is_home()) {
        if (get_option('page_for_posts', true)) {
            return get_the_title(get_option('page_for_posts', true));
        } else {
            return __('Latest Posts', 'tmbase');
        }
    } elseif (is_post_type_archive()) {
        return post_type_archive_title('');
    } elseif (is_archive()) {
        return get_the_archive_title();
    } elseif (is_search()) {
        return sprintf(__('Search Results for "%s"', 'tmbase'), get_search_query());
    } elseif (is_404()) {
        return __('Page Not Found', 'tmbase');
    } else {
        return get_the_title();
    }
}

/**
 * Remove recent comment <style> block from head.
 */
function remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}

add_action('widgets_init', __NAMESPACE__ . '\\remove_recent_comments_style');

/**
 * Get the WP Attachment using the logo in the Theme Options.
 *
 * @since  0.1.0
 * @param  string $key Options array key
 * @return mixed        Option value
 */
function get_theme_logo()
{
    $args = array();
    $logo_id = get_theme_mod('custom_logo');
    $logo = get_post($logo_id);

    if ($logo) {
        $width = Options\get_option('tmbase_logo_width');
        $height = Options\get_option('tmbase_logo_height');

        // Logo Title Text
        // Use the Title defined in the Media Library if there is one.
        // Else, use the name of the blog.
        if ($logo->post_title) {
            $args['title'] = esc_attr($logo->post_title);
        } else {
            $args['title'] = get_bloginfo('name');
        }

        return wp_get_attachment_image($logo_id, array($width, $height), false, $args);
    }

    return false;
}

/**
 * Detect whether the homepage of the site is current page.
 */
function is_homepage()
{
    if ($_SERVER['REQUEST_URI'] === '/') {
        return true;
    }

    return false;
}

/*
 * Add a dynamic Login/Register/My Account nav item
 */
function add_login_nav_item($items, $args)
{
    if ($args->theme_location == 'primary_menu') {
        if (is_user_logged_in()) {
            $nav_link = '<a href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '" class="my-account" title="My Account">';
            $nav_link .= 'My Account' . '</a>';
        } else {
            $nav_link = '<a href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '" class="login" title="Login/Register">';
            $nav_link .= 'Login/Register' . '</a>';
        }

        $items .= '<li class="nav-login nav-link">' . $nav_link . '</li>';
    }

    return $items;
}

add_filter('wp_nav_menu_items', __NAMESPACE__ . '\\add_login_nav_item', 10, 20);

/**
 * Modify default comment form fields
 *
 * @param $fields
 * @return mixed
 */
function modify_comment_fields($fields)
{
    unset($fields['url']);

    return $fields;
}
add_filter('comment_form_default_fields', __NAMESPACE__ . '\\modify_comment_fields');