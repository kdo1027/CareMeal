<?php
global $post;
$featured_image_url = organium_get_featured_image_url();
$image_alt_text = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);

if (function_exists('aq_resize')) {
    $featured_image_src = aq_resize($featured_image_url, 776, 776, true, true, true);
} else {
    $featured_image_src = $featured_image_url;
}
?>

<div class="organium_portfolio_item column_item<?php echo ((is_sticky()) ? ' organium_sticky_post' : ''); ?>">
    <a href="<?php the_permalink(); ?>" class="organium_portfolio_item_wrapper">
        <div class="organium_portfolio_item_overlay"></div>
        <img src="<?php echo esc_url($featured_image_src); ?>" alt="<?php echo esc_attr($image_alt_text); ?>" class="organium_portfolio_img" />
        <div class="organium_content_wrapper">
            <h6 class="organium_post_title"><?php the_title(); ?></h6>
        </div>
    </a>
</div>