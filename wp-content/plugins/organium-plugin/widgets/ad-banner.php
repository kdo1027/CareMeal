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

class Organium_Ad_Banner_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_ad_banner';
    }

    public function get_title() {
        return esc_html__('Ad Banner', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-banner';
    }

    public function get_categories() {
        return ['organium_widgets'];
    }

    protected function _register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_image',
            [
                'label' => esc_html__('Banner', 'organium_plugin')
            ]
        );

        $this->add_control(
            'view_type',
            [
                'label' => esc_html__('Banner View Type', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'type_1',
                'options' => [
                    'type_1' => esc_html__('View Type 1', 'organium_plugin'),
                    'type_2' => esc_html__('View Type 2', 'organium_plugin')
                ]
            ]
        );

        $this->add_control(
            'bg_image',
            [
                'label' => esc_html__('Choose Background Image', 'organium_plugin'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_responsive_control(
            'banner_align',
            [
                'label' => esc_html__('Banner Alignment', 'organium_plugin'),
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
                    '{{WRAPPER}} .organium_banner_content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter title', 'organium_plugin' ),
                'default' => ''
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => esc_html__('Subtitle', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter subtitle', 'organium_plugin' ),
                'default' => ''
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'organium_plugin'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( 'Enter description', 'organium_plugin' ),
                'default' => ''
            ]
        );

        $this->add_control(
            'banner_link',
            [
                'label' => esc_html__('Banner Link', 'organium_plugin'),
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
            'overlay_status',
            [
                'label' => esc_html__('Banner Overlay', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'organium_plugin'),
                'label_on' => esc_html__('On', 'organium_plugin'),
                'default' => 'no',
                'separator' => 'before'
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

        $this->add_responsive_control(
            'banner_height',
            [
                'label' => esc_html__('Banner height', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_banner_inner' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'banner_paddings',
            [
                'label' => esc_html__('Banner paddings', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_banner_content' => 'padding: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_banner_title'
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Space between title and subtitle', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_banner_subtitle' => 'margin-top: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'label' => esc_html__('Subtitle Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_banner_subtitle',
                'separator' => 'after'
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => esc_html__('Space between subtitle and description', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -50,
                        'max' => 50
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_banner_description' => 'margin-top: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__('Description Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_banner_description',
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
                            '{{WRAPPER}} .organium_banner_title' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after'
                    ]
                );

                $this->add_control(
                    'subtitle_color',
                    [
                        'label' => esc_html__('Subtitle Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_banner_subtitle' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'description_color',
                    [
                        'label' => esc_html__('Description Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_banner_title' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before'
                    ]
                );

                $this->add_control(
                    'frame_color',
                    [
                        'label' => esc_html__('Frame Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_banner_frame' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'view_type' => 'type_2'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_content_hover',
                [
                    'label' => esc_html__('Hover', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'title_color_hover',
                    [
                        'label' => esc_html__('Title Color on Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .organium_banner_title' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after'
                    ]
                );

                $this->add_control(
                    'subtitle_color_hover',
                    [
                        'label' => esc_html__('Subtitle Color on Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .organium_banner_subtitle' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'description_color_hover',
                    [
                        'label' => esc_html__('Description Color on Hove', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .organium_banner_title' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before'
                    ]
                );

                $this->add_control(
                    'frame_color_hover',
                    [
                        'label' => esc_html__('Frame Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .organium_banner_frame' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'view_type' => 'type_2'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // ------------------------------------ //
        // ---------- Overlay Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'section_overlay_settings',
            [
                'label' => esc_html__('Overlay Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'overlay_status' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('overlay_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_overlay_normal',
                [
                    'label' => esc_html__('Normal', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'overlay_bg',
                    [
                        'label' => esc_html__('Overlay Background Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_banner_overlay' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'overlay_status' => 'yes'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_overlay_hover',
                [
                    'label' => esc_html__('Hover', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'title_overlay_hover',
                    [
                        'label' => esc_html__('Overlay Background Color on Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .organium_banner_overlay' => 'background-color: {{VALUE}};'
                        ],
                        'separator' => 'after',
                        'condition' => [
                            'overlay_status' => 'yes'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $view_type = $settings['view_type'];
        $bg_image = $settings['bg_image'];
        $title = $settings['title'];
        $subtitle = $settings['subtitle'];
        $description = $settings['description'];
        $banner_link = $settings['banner_link'];
        $overlay_status = $settings['overlay_status'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //

        $bg_image_src = $bg_image['url'];
        $bg_image_meta = organium_get_attachment_meta($bg_image['id']);
        $bg_image_alt_text = $bg_image_meta['alt'];

        if (!empty($banner_link['url'])) {
            $start_tag = '<a href="' . esc_url($banner_link['url']) . '" class="organium_banner_inner"' . ($banner_link['is_external'] == true ? ' target="_blank"' : '') . ($banner_link['nofollow'] == 'on' ? ' rel="nofollow"' : '') . '>';
            $close_tag = '</a>';
        } else {
            $start_tag = '<span class="organium_banner_inner">';
            $close_tag = '</span>';
        }
        ?>

        <div class="organium_ad_banner_widget<?php echo ( !empty($view_type) ? ' view_' . esc_attr($view_type) : '' ); ?>">
            <?php
            echo sprintf('%s', $start_tag);
                if (!empty($bg_image_src)) {
                    echo '<img class="organium_image_widget_bg" src="' . esc_url($bg_image_src) . '" alt="' . esc_attr($bg_image_alt_text) . '" />';
                }

                if ($overlay_status == 'yes') {
                    echo '<span class="organium_banner_overlay"></span>';
                }

                if ($view_type == 'type_2') {
                    echo '<span class="organium_banner_frame"></span>';
                }

                echo '<span class="organium_banner_content">';
                    if (!empty($title)) {
                        echo '<span class="organium_banner_title">' . wp_kses($title, array(
                            'br' => array(),
                            'strong' => array(),
                            'mark' => array(),
                            'b' => array(),
                            'i' => array(),
                            'em' => array(),
                            'span' => array()
                        )) . '</span>';
                    }

                    if (!empty($subtitle)) {
                        echo '<span class="organium_banner_subtitle">' . wp_kses($subtitle, array(
                            'br' => array(),
                            'strong' => array(),
                            'mark' => array(),
                            'b' => array(),
                            'i' => array(),
                            'em' => array(),
                            'span' => array()
                        )) . '</span>';
                    }

                    if (!empty($description)) {
                        echo '<span class="organium_banner_description">' . wp_kses($description, array(
                            'br' => array(),
                            'strong' => array(),
                            'mark' => array(),
                            'b' => array(),
                            'i' => array(),
                            'em' => array(),
                            'span' => array()
                        )) . '</span>';
                    }
                echo '</span>';
            echo sprintf('%s', $close_tag);
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
