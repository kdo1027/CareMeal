<?php
/*
 * Created by Artureanec
*/


add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

add_action( 'wp_enqueue_scripts', 'organium_woo_enqueue_scripts' );
if ( !function_exists( 'organium_woo_enqueue_scripts') ) {
    function organium_woo_enqueue_scripts() {
        wp_enqueue_script( 'organium-woocommerce-scripts', get_template_directory_uri() . '/js/woo.js', array('jquery', 'jquery-cookie'), false, true );
    }
}

// Mini Cart AJAX support
add_action( 'woocommerce_before_mini_cart', 'organium_minicart_wrapper_open' );
if ( !function_exists( 'organium_minicart_wrapper_open') ) {
    function organium_minicart_wrapper_open() {
        echo "<div class='mini_cart_panel'>";
        echo "<i class='close_mini_cart'></i>";
    }
}

add_action( 'woocommerce_after_mini_cart', 'organium_minicart_wrapper_close' );
if ( !function_exists( 'organium_minicart_wrapper_close') ) {
    function organium_minicart_wrapper_close() {
        echo '</div>';
    }
}

add_filter( 'woocommerce_add_to_cart_fragments', 'organium_header_add_to_cart_fragment', 30, 1 );
if ( !function_exists( 'organium_header_add_to_cart_fragment') ) {
    function organium_header_add_to_cart_fragment($fragments) {
        ob_start();
        ?>
        <i class='mini_cart_count'><?php echo '<span>' . WC()->cart->cart_contents_count . '</span>' ?></i>
        <?php
        $fragments['.mini_cart_count'] = ob_get_clean();

        ob_start();
        woocommerce_mini_cart();
        $fragments['div.mini_cart_panel'] = ob_get_clean();
        return $fragments;
    }
}

add_filter( 'wc_add_to_cart_message_html', '__return_false' );

add_action( 'wp_ajax_organium_ajax_add_to_cart', 'organium_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_organium_ajax_add_to_cart', 'organium_ajax_add_to_cart' );
if ( !function_exists( 'organium_ajax_add_to_cart') ) {
    function organium_ajax_add_to_cart() {
        WC_AJAX::get_refreshed_fragments();
        wp_die();
    }
}

// Remove catalog page title
add_filter( 'woocommerce_show_page_title', 'organium_remove_catalog_page_title' );
if ( !function_exists( 'organium_remove_catalog_page_title') ) {
    function organium_remove_catalog_page_title() {
        return false;
    }
}

// Shop mode switcher
add_action( 'after_setup_theme', 'organium_set_shop_mode' );
if ( !function_exists( 'organium_set_shop_mode') ) {
    function organium_set_shop_mode() {
        global $organium_shop_mode;
        $organium_shop_mode = !empty($organium_shop_mode) ? $organium_shop_mode : 'grid';
    }
}


add_action( 'woocommerce_before_shop_loop', 'organium_add_shop_mode_switcher', 25 );
add_action( 'woocommerce_before_shop_loop', 'organium_wc_add_catalog_filter_trigger', 30 );
if ( !function_exists( 'organium_add_shop_mode_switcher') ) {
    function organium_add_shop_mode_switcher() {
        global $organium_shop_mode;
        echo '<div class="shop-mode-buttons">';
            echo '<form action="' . esc_url(organium_get_current_url()) . '" method="post">';
                echo '<input type="hidden" name="shop_mode" value="' . esc_attr($organium_shop_mode) . '" />';
                echo '<a href="#" class="woocommerce-grid" title="' . esc_attr__('Show products as grid', 'organium') . '">';
                    echo '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
<path d="M1,1h138.5v138.5H1V1z"/><path d="M374.5,1H513v138.5H374.5V1z"/><path d="M187.8,1h138.5v138.5H187.8V1z"/><path d="M1,187.8h138.5v138.5H1V187.8z"/><path d="M374.5,187.8H513v138.5H374.5V187.8z"/><path d="M187.8,187.8h138.5v138.5H187.8V187.8z"/><path d="M1,374.5h138.5V513H1V374.5z"/><path d="M374.5,374.5H513V513H374.5V374.5z"/><path d="M187.8,374.5h138.5V513H187.8V374.5z"/></svg>';
                echo '</a>';
                echo '<a href="#" class="woocommerce-list" title="' . esc_attr__('Show products as list', 'organium') . '">';
                    echo '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 405"><path d="M0-1h113.3v113.3H0V-1z"/><path d="M149.3-1H512v113.3H149.3V-1z"/><path d="M0,146h113.3v113.3H0V146z"/><path d="M149.3,146H512v113.3H149.3V146z"/><path d="M0,293h113.3v113.3H0V293z"/><path d="M149.3,293H512v113.3H149.3V293z"/></svg>';
                echo '</a>';
            echo '</form>';
        echo '</div>';
    }
}

// Rewrite WooCommerce function 'woocommerce_mini_cart'
if ( !function_exists( 'woocommerce_mini_cart') ) {
    function woocommerce_mini_cart($args = array()) {
        $defaults = array(
            'list_class' => '',
        );
        $args = wp_parse_args($args, $defaults);

        do_action('woocommerce_before_mini_cart');

        if (!WC()->cart->is_empty()) {
            echo '<ul class="woocommerce-mini-cart cart_list product_list_widget' . (!empty($args['list_class']) ? ' ' . esc_attr($args['list_class']) : '') . '">';
            do_action('woocommerce_before_mini_cart_contents');
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                    $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    echo '<li class="woocommerce-mini-cart-item ' . esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)) . '">';
                    if (empty($product_permalink)) {
                        echo '<span class="thumbnail-woocommerce_wrapper">';
                            echo sprintf('%s', $thumbnail);
                        echo '</span>';
                    } else {
                        echo '<a href="' . esc_url($product_permalink) . '" class="thumbnail-woocommerce_wrapper">';
                            echo sprintf('%s', $thumbnail);
                        echo '</a>';
                    }
                    echo '<span class="content-woocommerce_wrapper">';
                    if (empty($product_permalink)) {
                        echo '<h6 class="woocommerce-mini-cart-item__title">' . esc_html($product_name) . '</h6>';
                    } else {
                        echo '<h6 class="woocommerce-mini-cart-item__title"><a href="' . esc_url($product_permalink) . '">' . esc_html($product_name) . '</a></h6>';
                    }
                    echo wc_get_formatted_cart_item_data($cart_item);
                    echo apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $product_price) . '</span>', $cart_item, $cart_item_key);
                    echo '</span>';
                    echo apply_filters(
                        'woocommerce_cart_item_remove_link',
                        sprintf(
                            '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"></a>',
                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                            esc_attr__('Remove this item', 'organium'),
                            esc_attr($product_id),
                            esc_attr($cart_item_key),
                            esc_attr($_product->get_sku())
                        ),
                        $cart_item_key
                    );
                    echo '</li>';
                }
            }

            do_action('woocommerce_mini_cart_contents');

            echo '</ul>';

            echo '<p class="woocommerce-mini-cart__total total">';
            do_action('woocommerce_widget_shopping_cart_total');
            echo '</p>';

            do_action('woocommerce_widget_shopping_cart_before_buttons');

            echo '<p class="woocommerce-mini-cart__buttons buttons">';
            do_action('woocommerce_widget_shopping_cart_buttons');
            echo '</p>';

            do_action('woocommerce_widget_shopping_cart_after_buttons');

        } else {
            echo '<p class="woocommerce-mini-cart__empty-message">' . esc_html__('No products in the cart.', 'organium') . '</p>';
        }
        do_action('woocommerce_after_mini_cart');
    }
}

// Override Price Layout
add_filter('woocommerce_get_price_html', 'organium_wc_price_layout');
if ( !function_exists( 'organium_wc_price_layout') ) {
    function organium_wc_price_layout($price) {
        return '<span class="price_wrapper">' . $price . '</span>';
    }
}

// Product Catalog styling
add_action('woocommerce_before_shop_loop', 'organium_wc_catalog_loop_wrapper_open', 2);
add_action('woocommerce_after_shop_loop', 'organium_wc_catalog_loop_wrapper_close', 10);

add_action('woocommerce_before_shop_loop', 'organium_wc_catalog_top_info_open', 15);
add_action('woocommerce_before_shop_loop', 'organium_wc_catalog_top_info_close', 35);

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);

add_action('woocommerce_before_shop_loop_item', 'organium_wc_product_wrapper_open', 10);
add_action('woocommerce_after_shop_loop_item', 'organium_wc_product_wrapper_close', 5);

add_action('woocommerce_before_shop_loop_item_title', 'organium_wc_product_thumbnail_wrapper_open', 5);
add_action('woocommerce_before_shop_loop_item_title', 'organium_wc_product_thumbnail_wrapper_close', 25);

add_action('woocommerce_after_shop_loop_item_title', 'organium_wc_product_buttons_wrapper_open', 25);
add_action('woocommerce_after_shop_loop_item_title', 'organium_wc_product_buttons_wrapper_close', 35);

add_action('woocommerce_shop_loop_item_title', 'organium_wc_product_content_wrapper_open', 5);
add_action('woocommerce_after_shop_loop_item_title', 'organium_wc_product_content_wrapper_close', 20);

add_action('woocommerce_before_shop_loop_item_title', 'organium_wc_product_add_thumbnail_link', 20);

add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 30);

//add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);
add_action('woocommerce_after_shop_loop_item_title', 'organium_wc_template_loop_rating', 15);

add_action('woocommerce_shop_loop_item_title', 'organium_wc_product_title', 10);

add_action('woocommerce_before_shop_loop_item_title', 'organium_wc_product_sale_flash', 10);

if ( function_exists( 'yith_plugin_registration_hook' ) ) {
    add_action('woocommerce_before_shop_loop_item_title', 'organium_wc_catalog_add_to_wishlist', 15);
}

