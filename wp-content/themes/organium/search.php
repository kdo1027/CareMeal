<?php
/*
 * Created by Artureanec
*/

get_header();

// --- Page Title Block --- //
if (organium_get_theme_mod('page_title_status') == 'show') {
    echo organium_page_title_block_output();
}
?>

    <div id="post-<?php the_ID(); ?>" class="organium_page_content_container">
        <div class="organium_page_content_wrapper<?php echo (organium_get_theme_mod('content_top_margin') == 'yes' ? ' with_top_margin' : '') . (organium_get_theme_mod('content_bottom_margin') == 'yes' ? ' with_bottom_margin' : ''); ?>">
            <div class="container">
                <div class="row organium_sidebar_none">
                    <!-- Content Container -->
                    <div class="col-12">
                        <div class="organium_content_wrapper">

                            <div class="organium_archive_listing">
                                <?php
                                    global $wp_query;
                                    if ( 0 === strlen($wp_query->query_vars['s'] ) || 0 === strlen(preg_replace('/\s+/', '', $wp_query->query_vars['s'])) ){
                                        echo '<div class="organium_archive_listing_wrapper">';
                                            echo '<h2 class="organium_no_results_title">' . esc_html__( 'Empty search string!', 'organium' ) . '</h2>';
                                            echo '<p class="organium_no_results_text">' . esc_html__( 'Please, enter some characters to search field', 'organium' ) . '</p>';
                                            echo '<div class="organium_no_result_search_form">';
                                                get_search_form(true);
                                            echo '</div>';
                                        echo '</div>';
                                    } else {
                                        echo '<div class="organium_archive_listing_wrapper">';
                                            if (have_posts()) {
                                                while (have_posts()) : the_post();
                                                    get_template_part('content', 'search');
                                                endwhile;
                                            } else {
                                                ?>
                                                <h2 class="organium_no_results_title"><?php esc_html_e('Oops! Nothing Found!', 'organium'); ?></h2>

                                                <div class="organium_no_result_search_form">
                                                    <?php get_search_form(true); ?>
                                                </div>
                                                <?php
                                            }
                                        echo '</div>';

                                        echo '<div class="organium_pagination">';
                                            echo get_the_posts_pagination(array(
                                                'prev_text' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                                                'next_text' => '<i class="fa fa-angle-right" aria-hidden="true"></i>'
                                            ));
                                        echo '</div>';
                                    }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer();
