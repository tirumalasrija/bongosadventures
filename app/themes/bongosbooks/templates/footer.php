<?php
    use TMProd\Base\Assets;
?>

<section class="subscribe-cta">
    <div class="container">
        <h2>Sign up to follow all of the adventures</h2>
        <p>Pick apples with Bella, play baseball with Billy, volunteer with Jayni, and have great fun with Jax. There's adventure around every corner!</p>
        <a href="<?= get_the_permalink(get_page_by_path('/join-now')) ?>" class="button">Subscribe now!</a>
    </div>
</section>

<footer class="site-footer">
    <div class="container">
        <?php if ( has_nav_menu( 'footer_menu' ) ) :
            wp_nav_menu( [
                'theme_location' => 'footer_menu',
                'menu_class'     => 'nav',
                'container'      => false
            ] );
        endif; ?>
    </div>
    <img src="<?php echo Assets\asset_path('images/boat-monkey.png'); ?>" class="overlay" alt="Monkey's at sea!">
</footer>
<?php if ( is_front_page() ) { ?>
    <p class="site-credit" itemscope itemtype="http://schema.org/Organization">
        Copyright <?php echo date("Y"); ?> &copy; Bongo's Adventures. All right reserved.
    </p>
<?php } ?>