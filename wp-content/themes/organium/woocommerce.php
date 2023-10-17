<?php
/*
 * Created by Artureanec
*/

get_header();

$organium_sidebar_name = 'sidebar-woocommerce';
if ( (is_shop() || is_product_category()) && !is_product() && is_active_sidebar('sidebar-woocommerce') ) {
    global $post;
    $page_id = wc_get_page_id('shop');
    $post = get_post($page_id);
    $organium_sidebar_position = organium_get_prefered_option('catalog_sidebar_position');
} else {
    $organium_sidebar_position = 'none';
}

// --- Page Title Block --- //
if (organium_get_prefered_option('page_title_status') == 'show') {
    echo organium_page_title_block_output();
}
?>

<div id="post-<?php the_ID(); ?>" class="organium_page_content_container">
    <div class="organium_page_content_wrapper organium_woocommerce_wrapper<?php echo (organium_get_prefered_option('content_top_margin') == 'yes' ? ' with_top_margin' : '') . (organium_get_prefered_option('content_bottom_margin') == 'yes' ? ' with_bottom_margin' : ''); ?>">
        <div class="container">
            <div class="row organium_sidebar_<?php echo esc_attr($organium_sidebar_position); ?>">
                <!-- Content Container -->
                <div class="col-lg-<?php echo ((is_active_sidebar('sidebar-woocommerce') && $organium_sidebar_position !== 'none') ? '9' : '12'); ?>">
                    <div class="organium_content_wrapper">
                        <?php
                        woocommerce_content();
                        ?>
                    </div>

                    <?php wp_link_pages(array('before' => '<div class="organium_pagination"><nav class="pagination"><div class="nav-links">', 'after' => '</div></nav></div>')); ?>

                </div>

                <!-- Sidebar Container -->
                <?php get_sidebar('woocommerce'); ?>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();