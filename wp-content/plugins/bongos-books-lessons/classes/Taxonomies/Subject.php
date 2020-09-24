<?php

namespace BongosBooks\Lessons\Taxonomies;

use BongosBooks\Lessons\PostTypes\Lesson;
use BongosBooks\Lessons\Core;

class Subject
{
    const METABOX_PREFIX = '_bongosbooks_subject_';

    const TERM_ID = 'bongosbooks_subject';

    /**
     *  Subject constructor
     */
    public function __construct()
    {
        add_action('init', array($this, 'register_taxonomy'));
        add_action('rwmb_meta_boxes', array($this, 'register_metaboxes'));
    }

    /**
     *  Registers the Subject taxonomy.
     */
    public function register_taxonomy()
    {
        $labels = array(
            'name'                       => _x('Subjects', 'Taxonomy General Name', 'bongosbooks'),
            'singular_name'              => _x('Subject', 'Taxonomy Singular Name', 'bongosbooks'),
            'menu_name'                  => __('Subjects', 'bongosbooks'),
            'all_items'                  => __('All Subjects', 'bongosbooks'),
            'parent_item'                => __('Parent Item', 'bongosbooks'),
            'parent_item_colon'          => __('Parent Item:', 'bongosbooks'),
            'new_item_name'              => __('New Subject', 'bongosbooks'),
            'add_new_item'               => __('Add New Subject', 'bongosbooks'),
            'edit_item'                  => __('Edit Subject', 'bongosbooks'),
            'update_item'                => __('Update Subject', 'bongosbooks'),
            'view_item'                  => __('View Subject', 'bongosbooks'),
            'separate_items_with_commas' => __('Separate characters with commas', 'bongosbooks'),
            'add_or_remove_items'        => __('Add or remove characters', 'bongosbooks'),
            'choose_from_most_used'      => __('Choose from the most used', 'bongosbooks'),
            'popular_items'              => __('Popular Subjects', 'bongosbooks'),
            'search_items'               => __('Search Subjects', 'bongosbooks'),
            'not_found'                  => __('Not Found', 'bongosbooks'),
            'no_terms'                   => __('No Subjects', 'bongosbooks'),
            'items_list'                 => __('Subjects list', 'bongosbooks'),
            'items_list_navigation'      => __('Subjects list navigation', 'bongosbooks'),
        );
        $args = array(
            'labels'            => $labels,
            'rewrite'           => array('slug' => 'subject'),
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => true,
            'show_in_rest'      => true,
        );
        register_taxonomy(static::TERM_ID, array(Lesson::POST_TYPE), $args);
    }

    /**
     *  Register metaboxes for Subject taxonomy
     */
    public function register_metaboxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title'      => __('Category Icon', Core::TEXT_DOMAIN),
            'taxonomies' => static::TERM_ID,
            'context'    => 'normal',
            'priority'   => 'high',
            'autosave'   => true,
            'fields'     => [
                [
                    'name' => __('Upload an Icon'),
                    'id'   => static::METABOX_PREFIX . 'category_icon',
                    'type' => 'image_advanced',
                ],
            ],
        ];

        $meta_boxes[] = [
            'title'      => __('Category Color', Core::TEXT_DOMAIN),
            'taxonomies' => static::TERM_ID,
            'context'    => 'normal',
            'priority'   => 'high',
            'autosave'   => true,
            'fields'     => [
                [
                    'name' => __('Choose a Color'),
                    'id'   => static::METABOX_PREFIX . 'category_color',
                    'type' => 'color',
                    'js_options'    => array(
                        'palettes' => array( '#D18B0C', '#961D8C', '#39ACDD', '#78B932' )
                    ),
                ],
            ],
        ];

        $meta_boxes[] = [
            'title'      => __('Page Banner', Core::TEXT_DOMAIN),
            'taxonomies' => static::TERM_ID,
            'context'    => 'normal',
            'priority'   => 'high',
            'autosave'   => true,
            'fields'     => [
                [
                    'name' => __('Upload a page banner', Core::TEXT_DOMAIN),
                    'id'   => static::METABOX_PREFIX . 'banner_background',
                    'type' => 'image_advanced',
                ],
            ],
        ];

        return $meta_boxes;
    }

    /**
     *  Check if this is a character taxonomy page
     *
     * @return bool
     */
    public function is_a_subject()
    {
        return is_tax(static::TERM_ID);
    }

    /**
     *  Returns all characters.
     *
     * @param bool $hide_empty
     * @return array|int|\WP_Error
     */
    public static function get_all_subjects($hide_empty = true)
    {
        $terms = get_terms(array(
            'taxonomy'   => self::TERM_ID,
            'hide_empty' => $hide_empty,
        ));

        if (is_wp_error($terms) || !is_array($terms)) {
            return array();
        }

        return $terms;
    }
}