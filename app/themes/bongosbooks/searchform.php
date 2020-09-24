<?php
use TMProd\Base\Assets;
?>
<form class="search-bar" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
    <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
    <button type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>">a</button>
</form>