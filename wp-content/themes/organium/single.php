<?php
/*
 * Created by Artureanec
*/

the_post();
get_header();

if ( organium_get_post_option('sidebar_name') && organium_get_post_option('sidebar_name') != 'default' ) {
    $organium_sidebar_name = organium_get_post_option('sidebar_name');
} else {
    $organium_sidebar_name = 'sidebar-blog';
}

if ( is_active_sidebar($organium_sidebar_name) ) {
    if ( organium_get_post_option('sidebar_position') && organium_get_post_option('sidebar_position') != 'default' ) {
        $organium_sidebar_position = organium_get_post_option('sidebar_position');
    } else {
        $organium_sidebar_position = organium_get_prefered_option('post_sidebar_position');
    }
} else {
    $organium_sidebar_position = 'none';
}

$categories = get_the_category();
$categ_code = array();
if (is_array($categories)) {
    foreach ($categories as $category) {
        $categ_code[] = '
            <span class="organium_category" style="background-color: #'.esc_attr(get_term_meta($category->term_id, '_category_bg_color', true)).'; color: #'.esc_attr(get_term_meta($category->term_id, '_category_font_color', true)).';">' . esc_html($category->name) . '</span>
        ';
    }
}


// --- Page Title Block --- //
if (organium_get_prefered_option('page_title_status') == 'show') {
    echo organium_page_title_block_output();
}
?>

<div id="post-<?php the_ID(); ?>" class="organium_single_post_container">
    <div class="organium_blog_content_wrapper<?php echo (organium_get_prefered_option('content_top_margin') == 'yes' ? ' with_top_margin' : '') . (organium_get_prefered_option('content_bottom_margin') == 'yes' ? ' with_bottom_margin' : ''); ?>">
        <div class="container">
            <div class="row organium_sidebar_<?php echo esc_attr($organium_sidebar_position); ?>">
                <!-- Content Container -->
                <div class="col-lg-<?php echo ((is_active_sidebar('sidebar') && $organium_sidebar_position !== 'none') ? '9' : '12'); ?>">
                    <div class="single_post_content">
                        <?php
                        if (organium_get_prefered_option('media_output_status') == 'show') {
                            echo '<div class="organium_media_output">';
                                if ( is_array($categ_code) && count($categ_code) > 0 ) {
                                    echo '<div class="organium_media_categories">';
                                        echo join('', $categ_code);
                                    echo '</div>';
                                }
                                echo organium_post_media_output();
                            echo '</div>';
                        }

                        if (organium_get_prefered_option('post_meta_status') == 'show') {
                            echo '<div class="organium_post_meta_container">';
                                echo '<div class="organium_post_meta post_meta_columns">';
                                    if ( !empty(get_the_date()) || !empty(get_the_author()) ) {
                                        echo '<div class="post_meta_left">';
                                            if ( !empty(get_the_date()) ) {
                                                echo '<div class="organium_post_meta_item meta_item meta_item_date">';
                                                    echo '<a href="' . get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')) . '">' . get_the_date() . "</a>";
                                                echo '</div>';
                                            }
                                            if ( !empty(get_the_author()) ) {
                                                echo '<div class="organium_post_meta_item meta_item meta_item_author">';
                                                    echo esc_html__('By ', 'organium') . get_the_author_posts_link();
                                                echo '</div>';
                                            }
                                        echo '</div>';
                                    }
                                    echo '<div class="post_meta_right">';
                                        echo '<div class="organium_post_meta_item meta_item meta_item_comments">';
                                            echo get_comments_number() . ' ' . esc_html(_n('comment', 'comments', get_comments_number(), 'organium'));
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }
                        ?>

                        <div class="organium_heading_wrapper">
                            <h3 class="organium_single_post_title"><?php the_title(); ?></h3>
                        </div>

                        <div class="organium_content_wrapper">
                            <?php the_content(); ?>
                        </div>

                        <?php wp_link_pages(array('before' => '<div class="organium_pagination"><nav class="pagination"><div class="nav-links">', 'after' => '</div></nav></div>')); ?>

                        <?php
                        if (organium_get_prefered_option('after_content_panel_status') == 'show') {
                            ?>
                            <div class="organium_post_details_container">
                                <div class="flex-sm-row row organium_post_meta justify-content-between">
                                    <div class="col-sm-auto">
                                        <?php
                                            if ( !empty(get_the_tag_list()) ) {
                                                echo get_the_tag_list('<div class="organium_post_meta_item meta_item meta_item_tags">', ', ', '</div>');
                                            }
                                        ?>
                                    </div>
                                    <div class="col-sm-auto flex-shrink-0">
                                        <?php echo organium_socials_output('organium_post_meta_item meta_item meta_item_socials'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <?php
                    if ( organium_get_prefered_option('comments_status') == 'show' ) {
                        comments_template();
                    }
                    ?>
                </div>

                <!-- Sidebar Container -->
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>

    <?php
    if (organium_get_prefered_option('recent_posts_status') == 'show') {
        organium_recent_posts_output(
            array(
                'orderby' => organium_get_prefered_option('recent_posts_order_by'),
                'numberposts' => organium_get_prefered_option('recent_posts_number'),
                'post_type' => get_post_type(),
                'order' => organium_get_prefered_option('recent_posts_order'),
                'show_image' => organium_get_prefered_option('recent_posts_image'),
                'show_category' => organium_get_prefered_option('recent_posts_category'),
                'show_title' => organium_get_prefered_option('recent_posts_title'),
                'show_date' => organium_get_prefered_option('recent_posts_date'),
                'show_author' => organium_get_prefered_option('recent_posts_author'),
                'show_excerpt' => organium_get_prefered_option('recent_posts_excerpt'),
                'show_excerpt_length' => organium_get_prefered_option('recent_posts_excerpt_length'),
                'show_tags' => organium_get_prefered_option('recent_posts_tags'),
                'show_more' => organium_get_prefered_option('recent_posts_more')
            )
        );
    }
    ?>
</div>

<?php
get_footer();
