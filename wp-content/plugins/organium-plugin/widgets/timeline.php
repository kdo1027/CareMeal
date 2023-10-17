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

class Organium_Timeline_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_timeline';
    }

    public function get_title() {
        return esc_html__('Timeline', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-time-line';
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
                'label' => esc_html__('Timeline', 'organium_plugin')
            ]
        );

        $this->add_control(
            'items_per_row',
            [
                'label' => esc_html__('Items Per Row', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
                'min' => 1,
                'max' => 5
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'field_date',
            [
                'label' => esc_html__('Field Date', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => esc_html__('Enter Date', 'organium_plugin')
            ]
        );

        $repeater->add_control(
            'field_title',
            [
                'label' => esc_html__('Field Title', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => esc_html__('Enter Title', 'organium_plugin')
            ]
        );

        $repeater->add_control(
            'field_content',
            [
                'label' => esc_html__('Field Content', 'organium_plugin'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'placeholder' => esc_html__('Enter Your Information', 'organium_plugin')
            ]
        );

        $this->add_control(
            'fields',
            [
                'label' => esc_html__('Fields', 'organium_plugin'),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'field_date' => '',
                        'field_title' => '',
                        'field_content' => ''
                    ]
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{field_date}}}',
                'prevent_empty' => false,
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // --------------------------------------- //
        // ---------- Info Box Settings ---------- //
        // --------------------------------------- //
        $this->start_controls_section(
            'section_line_settings',
            [
                'label' => esc_html__('Line Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'item_line_color',
            [
                'label' => esc_html__('Line Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_timeline_item:before, {{WRAPPER}} .organium_timeline_item:after' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'item_dot_color',
            [
                'label' => esc_html__('Dots Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_timeline_dot' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .organium_timeline_dot:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
            'section_date_settings',
            [
                'label' => esc_html__('Date Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'date_typography',
                'label' => esc_html__('Date Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_timeline_date'
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' => esc_html__('Date Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_timeline_date' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
            'section_title_settings',
            [
                'label' => esc_html__('Title Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_timeline_title'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_timeline_title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Space between date and title', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_timeline_title' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();



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
                'name' => 'content_typography',
                'label' => esc_html__('Content Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_timeline_content'
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Content Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_timeline_content' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Space between title and content', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_timeline_content' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        $items_per_row = $settings['items_per_row'];
        $fields = $settings['fields'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="organium_timeline_widget<?php echo ( !empty($items_per_row) ? ' columns_' . esc_attr($items_per_row) : '' ); ?>">
            <?php
            if (!empty($fields)) {
                foreach ($fields as $field) {
                    echo '<div class="organium_timeline_item">';
                        echo '<div class="organium_timeline_dot"></div>';
                        echo '<div class="organium_timeline_date">' . esc_html($field['field_date']) . '</div>';
                        echo '<h6 class="organium_timeline_title">' . wp_kses($field['field_title'], array(
                            'br' => array()
                        )) . '</h6>';
                        echo '<div class="organium_timeline_content">' . organium_output_code($field['field_content']) . '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}