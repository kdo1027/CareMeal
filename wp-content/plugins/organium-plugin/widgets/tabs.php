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

class Organium_Tabs_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_tabs';
    }

    public function get_title() {
        return esc_html__('Tabs', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-tabs';
    }

    public function get_categories() {
        return ['organium_widgets'];
    }

    public function get_script_depends() {
        return ['tabs_widget'];
    }

    protected function _register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Tabs', 'organium_plugin')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Tab Title', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Tab', 'organium_plugin'),
                'placeholder' => esc_html__('Enter Tab Title', 'organium_plugin')
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

        $repeater->add_control(
            'content_type',
            [
                'label' => esc_html__('Content Type', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text' => esc_html__('Text', 'organium_plugin'),
                    'gallery' => esc_html__('Gallery', 'organium_plugin'),
                    'video' => esc_html__('Video', 'organium_plugin')
                ]
            ]
        );

        $repeater->add_control(
            'text',
            [
                'label' => esc_html__('Tab Content', 'organium_plugin'),
                'type' => Controls_Manager::WYSIWYG,
                'condition' => [
                    'content_type' => 'text'
                ]
            ]
        );

        $repeater->add_control(
            'gallery',
            [
                'label' => esc_html__('Add Images', 'elementory'),
                'type' => Controls_Manager::GALLERY,
                'default' => [],
                'condition' => [
                    'content_type' => 'gallery'
                ]
            ]
        );

        $repeater->add_control(
            'video_link',
            [
                'label' => esc_html__('Enter Video Link', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => '',
                'default' => '',
                'condition' => [
                    'content_type' => 'video'
                ]
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Preview Image', 'organium_plugin'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'content_type' => 'video'
                ]
            ]
        );

        $repeater->add_control(
            'button_text',
            [
                'label' => esc_html__('Play Button Text', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter Play Button Text', 'organium_plugin'),
                'default' => esc_html__('', 'organium_plugin'),
                'condition' => [
                    'content_type' => 'video'
                ]
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__('Tabs', 'organium_plugin'),
                'type' => Controls_Manager::REPEATER,
                'default' => [],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{title}}}',
                'prevent_empty' => false
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

        $this->add_control(
            'content_text_color',
            [
                'label' => esc_html__('Text Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_tab_text_container' => 'color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'content_text_accent',
            [
                'label' => esc_html__('Text Accent Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_tab_text_container blockquote:before, {{WRAPPER}} .organium_tab_text_container p a:not(:hover)' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .organium_tab_text_container ul li:before, {{WRAPPER}} .organium_tab_text_container ol li:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'content_text_hover',
            [
                'label' => esc_html__('Text Link Color on Hover', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_tab_text_container p a:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Text Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_content_text_settings',
            [
                'label' => esc_html__('Text Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => esc_html__('Text Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_tab_text_container'
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_tab_text_container' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        // -------------------------------------- //
        // ---------- Gallery Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'section_content_gallery_settings',
            [
                'label' => esc_html__('Gallery Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 4,
                'options' => [
                    2 => esc_html__('Two Columns', 'organium_plugin'),
                    3 => esc_html__('Three Columns', 'organium_plugin'),
                    4 => esc_html__('Four Columns', 'organium_plugin')
                ]
            ]
        );

        $this->add_control(
            'items_padding',
            [
                'label' => esc_html__('Spaces Between Items', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_tab_gallery_container' => 'margin-left: -{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .organium_tab_gallery_item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'gallery_radius',
            [
                'label' => esc_html__('Images Border Radius', 'organium_plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .organium_tab_gallery_wrapper a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'gallery_color',
            [
                'label' => esc_html__('Overlay Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_tab_gallery_wrapper a:before' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------ //
        // ---------- Video Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'section_content_video_settings',
            [
                'label' => esc_html__('Video Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
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
                            '{{WRAPPER}} .organium_video_trigger_button .organium_button_icon' => 'background: {{VALUE}};'
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
                            '{{WRAPPER}} .organium_video_trigger_button:hover .organium_button_icon' => 'background: {{VALUE}};'
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

        $tabs = $settings['tabs'];
        $columns = $settings['columns'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="organium_tabs_widget">
            <div class="organium_tabs_titles_container">
                <?php
                $i = 1;

                foreach ($tabs as $tab) {
                    ?>
                    <div class="organium_tab_title_item" data-id="organium_tab_id_<?php echo esc_attr($i); ?>">
                        <a href="<?php echo esc_js('javascript:void(0)'); ?>"><?php echo esc_html($tab['title']); ?></a>
                    </div>
                    <?php

                    $i++;
                }
                ?>
            </div>

            <div class="organium_tabs_content_container">
                <?php
                $i = 1;

                foreach ($tabs as $tab) {
                    ?>
                    <div class="organium_tab_content_item" id="organium_tab_id_<?php echo esc_attr($i); ?>">
                        <?php
                        // ----------------- //
                        // --- Text Type --- //
                        // ----------------- //
                        if ($tab['content_type'] == 'text') {
                            ?>
                            <div class="organium_tab_text_container">
                                <?php
                                echo organium_output_code($tab['text']);
                                ?>
                            </div>
                            <?php
                        }

                        // ------------------ //
                        // --- Video Type --- //
                        // ------------------ //
                        if ($tab['content_type'] == 'video') {
                            ?>
                            <div class="organium_tab_video_container">
                                <div class="organium_preview_container">
                                    <img src="<?php echo esc_url($tab['image']['url']); ?>" alt="<?php echo esc_html__('Video Preview Image', 'organium_plugin'); ?>" />
                                    <div class="organium_overlay"></div>
                                    <a class="organium_video_trigger_button" href="<?php echo esc_js('javascript:void(0)'); ?>">
                                        <span class="organium_button_icon"><i class="fa fa-play"></i></span>
                                        <?php
                                        if ($tab['button_text'] !== '') {
                                            ?>
                                            <span class="organium_button_text"><?php echo esc_html($tab['button_text']); ?></span>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </div>

                                <?php
                                if ($tab['video_link'] !== '') {
                                    ?>
                                    <div class="organium_video_container">
                                        <div class="organium_close_popup_layer">
                                            <div class="organium_close_button">
                                                <svg viewBox="0 0 40 40"><path d="M10,10 L30,30 M30,10 L10,30"></path></svg>
                                            </div>
                                        </div>
                                        <div class="organium_video_wrapper" data-src="<?php echo esc_url($tab['video_link']); ?>"></div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }

                        // -------------------- //
                        // --- Gallery Type --- //
                        // -------------------- //
                        if ($tab['content_type'] == 'gallery') {
                            ?>
                            <div class="organium_tab_gallery_container organium_columns_<?php echo esc_attr($columns); ?>">
                                <?php
                                foreach ($tab['gallery'] as $image) {
                                    $image_url = $image['url'];
                                    $image_meta = organium_get_attachment_meta($image['id']);
                                    $image_alt_text = $image_meta['alt'];

                                    if ($columns == 2) {
                                        $image_src = aq_resize(esc_url($image_url), 960, 960, true, true, true);
                                    }

                                    if ($columns == 3) {
                                        $image_src = aq_resize(esc_url($image_url), 640, 640, true, true, true);
                                    }

                                    if ($columns == 4) {
                                        $image_src = aq_resize(esc_url($image_url), 480, 480, true, true, true);
                                    }
                                    ?>
                                    <div class="organium_tab_gallery_item">
                                        <div class="organium_tab_gallery_wrapper">
                                            <a href="<?php echo esc_url($image_url); ?>" data-fancybox="simple-gallery" data-elementor-open-lightbox="no">
                                                <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($image_alt_text); ?>" />
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php

                    $i++;
                }
                ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