// Catalog category styling
remove_action('woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10);
remove_action('woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10);
remove_action('woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10);

add_action('woocommerce_before_subcategory', 'organium_wc_product_wrapper_open', 10);
add_action('woocommerce_after_subcategory', 'organium_wc_product_wrapper_close', 10);

add_action('woocommerce_before_subcategory_title', 'organium_wc_product_thumbnail_wrapper_open', 5);
add_action('woocommerce_before_subcategory_title', 'organium_wc_product_thumbnail_wrapper_close', 20);

add_action('woocommerce_shop_loop_subcategory_title', 'organium_wc_product_content_wrapper_open', 5);
add_action('woocommerce_after_subcategory_title', 'organium_wc_product_content_wrapper_close', 10);

add_action('woocommerce_before_subcategory_title', 'organium_wc_subcategory_add_thumbnail_link', 15);

add_action('woocommerce_shop_loop_subcategory_title', 'organium_wc_subcategory_title', 10);

// Single product styling
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
add_action('woocommerce_single_product_summary', 'organium_wc_single_title', 5);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
add_action('woocommerce_single_product_summary', 'organium_wc_single_rating', 15);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action('woocommerce_single_product_summary', 'organium_wc_single_meta', 25);

add_action('woocommerce_before_add_to_cart_quantity', 'organium_wc_quantity_wrapper_open', 10);
add_action('woocommerce_after_add_to_cart_quantity', 'organium_wc_quantity_wrapper_close', 10);
add_filter('woocommerce_cart_item_quantity', 'organium_wc_cart_quantity_wrapper', 1);

remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
add_action('organium_wc_single_product_sail_flash', 'organium_wc_product_sale_flash', 10);

add_filter( 'woocommerce_product_tabs', 'organium_wc_remove_product_tabs', 9999 );

add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'organium_wc_dropdown_variation_attribute_options_html', 10, 2 );

if ( function_exists( 'yith_plugin_registration_hook' ) ) {
    add_action('woocommerce_single_product_summary', 'organium_wc_single_add_to_wishlist', 10);
}
if ( !function_exists( 'organium_wc_single_add_to_wishlist') ) {
    function organium_wc_single_add_to_wishlist() {
        global $product;
        if ( $product->get_type() == 'grouped' ) {
            add_action('woocommerce_before_add_to_cart_button', 'organium_wc_catalog_add_to_wishlist', 10);
        } else {
            add_action('woocommerce_after_add_to_cart_quantity', 'organium_wc_catalog_add_to_wishlist', 10);
        }
    }
}

// Review
remove_action('woocommerce_review_before', 'woocommerce_review_display_gravatar', 10);
add_action('woocommerce_review_before', 'organium_wc_review_display_gravatar', 10);
add_action('woocommerce_review_before_comment_meta', 'organium_wc_review_meta_wrapper_open', 5);
add_action('woocommerce_review_meta', 'organium_wc_review_meta_wrapper_close', 15);
remove_action('woocommerce_review_meta', 'woocommerce_review_display_meta', 10);
add_action('woocommerce_review_meta', 'organium_wc_review_display_meta', 10);
add_filter('woocommerce_product_review_comment_form_args', 'organium_wc_product_review_comment_form_args');



if ( !function_exists( 'organium_wc_catalog_loop_wrapper_open') ) {
    function organium_wc_catalog_loop_wrapper_open() {
        global $organium_shop_mode;
        if (isset($_POST['shop_mode'])) {
            $organium_shop_mode = stripslashes(trim($_POST['shop_mode']));
        } else if (isset($_COOKIE['shop_mode'])) {
            $organium_shop_mode = stripslashes(trim($_COOKIE['shop_mode']));
        }
        if (empty($organium_shop_mode)) {
            $organium_shop_mode = 'grid';
        }

        echo '<div class="organium_shop_loop shop_mode_' . (isset($organium_shop_mode) && !empty($organium_shop_mode) ? esc_attr($organium_shop_mode) : 'grid') . '">';
    }
}

if ( !function_exists( 'organium_wc_catalog_loop_wrapper_close') ) {
    function organium_wc_catalog_loop_wrapper_close() {
        echo '</div>';
    }
}

if ( !function_exists( 'organium_wc_catalog_top_info_open') ) {
    function organium_wc_catalog_top_info_open() {
        echo '<div class="catalog-top-info-wrapper">';
    }
}

if ( !function_exists( 'organium_wc_catalog_top_info_close') ) {
    function organium_wc_catalog_top_info_close() {
        echo '</div>';
    }
}

if ( !function_exists( 'organium_wc_product_wrapper_open') ) {
    function organium_wc_product_wrapper_open() {
        echo '<div class="woocommerce-loop-product__wrapper">';
    }
}

if ( !function_exists( 'organium_wc_product_wrapper_close') ) {
    function organium_wc_product_wrapper_close() {
        echo '</div>';
    }
}

if ( !function_exists( 'organium_wc_product_thumbnail_wrapper_open') ) {
    function organium_wc_product_thumbnail_wrapper_open() {
        echo '<div class="attachment-woocommerce_wrapper">';
    }
}

if ( !function_exists( 'organium_wc_product_thumbnail_wrapper_close') ) {
    function organium_wc_product_thumbnail_wrapper_close() {
        echo '</div>';
    }
}

if ( !function_exists( 'organium_wc_product_content_wrapper_open') ) {
    function organium_wc_product_content_wrapper_open() {
        echo '<div class="content-woocommerce_wrapper">';
    }
}

if ( !function_exists( 'organium_wc_product_content_wrapper_close') ) {
    function organium_wc_product_content_wrapper_close() {
        echo '</div>';
    }
}

if ( !function_exists( 'organium_wc_product_buttons_wrapper_open') ) {
    function organium_wc_product_buttons_wrapper_open() {
        echo '<div class="buttons-woocommerce_wrapper">';
    }
}

if ( !function_exists( 'organium_wc_product_buttons_wrapper_close') ) {
    function organium_wc_product_buttons_wrapper_close() {
        echo '</div>';
    }
}

if ( !function_exists( 'organium_wc_product_add_thumbnail_link') ) {
    function organium_wc_product_add_thumbnail_link() {
        global $product;
        $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
        echo '<a href="' . esc_url( $link ) . '" class="attachment-woocommerce_link"></a>';
    }
}

if ( ! function_exists( 'organium_wc_template_loop_rating' ) ) {
    function organium_wc_template_loop_rating() {
        global $product;
        if ( wc_review_ratings_enabled() ) {
            $rating = $product->get_average_rating();
            $count = 0;
            $html  = '<div class="star-rating" role="img" aria-label="' . sprintf( esc_attr__( 'Rated %s out of 5', 'organium' ), $rating ) . '">' . wc_get_star_rating_html( $rating, $count ) . '</div>';
            echo apply_filters( 'woocommerce_product_get_rating_html', $html, $rating, $count );
        }
    }
}

if ( ! function_exists( 'organium_wc_product_title' ) ) {
    function organium_wc_product_title() {
        global $product;
        $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

        echo '<h3 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">';
            echo '<a href="' . esc_url( $link ) . '">' . get_the_title() . '</a>';
        echo '</h3>';
    }
}

if ( ! function_exists( 'organium_wc_product_sale_flash' ) ) {
    function organium_wc_product_sale_flash() {
        global $post, $product;

        echo '<div class="attachment-woocommerce_flash">';
        if ( $product->is_on_sale() ) {
            echo apply_filters('woocommerce_sale_flash', '<span class="flash-item sale">' . esc_html__('Sale', 'organium') . '</span>', $post, $product);
        }

        $postdate      = get_the_time( 'Y-m-d' );
        $postdatestamp = strtotime( $postdate );
        $newness       = 14;
        if( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ){
            echo '<span class="flash-item new">' . esc_html__( 'New', 'organium' ) . '</span>';
        }
        echo '</div>';
    }
}

if ( ! function_exists( 'organium_wc_catalog_add_to_wishlist' ) ) {
    function organium_wc_catalog_add_to_wishlist() {
        echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
    }
}

if ( ! function_exists( 'organium_wc_subcategory_title' ) ) {
    function organium_wc_subcategory_title($category) {
        $link = get_term_link( $category, 'product_cat' );

        echo '<h3 class="woocommerce-loop-category__title">';
            echo '<a href="' . esc_url( $link ) . '">';
                echo esc_html( $category->name );
                if ( $category->count > 0 ) {
                    echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . esc_html( $category->count ) . ')</mark>', $category );
                }
            echo '</a>';
		echo '</h2>';
    }
}

if ( !function_exists( 'organium_wc_subcategory_add_thumbnail_link') ) {
    function organium_wc_subcategory_add_thumbnail_link($category) {
        $link = get_term_link( $category, 'product_cat' );
        echo '<a href="' . esc_url( $link ) . '" class="attachment-woocommerce_link"></a>';
    }
}


if ( !function_exists('organium_wc_single_title') ) {
    function organium_wc_single_title() {
        the_title( '<h2 class="product_title entry-title">', '</h2>' );
    }
}

if ( !function_exists('organium_wc_single_rating') ) {
    function organium_wc_single_rating() {
        global $product;

        if ( wc_review_ratings_enabled() ) {
            $rating_count = $product->get_rating_count();
            $average      = $product->get_average_rating();

            if ( $rating_count > 0 ) {
                echo '<div class="woocommerce-product-rating">';
                    echo wc_get_rating_html( $average, $rating_count );
                echo '</div>';
            }
        }
    }
}

if ( !function_exists('organium_wc_single_meta') ) {
    function organium_wc_single_meta() {
        global $product;

        echo '<div class="product_meta">';

            do_action( 'woocommerce_product_meta_start' );

            if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) {
                echo '<div class="product_meta_item sku_wrapper">';
                    echo esc_html__( 'SKU: ', 'organium' ) . '<span class="sku">' . (( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'organium' )) . '</span>';
                echo '</div>';
            }
            echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="product_meta_item posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'organium' ) . ' ', '</div>' );
            echo wc_get_product_tag_list( $product->get_id(), '', '<div class="product_meta_item tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'organium' ) . ' ', '</div>' );

            do_action( 'woocommerce_product_meta_end' );

        echo '</div>';
    }
}

if ( !function_exists('organium_wc_quantity_wrapper_open') ) {
    function organium_wc_quantity_wrapper_open() {
        echo '<div class="quantity-wrapper">';
    }
}

if ( !function_exists('organium_wc_quantity_wrapper_close') ) {
    function organium_wc_quantity_wrapper_close() {
        echo '</div>';
    }
}

if ( !function_exists('organium_wc_cart_quantity_wrapper') ) {
    function organium_wc_cart_quantity_wrapper($quantity) {
        echo sprintf('<div class="quantity-wrapper">%s</div>', $quantity);
    }
}

// Rewrite WooCommerce function 'woocommerce_show_product_images'
function woocommerce_show_product_images() {
    if ( function_exists( 'wc_get_gallery_image_html' ) ) {
        global $product;

        $columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
        $post_thumbnail_id = $product->get_image_id();
        $wrapper_classes   = apply_filters(
            'woocommerce_single_product_image_gallery_classes',
            array(
                'woocommerce-product-gallery',
                'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
                'woocommerce-product-gallery--columns-' . absint( $columns ),
                'images',
            )
        );
        echo '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ) . '" data-columns="' . esc_attr( $columns ) . '" style="opacity: 0; transition: opacity .25s ease-in-out;">';
        echo '<figure class="woocommerce-product-gallery__wrapper">';
        if ( $product->get_image_id() ) {
            $html = wc_get_gallery_image_html( $post_thumbnail_id, true );
        } else {
            $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
            $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_attr__( 'Awaiting product image', 'organium' ) );
            $html .= '</div>';
        }
        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );

        do_action( 'woocommerce_product_thumbnails' );

        echo '</figure>';

        do_action( 'organium_wc_single_product_sail_flash' );

        echo '</div>';
    }
}

