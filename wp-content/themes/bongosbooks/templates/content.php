<article <?php post_class( 'excerpt' ); ?>>

    <?php if ( has_post_thumbnail() ) { ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="blog-thumb"><?php the_post_thumbnail( 'small' ); ?></a>
    <?php } ?>

    <div class="article-content">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php get_template_part( 'templates/entry-meta' ); echo the_excerpt(); ?>
        <a href="<?php the_permalink(); ?>" title="<?php echo __( 'Continue reading ' ) . get_the_title(); ?>" class="button">Read more</a>
    </div>
</article>