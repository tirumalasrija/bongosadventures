<?php

namespace TMProd\Base\Metabox;

/**
 * Metabox Initialization
 * Registers metaboxes & fields.
 *
 * @param $meta_boxes array
 *
 * @return array
 */
function register_metaboxes($meta_boxes)
{
    $prefix = 'tmbase_';

    /**
     * Home Banner Metabox
     */
    $meta_boxes[] = [
        'title'      => __('Homepage Rotator'),
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'include'    => [
            'ID' => [get_option('page_on_front')],
        ],
        'fields'     => [
            [
                'id'         => $prefix . 'rotator',
                'type'       => 'group',
                'clone'      => true,
                'sort_clone' => true,
                'sortable'   => true,
                'fields'     => [
                    [
                        'id'               => $prefix . 'rotator_background_id',
                        'type'             => 'image_advanced',
                        'name'             => esc_html__('Rotator Background', 'tmbase'),
                        'desc'             => __('Upload an Rotator Image. Recommended dimensions: 1230x630.', 'tmbase'),
                        'max_file_uploads' => 1,
                    ],
                    [
                        'id'               => $prefix . 'rotator_image_overlay',
                        'type'             => 'image_advanced',
                        'name'             => esc_html__('Image Overlay', 'tmbase'),
                        'desc'             => __('Upload an Rotator Overlay Image.', 'tmbase'),
                        'max_file_uploads' => 1,
                    ],
                    [
                        'id'   => $prefix . 'rotator_title',
                        'name' => 'Rotator Title',
                        'type' => 'text',
                        'desc' => __('Enter a title to display in the rotator. This will be the homepage\'s H1 element.', 'tmbase'),
                    ],
                    [
                        'id'   => $prefix . 'rotator_content',
                        'name' => 'Rotator Content',
                        'type' => 'textarea',
                        'desc' => __('Enter content to display in the rotator.', 'tmbase'),
                    ],
                ],
            ],
        ],
    ];

    /**
     * Banner Metabox
     */
    $meta_boxes[] = [
        'title'      => __('Page Banner', 'tmbase'),
        'post_types' => ['page', 'post', 'bongos_books_lesson'],
        'context'    => 'normal',
        'priority'   => 'default',
        'autosave'   => true,
        'exclude'    => [
            'ID' => [get_option('page_on_front')],
        ],
        'fields'     => [
            [
                'id'               => $prefix . 'banner_background_id',
                'name'             => 'Banner Image',
                'type'             => 'image_advanced',
                'desc'             => 'Upload an image for this page\'s banner. If an image isn\'t uploaded,
                                       the default image set in Appearance->Theme Options will be used. Recommended dimensions: 2000x340',
                'max_file_uploads' => 1,
            ],
        ],
    ];

    return $meta_boxes;
}

add_filter('rwmb_meta_boxes', __NAMESPACE__ . '\\register_metaboxes');