// Rewrite WooCommerce function 'woocommerce_product_description_tab'
function woocommerce_product_description_tab() {
    global $product;
    the_content();
    do_action( 'woocommerce_product_additional_information', $product );
}

if ( !function_exists('organium_wc_remove_product_tabs') ) {
    function organium_wc_remove_product_tabs($tabs) {
        unset($tabs['additional_information']);
        return $tabs;
    }
}

if ( !function_exists('organium_wc_dropdown_variation_attribute_options_html') ) {
    function organium_wc_dropdown_variation_attribute_options_html($html, $args) {
        return $html = sprintf('<div class="select-wrap">%s</div>', $html);
    }
}

// Rewrite WooCommerce function 'woocommerce_related_products'
function woocommerce_related_products( $args = array() ) {
    global $product;

    if ( $product ) {
        $defaults = array(
            'posts_per_page' => 2,
            'columns'        => 2,
            'orderby'        => 'rand',
            'order'          => 'desc',
        );
        $args = wp_parse_args( $args, $defaults );
        $args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
        $args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );
        wc_set_loop_prop( 'name', 'related' );
        wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_related_products_columns', $args['columns'] ) );
        $related_products = $args['related_products'];
        if ( $related_products ) {
            echo '<section class="related products">';
                echo '<div class="block-heading">';
                    echo '<div class="block-heading__subtitle">' .  esc_html__( 'Power of Nature', 'organium' ) . '</div>';
                    echo '<h2 class="block-heading__title">' . esc_html__( 'Best Sellers Products', 'organium' ) . '</h2>';
                echo '</div>';
                echo '<div class="organium_shop_loop shop_mode_grid">';
                woocommerce_product_loop_start();
                foreach ( $related_products as $related_product ) {
                    $post_object = get_post( $related_product->get_id() );
                    setup_postdata( $GLOBALS['post'] =& $post_object );
                    wc_get_template_part( 'content', 'product' );
                }
                woocommerce_product_loop_end();
                echo '</div>';
            echo '</section>';
        }
        wp_reset_postdata();
    }
}

// Rewrite WooCommerce function 'woocommerce_upsell_display'
function woocommerce_upsell_display( $limit = '-1', $columns = 4, $orderby = 'rand', $order = 'desc' ) {
    global $product;

    if ( $product ) {
        $args = apply_filters(
            'woocommerce_upsell_display_args',
            array(
                'posts_per_page' => $limit,
                'orderby'        => $orderby,
                'order'          => $order,
                'columns'        => $columns,
            )
        );
        wc_set_loop_prop( 'name', 'up-sells' );
        wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_upsells_columns', isset( $args['columns'] ) ? $args['columns'] : $columns ) );
        $orderby = apply_filters( 'woocommerce_upsells_orderby', isset( $args['orderby'] ) ? $args['orderby'] : $orderby );
        $order   = apply_filters( 'woocommerce_upsells_order', isset( $args['order'] ) ? $args['order'] : $order );
        $limit   = apply_filters( 'woocommerce_upsells_total', isset( $args['posts_per_page'] ) ? $args['posts_per_page'] : $limit );
        $upsells = wc_products_array_orderby( array_filter( array_map( 'wc_get_product', $product->get_upsell_ids() ), 'wc_products_array_filter_visible' ), $orderby, $order );
        $upsells = $limit > 0 ? array_slice( $upsells, 0, $limit ) : $upsells;
        if ( $upsells ) {
            echo '<section class="up-sells upsells products">';
            echo '<div class="block-heading">';
            echo '<div class="block-heading__subtitle">' . esc_html__('Power of Nature', 'organium') . '</div>';
            echo '<h2 class="block-heading__title">' . esc_html__( 'You may also like&hellip;', 'organium' ) . '</h2>';
            echo '</div>';
            echo '<div class="organium_shop_loop shop_mode_grid">';
            woocommerce_product_loop_start();
            foreach ( $upsells as $upsell ) {
                $post_object = get_post( $upsell->get_id() );
                setup_postdata( $GLOBALS['post'] =& $post_object );
                wc_get_template_part( 'content', 'product' );
            }
            woocommerce_product_loop_end();
            echo '</div>';
            echo '</section>';
        }
        wp_reset_postdata();
    }
}

if ( ! function_exists( 'organium_wc_review_display_gravatar' ) ) {
    function organium_wc_review_display_gravatar( $comment ) {
        echo '<div class="comment-avatar">';
            echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '106' ), '' );
        echo '</div>';
    }
}

if ( ! function_exists( 'organium_wc_review_meta_wrapper_open' ) ) {
    function organium_wc_review_meta_wrapper_open() {
        echo '<div class="comment-meta">';
    }
}

if ( ! function_exists( 'organium_wc_review_meta_wrapper_close' ) ) {
    function organium_wc_review_meta_wrapper_close() {
        echo '</div>';
    }
}

if ( ! function_exists( 'organium_wc_review_display_meta' ) ) {
    function organium_wc_review_display_meta() {
        global $comment;
        $verified = wc_review_is_from_verified_owner( $comment->comment_ID );
        if ( '0' === $comment->comment_approved ) {
            echo '<div class="woocommerce-review__awaiting-approval">';
                esc_html_e( 'Your review is awaiting approval', 'organium' );
            echo '</div>';
        } else {
            echo '<div class="woocommerce-review__author">';
                comment_author();
            echo '</div>';
            if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
                echo '<div class="woocommerce-review__verified verified">(' . esc_attr__( 'verified owner', 'organium' ) . ')</div>';
            }
            echo '<div class="woocommerce-review__published-date">' . esc_html( get_comment_date( wc_date_format() ) ) . '</div>';
        }
    }
}

if ( ! function_exists( 'organium_wc_product_review_comment_form_args' ) ) {
    function organium_wc_product_review_comment_form_args($args) {
        $args['class_submit'] = 'submit';
        $args['comment_field'] = '
        <div class="comment-form-rating">
            <select name="rating" id="rating" required>
                <option value="">' . esc_html_x( 'Rate&hellip;', 'frontend', 'organium' ) . '</option>
                <option value="5">' . esc_html_x( 'Perfect', 'frontend', 'organium' ) . '</option>
                <option value="4">' . esc_html_x( 'Good', 'frontend', 'organium' ) . '</option>
                <option value="3">' . esc_html_x( 'Average', 'frontend', 'organium' ) . '</option>
                <option value="2">' . esc_html_x( 'Not that bad', 'frontend', 'organium' ) . '</option>
                <option value="1">' . esc_html_x( 'Very poor', 'frontend', 'organium' ) . '</option>
            </select>
        </div>
        <textarea id="comment" name="comment" cols="45" rows="5" class="form__field form__message" placeholder="' . esc_attr__( 'Your review', 'organium' ) . '" required></textarea>';

                $commenter  = wp_get_current_commenter();
                $req        = get_option( 'require_name_email' );
                $html_req   = ( $req ? " required" : '' );

                $args['fields']['author'] = '
        <div class="form__columns">
            <input id="author" name="author" type="text" placeholder="' . esc_attr__('Your Full Name', 'organium' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" class="form__field" size="30" maxlength="245"' . $html_req . ' />';
                $args['fields']['email'] = '
            <input id="email" name="email" type="email" placeholder="' . esc_attr__('Your Email', 'organium') . '" value="' . esc_attr($commenter['comment_author_email'] ) . '" class="form__field" size="30"' . $html_req . ' />
        </div>';

        return $args;
    }
}

if ( ! function_exists( 'organium_wc_add_catalog_filter_trigger' ) ) {
    function organium_wc_add_catalog_filter_trigger() {
        echo '<div class="product-filters-trigger-wrapper">';
            if ( is_active_sidebar('woocommerce') ) {
                echo '<span class="product-filters-trigger">' . esc_html__('View filters', 'organium') . '</span>';
            } else {
                echo '<span>&nbsp;</span>';
            }
        echo '</div>';
    }
}




