<?php
    defined( 'ABSPATH' ) or die();

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
    ){
        $organium_retina_class = 'organium_retina_logo';
    }

?>
    <!-- Menu Block -->
    <div class="organium_mobile_header_menu_container">
        <div class="row justify-content-between">

            <!-- Logo Block -->
            <div class="col-auto d-flex align-items-center organium_logo_container">
                <div class="organium_header-logo">
                    <a class="organium_header-logo__link <?php echo esc_attr($organium_retina_class); ?>" href="<?php echo esc_url(home_url('/')); ?>">
                        <?php
                            if (
                                (
                                    $header_customize_logo == 'yes' &&
                                    empty(organium_get_post_option('logo_image'))
                                ) || (
                                    $header_customize_logo != 'yes' &&
                                    empty(organium_get_theme_mod('logo_image'))
                                )
                            ) {
                                echo '<span class="site_name">' . get_bloginfo( 'name', 'display' ) . '</span>';
                            }
                        ?>
                    </a>
                </div>
            </div>

            <!-- Icons Block -->
            <div class="col-auto d-flex align-items-center flex-shrink-0 organium_header_icons_container">

                <?php
                $header_customize_side = organium_get_post_option('header_customize_side');
                $menu_trigger_classes = 'organium_header_icon menu_close menu_close--large';
                ?>
                <div class="<?php echo esc_attr($menu_trigger_classes); ?>">
                    <span class="menu_close_icon"></span>
                </div>
            </div>

        </div>
        <nav>
            <?php
                $header_customize_menu = organium_get_post_option('header_customize_menu');
                if (
                    $header_customize_menu == 'yes' &&
                    organium_get_post_option('main_menu') != 'default' &&
                    organium_get_post_option('main_menu') != false
                ) {
                    wp_nav_menu(
                        array(
                            'menu'              => organium_get_post_option('main_menu'),
                            'menu_class'        => 'organium_main-menu organium_main-menu--inner',
                            'depth'             => '0',
                            'container'         => ''
                        )
                    );
                } else {
                    $organium_menu_locations = get_nav_menu_locations();
                    if (
                        isset($organium_menu_locations['main']) &&
                        $organium_menu_locations['main'] !== 0
                    ) {
                        wp_nav_menu(
                            array(
                                'theme_location'    => 'main',
                                'menu_class'        => 'organium_main-menu organium_main-menu--inner',
                                'depth'             => '0',
                                'container'         => ''
                            )
                        );
                    }
                }
            ?>
        </nav>
         <div>

                <div class="cm-form-login_out-main">
                  
                   <?php

                   if ( is_user_logged_in() ){
                    ?>
                    
                    <div class="cm-form-login_out">  
                       <a href="/thuc-don/">Tài khoản</a>
                       <a href=" <?php echo wp_logout_url('https://caremeal.vn/'); ?>">Đăng xuất</a>
                   </div>
                   <?php
               } else{
                ?>
                <div class="cm-form-login_out">
                    <a href="https://caremeal.vn/wp-admin/">Đăng nhập</a>
                    <a href="https://caremeal.vn/dang-ky/">Đăng ký</a>
                </div>
                
                <?php
            }
            ?>
        </div>
    </div>
        <div class="organium_header_mobile_footer d-flex align-items-center">
            <?php
            if (
                class_exists('WooCommerce') &&
                (
                    (
                        organium_get_post_option('header_customize_minicart') == 'yes' &&
                        organium_get_post_option('header_minicart') == 'on'
                    ) || (
                        organium_get_post_option('header_customize_minicart') != 'yes' &&
                        organium_get_theme_mod('header_minicart') == 'on'
                    )
                )
            ) { ?>
                <div class="organium_header_icon mini_cart d-block">
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="mini_cart_trigger">
                        <i class='mini_cart_count'>
                            <?php
                            echo '<span>'. WC()->cart->cart_contents_count .'</span>';
                            ?>
                        </i>
                    </a>
                </div>
            <?php } ?>

            <?php
            $header_customize_search = organium_get_post_option('header_customize_search');
            if (
                (
                    $header_customize_search == 'yes' &&
                    organium_get_post_option('header_search') == 'on'
                ) || (
                    $header_customize_search != 'yes' &&
                    organium_get_theme_mod('header_search') == 'on'
                )
            ) { ?>
                <div class="organium_header_icon search_trigger d-block">
                    <span class="search_trigger_icon"></span>
                </div>
            <?php } ?>

            <?php
                if (
                    class_exists('WooCommerce') && function_exists( 'yith_plugin_registration_hook' ) &&
                    (
                        (
                            organium_get_post_option('header_customize_wishlist') == 'yes' &&
                            organium_get_post_option('header_wishlist') == 'on'
                        ) || (
                            organium_get_post_option('header_customize_wishlist') != 'yes' &&
                            organium_get_theme_mod('header_wishlist') == 'on'
                        )
                    )
                ) { ?>
                    <div class="organium_header_icon wishlist_link d-block">
                        <a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>" class="wishlist_link_icon"></a>
                    </div>
            <?php } ?>
        </div>

        <?php
            $header_customize_socials = organium_get_post_option('header_customize_socials');
            if (
                (
                    $header_customize_socials == 'yes' &&
                    organium_get_post_option('header_socials') == 'on'
                ) || (
                    $header_customize_socials != 'yes' &&
                    organium_get_theme_mod('header_socials') == 'on'
                )
            ) {
                echo '<div class="organium_header_mobile_footer">';
                    $social_classes = 'organium_header_icon organium_header_socials';
                    $social_classes .= organium_get_prefered_option('header_socials_type') == 'bg' ? ' organium_header_socials--bg' : '';
                    echo organium_socials_output($social_classes);
                echo '</div>';
            }
        ?>


        <?php
        $header_customize_button = organium_get_post_option('header_customize_button');
        if (
            (
                $header_customize_button == 'yes' &&
                organium_get_post_option('header_button') == 'on'
            ) || (
                $header_customize_button != 'yes' &&
                organium_get_theme_mod('header_button') == 'on'
            )
        ) {
        ?>
            <div class="organium_header_mobile_footer">
                <div class="header_button_container">
                    <a class="organium_button organium_button--squared" href="<?php echo (!empty(organium_get_theme_mod('header_button_url')) ? esc_url(organium_get_theme_mod('header_button_url')) : esc_js('javascript:void(0);')); ?>">
                        <span><?php echo esc_html(organium_get_theme_mod('header_button_text')); ?></span>
                    </a>
                </div>
            </div>
        <?php
            }
        ?>
    </div>