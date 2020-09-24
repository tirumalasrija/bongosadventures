<?php

namespace BongosBooks\Lessons\PostTypes;

use BongosBooks\Lessons\Taxonomies\Subject;
use BongosBooks\Lessons\TemplateEngine;
use BongosBooks\Lessons\Core;

class Character extends PostType
{
    const METABOX_PREFIX = '_bongosbooks_character_';

    const POST_TYPE = 'character';

    public function __construct()
    {
        add_action('init', array($this, 'register_post_type'));
        add_action('rwmb_meta_boxes', array($this, 'register_metaboxes'));
        add_action('insert_additional_content', array($this, 'add_additional_content'));
        add_action('body_class', array($this, 'add_rotator_class'));
    }

    public function register_post_type()
    {
        $labels = array(
            'name'              => _x('Characters', 'Post Type General Name', Core::TEXT_DOMAIN),
            'singular_name'     => _x('Character', 'Post Type Singular Name', Core::TEXT_DOMAIN),
            'menu_name'         => __('Characters', Core::TEXT_DOMAIN),
            'name_admin_bar'    => __('Characters', Core::TEXT_DOMAIN),
            'archives'          => __('Character Archives', Core::TEXT_DOMAIN),
            'attributes'        => __('Character Attributes', Core::TEXT_DOMAIN),
            'parent_item_colon' => __('Parent Item:', Core::TEXT_DOMAIN),
            'all_items'         => __('All Characters', Core::TEXT_DOMAIN),
            'add_new_item'      => __('Add New Character', Core::TEXT_DOMAIN),
            'add_new'           => __('Add New', Core::TEXT_DOMAIN),
            'new_item'          => __('New Character', Core::TEXT_DOMAIN),
            'edit_item'         => __('Edit Character', Core::TEXT_DOMAIN),
            'update_item'       => __('Update Character', Core::TEXT_DOMAIN),
            'view_item'         => __('View Character', Core::TEXT_DOMAIN),
            'view_items'        => __('View Characters', Core::TEXT_DOMAIN),
        );
        $args = array(
            'label'               => __('Character', Core::TEXT_DOMAIN),
            'description'         => __('Characters', Core::TEXT_DOMAIN),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'excerpt', 'thumbnail', 'comments'),
            'taxonomies'          => array('post_tag', Subject::TERM_ID),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-universal-access-alt',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );
        register_post_type(static::POST_TYPE, $args);
    }

    /**
     *  Register metaboxes for Character post type
     */
    public function register_metaboxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title'      => __('Character Image', Core::TEXT_DOMAIN),
            'post_types' => [static::POST_TYPE],
            'context'    => 'normal',
            'priority'   => 'high',
            'autosave'   => true,
            'fields'     => [
                [
                    'name' => __('Upload the character image'),
                    'id'   => static::METABOX_PREFIX . 'character_image',
                    'type' => 'image_advanced',
                ],
            ],
        ];

        $meta_boxes[] = [
            'title'      => __('Character Color', Core::TEXT_DOMAIN),
            'post_types' => [static::POST_TYPE],
            'context'    => 'normal',
            'priority'   => 'high',
            'autosave'   => true,
            'fields'     => [
                [
                    'name'       => __('Choose a Color'),
                    'id'         => static::METABOX_PREFIX . 'character_color',
                    'type'       => 'color',
                    'js_options' => array(
                        'palettes' => array('#F4AECD', '#62C6C9', '#F9B641', '#827FA8'),
                    ),
                ],
            ],
        ];

        $meta_boxes[] = [
            'title'      => __('Additional Content', Core::TEXT_DOMAIN),
            'post_types' => [static::POST_TYPE],
            'context'    => 'normal',
            'priority'   => 'high',
            'autosave'   => true,
            'fields'     => [
                [
                    'name' => __('More About Character'),
                    'id'   => static::METABOX_PREFIX . 'character_more',
                    'type' => 'wysiwyg',
                ],
                [
                    'name' => __('Likes'),
                    'id'   => static::METABOX_PREFIX . 'character_likes',
                    'type' => 'wysiwyg',
                ],
                [
                    'name' => __('Dislikes'),
                    'id'   => static::METABOX_PREFIX . 'character_dislikes',
                    'type' => 'wysiwyg',
                ],
            ],
        ];

        $meta_boxes[] = [
            'title'      => __('Page Banner', Core::TEXT_DOMAIN),
            'post_types' => [static::POST_TYPE],
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
     *  Output "Additional Content" section on character pages
     */
    public function add_additional_content($content)
    {
        if ($this->is_a_character() && !is_admin()) {
            $post_id = get_the_ID();

            return TemplateEngine::render('frontend/character-additional-content', array(
                    'post_id'            => $post_id,
                    'character_more'     => get_post_meta($post_id, '_bongosbooks_character_character_more', true),
                    'character_likes'    => get_post_meta($post_id, '_bongosbooks_character_character_likes', true),
                    'character_dislikes' => get_post_meta($post_id, '_bongosbooks_character_character_dislikes', true),
                    'color'              => get_post_meta($post_id, '_bongosbooks_character_character_color', true),
                    'post'               => get_post($post_id),
                ), true) . $content;
        }

        return $content;
    }

    /**
     *  Check if this is a character taxonomy page
     *
     * @return bool
     */
    static public function is_a_character()
    {
        return is_singular(self::POST_TYPE);
    }

    /**
     * Add 'has_rotator' class for character tax pages
     *
     * @param $classes
     * @return array
     */
    public function add_rotator_class($classes)
    {
        if ($this->is_a_character()) {
            $classes[] = 'has-rotator';
        }

        return $classes;
    }

    /**
     *  Build an array of character ID's and their names
     */
    public static function build_character_array() {
        $characters_array = array();
        $characters = self::get_all();

        foreach($characters as $character) {
            $characters_array[$character->ID] = $character->post_title;
        }

        return $characters_array;
    }
}