<?php

namespace BongosBooks\Lessons\PostTypes;

use BongosBooks\Lessons\Taxonomies\Subject;
use BongosBooks\Lessons\TemplateEngine;
use TMProd\Base\Options;
use BongosBooks\Lessons\Core;

class Lesson extends PostType
{
    const METABOX_PREFIX = '_bongos_books_lesson_metabox_';

    const POST_TYPE = 'bongos_books_lesson';

    public function __construct()
    {
        add_action('init', array($this, 'register_post_type'));
        add_action('rwmb_meta_boxes', array($this, 'register_metaboxes'));
        add_filter('the_content', array($this, 'populate_lessons_page'), 5);
        add_filter('the_content', array($this, 'add_lesson_quiz'), 10);
        add_filter('the_content', array($this, 'add_lesson_navigation'), 20);
        add_filter('pre_get_posts', array($this, 'add_lesson_post_type'));
    }

    public function register_post_type()
    {
        $labels = array(
            'name'              => _x('Lessons', 'Post Type General Name', Core::TEXT_DOMAIN),
            'singular_name'     => _x('Lesson', 'Post Type Singular Name', 'text_domain'),
            'menu_name'         => __('Lessons', 'text_domain'),
            'name_admin_bar'    => __('Lessons', 'text_domain'),
            'archives'          => __('Lesson Archives', 'text_domain'),
            'attributes'        => __('Lesson Attributes', 'text_domain'),
            'parent_item_colon' => __('Parent Item:', 'text_domain'),
            'all_items'         => __('All Lessons', 'text_domain'),
            'add_new_item'      => __('Add New Lesson', 'text_domain'),
            'add_new'           => __('Add New', 'text_domain'),
            'new_item'          => __('New Lesson', 'text_domain'),
            'edit_item'         => __('Edit Lesson', 'text_domain'),
            'update_item'       => __('Update Lesson', 'text_domain'),
            'view_item'         => __('View Lesson', 'text_domain'),
            'view_items'        => __('View Lessons', 'text_domain'),
        );
        $args = array(
            'label'               => __('Lesson', 'text_domain'),
            'description'         => __('Lessons', 'text_domain'),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'excerpt', 'thumbnail', 'comments'),
            'taxonomies'          => array('post_tag', Subject::TERM_ID),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-welcome-learn-more',
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
     *  Register metaboxes for lessons
     */
    public function register_metaboxes($meta_boxes)
    {
        /**
         * Quiz Questions Metabox
         */
        $meta_boxes[] = [
            'title'      => __('Quiz Questions'),
            'post_types' => [static::POST_TYPE],
            'context'    => 'normal',
            'priority'   => 'high',
            'autosave'   => true,
            'fields'     => [
                [
                    'id'         => static::METABOX_PREFIX . 'quiz',
                    'type'       => 'group',
                    'clone'      => true,
                    'sort_clone' => true,
                    'sortable'   => true,
                    'fields'     => [
                        [
                            'id'          => static::METABOX_PREFIX . 'quiz_question',
                            'type'        => 'text',
                            'name'        => esc_html__('Question', Core::TEXT_DOMAIN),
                            'desc'        => __('Enter the question.', Core::TEXT_DOMAIN),
                            'placeholder' => __('Enter a question', Core::TEXT_DOMAIN),
                            'size'        => 75,
                        ],
                        [
                            'id'     => static::METABOX_PREFIX . 'quiz_answers',
                            'type'   => 'group',
                            'name'   => esc_html__('Answers', Core::TEXT_DOMAIN),
                            'desc'   => __('Add question answer choices.', Core::TEXT_DOMAIN),
                            'clone'  => true,
                            'fields' => [
                                [
                                    'id'   => static::METABOX_PREFIX . 'quiz_answer_choice',
                                    'type' => 'text',
                                    'name' => esc_html__('Answer', Core::TEXT_DOMAIN),
                                    'desc' => __('Enter an answer.', Core::TEXT_DOMAIN),
                                ],
                                [
                                    'id'   => static::METABOX_PREFIX . 'quiz_answer_choice_correct',
                                    'type' => 'checkbox',
                                    'name' => esc_html__('Correct?', Core::TEXT_DOMAIN),
                                    'desc' => __('Mark answer as correct.', Core::TEXT_DOMAIN),
                                    'std'  => 0,
                                ],
                                [
                                    'id'   => static::METABOX_PREFIX . 'quiz_answer_choice_message',
                                    'type' => 'textarea',
                                    'name' => esc_html__('Answer Message', Core::TEXT_DOMAIN),
                                    'desc' => __('Enter a message to be displayed if this answer is selected (Optional).', Core::TEXT_DOMAIN),
                                    'std'  => __('You selected an answer! Click Next to continue.', Core::TEXT_DOMAIN),
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $meta_boxes[] = [
            'title'      => __('Character'),
            'post_types' => [static::POST_TYPE],
            'context'    => 'normal',
            'priority'   => 'high',
            'autosave'   => true,
            'fields'     => [
                [
                    'id'      => static::METABOX_PREFIX . 'character_link',
                    'name'    => esc_html__('Character Link', Core::TEXT_DOMAIN),
                    'desc'    => __('Select all characters involved in this lesson.', Core::TEXT_DOMAIN),
                    'type'    => 'checkbox_list',
                    'options' => Character::build_character_array()
                ],
            ],
        ];

        $meta_boxes[] = [
            'title'      => __('Featured Lesson'),
            'post_types' => [static::POST_TYPE],
            'context'    => 'normal',
            'priority'   => 'high',
            'autosave'   => true,
            'fields'     => [
                [
                    'id'   => static::METABOX_PREFIX . 'featured',
                    'type' => 'checkbox',
                    'name' => esc_html__('Featured Lesson', Core::TEXT_DOMAIN),
                    'desc' => __('Is the lesson featured?', Core::TEXT_DOMAIN),
                ],
            ],
        ];

        $meta_boxes[] = [
            'title'      => __('Page Banner'),
            'post_types' => [static::POST_TYPE],
            'context'    => 'normal',
            'priority'   => 'high',
            'autosave'   => true,
            'fields'     => [
                [
                    'id'   => static::METABOX_PREFIX . 'banner_background',
                    'type' => 'image_advanced',
                    'name' => esc_html__('Banner Background', Core::TEXT_DOMAIN),
                    'desc' => __('Upload an image for use as the banner background.', Core::TEXT_DOMAIN),
                ],
                [
                    'id'   => static::METABOX_PREFIX . 'banner_title',
                    'type' => 'text',
                    'name' => esc_html__('Banner Title', Core::TEXT_DOMAIN),
                    'desc' => __('Add a page title (optional).', Core::TEXT_DOMAIN),
                ],
            ],
        ];

        return $meta_boxes;
    }

    /**
     *  Check if the current page is a lesson
     *
     * @return bool
     */
    public function is_a_lesson()
    {
        return is_singular(self::POST_TYPE);
    }

    public function add_lesson_post_type($query)
    {
        if ((is_category() || is_tag()) && $query->is_archive() && empty($query->query_vars['suppress_filters'])) {
            $query->set('post_type', array(
                'post', self::POST_TYPE,
            ));
        }

        return $query;
    }

    /**
     *  Populate the lessons page with all lessons
     *
     * @param $content
     * @return string
     */
    public function populate_lessons_page($content)
    {
        if (is_page(get_page_by_title('Lessons'))) {
            return $content . TemplateEngine::render('frontend/lesson-gallery-list', array(
                    'lessons' => static::get_all(),
                ), false);
        } else {
            return $content;
        }
    }

    public function add_lesson_quiz($content)
    {
        if ($this->is_a_lesson() && !is_admin() && $this->display_quiz_condition()) {
            return $content . TemplateEngine::render('frontend/lesson-quiz', array(
                    'quizes'                 => get_post_meta(get_the_ID(), '_bongos_books_lesson_metabox_quiz', true),
                    'wrong_answer_message'   => Options\get_option('tmbase_default_wrong_message'),
                    'correct_answer_message' => Options\get_option('tmbase_default_correct_message'),
                ), false);
        } else {
            return $content;
        }
    }

    public function add_lesson_navigation($content)
    {
        if ($this->is_a_lesson() && !is_admin()) {
            global $post;
            $current_post_date = $post->post_date;

            $next_post = $this->get_adjacent_lesson($post, 'after');
            $prev_post = $this->get_adjacent_lesson($post, 'before');

            return $content . TemplateEngine::render('frontend/lesson-navigation', array(
                    'previous'  => $prev_post,
                    'next'      => $next_post,
                    'char_id' => get_post_meta($post->ID, static::METABOX_PREFIX . 'character_link')
        ), false);
        } else {
            return $content;
        }
    }

    public function get_adjacent_lesson($post, $direction = 'after')
    {
        $character_id = get_post_meta(get_the_ID(), static::METABOX_PREFIX . 'character_link');
        $args = array(
            'posts_per_page' => 1,
            'post_type'      => static::POST_TYPE,
            'orderby'        => 'post_date',
            'order'          => $direction == 'after' ? 'ASC' : 'DESC',
            'meta_query'     => array(
                array(
                    'key'   => static::METABOX_PREFIX . 'character_link',
                    'value' => $character_id,
                ),
            ),
            'date_query'     => array(
                $direction => $post->post_date,
            ),
        );
        $results = get_posts($args);

        return $results ? $results[0] : null;
    }

    public function display_quiz_condition()
    {
        if (wc_memberships_is_user_active_member(null, 'premium-membership-plan') || !wc_memberships_is_post_content_restricted()) {
            return true;
        };

        return false;
    }
}