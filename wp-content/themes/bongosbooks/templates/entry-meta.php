<?php
/*
 * Returns the author url, only adding a hyperlink to their archive if Yoast
 */

// Check if Yoast SEO is installed & author archives are disabled.
$yoast_seo_installed = defined( 'WPSEO_VERSION' ) ? true : false;

$author_archives = false;
if ( $yoast_seo_installed ) {
    $yoast_options = get_option( 'wpseo_titles' );
    $author_archives = $yoast_options[ 'disable-author' ] ? true : false;
}

// If Yoast SEO is disabled, do not add a hyperlink to the author
if ( $author_archives ) {
    $author = get_the_author();
} else {
    $author = '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" rel="author" class="fn">' . get_the_author() . '</a>';
}

// Get the categories
$posted_under = '';
$url_format = '<a href="%2$s">%1$s</a>';
$categories = wp_get_object_terms( $post->ID, 'category', array( 'fields' => 'all' ) );
if ( !empty( $categories ) && !is_wp_error( $categories ) ) {

    // Wrap the categories with a hyperlink
    foreach ( $categories as $key => $category ) {
        $categories[$key] = sprintf($url_format, $category->name, get_term_link($category, 'category') );
    }
    $posted_under = implode( ', ', $categories );
}
?>
<p class="entry-meta">
    <?php echo __( 'Posted', 'tmbase' ); ?>
    <span class="posted-by"> by <span class="author vcard"><?php echo $author; ?></span></span> <span class="posted-on"> on <time datetime="<?php echo get_post_time( 'c',
            true ); ?>"><?php echo get_the_date(); ?></time></span>
    <span class="posted-under"> under <span class="categories"><?php echo $posted_under; ?></span></span>
</p>