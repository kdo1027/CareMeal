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
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Organium_Products_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_products';
    }

    public function get_title() {
        return esc_html__('Products', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-products';
    }

    public function is_reload_preview_required() {
        return true;
    }

    public function get_categories() {
        return ['organium_widgets'];
    }

    public function get_script_depends() {
        return ['products_widget'];
    }

    protected function _register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_display_product',
            [
                'label' => esc_html__('Display Product', 'organium_plugin')
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
                    'special'  => esc_html__('Special', 'organium_plugin'),
                    'compact'  => esc_html__('Compact', 'organium_plugin')
                ]
            ]
        );

        $this->add_control(
            'products_type',
            [
                'label'   => esc_html__('Products Type', 'organium_plugin'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'all',
                'options' => [
                    'all'           => esc_html__('All', 'organium_plugin'),
                    'on_sale'       => esc_html__('On sale products', 'organium_plugin'),
                    'best_selling'  => esc_html__('The best selling products', 'organium_plugin'),
                    'top_rated'     => esc_html__('Top-rated products', 'organium_plugin')
                ]
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Limit', 'organium_plugin'),
                'description' => esc_html__('The number of products to display', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'min' => -1,
                'max' => 50,
                'default' => 4
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'organium_plugin'),
                'description' => esc_html__('The number of columns to display.', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 6,
                'default' => 4
            ]
        );

        $this->add_control(
            'paginate',
            [
                'label' => esc_html__('Show Pagination', 'organium_plugin'),
                'description' => esc_html__('Toggles pagination on. Use in conjunction with "limit"', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_off' => esc_html__('Hide', 'organium_plugin'),
                'label_on' => esc_html__('Show', 'organium_plugin')
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => esc_html__('Orderby', 'organium_plugin'),
                'type'    => Controls_Manager::SELECT,
                'description' => esc_html__('Sorts the products displayed by the entered option.', 'organium_plugin'),
                'default' => 'date',
                'options' => [
                    'date'        => esc_html__('Date', 'organium_plugin'),
                    'id'          => esc_html__('ID', 'organium_plugin'),
                    'menu_order'  => esc_html__('Menu order', 'organium_plugin'),
                    'popularity'  => esc_html__('Popularity', 'organium_plugin'),
                    'rand'        => esc_html__('Random', 'organium_plugin'),
                    'rating'      => esc_html__('Rating', 'organium_plugin'),
                    'title'       => esc_html__('Title', 'organium_plugin')
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => esc_html__('Order', 'organium_plugin'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'ASC',
                'options' => [
                    'ASC'        => esc_html__('ASC', 'organium_plugin'),
                    'DESC'       => esc_html__('DESC', 'organium_plugin')
                ]
            ]
        );

        $cat_args = array(
            'orderby'    => 'name',
            'order'      => 'asc',
            'hide_empty' => false,
        );
        $product_categories = get_terms( 'product_cat', $cat_args );
        $category_arr = [];
        if( !empty($product_categories) ){
            foreach ($product_categories as $key => $category) {
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
                'options' => $category_arr
            ]
        );

        $this->add_control(
            'skus',
            [
                'label' => esc_html__('SKUs', 'organium_plugin'),
                'label_block' => true,
                'description' => esc_html__('Comma-separated list of product SKUs.', 'organium_plugin'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( 'Enter SKU list', 'organium_plugin' )
            ]
        );

        $this->add_control(
            'tag',
            [
                'label' => esc_html__('Tags', 'organium_plugin'),
                'label_block' => true,
                'description' => esc_html__('Comma-separated list of tag slugs.', 'organium_plugin'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( 'Enter tags list', 'organium_plugin' )
            ]
        );

        $this->add_control(
            'slider',
            [
                'label' => esc_html__('Use Carousel', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_off' => esc_html__('No', 'organium_plugin'),
                'label_on' => esc_html__('Yes', 'organium_plugin'),
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_slider_product',
            [
                'label' => esc_html__('Slider Settings', 'organium_plugin'),
                'condition' => [
                    'slider' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'slider_style',
            [
                'label'   => esc_html__('Slider Style', 'organium_plugin'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style_1',
                'options' => [
                    'style_1'     => esc_html__('Style 1', 'organium_plugin'),
                    'style_2'     => esc_html__('Style 2', 'organium_plugin'),
                ],
                'condition' => [
                    'slider' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Animation Speed', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
                'condition' => [
                    'slider' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label' => esc_html__('Infinite Loop', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'organium_plugin'),
                    'no' => esc_html__('No', 'organium_plugin'),
                ],
                'condition' => [
                    'slider' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'organium_plugin'),
                    'no' => esc_html__('No', 'organium_plugin'),
                ],
                'condition' => [
                    'slider' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => [
                    'slider' => 'yes',
                    'autoplay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => esc_html__('Pause on Hover', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'organium_plugin'),
                    'no' => esc_html__('No', 'organium_plugin'),
                ],
                'condition' => [
                    'slider' => 'yes',
                    'autoplay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'rtl_support',
            [
                'label' => esc_html__('Rtl Support', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_off' => esc_html__('Off', 'organium_plugin'),
                'label_on' => esc_html__('On', 'organium_plugin'),
                'separator' => 'before',
                'condition' => [
                    'slider' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Item Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_item_settings',
            [
                'label' => esc_html__('Product Item Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label'   => esc_html__('Image Style', 'organium_plugin'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default'     => esc_html__('Default', 'organium_plugin'),
                    'wide'        => esc_html__('Wide', 'organium_plugin'),
                    'large'       => esc_html__('Large', 'organium_plugin'),
                    'book'        => esc_html__('Book', 'organium_plugin')
                ],
                'condition' => [
                    'view_style' => ['standard', 'special']
                ]
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
                'border_color',
                [
                    'label' => esc_html__('Border Color', 'organium_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-loop-product__wrapper' => 'border-color: {{VALUE}};'
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
                'border_hover',
                [
                    'label' => esc_html__('Border Color', 'organium_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-loop-product__wrapper:hover' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

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
                        '{{WRAPPER}} .woocommerce-loop-product__wrapper .yith-wcwl-add-to-wishlist .add_to_wishlist' => 'color: {{VALUE}};'
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
                        '{{WRAPPER}} .woocommerce-loop-product__wrapper .yith-wcwl-add-to-wishlist .delete_item' => 'color: {{VALUE}};'
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-loop-product__wrapper' => 'text-align: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .woocommerce-loop-product__wrapper .content-woocommerce_wrapper .woocommerce-loop-product__title, {{WRAPPER}} .woocommerce-loop-product__wrapper .content-woocommerce_wrapper .woocommerce-loop-category__title, {{WRAPPER}} .woocommerce-loop-product__wrapper .content-woocommerce_wrapper h3'
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Space between image and title', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}}  .woocommerce-loop-product__wrapper .content-woocommerce_wrapper' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
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
                        '{{WRAPPER}} .woocommerce-loop-product__wrapper .content-woocommerce_wrapper .woocommerce-loop-product__title, {{WRAPPER}} .woocommerce-loop-product__wrapper .content-woocommerce_wrapper .woocommerce-loop-category__title, {{WRAPPER}} .woocommerce-loop-product__wrapper .content-woocommerce_wrapper h3' => 'color: {{VALUE}};'
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
                        '{{WRAPPER}} .woocommerce-loop-product__wrapper .content-woocommerce_wrapper .woocommerce-loop-product__title a:hover, {{WRAPPER}} .woocommerce-loop-product__wrapper .content-woocommerce_wrapper .woocommerce-loop-category__title a:hover, {{WRAPPER}} .woocommerce-loop-product__wrapper .content-woocommerce_wrapper h3 a:hover' => 'color: {{VALUE}};'
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
                'selector' => '{{WRAPPER}} .woocommerce-loop-product__wrapper .content-woocommerce_wrapper .price'
            ]
        );

        $this->add_control(
            'current_price_color',
            [
                'label' => esc_html__('Current Price Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-loop-product__wrapper .content-woocommerce_wrapper .price' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'old_price_color',
            [
                'label' => esc_html__('Old Price Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-loop-product__wrapper .content-woocommerce_wrapper .price del' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'rating_default_color',
            [
                'label' => esc_html__('Rating Inactive Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-loop-product__wrapper .content-woocommerce_wrapper .star-rating:before' => 'color: {{VALUE}};'
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
                    '{{WRAPPER}} .woocommerce-loop-product__wrapper .content-woocommerce_wrapper .star-rating span' => 'color: {{VALUE}};'
                ]
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
                'selector' => '{{WRAPPER}} .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper a.button, {{WRAPPER}} .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper a.added_to_cart'
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
                            '{{WRAPPER}} .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper a.button, {{WRAPPER}} .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper a.added_to_cart' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_bg_color',
                    [
                        'label' => esc_html__('Button Background Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper a.button, {{WRAPPER}} .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper a.added_to_cart' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow',
                        'selector' => '{{WRAPPER}} .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper a.button, {{WRAPPER}} .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper a.added_to_cart',
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
                            '{{WRAPPER}} .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper a.button:hover, {{WRAPPER}} .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper a.added_to_cart:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_hover_bg_color',
                    [
                        'label' => esc_html__('Button Background Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper a.button:hover, {{WRAPPER}} .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper a.added_to_cart:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_hover_box_shadow',
                        'selector' => '{{WRAPPER}} .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper a.button:hover, {{WRAPPER}} .woocommerce-loop-product__wrapper .buttons-woocommerce_wrapper a.added_to_cart:hover',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->end_controls_section();


        // ----------------------------------------- //
        // ---------- Pagination Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'section_pagination_settings',
            [
                'label' => esc_html__('Pagination Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'slider' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('pagination_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'pagination_normal',
                [
                    'label' => esc_html__('Normal', 'organium_plugin')
                ]
            );

            $this->add_control(
                'dot_color',
                [
                    'label' => esc_html__('Pagination Dot Color', 'organium_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .slick-dots li:after' => 'background: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'dot_border',
                [
                    'label' => esc_html__('Pagination Dot Border', 'organium_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .slick-dots li' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

            // ------------------------ //
            // ------ Active Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'pagination_active',
                [
                    'label' => esc_html__('Active', 'organium_plugin')
                ]
            );

            $this->add_control(
                'dot_active',
                [
                    'label' => esc_html__('Pagination Dot Color', 'organium_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .slick-dots li.slick-active:after' => 'background: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'dot_border_active',
                [
                    'label' => esc_html__('Pagination Dot Border', 'organium_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .slick-dots li.slick-active' => 'border-color: {{VALUE}};'
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
        $image_size = $settings['image_size'];
        $slider_style = $settings['slider_style'];
        $shortcode_attr = '';

        $products_type = $settings['products_type'];
        if ( $products_type == 'on_sale' ) {
            $shortcode_attr .= ' on_sale="true"';
        } elseif ( $products_type == 'best_selling' ) {
            $shortcode_attr .= ' best_selling="true"';
        } elseif ( $products_type == 'top_rated' ) {
            $shortcode_attr .= ' top_rated="true"';
        }

        $limit = $settings['limit'];
        $shortcode_attr .= (!empty($limit) ? ' limit="' . $limit . '"' : '');

        $columns = $settings['columns'];
        $shortcode_attr .= (!empty($columns) ? ' columns="' . $columns . '"' : '');

        $paginate = $settings['paginate'];
        $shortcode_attr .= (!empty($paginate) && $paginate == 'yes' ? ' paginate="true"' : ' paginate="false"');

        $orderby = $settings['orderby'];
        $shortcode_attr .= (!empty($orderby) ? ' orderby="' . $orderby . '"' : '');

        $order = $settings['order'];
        $shortcode_attr .= (!empty($order) ? ' order="' . $order . '"' : '');

        $category = $settings['category'];
        $shortcode_attr .= (!empty($category) ? ' category="' . implode(', ', $category) . '"' : '');

        $skus = $settings['skus'];
        $shortcode_attr .= (!empty($skus) ? ' skus="' . esc_html__($skus) . '"' : '');

        $tag = $settings['tag'];
        $shortcode_attr .= (!empty($tag) ? ' tag="' . esc_html__($tag) . '"' : '');


        // Carousel
        if ($settings['rtl_support'] == 'yes') {
            $rtl = true;
        } else {
            $rtl = false;
        }
        $slidesToShow = $columns;
        $slider_options = [
            'use_slider' => ('yes' === $settings['slider']),
            'slidesToShow' => $slidesToShow,
            'pauseOnHover' => ('yes' === $settings['pause_on_hover']),
            'autoplay' => ('yes' === $settings['autoplay']),
            'infinite' => ('yes' === $settings['infinite']),
            'speed' => absint($settings['speed']),
            'rtl' => $rtl
        ];

        $classes = (!empty($view_style) ? ' view_type_' . esc_attr($view_style) : '');
        $classes .= ($settings['slider'] == 'yes' ? ' is_slider' : '');
        $classes .= ($image_size != 'default' ? ' ' . esc_attr($image_size) . '_image' : '');
        $classes .= ($settings['slider'] == 'yes' && !empty($slider_style) ? ' slider_' . esc_attr($slider_style) : '');

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>
        <div class="organium_products_widget<?php echo esc_attr($classes); ?>" data-slider-options="<?php echo esc_attr(wp_json_encode($slider_options)); ?>">
            <?php
                $shortcode = '[products' . $shortcode_attr . ']';
                echo do_shortcode( $shortcode );
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
