<?php

use TMProd\Base\Extras;

$logo = Extras\get_theme_logo();

?>
<style>
	a.cart-contents{
		line-height: 2.3em;
		margin-left: 20px;
	}
	.woocommerce-error strong{ padding-left: 35px;}
	.woocommerce-ordering{
		display:none;
	}
.cart-contents:before {
    font-family:WooCommerce;
    content: "\e01d";
    font-size:28px;
    margin-top:10px;
    font-style:normal;
    font-weight:400;
    padding-right:5px;
    vertical-align: bottom;
}
.cart-contents:hover {
    text-decoration: none;
}
.cart-contents-count {
    color: #fff;
    background-color: #0a6064;
    font-weight: bold;
    border-radius: 10px;
    padding: 1px 6px;
    line-height: 1;
    font-family: Arial, Helvetica, sans-serif;
    vertical-align: top;
}
</style>
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
                    <!-- <a href="<?= get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="login" title="<?php _e('Login / Register','woothemes'); ?>"><?php _e('Login','woothemes'); ?></a> -->
		 <a href="http://bongosbooks.com/my-account/" class="login" title="<?php _e('Login / Register','woothemes'); ?>"><?php _e('Login','woothemes'); ?></a>		
                <?php } ?>
				
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
				<!-- venkate -->
			<!--	<?php //global $woocommerce;
//if ( $woocommerce->cart->get_cart_contents_count() != 0 ) { ?>
 <a class="" href="<?php //echo $woocommerce->cart->get_cart_url(); ?>"
title="<?php// _e('Cart View', 'woothemes'); ?>">
<img src="http://universitiesconnect.com/wp-content/uploads/2019/03/34387-1-e1551525005803.png" />
	 <span class="numberCircle"><?php //echo sprintf(_n('%d item', '%d', //$woocommerce->cart->cart_contents_count, 'woothemes'),
 //$woocommerce->cart->cart_contents_count);?></span>
<?php//  $woocommerce->cart->get_cart_total(); }else{ ?> <img src="http://universitiesconnect.com/wp-content/uploads/2019/03/34387-1-e1551525005803.png" /> 0<?php // } ?>
</a> -->
				<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php 
    if ( $count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php
    }
        ?></a>
 
<?php } ?>
				<!-- en -->
            </nav>
        </div>
    </div>
    <?php if ( is_active_sidebar( 'header-widgets' ) ): ?>
        <div class="header-widgets">
            <?php dynamic_sidebar( 'header-widgets' ) ?>
        </div>
    <?php endif; ?>
</header>
