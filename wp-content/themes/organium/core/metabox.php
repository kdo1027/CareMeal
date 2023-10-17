<?php
/*
 * Created by Artureanec
*/

if (!class_exists('RWMB_Loader')) {
    return;
}

if (!function_exists('organium_custom_meta_boxes')) {
    add_filter('rwmb_meta_boxes', 'organium_custom_meta_boxes');

    function organium_custom_meta_boxes($meta_boxes) {
        # Image Post Format
        $meta_boxes[] = array(
            'title' => esc_html__('Image Post Format Settings', 'organium'),
            'post_types' => array('post', 'organium-portfolio', 'organium-recipes'),
            'fields' => array(
                array(
                    'id' => 'organium_pf_images',
                    'name' => esc_html__('Select Images', 'organium'),
                    'type' => 'image_advanced',
                ),
                array(
                    'id' => 'organium_pf_images_crop_status',
                    'name' => esc_html__('Crop Images', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'yes' => esc_html__('Yes', 'organium'),
                        'no' => esc_html__('No', 'organium'),
                    ),
                ),
                array(
                    'id' => 'organium_pf_images_width',
                    'name' => esc_html__('Image Width', 'organium'),
                    'type' => 'text',
                    'desc' => esc_html__('In pixels.', 'organium'),
                    'std' => '1200',
                    'attributes' => array(
                        'data-dependency-id' => 'organium_pf_images_crop_status',
                        'data-dependency-val' => 'yes'
                    ),
                ),
                array(
                    'id' => 'organium_pf_images_height',
                    'name' => esc_html__('Image Height', 'organium'),
                    'type' => 'text',
                    'desc' => esc_html__('In pixels.', 'organium'),
                    'std' => '738',
                    'attributes' => array(
                        'data-dependency-id' => 'organium_pf_images_crop_status',
                        'data-dependency-val' => 'yes'
                    ),
                ),
            ),
        );

        # Video Post Format
        $meta_boxes[] = array(
            'title' => esc_html__('Video Post Format Settings', 'organium'),
            'post_types' => array('post', 'organium-portfolio', 'organium-recipes'),
            'fields' => array(
                array(
                    'id' => 'organium_pf_video_url',
                    'name' => esc_html__('Video URL', 'organium'),
                    'type' => 'oembed',
                    'desc' => esc_html__('Copy link to the video from YouTube or other video-sharing website.', 'organium'),
                ),
                array(
                    'id' => 'organium_pf_video_height',
                    'name' => esc_html__('Video Height', 'organium'),
                    'type' => 'text',
                    'desc' => esc_html__('In pixels.', 'organium'),
                    'std' => '500',
                ),
            ),
        );

        # Content Output Settings
        $meta_boxes[] = array(
            'title' => esc_html__('Content Output Settings', 'organium'),
            'post_types' => array('post', 'organium-recipes'),
            'fields' => array(
                array(
                    'id' => 'media_output_status',
                    'name' => esc_html__('Media Output Container', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium')
                    )
                ),

                array(
                    'id' => 'post_meta_status',
                    'name' => esc_html__('Post Meta Container', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium')
                    )
                ),

                array(
                    'id' => 'after_content_panel_status',
                    'name' => esc_html__('Panel After Post Content', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium')
                    )
                ),

                array(
                    'id' => 'comments_status',
                    'name' => esc_html__('Post Comments', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium')
                    )
                ),

                array(
                    'id' => 'recent_posts_status',
                    'name' => esc_html__('Recent Posts', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium')
                    )
                ),

                array(
                    'id' => 'recent_posts_number',
                    'name' => esc_html__('Number of Posts', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        '2' => esc_html__('2 Items', 'organium'),
                        '3' => esc_html__('3 Items', 'organium')
                    )
                ),

                array(
                    'id' => 'recent_posts_order_by',
                    'name' => esc_html__('Order By', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'random' => esc_html__('Random', 'organium'),
                        'date' => esc_html__('Date', 'organium'),
                        'name' => esc_html__('Name', 'organium')
                    )
                ),

                array(
                    'id' => 'recent_posts_order',
                    'name' => esc_html__('Sort Order', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'desc' => esc_html__('Descending', 'organium'),
                        'asc' => esc_html__('Ascending', 'organium')
                    )
                ),

                array(
                    'id' => 'recent_posts_bg',
                    'name' => esc_html__('Recent Posts Container Background', 'organium'),
                    'placeholder' => '#ffffff',
                    'type' => 'color',
                    'class' => 'organium_color_picker',
                )
            )
        );

        # Recipes Custom Fields
        $meta_boxes[] = array(
            'title'         => esc_html__('Recipe Fields', 'organium'),
            'post_types'    => array('organium-recipes'),
            'context'       => 'side',
            'fields' => array(
                array(
                    'id'        => 'recipe_difficulty_level',
                    'name'      => esc_html__('Difficulty Level', 'organium'),
                    'type'      => 'select',
                    'options'   => array(
                        'easy'      => esc_html__('Easy', 'organium'),
                        'medium'    => esc_html__('Medium', 'organium'),
                        'hard'      => esc_html__('Hard', 'organium')
                    )
                ),
                array(
                    'type' => 'divider',
                ),
                array(
                    'id'            => 'recipe_total_time',
                    'name'          => esc_html__('Total Time', 'organium'),
                    'type'          => 'time',
                    'js_options'    => array(
                        'showButtonPanel'   => false,
                        'timeFormat'        => "H 'Hours' m 'Minutes'",
                        'pickerTimeFormat'  => "H'h' m'm'"
                    ),
                ),
                array(
                    'id'            => 'recipe_prep_time',
                    'name'          => esc_html__('Prep Time', 'organium'),
                    'type'          => 'time',
                    'js_options'    => array(
                        'showButtonPanel'   => false,
                        'timeFormat'        => "H 'Hours' m 'Minutes'",
                        'pickerTimeFormat'  => "H'h' m'm'"
                    ),
                ),
                array(
                    'id'            => 'recipe_cooking_time',
                    'name'          => esc_html__('Cooking Time', 'organium'),
                    'type'          => 'time',
                    'js_options'    => array(
                        'showButtonPanel'   => false,
                        'timeFormat'        => "H 'Hours' m 'Minutes'",
                        'pickerTimeFormat'  => "H'h' m'm'"
                    ),
                ),
                array(
                    'id'                => 'recipe_ingredients_image',
                    'name'              => esc_html__('Ingredients Image', 'organium'),
                    'type'              => 'image_advanced',
                    'max_file_uploads'  => '1',
                    'max_status'        => false
                ),
                array(
                    'type' => 'divider',
                ),
                array(
                    'id'            => 'recipe_ingredients_list',
                    'name'          => esc_html__('Ingredients List', 'organium'),
                    'type'          => 'text',
                    'clone'         => true
                )
            )
        );
        $meta_boxes[] = array(
            'title'         => esc_html__('Recipe Instructions', 'organium'),
            'post_types'    => array('organium-recipes'),
            'fields' => array(
                array(
                    'id'        => 'recipe_instructions',
                    'name'      => esc_html__('Instruction steps', 'organium'),
                    'type'      => 'wysiwyg',
                    'clone'     => true,
                    'options'   => array(
                        'textarea_rows' => 10,
                        'teeny'         => true
                    )
                )
            )
        );

        # Portfolio Custom Fields
        $meta_boxes[] = array(
            'title'         => esc_html__('Portfolio Fields', 'organium'),
            'post_types'    => array('organium-portfolio'),
            'context'       => 'side',
            'fields'        => array(
                array(
                    'id'    => 'portfolio_author',
                    'name'  => esc_html__('Portfolio Author', 'organium'),
                    'type'  => 'text'
                ),
                array(
                    'id'    => 'portfolio_client',
                    'name'  => esc_html__('Client', 'organium'),
                    'type'  => 'text'
                ),
                array(
                    'id'    => 'portfolio_gallery',
                    'name'  => esc_html__('Portfolio Gallery', 'organium'),
                    'type'  => 'image_advanced'
                )
            )
        );

        # Content Settings for Portfolio and Recipes
        $meta_boxes[] = array(
            'title' => esc_html__('Content Settings', 'organium'),
            'post_types' => array('organium-portfolio', 'organium-recipes'),
            'fields' => array(
                array(
                    'id' => 'media_output_status',
                    'name' => esc_html__('Media Output Container', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium')
                    )
                ),

                array(
                    'id' => 'top_padding',
                    'name' => esc_html__('Content Area Top Padding', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'on' => esc_html__('On', 'organium'),
                        'off' => esc_html__('Off', 'organium')
                    )
                ),

                array(
                    'id' => 'bottom_padding',
                    'name' => esc_html__('Content Area Bottom Padding', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'on' => esc_html__('On', 'organium'),
                        'off' => esc_html__('Off', 'organium')
                    )
                )
            )
        );

        # Post and Page Settings
        $menus = wp_get_nav_menus();
        $menus_list = array();
        foreach ( $menus as $menu ) {
            $menus_list[$menu->slug] = $menu->name;
        }
        $menu_list_default = array(
            'default' => esc_html__('Default', 'organium')
        );
        $menus_list = array_merge($menu_list_default, $menus_list);

        $sidebar_list = array();
        foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
            $sidebar_list[$sidebar['id']] = $sidebar['name'];
        }

        $meta_boxes[] = array(
            'title' => esc_html__('Page Settings', 'organium'),
            'post_types' => array('post', 'page', 'organium-events', 'organium-stories', 'organium-causes'),
            'fields' => array(
                # Header Options
                array(
                    'type' => 'heading',
                    'name' => esc_html__('Header Options', 'organium'),
                    'desc' => '',
                ),

                array(
                    'id' => 'header_style',
                    'name' => esc_html__('Header Style', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'type_1' => esc_html__('Style Type 1', 'organium'),
                        'type_2' => esc_html__('Style Type 2', 'organium'),
                        'type_3' => esc_html__('Style Type 3', 'organium')
                    )
                ),

                array(
                    'id' => 'header_position',
                    'name' => esc_html__('Header Position', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'above' => esc_html__('Above', 'organium'),
                        'over' => esc_html__('Over', 'organium')
                    )
                ),

                array(
                    'id' => 'sticky_header',
                    'name' => esc_html__('Sticky Header', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'on' => esc_html__('On', 'organium'),
                        'off' => esc_html__('Off', 'organium')
                    )
                ),

                array(
                    'id' => 'header_tagline',
                    'name' => esc_html__('Header Tagline', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'on' => esc_html__('On', 'organium'),
                        'off' => esc_html__('Off', 'organium')
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'header_style',
                        'data-dependency-val' => 'type_4'
                    )
                ),










                array(
                    'id' => 'header_customize_colors',
                    'name' => esc_html__('Customize Header Colors', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),

                array(
                    'id' => 'header_bg',
                    'name' => esc_html__('Header Background', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_bd',
                    'name' => esc_html__('Header Border', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_logo_color',
                    'name' => esc_html__('Header Logo Text', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_socials_icon_color',
                    'name' => esc_html__('Social Buttons Icon Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_socials_icon_hover',
                    'name' => esc_html__('Social Buttons Icon Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_socials_bg_color',
                    'name' => esc_html__('Social Buttons Background Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_socials_bg_hover',
                    'name' => esc_html__('Social Buttons Background Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_button_color',
                    'name' => esc_html__('Header Button Text Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_button_hover',
                    'name' => esc_html__('Header Button Text Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_button_bg_color',
                    'name' => esc_html__('Header Button Background Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_button_bg_hover',
                    'name' => esc_html__('Header Button Background Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_menu_color',
                    'name' => esc_html__('Header Menu Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_menu_hover',
                    'name' => esc_html__('Header Menu Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_sub_menu_color',
                    'name' => esc_html__('Header Sub Menu Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_sub_menu_hover',
                    'name' => esc_html__('Header Sub Menu Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_sub_menu_bg',
                    'name' => esc_html__('Header Sub Menu Background', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'side_panel_trigger_color',
                    'name' => esc_html__('Side Panel Trigger Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'side_panel_trigger_hover',
                    'name' => esc_html__('Side Panel Trigger Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'side_panel_trigger_bg_color',
                    'name' => esc_html__('Side Panel Trigger Background Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'side_panel_trigger_bg_hover',
                    'name' => esc_html__('Side Panel Trigger Background Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_search_trigger_color',
                    'name' => esc_html__('Header Search Trigger Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_search_trigger_hover',
                    'name' => esc_html__('Header Search Trigger Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_minicart_icon_color',
                    'name' => esc_html__('Header Minicart Icon Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_minicart_icon_hover',
                    'name' => esc_html__('Header Minicart Icon Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_minicart_bg_color',
                    'name' => esc_html__('Header Minicart Background Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_minicart_bg_hover',
                    'name' => esc_html__('Header Minicart Background Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_minicart_counter_color',
                    'name' => esc_html__('Header Minicart Counter Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_minicart_counter_bg',
                    'name' => esc_html__('Header Minicart Counter Background', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_wishlist_color',
                    'name' => esc_html__('Header Wishlist Link Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'header_wishlist_hover',
                    'name' => esc_html__('Header Wishlist Link Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),




                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'header_customize_logo',
                    'name' => esc_html__('Customize Logo', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'logo_image',
                    'name' => esc_html__('Logo Image', 'organium'),
                    'type' => 'single_image',
                    'size' => 'full',
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_logo',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'logo_retina',
                    'name' => esc_html__('Logo Retina', 'organium'),
                    'type' => 'checkbox',
                    'std' => 1,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_logo',
                        'data-dependency-val' => 'yes'
                    )
                ),







                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'header_customize_socials',
                    'name' => esc_html__('Customize Social Buttons', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'header_socials',
                    'name' => esc_html__('Header Social Buttons', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'on' => esc_html__('On', 'organium'),
                        'off' => esc_html__('Off', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_socials',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'header_socials_type',
                    'name' => esc_html__('Header Socials Type', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'bg' => esc_html__('Icon With Background', 'organium'),
                        'nobg' => esc_html__('Icon Without Background', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_socials',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'header_socials_font_size',
                    'name' => esc_html__('Header Socials Size', 'organium'),
                    'type' => 'text',
                    'placeholder' => '13px',
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_socials',
                        'data-dependency-val' => 'yes'
                    )
                ),








                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'header_customize_button',
                    'name' => esc_html__('Customize Button', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'header_button',
                    'name' => esc_html__('Header Button', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'on' => esc_html__('On', 'organium'),
                        'off' => esc_html__('Off', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_button',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'header_button_text',
                    'name' => esc_html__('Header Button Text', 'organium'),
                    'type' => 'text',
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_button',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'header_button_url',
                    'name' => esc_html__('Header Button Link', 'organium'),
                    'type' => 'text',
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_button',
                        'data-dependency-val' => 'yes'
                    )
                ),







                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'header_customize_menu',
                    'name' => esc_html__('Customize Menu', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'main_menu',
                    'name' => esc_html__('Select Menu', 'organium'),
                    'type' => 'select',
                    'options' => $menus_list,
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_menu',
                        'data-dependency-val' => 'yes'
                    )
                ),








                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'header_customize_side',
                    'name' => esc_html__('Customize Side Panel', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'side_panel',
                    'name' => esc_html__('Side Panel', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'on' => esc_html__('On', 'organium'),
                        'off' => esc_html__('Off', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_side',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'side_panel_trigger_type',
                    'name' => esc_html__('Side Panel Trigger Type', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'large' => esc_html__('Large', 'organium'),
                        'small' => esc_html__('Small', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_side',
                        'data-dependency-val' => 'yes'
                    )
                ),








                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'header_customize_search',
                    'name' => esc_html__('Customize Search', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'header_search',
                    'name' => esc_html__('Header Search', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'on' => esc_html__('On', 'organium'),
                        'off' => esc_html__('Off', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_search',
                        'data-dependency-val' => 'yes'
                    )
                ),








                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'header_customize_minicart',
                    'name' => esc_html__('Customize Mini Cart', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'header_minicart',
                    'name' => esc_html__('Header Wishlist', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'on' => esc_html__('On', 'organium'),
                        'off' => esc_html__('Off', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_minicart',
                        'data-dependency-val' => 'yes'
                    )
                ),








                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'header_customize_wishlist',
                    'name' => esc_html__('Customize Wishlist', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'header_wishlist',
                    'name' => esc_html__('Header Wishlist', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'on' => esc_html__('On', 'organium'),
                        'off' => esc_html__('Off', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'header_customize_wishlist',
                        'data-dependency-val' => 'yes'
                    )
                ),















                # Title Options
                array(
                    'type' => 'heading',
                    'name' => esc_html__('Title Options', 'organium'),
                    'desc' => '',
                ),

                array(
                    'id' => 'page_title_status',
                    'name' => esc_html__('Page Title', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium')
                    )
                ),

                array(
                    'id' => 'page_title_image_type',
                    'name' => esc_html__('Page Title Image Type', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'alt' => esc_html__('Alternative', 'organium')
                    )
                ),

                array(
                    'id' => 'page_title_alt_image',
                    'name' => esc_html__('Alternative Page Title Image', 'organium'),
                    'type' => 'image_advanced',
                    'max_file_uploads' => '1',
                    'max_status' => false,
                    'attributes' => array(
                        'data-dependency-id' => 'page_title_image_type',
                        'data-dependency-val' => 'alt'
                    )
                ),

                array(
                    'id' => 'page_title_settings',
                    'name' => esc_html__('Page Title Settings', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'custom' => esc_html__('Custom', 'organium'),
                    )
                ),

                array(
                    'id' => 'title_height',
                    'name' => esc_html__('Page Title Height', 'organium'),
                    'type' => 'number',
                    'std' => '449',
                    'attributes' => array(
                        'data-dependency-id' => 'page_title_settings',
                        'data-dependency-val' => 'custom'
                    )
                ),

                array(
                    'id' => 'title_type',
                    'name' => esc_html__('Page Title Type', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'alt' => esc_html__('Alternative', 'organium')
                    )
                ),

                array(
                    'id' => 'alt_title',
                    'name' => esc_html__('Alternative Page Title', 'organium'),
                    'desc' => esc_html__('You can use HTML tags in alternative title', 'organium'),
                    'type' => 'textarea',
                    'cols' => '20',
                    'rows' => '1',
                    'attributes' => array(
                        'data-dependency-id' => 'title_type',
                        'data-dependency-val' => 'alt'
                    )
                ),

                array(
                    'id' => 'title_additional_text',
                    'name' => esc_html__('Header Title Additional Text', 'organium'),
                    'type' => 'text'
                ),

                array(
                    'id' => 'title_customize_colors',
                    'name' => esc_html__('Customize Title Colors', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),

                array(
                    'id' => 'title_bg_color',
                    'name' => esc_html__('Page Title Background Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'title_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'page_title_color',
                    'name' => esc_html__('Page Title Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'title_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'title_additional_text_color',
                    'name' => esc_html__('Page Title Additional Text Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'title_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'breadcrumbs_text_color',
                    'name' => esc_html__('Breadcrumbs Text Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'title_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'breadcrumbs_link_color',
                    'name' => esc_html__('Breadcrumbs Link Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'title_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'breadcrumbs_link_hover',
                    'name' => esc_html__('Breadcrumbs Link Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'title_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                # Content Options
                array(
                    'type' => 'heading',
                    'name' => esc_html__('Content Options', 'organium'),
                    'desc' => '',
                ),
                array(
                    'id' => 'content_top_margin',
                    'name' => esc_html__('Content Top Margin', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'yes' => esc_html__('On', 'organium'),
                        'no' => esc_html__('Off', 'organium')
                    )
                ),
                array(
                    'id' => 'content_bottom_margin',
                    'name' => esc_html__('Content Bottom Margin', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'yes' => esc_html__('On', 'organium'),
                        'no' => esc_html__('Off', 'organium')
                    )
                ),


                # Sidebar Options
                array(
                    'type' => 'heading',
                    'name' => esc_html__('Sidebar Options', 'organium'),
                    'desc' => '',
                ),

                array(
                    'id' => 'sidebar_name',
                    'name' => esc_html__('Select Sidebar', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default'               => esc_html__('Default', 'organium'),
                        'sidebar'               => esc_html__('Page Sidebar', 'organium'),
                        'sidebar-blog'          => esc_html__('Blog Sidebar', 'organium'),
                        'sidebar-portfolio'     => esc_html__('Portfolio Sidebar', 'organium'),
                        'sidebar-recipes'       => esc_html__('Recipes Sidebar', 'organium'),
                        'sidebar-side'          => esc_html__('Side Panel Sidebar', 'organium'),
                        'sidebar-footer'        => esc_html__('Footer Sidebar', 'organium'),
                        'sidebar-woocommerce'   => esc_html__('WooCommerce Sidebar', 'organium'),
                    )
                ),

                array(
                    'id' => 'sidebar_position',
                    'name' => esc_html__('Sidebar Position', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'left' => esc_html__('Left', 'organium'),
                        'right' => esc_html__('Right', 'organium'),
                        'none' => esc_html__('None', 'organium')
                    )
                ),

                #Footer Options
                array(
                    'type' => 'heading',
                    'name' => esc_html__('Footer Options', 'organium'),
                    'desc' => ''
                ),

                array(
                    'id' => 'footer_status',
                    'name' => esc_html__('Footer Status', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium')
                    )
                ),

                array(
                    'id' => 'footer_style',
                    'name' => esc_html__('Footer Style', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_html__('Default', 'organium'),
                        'style_1' => esc_html__('Style 1', 'organium'),
                        'style_2' => esc_html__('Style 2', 'organium'),
                        'style_3' => esc_html__('Style 3', 'organium'),
                        'style_4' => esc_html__('Style 4', 'organium'),
                    )
                ),

                array(
                    'id' => 'footer_customize_bg',
                    'name' => esc_html__('Customize Footer Background', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'footer_bg_image',
                    'name' => esc_html__('Background Image', 'organium'),
                    'type' => 'single_image',
                    'size' => 'full',
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_bg',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'footer_bg_position',
                    'name' => esc_html__('Background Position', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'center center' => esc_html__('Center Center', 'organium'),
                        'center left' => esc_html__('Center Left', 'organium'),
                        'center right' => esc_html__('Center Right', 'organium'),
                        'top center' => esc_html__('Top Center', 'organium'),
                        'top left' => esc_html__('Top Left', 'organium'),
                        'top right' => esc_html__('Top Right', 'organium'),
                        'bottom center' => esc_html__('Bottom Center', 'organium'),
                        'bottom left' => esc_html__('Bottom Left', 'organium'),
                        'bottom right' => esc_html__('Bottom Right', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_bg',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'footer_bg_repeat',
                    'name' => esc_html__('Background Repeat', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no-repeat' => esc_html__('No-repeat', 'organium'),
                        'repeat' => esc_html__('Repeat', 'organium'),
                        'repeat-x' => esc_html__('Repeat-x', 'organium'),
                        'repeat-y' => esc_html__('Repeat-y', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_bg',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'footer_bg_size',
                    'name' => esc_html__('Background Size', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'initial' => esc_html__('Default', 'organium'),
                        'auto' => esc_html__('Auto', 'organium'),
                        'cover' => esc_html__('Cover', 'organium'),
                        'contain' => esc_html__('Contain', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_bg',
                        'data-dependency-val' => 'yes'
                    )
                ),


                array(
                    'id' => 'footer_customize_colors',
                    'name' => esc_html__('Customize Footer Colors', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),

                array(
                    'id' => 'footer_bg',
                    'name' => esc_html__('Footer Background Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_text_color',
                    'name' => esc_html__('Footer Text Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_accent_color',
                    'name' => esc_html__('Footer Text Accent Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_hover_color',
                    'name' => esc_html__('Footer Text Hover Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_logo_color',
                    'name' => esc_html__('Footer Logo Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_sidebar_text_color',
                    'name' => esc_html__('Footer Widget Text Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_sidebar_accent_color',
                    'name' => esc_html__('Footer Widget Accent Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_sidebar_hover_color',
                    'name' => esc_html__('Footer Widget Hover Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_menu_color',
                    'name' => esc_html__('Footer Menu Link Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_menu_hover',
                    'name' => esc_html__('Footer Menu Hover Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_menu_border_color',
                    'name' => esc_html__('Footer Menu Border Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_socials_color',
                    'name' => esc_html__('Footer Social Icons Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_socials_hover',
                    'name' => esc_html__('Footer Social Icons Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_socials_bg',
                    'name' => esc_html__('Footer Social Icons Background Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_socials_bg_hover',
                    'name' => esc_html__('Footer Social Icons Background Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_button_color',
                    'name' => esc_html__('Footer Button Text Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_button_bg_color',
                    'name' => esc_html__('Footer Button Background Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_button_shadow',
                    'name' => esc_html__('Footer Button Shadow Color', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_button_hover',
                    'name' => esc_html__('Footer Button Text Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_button_bg_hover',
                    'name' => esc_html__('Footer Button Background Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'id' => 'footer_button_hover_shadow',
                    'name' => esc_html__('Footer Button Shadow Hover', 'organium'),
                    'type' => 'color',
                    'alpha_channel' => true,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_colors',
                        'data-dependency-val' => 'yes'
                    )
                ),






                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'footer_customize_logo',
                    'name' => esc_html__('Customize Logo', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'footer_logo_status',
                    'name' => esc_html__('Footer Logo Status', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_logo',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'footer_logo_image',
                    'name' => esc_html__('Logo Image', 'organium'),
                    'type' => 'single_image',
                    'size' => 'full',
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_logo',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'footer_logo_retina',
                    'name' => esc_html__('Logo Retina', 'organium'),
                    'type' => 'checkbox',
                    'std' => 1,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_logo',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'footer_customize_sidebar',
                    'name' => esc_html__('Customize Sidebar', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'footer_sidebar_status',
                    'name' => esc_html__('Footer Sidebar Status', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_sidebar',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'footer_sidebar_select',
                    'name' => esc_html__('Select Sidebar', 'organium'),
                    'type' => 'select',
                    'options' => $sidebar_list,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_sidebar',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'footer_customize_copyright',
                    'name' => esc_html__('Customize Copyright', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'footer_copyright_text',
                    'name' => esc_html__('Copyright Text', 'organium'),
                    'type' => 'text',
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_copyright',
                        'data-dependency-val' => 'yes'
                    ),
                ),

                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'footer_customize_menu',
                    'name' => esc_html__('Customize Footer Menu', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'footer_menu_status',
                    'name' => esc_html__('Footer Menu Status', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_menu',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'footer_menu_select',
                    'name' => esc_html__('Select Menu', 'organium'),
                    'type' => 'select',
                    'options' => $menus_list,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_menu',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'footer_customize_additional_menu',
                    'name' => esc_html__('Customize Additional Menu', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'footer_additional_menu_status',
                    'name' => esc_html__('Footer Additional Menu Status', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_additional_menu',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'footer_additional_menu_select',
                    'name' => esc_html__('Select Additional Menu', 'organium'),
                    'type' => 'select',
                    'options' => $menus_list,
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_additional_menu',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'footer_customize_socials',
                    'name' => esc_html__('Customize Social Buttons', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'footer_socials_status',
                    'name' => esc_html__('Social Buttons Status', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_socials',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'footer_socials_type',
                    'name' => esc_html__('Footer Socials Type', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'bg' => esc_html__('Icon With Background', 'organium'),
                        'nobg' => esc_html__('Icon Without Background', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_socials',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'footer_socials_font_size',
                    'name' => esc_html__('Footer Socials Size', 'organium'),
                    'type' => 'text',
                    'placeholder' => '13px',
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_socials',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'footer_customize_payment',
                    'name' => esc_html__('Customize Payment Image', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'footer_payment_status',
                    'name' => esc_html__('Footer Payment Image Status', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_payment',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'footer_payment_image',
                    'name' => esc_html__('Payment Image', 'organium'),
                    'type' => 'single_image',
                    'size' => 'full',
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_payment',
                        'data-dependency-val' => 'yes'
                    )
                ),

                array(
                    'type' => 'divider',
                ),
                array(
                    'id' => 'footer_customize_subscribe',
                    'name' => esc_html__('Customize Subscribe Form', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'no' => esc_html__('No', 'organium'),
                        'yes' => esc_html__('Yes', 'organium'),
                    )
                ),
                array(
                    'id' => 'footer_subscribe_status',
                    'name' => esc_html__('Footer Subscribe Form Status', 'organium'),
                    'type' => 'select',
                    'options' => array(
                        'show' => esc_html__('Show', 'organium'),
                        'hide' => esc_html__('Hide', 'organium'),
                    ),
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_subscribe',
                        'data-dependency-val' => 'yes'
                    )
                ),
                array(
                    'id' => 'footer_subscribe_title',
                    'name' => esc_html__('Subscribe Form Title', 'organium'),
                    'type' => 'text',
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_subscribe',
                        'data-dependency-val' => 'yes'
                    ),
                ),
                array(
                    'id' => 'footer_subscribe_text',
                    'name' => esc_html__('Subscribe Form Text', 'organium'),
                    'type' => 'text',
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_subscribe',
                        'data-dependency-val' => 'yes'
                    ),
                ),
                array(
                    'id' => 'footer_subscribe_shortcode',
                    'name' => esc_html__('Subscribe Form Shortcode', 'organium'),
                    'type' => 'text',
                    'attributes' => array(
                        'data-dependency-id' => 'footer_customize_subscribe',
                        'data-dependency-val' => 'yes'
                    ),
                ),
            ),
        );

        return $meta_boxes;
    }
}
