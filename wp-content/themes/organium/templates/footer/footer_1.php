<?php
    defined( 'ABSPATH' ) or die();
?>

<div class="container">
    <?php
        $footer_customize_logo =  organium_get_post_option('footer_customize_logo');
        $organium_retina_class = 'organium_non_retina_logo';
        if (
            (
                $footer_customize_logo == 'yes' &&
                organium_get_post_option('footer_logo_retina') == 1
            ) || (
                $footer_customize_logo != 'yes' &&
                organium_get_theme_mod('footer_logo_retina') == true
            )
        ) {
            $organium_retina_class = 'organium_retina_logo';
        }

        // Footer Logo
        if (
            (
                $footer_customize_logo == 'yes' &&
                organium_get_post_option('footer_logo_status') == 'show'
            ) || (
                $footer_customize_logo != 'yes' &&
                organium_get_theme_mod('footer_logo_status') == 'show'
            )
        ) {
            echo '<div class="organium_logo_container">';
                echo '<div class="organium_footer-logo">';
                    echo '<a class="organium_footer-logo__link ' . esc_attr($organium_retina_class) . '" href="' . esc_url(home_url('/')) . '">';
                    if (
                        (
                            $footer_customize_logo == 'yes' &&
                            empty(organium_get_post_option('footer_logo_image'))
                        ) || (
                            $footer_customize_logo != 'yes' &&
                            empty(organium_get_theme_mod('footer_logo_image'))
                        )
                    ) {
                        echo '<span class="site_name">' . get_bloginfo( 'name', 'display' ) . '</span>';
                    }
                    echo '</a>';
                echo '</div>';
            echo '</div>';
        }

        // Subscribe Form
        $footer_customize_subscribe =  organium_get_post_option('footer_customize_subscribe');
        if (
        (
            $footer_customize_subscribe == 'yes' &&
            organium_get_post_option('footer_subscribe_status') == 'show'
        ) || (
            $footer_customize_subscribe != 'yes' &&
            organium_get_theme_mod('footer_subscribe_status') == 'show'
        )
        ) {
            echo '<div class="organium_footer_subscribe_container">';
                    echo '<div class="organium_footer_subscribe_columns">';
                    if ( !empty(organium_get_prefered_option('footer_subscribe_title')) || !empty( organium_get_prefered_option('footer_subscribe_text') ) ) {
                        echo '<div class="organium_footer_subscribe_content">';
                        if ( !empty(organium_get_prefered_option('footer_subscribe_title')) ) {
                            echo '<h6 class="organium_footer_widget_title">' . esc_html(organium_get_prefered_option('footer_subscribe_title')) . '</h6>';
                        }
                        if ( !empty(organium_get_prefered_option('footer_subscribe_text')) ) {
                            echo '<div class="organium_footer_subscribe_text">';
                                echo '<p>' . esc_html(organium_get_prefered_option('footer_subscribe_text')) . '</p>';
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                    if ( !empty(organium_get_prefered_option('footer_subscribe_shortcode')) ) {
                        echo '<div class="organium_footer_subscribe_form">';
                            echo do_shortcode(organium_get_prefered_option('footer_subscribe_shortcode'));
                        echo '</div>';
                    }
                    echo '</div>';
            echo '</div>';
        }

        // Footer Sidebar
        $footer_customize_sidebar =  organium_get_post_option('footer_customize_sidebar');
        if (
            (
                $footer_customize_sidebar == 'yes' &&
                organium_get_post_option('footer_sidebar_status') == 'show'
            ) || (
                $footer_customize_sidebar != 'yes' &&
                organium_get_theme_mod('footer_sidebar_status') == 'show'
            )
        ) {
            $footer_sidebar_select = '';
            if (
                $footer_customize_sidebar == 'yes' &&
                organium_get_post_option('footer_sidebar_status') == 'show'
            ){
                $footer_sidebar_select = organium_get_post_option('footer_sidebar_select');
            } elseif (
                $footer_customize_sidebar != 'yes' &&
                organium_get_theme_mod('footer_sidebar_status') == 'show'
            ) {
                $footer_sidebar_select = organium_get_theme_mod('footer_sidebar_select');
            }
            if ( is_active_sidebar($footer_sidebar_select) ) {
                echo '<div class="footer_widgets">';
                    dynamic_sidebar($footer_sidebar_select);
                echo '</div>';
            }
        }

        // Footer Menu
        $footer_customize_menu = organium_get_post_option('footer_customize_menu');
        if (
            (
                $footer_customize_menu == 'yes' &&
                organium_get_post_option('footer_menu_status') == 'show'
            ) || (
                $footer_customize_menu != 'yes' &&
                organium_get_theme_mod('footer_menu_status') == 'show' &&
                has_nav_menu('footer_menu')
            )
        ) {
            echo '<div class="organium_footer_menu_container">';
            if (
                (
                    $footer_customize_menu == 'yes' &&
                    organium_get_post_option('footer_menu_select') != 'default' &&
                    organium_get_post_option('footer_menu_select') != false
                )
            ) {
                wp_nav_menu(
                    array(
                        'menu' => organium_get_post_option('footer_menu_select'),
                        'menu_class' => 'organium_footer_menu',
                        'depth' => '1',
                        'container' => ''
                    )
                );
            } else {
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer_menu',
                        'menu_class' => 'organium_footer_menu',
                        'depth' => '1',
                        'container' => ''
                    )
                );
            }
            echo '</div>';
        }

        // Copyright
        $footer_customize_copyright = organium_get_post_option('footer_customize_copyright');
        if (
            (
                $footer_customize_copyright == 'yes' &&
                !empty(organium_get_post_option('footer_copyright_text'))
            ) || (
                $footer_customize_copyright != 'yes' &&
                !empty(organium_get_theme_mod('footer_copyright_text'))
            )
        ) {
            echo '<div class="organium_copyright_container">';
                if (
                    $footer_customize_copyright == 'yes' &&
                    !empty(organium_get_post_option('footer_copyright_text'))
                ) {
                    echo esc_html(organium_get_post_option('footer_copyright_text'));
                } elseif (
                    $footer_customize_copyright != 'yes' &&
                    !empty(organium_get_theme_mod('footer_copyright_text'))
                ) {
                    echo esc_html(organium_get_theme_mod('footer_copyright_text'));
                }
            echo '</div>';
        }

        // Social Buttons
        $footer_customize_socials = organium_get_post_option('footer_customize_socials');
        if (
            (
                $footer_customize_socials == 'yes' &&
                organium_get_post_option('footer_socials_status') == 'show'
            ) || (
                $footer_customize_socials != 'yes' &&
                organium_get_theme_mod('footer_socials_status') == 'show'
            )
        ) {
            $social_classes = 'organium_footer_socials';
            $social_classes .= organium_get_prefered_option('footer_socials_type') == 'bg' ? ' organium_footer_socials--bg' : '';
            echo organium_socials_output($social_classes);
        }

        // Payment Image
        $footer_customize_payment = organium_get_post_option('footer_customize_payment');
        if (
            (
                $footer_customize_payment == 'yes' &&
                organium_get_post_option('footer_payment_status') == 'show' &&
                !empty(organium_get_post_option('footer_payment_image'))
            ) || (
                $footer_customize_payment != 'yes' &&
                organium_get_theme_mod('footer_payment_status') &&
                !empty(organium_get_theme_mod('footer_payment_image'))
            )
        ) {
            echo '<div class="organium_payment_container">';
            if (
                $footer_customize_payment == 'yes' &&
                organium_get_post_option('footer_payment_status') == 'show' &&
                !empty(organium_get_post_option('footer_payment_image'))
            ) {
                $image = rwmb_meta( 'footer_payment_image', array( 'size' => 'full' ) );
                echo '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" class="organium_payment_image">';
            } elseif (
                $footer_customize_payment != 'yes' &&
                organium_get_theme_mod('footer_payment_status') &&
                !empty(organium_get_theme_mod('footer_payment_image'))
            ) {
                $image_id = attachment_url_to_postid(organium_get_theme_mod('footer_payment_image'));
                $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                echo '<img src="' . esc_url(organium_get_theme_mod('footer_payment_image')) . '" alt="' . esc_attr($image_alt) . '" class="organium_payment_image">';
            }
            echo '</div>';
        }

        // Additional Menu
        $footer_customize_additional_menu = organium_get_post_option('footer_customize_additional_menu');
        if (
            (
                $footer_customize_additional_menu == 'yes' &&
                organium_get_post_option('footer_additional_menu_status') == 'show'
            ) || (
                $footer_customize_additional_menu != 'yes' &&
                organium_get_theme_mod('footer_additional_menu_status') == 'show' &&
                has_nav_menu('footer_additional_menu')
            )
        ) {
            echo '<div class="organium_footer_additional_menu_container">';
            if (
                $footer_customize_additional_menu == 'yes' &&
                organium_get_post_option('footer_additional_menu_select') != 'default' &&
                organium_get_post_option('footer_additional_menu_select') != false
            ) {
                wp_nav_menu(
                    array(
                        'menu' => organium_get_post_option('footer_additional_menu_select'),
                        'menu_class' => 'organium_footer_additional_menu',
                        'depth' => '1',
                        'container' => ''
                    )
                );
            } else {
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer_additional_menu',
                        'menu_class' => 'organium_footer_additional_menu',
                        'depth' => '1',
                        'container' => ''
                    )
                );
            }
            echo '</div>';
        }
        ?>
</div>