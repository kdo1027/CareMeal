<?php
/*
 * Created by Artureanec
*/

namespace Organium\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\REPEATER;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Organium_Recipes_Listing_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_recipes_listing';
    }

    public function get_title() {
        return esc_html__('Recipe Listing', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_categories() {
        return ['organium_widgets'];
    }

    protected function _register_controls()
    {
        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Recipes Listing', 'organium_plugin')
            ]
        );

        $this->add_control(
            'view_style',
            [
                'label'   => esc_html__('View Style', 'organium_plugin'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'standard',
                'options' => [
                    'standard' => esc_html__('Standard', 'organium_plugin'),
                    'medium'  => esc_html__('Medium', 'organium_plugin')
                ]
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Items Per Page', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'default' => 3,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'filter_by',
            [
                'label' => esc_html__('Filter by:', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'organium_plugin'),
                    'cat' => esc_html__('Category', 'organium_plugin'),
                    'id' => esc_html__('ID', 'organium_plugin')
                ],
                'separator' => 'before'
            ]
        );

        $category_arr = [];
        $categories = get_terms(
            [
                'taxonomy' => 'recipes-category',
                'child_of' => 0,
                'parent' => '',
                'orderby' => 'name',
                'order' => 'ASC',
                'hierarchical' => 1,
                'exclude' => '',
                'include' => '',
                'number' => 0,
                'pad_counts' => false
            ]
        );
        if( !empty($categories) ) {
            foreach ($categories as $category) {
                $category_arr[$category->slug] = $category->name;
            }
        }
        $this->add_control(
            'category',
            [
                'label'   => esc_html__('Categories', 'organium_plugin'),
                'label_block' => true,
                'type'    => Controls_Manager::SELECT2,
                'multiple' => true,
                'description' => esc_html__('List of categories.', 'organium_plugin'),
                'options' => $category_arr,
                'condition' => [
                    'filter_by' => 'cat'
                ]
            ]
        );

        $this->add_control(
            'ids',
            [
                'label' => esc_html__('IDs', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter ID', 'organium_plugin' ),
                'description' => esc_html('Comma separated', 'organium_plugin'),
                'default' => '',
                'condition' => [
                    'filter_by' => 'id'
                ]
            ]
        );

        $this->add_control(
            'post_order_by',
            [
                'label' => esc_html__('Order By', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => esc_html__('Post Date', 'organium_plugin'),
                    'rand' => esc_html__('Random', 'organium_plugin'),
                    'ID' => esc_html__('Post ID', 'organium_plugin'),
                    'title' => esc_html__('Post Title', 'organium_plugin')
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'post_order',
            [
                'label' => esc_html__('Order', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'desc' => esc_html__('Descending', 'organium_plugin'),
                    'asc' => esc_html__('Ascending', 'organium_plugin')
                ]
            ]
        );

        $this->add_control(
            'pagination',
            [
                'label' => esc_html__('Pagination', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'organium_plugin'),
                'label_on' => esc_html__('Show', 'organium_plugin'),
                'default' => 'yes',
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();


        // -------------------------------------- //
        // ---------- Recipes Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Recipes Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_size',
                'default' => 'large'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_recipe_item .organium_content_wrapper .organium_post_title'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'label' => esc_html__('Excerpt Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_recipe_item .organium_content_wrapper .organium_post_excerpt',
                'separator' => 'before',
                'condition' => [
                    'view_style' => 'standard'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'label' => esc_html__('Meta Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_recipe_item .organium_content_wrapper .organium_post_meta .organium_post_meta_item',
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'more_typography',
                'label' => esc_html__('Button Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_recipe_item .organium_post_more .read_more_button',
                'condition' => [
                    'view_style' => 'medium'
                ],
                'separator' => 'before'
            ]
        );

        $this->start_controls_tabs('item_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_item_normal',
                [
                    'label' => esc_html__('Normal', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'title_color',
                    [
                        'label' => esc_html__('Title Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_recipe_item .organium_content_wrapper .organium_post_title, {{WRAPPER}} .organium_recipe_item .organium_content_wrapper .organium_post_title a' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'excerpt_color',
                    [
                        'label' => esc_html__('Excerpt Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_recipe_item .organium_content_wrapper .organium_post_excerpt' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'view_style' => 'standard'
                        ],
                        'separator' => 'before',
                    ]
                );

                $this->add_control(
                    'meta_color',
                    [
                        'label' => esc_html__('Meta Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_recipe_item .organium_content_wrapper .organium_post_meta .organium_post_meta_item, {{WRAPPER}} .organium_recipe_item .organium_content_wrapper .organium_post_meta .organium_post_meta_item a' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before',
                    ]
                );

                $this->add_control(
                    'more_color',
                    [
                        'label' => esc_html__('Button Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_recipe_item .organium_post_more .read_more_button' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before',
                        'condition' => [
                            'view_style' => 'medium'
                        ]
                    ]
                );

                $this->add_control(
                    'more_border_color',
                    [
                        'label' => esc_html__('Button Underline', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_recipe_item .organium_post_more .read_more_button' => 'border-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'view_style' => 'medium'
                        ]
                    ]
                );



                $this->add_control(
                    'pagination_color',
                    [
                        'label' => esc_html__('Pagination Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_pagination .page-numbers' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'pagination' => 'yes'
                        ],
                        'separator' => 'before'
                    ]
                );

                $this->add_control(
                    'pagination_bg_color',
                    [
                        'label' => esc_html__('Pagination Background', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_pagination .page-numbers' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'pagination' => 'yes'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_item_hover',
                [
                    'label' => esc_html__('Hover', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'title_color_hover',
                    [
                        'label' => esc_html__('Title Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_recipe_item .organium_content_wrapper .organium_post_title a:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'meta_color_hover',
                    [
                        'label' => esc_html__('Meta Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_recipe_item .organium_content_wrapper .organium_post_meta .organium_post_meta_item a:hover' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before',
                    ]
                );

                $this->add_control(
                    'more_color_hover',
                    [
                        'label' => esc_html__('Button Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_recipe_item .organium_post_more .read_more_button:hover' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before',
                        'condition' => [
                            'view_style' => 'medium'
                        ]
                    ]
                );

                $this->add_control(
                    'more_border_color_hover',
                    [
                        'label' => esc_html__('Button Underline', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_recipe_item .organium_post_more .read_more_button:hover' => 'border-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'view_style' => 'medium'
                        ]
                    ]
                );

                $this->add_control(
                    'pagination_hover',
                    [
                        'label' => esc_html__('Pagination Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_pagination a:hover, {{WRAPPER}} .organium_pagination .page-numbers.current' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'pagination' => 'yes'
                        ],
                        'separator' => 'before'
                    ]
                );

                $this->add_control(
                    'pagination_bg_hover',
                    [
                        'label' => esc_html__('Pagination Background', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_pagination a:hover, {{WRAPPER}} .organium_pagination .page-numbers.current' => 'background-color: {{VALUE}}; border-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'pagination' => 'yes'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings();
        $view_style = $settings['view_style'];

        $posts_per_page = $settings['posts_per_page'];
        $post_order_by = $settings['post_order_by'];
        $post_order = $settings['post_order'];
        $pagination = $settings['pagination'];

        $filter_by = $settings['filter_by'];
        $category_filter = !empty($settings['category']) && $filter_by == 'cat' ? implode(',', $settings['category']) : '';
        $id_filter = !empty($settings['ids']) && $filter_by == 'id' ? explode(',', str_replace(' ', '', $settings['ids'])) : '';

        $wrapper_class = 'organium_archive_listing_wrapper';
        $wrapper_class .= ( !empty($view_style) ? ' recipes_style_' . esc_attr($view_style) : '' );

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        echo '<div class="organium_recipes_listing_widget">';
            echo '<div class="organium_archive_listing">';
                echo '<div class="' . esc_attr($wrapper_class) . '">';
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    $args = array(
                        'post_type' => 'organium-recipes',
                        'posts_per_page' => $posts_per_page,
                        'orderby' => $post_order_by,
                        'order' => $post_order,
                        'paged' => esc_attr($paged),

                        'recipes-category' => $category_filter,
                        'post__in' => $id_filter
                    );

                    query_posts($args);

                    while (have_posts()) {
                        the_post();

                        global $post;
                        $image_alt_text = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);

                        $featured_image_src = Group_Control_Image_Size::get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'image_size', $settings );

                        $categories = get_the_terms( $post->ID , 'recipes-category' );
                        $categ_code = array();

                        if (is_array($categories)) {
                            foreach ($categories as $category) {
                                $categ_code[] = '
            <span class="organium_category" style="background-color: #'.esc_attr(get_term_meta($category->term_id, '_category_bg_color', true)).'; color: #'.esc_attr(get_term_meta($category->term_id, '_category_font_color', true)).';">' . esc_html($category->name) . '</span>
        ';
                            }
                        }

                        $organium_excerpt = substr(get_the_excerpt(), 0, 190);



                        echo '<div class="organium_recipe_item">';
                            echo '<div class="organium_recipe_item_wrapper">';

                                if ( !empty($featured_image_src) ) {
                                    echo '<div class="organium_featured_image_container">';
                                        echo '<a href="' . esc_url(get_permalink()) . '">';
                                            echo '<img src="' . esc_url($featured_image_src) . '" alt="' . esc_attr($image_alt_text) . '" />';
                                        echo '</a>';
                                        if ( !is_search() && $view_style == 'medium' ) {
                                            echo '<div class="organium_post_meta_container">';
                                                echo '<div class="organium_post_category_container">';
                                                    if ( is_array($categ_code) && count($categ_code) > 0 ) {
                                                        echo '<div class="organium_media_categories">';
                                                            echo join('', $categ_code);
                                                        echo '</div>';
                                                    }
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                    echo '</div>';
                                }

                                echo '<div class="organium_content_wrapper">';

                                    if (!is_search() && ( $view_style == 'standard' || empty($featured_image_src) )) {
                                        echo '<div class="organium_post_meta_container">';
                                            echo '<div class="organium_post_category_container">';
                                                if ( is_array($categ_code) && count($categ_code) > 0 ) {
                                                    echo '<div class="organium_media_categories">';
                                                        echo join('', $categ_code);
                                                    echo '</div>';
                                                }
                                            echo '</div>';
                                        echo '</div>';
                                    }

                                    if ( $view_style == 'medium' ) {
                                        echo '<div class="organium_post_details_container">';
                                        if (!empty(get_the_author()) || !empty(get_the_date())) {
                                            echo '<div class="organium_post_meta">';
                                                if (!empty(get_the_date())) {
                                                    echo '<div class="organium_post_meta_item meta_item meta_item_date">';
                                                        echo '<a href="' . get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')) . '">' . get_the_date() . "</a>";
                                                    echo '</div>';
                                                }
                                                if ( !empty( get_the_author() ) ) {
                                                    echo '<div class="organium_post_meta_item meta_item meta_item_author">';
                                                        echo esc_html__('By ', 'organium_plugin') . get_the_author_posts_link();
                                                    echo '</div>';
                                                }
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                    }

                                    echo '<h3 class="organium_post_title">';
                                        echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a>';
                                    echo '</h3>';

                                    if ( $view_style == 'standard' ) {
                                        echo '<p class="organium_post_excerpt">' . esc_html($organium_excerpt) . '</p>';
                                        echo '<div class="organium_post_details_container">';
                                            echo '<div class="flex-sm-row row organium_post_meta justify-content-between">';
                                                echo '<div class="col-sm-auto">';
                                                if (!empty(get_the_author()) || !empty(get_the_date())) {
                                                    echo '<div class="organium_post_meta">';
                                                        if (!empty(get_the_date())) {
                                                            echo '<div class="organium_post_meta_item meta_item meta_item_date">';
                                                                echo '<a href="' . get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')) . '">' . get_the_date() . "</a>";
                                                            echo '</div>';
                                                        }
                                                        if ( !empty( get_the_author() ) ) {
                                                            echo '<div class="organium_post_meta_item meta_item meta_item_author">';
                                                                echo esc_html__('By ', 'organium_plugin') . get_the_author_posts_link();
                                                            echo '</div>';
                                                        }
                                                    echo '</div>';
                                                }
                                                echo '</div>';

                                                echo '<div class="col-sm-auto flex-shrink-0">';
                                                    echo organium_socials_output('organium_post_meta_item meta_item meta_item_socials');
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</div>';
                                    }

                                    if ( $view_style == 'medium' ) {
                                        echo '<div class="organium_post_more">';
                                            echo '<a href="' . esc_url(get_permalink()) . '" class="read_more_button">' . esc_html__('Read More', 'organium_plugin') . '</a>';
                                        echo '</div>';
                                    }
                                echo '</div>';

                            echo '</div>';
                        echo '</div>';
                    }
                echo '</div>';
            echo '</div>';

            if ($pagination == 'yes') {
                echo '<div class="organium_pagination">';
                    echo get_the_posts_pagination(array(
                        'prev_text' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                        'next_text' => '<i class="fa fa-angle-right" aria-hidden="true"></i>'
                    ));
                echo '</div>';
            }
        echo '</div>';
        wp_reset_query();
    }

    protected function content_template() {}

    public function render_plain_content() {}
}