// Wishlist Default Settings
if ( function_exists( 'yith_plugin_registration_hook' ) ) {
    add_filter('yith_wcwl_add_to_wishlist_options', 'organium_wc_add_to_wishlist_default_settings', 1);
    add_filter('yith_wcwl_wishlist_page_options', 'organium_wc_wishlist_page_default_settings', 1);

    if ( !function_exists( 'organium_wc_add_to_wishlist_default_settings' ) ) {
        function organium_wc_add_to_wishlist_default_settings($args) {
            $args = array(
                'add_to_wishlist' => array(

                    'general_section_start' => array(
                        'name' => esc_html__( 'General Settings', 'organium' ),
                        'type' => 'title',
                        'desc' => '',
                        'id' => 'yith_wcwl_general_settings'
                    ),

                    'after_add_to_wishlist_behaviour' => array(
                        'name'      => esc_html__( 'After product is added to wishlist', 'organium' ),
                        'desc'      => esc_html__( 'Choose the look of the Wishlist button when the product has already been added to a wishlist', 'organium' ),
                        'id'        => 'yith_wcwl_after_add_to_wishlist_behaviour',
                        'options'   => array_merge(
                            array(
                                'add'    => esc_html__( 'Show "Add to wishilist" button', 'organium' ),
                                'view'   => esc_html__( 'Show "View wishlist" link', 'organium' ),
                                'remove' => esc_html__( 'Show "Remove from list" link', 'organium' ),
                            )
                        ) ,
                        'default'   => 'remove',
                        'type'      => 'yith-field',
                        'yith-type' => 'radio'
                    ),

                    'general_section_end' => array(
                        'type' => 'sectionend',
                        'id' => 'yith_wcwl_general_settings'
                    ),

                    'shop_page_section_start' => array(
                        'name' => esc_html__( 'Loop settings', 'organium' ),
                        'type' => 'title',
                        'desc' => esc_html__( 'Loop options will be visible on Shop page, category pages, product shortcodes, products sliders, and all the other places where the WooCommerce products\' loop is used', 'organium' ),
                        'id' => 'yith_wcwl_shop_page_settings'
                    ),

                    'show_on_loop' => array(
                        'name'      => esc_html__( 'Show "Add to wishlist" in loop', 'organium' ),
                        'desc'      => esc_html__( 'Enable the "Add to wishlist" feature in WooCommerce products\' loop', 'organium' ),
                        'id'        => 'yith_wcwl_show_on_loop',
                        'default'   => 'yes',
                        'type'      => 'yith-field',
                        'yith-type' => 'onoff'
                    ),

                    'loop_position' => array(
                        'name'      => esc_html__( 'Position of "Add to wishlist" in loop', 'organium' ),
                        'desc'      => wp_kses(__( 'Choose where to show "Add to wishlist" button or link in WooCommerce products\' loop. <span class="addon">Copy this shortcode <span class="code"><code>[yith_wcwl_add_to_wishlist]</code></span> and paste it where you want to show the "Add to wishlist" link or button</span>', 'organium' ), array(
                            'span' => array(
                                'class' => true
                            ),
                            'code' => array()
                        )),
                        'id'        => 'yith_wcwl_loop_position',
                        'default'   => 'shortcode',
                        'type'      => 'yith-field',
                        'yith-type' => 'select',
                        'class'     => 'wc-enhanced-select',
                        'options'   => array(
                            'before_image' => esc_html__( 'On top of the image', 'organium' ),
                            'before_add_to_cart' => esc_html__( 'Before "Add to cart" button', 'organium' ),
                            'after_add_to_cart' => esc_html__( 'After "Add to cart" button', 'organium' ),
                            'shortcode' => esc_html__( 'Use shortcode', 'organium' )
                        ),
                        'deps'      => array(
                            'id'    => 'yith_wcwl_show_on_loop',
                            'value' => 'yes'
                        )
                    ),

                    'shop_page_section_end' => array(
                        'type' => 'sectionend',
                        'id' => 'yith_wcwl_shop_page_settings'
                    ),

                    'product_page_section_start' => array(
                        'name' => esc_html__( 'Product page settings', 'organium' ),
                        'type' => 'title',
                        'desc' => '',
                        'id' => 'yith_wcwl_product_page_settings'
                    ),

                    'add_to_wishlist_position' => array(
                        'name'      => esc_html__( 'Position of "Add to wishlist" on product page', 'organium' ),
                        'desc'      => wp_kses(__( 'Choose where to show "Add to wishlist" button or link on the product page. <span class="addon">Copy this shortcode <span class="code"><code>[yith_wcwl_add_to_wishlist]</code></span> and paste it where you want to show the "Add to wishlist" link or button</span>', 'organium' ), array(
                            'span' => array(
                                'class' => true
                            ),
                            'code' => array()
                        )),
                        'id'        => 'yith_wcwl_button_position',
                        'default'   => 'shortcode',
                        'type'      => 'yith-field',
                        'yith-type' => 'select',
                        'class'     => 'wc-enhanced-select',
                        'options'   => array(
                            'add-to-cart' => esc_html__( 'After "Add to cart"', 'organium' ),
                            'thumbnails'  => esc_html__( 'After thumbnails', 'organium' ),
                            'summary'     => esc_html__( 'After summary', 'organium' ),
                            'shortcode'   => esc_html__( 'Use shortcode', 'organium' )
                        ),
                    ),

                    'product_page_section_end' => array(
                        'type' => 'sectionend',
                        'id' => 'yith_wcwl_product_page_settings'
                    ),

                    'text_section_start' => array(
                        'name' => esc_html__( 'Text customization', 'organium' ),
                        'type' => 'title',
                        'desc' => '',
                        'id' => 'yith_wcwl_text_section_settings'
                    ),

                    'add_to_wishlist_text' => array(
                        'name'    => esc_html__( '"Add to wishlist" text', 'organium' ),
                        'desc'    => esc_html__( 'Enter a text for "Add to wishlist" button', 'organium' ),
                        'id'      => 'yith_wcwl_add_to_wishlist_text',
                        'default' => '',
                        'type'    => 'text',
                    ),

                    'product_added_text' => array(
                        'name'    => esc_html__( '"Product added" text', 'organium' ),
                        'desc'    => esc_html__( 'Enter the text of the message displayed when the user adds a product to the wishlist', 'organium' ),
                        'id'      => 'yith_wcwl_product_added_text',
                        'default' => esc_html__( 'Product added to your wishlist!', 'organium' ),
                        'type'    => 'text',
                    ),

                    'browse_wishlist_text' => array(
                        'name'    => esc_html__( '"Browse wishlist" text', 'organium' ),
                        'desc'    => esc_html__( 'Enter a text for the "Browse wishlist" link on the product page', 'organium' ),
                        'id'      => 'yith_wcwl_browse_wishlist_text',
                        'default' => esc_html__( 'View wishlist', 'organium' ),
                        'type'    => 'text',
                    ),

                    'already_in_wishlist_text' => array(
                        'name'    => esc_html__( '"Product already in wishlist" text', 'organium' ),
                        'desc'    => esc_html__( 'Enter the text for the message displayed when the user views a product that is already in the wishlist', 'organium' ),
                        'id'      => 'yith_wcwl_already_in_wishlist_text',
                        'default' => esc_html__( 'The product is already in your wishlist!', 'organium' ),
                        'type'    => 'text',
                    ),

                    'text_section_end' => array(
                        'type' => 'sectionend',
                        'id' => 'yith_wcwl_text_section_settings'
                    ),

                    'style_section_start' => array(
                        'name' => esc_html__( 'Style & Color customization', 'organium' ),
                        'type' => 'title',
                        'desc' => '',
                        'id' => 'yith_wcwl_style_section_settings'
                    ),

                    'use_buttons' => array(
                        'name'      => esc_html__( 'Style of "Add to wishlist"', 'organium' ),
                        'desc'      => esc_html__( 'Choose if you want to show a textual "Add to wishlist" link or a button', 'organium' ),
                        'id'        => 'yith_wcwl_add_to_wishlist_style',
                        'options'   => array(
                            'link'           => esc_html__( 'Textual (anchor)', 'organium' ),
                            'button_default' => esc_html__( 'Button with theme style', 'organium' ),
                            'button_custom'  => esc_html__( 'Button with custom style', 'organium' )
                        ),
                        'default'   => 'link',
                        'type'      => 'yith-field',
                        'yith-type' => 'radio'
                    ),

                    'add_to_wishlist_colors' => array(
                        'name'         => esc_html__( '"Add to wishlist" button style', 'organium' ),
                        'id'           => 'yith_wcwl_color_add_to_wishlist',
                        'type'         => 'yith-field',
                        'yith-type'    => 'multi-colorpicker',
                        'colorpickers' => array(
                            array(
                                'desc' => esc_html__( 'Choose colors for the "Add to wishlist" button', 'organium' ),
                                array(
                                    'name' => esc_html__( 'Background', 'organium' ),
                                    'id'   => 'background',
                                    'default' => '#a5bd3a'
                                ),
                                array(
                                    'name' => esc_html__( 'Text', 'organium' ),
                                    'id'   => 'text',
                                    'default' => '#ffffff'
                                ),
                                array(
                                    'name' => esc_html__( 'Border', 'organium' ),
                                    'id'   => 'border',
                                    'default' => '#a5bd3a'
                                ),
                            ),
                            array(
                                'desc' => esc_html__( 'Choose colors for the "Add to wishlist" button on hover state', 'organium' ),
                                array(
                                    'name' => esc_html__( 'Background Hover', 'organium' ),
                                    'id'   => 'background_hover',
                                    'default' => '#b4ce41'
                                ),
                                array(
                                    'name' => esc_html__( 'Text Hover', 'organium' ),
                                    'id'   => 'text_hover',
                                    'default' => '#ffffff'
                                ),
                                array(
                                    'name' => esc_html__( 'Border Hover', 'organium' ),
                                    'id'   => 'border_hover',
                                    'default' => '#b4ce41'
                                ),
                            )
                        ),
                        'deps' => array(
                            'id'    => 'yith_wcwl_add_to_wishlist_style',
                            'value' => 'button_custom'
                        )
                    ),

                    'rounded_buttons_radius' => array(
                        'name'      => esc_html__( 'Border radius', 'organium' ),
                        'desc'      => esc_html__( 'Choose radius for the "Add to wishlist" button', 'organium' ),
                        'id'        => 'yith_wcwl_rounded_corners_radius',
                        'default'   => 3,
                        'type'      => 'yith-field',
                        'yith-type' => 'slider',
                        'min'       => 1,
                        'max'       => 100,
                        'deps' => array(
                            'id'    => 'yith_wcwl_add_to_wishlist_style',
                            'value' => 'button_custom'
                        )
                    ),

                    'add_to_wishlist_icon' => array(
                        'name'      => esc_html__( '"Add to wishlist" icon', 'organium' ),
                        'desc'      => esc_html__( 'Select an icon for the "Add to wishlist" button (optional)', 'organium' ),
                        'id'        => 'yith_wcwl_add_to_wishlist_icon',
                        'default'   => apply_filters( 'yith_wcwl_add_to_wishlist_std_icon', 'fa-heart-o', 'yith_wcwl_add_to_wishlist_icon' ),
                        'type'      => 'yith-field',
                        'class'     => 'icon-select',
                        'yith-type' => 'select',
                        'options'   => yith_wcwl_get_plugin_icons()
                    ),

                    'add_to_wishlist_custom_icon' => array(
                        'name'      => esc_html__( '"Add to wishlist" custom icon', 'organium' ),
                        'desc'      => esc_html__( 'Upload an icon you\'d like to use for "Add to wishlist" button (suggested 32px x 32px)', 'organium' ),
                        'id'        => 'yith_wcwl_add_to_wishlist_custom_icon',
                        'default'   => '',
                        'type'      => 'yith-field',
                        'yith-type' => 'upload',
                        'deps'      => array(
                            'id'    => 'yith_wcwl_add_to_wishlist_icon',
                            'value' => 'custom'
                        )
                    ),

                    'added_to_wishlist_icon' => array(
                        'name'      => esc_html__( '"Added to wishlist" icon', 'organium' ),
                        'desc'      => esc_html__( 'Select an icon for the "Added to wishlist" button (optional)', 'organium' ),
                        'id'        => 'yith_wcwl_added_to_wishlist_icon',
                        'default'   => apply_filters( 'yith_wcwl_add_to_wishlist_std_icon', 'fa-heart', 'yith_wcwl_added_to_wishlist_icon' ),
                        'type'      => 'yith-field',
                        'class'     => 'icon-select',
                        'yith-type' => 'select',
                        'options'   => yith_wcwl_get_plugin_icons( __( 'Same used for Add to wishlist', 'organium' ) )
                    ),

                    'added_to_wishlist_custom_icon' => array(
                        'name'      => esc_html__( '"Added to wishlist" custom icon', 'organium' ),
                        'desc'      => esc_html__( 'Upload an icon you\'d like to use for "Add to wishlist" button (suggested 32px x 32px)', 'organium' ),
                        'id'        => 'yith_wcwl_added_to_wishlist_custom_icon',
                        'default'   => '',
                        'type'      => 'yith-field',
                        'yith-type' => 'upload',
                        'deps'      => array(
                            'id'    => 'yith_wcwl_added_to_wishlist_icon',
                            'value' => 'custom'
                        )
                    ),

                    'custom_css' => array(
                        'name'     => esc_html__( 'Custom CSS', 'organium' ),
                        'desc'     => esc_html__( 'Enter custom CSS to be applied to Wishlist elements (optional)', 'organium' ),
                        'id'       => 'yith_wcwl_custom_css',
                        'default'  => '',
                        'type'     => 'yith-field',
                        'yith-type' => 'textarea',
                    ),

                    'style_section_end' => array(
                        'type' => 'sectionend',
                        'id' => 'yith_wcwl_style_section_settings'
                    ),

                )
            );
            return $args;
        }
    }
    if ( !function_exists( 'organium_wc_wishlist_page_default_settings' ) ) {
        function organium_wc_wishlist_page_default_settings($args) {
            $args = array(
                'wishlist_page' => array(
                    'manage_section_start' => array(
                        'name' => esc_html__( 'All your wishlists', 'organium' ),
                        'type' => 'title',
                        'desc' => '',
                        'id' => 'yith_wcwl_manage_settings'
                    ),

                    'wishlist_page' => array(
                        'name'     => esc_html__( 'Wishlist page', 'organium' ),
                        'desc'     => wp_kses(__( 'Pick a page as the main Wishlist page; make sure you add the <span class="code"><code>[yith_wcwl_wishlist]</code></span> shortcode into the page content', 'organium' ), array(
                            'span' => array(
                                'class' => true
                            ),
                            'code' => array()
                        )),
                        'id'       => 'yith_wcwl_wishlist_page_id',
                        'type'     => 'single_select_page',
                        'default'  => '',
                        'class'    => 'chosen_select_nostd',
                    ),

                    'manage_section_end' => array(
                        'type' => 'sectionend',
                        'id' => 'yith_wcwl_manage_settings'
                    ),

                    'wishlist_section_start' => array(
                        'name' => esc_html__( 'Wishlist Detail Page', 'organium' ),
                        'type' => 'title',
                        'desc' => '',
                        'id' => 'yith_wcwl_wishlist_settings'
                    ),

                    'show_product_variation' => array(
                        'name'     => esc_html__( 'In wishlist table show', 'organium' ),
                        'desc'     => esc_html__( 'Product variations selected by the user (example: size or color)', 'organium' ),
                        'id'       => 'yith_wcwl_variation_show',
                        'type'     => 'checkbox',
                        'default'  => 'no',
                        'checkboxgroup' => 'start'
                    ),

                    'show_unit_price' => array(
                        'name'     => esc_html__( 'In wishlist table show', 'organium' ),
                        'desc'     => esc_html__( 'Product price', 'organium' ),
                        'id'       => 'yith_wcwl_price_show',
                        'type'     => 'checkbox',
                        'default'  => 'yes',
                        'checkboxgroup' => 'wishlist_info'
                    ),

                    'show_stock_status' => array(
                        'name'     => esc_html__( 'In wishlist table show', 'organium' ),
                        'desc'     => esc_html__( 'Product stock (show if the product is available or not)', 'organium' ),
                        'id'       => 'yith_wcwl_stock_show',
                        'type'     => 'checkbox',
                        'default'  => 'no',
                        'checkboxgroup' => 'wishlist_info'
                    ),

                    'show_dateadded' => array(
                        'name'     => esc_html__( 'In wishlist table show', 'organium' ),
                        'desc'     => esc_html__( 'Date on which the product was added to the wishlist', 'organium' ),
                        'id'       => 'yith_wcwl_show_dateadded',
                        'type'     => 'checkbox',
                        'default'  => 'no',
                        'checkboxgroup' => 'wishlist_info'
                    ),

                    'show_add_to_cart' => array(
                        'name'     => esc_html__( 'In wishlist table show', 'organium' ),
                        'desc'     => esc_html__( 'Add to cart option for each product', 'organium' ),
                        'id'       => 'yith_wcwl_add_to_cart_show',
                        'type'     => 'checkbox',
                        'default'  => 'yes',
                        'checkboxgroup' => 'wishlist_info'
                    ),

                    'show_remove_button' => array(
                        'name'     => esc_html__( 'In wishlist table show', 'organium' ),
                        'desc'     => esc_html__( 'Icon to remove the product from the wishlist - to the left of the product', 'organium' ),
                        'id'       => 'yith_wcwl_show_remove',
                        'type'     => 'checkbox',
                        'default'  => 'no',
                        'checkboxgroup' => 'wishlist_info'
                    ),

                    'repeat_remove_button' => array(
                        'name'     => esc_html__( 'In wishlist table show', 'organium' ),
                        'desc'     => esc_html__( 'Button to remove the product from the wishlist - to the right of the product', 'organium' ),
                        'id'       => 'yith_wcwl_repeat_remove_button',
                        'type'     => 'checkbox',
                        'default'  => 'yes',
                        'checkboxgroup' => 'end'
                    ),

                    'redirect_to_cart' => array(
                        'name'      => esc_html__( 'Redirect to cart', 'organium' ),
                        'desc'      => esc_html__( 'Redirect users to the cart page when they add a product to the cart from the wishlist page', 'organium' ),
                        'id'        => 'yith_wcwl_redirect_cart',
                        'default'   => 'no',
                        'type'      => 'yith-field',
                        'yith-type' => 'onoff'
                    ),

                    'remove_after_add_to_cart' => array(
                        'name'      => esc_html__( 'Remove if added to the cart', 'organium' ),
                        'desc'      => esc_html__( 'Remove the product from the wishlist after it has been added to the cart', 'organium' ),
                        'id'        => 'yith_wcwl_remove_after_add_to_cart',
                        'default'   => 'no',
                        'type'      => 'yith-field',
                        'yith-type' => 'onoff'
                    ),

                    'enable_wishlist_share' => array(
                        'name'      => esc_html__( 'Share wishlist', 'organium' ),
                        'desc'      => esc_html__( 'Enable this option to let users share their wishlist on social media', 'organium' ),
                        'id'        => 'yith_wcwl_enable_share',
                        'type'      => 'yith-field',
                        'yith-type' => 'onoff',
                        'default'   => 'no',
                    ),

                    'share_on_facebook' => array(
                        'name'    => esc_html__( 'Share on social media', 'organium' ),
                        'desc'    => esc_html__( 'Share on Facebook', 'organium' ),
                        'id'      => 'yith_wcwl_share_fb',
                        'default' => 'yes',
                        'type'    => 'checkbox',
                        'checkboxgroup' => 'start'
                    ),

                    'share_on_twitter' => array(
                        'name'    => esc_html__( 'Share on social media', 'organium' ),
                        'desc'    => esc_html__( 'Tweet on Twitter', 'organium' ),
                        'id'      => 'yith_wcwl_share_twitter',
                        'default' => 'yes',
                        'type'    => 'checkbox',
                        'checkboxgroup' => 'wishlist_share'
                    ),

                    'share_on_pinterest' => array(
                        'name'    => esc_html__( 'Share on social media', 'organium' ),
                        'desc'    => esc_html__( 'Pin on Pinterest', 'organium' ),
                        'id'      => 'yith_wcwl_share_pinterest',
                        'default' => 'no',
                        'type'    => 'checkbox',
                        'checkboxgroup' => 'wishlist_share'
                    ),

                    'share_by_email' => array(
                        'name'    => esc_html__( 'Share on social media', 'organium' ),
                        'desc'    => esc_html__( 'Share by email', 'organium' ),
                        'id'      => 'yith_wcwl_share_email',
                        'default' => 'no',
                        'type'    => 'checkbox',
                        'checkboxgroup' => 'wishlist_share'
                    ),

                    'share_by_whatsapp' => array(
                        'name'    => esc_html__( 'Share on social media', 'organium' ),
                        'desc'    => esc_html__( 'Share on WhatsApp', 'organium' ),
                        'id'      => 'yith_wcwl_share_whatsapp',
                        'default' => 'no',
                        'type'    => 'checkbox',
                        'checkboxgroup' => 'wishlist_share'
                    ),

                    'share_by_url' => array(
                        'name'    => esc_html__( 'Share by URL', 'organium' ),
                        'desc'    => esc_html__( 'Show "Share URL" field on wishlist page', 'organium' ),
                        'id'      => 'yith_wcwl_share_url',
                        'default' => 'no',
                        'type'    => 'checkbox',
                        'checkboxgroup' => 'end'
                    ),

                    'socials_title' => array(
                        'name'    => esc_html__( 'Sharing title', 'organium' ),
                        'desc'    => esc_html__( 'Wishlist title used for sharing (only used on Twitter and Pinterest)', 'organium' ),
                        'id'      => 'yith_wcwl_socials_title',
                        'default' => sprintf( esc_html__( 'My wishlist on %s', 'organium' ), get_bloginfo( 'name' ) ),
                        'type'    => 'text',
                    ),

                    'socials_text' =>  array(
                        'name'    => esc_html__( 'Social text', 'organium' ),
                        'desc'    => esc_html__( 'Type the message you want to publish when you share your wishlist on Twitter and Pinterest', 'organium' ),
                        'id'      => 'yith_wcwl_socials_text',
                        'default' => '',
                        'type'    => 'yith-field',
                        'yith-type' => 'textarea'
                    ),

                    'socials_image' => array(
                        'name'    => esc_html__( 'Social image URL', 'organium' ),
                        'desc'    => esc_html__( 'It will be used to pin the wishlist on Pinterest.', 'organium' ),
                        'id'      => 'yith_wcwl_socials_image_url',
                        'default' => '',
                        'type'    => 'text',
                    ),

                    'wishlist_section_end' => array(
                        'type' => 'sectionend',
                        'id' => 'yith_wcwl_wishlist_settings',
                    ),

                    'text_section_start' => array(
                        'name' => esc_html__( 'Text customization', 'organium' ),
                        'type' => 'title',
                        'desc' => '',
                        'id' => 'yith_wcwl_text_section_settings'
                    ),

                    'default_wishlist_title' => array(
                        'name'    => esc_html__( 'Default wishlist name', 'organium' ),
                        'desc'    => esc_html__( 'Enter a name for the default wishlist. This is the wishlist that will be automatically generated for all users if they do not create any custom one', 'organium' ),
                        'id'      => 'yith_wcwl_wishlist_title',
                        'default' => '',
                        'type'    => 'text',
                    ),

                    'add_to_cart_text' => array(
                        'name'    => esc_html__( '"Add to cart" text', 'organium' ),
                        'desc'    => esc_html__( 'Enter a text for the "Add to cart" button', 'organium' ),
                        'id'      => 'yith_wcwl_add_to_cart_text',
                        'default' => esc_html__( 'Add to cart', 'organium' ),
                        'type'    => 'text',
                    ),

                    'text_section_end' => array(
                        'type' => 'sectionend',
                        'id' => 'yith_wcwl_text_section_settings'
                    ),

                    'style_section_start' => array(
                        'name' => esc_html__( 'Style & color customization', 'organium' ),
                        'type' => 'title',
                        'desc' => '',
                        'id' => 'yith_wcwl_style_section_settings'
                    ),

                    'use_buttons' => array(
                        'name'      => esc_html__( 'Style of "Add to cart"', 'organium' ),
                        'desc'      => esc_html__( 'Choose whether to show a textual "Add to cart" link or a button', 'organium' ),
                        'id'        => 'yith_wcwl_add_to_cart_style',
                        'options'   => array(
                            'link'           => esc_html__( 'Textual (anchor)', 'organium' ),
                            'button_default' => esc_html__( 'Button with theme style', 'organium' ),
                            'button_custom'  => esc_html__( 'Button with custom style', 'organium' )
                        ),
                        'default'   => 'link',
                        'type'      => 'yith-field',
                        'yith-type' => 'radio'
                    ),

                    'add_to_cart_colors' => array(
                        'name'         => esc_html__( '"Add to cart" button style', 'organium' ),
                        'id'           => 'yith_wcwl_color_add_to_cart',
                        'type'         => 'yith-field',
                        'yith-type'    => 'multi-colorpicker',
                        'colorpickers' => array(
                            array(
                                'desc' => esc_html__( 'Choose the colors for the "Add to cart" button', 'organium' ),
                                array(
                                    'name' => esc_html__( 'Background', 'organium' ),
                                    'id'   => 'background',
                                    'default' => '#fa6c47'
                                ),
                                array(
                                    'name' => esc_html__( 'Text', 'organium' ),
                                    'id'   => 'text',
                                    'default' => '#ffffff'
                                ),
                                array(
                                    'name' => esc_html__( 'Border', 'organium' ),
                                    'id'   => 'border',
                                    'default' => '#fa6c47'
                                ),
                            ),
                            array(
                                'desc' => esc_html__( 'Choose colors for the "Add to cart" button on hover state', 'organium' ),
                                array(
                                    'name' => esc_html__( 'Background Hover', 'organium' ),
                                    'id'   => 'background_hover',
                                    'default' => '#fb8a6b'
                                ),
                                array(
                                    'name' => esc_html__( 'Text Hover', 'organium' ),
                                    'id'   => 'text_hover',
                                    'default' => '#ffffff'
                                ),
                                array(
                                    'name' => esc_html__( 'Border Hover', 'organium' ),
                                    'id'   => 'border_hover',
                                    'default' => '#fb8a6b'
                                ),
                            )
                        ),
                        'deps' => array(
                            'id' => 'yith_wcwl_add_to_cart_style',
                            'value' => 'button_custom'
                        )
                    ),

                    'rounded_buttons_radius' => array(
                        'name'      => esc_html__( 'Border radius', 'organium' ),
                        'desc'      => esc_html__( 'Set the radius for the "Add to cart" button', 'organium' ),
                        'id'        => 'yith_wcwl_add_to_cart_rounded_corners_radius',
                        'default'   => 3,
                        'type'      => 'yith-field',
                        'yith-type' => 'slider',
                        'min'       => 1,
                        'max'       => 100,
                        'deps' => array(
                            'id' => 'yith_wcwl_add_to_cart_style',
                            'value' => 'button_custom'
                        )
                    ),

                    'add_to_cart_icon' => array(
                        'name'      => esc_html__( '"Add to cart" icon', 'organium' ),
                        'desc'      => esc_html__( 'Select an icon for the "Add to cart" button (optional)', 'organium' ),
                        'id'        => 'yith_wcwl_add_to_cart_icon',
                        'default'   => apply_filters( 'yith_wcwl_add_to_cart_std_icon', 'fa-shopping-cart' ),
                        'type'      => 'yith-field',
                        'yith-type' => 'select',
                        'class'     => 'icon-select',
                        'options'   => yith_wcwl_get_plugin_icons(),
                        'deps' => array(
                            'id' => 'yith_wcwl_add_to_cart_style',
                            'value' => 'button_custom'
                        )

                    ),

                    'add_to_cart_custom_icon' => array(
                        'name'      => esc_html__( '"Add to cart" custom icon', 'organium' ),
                        'desc'      => esc_html__( 'Upload an icon you\'d like to use for the "Add to cart" button (suggested 32px x 32px)', 'organium' ),
                        'id'        => 'yith_wcwl_add_to_cart_custom_icon',
                        'default'   => '',
                        'type'      => 'yith-field',
                        'yith-type' => 'upload'
                    ),

                    'style_1_button_colors' => array(
                        'name'         => esc_html__( 'Primary button style', 'organium' ),
                        'id'           => 'yith_wcwl_color_button_style_1',
                        'type'         => 'yith-field',
                        'yith-type'    => 'multi-colorpicker',
                        'colorpickers' => array(
                            array(
                                'desc' => wp_kses(__( 'Choose colors for the primary button<br/><small>This style will be applied to "Edit title" button on Wishlist view, "Submit Changes" button on Manage view and "Search wishlist" button on Search view</small>', 'organium' ), array(
                                    'br'    => array(),
                                    'small' => array()
                                )),
                                array(
                                    'name' => esc_html__( 'Background', 'organium' ),
                                    'id'   => 'background',
                                    'default' => '#a5bd3a'
                                ),
                                array(
                                    'name' => esc_html__( 'Text', 'organium' ),
                                    'id'   => 'text',
                                    'default' => '#ffffff'
                                ),
                                array(
                                    'name' => esc_html__( 'Border', 'organium' ),
                                    'id'   => 'border',
                                    'default' => '#a5bd3a'
                                ),
                            ),
                            array(
                                'desc' => wp_kses(__( 'Choose colors for the primary button on hover state<br/><small>This style will be applied to "Edit title" button on Wishlist view, "Submit Changes" button on Manage view and "Search wishlist" button on Search view</small>', 'organium' ), array(
                                    'br'    => array(),
                                    'small' => array()
                                )),
                                array(
                                    'name' => esc_html__( 'Background Hover', 'organium' ),
                                    'id'   => 'background_hover',
                                    'default' => '#b4ce41'
                                ),
                                array(
                                    'name' => esc_html__( 'Text Hover', 'organium' ),
                                    'id'   => 'text_hover',
                                    'default' => '#ffffff'
                                ),
                                array(
                                    'name' => esc_html__( 'Border Hover', 'organium' ),
                                    'id'   => 'border_hover',
                                    'default' => '#b4ce41'
                                ),
                            )
                        ),
                        'deps' => array(
                            'id' => 'yith_wcwl_add_to_cart_style',
                            'value' => 'button_custom'
                        )
                    ),

                    'style_2_button_colors' => array(
                        'name'         => esc_html__( 'Secondary button style', 'organium' ),
                        'id'           => 'yith_wcwl_color_button_style_2',
                        'type'         => 'yith-field',
                        'yith-type'    => 'multi-colorpicker',
                        'colorpickers' => array(
                            array(
                                'desc' => wp_kses(__( 'Choose colors of the secondary button<br/><small>This style will be applied to the buttons that allow showing and hiding the Edit title form on Wishlist view and "Create new Wishlist" button on Manage view</small>', 'organium' ), array(
                                    'br'    => array(),
                                    'small' => array()
                                )),
                                array(
                                    'name' => esc_html__( 'Background', 'organium' ),
                                    'id'   => 'background',
                                    'default' => '#fa6c47'
                                ),
                                array(
                                    'name' => esc_html__( 'Text', 'organium' ),
                                    'id'   => 'text',
                                    'default' => '#ffffff'
                                ),
                                array(
                                    'name' => esc_html__( 'Border', 'organium' ),
                                    'id'   => 'border',
                                    'default' => '#fa6c47'
                                ),
                            ),
                            array(
                                'desc' => wp_kses(__( 'Choose colors of the secondary button<br/><small>This style will be applied to the buttons that allow showing and hiding the Edit title form on Wishlist view and "Create new Wishlist" button on Manage view</small>', 'organium' ), array(
                                    'br'    => array(),
                                    'small' => array()
                                )),
                                array(
                                    'name' => esc_html__( 'Background Hover', 'organium' ),
                                    'id'   => 'background_hover',
                                    'default' => '#fb8a6b'
                                ),
                                array(
                                    'name' => esc_html__( 'Text Hover', 'organium' ),
                                    'id'   => 'text_hover',
                                    'default' => '#ffffff'
                                ),
                                array(
                                    'name' => esc_html__( 'Border Hover', 'organium' ),
                                    'id'   => 'border_hover',
                                    'default' => '#fb8a6b'
                                ),
                            )
                        ),
                        'deps' => array(
                            'id' => 'yith_wcwl_add_to_cart_style',
                            'value' => 'button_custom'
                        )
                    ),

                    'wishlist_table_style' => array(
                        'name'         => esc_html__( 'Wishlist table style', 'organium' ),
                        'desc'         => esc_html__( 'Choose the colors for the wishlist table (when set to "Traditional" layout)', 'organium' ),
                        'id'           => 'yith_wcwl_color_wishlist_table',
                        'type'         => 'yith-field',
                        'yith-type'    => 'multi-colorpicker',
                        'colorpickers' => array(
                            array(
                                'name' => esc_html__( 'Background', 'organium' ),
                                'id'   => 'background',
                                'default' => '#FFFFFF'
                            ),
                            array(
                                'name' => esc_html__( 'Text', 'organium' ),
                                'id'   => 'text',
                                'default' => '#2d3131'
                            ),
                            array(
                                'name' => esc_html__( 'Border', 'organium' ),
                                'id'   => 'border',
                                'default' => '#e0e0e0'
                            ),
                        ),
                        'deps' => array(
                            'id' => 'yith_wcwl_add_to_cart_style',
                            'value' => 'button_custom'
                        )
                    ),

                    'headings_style' => array(
                        'name'         => esc_html__( 'Highlight color', 'organium' ),
                        'desc'         => wp_kses(__( 'Choose the color for all sections with background<br/><small>This color will be used as background for the wishlist table heading and footer (when set to "Traditional" layout), and for various form across wishlist views</small>', 'organium' ), array(
                            'br'    => array(),
                            'small' => array(),
                        )),
                        'id'           => 'yith_wcwl_color_headers_background',
                        'type'         => 'yith-field',
                        'yith-type'    => 'colorpicker',
                        'default'      => '#f7f6f1',
                        'deps' => array(
                            'id' => 'yith_wcwl_add_to_cart_style',
                            'value' => 'button_custom'
                        )
                    ),

                    'share_colors' => array(
                        'name'         => esc_html__( 'Share button text color', 'organium' ),
                        'desc'         => esc_html__( 'Choose colors for share buttons text', 'organium' ),
                        'id'           => 'yith_wcwl_color_share_button',
                        'type'         => 'yith-field',
                        'yith-type'    => 'multi-colorpicker',
                        'colorpickers' => array(
                            array(
                                'name' => esc_html__( 'Text', 'organium' ),
                                'id'   => 'color',
                                'default' => '#ffffff'
                            ),
                            array(
                                'name' => esc_html__( 'Text hover', 'organium' ),
                                'id'   => 'color_hover',
                                'default' => '#ffffff'
                            ),
                        ),
                        'deps' => array(
                            'id' => 'yith_wcwl_enable_share',
                            'value' => 'yes'
                        )

                    ),

                    'fb_button_icon' => array(
                        'name'      => esc_html__( 'Facebook share button icon', 'organium' ),
                        'desc'      => esc_html__( 'Select an icon for the Facebook share button', 'organium' ),
                        'id'        => 'yith_wcwl_fb_button_icon',
                        'default'   => 'fa-facebook',
                        'type'      => 'yith-field',
                        'yith-type' => 'select',
                        'class'     => 'icon-select',
                        'options'   => yith_wcwl_get_plugin_icons()
                    ),

                    'fb_button_custom_icon' => array(
                        'name'      => esc_html__( 'Facebook share button custom icon', 'organium' ),
                        'desc'      => esc_html__( 'Upload an icon you\'d like to use for Facebook share button (suggested 32px x 32px)', 'organium' ),
                        'id'        => 'yith_wcwl_fb_button_custom_icon',
                        'default'   => '',
                        'type'      => 'yith-field',
                        'yith-type' => 'upload'
                    ),

                    'fb_button_colors' => array(
                        'name'         => esc_html__( 'Facebook share button style', 'organium' ),
                        'desc'         => esc_html__( 'Choose colors for Facebook share button', 'organium' ),
                        'id'           => 'yith_wcwl_color_fb_button',
                        'type'         => 'yith-field',
                        'yith-type'    => 'multi-colorpicker',
                        'colorpickers' => array(
                            array(
                                'name' => esc_html__( 'Background', 'organium' ),
                                'id'   => 'background',
                                'default' => '#a5bd3a'
                            ),
                            array(
                                'name' => esc_html__( 'Background hover', 'organium' ),
                                'id'   => 'background_hover',
                                'default' => '#fa6c47'
                            ),
                        ),
                    ),

                    'tw_button_icon' => array(
                        'name'      => esc_html__( 'Twitter share button icon', 'organium' ),
                        'desc'      => esc_html__( 'Select an icon for the Twitter share button', 'organium' ),
                        'id'        => 'yith_wcwl_tw_button_icon',
                        'default'   => 'fa-twitter',
                        'type'      => 'yith-field',
                        'yith-type' => 'select',
                        'class'     => 'icon-select',
                        'options'   => yith_wcwl_get_plugin_icons()
                    ),

                    'tw_button_custom_icon' => array(
                        'name'      => esc_html__( 'Twitter share button custom icon', 'organium' ),
                        'desc'      => esc_html__( 'Upload an icon you\'d like to use for Twitter share button (suggested 32px x 32px)', 'organium' ),
                        'id'        => 'yith_wcwl_tw_button_custom_icon',
                        'default'   => '',
                        'type'      => 'yith-field',
                        'yith-type' => 'upload'
                    ),

                    'tw_button_colors' => array(
                        'name'         => esc_html__( 'Twitter share button style', 'organium' ),
                        'desc'         => esc_html__( 'Choose colors for Twitter share button', 'organium' ),
                        'id'           => 'yith_wcwl_color_tw_button',
                        'type'         => 'yith-field',
                        'yith-type'    => 'multi-colorpicker',
                        'colorpickers' => array(
                            array(
                                'name' => esc_html__( 'Background', 'organium' ),
                                'id'   => 'background',
                                'default' => '#a5bd3a'
                            ),
                            array(
                                'name' => esc_html__( 'Background hover', 'organium' ),
                                'id'   => 'background_hover',
                                'default' => '#fa6c47'
                            ),
                        ),
                    ),

                    'pr_button_icon' => array(
                        'name'      => esc_html__( 'Pinterest share button icon', 'organium' ),
                        'desc'      => esc_html__( 'Select an icon for the Pinterest share button', 'organium' ),
                        'id'        => 'yith_wcwl_pr_button_icon',
                        'default'   => 'fa-pinterest',
                        'type'      => 'yith-field',
                        'yith-type' => 'select',
                        'class'     => 'icon-select',
                        'options'   => yith_wcwl_get_plugin_icons()
                    ),

                    'pr_button_custom_icon' => array(
                        'name'      => esc_html__( 'Pinterest share button custom icon', 'organium' ),
                        'desc'      => esc_html__( 'Upload an icon you\'d like to use for Pinterest share button (suggested 32px x 32px)', 'organium' ),
                        'id'        => 'yith_wcwl_pr_button_custom_icon',
                        'default'   => '',
                        'type'      => 'yith-field',
                        'yith-type' => 'upload'
                    ),

                    'pr_button_colors' => array(
                        'name'         => esc_html__( 'Pinterest share button style', 'organium' ),
                        'desc'         => esc_html__( 'Choose colors for Pinterest share button', 'organium' ),
                        'id'           => 'yith_wcwl_color_pr_button',
                        'type'         => 'yith-field',
                        'yith-type'    => 'multi-colorpicker',
                        'colorpickers' => array(
                            array(
                                'name' => esc_html__( 'Background', 'organium' ),
                                'id'   => 'background',
                                'default' => '#a5bd3a'
                            ),
                            array(
                                'name' => esc_html__( 'Background hover', 'organium' ),
                                'id'   => 'background_hover',
                                'default' => '#fa6c47'
                            ),
                        ),
                    ),

                    'em_button_icon' => array(
                        'name'      => esc_html__( 'Email share button icon', 'organium' ),
                        'desc'      => esc_html__( 'Select an icon for the Email share button', 'organium' ),
                        'id'        => 'yith_wcwl_em_button_icon',
                        'default'   => 'fa-envelope-o',
                        'type'      => 'yith-field',
                        'yith-type' => 'select',
                        'class'     => 'icon-select',
                        'options'   => yith_wcwl_get_plugin_icons()
                    ),

                    'em_button_custom_icon' => array(
                        'name'      => esc_html__( 'Email share button custom icon', 'organium' ),
                        'desc'      => esc_html__( 'Upload an icon you\'d like to use for the Email share button (suggested 32px x 32px)', 'organium' ),
                        'id'        => 'yith_wcwl_em_button_custom_icon',
                        'default'   => '',
                        'type'      => 'yith-field',
                        'yith-type' => 'upload'
                    ),

                    'em_button_colors' => array(
                        'name'         => esc_html__( 'Email share button style', 'organium' ),
                        'desc'         => esc_html__( 'Choose colors for the Email share button', 'organium' ),
                        'id'           => 'yith_wcwl_color_em_button',
                        'type'         => 'yith-field',
                        'yith-type'    => 'multi-colorpicker',
                        'colorpickers' => array(
                            array(
                                'name' => esc_html__( 'Background', 'organium' ),
                                'id'   => 'background',
                                'default' => '#a5bd3a'
                            ),
                            array(
                                'name' => esc_html__( 'Background hover', 'organium' ),
                                'id'   => 'background_hover',
                                'default' => '#fa6c47'
                            ),
                        ),
                    ),

                    'wa_button_icon' => array(
                        'name'      => esc_html__( 'WhatsApp share button icon', 'organium' ),
                        'desc'      => esc_html__( 'Select an icon for the WhatsApp share button', 'organium' ),
                        'id'        => 'yith_wcwl_wa_button_icon',
                        'default'   => 'fa-whatsapp',
                        'type'      => 'yith-field',
                        'yith-type' => 'select',
                        'class'     => 'icon-select',
                        'options'   => yith_wcwl_get_plugin_icons()
                    ),

                    'wa_button_custom_icon' => array(
                        'name'      => esc_html__( 'WhatsApp share button custom icon', 'organium' ),
                        'desc'      => esc_html__( 'Upload an icon you\'d like to use for WhatsApp share button (suggested 32px x 32px)', 'organium' ),
                        'id'        => 'yith_wcwl_wa_button_custom_icon',
                        'default'   => '',
                        'type'      => 'yith-field',
                        'yith-type' => 'upload'
                    ),

                    'wa_button_colors' => array(
                        'name'         => esc_html__( 'WhatsApp share button style', 'organium' ),
                        'desc'         => esc_html__( 'Choose colors for WhatsApp share button', 'organium' ),
                        'id'           => 'yith_wcwl_color_wa_button',
                        'type'         => 'yith-field',
                        'yith-type'    => 'multi-colorpicker',
                        'colorpickers' => array(
                            array(
                                'name' => esc_html__( 'Background', 'organium' ),
                                'id'   => 'background',
                                'default' => '#a5bd3a'
                            ),
                            array(
                                'name' => esc_html__( 'Background hover', 'organium' ),
                                'id'   => 'background_hover',
                                'default' => '#fa6c47'
                            ),
                        ),
                    ),

                    'style_section_end' => array(
                        'type' => 'sectionend',
                        'id' => 'yith_wcwl_style_section_settings'
                    ),
                )
            );
            return $args;
        }
    }
}

