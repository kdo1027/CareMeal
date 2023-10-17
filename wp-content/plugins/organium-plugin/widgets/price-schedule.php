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

class Organium_Price_Schedule_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_price_schedule';
    }

    public function get_title() {
        return esc_html__('Price Schedule', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-price-list';
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
                'label' => esc_html__('Price Schedule', 'organium_plugin')
            ]
        );



        $this->add_control(
            'price_items',
            [
                'label' => esc_html__('Price Items', 'organium_plugin'),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'title' => '',
                        'description' => '',
                        'currency' => '',
                        'currency_position' => 'before',
                        'price' => '',
                        'period' => '',
                        'price_button_text' => '',
                        'button_link' => [
                            'url' => '#'
                        ],
                    ]
                ],
                'fields' => [
                    [
                        'name' => 'title',
                        'label' => esc_html__( 'Title', 'organium_plugin' ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'placeholder' => esc_html__( 'Enter Title', 'organium_plugin' ),
                        'default' => ''
                    ],

                    [
                        'name' => 'description',
                        'label' => esc_html__( 'Description', 'organium_plugin' ),
                        'type' => Controls_Manager::TEXTAREA,
                        'label_block' => true,
                        'placeholder' => esc_html__( 'Enter description', 'organium_plugin' ),
                    ],

                    [
                        'name' => 'currency',
                        'label' => esc_html__( 'Currency', 'organium_plugin' ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'placeholder' => '$',
                    ],

                    [
                        'name' => 'currency_position',
                        'label' => esc_html__( 'Currency Position', 'organium_plugin' ),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'before',
                        'options' => [
                            'before' => esc_html__('Before Price', 'organium_plugin'),
                            'after' => esc_html__('After Price', 'organium_plugin')
                        ]
                    ],

                    [
                        'name' => 'price',
                        'label' => esc_html__( 'Price', 'organium_plugin' ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                    ],

                    [
                        'name' => 'period',
                        'label' => esc_html__( 'Period', 'organium_plugin' ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'placeholder' => esc_html__('month', 'organium_plugin')
                    ],

                    [
                        'name' => 'price_button_text',
                        'label' => esc_html__( 'Button Text', 'organium_plugin' ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => esc_html__('Get Started', 'organium_plugin'),
                        'placeholder' => esc_html__('Button Text', 'organium_plugin'),
                    ],

                    [
                        'name' => 'button_link',
                        'label' => esc_html__( 'Link', 'organium_plugin' ),
                        'type' => Controls_Manager::URL,
                        'label_block' => true,
                        'default' => [
                            'url' => '#',
                        ],
                        'placeholder' => esc_url('http://your-link.com'),
                    ],
                ],
                'title_field' => '{{{title}}}',
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // ----------------------------------------- //
        // ---------- Price Item Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Price Schedule Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
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
                    'item_bg',
                    [
                        'label' => esc_html__('Item Background', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'item_divider_color',
                    [
                        'label' => esc_html__('Divider Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item td' => 'border-color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'item_shadow',
                        'label' => esc_html__( 'Item Shadow', 'elementory' ),
                        'selector' => '{{WRAPPER}} .organium_price_schedule_item',
                        'separator' => 'before'
                    ]
                );

            $this->end_controls_tab();

            // ------------------------ //
            // ------- Hover Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_item_hover',
                [
                    'label' => esc_html__('Hover', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'item_hover_bg',
                    [
                        'label' => esc_html__('Item Background on Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item:hover' => 'background-color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_control(
                    'item_hover_divider_color',
                    [
                        'label' => esc_html__('Divider Color on Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item:hover td, {{WRAPPER}} .organium_price_schedule_item:hover td + td' => 'border-color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'item_hover_shadow',
                        'label' => esc_html__( 'Item Shadow on Hover', 'elementory' ),
                        'selector' => '{{WRAPPER}} .organium_price_schedule_item:hover',
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
                'label' => esc_html__('Content Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_price_title'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'label' => esc_html__('Price Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_price, {{WRAPPER}} .organium_currency'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'period_typography',
                'label' => esc_html__('Period Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_period'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__('Description Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_price_description_container',
                'separator' => 'after'
            ]
        );

        $this->start_controls_tabs('content_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_content_normal',
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
                            '{{WRAPPER}} .organium_price_schedule_item .organium_price_title' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after'
                    ]
                );

                $this->add_control(
                    'price_color',
                    [
                        'label' => esc_html__('Price Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item .organium_price_container' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after'
                    ]
                );

                $this->add_control(
                    'description_color',
                    [
                        'label' => esc_html__('Description Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item .organium_price_description_container' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ------------------------ //
            // ------- Hover Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_content_hover',
                [
                    'label' => esc_html__('Hover', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'title_hover_color',
                    [
                        'label' => esc_html__('Title Color on Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item:hover .organium_price_title' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after'
                    ]
                );

                $this->add_control(
                    'price_hover_color',
                    [
                        'label' => esc_html__('Price Color on Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item:hover .organium_price_container' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after'
                    ]
                );

                $this->add_control(
                    'description_hover_color',
                    [
                        'label' => esc_html__('Description Color on Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item:hover .organium_price_description_container' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // ------------------------------------- //
        // ---------- Button Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'section_button_settings',
            [
                'label' => esc_html__('Button Settings', 'organium_plugin'),
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
                        'label' => esc_html__('Button Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item:not(:hover) .organium_button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_bg',
                    [
                        'label' => esc_html__('Button Background', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item:not(:hover) .organium_button' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow',
                        'selector' => '{{WRAPPER}} .organium_price_schedule_item:not(:hover) .organium_button',
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_button_active',
                [
                    'label' => esc_html__('Hover Item', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'button_color_active',
                    [
                        'label' => esc_html__('Button Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item:hover .organium_button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_bg_active',
                    [
                        'label' => esc_html__('Button Background', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item:hover .organium_button' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow_active',
                        'selector' => '{{WRAPPER}} .organium_price_schedule_item:hover .organium_button',
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
                    'button_color_hover',
                    [
                        'label' => esc_html__('Button Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item .organium_button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_bg_hover',
                    [
                        'label' => esc_html__('Button Background Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_price_schedule_item .organium_button:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow_hover',
                        'selector' => '{{WRAPPER}} .organium_price_schedule_item .organium_button:hover',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'button_radius',
            [
                'label' => esc_html__('Border Radius', 'organium_plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .organium_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator' => 'before'
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
    }

    protected function render() {
        $settings = $this->get_settings();

        $price_items = $settings['price_items'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <?php if (!empty($price_items)) {  ?>
            <div class="organium_price_schedule_widget">
                <table class="organium_price_schedule_table">
                    <tbody>
                    <?php foreach ($price_items as $item) { ?>
                        <tr class="organium_price_schedule_item">
                            <?php
                                if ( !empty($item['title']) ) {
                                    echo '<td class="organium_price_title_wrapper">';
                                        echo '<h5 class="organium_price_title">' . esc_html($item['title']) . '</h5>';
                                    echo '</td>';
                                }

                                if ( !empty($item['description']) ) {
                                    echo '<td class="organium_price_description_container">';
                                        echo esc_html($item['description']);
                                    echo '</td>';
                                }

                                if ( !empty($item['price']) ) {
                                    echo '<td class="organium_price_container organium_currency_position_' . esc_attr($item['currency_position']) . '">';
                                        echo '<div class="organium_price_wrapper">';
                                            if ( !empty($item['currency']) && $item['currency_position'] == 'before' ) {
                                                echo '<span class="organium_currency">' . esc_html($item['currency']) . '</span>';
                                            }
                                            echo '<span class="organium_price">' . esc_html($item['price']) . '</span>';
                                            if ( !empty($item['currency']) && $item['currency_position'] == 'after' ) {
                                                echo '<span class="organium_currency">' . esc_html($item['currency']) . '</span>';
                                            }
                                        echo '</div>';
                                        if ( !empty($item['period']) ) {
                                            echo '<div class="organium_period">' . esc_html($item['period']) . '</div>';
                                        }
                                    echo '</td>';
                                }

                                if ( !empty($item['button_link']['url']) ) {
                                    $button_url = $item['button_link']['url'];
                                } else {
                                    $button_url = '#';
                                }
                                if ( !empty($item['button_link']) && !empty($item['price_button_text']) ) {
                                    echo '<td class="organium_price_button_container">';
                                        echo '<a class="organium_button" href="' . esc_url($button_url) . '" ' . ( ($item['button_link']['is_external'] == true) ? 'target="_blank"' : '' ) . ( ( $item['button_link']['nofollow'] == 'on' ) ? 'rel="nofollow"' : '') . '>' . esc_html($item['price_button_text']) . '</a>';
                                    echo '</td>';
                                }

                            ?>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}