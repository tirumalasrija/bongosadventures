<?php

use TMProd\Base\Assets;
use TMProd\Base\Options;

global $post;

$post_id = get_the_ID();

$color = get_post_meta(get_the_ID(), '_bongosbooks_character_character_color', true);

$character_posts = get_posts(array(
    'post_type'   => 'bongos_books_lesson',
    'numberposts' => -1,
    'order'       => 'ASC',
    'meta_query'  => array(
        array(
            'key'   => '_bongos_books_lesson_metabox_character_link',
            'value' => $post->ID,
        ),
    ),
));

do_action('insert_additional_content'); ?>

<div class="page-wrap">
    <div class="container">
        <?php comments_template('/templates/comments.php'); ?>

        <section class="internal-lesson-slider">
            <h2 style="background-color: <?= $color ?>">Follow along with <?= $post->post_title ?></h2>
            <div class="lesson-blocks">
                <?php foreach ($character_posts as $character_post) : setup_postdata($character_post->ID);

                    $default_thumb = Options\get_option('tmbase_default_thumb', 'https://placehold.it/250x250');

                    $thumb = has_post_thumbnail($character_post->ID) ? get_the_post_thumbnail_url($character_post->ID) : $default_thumb;

                    $term = wp_get_post_terms($character_post->ID, 'bongosbooks_subject');

                    $icons = rwmb_meta('_bongosbooks_subject_category_icon', array('object_type' => 'term'), $term[0]->term_id);

                    $color = rwmb_meta('_bongosbooks_subject_category_color', array('object_type' => 'term'), $term[0]->term_id);

                    ?>

                    <article <?php post_class('lesson'); ?> style="border-color: <?= $color ?>; background-image: url(<?= $thumb ?>)">
                        <a href="<?= get_permalink($character_post->ID); ?>">
                            <header>
                                <h4 style="background-color: <?= $color ?>"><?= $character_post->post_title ?>
                                    <?php foreach ($icons as $icon) : ?>
                                        <img src="<?= $icon['full_url'] ?>" class="category-icon" alt="<?= $term[0]->name ?>"/>
                                    <? endforeach; ?>
                                </h4>
                            </header>
                        </a>
                    </article>

                    <?php wp_reset_postdata(); ?>
                <?php endforeach; ?>
            </div>
        </section>

    </div>
</div>