add_filter('woocommerce_form_field_args', 'organium_wc_form_fields_args', 1);
if ( !function_exists( 'organium_wc_form_fields_args' ) ) {
    function organium_wc_form_fields_args($args) {
        $placeholder = $args['label'];
        $required = $args['required'] == true ? '*' : '';
        $new_args = array(
            'placeholder' => esc_attr($placeholder) . esc_attr($required),
            'label'       => false,
            'default'     => '',
        );
        return array_merge($args, $new_args);
    }
}

// Checkout Page
add_action( 'woocommerce_checkout_before_customer_details', 'organium_wc_billing_details_start_first_column', 10 );
if ( !function_exists( 'organium_wc_billing_details_start_first_column' ) ) {
    function organium_wc_billing_details_start_first_column() {
        echo '<div class="row">';
            echo '<div class="col-lg-8">';
    }
}

add_action( 'woocommerce_checkout_after_customer_details', 'organium_wc_billing_details_end_first_column', 20 );
if ( !function_exists( 'organium_wc_billing_details_end_first_column' ) ) {
    function organium_wc_billing_details_end_first_column() {
        echo '</div>';
    }
}

add_action( 'woocommerce_checkout_before_order_review_heading', 'organium_wc_billing_details_start_second_column', 10 );
if ( !function_exists( 'organium_wc_billing_details_start_second_column' ) ) {
    function organium_wc_billing_details_start_second_column() {
        echo '<div class="col-lg-4">';
    }
}

