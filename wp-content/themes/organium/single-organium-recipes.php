<?php
/*
 * Created by Artureanec
*/

the_post();
get_header();

global $post;
$organium_sidebar_name = 'sidebar-recipes';
if ( is_active_sidebar('sidebar-recipes') ) {
    $organium_sidebar_position = organium_get_prefered_option('recipe_sidebar_position');
} else {
    $organium_sidebar_position = 'none';
}

$categories = get_the_terms( $post->ID , 'recipes-category' );
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

<div id="recipe-<?php the_ID(); ?>" class="organium_single_recipe_container">
    <div class="organium_blog_content_wrapper<?php echo (organium_get_prefered_option('content_top_margin') == 'yes' ? ' with_top_margin' : '') . (organium_get_prefered_option('content_bottom_margin') == 'yes' ? ' with_bottom_margin' : ''); ?>">
        <div class="container">
            <div class="row organium_sidebar_<?php echo esc_attr($organium_sidebar_position); ?>">
                <!-- Content Container -->
                <div class="col-lg-<?php echo ((is_active_sidebar('sidebar-recipes') && $organium_sidebar_position !== 'none') ? '9' : '12'); ?>">
                    <div class="single_recipe_content">
                        <?php
                        if (organium_get_prefered_option('media_output_status') == 'show') {
                            echo '<div class="organium_media_output">';
                                echo organium_post_media_output();
                            echo '</div>';
                        }

                        if (organium_get_prefered_option('post_meta_status') == 'show') {
                            echo '<div class="organium_post_meta_container">';
                                if ( is_array($categ_code) && count($categ_code) > 0 ) {
                                    echo '<div class="organium_media_categories">';
                                        echo join('', $categ_code);
                                    echo '</div>';
                                }
                            echo '</div>';
                        }
                        ?>
                        <div class="organium_heading_wrapper">
                            <h2 class="organium_single_post_title"><?php the_title(); ?></h2>
                        </div>

                        <div class="organium_content_wrapper">
                            <?php the_content(); ?>
                        </div>

                        <div class="organium_ingredients_wrapper">
                            <div class="row">
                                <div class="col-md-6 ingredient_column">
                                    <?php
                                        if ( !empty(organium_get_post_value('recipe_difficulty_level')) ) {
                                            echo '<div class="ingredient_item">';
                                                echo '<div class="ingredient_item_title">' . esc_html__('Level :', 'organium') . '</div>';
                                                echo '<div class="ingredient_item_value">';
                                                    echo organium_get_post_value('recipe_difficulty_level');
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                        if ( !empty(organium_get_post_option('recipe_total_time')) ) {
                                            echo '<div class="ingredient_item">';
                                                echo '<div class="ingredient_item_title">' . esc_html__('Total time :', 'organium') . '</div>';
                                                echo '<div class="ingredient_item_value">';
                                                    echo esc_html(organium_get_post_time('recipe_total_time'));
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                    ?>
                                </div>
                                <div class="col-md-6 ingredient_column">
                                    <?php
                                        if ( !empty(organium_get_post_option('recipe_prep_time')) ) {
                                            echo '<div class="ingredient_item">';
                                                echo '<div class="ingredient_item_title">' . esc_html__('Prep time :', 'organium') . '</div>';
                                                echo '<div class="ingredient_item_value">';
                                                    echo esc_html(organium_get_post_time('recipe_prep_time'));
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                        if ( !empty(organium_get_post_option('recipe_total_time')) ) {
                                            echo '<div class="ingredient_item">';
                                                echo '<div class="ingredient_item_title">' . esc_html__('Cooking time :', 'organium') . '</div>';
                                                echo '<div class="ingredient_item_value">';
                                                    echo esc_html(organium_get_post_time('recipe_cooking_time'));
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <?php
                                        if ( !empty(organium_get_post_image('recipe_ingredients_image')) ) {
                                            echo '<div class="ingredients_img">';
                                                echo organium_get_post_image('recipe_ingredients_image');
                                            echo '</div>';
                                        }

                                        $ingredients = organium_get_post_option('recipe_ingredients_list');
                                        if ( !empty($ingredients) ) {
                                            echo '<div class="ingredients_list">';
                                                echo '<h4>' . esc_html__('Ingredients:', 'organium') . '</h4>';
                                                echo '<ul>';
                                                if ( is_array($ingredients) ) {
                                                    foreach ($ingredients as $ingredient) {
                                                        echo '<li>' . esc_html($ingredient) . '</li>';
                                                    }
                                                } else {
                                                    echo '<li>' . esc_html($ingredients) . '</li>';
                                                }
                                                echo '</ul>';
                                            echo '</div>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <?php

                        if ( !empty(rwmb_meta('recipe_instructions')) ) {
                            echo '<div class="organium_instructions_wrapper">';
                                echo '<h4>' . esc_html__('Instructions:', 'organium') . '</h4>';
                                $values = rwmb_meta( 'recipe_instructions' );
                                if ( is_array($ingredients) ) {
                                    $counter = 1;
                                    foreach ($values as $value) {
                                        echo '<div class="organium_instructions_item">';
                                            echo '<div class="organium_instructions_bullet"></div>';
                                            echo '<div class="organium_instructions_num">' . esc_html($counter) . '.' . '</div>';
                                            echo do_shortcode(wpautop($value));
                                        echo '</div>';
                                        $counter++;
                                    }
                                } else {
                                    echo '<div class="organium_instructions_item"><div class="organium_instructions_num">'.esc_html($counter) . '.'.'</div>' . do_shortcode(wpautop($values)) . '</div>';
                                }
                            echo '</div>';
                        }

                        if (organium_get_prefered_option('after_content_panel_status') == 'show') {
                            ?>
                            <div class="organium_post_details_container">
                                <div class="flex-sm-row row organium_post_meta justify-content-between">
                                    <div class="col-sm-auto">
                                        <?php
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
                    if (organium_get_prefered_option('comments_status') == 'show') {
                        comments_template();
                    }
                    ?>
                </div>

                <!-- Sidebar Container -->
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
