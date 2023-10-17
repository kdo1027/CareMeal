<?php
/*
 * Created by Artureanec
*/

get_header();

$organium_sidebar_position = organium_get_theme_mod('archive_sidebar_position');
$organium_sidebar_name = 'sidebar-portfolio';

// --- Page Title Block --- //
if (organium_get_theme_mod('page_title_status') == 'show') {
    echo organium_page_title_block_output();
}
?>

    <div id="post-<?php the_ID(); ?>" class="organium_page_content_container">
        <div class="organium_page_content_wrapper<?php echo (organium_get_prefered_option('content_top_margin') == 'yes' ? ' with_top_margin' : '') . (organium_get_prefered_option('content_bottom_margin') == 'yes' ? ' with_bottom_margin' : ''); ?>">
            <div class="container">
                <div class="row organium_sidebar_<?php echo esc_attr($organium_sidebar_position); ?>">
                    <!-- Content Container -->
                    <div class="col-lg-<?php echo ((is_active_sidebar('sidebar') && $organium_sidebar_position !== 'none') ? '9' : '12'); ?>">
                        <div class="organium_content_wrapper">

                            <div class="organium_archive_listing">
                                <div class="organium_archive_listing_wrapper">
                                    <?php
                                    while (have_posts()) : the_post();
                                        get_template_part('content');
                                    endwhile;
                                    ?>
                                </div>

                                <div class="organium_pagination">
                                    <?php
                                    echo get_the_posts_pagination(array(
                                        'prev_text' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                                        'next_text' => '<i class="fa fa-angle-right" aria-hidden="true"></i>'
                                    ));
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Sidebar Container -->
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer();
