<?php
# One Click Demo Content Import
if (!function_exists('organium_ocdi_import_files')) {
    function organium_ocdi_import_files() {
        return array(
            array(
                'import_file_name' => 'Organium',
                'categories' => array('With Images'),
                'import_file_url' => trailingslashit(get_template_directory_uri()) . 'core/import/import.xml',
                'import_widget_file_url' => trailingslashit(get_template_directory_uri()) . 'core/import/widgets.xml',
                'import_customizer_file_url' => trailingslashit(get_template_directory_uri()) . 'core/import/customizer.xml',
                'import_preview_image_url' => trailingslashit(get_template_directory_uri()) . 'screenshot.png',
                'preview_url' => 'https://organium.artureanec.com/',
            ),
        );
    }
}
add_filter( 'pt-ocdi/import_files', 'organium_ocdi_import_files' );

# Remove Branding Message
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

# Disable Regenerate for Thumbs
add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

if (!function_exists('organium_after_activation')) {
    function organium_after_activation() {
        function organium_after_switch_theme_message() {
            echo '<div class="updated notice is-dismissible"><p>' . esc_html__('After activating all the recommended plugins, you can import all demo content in one-touch. Appearance > Import Demo Data.', 'organium') . '</p></div>';
        }
        add_action('admin_notices', 'organium_after_switch_theme_message');
    }
}
add_action('after_switch_theme', 'organium_after_activation', 10 , 2);


if (!function_exists('organium_ocdi_after_import_setup')) {
    function organium_ocdi_after_import_setup() {
        # Assign menus to their locations.
        $main_menu = get_term_by('name', 'Main Menu', 'nav_menu');
        $footer_menu = get_term_by('name', 'Footer Menu', 'nav_menu');
        $footer_additional_menu = get_term_by('name', 'Footer Additional Menu', 'nav_menu');

        set_theme_mod('nav_menu_locations', array(
            'main' => $main_menu->term_id,
            'footer_menu' => $footer_menu->term_id,
            'footer_additional_menu' => $footer_additional_menu->term_id,
        ));

        # Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title('Organic Food Shop');
        # $blog_page_id  = get_page_by_title( 'Blog' );

        update_option('show_on_front', 'page');
        update_option('page_on_front', $front_page_id->ID);
        # update_option( 'page_for_posts', $blog_page_id->ID );

        if (class_exists('WooCommerce')) {
            if (!wc_update_product_lookup_tables_is_running()) {
                wc_update_product_lookup_tables();
            }
            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'ASC'
            );
            $loop = new WP_Query($args);
            while ($loop->have_posts()) {
                $loop->the_post();
                global $product;
                wc_delete_product_transients($product->get_id());
            }
        }
    }
}
add_action( 'pt-ocdi/after_import', 'organium_ocdi_after_import_setup' );