<?php

use TMProd\Base\Options;

$default_thumb = Options\get_option('tmbase_default_thumb', 'https://placehold.it/250x250');

$thumb = has_post_thumbnail() ? get_the_post_thumbnail_url() : $default_thumb;

$term = wp_get_post_terms(get_the_ID(), 'bongosbooks_subject');

$icons = rwmb_meta('_bongosbooks_subject_category_icon', array('object_type' => 'term'), $term[0]->term_id);

$color = rwmb_meta( '_bongosbooks_subject_category_color', array('object_type' => 'term'), $term[0]->term_id );

$post_classes = array('lesson');

 $has_sub1 = wcs_user_has_subscription( get_current_user_id(), 389, 'active' );  
					$has_sub2 = wcs_user_has_subscription( get_current_user_id(), 361, 'active' );  
	
	
					 
					//echo "<pre>"; 
					//var_dump(wc_memberships_is_user_active_member(null, 'premium-membership-plan'));
					//var_dump(wc_memberships_is_post_content_restricted($lesson->ID)); 
                  //  if(wc_memberships_is_post_content_restricted($lesson->ID)) {
					  	  if (empty($has_sub1)&&empty($has_sub2)  ) {
							  if(wc_memberships_is_post_content_restricted($lesson->ID)) {
                        $post_classes[] = 'restricted-content';
							  }
                    }

?>

<article <?php post_class($post_classes); ?> style="border-color: <?= $color ?>; background-image: url(<?= $thumb ?>)">
    <a href="<?php the_permalink(); ?>">
        <header>
            <h4 style="background-color: <?= $color ?>"><?php the_title(); ?>
                <?php foreach ($icons as $icon) : ?>
                    <img src="<?= $icon['full_url'] ?>" class="category-icon" alt="<?= $term[0]->name ?>" />
                <?php endforeach; ?>
            </h4>
        </header>
    </a>
</article>