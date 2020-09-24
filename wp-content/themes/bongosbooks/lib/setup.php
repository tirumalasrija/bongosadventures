<?php

namespace TMProd\Base\Setup;

use TMProd\Base\Assets;
use TMProd\Base\Options;

/**
 * Configuration
 */

// Distribution directory for front-end-assets
if ( ! defined( 'DIST_DIR' ) ) {
    define( 'DIST_DIR', '/dist/' );
}

/**
 * Theme setup
 */
function setup() {
    // Make theme available for translation
    // Community translations can be found at https://github.com/roots/sage-translations
    load_theme_textdomain( 'tmbase', get_template_directory() . '/lang' );

    // Enable plugins to manage the document title
    // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
    add_theme_support( 'title-tag' );

    // Register wp_nav_menu() menus
    // http://codex.wordpress.org/Function_Reference/register_nav_menus
    register_nav_menus( [
        'primary_menu' => __( 'Primary Menu', 'tmbase' ),
        'footer_menu'  => __( 'Footer Menu', 'tmbase' ),
    ] );

    // Add post thumbnails
    // http://codex.wordpress.org/Post_Thumbnails
    // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
    // http://codex.wordpress.org/Function_Reference/add_image_size
    add_theme_support( 'post-thumbnails' );

    // Add post formats
    // http://codex.wordpress.org/Post_Formats
    // add_theme_support( 'post-formats', [ 'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio' ] );

    // Add HTML5 markup for captions
    // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
    add_theme_support( 'html5', [ 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ] );

    // Tell the TinyMCE editor to use a custom stylesheet
    add_editor_style( Assets\asset_path( 'styles/editor-style.css' ) );

    // Remove Windows Live Writer support and RSD link from the head
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );

    // Add theme support for custom-logo
    $logo_width = Options\get_option('tmbase_logo_width') ? Options\get_option('tmbase_logo_width') : '';
    $logo_height = Options\get_option('tmbase_logo_height') ? Options\get_option('tmbase_logo_height') : '';
    add_theme_support( 'custom-logo', array(
        'height'      => $logo_height,
        'width'       => $logo_width,
        'flex-width' => true,
        'flex-height' => true,
    ) );

    // Declare theme support for WooCommerce
    add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\\setup' );

/**
 * Check for any plugin dependencies for the theme.
 *
 * Checks to see if Meta Box core is installed & active.
 * Then will check to see if Meta Box AIO is installed & active.
 * Then will check to see if Meta Box AIO required plugins are activated.
 */
function process_dependencies()
{
    $error_format = '<div class="error"><p>%s</p></div>';
    $metabox_installed = defined('RWMB_DIR');
    $metabox_aio_installed = is_plugin_active('meta-box-aio/meta-box-aio.php');
    if( !$metabox_installed ) {
        echo sprintf($error_format, __('Warning: The theme requires the plugin: Meta Box to function correctly.', 'tmbase'));
    } elseif( !$metabox_aio_installed ) {
        echo sprintf($error_format, __('Warning: The theme requires the plugin: Meta Box AIO to function correctly.', 'tmbase'));
    }
}

add_action('admin_notices', __NAMESPACE__ . '\\process_dependencies');

/**
 * Enables the Meta Box AIO addons required for the theme.
 * These addons ensure the theme remains functional while it is active.
 */
function enable_required_meta_box_addons( $user_login, $user ) {
    if(!in_array('administrator', $user->roles)) return;

    $meta_box_aio_settings = get_option('meta_box_aio') ? get_option('meta_box_aio') : [];
    $meta_box_aio_settings['mb-settings-page'] = 1;
    $meta_box_aio_settings['meta-box-conditional-logic'] = 1;
    $meta_box_aio_settings['meta-box-group'] = 1;
    $meta_box_aio_settings['meta-box-include-exclude'] = 1;
    update_option('meta_box_aio', $meta_box_aio_settings);
}

add_action('wp_login', __NAMESPACE__ . '\\enable_required_meta_box_addons', 10, 2);

/**
 * Google Analytics or Tag Manager tracking code.
 */
function google_tracking_code() {
    $script = Options\get_option( 'tmbase_google_tracking_code' );
    if ( ! empty( $script ) ) {
        echo '<script>' . $script . '</script>';
    }
}

/**
 * Register widget areas
 */
function widgets_init() {

    register_sidebar( [
        'name'          => __( 'Main Sidebar', 'tmbase' ),
        'id'            => 'main-sidebar',
        'before_widget' => '<div class="widget %1$s %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5>',
        'after_title'   => '</h5>',
    ] );

    register_sidebar( [
        'name'          => __( 'Header Widgets', 'tmbase' ),
        'id'            => 'header-widgets',
        'before_widget' => '<div class="widget %1$s %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<strong>',
        'after_title'   => '</strong>',
    ] );
}

add_action( 'widgets_init', __NAMESPACE__ . '\\widgets_init' );

/**
 * Define the pages that use a sidebar.
 */
function display_sidebar() {
    static $display;

    isset( $display ) || $display = in_array( true, [
        // The rotator will be displayed if any of the following functions return true.
        // @link https://codex.wordpress.org/Conditional_Tags
        (!is_front_page() && is_page() && !is_page_template('no-sidebar.php')),
        is_home(),
        is_single(),
        is_archive(),
        is_search(),
    ] );

    return apply_filters( 'tmbase/display_sidebar', $display );
}

/**
 * Define the pages that use a rotator.
 */
function display_rotator() {
    static $display;

    isset( $display ) || $display = in_array( true, [
        // The rotator will be displayed if any of the following functions return true.
        // @link https://codex.wordpress.org/Conditional_Tags
        is_front_page(),
    ] );

    return apply_filters( 'tmbase/display_rotator', $display );
}

/**
 * Add characters block to The Characters index page
 *
 * @param $content
 * @return string
 */
function display_characters($content) {
    if(is_page(get_page_by_title('The Characters'))) {
        return $content . get_template_part('templates/homepage/characters');
    }

    return $content;
}
add_filter('the_content', __NAMESPACE__ . '\\display_characters');