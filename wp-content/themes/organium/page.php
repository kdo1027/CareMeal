<?php
/*
 * Created by Artureanec
*/

the_post();
get_header();

if ( organium_get_post_option('sidebar_name') && organium_get_post_option('sidebar_name') != 'default' ) {
    $organium_sidebar_name = organium_get_post_option('sidebar_name');
} else {
    $organium_sidebar_name = 'sidebar';
}
if ( function_exists( 'yith_plugin_registration_hook' ) && yith_wcwl_is_wishlist_page() ) {
    $organium_sidebar_position = 'none';
} elseif ( is_active_sidebar($organium_sidebar_name) ) {
    $organium_sidebar_position = organium_get_prefered_option('sidebar_position');
} else {
    $organium_sidebar_position = 'none';
}

// --- Page Title Block --- //
if (organium_get_prefered_option('page_title_status') == 'show') {
    echo organium_page_title_block_output();
}
?>

<div id="post-<?php the_ID(); ?>" class="organium_page_content_container">
    <div class="organium_page_content_wrapper<?php echo (organium_get_prefered_option('content_top_margin') == 'yes' ? ' with_top_margin' : '') . (organium_get_prefered_option('content_bottom_margin') == 'yes' ? ' with_bottom_margin' : ''); ?>">
        <div class="container">
            <div class="row organium_sidebar_<?php echo esc_attr($organium_sidebar_position); ?>">
                <!-- Content Container -->
                <div class="col-lg-<?php echo ((is_active_sidebar($organium_sidebar_name) && $organium_sidebar_position !== 'none') ? '9' : '12'); ?>">
                    <div class="organium_content_wrapper">
                        <?php the_content(); ?>
                    </div>

                    <?php wp_link_pages(array('before' => '<div class="organium_pagination"><nav class="pagination"><div class="nav-links">', 'after' => '</div></nav></div>')); ?>

                    <?php comments_template(); ?>
                </div>

                <!-- Sidebar Container -->
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();