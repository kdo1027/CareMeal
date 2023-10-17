<?php
    defined( 'ABSPATH' ) or die();

    $header_customize_logo = organium_get_post_option('header_customize_logo');
    $organium_retina_class = 'organium_non_retina_logo';
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

    <div class="row justify-content-between flex-nowrap">

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
                <div class="organium_header_icon search_trigger d-none d-md-block">
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
                <div class="organium_header_icon wishlist_link d-none d-md-block">
                    <a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>" class="wishlist_link_icon"></a>
                </div>
            <?php } ?>

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
                <div class="organium_header_icon mini_cart d-none d-md-block">
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
                $menu_trigger_classes = 'organium_header_icon menu_trigger';
                $menu_trigger_classes .= organium_get_prefered_option('side_panel_trigger_type') == 'large' ? ' menu_trigger--large' : ' menu_trigger--small';
            ?>
            <div class="<?php echo esc_attr($menu_trigger_classes); ?>">
                <span class="menu_trigger_icon">
                    <span class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </span>
            </div>
        </div>

    </div>