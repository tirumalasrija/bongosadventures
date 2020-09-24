<?php

namespace BongosBooks\Lessons\PostTypes;

abstract class PostType
{
    const POST_TYPE = '';

    const METABOX_PREFIX = '';

    abstract public function register_post_type();

    /**
     * Gets all posts.
     *
     * @since 1.0.0
     * @param array $args get_posts argument overrides.
     * @return array
     */
    public static function get_all($args_overrides = array())
    {
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => static::POST_TYPE,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        );
        foreach ($args_overrides as $key => $value) {
            $args[$key] = $value;
        }

        return get_posts($args);
    }
}
