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

class Organium_Icon_Box_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_icon_box';
    }

    public function get_title() {
        return esc_html__('Icon Box', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-icon-box';
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
                'label' => esc_html__('Icon Box', 'organium_plugin')
            ]
        );

        $this->add_control(
            'block_style',
            [
                'label' => esc_html__('Block behavior', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'label_block' => true,
                'options' => [
                    'default' => esc_html__('Default', 'organium_plugin'),
                    'narrow' => esc_html__('Narrow', 'organium_plugin')
                ],
                'separator' => 'after',
                'prefix_class' => 'block_behavior_',
            ]
        );

        $this->add_control(
            'icon_type',
            [
                'label' => esc_html__('Type of Icon', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default Icon', 'organium_plugin'),
                    'svg' => esc_html__('SVG Icon', 'organium_plugin'),
                    'text' => esc_html__('Text', 'organium_plugin')
                ]
            ]
        );

        $this->add_control(
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

        $this->add_control(
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

        $this->add_control(
            'text_icon',
            [
                'label' => esc_html__('Text', 'organium_plugin'),
                'description' => esc_html__('Enter text', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    'icon_type' => 'text'
                ]
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => __( 'Icon Position', 'elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'top',
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'elementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'top' => [
                        'title' => __( 'Top', 'elementor' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'elementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'icon_position_',
                'toggle' => false
            ]
        );

        $this->add_control(
            'bg_image_status',
            [
                'label' => esc_html__('Background Image', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'organium_plugin'),
                'label_on' => esc_html__('On', 'organium_plugin'),
                'default' => 'no',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'background_type',
            [
                'label' => esc_html__('Type of Background', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'svg',
                'options' => [
                    'svg' => esc_html__('SVG', 'organium_plugin'),
                    'image' => esc_html__('Image', 'organium_plugin'),
                    'color' => esc_html__('Color', 'organium_plugin')
                ],
                'condition' => [
                    'bg_image_status' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'svg_background',
            [
                'label' => esc_html__('SVG Background', 'organium_plugin'),
                'description' => esc_html__('Enter svg code', 'organium_plugin'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'condition' => [
                    'bg_image_status' => 'yes',
                    'background_type' => 'svg'
                ]
            ]
        );

        $this->start_controls_tabs('background_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'background_normal',
                [
                    'label' => esc_html__('Normal', 'organium_plugin'),
                    'condition' => [
                        'bg_image_status' => 'yes',
                        'background_type' => 'image'
                    ]
                ]
            );

                $this->add_control(
                    'bg_image',
                    [
                        'label' => esc_html__('Choose Background Image', 'organium_plugin'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [],
                        'condition' => [
                            'bg_image_status' => 'yes',
                            'background_type' => 'image'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'background_hover',
                [
                    'label' => esc_html__('Hover', 'organium_plugin'),
                    'condition' => [
                        'bg_image_status' => 'yes',
                        'background_type' => 'image'
                    ]
                ]
            );

                $this->add_control(
                    'bg_image_hover',
                    [
                        'label' => esc_html__('Choose Background Image', 'organium_plugin'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [],
                        'condition' => [
                            'bg_image_status' => 'yes',
                            'background_type' => 'image'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Icon Box Title', 'organium_plugin'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Title', 'organium_plugin'),
                'placeholder' => esc_html__('Enter Icon Box Title', 'organium_plugin'),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'info_type',
            [
                'label' => esc_html__('Type of Icon Box Information', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'info',
                'label_block' => true,
                'options' => [
                    'info' => esc_html__('Custom Information', 'organium_plugin'),
                    'socials' => esc_html__('Social Icons', 'organium_plugin')
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'info',
            [
                'label' => esc_html__('Icon Box Information', 'organium_plugin'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'placeholder' => esc_html__('Enter Your Custom Information', 'organium_plugin'),
                'condition' => [
                    'info_type' => 'info'
                ]
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'social_icon',
            [
                'label' => esc_html__('Icon', 'organium_plugin'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'fa4compatibility' => 'social',
                'default' => [
                    'value' => 'fab fa-wordpress',
                    'library' => 'brand'
                ]
            ]
        );

        $repeater->add_control(
            'social_link',
            [
                'label' => esc_html__('Link', 'organium_plugin'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '',
                    'is_external' => 'true',
                ],
                'placeholder' => esc_html__( 'http://your-link.com', 'organium_plugin' )
            ]
        );

        $this->add_control(
            'socials',
            [
                'label' => esc_html__('Social Icons', 'organium_plugin'),
                'type' => Controls_Manager::REPEATER,
                'default' => [],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{elementor.helpers.renderIcon(this, social_icon, {}, "i", "panel")}}}',
                'prevent_empty' => false,
                'condition' => [
                    'info_type' => 'socials'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_box_align',
            [
                'label' => esc_html__('Icon Box Alignment', 'organium_plugin'),
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
                    '{{WRAPPER}} .organium_icon_box_item' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before',
                'prefix_class' => 'alignment%s-'
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Icon Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'icon_settings',
            [
                'label' => esc_html__('Icon Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'icon_container_size',
            [
                'label' => esc_html__('Icon Container Size', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_icon_container' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
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

        $this->add_responsive_control(
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
                    '{{WRAPPER}} .organium_icon_container .icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'icon_type' => 'svg'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'icon_text_typography',
                'label' => esc_html__('Icon Text Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_icon_container .text',
                'condition' => [
                    'icon_type' => 'text'
                ]
            ]
        );




        $this->start_controls_tabs('icon_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'icon_normal',
                [
                    'label' => esc_html__('Normal', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'icon_color',
                    [
                        'label' => esc_html__('Icon Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_icon_container i' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'icon_type' => 'default'
                        ]
                    ]
                );

                $this->add_control(
                    'icon_svg_color',
                    [
                        'label' => esc_html__('Icon Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_icon_container .icon svg' => 'fill: {{VALUE}};'
                        ],
                        'condition' => [
                            'icon_type' => 'svg'
                        ]
                    ]
                );

                $this->add_control(
                    'icon_text_color',
                    [
                        'label' => esc_html__('Icon Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_icon_container .text' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'icon_type' => 'text'
                        ]
                    ]
                );

                $this->add_control(
                    'background_svg_color',
                    [
                        'label' => esc_html__('Background SVG Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_icon_container .background svg' => 'fill: {{VALUE}};'
                        ],
                        'condition' => [
                            'background_type' => 'svg',
                            'bg_image_status' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'background_color',
                    [
                        'label' => esc_html__('Background Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_icon_container' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'background_type' => 'color',
                            'bg_image_status' => 'yes'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'icon_hover',
                [
                    'label' => esc_html__('Hover', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'icon_color_hover',
                    [
                        'label' => esc_html__('Icon Color on Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .organium_icon_container i' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'icon_type' => 'default'
                        ]
                    ]
                );

                $this->add_control(
                    'icon_svg_color_hover',
                    [
                        'label' => esc_html__('Icon Color on Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .organium_icon_container .icon svg' => 'fill: {{VALUE}};'
                        ],
                        'condition' => [
                            'icon_type' => 'svg'
                        ]
                    ]
                );

                $this->add_control(
                    'icon_text_color_hover',
                    [
                        'label' => esc_html__('Icon Color on Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .organium_icon_container .text' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'icon_type' => 'text'
                        ]
                    ]
                );

                $this->add_control(
                    'background_svg_color_hover',
                    [
                        'label' => esc_html__('Background SVG on Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .organium_icon_container .background svg' => 'fill: {{VALUE}};'
                        ],
                        'condition' => [
                            'background_type' => 'svg',
                            'bg_image_status' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'background_color_hover',
                    [
                        'label' => esc_html__('Background Color on Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .organium_icon_container' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'background_type' => 'color',
                            'bg_image_status' => 'yes'
                        ]
                    ]
                );


            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Icon top padding', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_icon_container' => 'margin-top: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'icon_position' => ['left', 'right']
                ]
            ]
        );

        $this->end_controls_section();








        // ------------------------------------ //
        // ---------- Title Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'title_settings',
            [
                'label' => esc_html__('Title Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_icon_box_title' => 'color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_icon_box_title'
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Space Between Icon and Title', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '(desktop){{WRAPPER}}.icon_position_left .organium_icon_box_item .organium_icon_container' => 'margin-right: {{title_margin.SIZE}}{{title_margin.UNIT}};',
                    '(desktop){{WRAPPER}}.icon_position_right .organium_icon_box_item .organium_icon_container' => 'margin-left: {{title_margin.SIZE}}{{title_margin.UNIT}};',
                    '(desktop){{WRAPPER}}.icon_position_top .organium_icon_box_item .organium_icon_container' => 'margin-bottom: {{title_margin.SIZE}}{{title_margin.UNIT}};',
                    '(tablet){{WRAPPER}} .organium_icon_box_item .organium_icon_container' => 'margin-bottom: {{title_margin_tablet.SIZE}}{{title_margin_tablet.UNIT}}; margin-left: 0!important; margin-right: 0!important;',
                    '(mobile){{WRAPPER}} .organium_icon_box_item .organium_icon_container' => 'margin-bottom: {{title_margin_mobile.SIZE}}{{title_margin_mobile.UNIT}}; margin-left: 0!important; margin-right: 0!important;',
                ]
            ]
        );

        $this->end_controls_section();




        // ---------------------------------------- //
        // ---------- Info Text Settings ---------- //
        // ---------------------------------------- //
        $this->start_controls_section(
            'text_settings',
            [
                'label' => esc_html__('Information Text Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'info_color',
            [
                'label' => esc_html__('Information Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_info_container' => 'color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'info_typography',
                'label' => esc_html__('Information Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_info_container',
                'condition' => [
                    'info_type' => 'info'
                ]
            ]
        );

        $this->add_responsive_control(
            'info_margin',
            [
                'label' => esc_html__('Space Between Title and Text', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_info_container' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();




        // -------------------------------------------- //
        // ---------- Social Button Settings ---------- //
        // -------------------------------------------- //
        $this->start_controls_section(
            'socials_settings',
            [
                'label' => esc_html__('Social Button Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'info_type' => 'socials'
                ]
            ]
        );

        $this->add_responsive_control(
            'socials_size',
            [
                'label' => esc_html__('Social Icons Size', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_icon_box_socials li a' => 'font-size: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'info_type' => 'socials'
                ]
            ]
        );

        $this->start_controls_tabs('social_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'socials_normal',
                [
                    'label' => esc_html__('Normal', 'organium_plugin'),
                    'condition' => [
                        'info_type' => 'socials'
                    ]
                ]
            );

                $this->add_control(
                    'social_color',
                    [
                        'label' => esc_html__('Social Button Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_info_container' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'info_type' => 'socials'
                        ]
                    ]
                );

                $this->add_control(
                    'social_bg',
                    [
                        'label' => esc_html__('Social Button Background', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_info_container' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'info_type' => 'socials'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'socials_hover',
                [
                    'label' => esc_html__('Hover', 'organium_plugin'),
                    'condition' => [
                        'info_type' => 'socials'
                    ]
                ]
            );

                $this->add_control(
                    'social_hover',
                    [
                        'label' => esc_html__('Social Button Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_info_container' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'info_type' => 'socials'
                        ]
                    ]
                );

                $this->add_control(
                    'social_bg_hover',
                    [
                        'label' => esc_html__('Social Button Background', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_info_container' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'info_type' => 'socials'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $icon_type = $settings['icon_type'];
        $default_icon = $settings['default_icon'];
        $svg_icon = $settings['svg_icon'];
        $text_icon = $settings['text_icon'];

        $bg_image_status = $settings['bg_image_status'];
        $background_type = $settings['background_type'];
        if ($bg_image_status == 'yes') {
            if ( $background_type == 'svg' ) {
                $svg_background = $settings['svg_background'];
            }
            if ( $background_type == 'image' ) {
                $bg_image = !empty($settings['bg_image']['url']) ? $settings['bg_image'] : array();
                $bg_image_hover = !empty($settings['bg_image_hover']['url']) ? $settings['bg_image_hover'] : array();
            }
        }

        $title = $settings['title'];
        $info_type = $settings['info_type'];
        $info = $settings['info'];
        $socials = $settings['socials'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="organium_icon_box_widget">
            <div class="organium_icon_box_item">

                <div class="organium_icon_container<?php echo (!empty($background_type) ? ' background_type_' . esc_attr($background_type) : '') ?>">
                    <?php
                    if ($icon_type == 'default') {
                        echo '<i class="' . esc_attr($default_icon['value']) . '"></i>';
                    }
                    if ($icon_type == 'svg') {
                        echo '<span class="icon">' . organium_output_code($svg_icon) . '</span>';
                    }
                    if ($icon_type == 'text') {
                        echo '<span class="text">' . esc_html($text_icon) . '</span>';
                    }

                    if ($bg_image_status == 'yes') {
                        if ($background_type == 'image') {
                            if (!empty($bg_image_hover['url'])) {
                                echo '<img class="organium_bg_image_hover" src="' . esc_url($bg_image_hover['url']) . '" alt="' . esc_html__('Background Image on Hover', 'organium_plugin') . '" />';
                            }
                            if (!empty($bg_image['url'])) {
                                echo '<img class="organium_bg_image" src="' . esc_url($bg_image['url']) . '" alt="' . esc_html__('Background Image', 'organium_plugin') . '" />';
                            }
                        }
                        if ($background_type == 'svg' && !empty($svg_background)) {
                            echo '<span class="background">' . organium_output_code($svg_background) . '</span>';
                        }
                    }
                    ?>
                </div>

                <div class="organium_icon_box_content">
                    <?php
                    if ($title !== '') {
                        echo '<h6 class="organium_icon_box_title">' . organium_output_code($title) . '</h6>';
                    }
                    ?>

                    <div class="organium_info_container">
                        <?php
                        if ($info_type == 'info') {
                            if ($info !== '') {
                                echo '<p>' . organium_output_code($info) . '</p>';
                            }
                        } else {
                            if (!empty($socials)) {
                                ?>
                                <ul class="organium_icon_box_socials">
                                    <?php
                                    foreach ($socials as $social) {
                                        if ($social['social_link']['url'] !== '') {
                                            $social_url = $social['social_link']['url'];
                                        } else {
                                            $social_url = '#';
                                        }
                                        ?>

                                        <li>
                                            <a href="<?php echo esc_url($social_url); ?>" <?php echo (($social['social_link']['is_external'] == true) ? 'target="_blank"' : ''); echo (($social['social_link']['nofollow'] == 'on') ? 'rel="nofollow"' : ''); ?>><i class="<?php echo esc_attr($social['social_icon']['value']); ?>"></i></a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}