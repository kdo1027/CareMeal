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

class Organium_Wpforms_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_wpforms';
    }

    public function get_title() {
        return esc_html__('WPForms', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function is_reload_preview_required() {
        return true;
    }

    public function get_categories() {
        return ['organium_widgets'];
    }

    protected function _register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_display_form',
            [
                'label' => esc_html__('Display Form', 'organium_plugin')
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

        $forms = wpforms()->form->get();
        $form_list_default = [
            'default' => esc_html__('Select your form', 'organium_plugin')
        ];
        $form_list = [];
        if ( !empty( $forms ) ) {
            foreach ($forms as $key => $form) {
                $form_list[$form->post_title] = $form->post_title;
            }
            $form_list = array_merge($form_list_default, $form_list);
        } else {
            $form_list['default'] = esc_html__('No forms', 'organium_plugin');
        }
        $this->add_control(
            'form',
            [
                'label'   => esc_html__('Form', 'organium_plugin'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => $form_list
            ]
        );

        $this->add_control(
            'add_name',
            [
                'label' => esc_html__('Display form name', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_off' => esc_html__('No', 'organium_plugin'),
                'label_on' => esc_html__('Yes', 'organium_plugin')
            ]
        );

        $this->add_control(
            'add_description',
            [
                'label' => esc_html__('Display form description', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_off' => esc_html__('No', 'organium_plugin'),
                'label_on' => esc_html__('Yes', 'organium_plugin')
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
                    '{{WRAPPER}} .organium_wpforms_widget' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before',
                'prefix_class' => 'alignment%s-'
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        $title = $settings['title'];
        $add_name = $settings['add_name'];
        $add_description = $settings['add_description'];
        $shortcode_attr = '';

        $form_id = '';
        $form_name = $settings['form'];

        $forms = wpforms()->form->get();
        if ( !empty( $forms ) ) {
            foreach ($forms as $key => $form) {
                if ($form->post_title == $form_name) {
                    $form_id = $form->ID;
                }
            }

            if (!empty($form_id)) {
                $shortcode_attr .= ' id="' . esc_attr($form_id) . '"';
            }
            if ($add_name == 'yes') {
                $shortcode_attr .= ' title="true"';
            }
            if ($add_description == 'yes') {
                $shortcode_attr .= ' description="true"';
            }
        }

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>
        <div class="organium_wpforms_widget">
            <?php
                if ( !empty($title) ) {
                    echo '<h5>' . esc_html($title) . '</h5>';
                }
                if ( !empty($form_id) ) {
                    $shortcode = '[wpforms' . $shortcode_attr . ']';
                    echo do_shortcode($shortcode);
                }
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
