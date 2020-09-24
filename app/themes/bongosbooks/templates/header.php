<?php

use TMProd\Base\Extras;

$logo = Extras\get_theme_logo();

?>
<header class="site-header">
    <?php echo Extras\is_homepage() ? '<h1 class="site-title">' : '<div class="site-title">'; ?>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <?php if ( $logo ) {
            echo $logo;
        } ?>
    </a>
    <?php echo Extras\is_homepage() ? '</h1>' : '</div>'; ?>
    <div class="mast">
        <div class="container">

            <div class="woocommerce-links">
                <?php if ( is_user_logged_in() ) { ?>
                    <a href="<?= get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="my-account" title="<?php _e('My Account','woothemes'); ?>"><?php _e('My Account','woothemes'); ?></a>
                <?php } else { ?>
                    <a href="<?= get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="login" title="<?php _e('Login / Register','woothemes'); ?>"><?php _e('Login','woothemes'); ?></a>
                <?php } ?>
				<!-- venkate -->
				<?php global $woocommerce;
if ( $woocommerce->cart->get_cart_contents_count() != 0 ) { ?>
 <a class="your-class-name" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"
title="<?php _e('Cart View', 'woothemes'); ?>"><i class="fa fa-shopping-basket" aria-hidden="true"></i>
<?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'),
 $woocommerce->cart->cart_contents_count);?>  -
<?php echo $woocommerce->cart->get_cart_total(); } ?>
</a>
				<!-- en -->
            </div>

            <nav class="primary-navigation">
                    <a href="javascript:void(0)" class="navigation-toggle" id="js-toggle-nav-main">
                    <span class="menu-icon">
                        <span class="bar one"></span>
                        <span class="bar two"></span>
                        <span class="bar three"></span>
                    </span>
                    </a>
                    <?php
                    if ( has_nav_menu( 'primary_menu' ) ) :
                        $args = array(
                            'menu_class'     => 'navigation-menu',
                            'menu_id'        => 'js-primary-nav',
                            'theme_location' => 'primary_menu',
                            'container'      => false,
                        );
                        wp_nav_menu( $args );
                    endif;
                    ?>
            </nav>
        </div>
    </div>
    <?php if ( is_active_sidebar( 'header-widgets' ) ): ?>
        <div class="header-widgets">
            <?php dynamic_sidebar( 'header-widgets' ) ?>
        </div>
    <?php endif; ?>
</header>