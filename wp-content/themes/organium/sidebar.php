<?php
/*
 * Created by Artureanec
*/

if (class_exists('WooCommerce')) {
    if ( (is_shop() || is_product_category()) && !is_product() ) {
        global $post;
        $page_id = wc_get_page_id('shop');
        $post = get_post($page_id);
    }
}

global $organium_sidebar_name;
$additional_class = '';

if (class_exists('WooCommerce') && is_woocommerce() ) {
    if ( (is_shop() || is_product_category()) && !is_product()) {
        $organium_sidebar_position = organium_get_prefered_option('catalog_sidebar_position');
        $additional_class = ' shop_hidden_sidebar';
    } else {
        $organium_sidebar_position = 'none';
        $additional_class = ' simple_sidebar';
    }
} elseif ( function_exists( 'yith_plugin_registration_hook' ) && yith_wcwl_is_wishlist_page() ) {
    $organium_sidebar_position = 'none';
    $additional_class = ' simple_sidebar';
} else {
    if ( is_archive() ) {
        $organium_sidebar_position = organium_get_prefered_option('archive_sidebar_position');
    } elseif ( get_post_type() == 'post' ) {
        $organium_sidebar_position = organium_get_prefered_option('post_sidebar_position');
    } elseif ( get_post_type() == 'organium-portfolio' ) {
        $organium_sidebar_position = organium_get_prefered_option('portfolio_sidebar_position');
    } elseif ( get_post_type() == 'organium-recipes' ) {
        $organium_sidebar_position = organium_get_prefered_option('recipe_sidebar_position');
    } else {
        $organium_sidebar_position = organium_get_prefered_option('sidebar_position');
    }
    $additional_class = ' simple_sidebar';
}

if ($organium_sidebar_position !== 'none' && is_active_sidebar($organium_sidebar_name) ) {
    echo "<div class='organium_sidebar col-lg-3" . esc_attr($additional_class) . "'>";
        dynamic_sidebar($organium_sidebar_name);
        if ( !empty($additional_class) ) {
            echo '<div class="shop_hidden_sidebar_close"></div>';
        }
    echo "</div>";
    if ( !empty($additional_class) && $additional_class == ' simple_sidebar' ) {
        echo '<div class="simple_sidebar_trigger">';
            echo '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 469.333 469.333"><path d="M426.667,0h-384C19.135,0,0,19.135,0,42.667v384c0,23.531,19.135,42.667,42.667,42.667h384
				c23.531,0,42.667-19.135,42.667-42.667v-384C469.333,19.135,450.198,0,426.667,0z M149.333,448H42.667
				c-11.76,0-21.333-9.573-21.333-21.333v-320h128V448z M448,426.667c0,11.76-9.573,21.333-21.333,21.333h-256V106.667H448V426.667z
				 M448,85.333H21.333V42.667c0-11.76,9.573-21.333,21.333-21.333h384c11.76,0,21.333,9.573,21.333,21.333V85.333z"/>
			<circle cx="53.333" cy="53.333" r="10.667"/>
			<circle cx="96" cy="53.333" r="10.667"/>
			<circle cx="138.667" cy="53.333" r="10.667"/>
			<path d="M53.333,192h64c5.896,0,10.667-4.771,10.667-10.667c0-5.896-4.771-10.667-10.667-10.667h-64
				c-5.896,0-10.667,4.771-10.667,10.667C42.667,187.229,47.437,192,53.333,192z"/>
			<path d="M53.333,256h64c5.896,0,10.667-4.771,10.667-10.667c0-5.896-4.771-10.667-10.667-10.667h-64
				c-5.896,0-10.667,4.771-10.667,10.667C42.667,251.229,47.437,256,53.333,256z"/>
			<path d="M53.333,320h64c5.896,0,10.667-4.771,10.667-10.667c0-5.896-4.771-10.667-10.667-10.667h-64
				c-5.896,0-10.667,4.771-10.667,10.667C42.667,315.229,47.437,320,53.333,320z"/>
			<path d="M53.333,384H96c5.896,0,10.667-4.771,10.667-10.667S101.896,362.667,96,362.667H53.333
				c-5.896,0-10.667,4.771-10.667,10.667S47.437,384,53.333,384z"/></svg>';
        echo '</div>';
    }
}
