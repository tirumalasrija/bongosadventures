<?php

namespace TMProd\Base\Options;

add_filter('mb_settings_pages', __NAMESPACE__ . '\\theme_options_page');

function theme_options_page($settings_pages)
{
    $settings_pages[] = array(
        'id'          => 'tmbase-options',
        'option_name' => 'tmbase_options',
        'menu_title'  => __('Theme Options', 'tmbase'),
        'parent'      => 'themes.php',
    );

    return $settings_pages;
}

/**
 * Add the Meta Boxes to the settings page.
 *
 * @param $meta_boxes
 *
 * @return array
 */
function theme_options_metaboxes($meta_boxes)
{
    $prefix = 'tmbase_';

    // General settings
    $meta_boxes[] = [
        'id'             => 'general_settings',
        'title'          => __('General', 'tmbase'),
        'settings_pages' => 'tmbase-options',
        'fields'         => [

            // Logo width
            [
                'id'         => $prefix . 'logo_width',
                'name'       => __('Logo Width', 'tmbase'),
                'desc'       => __('Width of the logo.', 'tmbase'),
                'type'       => 'text',
                'default'    => 70,
                'attributes' => ['type' => 'number', 'pattern' => '\d*',],
            ],

            // Logo height
            [
                'id'         => $prefix . 'logo_height',
                'name'       => __('Logo Height', 'tmbase'),
                'desc'       => __('Height of the logo.', 'tmbase'),
                'type'       => 'text',
                'default'    => 125,
                'attributes' => ['type' => 'number', 'pattern' => '\d*',],
            ],

            // Logo centered in nav
            [
                'id'   => $prefix . 'logo_center',
                'name' => __('Center Logo in Main Menu', 'tmbase'),
                'desc' => __('Positions the logo in the center of the main navigation menu, 
                                    in-between the nav-items.', 'tmbase'),
                'type' => 'checkbox',
            ],

            // Default internal banner
            [
                'id'               => $prefix . 'default_banner',
                'name'             => __('Default Internal Banner', 'tmbase'),
                'desc'             => __('Select the default banner displayed on pages and posts.', 'tmbase'),
                'type'             => 'image_advanced',
                'max_file_uploads' => 1,
            ],
        ],
    ];

    // Additional scripts/tags
    $meta_boxes[] = [
        'id'             => 'additional_scripts',
        'title'          => __('Additional Scripts/Tags', 'tmbase'),
        'settings_pages' => 'tmbase-options',
        'fields'         => [

            // Additional tags in <head>
            [
                'id'   => $prefix . 'head_tags',
                'name' => __('Additional &lt;head&gt; Tags', 'tmbase'),
                'desc' => __('Use this field to add additional tags to the &lt;head&gt;.', 'tmbase'),
                'type' => 'textarea',
                'rows' => 12,
            ],

            // Additional tags before <body> content starts
            [
                'id'   => $prefix . 'before_body_tags',
                'name' => __('Before &lt;body&gt; Tags', 'tmbase'),
                'desc' => __('Use this field to add additional tags immediately after the opening &lt;body&gt; tag. 
                For example, Google Tag Manager &lt;noscript&gt; tags.', 'tmbase'),
                'type' => 'textarea',
                'rows' => 12,
            ],

            // Additional Footer Scripts
            [
                'id'   => $prefix . 'footer_scripts',
                'name' => __('Footer Scripts', 'tmbase'),
                'desc' => __('Use this field to add additional scripts to the footer.
                Ideal for including external user interaction/marketing scripts.', 'tmbase'),
                'type' => 'textarea',
                'rows' => 12,
            ],
        ],
    ];

    $meta_boxes[] = [
        'id'             => 'lesson_quiz_defaults',
        'title'          => __('Lesson Quiz Settings', 'tmbase'),
        'settings_pages' => 'tmbase-options',
        'fields'         => [
            [
                'id'          => $prefix . 'default_wrong_message',
                'type'        => 'text',
                'name'        => esc_html__('Default Wrong Answer Message', 'tmbase'),
                'desc'        => __('Enter a message to be displayed if an incorrect answer is selected.', 'tmbase'),
                'placeholder' => __('Nope, try again!', 'tmbase'),
                'std'         => __('Nope, try again!', 'tmbase'),
                'size'        => 75,
            ],
            [
                'id'          => $prefix . 'default_correct_message',
                'type'        => 'text',
                'name'        => esc_html__('Default Correct Answer Message', 'tmbase'),
                'desc'        => __('Enter a message to be displayed if the correct answer is selected.', 'tmbase'),
                'placeholder' => __('You got it!', 'tmbase'),
                'std'         => __('You got it!', 'tmbase'),
                'size'        => 75,
            ],
        ]
    ];

    return $meta_boxes;
}

add_filter('rwmb_meta_boxes', __NAMESPACE__ . '\\theme_options_metaboxes');

/**
 * Wrapper function around cmb2_get_option
 *
 * @since  0.1.0
 *
 * @param  string $key     Options array key
 * @param  string $default Value to return if option is not set.
 *
 * @return mixed        Option value
 */
function get_option($key = '', $default = '')
{
    static $options;

    if (!isset($options)) {
        $options = \get_option('tmbase_options');
    }

    if (is_array($options) && array_key_exists($key, $options)) {
        return $options[$key];
    }

    if ($default) {
        return $default;
    }

    return false;
}
