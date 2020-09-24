<?php
/**
 * Theme includes
 *
 * The $theme_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$theme_includes = [
    'lib/options.php',        // Options
    'lib/extras.php',         // Custom functions
    'lib/setup.php',          // Theme setup
    'lib/assets.php',         // Scripts and stylesheets
    'lib/metaboxes.php',      // Metaboxes
    'lib/wrapper.php',        // Theme wrapper class
    'lib/woocommerce.php'     // WooCommerce
];

foreach( $theme_includes as $file ) {
    if( !$filepath = locate_template( $file ) ) {
        trigger_error( sprintf( __( 'Error locating %s for inclusion', 'tmbase' ), $file ), E_USER_ERROR );
    }

    require_once $filepath;
}
unset( $file, $filepath );
add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );
function custom_woocommerce_product_add_to_cart_text( $default) {
	global $product;
	
	$product_type = $product->product_type;
	
	switch ( $product_type ) {
		
		case 'subscription':
			return __( 'Subscribe', 'woocommerce' );
		break;
		default:
			return __("Add to cart" , 'woocommerce' );
		
	}
	
}
add_filter( 'add_to_cart_text', 'woo_custom_single_add_to_cart_text' );                // < 2.1
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_single_add_to_cart_text' );  // 2.1 +
  
function woo_custom_single_add_to_cart_text() {
  
   global $product;
	
	$product_type = $product->product_type;
	
	switch ( $product_type ) {
		
		case 'subscription':
			return __( 'Subscribe', 'woocommerce' );
		break;
		default:
			return __("Add to cart" , 'woocommerce' );
		
	}
  
}

add_action( 'init', 'events_post_type', 0 );
function events_post_type() {
    $labels = array(
    'name'                  => _x( 'Events', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'Events', 'text_domain' ),
    'name_admin_bar'        => __( 'Events', 'text_domain' ),
    'archives'              => __( 'Event Archives', 'text_domain' ),
    'attributes'            => __( 'Event Attributes', 'text_domain' ),
    'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
    'all_items'             => __( 'All Events', 'text_domain' ),
    'add_new_item'          => __( 'Add New Event', 'text_domain' ),
    'add_new'               => __( 'Add New', 'text_domain' ),
    'new_item'              => __( 'New Event', 'text_domain' ),
    'edit_item'             => __( 'Edit Event', 'text_domain' ),
    'update_item'           => __( 'Update Event', 'text_domain' ),
    'view_item'             => __( 'View Event', 'text_domain' ),
    'view_items'            => __( 'View Events', 'text_domain' ),
    );
    $args = array(
    'label'                 => __( 'Event', 'text_domain' ),
    'description'           => __( 'Events', 'text_domain' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
    'taxonomies'            => array( 'eventcategory', 'post_tag' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-welcome-learn-more',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
    );
    register_post_type( 'events', $args );
}

add_action('init','delay_remove');
function delay_remove() {
    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
}
//This snippet removes the default sorting dropdown in StoreFront Theme
//
add_action('wp_logout','auto_redirect_after_logout');
function auto_redirect_after_logout(){
  wp_redirect( home_url() );
  exit();
}
/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function my_header_add_to_cart_fragment( $fragments ) {
 
    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
    if ( $count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php            
    }
        ?></a><?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(http://bongosbooks.com/wp-content/uploads/2017/03/bongoslogo.png);
		height:65px;
		width:320px;
		background-size: 320px 95px;
		background-repeat: no-repeat;
        	padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );
add_action( 'after_setup_theme', 'mystile1_setup' );

function mystile1_setup() {
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
//add_theme_support( 'wc-product-gallery-slider' );
}
add_filter( 'woocommerce_min_password_strength', 'reduce_min_strength_password_requirement' );
function reduce_min_strength_password_requirement( $strength ) {
    return 2; 
}
add_filter( 'password_hint', function( $hint )
{
  return __( 'The password should be at least 7 characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ & )' );
} );
add_action( 'woocommerce_thankyou', 'custom_thankyou_subscription_action', 50, 1 );
function custom_thankyou_subscription_action( $order_id ){
    if( ! $order_id ) return;

    $order = wc_get_order( $order_id ); // Get an instance of the WC_Order object

    // If the order has a 'processing' status and contains a subscription 
    if( wcs_order_contains_subscription( $order ) && $order->has_status( 'processing' ) ){
		$order->update_status( 'completed' );
        // Get an array of WC_Subscription objects
        $subscriptions = wcs_get_subscriptions_for_order( $order_id );
        foreach( $subscriptions as $subscription_id => $subscription ){
            // Change the status of the WC_Subscription object
            $subscription->update_status( 'active' );
        }
    }
}
function wpse262203_restrict_comment_views( $comments_query ) {
  // Don't interfere with comment results in the dashboard
  if( is_admin() )
    return;

  $current_user = wp_get_current_user(); // Get the current user

  if( $current_user instanceof WP_User && is_user_logged_in() ) {
    // The visitor is logged in as a WordPress user...
 if( in_array( 'administrator', $current_user->roles ) )
      return;
 

    // Otherwise, restrict queried comments to those authored by this user.
    $comments_query->query_vars[ 'user_id' ]= array($current_user->ID,37,7);
	$comments_query->query_vars[ 'order'] = 'DESC';
  }
  else {
    // The visitor isn't logged in - make sure no comments are queried.
    $comments_query->query_vars[ 'comment__in' ] = array(0);
  }
}

add_action( 'pre_get_comments', 'wpse262203_restrict_comment_views' );