add_action( 'woocommerce_checkout_after_order_review', 'organium_wc_billing_details_end_second_column', 10 );
if ( !function_exists( 'organium_wc_billing_details_end_second_column' ) ) {
    function organium_wc_billing_details_end_second_column() {
            echo '</div>';
        echo '</div>';
    }
}

remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

add_action( 'woocommerce_checkout_order_review', 'organium_wc_order_review', 10 );
if ( !function_exists( 'organium_wc_order_review' ) ) {
    function organium_wc_order_review() {
        echo '<table class="checkout_cart_table">';
            echo '<tbody>';

            do_action( 'woocommerce_review_order_before_cart_contents' );

            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                    echo '<tr class="' . esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ) . '">';
                        echo '<td class="product-thumbnail">';
                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                            echo sprintf('%s', $thumbnail );
                        echo '</td>';
                        echo '<td class="product-name">';
                            echo '<div class="product-name-title">';
                                echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
                            echo '</div>';
                            echo '<div class="product-name-info">';
                                echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                                echo apply_filters( 'woocommerce_checkout_cart_item_quantity', sprintf( '&nbsp;&times;&nbsp;%s', $cart_item['quantity'] ), $cart_item, $cart_item_key );
                            echo '</div>';
                            echo wc_get_formatted_cart_item_data( $cart_item );
                        echo '</td>';
                        echo '<td class="product-total">';
                            echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
                        echo '</td>';
                        echo '<td class="product-remove">';
							echo apply_filters(
								'woocommerce_cart_item_remove_link',
								sprintf(
								'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									esc_html__( 'Remove this item', 'organium' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								),
								$cart_item_key
							);
						echo '</td>';
                    echo '</tr>';
                }
            }

            do_action( 'woocommerce_review_order_after_cart_contents' );

            echo '</tbody>';
        echo '</table>';
    }
}

