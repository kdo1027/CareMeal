<?php
defined( 'ABSPATH' ) or die();
?>
<div class="container-fluid">
    <div class="row no-gutters justify-content-between align-items-center flex-nowrap">

        <!-- Icons Block -->
        <div class="col-auto d-flex align-items-center organium_header_icons_container">
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
                    $social_classes = 'organium_header_icon organium_header_socials';
                    $social_classes .= organium_get_prefered_option('header_socials_type') == 'bg' ? ' organium_header_socials--bg' : '';
                    echo organium_socials_output($social_classes);
                }
            ?>
        </div>

        <!-- Menu Block -->
        <?php
        if (
            organium_get_post_option('header_customize_menu') == 'yes' &&
            organium_get_post_option('main_menu') != 'default' &&
            organium_get_post_option('main_menu') != false
        ) {
            $menu_string = wp_nav_menu(
                array(
                    'menu'              => organium_get_post_option('main_menu'),
                    'items_wrap'        => '%3$s',
                    'depth'             => '1',
                    'container'         => '',
                    'echo'              => false
                )
            );
            $menu_string = str_replace('</li>
<li', '</li>@@@<li', $menu_string);
            $menu_array = explode('@@@', $menu_string);
            $menu_count = count($menu_array);
            $menu_center_item_num = ceil($menu_count / 2) - 1;
            $menu_center_item = $menu_array[$menu_center_item_num];
            preg_match('/menu-item-[0-9]+"/u', $menu_center_item, $menu_center_item_id);
            $menu_center_item_id = str_replace('menu-item-', '', $menu_center_item_id[0]);
            $menu_center_item_id = str_replace('"', '', $menu_center_item_id);
            wp_nav_menu(
                array(
                    'menu'              => organium_get_post_option('main_menu'),
                    'menu_class'        => 'organium_main-menu organium_main-menu--inner col-auto',
                    'depth'             => '0',
                    'container'         => '',
                    'center'            => $menu_center_item_id,
                    'walker'            => new Organium_Double_Menu_Walker()
                )
            );
        } else {
            $organium_menu_locations = get_nav_menu_locations();
            if (
                isset($organium_menu_locations['main']) &&
                $organium_menu_locations['main'] !== 0
            ) {
                $menu_string = wp_nav_menu(
                    array(
                        'theme_location'    => 'main',
                        'items_wrap'        => '%3$s',
                        'depth'             => '1',
                        'container'         => '',
                        'echo'              => false
                    )
                );
                $menu_string = str_replace('</li>
<li', '</li>@@@<li', $menu_string);
                $menu_array = explode('@@@', $menu_string);
                $menu_count = count($menu_array);
                $menu_center_item_num = ceil($menu_count / 2) - 1;
                $menu_center_item = $menu_array[$menu_center_item_num];
                preg_match('/menu-item-[0-9]+"/u', $menu_center_item, $menu_center_item_id);
                $menu_center_item_id = str_replace('menu-item-', '', $menu_center_item_id[0]);
                $menu_center_item_id = str_replace('"', '', $menu_center_item_id);
                wp_nav_menu(
                    array(
                        'theme_location'    => 'main',
                        'menu_class'        => 'organium_main-menu organium_main-menu--inner',
                        'depth'             => '0',
                        'container'         => '',
                        'center'            => $menu_center_item_id,
                        'walker'            => new Organium_Double_Menu_Walker()
                    )
                );
            }
        }
        ?>

        <!-- Icons Block -->
        <div class="col-auto d-flex align-items-center organium_header_icons_container">
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
                <div class="organium_header_icon search_trigger">
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
                <div class="organium_header_icon wishlist_link">
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
                <div class="organium_header_icon mini_cart">
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="mini_cart_trigger">
                        <i class='mini_cart_count'>
                            <?php
                            echo '<span>'. WC()->cart->cart_contents_count .'</span>';
                            ?>
                        </i>
                    </a>

                    <?php woocommerce_mini_cart(); ?>
                </div>
            <?php } ?>


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
                <div class="organium_header_icon header_button_container">
                    <a class="organium_button organium_button--squared" href="<?php echo (!empty(organium_get_prefered_option('header_button_url')) ? esc_url(organium_get_prefered_option('header_button_url')) : esc_js('javascript:void(0);')); ?>">
                        <span><?php echo esc_html(organium_get_prefered_option('header_button_text')); ?></span>
                    </a>
                </div>
                <?php
            }
            ?>

            <?php
            $header_customize_side = organium_get_post_option('header_customize_side');
            if (
                (
                    $header_customize_side == 'yes' &&
                    organium_get_post_option('side_panel') == 'on'
                ) || (
                    $header_customize_side != 'yes' &&
                    organium_get_theme_mod('side_panel') == 'on'
                )
            ) {
                $side_panel_classes = 'organium_header_icon dropdown-trigger';
                $side_panel_classes .= organium_get_prefered_option('side_panel_trigger_type') == 'large' ? ' dropdown-trigger--large' : ' dropdown-trigger--small';
                ?>
                <div class="<?php echo esc_attr($side_panel_classes); ?>">
                    <div class="dropdown-trigger__item"></div>
                </div>
                <?php
            }
            ?>
        </div>

    </div>
</div>