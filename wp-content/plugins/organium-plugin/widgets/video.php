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

class Organium_Video_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_video';
    }

    public function get_title() {
        return esc_html__('Video', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-play';
    }

    public function get_categories() {
        return ['organium_widgets'];
    }

    public function get_script_depends() {
        return ['video_widget'];
    }

    protected function _register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Video', 'organium_plugin')
            ]
        );

        $this->add_control(
            'video_link',
            [
                'label' => esc_html__('Enter Video Link', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => '',
                'default' => '',
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'organium_plugin'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_control(
            'image_style',
            [
                'label'   => esc_html__('Image Style', 'organium_plugin'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'organium_plugin'),
                    'framed'  => esc_html__('Framed', 'organium_plugin')
                ]
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Play Button Text', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter Play Button Text', 'organium_plugin'),
                'default' => esc_html__('Watch Our Video', 'organium_plugin'),
            ]
        );

        $this->end_controls_section();

        // ------------------------------------ //
        // ---------- Video Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Video Widget Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'video_height',
            [
                'label' => esc_html__('Video Height', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_preview_container' => 'height: {{SIZE}}{{UNIT}}; padding: 0;'
                ]
            ]
        );

        $this->add_responsive_control(
            'video_width',
            [
                'label' => esc_html__('Video Width', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_preview_container' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'frame_color',
            [
                'label' => esc_html__('Frame Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_image_style_framed:before' => 'border-color: {{VALUE}};'
                ],
                'condition' => [
                    'image_style' => 'framed'
                ]
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label' => esc_html__('Overlay Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_overlay' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'overlay_opacity',
            [
                'label' => esc_html__('Overlay Opacity', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => .01
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_overlay' => 'opacity: {{SIZE}};'
                ]
            ]
        );

        $this->add_control(
            'icon_button_size',
            [
                'label' => esc_html__('Trigger Button Size', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_button_icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .organium_button_icon i' => 'line-height: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_button_icon i' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Button Text Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_button_text'
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
                    'icon_color',
                    [
                        'label' => esc_html__('Icon Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_video_trigger_button .organium_button_icon' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'icon_bg',
                    [
                        'label' => esc_html__('Icon Background', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_video_trigger_button .organium_button_icon:before' => 'background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_text_color',
                    [
                        'label' => esc_html__('Button Text Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_video_trigger_button .organium_button_text' => 'color: {{VALUE}};'
                        ]
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
                    'icon_hover',
                    [
                        'label' => esc_html__('Icon Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_video_trigger_button:hover .organium_button_icon' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'icon_bg_hover',
                    [
                        'label' => esc_html__('Icon Background Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_video_trigger_button:hover .organium_button_icon:before' => 'background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_text_hover',
                    [
                        'label' => esc_html__('Button Text Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_video_trigger_button:hover .organium_button_text' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $video_link = $settings['video_link'];
        $image = $settings['image'];
        $button_text = $settings['button_text'];
        $image_style = $settings['image_style'];


        $image_src = $image['url'];

        if ($image_src == false) {
            $image_src = $image['url'];
        }

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        $image_meta = organium_get_attachment_meta($image['id']);
        $image_alt = $image_meta['alt'];

        ?>

        <div class="organium_video_widget">
            <div class="organium_preview_container<?php echo ( !empty($image_style) ? ' organium_image_style_' . esc_attr($image_style) : ''); ?>">
                <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($image_alt); ?>" />
                <div class="organium_overlay"></div>
                <a class="organium_video_trigger_button" href="<?php echo esc_js('javascript:void(0)'); ?>">
                    <span class="organium_button_icon"><i class="fa fa-play"></i></span>
                    <?php
                    if ($button_text !== '') {
                        ?>
                        <span class="organium_button_text"><?php echo esc_html($button_text); ?></span>
                        <?php
                    }
                    ?>
                </a>
            </div>

            <?php
            if ($video_link !== '') {
                ?>
                <div class="organium_video_container">
                    <div class="organium_close_popup_layer">
                        <div class="organium_close_button">
                            <svg viewBox="0 0 40 40"><path d="M10,10 L30,30 M30,10 L10,30"></path></svg>
                        </div>
                    </div>
                    <div class="organium_video_wrapper" data-src="<?php echo esc_url($video_link); ?>"></div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