add_action( 'woocommerce_checkout_order_review', 'organium_wc_order_totals', 20 );
if ( !function_exists( 'organium_wc_order_totals' ) ) {
    function organium_wc_order_totals() {
        echo '</div>';
        echo '<h3 id="order_total_heading">' . esc_html__( 'Cart Totals', 'organium' ) . '</h3>';
        echo '<div id="order_total" class="woocommerce-checkout-review-total">';
            echo '<table class="checkout_total_table">';
                echo '<tbody>';
                    echo '<tr class="cart-subtotal">';
			            echo '<td>' . esc_html__( 'Subtotal', 'organium' ) . '</td>';
                        echo '<td>';
                            wc_cart_totals_subtotal_html();
                        echo '</td>';
                    echo '</tr>';
                    foreach ( WC()->cart->get_coupons() as $code => $coupon ) {
			            echo '<tr class="cart-discount coupon-' . esc_attr( sanitize_title( $code ) ) . '">';
                            echo '<td>';
                                wc_cart_totals_coupon_label( $coupon );
                            echo '</td>';
                            echo '<td>';
                                wc_cart_totals_coupon_html( $coupon );
                            echo '</td>';
			            echo '</tr>';
		            }
                    foreach ( WC()->cart->get_fees() as $fee ) {
                        echo '<tr class="fee">';
                            echo '<td>' . esc_html( $fee->name ) . '</td>';
                            echo '<td>';
                                wc_cart_totals_fee_html( $fee );
                            echo '</td>';
                        echo '</tr>';
                    }
                    if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
			            if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
                            foreach (WC()->cart->get_tax_totals() as $code => $tax) {
                                echo '<tr class="tax-rate tax-rate-' . esc_attr(sanitize_title($code)) . '">';
                                echo '<td>' . esc_html($tax->label) . '</td>';
                                echo '<td>' . wp_kses_post($tax->formatted_amount) . '</td>';
                                echo '</tr>';
                            }
                        } else {
				            echo '<tr class="tax-total">';
					            echo '<td>' . esc_html( WC()->countries->tax_or_vat() ) . '</td>';
					            echo '<td>';
					                wc_cart_totals_taxes_total_html();
					            echo '</td>';
				            echo '</tr>';
			            }
		            }

		            do_action( 'woocommerce_review_order_before_order_total' );

		            echo '<tr class="order-total">';
			            echo '<td>' . esc_html__( 'Total', 'organium' ) . '</td>';
			            echo '<td>';
			                wc_cart_totals_order_total_html();
			            echo '</td>';
		            echo '</tr>';

		            do_action( 'woocommerce_review_order_after_order_total' );

                echo '</tbody>';
            echo '</table>';
        echo '</div>';

        echo '<div class="place-order">';
		    echo '<noscript>';
			    printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'organium' ), '<em>', '</em>' );
			    echo '<br/>';
			    echo '<button type="submit" class="button" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update totals', 'organium' ) . '">' . esc_html__( 'Update totals', 'organium' ) . '</button>';
		    echo '</noscript>';

		    do_action( 'woocommerce_review_order_before_submit' );

		    echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr__( 'Place order', 'organium' ) . '" data-value="' . esc_attr__( 'Place order', 'organium' ) . '">' . esc_html__( 'Place order', 'organium' ) . '</button>' );

		    do_action( 'woocommerce_review_order_after_submit' );

		    wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' );
    }
}

