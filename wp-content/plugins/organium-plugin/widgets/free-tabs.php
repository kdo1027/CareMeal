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
use Elementor\Control_Choose;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Organium_Free_Tabs_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_free_tabs';
    }

    public function get_title() {
        return esc_html__('Free Tabs', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-tabs';
    }

    public function get_categories() {
        return ['organium_widgets'];
    }

    public function get_script_depends() {
        return ['free_tabs_widget'];
    }

    protected function _register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'tabs_controls',
            [
                'label' => esc_html__('Tabs Controls', 'organium_plugin'),
                'description' => esc_html__('Create tabs controls and set class and ID of any inner row', 'organium')
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__('Tabs', 'organium_plugin'),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'tab_title' => esc_html__( 'Tab 1', 'organium_plugin' ),
                        'control_id' => ''
                    ]
                ],
                'fields' => [
                    [
                        'name' => 'tab_title',
                        'label' => esc_html__( 'Tab Title', 'organium_plugin' ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'placeholder' => esc_html__( 'Enter Tab Title', 'organium_plugin' ),
                        'default' => ''
                    ],

                    [
                        'name' => 'control_id',
                        'label' => esc_html__( 'Linked Block ID', 'organium_plugin' ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'placeholder' => esc_html__( 'Enter ID', 'organium_plugin' ),
                        'default' => ''
                    ]
                ],
                'title_field' => '{{{tab_title}}}'
            ]
        );

        $this->add_responsive_control(
            'tabs_align',
            [
                'label' => esc_html__('Heading Alignment', 'organium_plugin'),
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
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Tabs Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_controls_settings',
            [
                'label' => esc_html__('Tab Title Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'controls_border',
                'label' => esc_html__( 'Tabs Title Area Border', 'elementory' ),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .organium_tabs_titles_container',
            ]
        );

        $this->add_control(
            'controls_radius',
            [
                'label' => esc_html__('Tabs Title Area Radius', 'organium_plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .organium_tabs_titles_container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'control_item_radius',
            [
                'label' => esc_html__('Tabs Title Radius', 'organium_plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .organium_tabs_titles_container .organium_tab_title_item a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'controls_typography',
                'label' => esc_html__('Tab Title Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_tabs_titles_container .organium_tab_title_item a'
            ]
        );

        $this->start_controls_tabs('controls_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_control_normal',
                [
                    'label' => esc_html__('Normal', 'organium_plugin')
                ]
            );

            $this->add_control(
                'controls_color',
                [
                    'label' => esc_html__('Tab Title Color', 'organium_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .organium_tabs_titles_container .organium_tab_title_item:not(.active) a:not(:hover)' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'controls_bg',
                [
                    'label' => esc_html__('Tab Title Background', 'organium_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .organium_tabs_titles_container .organium_tab_title_item:not(.active) a:not(:hover)' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Active Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_control_active',
                [
                    'label' => esc_html__('Active', 'organium_plugin')
                ]
            );

            $this->add_control(
                'controls_color_active',
                [
                    'label' => esc_html__('Active Tab Title Color', 'organium_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .organium_tabs_titles_container .organium_tab_title_item.active a, {{WRAPPER}} .organium_tabs_titles_container .organium_tab_title_item.active a:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'controls_bg_active',
                [
                    'label' => esc_html__('Active Tab Title Background', 'organium_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .organium_tabs_titles_container .organium_tab_title_item.active a, {{WRAPPER}} .organium_tabs_titles_container .organium_tab_title_item.active a:hover' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_control_hover',
                [
                    'label' => esc_html__('Hover', 'organium_plugin')
                ]
            );

            $this->add_control(
                'controls_color_hover',
                [
                    'label' => esc_html__('Tab Title on Hover', 'organium_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .organium_tabs_titles_container .organium_tab_title_item a:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'controls_bg_hover',
                [
                    'label' => esc_html__('Tab Title Background on Hover', 'organium_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .organium_tabs_titles_container .organium_tab_title_item a:hover' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();
    }

    protected function render() {
        $settings = $this->get_settings();

        $tabs = $settings['tabs'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <?php if (!empty($tabs) && is_array($tabs)) {  ?>
            <div class="organium_free_tabs_widget">
                <div class="organium_tabs_titles_container">
                    <?php
                    foreach ($tabs as $tab) {
                        if ( !empty($tab['control_id']) && !empty($tab['tab_title']) ) {
                            echo '<div class="organium_tab_title_item" data-id="' . esc_attr($tab['control_id']) . '">';
                                echo '<a href="' . esc_js('javascript:void(0)') . '">' . esc_html($tab['tab_title']) . '</a>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        <?php } ?>

        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}