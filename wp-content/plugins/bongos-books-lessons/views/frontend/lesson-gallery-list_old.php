<?php
use TMProd\Base\Assets;
use BongosBooks\Lessons\Taxonomies\Subject;
use TMProd\Base\Options;

?>

<div class="category-lesson-blocks">
    <?php
    foreach ($lessons as $lesson) :
        $subject_list = array();

        $subjects = get_terms([
            'taxonomy'   => Subject::TERM_ID,
            'hide_empty' => false,
        ]);

        $terms = get_the_terms($lesson->ID, Subject::TERM_ID);

        $icons = rwmb_meta('_bongosbooks_subject_category_icon', array('object_type' => 'term'), $terms[0]->term_id);

        $color = rwmb_meta('_bongosbooks_subject_category_color', array('object_type' => 'term'), $terms[0]->term_id);

        $default_thumb = Options\get_option('tmbase_default_thumb', 'https://placehold.it/250x250');

        $thumb = has_post_thumbnail($lesson->ID) ? get_the_post_thumbnail_url($lesson->ID) : $default_thumb;

        foreach ($terms as $term) {
            $subject_list[] = $term->term_id;
        }

        $post_classes = array('lesson');

        if(wc_memberships_is_post_content_restricted($lesson->ID)) {
            $post_classes[] = 'restricted-content';
        }

        ?>
        <div <?php post_class($post_classes) ?> data-categories="<?= implode(",", $subject_list) ?>" style="border-color: <?= $color ?>; background-image: url(<?= $thumb ?>)">
            <a href="<?= get_the_permalink($lesson->ID) ?>">
                <h4 style="background-color: <?= $color ?>">
                    <?= $lesson->post_title ?>
                    <?php foreach ($icons as $icon) : ?>
                        <img src="<?= $icon['full_url'] ?>" class="category-icon" alt="<?= $terms[0]->name ?>">
                    <? endforeach; ?>
                </h4>
            </a>
        </div>
    <?php endforeach; ?>
</div>