add_action( 'woocommerce_checkout_after_customer_details', 'organium_wc_checkout_shipping', 10 );
if ( !function_exists( 'organium_wc_checkout_shipping' ) ) {
    function organium_wc_checkout_shipping() {
        if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) {
            echo '<h3 id="order_shipping_heading">' . esc_html__( 'Shipping Method', 'organium' ) . '</h3>';
            echo '<div id="order_shipping" class="woocommerce-checkout-shipping-method">';

                do_action( 'woocommerce_review_order_before_shipping' );

                wc_cart_totals_shipping_html();

                do_action( 'woocommerce_review_order_after_shipping' );

            echo '</div>';
		}
    }
}

add_action( 'woocommerce_checkout_after_customer_details', 'organium_wc_checkout_payment', 15 );
if ( !function_exists( 'organium_wc_checkout_payment' ) ) {
    function organium_wc_checkout_payment() {
        if ( WC()->cart->needs_payment() ) {
            $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
            WC()->payment_gateways()->set_current_gateway( $available_gateways );
        } else {
            $available_gateways = array();
        }

        if ( WC()->cart->needs_payment() ) {
            echo '<h3 id="order_payment_heading">' . esc_html__( 'Payment Method', 'organium' ) . '</h3>';
            echo '<div id="payment" class="woocommerce-checkout-payment-method">';
                echo '<ul class="wc_payment_methods payment_methods methods">';
                    if ( ! empty( $available_gateways ) ) {
                        foreach ( $available_gateways as $gateway ) {
                            wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
                        }
                    } else {
                        echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'organium' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'organium' ) ) . '</li>';
                    }
                echo '</ul>';
            echo '</div>';
        }
	}
}

// 'My account' Log In Form
add_action('woocommerce_after_checkout_validation', 'organium_wc_confirm_password_matches', 10, 2);

if ( !function_exists( 'organium_wc_confirm_password_matches' ) ) {
    function organium_wc_confirm_password_matches($posted ) {
        $checkout = WC()->checkout;
        if ( ! is_user_logged_in() && ( $checkout->must_create_account || ! empty( $posted['createaccount'] ) ) ) {
            if ( strcmp( $posted['password'], $posted['password2'] ) !== 0 ) {
                wc_add_notice( esc_html__( 'Passwords do not match.', 'organium' ), 'error' );
            }
        }
    }
}
add_filter('woocommerce_registration_errors', 'organium_wc_registration_errors_validation', 10, 3 );
if ( !function_exists( 'organium_wc_registration_errors_validation' ) ) {
    function organium_wc_registration_errors_validation($reg_errors) {
        if (strcmp( $_POST['password'], $_POST['password2'] ) !== 0) {
            return new WP_Error('registration-error', esc_html__('Passwords do not match.', 'organium'));
        }
        return $reg_errors;
    }
}


// Rewrite WooCommerce Quantity template
if ( ! function_exists( 'woocommerce_quantity_input' ) ) {
    function woocommerce_quantity_input( $args = array(), $product = null, $echo = true ) {
        if ( is_null( $product ) ) {
            $product = $GLOBALS['product'];
        }

        $defaults = array(
            'input_id'     => uniqid( 'quantity_' ),
            'input_name'   => 'quantity',
            'input_value'  => '1',
            'classes'      => apply_filters( 'woocommerce_quantity_input_classes', array( 'input-text', 'qty', 'text' ), $product ),
            'max_value'    => apply_filters( 'woocommerce_quantity_input_max', -1, $product ),
            'min_value'    => apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
            'step'         => apply_filters( 'woocommerce_quantity_input_step', 1, $product ),
            'pattern'      => apply_filters( 'woocommerce_quantity_input_pattern', has_filter( 'woocommerce_stock_amount', 'intval' ) ? '[0-9]*' : '' ),
            'inputmode'    => apply_filters( 'woocommerce_quantity_input_inputmode', has_filter( 'woocommerce_stock_amount', 'intval' ) ? 'numeric' : '' ),
            'product_name' => $product ? $product->get_title() : '',
            'placeholder'  => apply_filters( 'woocommerce_quantity_input_placeholder', '', $product ),
        );

        $args = apply_filters( 'woocommerce_quantity_input_args', wp_parse_args( $args, $defaults ), $product );

        // Apply sanity to min/max args - min cannot be lower than 0.
        $args['min_value'] = max( $args['min_value'], 0 );
        $args['max_value'] = 0 < $args['max_value'] ? $args['max_value'] : '';

        // Max cannot be lower than min if defined.
        if ( '' !== $args['max_value'] && $args['max_value'] < $args['min_value'] ) {
            $args['max_value'] = $args['min_value'];
        }

        ob_start();

        if ( $args['max_value'] && $args['min_value'] === $args['max_value'] ) {
            ?>
            <div class="quantity hidden">
                <input type="hidden" id="<?php echo esc_attr( $args['input_id'] ); ?>" class="qty" name="<?php echo esc_attr( $args['input_name'] ); ?>" value="<?php echo esc_attr( $args['min_value'] ); ?>" />
            </div>
            <?php
        } else {
            $label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'organium' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'organium' );
            ?>
            <div class="quantity">
                <?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
                <label class="screen-reader-text" for="<?php echo esc_attr( $args['input_id'] ); ?>"><?php echo esc_attr( $label ); ?></label>
                <input
                        type="number"
                        id="<?php echo esc_attr( $args['input_id'] ); ?>"
                        class="<?php echo esc_attr( join( ' ', (array) $args['classes'] ) ); ?>"
                        step="<?php echo esc_attr( $args['step'] ); ?>"
                        min="<?php echo esc_attr( $args['min_value'] ); ?>"
                        <?php echo esc_html( 0 < $args['max_value'] ? ' max=' . $args['max_value'] : '' ); ?>
                        name="<?php echo esc_attr( $args['input_name'] ); ?>"
                        value="<?php echo esc_attr( $args['input_value'] ); ?>"
                        title="<?php esc_attr_e( 'Qty', 'organium' ); ?>"
                        placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"
                        inputmode="<?php echo esc_attr( $args['inputmode'] ); ?>" />
                <?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
            </div>
            <?php
        }

        if ( $echo ) {
            echo ob_get_clean(); // WPCS: XSS ok.
        } else {
            return ob_get_clean();
        }
    }
}