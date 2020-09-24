<?php

$post_classes = array('lesson');

?>

<div class="lessons">
    <?php if (count($lessons)) : ?>
        <?php foreach ($lessons as $lesson) :
            $post_classes = array('lesson', 'excerpt');
			
           // if (wc_memberships_is_post_content_restricted()) {
			   $has_sub1 = wcs_user_has_subscription( get_current_user_id(), 389, 'active' );  
					$has_sub2 = wcs_user_has_subscription( get_current_user_id(), 361, 'active' ); 
        //if(wc_memberships_is_post_content_restricted($lesson->ID)) {
			 if (empty($has_sub1)&&empty($has_sub2)  ) {
                if(wc_memberships_is_post_content_restricted($lesson->ID)) {
                        $post_classes[] = 'restricted-content';
							  }
            } ?>
            <article <?php post_class($post_classes) ?>>
                <div class="lesson-thumbnail featured-image">
                    <img class="lesson-thumbnail-image" src="<?= get_the_post_thumbnail_url($lesson->ID) ? get_the_post_thumbnail_url($lesson->ID) : $default_thumbnail ?>"/>
                </div>
                <div class="lesson-content post-content">
                    <a href="<?= get_the_permalink($lesson->ID) ?>">
                        <h3 class="lesson-title"><?= $lesson->post_title; ?></h3>
                    </a>
                    <p><?= $lesson->post_content ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</div>