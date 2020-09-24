<?php if ( ! have_posts() ) : ?>
	<p><?php _e( 'Sorry, no results were found.', 'tmbase' ); ?></p>
	<?php get_search_form(); ?>
<?php endif; ?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'templates/content', 'search' ); ?>
<?php endwhile; ?>

<?php get_template_part( 'templates/pagination' ) ?>