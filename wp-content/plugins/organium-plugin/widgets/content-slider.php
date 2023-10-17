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

class Organium_Content_Slider_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_content_slider';
    }

    public function get_title() {
        return esc_html__('Content Slider', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-post-slider';
    }

    public function get_categories() {
        return ['organium_widgets'];
    }

    public function get_script_depends() {
        return ['content_slider_widget'];
    }

    protected function _register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content Slider', 'organium_plugin')
            ]
        );

        $this->add_control(
            'content_width_type',
            [
                'label' => esc_html__('Content Width Type', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'boxed',
                'options' => [
                    'boxed' => esc_html__('Boxed', 'organium_plugin'),
                    'full' => esc_html__('Fullwidth', 'organium_plugin'),
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'slider_height',
            [
                'label' => esc_html__('Slider Height', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '973',
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 2000,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_content_slide' => 'height: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'slide_name',
            [
                'label' => esc_html__('Slide Name', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'separator' => 'after'
            ]
        );

        $repeater->add_control(
            'slide_type',
            [
                'label' => esc_html__('Slide Type', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'fade_in_right',
                'options' => [
                    'fade_in_right' => esc_html__('Fade In Right', 'organium_plugin'),
                    'fade_in_left' => esc_html__('Fade In Left', 'organium_plugin'),
                    'corners_to_center' => esc_html__('Corners To Center', 'organium_plugin')
                ],
                'separator' => 'after'
            ]
        );



        $repeater->start_controls_tabs('button_settings_tabs');

            // -------------------- //
            // ------ BG Tab ------ //
            // -------------------- //
            $repeater->start_controls_tab(
                'tab_bg',
                [
                    'label' => esc_html__('BG', 'organium_plugin')
                ]
            );

                $repeater->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'background',
                        'label' => esc_html__( 'Background', 'organium_plugin' ),
                        'types' => [ 'classic' ],
                        'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}'
                    ]
                );

            $repeater->end_controls_tab();

            // ----------------------- //
            // ------ Image Tab ------ //
            // ----------------------- //
            $repeater->start_controls_tab(
                'tab_image',
                [
                    'label' => esc_html__('Image', 'organium_plugin')
                ]
            );

                $repeater->add_control(
                    'active_image',
                    [
                        'label' => esc_html__('Active Image', 'organium_plugin'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'condition' => [
                            'slide_type' => ['fade_in_right', 'fade_in_left']
                        ]
                    ]
                );

                $repeater->add_responsive_control(
                    'image_margin',
                    [
                        'label' => esc_html__('Position', 'organium_plugin'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['%', 'px'],
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .active_image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ],
                        'condition' => [
                            'slide_type' => ['fade_in_right', 'fade_in_left']
                        ]
                    ]
                );

                $repeater->add_control(
                    'active_image_1',
                    [
                        'label' => esc_html__('Top Left Corner Image', 'organium_plugin'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'condition' => [
                            'slide_type' => 'corners_to_center'
                        ]
                    ]
                );

                $repeater->add_control(
                    'active_image_2',
                    [
                        'label' => esc_html__('Top Right Corner Image', 'organium_plugin'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'condition' => [
                            'slide_type' => 'corners_to_center'
                        ]
                    ]
                );

                $repeater->add_control(
                    'active_image_3',
                    [
                        'label' => esc_html__('Bottom Right Corner Image', 'organium_plugin'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'condition' => [
                            'slide_type' => 'corners_to_center'
                        ]
                    ]
                );

                $repeater->add_control(
                    'active_image_4',
                    [
                        'label' => esc_html__('Bottom Left Corner Image', 'organium_plugin'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'condition' => [
                            'slide_type' => 'corners_to_center'
                        ]
                    ]
                );

            $repeater->end_controls_tab();

            // ---------------------- //
            // ------ Icon Tab ------ //
            // ---------------------- //
            $repeater->start_controls_tab(
                'tab_icon',
                [
                    'label' => esc_html__('Icon', 'organium_plugin')
                ]
            );

                $repeater->add_control(
                    'icon_type',
                    [
                        'label' => esc_html__('Type of Icon', 'organium_plugin'),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'none',
                        'options' => [
                            'none' => esc_html__('None', 'organium_plugin'),
                            'default' => esc_html__('Default Icon', 'organium_plugin'),
                            'svg' => esc_html__('SVG Icon', 'organium_plugin'),
                            'image' => esc_html__('Image Icon', 'organium_plugin')
                        ]
                    ]
                );

                $repeater->add_control(
                    'default_icon',
                    [
                        'label' => esc_html__('Icon', 'organium_plugin'),
                        'type' => Controls_Manager::ICONS,
                        'label_block' => true,
                        'default' => [
                            'value' => 'fas fa-star',
                            'library' => 'fa-solid'
                        ],
                        'condition' => [
                            'icon_type' => 'default'
                        ]
                    ]
                );

                $repeater->add_control(
                    'svg_icon',
                    [
                        'label' => esc_html__('SVG Icon', 'organium_plugin'),
                        'description' => esc_html__('Enter svg code', 'organium_plugin'),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => '',
                        'condition' => [
                            'icon_type' => 'svg'
                        ]
                    ]
                );

                $repeater->add_control(
                    'img_icon',
                    [
                        'label' => esc_html__('Image Icon', 'organium_plugin'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'condition' => [
                            'icon_type' => 'image'
                        ]
                    ]
                );

                $repeater->add_responsive_control(
                    'icon_size',
                    [
                        'label' => esc_html__('Icon Size', 'organium_plugin'),
                        'type' => Controls_Manager::SLIDER,
                        'range' => [
                            'px' => [
                                'min' => 5,
                                'max' => 200
                            ]
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .organium_icon_container i' => 'font-size: {{SIZE}}{{UNIT}};'
                        ],
                        'condition' => [
                            'icon_type' => 'default'
                        ]
                    ]
                );

                $repeater->add_responsive_control(
                    'icon_svg_size',
                    [
                        'label' => esc_html__('Icon Size', 'organium_plugin'),
                        'type' => Controls_Manager::SLIDER,
                        'range' => [
                            'px' => [
                                'min' => 5,
                                'max' => 200
                            ]
                        ],
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                        ],
                        'condition' => [
                            'icon_type' => 'svg'
                        ]
                    ]
                );

                $repeater->add_responsive_control(
                    'icon_img_size',
                    [
                        'label' => esc_html__('Icon Size', 'organium_plugin'),
                        'type' => Controls_Manager::SLIDER,
                        'range' => [
                            'px' => [
                                'min' => 5,
                                'max' => 200
                            ]
                        ],
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .icon' => 'width: {{SIZE}}{{UNIT}}; height: auto;'
                        ],
                        'condition' => [
                            'icon_type' => 'image'
                        ]
                    ]
                );

                $repeater->add_responsive_control(
                    'icon_margin',
                    [
                        'label' => esc_html__('Icon Margin', 'organium_plugin'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', '%'],
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ]
                    ]
                );

            $repeater->end_controls_tab();

            // ----------------------- //
            // ------ Title Tab ------ //
            // ----------------------- //
            $repeater->start_controls_tab(
                'tab_title',
                [
                    'label' => esc_html__('Title', 'organium_plugin')
                ]
            );

                $repeater->add_control(
                    'heading',
                    [
                        'label' => esc_html__('Title', 'organium_plugin'),
                        'type' => Controls_Manager::WYSIWYG,
                        'label_block' => true,
                        'placeholder' => esc_html__('Enter Title', 'organium_plugin'),
                        'default' => esc_html__('Title', 'organium_plugin')
                    ]
                );

                $repeater->add_group_control(
                    Group_Control_Typography::get_type(),
                    [
                        'name' => 'heading_typography',
                        'label' => esc_html__('Heading Typography', 'organium_plugin'),
                        'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .organium_content_slider_title'
                    ]
                );

                $repeater->add_control(
                    'heading_color',
                    [
                        'label' => esc_html__('Heading Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .organium_content_slider_title' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $repeater->end_controls_tab();

            // ---------------------- //
            // ------ Text Tab ------ //
            // ---------------------- //
            $repeater->start_controls_tab(
                'tab_text',
                [
                    'label' => esc_html__('Text', 'organium_plugin')
                ]
            );

                $repeater->add_control(
                    'text',
                    [
                        'label' => esc_html__('Promo Text', 'organium_plugin'),
                        'type' => Controls_Manager::WYSIWYG,
                        'default' => '',
                        'placeholder' => esc_html__('Enter Promo Text', 'organium_plugin'),
                        'separator' => 'before'
                    ]
                );

                $repeater->add_group_control(
                    Group_Control_Typography::get_type(),
                    [
                        'name' => 'text_typography',
                        'label' => esc_html__('Text Typography', 'organium_plugin'),
                        'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .organium_content_slider_promo_text'
                    ]
                );

                $repeater->add_control(
                    'text_color',
                    [
                        'label' => esc_html__('Text Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .organium_content_slider_promo_text' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $repeater->add_responsive_control(
                    'text_padding',
                    [
                        'label' => esc_html__('Promo Text Padding', 'organium_plugin'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', '%'],
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .organium_content_slider_promo_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ],
                        'separator' => 'before'
                    ]
                );

            $repeater->end_controls_tab();

            // ------------------------ //
            // ------ Button Tab ------ //
            // ------------------------ //
            $repeater->start_controls_tab(
                'tab_button',
                [
                    'label' => esc_html__('Button', 'organium_plugin')
                ]
            );

                $repeater->add_control(
                    'button_text',
                    [
                        'label' => esc_html__('Button Text', 'organium_plugin'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('Button', 'organium_plugin'),
                        'separator' => 'before'
                    ]
                );

                $repeater->add_control(
                    'button_link',
                    [
                        'label' => esc_html__('Button Link', 'organium_plugin'),
                        'type' => Controls_Manager::URL,
                        'label_block' => true,
                        'default' => [
                            'url' => '',
                            'is_external' => 'true',
                        ],
                        'placeholder' => esc_html__( 'http://your-link.com', 'organium_plugin' )
                    ]
                );

                $repeater->add_control(
                    'button_color',
                    [
                        'label' => esc_html__('Button Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .organium_button' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before'
                    ]
                );

                $repeater->add_control(
                    'button_bg',
                    [
                        'label' => esc_html__('Button Background', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .organium_button' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $repeater->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow',
                        'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .organium_button',
                    ]
                );

                $repeater->add_control(
                    'button_color_hover',
                    [
                        'label' => esc_html__('Button Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .organium_button:hover' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before'
                    ]
                );

                $repeater->add_control(
                    'button_bg_hover',
                    [
                        'label' => esc_html__('Button Background Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .organium_button:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $repeater->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow_hover',
                        'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .organium_button:hover',
                    ]
                );

                $repeater->add_responsive_control(
                    'button_top_margin',
                    [
                        'label' => esc_html__('Button Top Space', 'organium_plugin'),
                        'type' => Controls_Manager::SLIDER,
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 200
                            ]
                        ],
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} .organium_button' => 'margin-top: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );

            $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $repeater->add_responsive_control(
            'content_max_width',
            [
                'label' => esc_html__('Content Container Max Width', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 50,
                        'max' => 2000,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .organium_content_container' => 'max-width: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $repeater->add_responsive_control(
            'content_align',
            [
                'label' => esc_html__('Content Container Alignment', 'organium_plugin'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'organium_plugin' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'organium_plugin' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'organium_plugin' ),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .organium_content_slide_wrapper' => 'justify-content: {{VALUE}};'
                ],
                'label_block' => true,
                'separator' => 'before'
            ]
        );

        $repeater->add_responsive_control(
            'content_v_align',
            [
                'label' => esc_html__('Content Container Vertical Alignment', 'organium_plugin'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'organium_plugin' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'organium_plugin' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'organium_plugin' ),
                        'icon' => 'eicon-v-align-bottom',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .organium_content_slide_wrapper' => 'align-items: {{VALUE}};'
                ],
                'label_block' => true,
                'separator' => 'before'
            ]
        );

        $repeater->add_responsive_control(
            'content_text_align',
            [
                'label' => esc_html__('Content Container Text Align', 'organium_plugin'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'organium_plugin' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'organium_plugin' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'organium_plugin' ),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .organium_content_container' => 'text-align: {{VALUE}};'
                ],
                'label_block' => true,
                'separator' => 'before'
            ]
        );

        $repeater->add_control(
            'divider_1',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => esc_html__('Slides', 'organium_plugin'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{slide_name}}}',
                'prevent_empty' => false,
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // ---------------------------- //
        // ---------- Slider ---------- //
        // ---------------------------- //
        $this->start_controls_section(
            'section_slider',
            [
                'label' => esc_html__('Slider Settings', 'organium_plugin')
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Animation Speed', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1200,
                'separator' => 'before'
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
                'separator' => 'before'
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
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => [
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
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // ------------------------------------------- //
        // ---------- Button Style Settings ---------- //
        // ------------------------------------------- //
        $this->start_controls_section(
            'section_button_settings',
            [
                'label' => esc_html__('Content Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Button Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_button'
            ]
        );

        $this->add_control(
            'button_radius',
            [
                'label' => esc_html__('Border Radius', 'organium_plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .organium_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'button_padding',
            [
                'label' => esc_html__('Button Padding', 'organium_plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .organium_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------------- //
        // ---------- Button Style Settings ---------- //
        // ------------------------------------------- //
        $this->start_controls_section(
            'section_slider_settings',
            [
                'label' => esc_html__('Slider Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('button_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_arrows_normal',
                [
                    'label' => esc_html__('Normal', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'nav_color',
                    [
                        'label' => esc_html__('Slider Arrows Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slick-arrow:after' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'nav_bg',
                    [
                        'label' => esc_html__('Slider Arrows Background', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slick-arrow:before' => 'background: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_arrows_hover',
                [
                    'label' => esc_html__('Hover', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'nav_hover',
                    [
                        'label' => esc_html__('Slider Arrows Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slick-arrow:hover:after' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'nav_bg_hover',
                    [
                        'label' => esc_html__('Slider Arrows Hover Background', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slick-arrow:hover:before' => 'background: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $content_width_type = $settings['content_width_type'];
        $slides = $settings['slides'];

        if ($settings['rtl_support'] == 'yes') {
            $rtl = true;
        } else {
            $rtl = false;
        }

        $slider_options = [
            'pauseOnHover' => ('yes' === $settings['pause_on_hover']),
            'autoplay' => ('yes' === $settings['autoplay']),
            'infinite' => ('yes' === $settings['infinite']),
            'speed' => absint($settings['speed']),
            'rtl' => $rtl
        ];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="organium_content_slider_widget">
            <div class="organium_content_slider_wrapper">

                <div class="organium_content_slider organium_slider_slick" data-slider-options="<?php echo esc_attr(wp_json_encode($slider_options)); ?>">
                    <?php
                    foreach ($slides as $slide) {
                        echo '<div class="organium_content_slide elementor-repeater-item-' . esc_attr($slide['_id']) . ' slide-animation-type-' . esc_attr($slide['slide_type']) . '">';
                            if ( $slide['slide_type'] == 'corners_to_center' ) {
                                echo ( !empty($slide['active_image_1']) ? '<div class="active_image active_image_left_top">' . wp_get_attachment_image( $slide['active_image_1']['id'], 'full' ) . '</div>' : '' );
                                echo ( !empty($slide['active_image_2']) ? '<div class="active_image active_image_right_top">' . wp_get_attachment_image( $slide['active_image_2']['id'], 'full' ) . '</div>' : '' );
                                echo ( !empty($slide['active_image_3']) ? '<div class="active_image active_image_right_bottom">' . wp_get_attachment_image( $slide['active_image_3']['id'], 'full' ) . '</div>' : '' );
                                echo ( !empty($slide['active_image_4']) ? '<div class="active_image active_image_left_bottom">' . wp_get_attachment_image( $slide['active_image_4']['id'], 'full' ) . '</div>' : '' );
                            } else {
                                echo ( !empty($slide['active_image']) ? '<div class="active_image">' . wp_get_attachment_image( $slide['active_image']['id'], 'full' ) . '</div>' : '' );
                            }
                            if ($content_width_type == 'boxed') {
                                echo '<div class="container organium_full_cont">';
                                    echo '<div class="row organium_full_cont">';
                                        echo '<div class="col-12 organium_full_cont">';
                            }
                                            echo '<div class="organium_content_slide_wrapper">';
                                                echo '<div class="organium_content_container">';

                                                    if ($slide['icon_type'] == 'default') {
                                                        echo '<div class="organium_content_wrapper_1">';
                                                            echo '<i class="icon ' . esc_attr($slide['default_icon']['value']) . '"></i>';
                                                        echo '</div>';
                                                    }
                                                    if ($slide['icon_type'] == 'svg') {
                                                        echo '<div class="organium_content_wrapper_1">';
                                                            echo '<span class="icon">' . organium_output_code($slide['svg_icon']) . '</span>';
                                                        echo '</div>';
                                                    }
                                                    if ($slide['icon_type'] == 'image') {
                                                        echo '<div class="organium_content_wrapper_1">';
                                                            echo '<span class="icon">' . wp_get_attachment_image( $slide['img_icon']['id'], 'full' ) . '</span>';
                                                        echo '</div>';
                                                    }

                                                    if ( !empty($slide['heading']) ) {
                                                        echo '<div class="organium_content_wrapper_2">';
                                                            echo '<div class="organium_content_slider_title">';
                                                               echo organium_output_code($slide['heading']);
                                                            echo '</div>';
                                                        echo '</div>';
                                                    }

                                                    if ($slide['text'] !== '') {
                                                        echo '<div class="organium_content_wrapper_3">';
                                                            echo '<div class="organium_content_slider_promo_text">' . organium_output_code($slide['text']) . '</div>';
                                                        echo '</div>';
                                                    }

                                                    if ($slide['button_text'] !== '') {
                                                        if ($slide['button_link']['url'] !== '') {
                                                            $button_url = $slide['button_link']['url'];
                                                        } else {
                                                            $button_url = '#';
                                                        }
                                                        echo '<div class="organium_content_wrapper_4">';
                                                            echo '<a class="organium_button organium_button--primary" href="' . esc_url($button_url) . '"' . (($slide['button_link']['is_external'] == true) ? ' target="_blank"' : '') . (($slide['button_link']['nofollow'] == 'on') ? ' rel="nofollow"' : '') . '>';
                                                                echo esc_html($slide['button_text']);
                                                            echo '</a>';
                                                        echo '</div>';
                                                    }
                                                echo '</div>';
                                            echo '</div>';

                            if ($content_width_type == 'boxed') {
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }

                        echo '</div>';
                    }
                    ?>
                </div>

            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}

//https://www.youtube.com/watch?v=_sI_Ps7JSEk