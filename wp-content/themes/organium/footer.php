        <?php
            $footer_classes = 'organium_footer';
            if ( !empty(organium_get_prefered_option('footer_style')) ) {
                $footer_classes .= ' organium_footer_' . esc_attr(organium_get_prefered_option('footer_style'));
            }
            if ( organium_get_prefered_option('footer_status') == 'show' ) {
                echo '<footer class="' . esc_attr($footer_classes) . '">';
                switch (organium_get_prefered_option('footer_style')) {
                    case 'style_2' :
                        get_template_part('templates/footer/footer_2');
                        break;
                    case 'style_3' :
                        get_template_part('templates/footer/footer_2');
                        break;
                    case 'style_4' :
                        get_template_part('templates/footer/footer_4');
                        break;
                    default :
                        get_template_part('templates/footer/footer_1');
                        break;
                }
                echo '</footer>';
            }
            ?>
        </div>
        <?php
            wp_footer();
        ?>
    </body>
</html>