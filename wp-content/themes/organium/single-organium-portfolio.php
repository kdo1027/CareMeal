<?php
/*
 * Created by Artureanec
*/

the_post();
get_header();

global $post;
$organium_sidebar_name = 'sidebar-portfolio';
if ( is_active_sidebar('sidebar-portfolio') ) {
    $organium_sidebar_position = organium_get_prefered_option('portfolio_sidebar_position');
} else {
    $organium_sidebar_position = 'none';
}

$categories = get_the_terms( $post->ID , 'portfolio-category' );
$categ_code = array();

if (is_array($categories)) {
    foreach ($categories as $category) {
        $categ_code[] = esc_html($category->name);
    }
}

// --- Page Title Block --- //
if (organium_get_prefered_option('page_title_status') == 'show') {
    echo organium_page_title_block_output();
}
?>

<div id="portfolio-<?php the_ID(); ?>" class="organium_single_portfolio_container">
    <div class="organium_blog_content_wrapper<?php echo (organium_get_prefered_option('content_top_margin') == 'yes' ? ' with_top_margin' : '') . (organium_get_prefered_option('content_bottom_margin') == 'yes' ? ' with_bottom_margin' : ''); ?>">
        <div class="container">
            <div class="row organium_sidebar_<?php echo esc_attr($organium_sidebar_position); ?>">
                <!-- Content Container -->
                <div class="col-lg-<?php echo ((is_active_sidebar('sidebar-portfolio') && $organium_sidebar_position !== 'none') ? '9' : '12'); ?>">

                    <div class="organium_content_wrapper">
                        <div class="organium_portfolio_gallery">
                            <?php
                                echo organium_get_post_image('portfolio_gallery');
                            ?>
                        </div>
                        <div class="organium_portfolio_content">
                            <h5 class="organium_single_post_title"><?php the_title(); ?></h5>
                            <?php the_content(); ?>
                            <div class="organium_portfolio_meta">
                                <?php
                                    if ( is_array($categ_code) && count($categ_code) > 0 ) {
                                        echo '<div class="organium_portfolio_meta_item meta_item meta_item_category">';
                                            echo (count($categ_code) > 1 ? '<span class="meta_item_label">' . esc_html__('Categories: ', 'organium') . '</span>' : '<span class="meta_item_label">' . esc_html__('Category: ', 'organium') . '</span>') . join(', ', $categ_code);
                                        echo '</div>';
                                    }
                                    if ( !empty(organium_get_post_option('portfolio_author')) ) {
                                        echo '<div class="organium_portfolio_meta_item meta_item meta_item_author">';
                                            echo '<span class="meta_item_label">' . esc_html__('Author: ', 'organium') . '</span>';
                                            echo esc_html(organium_get_post_option('portfolio_author'));
                                        echo '</div>';
                                    }
                                    if ( !empty(organium_get_post_option('portfolio_client')) ) {
                                        echo '<div class="organium_portfolio_meta_item meta_item meta_item_client">';
                                            echo '<span class="meta_item_label">' . esc_html__('Client: ', 'organium') . '</span>';
                                            echo esc_html(organium_get_post_option('portfolio_client'));
                                        echo '</div>';
                                    }
                                    if ( !empty(get_the_date()) ) {
                                        echo '<div class="organium_portfolio_meta_item meta_item meta_item_date">';
                                            echo '<span class="meta_item_label">' . esc_html__('Date: ', 'organium') . '</span>';
                                            echo get_the_date();
                                        echo '</div>';
                                    }
                                    if ( !empty(organium_socials_output()) ) {
                                        echo '<div class="organium_portfolio_meta_item meta_item meta_item_socials organium_post_meta">';
                                            echo '<span class="meta_item_label">' . esc_html__('Share: ', 'organium') . '</span>';
                                            echo organium_socials_output('organium_post_meta_item meta_item meta_item_socials');
                                        echo '</div>';
                                    }
                                ?>


                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Container -->
                <?php get_sidebar(); ?>
            </div>

            <!-- Post Navigation -->
            <?php
                $first_post_loop = get_posts( 'post_type='.get_post_type().'&numberposts=1&order=ASC' );
                $first_post = $first_post_loop[0];
    
                $last_post_loop = get_posts( 'post_type='.get_post_type().'&numberposts=1' );
                $last_post = $last_post_loop[0];
    
                $next_post = get_next_post() ? get_next_post() : $first_post;
                $prev_post = get_previous_post() ? get_previous_post() : $last_post;
                $post_type = get_post_type_object( get_post()->post_type );
    
                if ( get_next_post() || get_previous_post() ) {
                    echo '<nav class="navigation post_navigation">';
                        echo '<ul class="post_navigation_list">';
                        if ( $prev_post ) {
                            echo '<li class="prev_post">';
                                echo '<div class="post_nav_link">';
                                    echo '<a href="' . get_permalink( $prev_post ) . '">';
                                        esc_html_e('Previous Post', 'organium');
                                    echo '</a>';
                                echo '</div>';
                                echo '<div class="post_nav_item">';
                                    $thumbnail = get_the_post_thumbnail_url($prev_post->ID, array(75, 75));
                                    if ( !empty($thumbnail) ) {
                                        echo '<a href="' . get_permalink($prev_post) . '" class="post_nav_image">';
                                            echo '<img src="' . esc_url($thumbnail) . '" alt="' . esc_attr($prev_post->post_title) . '"/>';
                                        echo '</a>';
                                    }
                                    echo '<div class="post_nav_content">';
                                        echo '<div class="post_nav_text_wrapper">';
                                            echo '<a href="' . get_permalink( $prev_post ) . '">';
                                                if ( function_exists('wpm') ) {
                                                    echo wpm_translate_string(wp_kses_post( $prev_post->post_title ));
                                                } else {
                                                    echo wp_kses_post( $prev_post->post_title );
                                                }
                                            echo '</a>';
                                        echo '</div>';
                                        if( !empty(get_the_category_list( ', ', '', $prev_post->ID )) ) {
                                            echo '<div class="post_nav_cats">';
                                                echo get_the_category_list( ', ', '', $prev_post->ID );
                                            echo '</div>';
                                        }
                                        $prev_categories = organium_get_portfolio_nav_categories($prev_post->ID);
                                        if( !empty($prev_categories) ) {
                                            echo '<div class="post_nav_cats">';
                                                echo sprintf('%s', $prev_categories);
                                            echo '</div>';
                                        }
                                    echo '</div>';
                                echo '</div>';
                            echo '</li>';
                        } else {
                            echo '<li class="prev_post disabled"></li>';
                        }
                        echo '<li class="archive_dots">';
                            echo '<a href="' . get_post_type_archive_link(get_post()->post_type) . '">';
                                echo '<span class="icon flaticon-menu"></span>';
                            echo '</a>';
                        echo '</li>';
                        if ( $next_post ) {
                            echo '<li class="next_post">';
                                echo '<div class="post_nav_link">';
                                    echo '<a href="' . get_permalink( $next_post ) . '">';
                                        esc_html_e('Next Post', 'organium');
                                    echo '</a>';
                                echo '</div>';
                                echo '<div class="post_nav_item">';
                                    echo '<div class="post_nav_content">';
                                        echo '<div class="post_nav_text_wrapper">';
                                            echo '<a href="' . get_permalink( $next_post ) . '">';
                                                if ( function_exists('wpm') ) {
                                                    echo wpm_translate_string(wp_kses_post( $next_post->post_title ));
                                                } else {
                                                    echo wp_kses_post( $next_post->post_title );
                                                }
                                            echo '</a>';
                                        echo '</div>';
                                        if ( !empty(get_the_category_list( ', ', '', $next_post->ID )) ) {
                                            echo '<div class="post_nav_cats">';
                                                echo get_the_category_list( ', ', '', $next_post->ID );
                                            echo '</div>';
                                        }
                                        $next_categories = organium_get_portfolio_nav_categories($next_post->ID);
                                        if ( !empty($next_categories) ) {
                                            echo '<div class="post_nav_cats">';
                                                echo sprintf('%s', $next_categories);
                                            echo '</div>';
                                        }
                                    echo '</div>';
                                    $thumbnail = get_the_post_thumbnail_url($next_post->ID, array(75, 75));
                                    if ( !empty($thumbnail) ) {
                                        echo '<a href="' . get_permalink( $next_post ) . '" class="post_nav_image">';
                                            echo '<img src="' . esc_url($thumbnail) . '" alt="' . esc_attr($next_post->post_title) . '" />';
                                        echo '</a>';
                                    }
                                echo '</div>';
                            echo '</li>';
                        } else {
                            echo '<li class="next_post disabled"></li>';
                        }
                        echo '</ul>';
                    echo '</nav>';
                }
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
