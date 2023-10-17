<?php
/*
 * Created by Artureanec
*/

global $organium_custom_css;

// --------------------- //
// ------ General ------ //
// --------------------- //
$organium_custom_css .= '
    body,
    .organium_page_content_wrapper .organium_sidebar.shop_hidden_sidebar,
    .organium_aside-dropdown {
        background: ' . esc_attr(organium_get_theme_mod('site_bg_color')) . ';
    }
    
    .organium_post_meta .post_meta_left .organium_post_meta_item:after,
    .organium_post_meta:not(.post_meta_columns) .organium_post_meta_item:not(:last-child):after
    {
        background-color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    .organium_post_meta .organium_post_meta_item a:hover
    {
        color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    
    .organium_search_form .organium_icon_search,
    .wp-block-search .wp-block-search__button,
    .woocommerce .widget_product_search .woocommerce-product-search button,
    .woocommerce.widget_product_search .woocommerce-product-search button,
    .woocommerce-page .widget_product_search .woocommerce-product-search button {
        color: ' . esc_attr(organium_get_theme_mod('button_alter_color')) . ';
        background-color: ' . esc_attr(organium_get_theme_mod('button_alter_bg_color')) . ';
    }
    .organium_search_form .organium_icon_search:hover,
    .wp-block-search .wp-block-search__button:hover,
    .woocommerce .widget_product_search .woocommerce-product-search button:hover,
    .woocommerce.widget_product_search .woocommerce-product-search button:hover,
    .woocommerce-page .widget_product_search .woocommerce-product-search button:hover {
        color: ' . esc_attr(organium_get_theme_mod('button_alter_hover')) . ';
        background-color: ' . esc_attr(organium_get_theme_mod('button_alter_bg_hover')) . ';
    }
    
    .widget_tag_cloud .tagcloud .tag-cloud-link:hover,
    .wp-block-tag-cloud .tag-cloud-link:hover,
    .woocommerce .widget_product_tag_cloud .tagcloud .tag-cloud-link:hover,
    .woocommerce.widget_product_tag_cloud .tagcloud .tag-cloud-link:hover,
    .woocommerce-page .widget_product_tag_cloud .tagcloud .tag-cloud-link:hover {
        background-color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
';

// ------------------------ //
// ------ Side Panel ------ //
// ------------------------ //
$organium_custom_css .= '
    .organium_aside-dropdown__inner {
        background: ' . esc_attr(organium_get_theme_mod('side_panel_bg')) . ';
    }
    
    .organium_aside-dropdown__close {
        color: ' . esc_attr(organium_get_theme_mod('side_panel_close_color')) . ';
    }
    
    .organium_aside-dropdown__close:hover {
        color: ' . esc_attr(organium_get_theme_mod('side_panel_close_hover')) . ';
    }
';

// -------------------- //
// ------ Header ------ //
// -------------------- //
$organium_custom_css.= '
    header.organium_header {
        background: ' . esc_attr(organium_get_theme_mod('header_bg')) . ';
        border-color: ' . esc_attr(organium_get_theme_mod('header_bd')) . ';
    }

    .organium_dropdown-trigger__item,
    .organium_dropdown-trigger__item:after,
    .organium_dropdown-trigger__item:before {
        background: ' . esc_attr(organium_get_theme_mod('side_panel_trigger_color')) . ';
    }
    
    .organium_dropdown-trigger:hover .organium_dropdown-trigger__item,
    .organium_dropdown-trigger:hover .organium_dropdown-trigger__item:after,
    .organium_dropdown-trigger:hover .organium_dropdown-trigger__item:before {
        background: ' . esc_attr(organium_get_theme_mod('side_panel_trigger_hover')) . ';
    }
    
    .organium_main-menu > li > a,
    .quadmenu-navbar-nav > li > a {
        font-family: ' . esc_attr(organium_get_theme_mod('header_menu_font_family')) . ', sans-serif;
        font-size: ' . esc_attr(organium_get_theme_mod('header_menu_font_size')) . ';
        line-height: ' . esc_attr(organium_get_theme_mod('header_menu_line_height')) . ';
        font-weight: ' . esc_attr(organium_get_theme_mod('header_menu_font_weight')) . ';
        text-transform: ' . (organium_get_theme_mod('header_menu_uppercase') == true ? 'uppercase' : 'none') . ';
        font-style: ' . (organium_get_theme_mod('header_menu_italic') == true ? 'italic' : 'normal') . ';
        color: ' . esc_attr(organium_get_theme_mod('header_menu_color')) . ';
    }
    
    .organium_main-menu > li.menu-item-has-children > a:after,
    .quadmenu-navbar-nav > li.quadmenu-item-has-children > a:after {
        color: ' . esc_attr(organium_get_theme_mod('header_menu_color')) . ';
    }
    
    .organium_main-menu > li.current-menu-ancestor > a,
    .organium_main-menu > li.current-menu-parent > a,
    .quadmenu-navbar-nav > li.current-menu-ancestor > a,
    .quadmenu-navbar-nav > li.current-menu-parent > a,
    .organium_main-menu > li:hover > a,
    .quadmenu-navbar-nav > li:hover > a,
    .organium_main-menu > li.current-menu-item > a,
    .organium_main-menu > li.current_page_item > a,
    .quadmenu-navbar-nav > li.current-menu-item > a,
    .organium_main-menu > li.menu-item-has-children:hover > a:after,
    body .quadmenu-navbar-nav > li.quadmenu-item-has-children:hover > a:after {
        color: ' . esc_attr(organium_get_theme_mod('header_menu_hover')) . ';
    }
    
    .organium_main-menu > li ul.sub-menu,
    .quadmenu-navbar-nav > li .quadmenu-dropdown-menu {
        background: ' . esc_attr(organium_get_theme_mod('header_sub_menu_bg')) . ';
    }
    
    .organium_main-menu > li ul.sub-menu:before,
    .quadmenu-navbar-nav > li .quadmenu-dropdown-menu:before {
        border-top-color: ' . esc_attr(organium_get_theme_mod('header_sub_menu_bg')) . ';
    }
    
    .organium_main-menu > li ul.sub-menu > li > a,
    .quadmenu-navbar-nav > li .quadmenu-dropdown-menu ul > li > a {
        font-family: ' . esc_attr(organium_get_theme_mod('header_sub_menu_font_family')) . ', sans-serif;
        font-size: ' . esc_attr(organium_get_theme_mod('header_sub_menu_font_size')) . ';
        line-height: ' . esc_attr(organium_get_theme_mod('header_sub_menu_line_height')) . ';
        font-weight: ' . esc_attr(organium_get_theme_mod('header_sub_menu_font_weight')) . ';
        text-transform: ' . (organium_get_theme_mod('header_sub_menu_uppercase') == true ? 'uppercase' : 'none') . ';
        font-style: ' . (organium_get_theme_mod('header_sub_menu_italic') == true ? 'italic' : 'normal') . ';
        color: ' . esc_attr(organium_get_theme_mod('header_sub_menu_color')) . ';
    }
    .organium_mobile_header_menu_container .organium_main-menu > li ul.sub-menu li > .sub-menu-trigger:after {
        color: ' . esc_attr(organium_get_theme_mod('header_sub_menu_color')) . ';
    }
    
    .organium_main-menu > li ul.sub-menu > li:hover > a,
    .quadmenu-navbar-nav > li .quadmenu-dropdown-menu ul > li:hover > a {
        color: ' . esc_attr(organium_get_theme_mod('header_sub_menu_hover')) . ';
    }
    
    .organium_mobile_header_menu_container .organium_main-menu > li.current-menu-ancestor > a,
    .organium_mobile_header_menu_container .organium_main-menu > li.current-menu-parent > a,
    .organium_mobile_header_menu_container .quadmenu-navbar-nav > li.current-menu-ancestor > a,
    .organium_mobile_header_menu_container .quadmenu-navbar-nav > li.current-menu-parent > a,
    .organium_mobile_header_menu_container .organium_main-menu > li.active > a,
    .organium_mobile_header_menu_container .organium_main-menu > li.active > .sub-menu-trigger:after {
        color: ' . esc_attr(organium_get_theme_mod('header_menu_hover')) . ';
    }
    
    .organium_mobile_header_menu_container .organium_main-menu > li ul.sub-menu > li.active > a,
    .organium_header .organium_main-menu > li ul.sub-menu > li:hover > a,
    .organium_header .organium_main-menu > li ul.sub-menu > li.current-menu-item > a,
    body .quadmenu-navbar-nav > li .quadmenu-dropdown-menu ul > li:hover > a,
    body .quadmenu-navbar-nav > li .quadmenu-dropdown-menu ul > li.current-menu-item > a,
    .organium_mobile_header_menu_container .organium_main-menu > li ul.sub-menu > li.active > .sub-menu-trigger:after,
    .organium_mobile_header_menu_container .organium_main-menu li.current-menu-ancestor > a,
    .organium_mobile_header_menu_container .organium_main-menu li.current-menu-parent > a,
    .organium_mobile_header_menu_container .organium_main-menu li.current-menu-item > a,
    .organium_mobile_header_menu_container .organium_main-menu li.active > a {
        color: ' . esc_attr(organium_get_theme_mod('header_sub_menu_hover')) . ';
    }
    
    .organium_main-menu > li > a:before,
    .quadmenu-navbar-nav > li > a:before {
        background: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
';

// ---------- Header Social Buttons ---------- //
$organium_custom_css .= '
    .organium_header_socials li a,
    .organium_header_socials.organium_header_socials--bg li a {
        font-size: ' . esc_attr(organium_get_theme_mod('header_socials_font_size')) . ';
        color: ' . esc_attr(organium_get_theme_mod('header_socials_icon_color')) . ';
    }
    .organium_header_socials li a:hover {
        color: ' . esc_attr(organium_get_theme_mod('header_socials_icon_hover')) . ';
    }
    .organium_header_socials.organium_header_socials--bg li a {
        background: ' . esc_attr(organium_get_theme_mod('header_socials_bg_color')) . ';
    }
    .organium_header_socials.organium_header_socials--bg li a:hover {
        background: ' . esc_attr(organium_get_theme_mod('header_socials_bg_hover')) . ';
    }
';

// ---------- Header Button ---------- //
$organium_custom_css .= '
    .header_button_container .organium_button,
    .footer_widgets .widget_calendar .calendar_wrap tbody td#today {
        color: ' . esc_attr(organium_get_theme_mod('header_button_color')) . ';
        background: ' . esc_attr(organium_get_theme_mod('header_button_bg_color')) . ';
    }
    .header_button_container .organium_button:hover {
        color: ' . esc_attr(organium_get_theme_mod('header_button_hover')) . ';
        background: ' . esc_attr(organium_get_theme_mod('header_button_bg_hover')) . ';
    }
';

// ---------- Side Panel Trigger ---------- //
$organium_custom_css .= '
    .dropdown-trigger .dropdown-trigger__item,
    .menu_close .menu_close_icon {
        color: ' . esc_attr(organium_get_theme_mod('side_panel_trigger_color')) . ';
    }
    .menu_trigger .menu_trigger_icon .hamburger span {
        background: ' . esc_attr(organium_get_theme_mod('side_panel_trigger_color')) . ';
    }
    .dropdown-trigger.dropdown-trigger--large .dropdown-trigger__item,
    .menu_trigger.menu_trigger--large .menu_trigger_icon,
    .menu_close.menu_close--large .menu_close_icon {
        background: ' . esc_attr(organium_get_theme_mod('side_panel_trigger_bg_color')) . ';
    }
    .dropdown-trigger .dropdown-trigger__item:hover {
        color: ' . esc_attr(organium_get_theme_mod('side_panel_trigger_hover')) . ';
    }
    .dropdown-trigger.dropdown-trigger--large .dropdown-trigger__item:hover {
        background: ' . esc_attr(organium_get_theme_mod('side_panel_trigger_bg_hover')) . ';
    }
';

// ---------- Header Search ---------- //
$organium_custom_css .= '
    .search_trigger .search_trigger_icon {
        color: ' . esc_attr(organium_get_theme_mod('header_search_trigger_color')) . ';
    }
    .search_trigger .search_trigger_icon:hover {
        color: ' . esc_attr(organium_get_theme_mod('header_search_trigger_hover')) . ';
    }
    .site-search .close-search {
        color: ' . esc_attr(organium_get_theme_mod('button_color')) . ';
        background: ' . esc_attr(organium_get_theme_mod('button_bg_color')) . ';
    }
    .site-search .close-search:hover {
        color: ' . esc_attr(organium_get_theme_mod('button_alter_color')) . ';
        background: ' . esc_attr(organium_get_theme_mod('button_alter_bg_color')) . ';
    }
    .site-search .organium_search_form .organium_icon_search {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    .site-search .organium_search_form .organium_icon_search:hover {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
';

// ---------- Header Mini Cart ---------- //
$organium_custom_css .= '
    .mini_cart .mini_cart_trigger {
        color: ' . esc_attr(organium_get_theme_mod('header_minicart_icon_color')) . ';
        background: ' . esc_attr(organium_get_theme_mod('header_minicart_bg_color')) . ';
    }
    .mini_cart .mini_cart_trigger:hover {
        color: ' . esc_attr(organium_get_theme_mod('header_minicart_icon_hover')) . ';
        background: ' . esc_attr(organium_get_theme_mod('header_minicart_bg_hover')) . ';
    }
    .mini_cart .mini_cart_trigger .mini_cart_count > span {
        color: ' . esc_attr(organium_get_theme_mod('header_minicart_counter_color')) . ';
        background: ' . esc_attr(organium_get_theme_mod('header_minicart_counter_bg')) . ';
    }
';

// ---------- Header Wishlist Link ---------- //
$organium_custom_css .= '
    .wishlist_link .wishlist_link_icon {
        color: ' . esc_attr(organium_get_theme_mod('header_wishlist_color')) . ';
    }
    .wishlist_link .wishlist_link_icon:hover {
        color: ' . esc_attr(organium_get_theme_mod('header_wishlist_hover')) . ';
    }
';

// ------------------ //
// ------ Logo ------ //
// ------------------ //
$organium_logo_metadata = wp_get_attachment_metadata(attachment_url_to_postid(organium_get_theme_mod('logo_image')));
$organium_logo_width = (isset($organium_logo_metadata['width']) ? $organium_logo_metadata['width'] : 0);
$organium_logo_height = (isset($organium_logo_metadata['height']) ? $organium_logo_metadata['height'] : 0);

$organium_logo_width_mobile = round($organium_logo_width * 0.7);
$organium_logo_height_mobile = round($organium_logo_height * 0.7);

$organium_custom_css .= '
    .organium_header-logo__link {' .
        (!empty($organium_logo_width) ? 'width: ' . absint($organium_logo_width) . 'px;' : '') .
        (!empty($organium_logo_height) ? 'height: ' . absint($organium_logo_height) . 'px;' : '') .
        'background: url("' . esc_url(organium_get_theme_mod('logo_image')) . '") 0 0 no-repeat transparent;
        background-size: cover;
        color: ' . esc_attr(organium_get_theme_mod('header_logo_color')) . ';
    }
    
    .header_mobile .organium_header-logo__link {' .
        (!empty($organium_logo_width_mobile) ? 'width: ' . absint($organium_logo_width_mobile) . 'px;' : '') .
        (!empty($organium_logo_height_mobile) ? 'height: ' . absint($organium_logo_height_mobile) . 'px;' : '') . '
    }
';

if (organium_get_theme_mod('logo_retina') == true) {
    $organium_logo_width_retina = $organium_logo_width / 2;
    $organium_logo_height_retina = $organium_logo_height / 2;

    $organium_logo_width_mobile_retina = $organium_logo_width_mobile / 2;
    $organium_logo_height_mobile_retina = $organium_logo_height_mobile / 2;

    $organium_custom_css .= '
        .organium_header-logo__link.organium_retina_logo {' .
            (!empty($organium_logo_width_retina) ? 'width: ' . absint($organium_logo_width_retina) . 'px;' : '') .
            (!empty($organium_logo_height_retina) ? 'height: ' . absint($organium_logo_height_retina) . 'px;' : '') .
            'background-size: cover;
        }
        .organium_mobile_header_menu_container .organium_header-logo__link.organium_retina_logo,
        .header_mobile .organium_header-logo__link.organium_retina_logo {' .
            'display: block;' .
            (!empty($organium_logo_width_mobile_retina) ? 'width: ' . absint($organium_logo_width_mobile_retina) . 'px;' : '') .
            (!empty($organium_logo_height_mobile_retina) ? 'height: ' . absint($organium_logo_height_mobile_retina) . 'px;' : '') . '
        }
    ';
}

// ------------------------ //
// ------ Typography ------ //
// ------------------------ //
$organium_custom_css .= '
    body,
    body .organium_comments__item-text ol > li > .item-wrapper,
    body .organium_content_wrapper ol > li > .item-wrapper,
    body .organium_comments__item-text ul > li > .item-wrapper,
    body .organium_content_wrapper ul > li > .item-wrapper,
    .elementor-widget-image-box .elementor-image-box-wrapper .elementor-image-box-content .elementor-image-box-description {
        font-family: ' . esc_attr(organium_get_theme_mod('main_font_family')) . ', sans-serif;
        font-size: ' . esc_attr(organium_get_theme_mod('main_font_size')) . ';
        line-height: ' . esc_attr(organium_get_theme_mod('main_line_height')) . ';
        font-weight: ' . esc_attr(organium_get_theme_mod('main_font_weight')) . ';
        color: ' . esc_attr(organium_get_theme_mod('main_font_color')) . ';
    }
    .organium_post_excerpt,
    .woocommerce form label,
    .organium_timeline_widget .organium_timeline_item,
    .elementor-icon-list-items .elementor-icon-list-item .elementor-icon-list-text {
        font-size: ' . esc_attr(organium_get_theme_mod('main_font_size')) . ';
        line-height: ' . esc_attr(organium_get_theme_mod('main_line_height')) . ';
        font-weight: ' . esc_attr(organium_get_theme_mod('main_font_weight')) . ';
    }
    
    body .organium_content_wrapper .elementor-text-editor,
    .elementor-icon-list-items .elementor-icon-list-item .elementor-icon-list-text {
        font-family: ' . esc_attr(organium_get_theme_mod('main_font_family')) . ', sans-serif;
    }
    
    .organium_button {
        font-family: ' . esc_attr(organium_get_theme_mod('buttons_font_family')) . ', sans-serif;
        font-size: ' . esc_attr(organium_get_theme_mod('buttons_font_size')) . ';
        font-weight: ' . esc_attr(organium_get_theme_mod('buttons_font_weight')) . ';
        text-transform: ' . (organium_get_theme_mod('buttons_uppercase') == true ? 'uppercase' : 'none') . ';
        font-style: ' . (organium_get_theme_mod('buttons_italic') == true ? 'italic' : 'normal') . ';
    }
    .organium_button--primary {
        color: ' . esc_attr(organium_get_theme_mod('button_color')) . ';
        background: ' . esc_attr(organium_get_theme_mod('button_bg_color')) . ';
    }
    
    .organium_button--primary:hover {
        color: ' . esc_attr(organium_get_theme_mod('button_hover')) . ';
        background: ' . esc_attr(organium_get_theme_mod('button_bg_hover')) . ';
        box-shadow: 0px 15px 40px rgba(' . esc_attr(organium_hex2rgb(organium_get_theme_mod('button_bg_color'))) . ', 0.24);
    }
    
    .organium_button--alter {
        color: ' . esc_attr(organium_get_theme_mod('button_alter_color')) . ';
        background: ' . esc_attr(organium_get_theme_mod('button_alter_bg_color')) . ';
    }
    
    .organium_button--alter:hover {
        color: ' . esc_attr(organium_get_theme_mod('button_alter_hover')) . ';
        background: ' . esc_attr(organium_get_theme_mod('button_alter_bg_hover')) . ';
        box-shadow: 0px 15px 40px rgba(' . esc_attr(organium_hex2rgb(organium_get_theme_mod('button_alter_bg_color'))) . ', 0.24);
    }
    
    .organium_button--primary {
        border-color: ' . esc_attr(organium_get_theme_mod('button_bg_color')) . ';
    }
    
    .organium_button--primary:hover {
        border-color: ' . esc_attr(organium_get_theme_mod('button_bg_hover')) . ';
    }
    
    .organium_button--squared {
        color: ' . esc_attr(organium_get_theme_mod('button_color')) . ';
        background: ' . esc_attr(organium_get_theme_mod('button_bg_color')) . ';
    }
    
    .organium_button--squared:hover {
        color: ' . esc_attr(organium_get_theme_mod('button_hover')) . ';
        background: ' . esc_attr(organium_get_theme_mod('button_bg_hover')) . ';
    }
    
    body .organium_content_wrapper .wp-block-pullquote,
    .wp-block-pullquote {
        border-color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    
    h1, h2, h3, h4, h5, h6,
    .organium_content_slider_title, 
    body .elementor-widget-heading .elementor-heading-title,
    .woocommerce-Reviews-title,
    .comment-reply-title,
    .cart_totals h2,
    .woocommerce-account .woocommerce-EditAccountForm fieldset legend,
    .elementor-widget-image-box .elementor-image-box-wrapper .elementor-image-box-content .elementor-image-box-title,
    div.wpforms-container .wpforms-form .wpforms-title {
        font-family: ' . esc_attr(organium_get_theme_mod('headings_font_family')) . ', sans-serif;
        font-weight: ' . esc_attr(organium_get_theme_mod('headings_font_weight')) . ';
        text-transform: ' . (organium_get_theme_mod('headings_uppercase') == true ? 'uppercase' : 'none') . ';
        font-style: ' . (organium_get_theme_mod('headings_italic') == true ? 'italic' : 'normal') . ';
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    .organium_post_meta .meta_item_tags a,
    .wp-block-search .wp-block-search__label,
    .wp-block-latest-posts li > a,
    .wp-block-latest-posts li > .item-wrapper > a,
    body .organium_content_wrapper table tr th,
    q {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    
    .organium_sidebar .widget_title:before {
        background: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    blockquote:before,
    h1 a:hover,
    h2 a:hover,
    h3 a:hover,
    h4 a:hover,
    h5 a:hover,
    h6 a:hover,
    .organium_post_meta .meta_item_tags a:hover,
    .breadcrumbs-wrapper .breadcrumbs a:hover,
    .wp-block-latest-posts li > a:hover,
    .wp-block-latest-posts li > .item-wrapper > a:hover,
    body .organium_comments__item-text ol > li,
    body .organium_content_wrapper ol > li {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    
    p strong,
    blockquote,
    .organium_pagination .page-numbers,
    .organium_pagination .post-page-numbers,
    .wishlist-pagination .page-numbers,
    .wishlist-pagination .post-page-numbers,
    .breadcrumbs-wrapper .breadcrumbs {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    
    a {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    a:hover {
        color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    
    .block-heading .block-heading__subtitle {
        font-family: ' . esc_attr(organium_get_theme_mod('additional_font_family')) . ', sans-serif;
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    
    body .organium_content_wrapper .wp-block-social-links.is-style-default .wp-social-link, 
    .wp-block-social-links.is-style-default .wp-social-link,
     body .organium_content_wrapper .wp-block-social-links.is-style-pill-shape .wp-social-link, 
    .wp-block-social-links.is-style-pill-shape .wp-social-link {
        background-color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    body .organium_content_wrapper .wp-block-social-links.is-style-default .wp-social-link:hover, 
    .wp-block-social-links.is-style-default .wp-social-link:hover,
    body .organium_content_wrapper .wp-block-social-links.is-style-pill-shape .wp-social-link:hover, 
    .wp-block-social-links.is-style-pill-shape .wp-social-link:hover {
        background-color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    
    body .organium_content_wrapper .wp-block-social-links.is-style-logos-only .wp-social-link a, 
    .wp-block-social-links.is-style-logos-only .wp-social-link a {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    body .organium_content_wrapper .wp-block-social-links.is-style-logos-only .wp-social-link a:hover, 
    .wp-block-social-links.is-style-logos-only .wp-social-link a:hover {
        color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    
    @media only screen and (min-width: 992px) {
        h1,
        body .elementor-widget-heading h1.elementor-heading-title {
            font-size: ' . esc_attr(organium_get_theme_mod('h1_font_size')) . ';
            line-height: ' . esc_attr(organium_get_theme_mod('h1_line_height')) . ';
        }
        
        h2,
        body .elementor-widget-heading h2.elementor-heading-title {
            font-size: ' . esc_attr(organium_get_theme_mod('h2_font_size')) . ';
            line-height: ' . esc_attr(organium_get_theme_mod('h2_line_height')) . ';
        }
        
        h3,
        body .elementor-widget-heading h3.elementor-heading-title {
            font-size: ' . esc_attr(organium_get_theme_mod('h3_font_size')) . ';
            line-height: ' . esc_attr(organium_get_theme_mod('h3_line_height')) . ';
        }
        
        h4,
        body .elementor-widget-heading h4.elementor-heading-title {
            font-size: ' . esc_attr(organium_get_theme_mod('h4_font_size')) . ';
            line-height: ' . esc_attr(organium_get_theme_mod('h4_line_height')) . ';
        }
        
        h5,
        body .elementor-widget-heading h5.elementor-heading-title,
        .woocommerce-Reviews-title,
        .comment-reply-title,
        .cart_totals h2,
        .woocommerce-checkout h3,
        .woocommerce-account h3,
        .woocommerce-account .woocommerce-EditAccountForm fieldset legend,
        .outer-form-wrapper h2,
        .woocommerce-MyAccount-content h2,
        .woocommerce-order h2 {
            font-size: ' . esc_attr(organium_get_theme_mod('h5_font_size')) . ';
            line-height: ' . esc_attr(organium_get_theme_mod('h5_line_height')) . ';
        }
        
        h6,
        div.wpforms-container .wpforms-form .wpforms-title,
        body .elementor-widget-heading h6.elementor-heading-title {
            font-size: ' . esc_attr(organium_get_theme_mod('h6_font_size')) . ';
            line-height: ' . esc_attr(organium_get_theme_mod('h6_line_height')) . ';
        }
    }
    
';

// -------------------- //
// ------ Footer ------ //
// -------------------- //
$organium_custom_css .= '
    .organium_footer {
        background-image: url("' . esc_url(organium_get_theme_mod('footer_bg_image')) . '");
        background-position: ' . esc_attr(organium_get_theme_mod('footer_bg_position')) . ';
        background-repeat: ' . esc_attr(organium_get_theme_mod('footer_bg_repeat')) . ';
        -webkit-background-size: ' . esc_attr(organium_get_theme_mod('footer_bg_size')) . ';
        background-size: ' . esc_attr(organium_get_theme_mod('footer_bg_size')) . ';
        background-color: ' . esc_attr(organium_get_theme_mod('footer_bg')) . ';
        color: ' . esc_attr(organium_get_theme_mod('footer_text_color')) . ';
    }
   
    .organium_footer a {
        color: ' . esc_attr(organium_get_theme_mod('footer_accent_color')) . ';
    }
    .organium_footer a:hover {
        color: ' . esc_attr(organium_get_theme_mod('footer_hover_color')) . ';
    }
    .organium_footer-logo {
        color: ' . esc_attr(organium_get_theme_mod('footer_logo_color')) . ';
    }
    .organium_footer .footer_widget,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_logo,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_email a,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_phone a,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_address {
        color: ' . esc_attr(organium_get_theme_mod('footer_sidebar_text_color')) . ';
    }
    .organium_footer .footer_widget .organium_footer_widget_title,
    .organium_footer .footer_widget a,
    .organium_footer .footer_widget li a,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_logo a,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_email strong,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_phone strong,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_address strong,
    .organium_footer .organium_footer_subscribe_content .organium_footer_widget_title {
        color: ' . esc_attr(organium_get_theme_mod('footer_sidebar_accent_color')) . ';
    }
    .organium_footer .footer_widget a:hover,
    .organium_footer .footer_widget li:hover a {
        color: ' . esc_attr(organium_get_theme_mod('footer_sidebar_hover_color')) . ';
    }
    .organium_footer .organium_footer_menu li a {
        color: ' . esc_attr(organium_get_theme_mod('footer_menu_color')) . ';
    }
    .organium_footer .organium_footer_menu li a:hover,
    .organium_footer .organium_footer_menu li.current-menu-item a {
        color: ' . esc_attr(organium_get_theme_mod('footer_menu_hover')) . ';
    }
    .organium_footer .organium_footer_menu_container,
    .organium_footer.organium_footer_style_2 .organium_footer_subscribe_container:not(:last-child),
    .organium_footer.organium_footer_style_3 .organium_footer_subscribe_container:not(:last-child),
    .organium_footer.organium_footer_style_4 .organium_footer_subscribe_container:not(:last-child),
    .organium_footer.organium_footer_style_2 .organium_footer_bottom,
    .organium_footer.organium_footer_style_3 .organium_footer_bottom,
    .organium_footer.organium_footer_style_4 .organium_footer_bottom {
        border-color: ' . esc_attr(organium_get_theme_mod('footer_menu_border_color')) . ';
    }
    
    .organium_footer_socials li a,
    .organium_footer_socials.organium_footer_socials--bg li a,
    .organium_footer .widget_organium_address_widget .organium-socials li a {
        font-size: ' . esc_attr(organium_get_theme_mod('footer_socials_font_size')) . ';
        color: ' . esc_attr(organium_get_theme_mod('footer_socials_color')) . ';
    }
    .organium_footer_socials li a:hover,
    .organium_footer .widget_organium_address_widget .organium-socials li a:hover {
        color: ' . esc_attr(organium_get_theme_mod('footer_socials_hover')) . ';
    }
    .organium_footer_socials.organium_footer_socials--bg li a,
    .organium_footer .widget_organium_address_widget .organium-socials li a {
        background: ' . esc_attr(organium_get_theme_mod('footer_socials_bg')) . ';
    }
    .organium_footer_socials.organium_footer_socials--bg li a:hover,
    .organium_footer .widget_organium_address_widget .organium-socials li a:hover {
        background: ' . esc_attr(organium_get_theme_mod('footer_socials_bg_hover')) . ';
    }
    
    .organium_footer .organium_button,
    .organium_footer button,
    .organium_footer input[type="submit"],
    .organium_footer input[type="button"] {
        background: ' . esc_attr(organium_get_theme_mod('footer_button_bg_color')) . ';
        color: ' . esc_attr(organium_get_theme_mod('footer_button_color')) . ';' .
        ( !empty(organium_get_theme_mod('footer_button_shadow')) ? '-webkit-box-shadow: 0 15px 40px ' . esc_attr(organium_get_theme_mod('footer_button_shadow')) . ';' : '') .
        ( !empty(organium_get_theme_mod('footer_button_shadow')) ? '-moz-box-shadow: 0 15px 40px ' . esc_attr(organium_get_theme_mod('footer_button_shadow')) . ';' : '' ) .
        ( !empty(organium_get_theme_mod('footer_button_shadow')) ? 'box-shadow: 0 15px 40px ' . esc_attr(organium_get_theme_mod('footer_button_shadow')) . ';' : '' ) . '
    }
    .organium_footer .organium_button:hover,
    .organium_footer button:hover,
    .organium_footer input[type="submit"]:hover,
    .organium_footer input[type="button"]:hover {
        background: ' . esc_attr(organium_get_theme_mod('footer_button_bg_hover')) . ';
        color: ' . esc_attr(organium_get_theme_mod('footer_button_hover')) . ';' .
        ( !empty(organium_get_theme_mod('footer_button_hover_shadow')) ? '-webkit-box-shadow: 0 15px 40px ' . esc_attr(organium_get_theme_mod('footer_button_hover_shadow')) . ';' : '') .
        ( !empty(organium_get_theme_mod('footer_button_hover_shadow')) ? '-moz-box-shadow: 0 15px 40px ' . esc_attr(organium_get_theme_mod('footer_button_hover_shadow')) . ';' : '' ) .
        ( !empty(organium_get_theme_mod('footer_button_hover_shadow')) ? 'box-shadow: 0 15px 40px ' . esc_attr(organium_get_theme_mod('footer_button_hover_shadow')) . ';' : '' ) . '  
    }
';
$footer_logo_metadata = wp_get_attachment_metadata(attachment_url_to_postid(organium_get_theme_mod('footer_logo_image')));
$footer_logo_width = (isset($footer_logo_metadata['width']) ? $footer_logo_metadata['width'] : 0);
$footer_logo_height = (isset($footer_logo_metadata['height']) ? $footer_logo_metadata['height'] : 0);

$organium_custom_css .= '
    .organium_footer-logo__link {' .
    (!empty($footer_logo_width) ? 'width: ' . absint($footer_logo_width) . 'px;' : '') .
    (!empty($footer_logo_height) ? 'height: ' . absint($footer_logo_height) . 'px;' : '') .
    'background: url("' . esc_url(organium_get_theme_mod('footer_logo_image')) . '") 0 0 no-repeat transparent;
        background-size: cover;
        color: ' . esc_attr(organium_get_theme_mod('footer_logo_color')) . ';
    }
';

if (organium_get_theme_mod('footer_logo_retina') == true) {
    $footer_logo_width_retina = floor($footer_logo_width / 2);
    $footer_logo_height_retina = floor($footer_logo_height / 2);

    $organium_custom_css .= '
        .organium_footer-logo__link.organium_retina_logo {' .
            (!empty($footer_logo_width_retina) ? 'width: ' . absint($footer_logo_width_retina) . 'px;' : '') .
            (!empty($footer_logo_height_retina) ? 'height: ' . absint($footer_logo_height_retina) . 'px;' : '') .
            'background-size: cover;
        }
    ';
}

// ------------------------ //
// ------ Page Title ------ //
// ------------------------ //
$organium_custom_css .= '
    .organium_page_title_container {
        background-color: ' . esc_attr(organium_get_theme_mod('post_title_bg_color')) . ';
    }
    
    .organium_page_title {
        color: ' . esc_attr(organium_get_theme_mod('page_title_color')) . ';
        font-family: ' . esc_attr(organium_get_theme_mod('page_title_font_family')) . ', sans-serif;
    }
    
    .organium_page_title_additional {
        color: ' . esc_attr(organium_get_theme_mod('title_additional_text_color')) . ';
        font-family: ' . esc_attr(organium_get_theme_mod('title_additional_text_font_family')) . ', sans-serif;
        font-size: ' . esc_attr(organium_get_theme_mod('title_additional_text_font_size')) . ';
    }
    
    body .organium_additional_font .elementor-text-editor,
    .site_name {
        font-family: ' . esc_attr(organium_get_theme_mod('additional_font_family')) . ', sans-serif;
    }
    .breadcrumbs-wrapper .breadcrumbs a {
        color: ' . esc_attr(organium_get_theme_mod('breadcrumbs_link_color')) . ';
    }
    .breadcrumbs-wrapper .breadcrumbs a:hover {
        color: ' . esc_attr(organium_get_theme_mod('breadcrumbs_link_hover')) . ';
    }
    @media only screen and (min-width: 576px) {
        .organium_page_title_container {
            min-height: ' . absint(organium_get_theme_mod('title_height')) . 'px;
        }
        .organium_page_title_container .organium_page_title {
            font-size: ' . esc_attr(organium_get_theme_mod('page_title_font_size')) . ';
        }
    }
    @media only screen and (min-width: 992px) {
        .organium_page_title_bg {
            background-image: url("'. esc_url(organium_get_theme_mod('post_title_bg')) .'");
        }
    }
';

// ------------------ //
// ------ Blog ------ //
// ------------------ //
$organium_custom_css .= '
    .organium_media_categories .organium_category {
        font-family: ' . esc_attr(organium_get_theme_mod('main_font_family')) . ';
        font-weight: ' . esc_attr(organium_get_theme_mod('main_font_weight')) . ';
        background-color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    .organium_post_meta .meta_item_socials a {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    .organium_post_meta .meta_item_socials a:hover {
        background-color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
';

// ------------------------- //
// ------- Portfolio ------- //
$organium_custom_css .= '
    .filter_control_wrapper .filter_control_list ul li,
    .filter_control_wrapper .filter_control_list ul li > .item-wrapper {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    .filter_control_wrapper .filter_control_list ul li:before {
        background-color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    .filter_control_wrapper .filter_control_list ul li.active,
    .filter_control_wrapper .filter_control_list ul li.active > .item-wrapper ,
    .filter_control_wrapper .filter_control_list ul li:hover,
    .filter_control_wrapper .filter_control_list ul li:hover > .item-wrapper  {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
';


// ------------------------- //
// ------------------------- //
// ------ Single Post ------ //
// ------------------------- //
$organium_custom_css .= '
    .organium_post_details_tag_cont ul li:hover,
    .organium_post_details_tag_cont ul li a:hover {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    
    .organium_blog-post__socials a {
        color: ' . esc_attr(organium_get_theme_mod('post_socials_color')) . ';
        background: ' . esc_attr(organium_get_theme_mod('post_socials_bg')) . ';
    }
    
    .organium_blog-post__socials a:hover {
        color: ' . esc_attr(organium_get_theme_mod('post_socials_hover')) . ';
        background: ' . esc_attr(organium_get_theme_mod('post_socials_bg_hover')) . ';
    }
    
    input[type="text"],
    input[type="email"],
    input[type="url"],
    input[type="password"],
    input[type="search"],
    input[type="number"],
    input[type="tel"],
    input[type="range"],
    input[type="date"],
    input[type="month"],
    input[type="week"],
    input[type="time"],
    input[type="datetime"],
    input[type="datetime-local"],
    input[type="color"],
    select,
    textarea,
    div.wpforms-container .wpforms-form .wpforms-field input[type="text"],
    div.wpforms-container .wpforms-form .wpforms-field input[type="email"],
    div.wpforms-container .wpforms-form .wpforms-field input[type="url"],
    div.wpforms-container .wpforms-form .wpforms-field input[type="password"],
    div.wpforms-container .wpforms-form .wpforms-field input[type="search"],
    div.wpforms-container .wpforms-form .wpforms-field input[type="number"],
    div.wpforms-container .wpforms-form .wpforms-field input[type="tel"],
    div.wpforms-container .wpforms-form .wpforms-field input[type="range"],
    div.wpforms-container .wpforms-form .wpforms-field input[type="date"],
    div.wpforms-container .wpforms-form .wpforms-field input[type="month"],
    div.wpforms-container .wpforms-form .wpforms-field input[type="week"],
    div.wpforms-container .wpforms-form .wpforms-field input[type="time"],
    div.wpforms-container .wpforms-form .wpforms-field input[type="datetime"],
    div.wpforms-container .wpforms-form .wpforms-field input[type="datetime-local"],
    div.wpforms-container .wpforms-form .wpforms-field input[type="color"],
    div.wpforms-container .wpforms-form .wpforms-field select,
    div.wpforms-container .wpforms-form .wpforms-field textarea,
    .form__field,
    .organium_sidebar .widget.widget_categories select,
    .wp-block-categories select,
    .organium_sidebar .widget.widget_organium_recipes_categories_widget select,
    .woocommerce .organium_sidebar .widget.widget_product_categories select,
    .organium_sidebar .widget.woocommerce.widget_product_categories select,
    .woocommerce-page .organium_sidebar .widget.widget_product_categories select,
    body #give_checkout_user_info p input,
    div.wpforms-container .wpforms-form .wpforms-field input[type=checkbox],
    div.wpforms-container .wpforms-form .wpforms-field input[type=radio],
    .comment-form-cookies-consent input[type="checkbox"]:checked + label:before,
    .comment-form-cookies-consent input[type="checkbox"]:not(:checked) + label:before {
        color: ' . esc_attr(organium_get_theme_mod('form_field_color')) . ';
        background: ' . esc_attr(organium_get_theme_mod('form_field_bg')) . ';
        border-color: ' . esc_attr(organium_get_theme_mod('form_field_border')) . ';
    }
    .comment-form-cookies-consent input[type="checkbox"]:checked + label:before,
    .comment-form-cookies-consent input[type="checkbox"]:not(:checked) + label:before {
        border-color: ' . esc_attr(organium_get_theme_mod('main_font_color')) . ';
    }
    .container .select2-container.select2-container--default .select2-selection--single,
    .container .select2-container .select2-dropdown, 
    .container .select2-container .select2-search--dropdown .select2-search__field,
    .organium_search_form .form__field {
        border-color: ' . esc_attr(organium_get_theme_mod('form_field_border')) . ';
    }
    
    input[type="radio"]:checked:before {
        background-color: ' . esc_attr(organium_get_theme_mod('form_field_color')) . ';
    }
    
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="url"]:focus,
    input[type="password"]:focus,
    input[type="search"]:focus,
    input[type="number"]:focus,
    input[type="tel"]:focus,
    input[type="range"]:focus,
    input[type="date"]:focus,
    input[type="month"]:focus,
    input[type="week"]:focus,
    input[type="time"]:focus,
    input[type="datetime"]:focus,
    input[type="datetime-local"]:focus,
    input[type="color"]:focus,
    textarea:focus,
    select:focus,
    div.wpforms-container .wpforms-form .wpforms-field input[type="text"]:focus,
    div.wpforms-container .wpforms-form .wpforms-field input[type="email"]:focus,
    div.wpforms-container .wpforms-form .wpforms-field input[type="url"]:focus,
    div.wpforms-container .wpforms-form .wpforms-field input[type="password"]:focus,
    div.wpforms-container .wpforms-form .wpforms-field input[type="search"]:focus,
    div.wpforms-container .wpforms-form .wpforms-field input[type="number"]:focus,
    div.wpforms-container .wpforms-form .wpforms-field input[type="tel"]:focus,
    div.wpforms-container .wpforms-form .wpforms-field input[type="range"]:focus,
    div.wpforms-container .wpforms-form .wpforms-field input[type="date"]:focus,
    div.wpforms-container .wpforms-form .wpforms-field input[type="month"]:focus
    div.wpforms-container .wpforms-form .wpforms-field input[type="week"]:focus,
    div.wpforms-container .wpforms-form .wpforms-field input[type="time"]:focus,
    div.wpforms-container .wpforms-form .wpforms-field input[type="datetime"]:focus,
    div.wpforms-container .wpforms-form .wpforms-field input[type="datetime-local"]:focus,
    div.wpforms-container .wpforms-form .wpforms-field input[type="color"]:focus,
    div.wpforms-container .wpforms-form .wpforms-field select:focus,
    div.wpforms-container .wpforms-form .wpforms-field textarea:focus,
    .form__field:focus,
    body #give_checkout_user_info p input:focus,
    .organium_search_form .form__field:focus {
        background: ' . esc_attr(organium_get_theme_mod('active_form_field_bg')) . ';
        border-color: ' . esc_attr(organium_get_theme_mod('active_form_field_border')) . ';
    }
    
    div.wpforms-container .wpforms-form .wpforms-submit-container .wpforms-submit,
    input[type="submit"] {
        color: ' . esc_attr(organium_get_theme_mod('form_button_color')) . ';
        background: ' . esc_attr(organium_get_theme_mod('form_button_bg')) . ';
    }
    
    div.wpforms-container .wpforms-form .wpforms-submit-container .wpforms-submit:hover,
    input[type="submit"]:hover {
        color: ' . esc_attr(organium_get_theme_mod('form_button_hover')) . ';
        background: ' . esc_attr(organium_get_theme_mod('form_button_bg_hover')) . ';
        box-shadow: 0px 15px 40px rgba(' . esc_attr(organium_hex2rgb(organium_get_theme_mod('form_button_bg'))) . ', 0.24);
    }
    
    .organium_comments__item-name,
    .organium_comment_reply_cont a {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    
    .comment-respond .logged-in-as a {
        color: ' . esc_attr(organium_get_theme_mod('main_font_color')) . ';
    }
    
    .organium_comment_reply_cont a:hover,
    .comment-respond .logged-in-as a:hover {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    
    .organium_pagination span.current,
    .wishlist-pagination span.current,
    .organium_pagination a:hover, 
    .wishlist-pagination a:hover {
        background: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
        border-color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
';

// ------------------------------ //
// ------ Single Portfolio ------ //
// ------------------------------ //
$organium_custom_css .= '
    .organium_content_wrapper .organium_portfolio_content .organium_portfolio_meta {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    .post_navigation .post_nav_link a,
    .post_navigation .post_nav_text_wrapper a {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    .post_navigation .archive_dots a {
        color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    .post_navigation .archive_dots a:hover,
    .post_navigation .post_nav_link a:hover,
    .post_navigation .post_nav_text_wrapper a:hover {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    .post_navigation .post_nav_cats a:hover {
        color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
';

// --------------------------- //
// ------ Single Recipe ------ //
// --------------------------- //
$organium_custom_css .= '
    .organium_single_recipe_container .organium_instructions_wrapper .organium_instructions_item:before {
        background: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    .organium_single_recipe_container .organium_instructions_wrapper .organium_instructions_item .organium_instructions_num {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    .organium_single_recipe_container .organium_instructions_wrapper .organium_instructions_item .organium_instructions_bullet {
        border-color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    .organium_single_recipe_container .organium_post_meta .meta_item_socials a {
        background: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    .organium_single_recipe_container .organium_post_meta .meta_item_socials a:hover {
        background: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    .ingredient_item .ingredient_item_title {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
';


// ---------------------------- //
// ------ 404 Error Page ------ //
// ---------------------------- //
$organium_custom_css .= '
    .organium_404_error_container {
        background-image: url(' . esc_url(organium_get_theme_mod('404_bg_image')) . ');
        background-color: ' . esc_attr(organium_get_theme_mod('404_bg_color')) . ';
    }
    
    .organium_404_error_title {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    
    .organium_footer-socials li a {
        background-color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    .organium_footer-socials li a:hover {
        background-color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
';

// ----------------------------------------- //
// ------ Organium Widgets for Elementor ------ //
// ----------------------------------------- //
$organium_custom_css .= '
    body .organium_content_wrapper .elementor-text-editor a:hover strong,
    body .organium_skills_info .elementor-widget-text-editor a:hover,
    .widget_archive ul li:hover,
    ul.wp-block-archives li:hover,
    .widget_archive ul li:hover > a,
    ul.wp-block-archives li:hover > a,
    .widget_categories ul li:hover,
    .widget_categories ul li.current-cat,
    ul.wp-block-categories li:hover,
    ul.wp-block-categories li.current-cat,
    .widget_organium_recipes_categories_widget ul li:hover,
    .widget_organium_recipes_categories_widget ul li.current-cat,
    .widget_categories ul li:hover > a,
    .widget_categories ul li.current-cat > a,
    ul.wp-block-categories li:hover > .item-wrapper > a,
    ul.wp-block-categories li:hover > a,
    ul.wp-block-categories li.current-cat > .item-wrapper > a,
    ul.wp-block-categories li.current-cat > a,
    .widget_organium_recipes_categories_widget ul li:hover > a,
    .widget_organium_recipes_categories_widget ul li.current-cat > a,
    .woocommerce .widget_product_categories ul li:hover,
    .woocommerce.widget_product_categories ul li:hover,
    .woocommerce-page .widget_product_categories ul li:hover,
    .woocommerce .widget_product_categories ul li:hover > a,
    .woocommerce.widget_product_categories ul li:hover > a,
    .woocommerce-page .widget_product_categories ul li:hover > a,
    .woocommerce .widget_product_categories ul li.current-cat,
    .woocommerce.widget_product_categories ul li.current-cat,
    .woocommerce-page .widget_product_categories ul li.current-cat,
    .woocommerce .widget_product_categories ul li.current-cat > a,
    .woocommerce.widget_product_categories ul li.current-cat > a,
    .woocommerce-page .widget_product_categories ul li.current-cat > a,
    .widget_meta ul li:hover,
    .widget_meta ul li:hover > a,
    .widget_pages ul li:hover,
    .widget_pages ul li:hover > a,
    .widget_nav_menu ul li:hover,
    .widget_nav_menu ul li:hover > a,
    .wp-video .mejs-overlay-play .mejs-overlay-button:before,
    p a,
    body .organium_content_wrapper ol li:before,
    .organium_post_more a.read_more_button,
    .widget_calendar .calendar_wrap thead th,
    .wp-block-calendar table thead tr th
    {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    .organium_post_more .read_more_button:hover
    {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
        border-color: ' . esc_attr(organium_get_theme_mod('main_color')) . ' !important;
    }
    
    .organium_blog_listing_widget .organium_category_container,
    .organium_stories_wrapper .organium_button:hover,
    .organium_archive_listing .organium_category_container,
    body .elementor .mc4wp-form-fields input[type="submit"]:hover,
    .widget_media_audio .mejs-container,
    .widget_media_audio .mejs-container .mejs-controls,
    .widget_media_audio .mejs-embed,
    .widget_media_audio .mejs-embed body,
    .widget_archive ul li:hover:before,
    ul.wp-block-archives li:hover:before,
    .widget_categories ul li:hover:before,
    .widget_categories ul li.current-cat:before,
    ul.wp-block-categories li:hover:before,
    body .single_post_content ul.wp-block-categories li:hover:before,
    ul.wp-block-categories li.current-cat:before,
    body .single_post_content ul.wp-block-categories li.current-cat:before,
    .widget_organium_recipes_categories_widget ul li:hover:before,
    .widget_organium_recipes_categories_widget ul li.current-cat:before,
    .woocommerce .widget_product_categories ul li:hover:before,
    .woocommerce.widget_product_categories ul li:hover:before,
    .woocommerce-page .widget_product_categories ul li:hover:before,
    .woocommerce .widget_product_categories ul li.current-cat:before,
    .woocommerce.widget_product_categories ul li.current-cat:before,
    .woocommerce-page .widget_product_categories ul li.current-cat:before,
    .widget_meta ul li:hover:before,
    .widget_pages ul li:hover:before,
    .widget_nav_menu ul li:hover:before,
    .wp-video .mejs-container, 
    .wp-video .mejs-container .mejs-controls, 
    .wp-video .mejs-embed, 
    .wp-video .mejs-embed body,
    .has-drop-cap:not(:focus):first-letter,
    body .organium_content_wrapper ul li:before,
    body .organium_comments__item-text ul li:before,
    body .single_post_content ul li:before,
    body .single_portfolio_content ul li:before,
    body .single_recipe_content ul li:before,
    .widget_media_gallery .gallery .gallery-icon a:before,
    .widget_media_image a:hover:before,
    .organium_sidebar  #sb_instagram .sbi_item a:before {
        background: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    
    .organium_info_field a,
    .wp-block-calendar table tbody {
        color: ' . esc_attr(organium_get_theme_mod('main_font_color')) . ';
    }
    
    body .organium_content_wrapper .elementor-text-editor ul li,
    body .organium_content_wrapper .elementor-text-editor ol li,
    body .elementor-widget-counter .elementor-counter-title,
    body .elementor-widget-progress .elementor-title {
        font-family: ' . esc_attr(organium_get_theme_mod('main_font_family')) . ', sans-serif;
    }
    
    body .elementor-widget-text-editor.elementor-drop-cap-view-default .elementor-drop-cap,
    body .elementor-widget-accordion .elementor-active a,
    body .elementor-widget-accordion a,
    .widget_calendar .calendar_wrap caption,
    .wp-block-calendar caption,
    .widget_calendar .calendar_wrap tbody td#today,
    .wp-block-calendar tbody td#today {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    
    body .elementor-widget-counter .elementor-counter-number-wrapper {
        font-family: ' . esc_attr(organium_get_theme_mod('headings_font_family')) . ', sans-serif;
    }
    
    .organium_tabs_titles_container .organium_tab_title_item a:hover,
    .organium_tabs_titles_container .organium_tab_title_item.active a {
        color: ' . esc_attr(organium_get_theme_mod('post_socials_color')) . ';
        border-bottom-color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    
    .organium_blog_listing_widget .organium_post_title a,
    .organium_recent_posts_widget .organium_post_title a,
    .organium_sidebar .recent-posts__item-link,
    .organium_sidebar .recent-recipes__item-link,
    .organium_sidebar .widget.widget_categories ul li a,
    ul.wp-block-categories li a,
    .organium_sidebar .widget.widget_organium_recipes_categories_widget ul li a,
    .woocommerce .organium_sidebar .widget.widget_product_categories ul li a,
    .organium_sidebar .widget.woocommerce.widget_product_categories ul li a,
    .woocommerce-page .organium_sidebar .widget.widget_product_categories ul li a,
    .organium_sidebar .widget.widget_recent_entries ul li a,
    .organium_sidebar .widget.widget_archive ul li a,
    ul.wp-block-archives li a,
    .organium_sidebar .widget.widget_pages ul li a,
    .organium_sidebar .widget.widget_meta ul li a,
    .organium_sidebar .widget.widget_recent_comments ul li a,
    .wp-block-latest-comments li a,
    .organium_sidebar .widget.widget_rss .widget_title a,
    .organium_sidebar .widget.widget_rss ul li a,
    .wp-block-rss .wp-block-rss__item-title a,
    .organium_sidebar .widget.widget_nav_menu ul li a {
        color: ' . esc_attr(organium_get_theme_mod('listing_titles_color')) . ';
    }
    
    .organium_blog_listing_widget .organium_post_title a:hover,
    .organium_recent_posts_widget .organium_post_title a:hover,
    .organium_sidebar .recent-posts__item-link:hover,
    .organium_sidebar .recent-recipes__item-link:hover,
    .organium_sidebar .widget.widget_categories ul li:hover > a,
    .organium_sidebar .widget.widget_categories ul li.current-cat > a,
    ul.wp-block-categories li:hover > a,
    ul.wp-block-categories li:hover > .item-wrapper > a,
    .organium_sidebar .widget.widget_organium_recipes_categories_widget ul li:hover > a,
    .organium_sidebar .widget.widget_organium_recipes_categories_widget ul li.current-cat > a,
    .woocommerce .organium_sidebar .widget.widget_product_categories ul li:hover > a,
    .organium_sidebar .widget.woocommerce.widget_product_categories ul li:hover > a,
    .woocommerce-page .organium_sidebar .widget.widget_product_categories ul li:hover > a,
    .woocommerce .organium_sidebar .widget.widget_product_categories ul li.current-cat > a,
    .organium_sidebar .widget.woocommerce.widget_product_categories ul li.current-cat > a,
    .woocommerce-page .organium_sidebar .widget.widget_product_categories ul li.current-cat > a,
    .organium_sidebar .widget.widget_recent_entries ul li a:hover,
    .organium_sidebar .widget.widget_archive ul li a:hover,
    ul.wp-block-archives li a:hover,
    .organium_sidebar .widget.widget_pages ul li a:hover,
    .organium_sidebar .widget.widget_meta ul li a:hover,
    .organium_sidebar .widget.widget_recent_comments ul li a:hover,
    .wp-block-latest-comments li a:hover,
    .organium_sidebar .widget.widget_rss .widget_title a:hover,
    .organium_sidebar .widget.widget_rss ul li a:hover,
    .wp-block-rss .wp-block-rss__item-title a:hover,
    .organium_sidebar .widget.widget_nav_menu ul li a:hover {
        color: ' . esc_attr(organium_get_theme_mod('listing_titles_hover')) . ';
    }
    .organium_sidebar .widget_calendar table a,
    .wp-block-calendar table a {
        color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    
    .widget_rss cite,
    .wp-block-rss .wp-block-rss__item-author,
    .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_logo,
    .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_email,
    .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_phone,
    .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_address,
    .organium_contacts_widget_wrapper a,
    .widget_organium_address_widget .organium-socials li a {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    .widget_organium_address_widget .organium_contacts_widget_wrapper > div:before,
    .organium_contacts_widget_wrapper a:hover,
    .organium_sidebar .widget_calendar table a:hover,
    .wp-block-calendar table a:hover {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    .widget_organium_address_widget .organium-socials a:hover {
        background-color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    
    
    
    body .elementor-widget-accordion .elementor-accordion .elementor-tab-title .elementor-accordion-icon,
    body .elementor-widget-toggle .elementor-toggle .elementor-tab-title .elementor-toggle-icon {
        color: ' . esc_attr(organium_get_theme_mod('button_alter_color')) . ';
        background: ' . esc_attr(organium_get_theme_mod('button_alter_bg_color')) . ';
    }
    body .elementor-widget-accordion .elementor-accordion .elementor-accordion-title,
    body .elementor-widget-toggle .elementor-toggle .elementor-toggle-title {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
        font-family: ' . esc_attr(organium_get_theme_mod('header_menu_font_family')) . ', sans-serif;
        font-weight: ' . esc_attr(organium_get_theme_mod('header_menu_font_weight')) . ';
    }
    body .elementor-widget-accordion .elementor-accordion .elementor-tab-content,
    body .elementor-widget-toggle .elementor-toggle .elementor-tab-content,
    .wp-block-calendar table {
        font-family: ' . esc_attr(organium_get_theme_mod('main_font_family')) . ', sans-serif;
        font-weight: ' . esc_attr(organium_get_theme_mod('main_font_weight')) . ';
    }
    body .elementor-widget-accordion .elementor-accordion .elementor-active .elementor-accordion-title,
    body .elementor-widget-toggle .elementor-toggle .elementor-active .elementor-toggle-title {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    body .elementor-widget-accordion .elementor-accordion .elementor-accordion-item,
    body .elementor-widget-toggle .elementor-toggle .elementor-toggle-item {
        border-color: ' . esc_attr(organium_get_theme_mod('form_field_border')) . ';
    }
    
    .organium_price_item_widget .organium_price_container,
    .organium_price_schedule_widget .organium_price_container {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    .organium_price_item_widget .organium_price_wrapper,
    .organium_price_schedule_widget .organium_price_wrapper {
        font-family: ' . esc_attr(organium_get_theme_mod('additional_font_family')) . ';
        font-weight: ' . esc_attr(organium_get_theme_mod('additional_font_weight')) . ';
    }
    .organium_price_item_widget .organium_custom_fields_container .organium_custom_field.organium_active_field:before {
        color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    .organium_price_item .organium_price_button_container .organium_button,
    .organium_price_schedule_item .organium_price_button_container .organium_button,
    .organium_date_field:after,
    .organium_select_field:after,
    .organium_time_field:after {
        color: ' . esc_attr(organium_get_theme_mod('button_alter_color')) . ';
        background: ' . esc_attr(organium_get_theme_mod('button_alter_bg_color')) . ';
    }
    .organium_price_item .organium_price_button_container .organium_button:hover {
        color: ' . esc_attr(organium_get_theme_mod('button_alter_hover')) . ';
        background: ' . esc_attr(organium_get_theme_mod('button_alter_bg_hover')) . ';
        box-shadow: 0px 15px 40px rgba(' . esc_attr(organium_hex2rgb(organium_get_theme_mod('button_alter_bg_color'))) . ', 0.24);
    }
    .organium_price_item.active .organium_price_button_container .organium_button,
    .organium_price_schedule_item:hover .organium_price_button_container .organium_button {
        color: ' . esc_attr(organium_get_theme_mod('button_color')) . ';
        background: ' . esc_attr(organium_get_theme_mod('button_bg_color')) . ';
    }
    .organium_price_item.active .organium_price_button_container .organium_button:hover,
    .organium_price_schedule_item:hover .organium_price_button_container .organium_button:hover {
        color: ' . esc_attr(organium_get_theme_mod('button_hover')) . ';
        background: ' . esc_attr(organium_get_theme_mod('button_bg_hover')) . ';
        box-shadow: 0px 15px 40px rgba(' . esc_attr(organium_hex2rgb(organium_get_theme_mod('button_bg_color'))) . ', 0.24);
    }
    
    .organium_heading_widget .organium_up_heading {
        font-family: ' . esc_attr(organium_get_theme_mod('additional_font_family')) . ';
        font-weight: ' . esc_attr(organium_get_theme_mod('additional_font_weight')) . ';
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    .organium_heading_widget .organium_heading span,
    .elementor-image-gallery .gallery .gallery-item a:after {
        color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    
    .organium_tabs_widget .organium_tabs_titles_container,
    .organium_free_tabs_widget .organium_tabs_titles_container {
        border-color: ' . esc_attr(organium_get_theme_mod('form_field_border')) . ';
    }
    .organium_tabs_widget .organium_tabs_titles_container .organium_tab_title_item a,
    .organium_free_tabs_widget .organium_tabs_titles_container .organium_tab_title_item a {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    .organium_tabs_widget .organium_tabs_titles_container .organium_tab_title_item a:hover,
    .organium_free_tabs_widget .organium_tabs_titles_container .organium_tab_title_item a:hover,
    .elementor-widget-image-carousel.image_style_1 .swiper-slide a:after {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    .organium_tabs_widget .organium_tabs_titles_container .organium_tab_title_item.active a,
    .organium_free_tabs_widget .organium_tabs_titles_container .organium_tab_title_item.active a {
        background-color: ' . esc_attr(organium_get_theme_mod('button_alter_bg_color')) . ';
        color: ' . esc_attr(organium_get_theme_mod('button_alter_color')) . ';
    }
    
    .elementor-widget-counter .elementor-counter .elementor-counter-number-wrapper {
        font-family: ' . esc_attr(organium_get_theme_mod('additional_font_family')) . ';
        font-weight: ' . esc_attr(organium_get_theme_mod('additional_font_weight')) . ';
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    .organium_content_slider_widget .organium_content_slider_title em {
        font-family: ' . esc_attr(organium_get_theme_mod('additional_font_family')) . ';
        font-weight: ' . esc_attr(organium_get_theme_mod('additional_font_weight')) . ';
    }
    .elementor-widget-counter .elementor-counter .elementor-counter-title,
    .elementor-widget-image-carousel.image_style_2 .swiper-slide a:after {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    
    .slick-dots li:after,
    .elementor-widget-image-carousel .swiper-pagination .swiper-pagination-bullet:after {
        background: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    .slick-dots li.slick-active,
    .elementor-widget-image-carousel .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active {
        border-color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    .organium_testimonial_carousel_widget .organium_testimonial_carousel_wrapper.view_type_1 .organium_testimonial_item .organium_testimonial,
    .organium_testimonial_carousel_widget .organium_testimonial_carousel_wrapper.view_type_3 .organium_testimonial_item .organium_testimonial,
    .organium_testimonial_carousel_widget .organium_testimonial_carousel_wrapper .organium_testimonial_item .organium_author_name,
    .organium_content_slider_widget .slick-arrow:after {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    
    .organium_icon_box_widget .organium_icon_box_item .organium_icon_container .text {
        font-family: ' . esc_attr(organium_get_theme_mod('additional_font_family')) . ';
        font-weight: ' . esc_attr(organium_get_theme_mod('additional_font_weight')) . ';
    }
    .organium_icon_box_widget .organium_icon_box_item .organium_icon_container svg {
        fill: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    
    .organium_ad_banner_widget.view_type_1 .organium_banner_title,
    .organium_timeline_widget .organium_timeline_date,
    .organium_countdown_widget .countdown_digits,
    .organium_countdown_widget .countdown_digits_placeholder,
    .organium_countdown_widget .countdown_separator,
    .organium_price_inline_widget .organium_price {
        font-family: ' . esc_attr(organium_get_theme_mod('additional_font_family')) . ';
        font-weight: ' . esc_attr(organium_get_theme_mod('additional_font_weight')) . ';
    }
    .organium_ad_banner_widget .organium_banner_subtitle,
    .organium_ad_banner_widget .organium_banner_description,
    div.wpforms-container .wpforms-form .wpforms-field-label, 
    div.wpforms-container .wpforms-form .wpforms-field-label-inline {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    
    .organium_testimonial_carousel_widget .organium_testimonial_carousel_wrapper.view_type_3 .organium_testimonial_item .organium_testimonial:before {
        color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    .organium_person_widget ul.organium_person_socials li a,
    .organium_icon_box_widget ul.organium_icon_box_socials li a,
    .organium_countdown_widget .countdown_label,
    .organium_price_inline_widget .organium_period {
        color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    
    .organium_person_widget ul.organium_person_socials li a:hover,
    .organium_icon_box_widget ul.organium_icon_box_socials li a:hover {
        background-color: ' . esc_attr(organium_get_theme_mod('button_bg_color')) . ';
        color: ' . esc_attr(organium_get_theme_mod('button_color')) . ';
    }
    
    div.wpforms-container .wpforms-form .wpforms-field.wpforms-field-number-slider input[type="range"],
    .organium_content_slider_widget .slick-arrow:hover:before {
        background-color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    
    .organium_timeline_widget .organium_timeline_item .organium_timeline_date,
    .organium_ad_banner_widget.view_type_2 .organium_banner_title,
    .organium_testimonial_carousel_widget .organium_testimonial_carousel_wrapper.view_type_4 .organium_testimonial_item .organium_testimonial:before {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    .organium_timeline_widget .organium_timeline_item .organium_timeline_dot,
    .organium_timeline_widget .organium_timeline_item:after {
        border-color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    .organium_timeline_widget .organium_timeline_item:before,
    .organium_timeline_widget .organium_timeline_item .organium_timeline_dot:before {
        background-color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    
    .organium_video_widget .organium_overlay, 
    .organium_tabs_widget .organium_overlay {
        background-color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
    }
    .organium_video_widget .organium_video_trigger_button .organium_button_icon, 
    .organium_tabs_widget .organium_video_trigger_button .organium_button_icon,
    .organium_countdown_widget .countdown_digits,
    .organium_countdown_widget .countdown_separator  {
        color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
    }
    
    .elementor-widget-icon-list .elementor-icon-list-item .elementor-icon-list-icon i,
    .organium_price_inline_widget .organium_price {
        color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
    
    .organium_image_widget .organium_image_container.organium_image_style_framed:before,
    .organium_video_widget .organium_image_style_framed:before {
        border-color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
    }
';

// --------------------------- //
// ------- WooCommerce ------- //
// --------------------------- //
if ( class_exists('WooCommerce') ) {
    $organium_custom_css .= '
        .organium_shop_loop select.orderby {
            color: ' . esc_attr(organium_get_theme_mod('listing_titles_color')) . ';
        }
        .woocommerce .shop_mode_grid .woocommerce-loop-product__wrapper:hover, 
        .woocommerce-page .shop_mode_grid .woocommerce-loop-product__wrapper:hover,
        .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, 
        .woocommerce.widget_price_filter .ui-slider .ui-slider-handle {
            border-color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
        }
        .shop-mode-buttons a,
        .woocommerce .woocommerce-result-count,
        .woocommerce .woocommerce-ordering,
        .organium_aside-dropdown .organium_aside-dropdown__close,
        .organium_page_content_wrapper .organium_sidebar.shop_hidden_sidebar .shop_hidden_sidebar_close,
        .organium_video_widget .organium_video_container .organium_close_popup_layer .organium_close_button, 
        .organium_tabs_widget .organium_video_container .organium_close_popup_layer .organium_close_button {
            color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
        }
        .shop-mode-buttons a svg {
            fill: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
        }
        .woocommerce-loop-product__wrapper a.button,
        .organium_aside-dropdown .organium_aside-dropdown__close:hover,
        .organium_page_content_wrapper .organium_sidebar.shop_hidden_sidebar .shop_hidden_sidebar_close:hover,
        .organium_video_widget .organium_video_container .organium_close_popup_layer .organium_close_button:hover, 
        .organium_tabs_widget .organium_video_container .organium_close_popup_layer .organium_close_button:hover {
            color: ' . esc_attr(organium_get_theme_mod('button_color')) . ';
            background: ' . esc_attr(organium_get_theme_mod('button_bg_color')) . ';
        }
        .woocommerce-loop-product__wrapper a.button:hover {
            color: ' . esc_attr(organium_get_theme_mod('button_hover')) . ';
            background: ' . esc_attr(organium_get_theme_mod('button_bg_hover')) . ';
            box-shadow: 0px 15px 40px rgba(' . esc_attr(organium_hex2rgb(organium_get_theme_mod('button_bg_color'))) . ', 0.24);
        }
        .woocommerce-loop-product__wrapper a.added_to_cart {
            color: ' . esc_attr(organium_get_theme_mod('button_alter_color')) . ';
            background: ' . esc_attr(organium_get_theme_mod('button_alter_bg_color')) . ';
        }
        .woocommerce-loop-product__wrapper a.added_to_cart:hover {
            color: ' . esc_attr(organium_get_theme_mod('button_alter_hover')) . ';
            background: ' . esc_attr(organium_get_theme_mod('button_alter_bg_hover')) . ';
            box-shadow: 0px 15px 40px rgba(' . esc_attr(organium_hex2rgb(organium_get_theme_mod('button_alter_bg_color'))) . ', 0.24);
        }
        .organium_product_masonry_widget .product_masonry_item .price,
        .woocommerce ul.products li.product .price, 
        .woocommerce-page ul.products li.product .price,
        .woocommerce ul.product_list_widget li .price_wrapper, 
        .woocommerce-page ul.product_list_widget li .price_wrapper,
        .woocommerce .widget_shopping_cart .cart_list li .content-woocommerce_wrapper .quantity .amount, 
        .woocommerce-page .widget_shopping_cart .cart_list li .content-woocommerce_wrapper .quantity .amount,
        .woocommerce.widget_shopping_cart .cart_list li .content-woocommerce_wrapper .quantity .amount,
        .single-product.woocommerce div.product .price,
        .woocommerce .woocommerce-cart-form table.shop_table .product-name a:hover, 
        .woocommerce-page .woocommerce-cart-form table.shop_table .product-name a:hover,
        .woocommerce div.product form.cart .group_table label a:hover,
        .woocommerce div.product form.cart .group_table .price_wrapper,
        .product-filters-trigger {
            color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
        }
        .woocommerce a.remove {
            color: ' . esc_attr(organium_get_theme_mod('main_color')) . ' !important;
        }
        
        .woocommerce nav.woocommerce-pagination ul li .page-numbers,
        .woocommerce nav.woocommerce-pagination ul li .post-page-numbers,
        .woocommerce .widget_shopping_cart .total, 
        .woocommerce-page .widget_shopping_cart .total,
        .woocommerce.widget_shopping_cart .total,
        .single-product.woocommerce div.product .product_meta .product_meta_item,
        .single-product.woocommerce div.product .product_meta .product_meta_item.posted_in a,
        .woocommerce-cart table.cart th,
        .woocommerce .woocommerce-cart-form table.shop_table .product-name a, 
        .woocommerce-page .woocommerce-cart-form table.shop_table .product-name a,
        .woocommerce .woocommerce-cart-form table.shop_table .product-price .amount, 
        .woocommerce .woocommerce-cart-form table.shop_table .product-subtotal .amount, 
        .woocommerce-page .woocommerce-cart-form table.shop_table .product-price .amount, 
        .woocommerce-page .woocommerce-cart-form table.shop_table .product-subtotal .amount {
            color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
        }
        .woocommerce nav.woocommerce-pagination ul li span.current,
        .woocommerce nav.woocommerce-pagination ul li a:hover {
            background: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
            border-color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
        }
        .woocommerce .widget_shopping_cart .woocommerce-mini-cart__buttons a.button.checkout, 
        .woocommerce-page .widget_shopping_cart .woocommerce-mini-cart__buttons a.button.checkout,
        .woocommerce.widget_shopping_cart .woocommerce-mini-cart__buttons a.button.checkout,
        .mini_cart .mini_cart_panel .woocommerce-mini-cart__buttons a.button.checkout,
        .single-product.woocommerce div.product .cart .button,
        #add_payment_method .wc-proceed-to-checkout a.checkout-button, 
        .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, 
        .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button,
        .woocommerce .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper .button.alt, 
        .woocommerce-page .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper .button.alt,
        .organium_product_masonry_widget .product_masonry_item .button,
        .organium_product_masonry_widget .product_masonry_item .added_to_cart,
        .woocommerce a.button,
        .woocommerce a.button.disabled:hover, 
        .woocommerce a.button:disabled:hover, 
        .woocommerce a.button:disabled[disabled]:hover,
        .woocommerce a.button.alt,
        .woocommerce a.button.alt.disabled:hover, 
        .woocommerce a.button.alt:disabled:hover, 
        .woocommerce a.button.alt:disabled[disabled]:hover {
            color: ' . esc_attr(organium_get_theme_mod('button_color')) . ';
            background: ' . esc_attr(organium_get_theme_mod('button_bg_color')) . ';
        }
        .woocommerce .widget_shopping_cart .woocommerce-mini-cart__buttons a.button.checkout:hover, 
        .woocommerce-page .widget_shopping_cart .woocommerce-mini-cart__buttons a.button.checkout:hover,
        .woocommerce.widget_shopping_cart .woocommerce-mini-cart__buttons a.button.checkout:hover,
        .mini_cart .mini_cart_panel .woocommerce-mini-cart__buttons a.button.checkout:hover,
        .single-product.woocommerce div.product .cart .button:hover,
        #add_payment_method .wc-proceed-to-checkout a.checkout-button:hover, 
        .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, 
        .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button:hover,
        .woocommerce .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper .button.alt:hover, 
        .woocommerce-page .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper .button.alt:hover,
        .organium_product_masonry_widget .product_masonry_item .button:hover,
        .organium_product_masonry_widget .product_masonry_item .added_to_cart:hover,
        .woocommerce a.button:not(.disabled):not(:disabled):hover,
        .woocommerce a.button.alt:not(.disabled):not(:disabled):hover {
            color: ' . esc_attr(organium_get_theme_mod('button_hover')) . ';
            background: ' . esc_attr(organium_get_theme_mod('button_bg_hover')) . ';
            box-shadow: 0px 15px 40px rgba(' . esc_attr(organium_hex2rgb(organium_get_theme_mod('button_bg_color'))) . ', 0.24);
        }
        .woocommerce .widget_shopping_cart .woocommerce-mini-cart__buttons a.button, 
        .woocommerce-page .widget_shopping_cart .woocommerce-mini-cart__buttons a.button,
        .woocommerce.widget_shopping_cart .woocommerce-mini-cart__buttons a.button,
        .mini_cart .mini_cart_panel .woocommerce-mini-cart__buttons a.button,
        .container .select2-container.select2-container--default .select2-results .select2-results__option--highlighted[aria-selected], 
        .container .select2-container.select2-container--default .select2-results .select2-results__option--highlighted[data-selected] {
            color: ' . esc_attr(organium_get_theme_mod('button_alter_color')) . ';
            background: ' . esc_attr(organium_get_theme_mod('button_alter_bg_color')) . ';
        }
        .woocommerce .widget_shopping_cart .woocommerce-mini-cart__buttons a.button:hover, 
        .woocommerce-page .widget_shopping_cart .woocommerce-mini-cart__buttons a.button:hover,
        .woocommerce.widget_shopping_cart .woocommerce-mini-cart__buttons a.button:hover,
        .mini_cart .mini_cart_panel .woocommerce-mini-cart__buttons a.button:hover {
            color: ' . esc_attr(organium_get_theme_mod('button_alter_hover')) . ';
            background: ' . esc_attr(organium_get_theme_mod('button_alter_bg_hover')) . ';
            box-shadow: 0px 15px 40px rgba(' . esc_attr(organium_hex2rgb(organium_get_theme_mod('button_alter_bg_color'))) . ', 0.24);
        }
        .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
        .woocommerce.widget_price_filter .ui-slider .ui-slider-range,
        .woocommerce .widget_price_filter .ui-slider .ui-slider-handle:before,
        .woocommerce.widget_price_filter .ui-slider .ui-slider-handle:before,
        .woocommerce .widget_layered_nav_filters ul .chosen a:hover, 
        .woocommerce.widget_layered_nav_filters ul .chosen a:hover, 
        .woocommerce-page .widget_layered_nav_filters ul .chosen a:hover,
        .single-product.woocommerce div.product .product_meta .tagged_as a:hover {
            background: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
        }
        
        .woocommerce ul.product_list_widget li .product-title, 
        .woocommerce-page ul.product_list_widget li .product-title,
        .woocommerce .woocommerce-widget-layered-nav ul.woocommerce-widget-layered-nav-list li.woocommerce-widget-layered-nav-list__item a, 
        .woocommerce.woocommerce-widget-layered-nav ul.woocommerce-widget-layered-nav-list li.woocommerce-widget-layered-nav-list__item a, 
        .woocommerce-page .woocommerce-widget-layered-nav ul.woocommerce-widget-layered-nav-list li.woocommerce-widget-layered-nav-list__item a,
        .single-product.woocommerce .organium_content_wrapper .woocommerce-tabs table.shop_attributes tr td, 
        .single-product.woocommerce .organium_content_wrapper .woocommerce-tabs table.shop_attributes tr th,
        .woocommerce #reviews #comments ol.commentlist li.review .comment_container .woocommerce-review__author,
        .woocommerce .cart-collaterals .cart_totals table.shop_table, 
        .woocommerce-page .cart-collaterals .cart_totals table.shop_table,
        .checkout_cart_table .product-name .product-name-title,
        .checkout_cart_table .product-total .amount,
        .checkout_total_table tr td,
        .woocommerce-shipping-methods li,
        #add_payment_method #payment#payment ul.payment_methods li label, 
        .woocommerce-cart #payment#payment ul.payment_methods li label, 
        .woocommerce-checkout #payment#payment ul.payment_methods li label,
        .woocommerce-account .woocommerce-MyAccount-navigation ul li a,
        .woocommerce-form__label-for-checkbox,
        .woocommerce-account .form-attention,
        .woocommerce-account .woocommerce-privacy-policy-text,
        .woocommerce table.shop_table td,
        .woocommerce table.shop_table th,
        .woocommerce div.product form.cart .group_table label a {
            color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
        }
        .woocommerce ul.product_list_widget li .product-title:hover, 
        .woocommerce-page ul.product_list_widget li .product-title:hover,
        .woocommerce .widget_layered_nav_filters ul .chosen a:before, 
        .woocommerce.widget_layered_nav_filters ul .chosen a:before, 
        .woocommerce-page .widget_layered_nav_filters ul .chosen a:before,
        .single-product.woocommerce div.product .product_meta .product_meta_item.posted_in a:hover,
        .single-product.woocommerce .organium_content_wrapper .woocommerce-tabs ul.tabs li a:hover,
        .woocommerce .woocommerce-loop-product__wrapper .yith-wcwl-add-to-wishlist .add_to_wishlist:hover, 
        .woocommerce-page .woocommerce-loop-product__wrapper .yith-wcwl-add-to-wishlist .add_to_wishlist:hover,
        .single-product.woocommerce div.product .cart .yith-wcwl-add-to-wishlist .add_to_wishlist:hover,
        .organium_product_masonry_widget .product_masonry_item .yith-wcwl-add-to-wishlist .add_to_wishlist:hover,
        .woocommerce-account .woocommerce-MyAccount-navigation ul li a:hover,
        .tab-columns-switcher {
            color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
        }
        .woocommerce .quantity-wrapper.styled .btn-plus:before, 
        .woocommerce .quantity-wrapper.styled .btn-plus:after,
        .woocommerce .quantity-wrapper.styled .btn-minus:before {
            background-color: ' . esc_attr(organium_get_theme_mod('headings_color')) . ';
        }
        .woocommerce .quantity-wrapper.styled .btn-plus:hover:before, 
        .woocommerce .quantity-wrapper.styled .btn-plus:hover:after,
        .woocommerce .quantity-wrapper.styled .btn-minus:hover:before {
            background-color: ' . esc_attr(organium_get_theme_mod('main_color')) . ';
        }
        .single-product.woocommerce .organium_content_wrapper .woocommerce-tabs ul.tabs li.active a,
        .woocommerce-account .woocommerce-MyAccount-navigation ul li.is-active a {
            color: ' . esc_attr(organium_get_theme_mod('button_alter_color')) . ';
            background: ' . esc_attr(organium_get_theme_mod('button_alter_bg_color')) . ';
        }
        
        .woocommerce #respond input#submit,
        .woocommerce button.button, 
        .woocommerce input.button,
        .woocommerce #review_form #respond p.form-submit input#submit,
        .woocommerce #respond input#submit.disabled, 
        .woocommerce #respond input#submit:disabled, 
        .woocommerce #respond input#submit:disabled[disabled], 
        .woocommerce button.button.disabled, 
        .woocommerce button.button:disabled, 
        .woocommerce button.button:disabled[disabled], 
        .woocommerce input.button.disabled, 
        .woocommerce input.button:disabled, 
        .woocommerce input.button:disabled[disabled],
        .woocommerce #respond input#submit.disabled:hover, 
        .woocommerce #respond input#submit:disabled:hover, 
        .woocommerce #respond input#submit:disabled[disabled]:hover, 
        .woocommerce button.button.disabled:hover, 
        .woocommerce button.button:disabled:hover, 
        .woocommerce button.button:disabled[disabled]:hover, 
        .woocommerce input.button.disabled:hover, 
        .woocommerce input.button:disabled:hover, 
        .woocommerce input.button:disabled[disabled]:hover {
            color: ' . esc_attr(organium_get_theme_mod('form_button_color')) . ';
            background: ' . esc_attr(organium_get_theme_mod('form_button_bg')) . ';
        }
        
        .woocommerce #respond input#submit:not(.disabled):not(:disabled):hover,
        .woocommerce button.button:not(.disabled):not(:disabled):hover, 
        .woocommerce input.button:not(.disabled):not(:disabled):hover,
        .woocommerce #review_form #respond p.form-submit input#submit:not(.disabled):not(:disabled):hover {
            color: ' . esc_attr(organium_get_theme_mod('form_button_hover')) . ';
            background: ' . esc_attr(organium_get_theme_mod('form_button_bg_hover')) . ';
            box-shadow: 0px 15px 40px rgba(' . esc_attr(organium_hex2rgb(organium_get_theme_mod('form_button_bg'))) . ', 0.24);
        }
        .woocommerce .woocommerce-loop-product__wrapper .yith-wcwl-add-to-wishlist .add_to_wishlist, 
        .woocommerce-page .woocommerce-loop-product__wrapper .yith-wcwl-add-to-wishlist .add_to_wishlist,
        .single-product.woocommerce div.product .cart .yith-wcwl-add-to-wishlist .add_to_wishlist,
        .organium_product_masonry_widget .product_masonry_item .yith-wcwl-add-to-wishlist .add_to_wishlist,
        .tab-columns-switcher:hover {
            color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
        }
        .woocommerce .shop_mode_grid .woocommerce-loop-product__wrapper .attachment-woocommerce_wrapper a.remove_from_wishlist:hover, 
        .woocommerce-page .shop_mode_grid .woocommerce-loop-product__wrapper .attachment-woocommerce_wrapper a.remove_from_wishlist:hover {
            color: ' . esc_attr(organium_get_theme_mod('button_hover')) . ';
            background: ' . esc_attr(organium_get_theme_mod('button_bg_hover')) . ';
            border-color: ' . esc_attr(organium_get_theme_mod('button_bg_hover')) . ';
        }
        .woocommerce-account .woocommerce-MyAccount-navigation ul {
            border-color: ' . esc_attr(organium_get_theme_mod('form_field_border')) . ';
        }
        
        .organium_products_widget.view_type_compact .woocommerce-loop-product__wrapper:hover .attachment-woocommerce_wrapper .attachment-woocommerce_thumbnail {
            border-color: ' . esc_attr(organium_get_theme_mod('accent_color')) . ';
        }
    ';
}