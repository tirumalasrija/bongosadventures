<?php

use TMProd\Base\Options;
use TMProd\Base\Assets;

// Get the rotator settings from Theme Options
$banners = get_post_meta(get_the_ID(), 'tmbase_rotator', true);
$height = Options\get_option('tmbase_rotator_height');
$width = Options\get_option('tmbase_rotator_width');
?>

<?php if (!empty($banners)) { ?>
    <div class="rotator-wrap <?php echo count($banners) > 1 ? 'enabled' : ''; ?>">
        <?php if (count($banners) > 1): ?>
            <a id="js-rotator-prev" class="rotator-prev" href="javascript:void(0)">
                <?php echo file_get_contents(Assets\asset_path('images/icon-chevron-left.svg')); ?>
            </a>
        <?php endif ?>
        <div id="js-rotator" class="rotator <?php echo count($banners) > 1 ? 'owl-carousel' : ''; ?>">
            <?php foreach ($banners as $banner) {
                // Get the banner image source by the attachment post id
                $image_src = '';
                if (isset($banner['tmbase_rotator_background_id'])) {
                    $image = wp_get_attachment_image_src($banner['tmbase_rotator_background_id'][0], array($width, $height));
                    $image_src = is_array($image) ? $image[0] : '';
                } ?>
                <div class="banner" <?php echo $image_src ? 'style="background-image: url(' . $image_src . '); height: ' . $height . 'px;"' : '' ?>>
                    <div class="container">
                        <?php echo isset($banner['tmbase_rotator_title']) ? '<h2>' . $banner['tmbase_rotator_title'] . '</h2>' : ''; ?>
                        <?php echo isset($banner['tmbase_rotator_content']) ? '<p class="large">' . $banner['tmbase_rotator_content'] . '</p>' : ''; ?>
                        <a href="<?= get_permalink(get_page_by_title('Lessons')) ?>" class="button">Start Your Adventure</a>

                        <?php $lessons = get_posts(array(
                            'post_type'   => 'bongos_books_lesson',
                            'numberposts' => 1,
                            'meta_query'  => array(
                                array(
                                    'key'   => '_bongos_books_lesson_metabox_featured',
                                    'value' => 1,
                                ),
                            ),
                        ));

                     //   foreach ($lessons as $lesson) : 
                     ?>
                         
                        <?php //endforeach; ?>

                    </div>
                    <?php $overlay_image = current(wp_get_attachment_image_src($banner['tmbase_rotator_image_overlay'][0], 'full')); ?>
                    <?php echo isset($banner['tmbase_rotator_image_overlay']) ? '<img class="overlay-image" src="' . $overlay_image . '">' : ''; ?>
                </div>
            <?php } ?>
        </div>
        <?php if (count($banners) > 1): ?>
            <a id="js-rotator-next" class="rotator-next" href="javascript:void(0)">
                <?php echo file_get_contents(Assets\asset_path('images/icon-chevron-right.svg')); ?>
            </a>
        <?php endif ?>
    </div>
<?php } ?>
