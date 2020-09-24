<section class="characters">
    <div class="container">
        <div class="character-blocks">
            <?php $characters = get_posts(array(
                'posts_per_page' => -1,
                'post_type'      => 'character',
                'hide_empty'     => true,
                'order'         => 'ASC'
            ));

            foreach ($characters as $character) :
                $color = get_post_meta($character->ID, '_bongosbooks_character_character_color', true);
                $character_image_id = get_post_meta($character->ID, '_bongosbooks_character_character_image', true);
                $character_image = wp_get_attachment_image_url($character_image_id, 'full'); ?>
                <a class="block" href="<?= get_permalink($character->ID) ?>">
                    <img src="<?= $character_image ?>" alt="<?= $character->post_title ?>">
                    <h4 style="background-color: <?= $color ?>">Meet <?= $character->post_title ?></h4>
                    <div class="block-button">See what <?= $character->post_title ?> is up to today</div>
                </a>

            <?php endforeach; ?>
        </div>
    </div>
</section>