<?php
/**
 * Page Header
 * Serves as an "internal banner".
 * Displays the page title & might include a breadcrumb or postmeta.
 */

use TMProd\Base\Extras as Extras;
use TMProd\Base\Options as Options;

if (is_home()) {
    $postID = get_option('page_for_posts');
} else {
    $postID = get_the_ID();
}

$default_banner_id = Options\get_option('tmbase_default_banner', 'https://placehold.it/250x2000');
$default_banner = wp_get_attachment_image_url(current($default_banner_id), 'full');
$assigned_banner_id = get_post_meta($postID, 'tmbase_banner_background_id', true);
$assigned_banner = wp_get_attachment_image_url($assigned_banner_id, 'full');
$banner_title = get_post_meta($postID, '_bongos_books_lesson_metabox_banner_title', true);

$banner = $assigned_banner ? $assigned_banner : $default_banner;
?>
<header class="page-header" style="background-image: linear-gradient(
    rgba(0, 0, 0, 0.5),
    rgba(0, 0, 0, 0.5)
    ), url(<?php echo $banner ?>);">
    <div class="container">
        <div class="page-header-content">
            <div class="title-area">
                <h1 class="internal-page-title"><?= $banner_title ? $banner_title : Extras\get_page_title(); ?></h1>
            </div>
            <?php get_template_part('templates/breadcrumbs'); ?>
        </div>
    </div>
    <div id="page-header-gradient-trim" class="gradient-trim"></div>
</header>
