<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
</head>

<!--  -->
<body <?php body_class(); ?>>

    <div class="organium_404_error_container">
        <div class="organium_404_error_header">
            <?php
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
            ) {
                $organium_retina_class = 'organium_retina_logo';
            }

            ?>
            <div class="organium_logo_container">
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
        </div>
        <div class="organium_404_error_inner">
            <div class="organium_404_content">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/img/404.png'); ?>" alt="<?php esc_attr_e('Oops! Page not found!', 'organium'); ?>" class="organium_404_error_title">
                <?php
                    if ( !empty(organium_get_theme_mod('404_title')) ) {
                        echo '<h1 class="organium_404_error_subtitle">' . esc_html(organium_get_theme_mod('404_title')) . '</h1>';
                    }
                    if ( !empty(organium_get_theme_mod('404_text')) ) {
                        echo '<p class="organium_404_error_info_text">' . esc_html(organium_get_theme_mod('404_text')) . '</p>';
                    }
                    if ( !empty(organium_get_theme_mod('404_button_text')) ) {
                        echo '<div class="organium_404_error_button">';
                            echo '<a class="organium_404_home_button organium_button organium_button--primary" href="' . esc_url(home_url('/')) . '">' . esc_html(organium_get_theme_mod('404_button_text')) . '</a>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
        <div class="organium_404_error_footer">
            <?php
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
            ?>
        </div>
    </div>

<?php
    wp_footer();
?>

</body>
</html>