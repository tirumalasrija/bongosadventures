<?php

use TMProd\Base\Setup;
use TMProd\Base\Wrapper;

?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<?php get_template_part( 'templates/head' ); ?>
<body <?php body_class(); ?>>
<?php do_action( 'before_body' ); ?>
<div class="site-wrap">
    <!--[if lt IE 9]>
    <div class="alert alert-warning">
        <?php _e( 'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
        your browser</a> to improve your experience.', 'tmbase' ); ?>
    </div>
    <![endif]-->
    <?php
    do_action( 'get_header' );
    get_template_part( 'templates/header' );
    ?>
    <?php do_action('tmbase_before_main'); ?>
    <main>
        <?php if( Setup\display_rotator()): ?>
            <?php include Wrapper\rotator_path(); ?>
        <?php else: ?>
            <?php
                    if(is_singular('character')) {
                        get_template_part( 'templates/page', 'header-characters' ); }
                    else {
                        get_template_part( 'templates/page', 'header' );
                    }
            ?>
        <?php endif; ?>
        <?php do_action('tmbase_before_page_wrap'); ?>
        <?php if(is_page('home')) { get_template_part( 'templates/homepage/characters' );
                                    get_template_part( 'templates/homepage/newsletter' );
                                    get_template_part( 'templates/homepage/featured-lessons' );
                                    get_template_part( 'templates/homepage/cat-slider' );
        } ?>
        <div class="page-wrap">
            <div class="container">
                <?php do_action('tmbase_before_page_content'); ?>
                <div class="content">
                    <?php if(!is_singular('character')) {
                        include Wrapper\template_path();
                    } ?>
                </div>
                <?php if( Setup\display_sidebar() ) : ?>
                    <?php include Wrapper\sidebar_path(); ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if(is_singular('character')) {
            include Wrapper\template_path();
        } ?>
        <?php do_action('tmbase_after_page_wrap'); ?>
    </main>
    <?php do_action('tmbase_after_main'); ?>
    <?php
    do_action( 'get_footer' );
    get_template_part( 'templates/footer' ); ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
