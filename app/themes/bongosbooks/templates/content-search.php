<article <?php post_class( 'excerpt' ); ?>>
    <header>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    </header>
    <section>
        <?php the_excerpt(); ?>
    </section>
</article>