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

class Organium_Price_Item_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_price_item';
    }

    public function get_title() {
        return esc_html__('Price Item', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-price-table';
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
                'label' => esc_html__('Price Item', 'organium_plugin')
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => ''
            ]
        );

        $this->add_control(
            'active_block_status',
            [
                'label' => esc_html__('Highlight this block?', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('No', 'organium_plugin'),
                'label_on' => esc_html__('Yes', 'organium_plugin'),
                'default' => 'no'
            ]
        );

        $this->add_control(
            'currency',
            [
                'label' => esc_html__('Currency', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => '$',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'currency_position',
            [
                'label' => esc_html__('Currency Position', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'before',
                'options' => [
                    'before' => esc_html__('Before Price', 'organium_plugin'),
                    'after' => esc_html__('After Price', 'organium_plugin')
                ]
            ]
        );

        $this->add_control(
            'price',
            [
                'label' => esc_html__('Price', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => ''
            ]
        );

        $this->add_control(
            'period',
            [
                'label' => esc_html__('Period', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('month', 'organium_plugin')
            ]
        );

        $this->add_control(
            'custom_fields',
            [
                'label' => esc_html__('Custom Fields', 'organium_plugin'),
                'type' => Controls_Manager::REPEATER,
                'default' => [],
                'fields' => [
                    [
                        'name' => 'text',
                        'label' => esc_html__( 'Text', 'organium_plugin' ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => '',
                        'placeholder' => esc_html__( 'Enter Text', 'organium_plugin' ),
                    ],

                    [
                        'name' => 'active_field_status',
                        'label' => esc_html__( 'Active Field', 'organium_plugin' ),
                        'type' => Controls_Manager::SWITCHER,
                        'label_off' => esc_html__('No', 'organium_plugin'),
                        'label_on' => esc_html__('Yes', 'organium_plugin'),
                        'default' => 'yes'
                    ]
                ],
                'title_field' => '{{{text}}}',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'price_button_text',
            [
                'label' => esc_html__('Button Text', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Get Started', 'organium_plugin'),
                'placeholder' => esc_html__('Button Text', 'organium_plugin'),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Link', 'organium_plugin'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_url('http://your-link.com'),
                'default' => [
                    'url' => '#',
                ]
            ]
        );

        $this->end_controls_section();

        // ----------------------------------------- //
        // ---------- Price Item Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Price Item Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'content_width',
            [
                'label' => esc_html__('Content Area Width', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 150,
                        'max' => 450
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_custom_fields_container' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'item_padding',
            [
                'label' => esc_html__('Price Item Padding', 'organium_plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .organium_price_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'item_bg',
            [
                'label' => esc_html__('Price Item Background', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_price_item:before' => 'background-color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'item_active_bg',
            [
                'label' => esc_html__('Highlighted Price Item Background', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_price_item.active:before' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'item_radius',
            [
                'label' => esc_html__('Price Item Border Radius', 'organium_plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .organium_price_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__( 'Price Item Border', 'elementory' ),
                'placeholder' => '2px',
                'default' => '2px',
                'selector' => '{{WRAPPER}} .organium_price_item',
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow',
                'label' => esc_html__( 'Box Shadow', 'elementory' ),
                'selector' => '{{WRAPPER}} .organium_price_item:before',
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_active_shadow',
                'label' => esc_html__( 'Highlighted Box Shadow', 'elementory' ),
                'selector' => '{{WRAPPER}} .organium_price_item.active:before',
            ]
        );

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

        $this->add_control(
            'title_margin',
            [
                'label' => esc_html__('Space After Title', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_price_title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
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

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_price_title' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'price_margin',
            [
                'label' => esc_html__('Space After Price', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_price_container' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
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

        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Price Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_price_container' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'fields_margin',
            [
                'label' => esc_html__('Space Between Custom Fields', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_custom_field' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'fields_typography',
                'label' => esc_html__('Custom Fields Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_custom_field'
            ]
        );

        $this->add_control(
            'fields_color',
            [
                'label' => esc_html__('Custom Fields Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_custom_field' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'active_fields_color',
            [
                'label' => esc_html__('Active Fields Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_custom_field.organium_active_field' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'active_fields_icon_color',
            [
                'label' => esc_html__('Active Fields Icon Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_custom_field.organium_active_field:before' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

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

        $this->add_control(
            'button_margin',
            [
                'label' => esc_html__('Space Before Button', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_price_button_container' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
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
                            '{{WRAPPER}} .organium_button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_bg',
                    [
                        'label' => esc_html__('Button Background', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_button' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow',
                        'selector' => '{{WRAPPER}} .organium_button',
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
                            '{{WRAPPER}} .organium_button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_bg_hover',
                    [
                        'label' => esc_html__('Button Background Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_button:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow_hover',
                        'selector' => '{{WRAPPER}} .organium_button:hover',
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

        $title = $settings['title'];
        $active_block_status = $settings['active_block_status'];
        $currency = $settings['currency'];
        $currency_position = $settings['currency_position'];
        $price = $settings['price'];
        $period = $settings['period'];
        $custom_fields = $settings['custom_fields'];
        $price_button_text = $settings['price_button_text'];
        $button_link = $settings['button_link'];

        if ($button_link['url'] !== '') {
            $button_url = $button_link['url'];
        } else {
            $button_url = '#';
        }

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="organium_price_item_widget">
            <div class="organium_price_item<?php echo ($active_block_status == 'yes' ? ' active' : ''); ?>">
                <div class="organium_price_item_inner">
                    <?php
                    if ($title !== '') {
                        ?>
                        <h5 class="organium_price_title"><?php echo esc_html($title); ?></h5>
                        <?php
                    }

                    if ($price !== '') {
                        ?>
                        <div class="organium_price_container organium_currency_position_<?php echo esc_attr($currency_position); ?>">
                            <div class="organium_price_wrapper">
                                <?php
                                if ($currency !== '') {
                                    if ($currency_position == 'before') {
                                        ?>
                                        <span class="organium_currency"><?php echo esc_html($currency); ?></span>
                                        <?php
                                    }
                                }
                                ?>

                                <span class="organium_price"><?php echo esc_html($price); ?></span>

                                <?php
                                if ($currency !== '') {
                                    if ($currency_position == 'after') {
                                        ?>
                                        <span class="organium_currency"><?php echo esc_html($currency); ?></span>
                                        <?php
                                    }
                                }
                                ?>
                            </div>

                            <?php
                            if ($period !== '') {
                                ?>
                                <div class="organium_period"><?php echo esc_html($period); ?></div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }

                    if (!empty($custom_fields)) {
                        ?>
                        <div class="organium_custom_fields_container">
                            <?php
                            foreach ($custom_fields as $field) {
                                if ($field['active_field_status'] == 'yes') {
                                    $field_status_class = 'organium_active_field';
                                } else {
                                    $field_status_class = '';
                                }
                                ?>

                                <div class="organium_custom_field <?php echo esc_attr($field_status_class); ?>"><?php echo esc_html($field['text']); ?></div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="organium_price_button_container">
                        <a class="organium_button" href="<?php echo esc_url($button_url); ?>" <?php echo (($button_link['is_external'] == true) ? 'target="_blank"' : ''); echo (($button_link['nofollow'] == 'on') ? 'rel="nofollow"' : ''); ?>><?php echo esc_html($price_button_text); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}