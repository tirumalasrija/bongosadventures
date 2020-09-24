<?php
/**
 * Characters Page Header
 * Serves as an "internal banner".
 * Displays the page title & might include a breadcrumb or postmeta.
 */

use TMProd\Base\Options as Options;

$page_id = get_the_ID();

$default_featured_image = 'https://placehold.it/500x500';
$default_banner = Options\get_option('tmbase_default_banner', 'https://placehold.it/2000x250');
$character_image_id = get_post_meta($page_id, '_bongosbooks_character_character_image', true);
$character_image = wp_get_attachment_image_url($character_image_id, 'full');
$assigned_banner_id = get_post_meta($page_id, '_bongosbooks_character_banner_background', true);
$assigned_banner = wp_get_attachment_image_url($assigned_banner_id, 'full');
$color = get_post_meta($page_id, '_bongosbooks_character_character_color', true);

$banner = $assigned_banner ? $assigned_banner : $default_banner;

$post = get_post($page_id);

?>
<header class="page-header character-archive" style="background-image: url(<?= $banner ?>);">
    <div class="container">
        <div class="page-header-content">
            <?php if ($character_image) { ?>
                <div class="featured-image">
                    <img src="<?= $character_image ?>" alt="Character Image"/>
                </div>
            <?php } ?>

            <div class="intro-box">
                <h1 class="page-title" style="background-color: <?= $color ?>">Meet <?= $post->post_title ?>!</h1>
                <div class="intro-content">
                    <?= wpautop(do_shortcode($post->post_content)) ?>
                </div>
            </div>

        </div>
        <div class="bongo-status-box">
            <?php
            $recent_lessons = get_posts(array(
                'post_type'   => 'bongos_books_lesson',
                'numberposts' => 1,
                'order'       => 'ASC',
                'meta_query'  => array(
                    array(
                        'key'   => '_bongos_books_lesson_metabox_character_link',
                        'value' => $post->ID,
                    ),
                ),
            ));
            ?>
            <?php foreach ($recent_lessons as $lesson) : ?>
                <?php $thumbnail = get_the_post_thumbnail_url($lesson->ID) ? get_the_post_thumbnail_url($lesson->ID) : $default_featured_image ?>
                <img src="<?= $thumbnail ?>" class="status-image" alt="<?= $lesson->post_title ?>"/>
                <div class="status-content">
                    <h4>What's <?= $post->post_title ?> up to today?</h4>
                    <h2><?= $lesson->post_title ?></h2>
                    <a href="<?= get_the_permalink($lesson->ID) ?>" class="button">Read More</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</header>
