<?php

namespace BongosBooks\Lessons;

use BongosBooks\Lessons\PostTypes\Character;
use BongosBooks\Lessons\PostTypes\Lesson;
use BongosBooks\Lessons\Taxonomies\Subject;

class Core
{
    /** The plugin's human-readable name. */
    const PLUGIN_NAME = 'Bongos Books Lessons';
    /** The plugin's language text domain. */
    const TEXT_DOMAIN = 'bongosbooks';
    /** The plugin's version number. */
    const VERSION = '1.0.0';
    /** An array of all custom post types used in this plugin. */
    private $post_types = array();

    private $taxonomies = array();

    public function init()
    {
        $this->post_types[] = new Character();
        $this->post_types[] = new Lesson();
        $this->taxonomies[] = new Subject();

        add_action('admin_notices', array($this, 'process_dependencies'));
        add_action('wp_enqueue_scripts', array($this, 'load_frontend_assets'));
        add_shortcode('bongosbooks_lesson_gallery', array($this, 'render_lesson_gallery'));
        add_shortcode('bongosbooks_lesson_gallery_filters', array($this, 'render_lesson_gallery_filters'));
    }

    /**
     * Check for any dependencies and display an error message in the admin if necessary.
     *
     * @since 1.0
     * @return void
     */
    public function process_dependencies()
    {
        $error_format = '<div class="error"><p>%s</p></div>';
        $metabox_installed = defined('RWMB_DIR');
        $metabox_aio_installed = is_plugin_active('meta-box-aio/meta-box-aio.php');
        if( !$metabox_installed ) {
            echo sprintf($error_format, __('Warning: The theme requires the plugin: Meta Box to function correctly.', 'tmbase'));
        } elseif( !$metabox_aio_installed ) {
            echo sprintf($error_format, __('Warning: The theme requires the plugin: Meta Box AIO to function correctly.', 'tmbase'));
        }

        if (!defined('GF_MIN_WP_VERSION')) {
            echo '<div class="error"><p>' . __('Warning: The ' . static::PLUGIN_NAME . ' plugin requires Gravity Forms to function.', static::TEXT_DOMAIN) . '</p></div>';
        }
    }

    /**
     * Callback function for plugin activation.
     *
     * @since 1.0.0
     * @return void
     */
    public function activate()
    {
        flush_rewrite_rules();
    }

    /**
     * Callback function for plugin deactivation.
     *
     * @since 1.0.0
     * @return void
     */
    public function deactivate()
    {
        flush_rewrite_rules();
    }

    /**
     *  Load frontend assets
     */
    public function load_frontend_assets()
    {
        wp_register_script('bongosbooks-lessons', plugins_url('bongos-books-lessons/assets/scripts/bongosbooks-lesson-filter.js'), array('jquery'), '1.0', true);
        wp_register_script('bongosbooks-lessons-quiz', plugins_url('bongos-books-lessons/dist/scripts/main.js'), null, '1.0', true);

        wp_enqueue_script('bongosbooks-lessons-quiz');
    }

    /**
     *  Render filters for lessons gallery (populated by existing categories)
     */
    public function render_lesson_gallery_filters()
    {
        $subjects = get_terms([
            'taxonomy' => Subject::TERM_ID,
            'hide_empty' => false,
        ]);

        TemplateEngine::render('frontend/lesson-gallery-filters', array(
            'subjects' => $subjects,
        ));
    }

    /**
     *  Render the full lessons gallery (all lessons and category filters)
     */
    public function render_lesson_gallery()
    {
        wp_enqueue_script('bongosbooks-lessons');

        $lessons = get_posts(array(
            'post_type'   => 'bongos_books_lesson',
            'numberposts' => -1,
            'orderby'     => 'post_title',
            'order'       => 'ASC',
        ));

        TemplateEngine::render('frontend/lesson-gallery-list', array(
            'lessons' => $lessons,
        ));

        TemplateEngine::render('frontend/components/lesson-gallery-button');
    }
}
