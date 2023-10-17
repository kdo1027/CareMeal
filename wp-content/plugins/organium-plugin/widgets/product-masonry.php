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
use Elementor\REPEATER;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Organium_Product_Masonry_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_product_masonry';
    }

    public function get_title() {
        return esc_html__('Products Masonry Gallery', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-gallery-justified';
    }

    public function get_categories() {
        return ['organium_widgets'];
    }

    protected function _register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Products Masonry', 'organium_plugin')
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Items Per Page', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 1
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
                    'tag' => esc_html__('Tag', 'organium_plugin'),
                    'id' => esc_html__('ID', 'organium_plugin')
                ],
                'separator' => 'before'
            ]
        );

        $category_arr = [];
        $categories = get_categories(
            [
                'taxonomy' => 'product_cat',
                'type' => 'post',
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
            foreach ($categories as $key => $category) {
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

        $tags_arr = [];
        $tags = get_tags(
            [
                'taxonomy' => 'product_tag',
                'type' => 'post',
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
        if( !empty($tags) ) {
            foreach ($tags as $key => $tag) {
                $tags_arr[$tag->slug] = $tag->name;
            }
        }
        $this->add_control(
            'tag',
            [
                'label'   => esc_html__('Tags', 'organium_plugin'),
                'label_block' => true,
                'type'    => Controls_Manager::SELECT2,
                'multiple' => true,
                'description' => esc_html__('List of tags.', 'organium_plugin'),
                'options' => $tags_arr,
                'condition' => [
                    'filter_by' => 'tag'
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
                    'date' => esc_html__('Date', 'organium_plugin'),
                    'rand' => esc_html__('Random', 'organium_plugin'),
                    'ID' => esc_html__('Product ID', 'organium_plugin'),
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


        // --------------------------------------- //
        // ---------- Wishlist Settings ---------- //
        // --------------------------------------- //
        $this->start_controls_section(
            'section_wishlist_settings',
            [
                'label' => esc_html__('Product Wishlist Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('wishlist_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_wishlist_normal',
                [
                    'label' => esc_html__('Normal', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'wishlist_color',
                    [
                        'label' => esc_html__('Wishlist Icon Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .product_masonry_item .yith-wcwl-add-to-wishlist .add_to_wishlist' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ------------------------ //
            // ------ Active Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_content_hover',
                [
                    'label' => esc_html__('Active', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'wishlist_active_color',
                    [
                        'label' => esc_html__('Wishlist Active Icon Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .product_masonry_item .yith-wcwl-add-to-wishlist .delete_item' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();



        // -------------------------------------- //
        // ---------- Content Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'section_content_settings',
            [
                'label' => esc_html__('Product Content Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'content_align',
            [
                'label' => esc_html__('Alignment', 'organium_plugin'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'organium_plugin'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'organium_plugin'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'organium_plugin'),
                        'icon' => 'fa fa-align-right',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .product_masonry_item .product_masonry_content' => 'text-align: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label' => esc_html__('Overlay Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product_masonry_item .product_masonry_content_wrapper' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .product_masonry_item .product_masonry_title'
            ]
        );

        $this->start_controls_tabs('title_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_title_normal',
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
                            '{{WRAPPER}} .product_masonry_item .product_masonry_title, {{WRAPPER}} .product_masonry_item .product_masonry_title a' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_title_hover',
                [
                    'label' => esc_html__('Hover', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'title_hover',
                    [
                        'label' => esc_html__('Title Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .product_masonry_item .product_masonry_title a:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'label' => esc_html__('Price Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .product_masonry_item .price',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'current_price_color',
            [
                'label' => esc_html__('Current Price Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product_masonry_item .price' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'old_price_color',
            [
                'label' => esc_html__('Old Price Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product_masonry_item .price del' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'rating_default_color',
            [
                'label' => esc_html__('Rating Inactive Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product_masonry_item .star-rating:before' => 'color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'rating_active_color',
            [
                'label' => esc_html__('Rating Active Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product_masonry_item .star-rating span' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'label' => esc_html__('Excerpt Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .product_masonry_item .product_masonry_excerpt',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__('Excerpt Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product_masonry_item .product_masonry_excerpt' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__('Excerpt Length, in simbols', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'default' => 105
            ]
        );

        $this->end_controls_section();



        // ------------------------------------- //
        // ---------- Button Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'section_button_settings',
            [
                'label' => esc_html__('Product Button Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Button Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .product_masonry_item .product_masonry_buttons a.button, {{WRAPPER}} .product_masonry_item .product_masonry_buttons a.added_to_cart'
            ]
        );

        $this->start_controls_tabs('button_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_button_normal',
                [
                    'label' => esc_html__('Normal', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'button_color',
                    [
                        'label' => esc_html__('Button Text Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .product_masonry_item .product_masonry_buttons a.button, {{WRAPPER}} .product_masonry_item .product_masonry_buttons a.added_to_cart' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_bg_color',
                    [
                        'label' => esc_html__('Button Background Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .product_masonry_item .product_masonry_buttons a.button, {{WRAPPER}} .product_masonry_item .product_masonry_buttons a.added_to_cart' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow',
                        'selector' => '{{WRAPPER}} .product_masonry_item .product_masonry_buttons a.button, {{WRAPPER}} .product_masonry_item .product_masonry_buttons a.added_to_cart',
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_button_hover',
                [
                    'label' => esc_html__('Hover', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'button_hover_color',
                    [
                        'label' => esc_html__('Button Text Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .product_masonry_item .product_masonry_buttons a.button:hover, {{WRAPPER}} .product_masonry_item .product_masonry_buttons a.added_to_cart:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_hover_bg_color',
                    [
                        'label' => esc_html__('Button Background Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .product_masonry_item .product_masonry_buttons a.button:hover, {{WRAPPER}} .product_masonry_item .product_masonry_buttons a.added_to_cart:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_hover_box_shadow',
                        'selector' => '{{WRAPPER}} .product_masonry_item .product_masonry_buttons a.button:hover, {{WRAPPER}} .product_masonry_item .product_masonry_buttons a.added_to_cart:hover',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $posts_per_page = $settings['posts_per_page'];
        $post_order_by = $settings['post_order_by'];
        $post_order = $settings['post_order'];
        $pagination = $settings['pagination'];
        $filter_by = $settings['filter_by'];
        $category_filter = !empty($settings['category']) && $filter_by == 'cat' ? implode(',', $settings['category']) : '';
        $tag_filter = !empty($settings['tag']) && $filter_by == 'tag' ? implode(',', $settings['tag']) : '';
        $id_filter = !empty($settings['ids']) && $filter_by == 'id' ? explode(',', str_replace(' ', '', $settings['ids'])) : '';

        $excerpt_length = $settings['excerpt_length'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="organium_product_masonry_widget">
            <div class="product_masonry_wrapper">
                <?php
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => $posts_per_page,
                        'orderby' => $post_order_by,
                        'order' => $post_order,
                        'paged' => esc_attr($paged),
                        'product_cat' => $category_filter,
                        'product_tag' => $tag_filter,
                        'post__in' => $id_filter
                    );

                    $i = 0;

                    query_posts($args);

                    while (have_posts()) {
                        the_post();
                        global $product;
                        $i++;
                        $featured_image_url = organium_get_featured_image_url();
                        $image_alt_text = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
                        if (function_exists('aq_resize')) {
                            if ( $i == 1 || $i == 6 ) {
                                $featured_image_src = aq_resize(esc_url($featured_image_url), 960, 480, true, true, true);
                            } else {
                                $featured_image_src = aq_resize(esc_url($featured_image_url), 480, 480, true, true, true);
                            };
                        } else {
                            $featured_image_src = $featured_image_url;
                        }
                        if ( $i == 6 ) $i = 0;
                        $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
                        $organium_excerpt = substr(get_the_excerpt(), 0, $excerpt_length);
                        echo '<div class="product_masonry_item">';
                            echo '<div class="product_masonry_item_inner">';
                                echo '<div class="product_masonry_image_wrapper">';
                                    if ( !empty($featured_image_src) ) {
                                        echo '<img src="' . esc_url($featured_image_src) . '" alt="' . esc_attr($image_alt_text) . '" />';
                                    }
                                echo '</div>';

                                echo '<div class="product_masonry_content_wrapper">';
                                    if ( function_exists( 'yith_plugin_registration_hook' ) ) {
                                        echo do_shortcode("[yith_wcwl_add_to_wishlist]");
                                    }
                                    echo '<div class="product_masonry_content">';
                                        echo '<h3 class="product_masonry_title">';
                                            echo '<a href="' . esc_url($link) . '">' . get_the_title() . '</a>';
                                        echo '</h3>';
                                        if ( $price_html = $product->get_price_html() ) {
                                            echo '<div class="price">' . $price_html . '</div>';
                                        }
                                        if ( wc_review_ratings_enabled() ) {
                                            echo wc_get_rating_html( $product->get_average_rating() );
                                        }
                                        echo '<div class="product_masonry_excerpt">';
                                            echo '<p>' . esc_html($organium_excerpt) . '</p>';
                                        echo '</div>';
                                        echo '<div class="product_masonry_buttons">';
                                            echo woocommerce_template_loop_add_to_cart();
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';

                            echo '</div>';
                        echo '</div>';
                    }
                ?>

                <?php
                    if ($pagination == 'yes') {
                        echo '<div class="organium_pagination">';
                            echo get_the_posts_pagination(array(
                                'prev_text' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                                'next_text' => '<i class="fa fa-angle-right" aria-hidden="true"></i>'
                            ));
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
        <?php
        wp_reset_query();
    }

    protected function content_template() {}

    public function render_plain_content() {}
}