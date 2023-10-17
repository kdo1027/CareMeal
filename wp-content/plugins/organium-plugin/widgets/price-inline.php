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

class Organium_Price_Inline_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_price_inline';
    }

    public function get_title() {
        return esc_html__('Inline Price', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-product-price';
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
                'label' => esc_html__('Inline Price', 'organium_plugin')
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

        $this->add_responsive_control(
            'align',
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
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .organium_price_inline_widget' => 'text-align: {{VALUE}};',
                ]
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
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'label' => esc_html__('Price Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_price, {{WRAPPER}} .organium_currency',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Price Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_price_container' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'period_typography',
                'label' => esc_html__('Period Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_period',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'period_color',
            [
                'label' => esc_html__('Period Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_period' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $currency = $settings['currency'];
        $currency_position = $settings['currency_position'];
        $price = $settings['price'];
        $period = $settings['period'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="organium_price_inline_widget">
            <?php
            if ($price !== '') {
                if ($currency !== '') {
                    if ($currency_position == 'before') {
                        echo '<span class="organium_currency">' . esc_html($currency) . '</span>';
                    }
                }
                echo '<span class="organium_price">' . esc_html($price) . '</span>';
                if ($currency !== '') {
                    if ($currency_position == 'after') {
                        echo '<span class="organium_currency">' . esc_html($currency) . '</span>';
                    }
                }
                if ($period !== '') {
                    echo '<span class="organium_period">' . esc_html($period) . '</span>';
                }
            }
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}