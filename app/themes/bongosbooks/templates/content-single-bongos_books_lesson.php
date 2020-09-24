<?php while ( have_posts() ) : the_post(); ?>
    <div <?php post_class(); ?>>

        <?php if ( has_post_thumbnail() ) { ?>
            <div class="featured-image">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php } ?>

        <?php the_content(); ?>

        <?php comments_template( '/templates/comments.php' ); ?>

        <?php get_template_part( 'templates/pagination' ); ?>

    </div>
<?php endwhile; ?>
