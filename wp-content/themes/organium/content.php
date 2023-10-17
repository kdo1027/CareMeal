<?php
$featured_image_url = organium_get_featured_image_url();
$image_alt_text = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);

if (function_exists('aq_resize')) {
    $featured_image_src = aq_resize($featured_image_url, 1170, 561, true, true, true);
} else {
    $featured_image_src = $featured_image_url;
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


//$organium_excerpt = substr(get_the_excerpt(), 0, 190);
$organium_excerpt = get_the_excerpt();
?>

<div <?php post_class('organium_standard_blog_item' . ( is_sticky() ? ' organium_sticky_post' : '' )); ?>>
    <div class="organium_standard_blog_item_wrapper">
            <?php if ( !empty($featured_image_src) ) { ?>
                <div class="organium_featured_image_container">
                    <?php
                        if ( is_array($categ_code) && count($categ_code) > 0 ) {
                            echo '<div class="organium_media_categories">';
                                echo join('', $categ_code);
                            echo '</div>';
                        }
                    ?>
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo esc_url($featured_image_src); ?>" alt="<?php echo esc_attr($image_alt_text); ?>" />
                    </a>
                </div>
                <?php } else {
                    if ( is_array($categ_code) && count($categ_code) > 0 ) {
                        echo '<div class="organium_media_categories">';
                            echo join('', $categ_code);
                        echo '</div>';
                    }
                } ?>

                <div class="organium_content_wrapper">
                    <?php
                        if ( !empty(get_the_author()) || !empty(get_the_date()) ) {
                            echo '<div class="organium_post_meta">';
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
                    ?>
                    <h3 class="organium_post_title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>

                    <p class="organium_post_excerpt"><?php echo wp_kses($organium_excerpt, array(
                            'strong' => array(),
                            'b' => array(),
                            'em' => array(),
                            'sup' => array(),
                            'sub' => array(),
                            'a' => array(
                                'class' => true,
                                'href' => true
                            ),
                            'span' => array(
                                'class' => true
                            )
                        )); ?></p>
                    <?php
                        if ( !empty(get_the_tag_list()) ) {
                            echo '<div class="organium_post_meta">';
                                echo get_the_tag_list('<div class="organium_post_meta_item meta_item meta_item_tags">', ', ', '</div>');
                            echo '</div>';
                        }
                    ?>

                    <div class="organium_post_more">
                        <a href="<?php the_permalink(); ?>" class="read_more_button"><?php esc_html_e('Read More', 'organium'); ?></a>
                    </div>
                </div>
    </div>
</div>