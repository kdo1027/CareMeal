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

class Organium_Testimonial_Carousel_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_testimonial_carousel';
    }

    public function get_title() {
        return esc_html__('Testimonial Carousel', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-testimonial-carousel';
    }

    public function get_categories() {
        return ['organium_widgets'];
    }

    public function get_script_depends() {
        return ['testimonials_widget'];
    }

    protected function _register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Testimonial Carousel', 'organium_plugin')
            ]
        );

        $this->add_control(
            'view_type',
            [
                'label' => esc_html__('View Type', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'type_1',
                'options' => [
                    'type_1' => esc_html__('Type 1', 'organium_plugin'),
                    'type_2' => esc_html__('Type 2', 'organium_plugin'),
                    'type_3' => esc_html__('Type 3', 'organium_plugin'),
                    'type_4' => esc_html__('Type 4', 'organium_plugin')
                ]
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'testimonial',
            [
                'label' => esc_html__('Testimonial Text', 'organium_plugin'),
                'type' => Controls_Manager::WYSIWYG,
                'rows' => '10',
                'default' => '',
                'placeholder' => esc_html__('Enter Testimonial Text', 'organium_plugin'),
                'separator' => 'before'
            ]
        );

        $repeater->add_control(
            'photo',
            [
                'label' => __( 'Choose Author Photo', 'organium_plugin' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__('Author Name', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => ''
            ]
        );

        $repeater->add_control(
            'position',
            [
                'label' => esc_html__('Author Position', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => ''
            ]
        );

        $this->add_control(
            'testimonials_items',
            [
                'label' => esc_html__('Testimonials', 'organium_plugin'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{name}}}',
                'prevent_empty' => false,
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // ---------------------------- //
        // ---------- Slider ---------- //
        // ---------------------------- //
        $this->start_controls_section(
            'section_slider',
            [
                'label' => esc_html__('Slider Settings', 'organium_plugin')
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Animation Speed', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label' => esc_html__('Infinite Loop', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'organium_plugin'),
                    'no' => esc_html__('No', 'organium_plugin'),
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'organium_plugin'),
                    'no' => esc_html__('No', 'organium_plugin'),
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => [
                    'autoplay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => esc_html__('Pause on Hover', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'organium_plugin'),
                    'no' => esc_html__('No', 'organium_plugin'),
                ],
                'condition' => [
                    'autoplay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'rtl_support',
            [
                'label' => esc_html__('Rtl Support', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_off' => esc_html__('Off', 'organium_plugin'),
                'label_on' => esc_html__('On', 'organium_plugin'),
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // ----------------------------------------- //
        // ---------- Pagination Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'section_pagination_settings',
            [
                'label' => esc_html__('Pagination Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('button_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'pagination_normal',
                [
                    'label' => esc_html__('Normal', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'dot_color',
                    [
                        'label' => esc_html__('Pagination Dot Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slick-dots li:after' => 'background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'dot_border',
                    [
                        'label' => esc_html__('Pagination Dot Border', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slick-dots li' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ------------------------ //
            // ------ Active Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'pagination_active',
                [
                    'label' => esc_html__('Active', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'dot_active',
                    [
                        'label' => esc_html__('Pagination Active Dot Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slick-dots li.slick-active:after' => 'background: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'dot_border_active',
                    [
                        'label' => esc_html__('Pagination Active Dot Border', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slick-dots li.slick-active' => 'border-color: {{VALUE}};'
                        ]
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

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Quote Icon Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .organium_testimonial_item .organium_testimonial:before' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'view_type' => ['type_3', 'type_4']
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => esc_html__('Testimonial Text Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_testimonial_carousel_wrapper .organium_testimonials_content .organium_testimonial',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Testimonial Text Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .organium_testimonial_carousel_wrapper .organium_testimonials_content .organium_testimonial' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_typography',
                'label' => esc_html__('Author Name Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_testimonial_carousel_wrapper .organium_testimonials_content .organium_author_name',
            ]
        );

        $this->add_control(
            'author_color',
            [
                'label' => esc_html__('Author Name Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .organium_testimonial_carousel_wrapper .organium_testimonials_content .organium_author_name' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'position_typography',
                'label' => esc_html__('Author Position Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_testimonial_carousel_wrapper .organium_testimonials_content .organium_author_position',
            ]
        );

        $this->add_control(
            'position_color',
            [
                'label' => esc_html__('Author Position Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_testimonial_carousel_wrapper .organium_testimonials_content .organium_author_position' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $view_type = $settings['view_type'];
        $testimonials_items = $settings['testimonials_items'];

        if ($settings['rtl_support'] == 'yes') {
            $rtl = true;
        } else {
            $rtl = false;
        }

        $slidesToShow = 1;

        $slider_options = [
            'slidesToShow' => $slidesToShow,
            'pauseOnHover' => ('yes' === $settings['pause_on_hover']),
            'autoplay' => ('yes' === $settings['autoplay']),
            'infinite' => ('yes' === $settings['infinite']),
            'speed' => absint($settings['speed']),
            'rtl' => $rtl
        ];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="organium_testimonial_carousel_widget">
            <div class="organium_testimonial_carousel_wrapper view_<?php echo esc_attr($view_type); ?>">
                <div class="organium_testimonials_slider_container">
                    <div class="organium_testimonials_slider organium_slider_slick slider_<?php echo esc_attr($view_type); ?>" data-slider-options="<?php echo esc_attr(wp_json_encode($slider_options)); ?>">
                        <?php

                        foreach ($testimonials_items as $item) {
                            if ( $view_type == 'type_1' ) {
                                if (function_exists('aq_resize')) {
                                    $image_src = aq_resize(esc_url($item['photo']['url']), 125, 125, true, true, true);
                                    $image_alt_text = get_post_meta(get_post_thumbnail_id($item['photo']['id']), '_wp_attachment_image_alt', true);
                                    $image = '<img src="' . esc_url($image_src) . '" alt="' . esc_attr($image_alt_text) . '" >';
                                } else {
                                    $image = wp_get_attachment_image( $item['photo']['id'], 'thumbnail' );
                                }
                                echo '<div class="organium_testimonial_item">';
                                    if ( !empty($item['photo']['url']) && !empty($image) ) {
                                        echo '<div class="organium_testimonial_photo">';
                                            echo wp_kses($image, array(
                                                'img' => array(
                                                    'src' => true,
                                                    'alt' => true
                                                )
                                            ));
                                        echo '</div>';
                                    }
                                    echo '<div class="organium_testimonials_content">';
                                        echo ( !empty($item['testimonial']) ? '<div class="organium_testimonial">' . organium_output_code($item['testimonial']) . '</div>' : '' );
                                        echo '<div class="organium_author_container">';
                                            echo ( !empty($item['name']) ? '<span class="organium_author_name">' . esc_html($item['name']) . '</span>' : '' );
                                            echo ( !empty($item['position']) ? '<span class="organium_author_position">' . esc_html($item['position']) . '</span>' : '');
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }
                            if ( $view_type == 'type_2' ) {
                                if (function_exists('aq_resize')) {
                                    $image_src = aq_resize(esc_url($item['photo']['url']), 85, 85, true, true, true);
                                    $image_alt_text = get_post_meta(get_post_thumbnail_id($item['photo']['id']), '_wp_attachment_image_alt', true);
                                    $image = '<img src="' . esc_url($image_src) . '" alt="' . esc_attr($image_alt_text) . '" >';
                                } else {
                                    $image = wp_get_attachment_image( $item['photo']['id'], 'thumbnail' );
                                }
                                echo '<div class="organium_testimonial_item">';
                                    echo ( !empty($item['testimonial']) ? '<div class="organium_testimonial">' . organium_output_code($item['testimonial']) . '</div>' : '' );
                                    echo '<div class="organium_author_container">';
                                        if ( !empty($item['photo']['url']) && !empty($image) ) {
                                            echo '<div class="organium_testimonial_photo">';
                                            echo wp_kses($image, array(
                                                'img' => array(
                                                    'src' => true,
                                                    'alt' => true
                                                )
                                            ));
                                            echo '</div>';
                                        }
                                        echo '<div class="organium_author_info">';
                                            echo ( !empty($item['name']) ? '<div class="organium_author_name">' . esc_html($item['name']) . '</div>' : '' );
                                            echo ( !empty($item['position']) ? '<div class="organium_author_position">' . esc_html($item['position']) . '</div>' : '' );
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }
                            if ( $view_type == 'type_3' ) {
                                if (function_exists('aq_resize')) {
                                    $image_src = aq_resize(esc_url($item['photo']['url']), 70, 70, true, true, true);
                                    $image_alt_text = get_post_meta(get_post_thumbnail_id($item['photo']['id']), '_wp_attachment_image_alt', true);
                                    $image = '<img src="' . esc_url($image_src) . '" alt="' . esc_attr($image_alt_text) . '" >';
                                } else {
                                    $image = wp_get_attachment_image( $item['photo']['id'], 'thumbnail' );
                                }
                                echo '<div class="organium_testimonial_item">';
                                    echo ( !empty($item['testimonial']) ? '<div class="organium_testimonial">' . organium_output_code($item['testimonial']) . '</div>' : '' );
                                    echo '<div class="organium_author_container">';
                                        if ( !empty($item['photo']['url']) && !empty($image) ) {
                                            echo '<div class="organium_testimonial_photo">';
                                                echo wp_kses($image, array(
                                                    'img' => array(
                                                        'src' => true,
                                                        'alt' => true
                                                    )
                                                ));
                                            echo '</div>';
                                        }
                                        echo '<div class="organium_author_info">';
                                            echo ( !empty($item['name']) ? '<div class="organium_author_name">' . esc_html($item['name']) . '</div>' : '' );
                                            echo ( !empty($item['position']) ? '<div class="organium_author_position">' . esc_html($item['position']) . '</div>' : '' );
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }
                            if ( $view_type == 'type_4' ) {
                                if (function_exists('aq_resize')) {
                                    $image_src = aq_resize(esc_url($item['photo']['url']), 70, 70, true, true, true);
                                    $image_alt_text = get_post_meta(get_post_thumbnail_id($item['photo']['id']), '_wp_attachment_image_alt', true);
                                    $image = '<img src="' . esc_url($image_src) . '" alt="' . esc_attr($image_alt_text) . '" >';
                                } else {
                                    $image = wp_get_attachment_image( $item['photo']['id'], 'medium' );
                                }
                                echo '<div class="organium_testimonial_item">';
                                    if ( !empty($item['photo']['url']) && !empty($image) ) {
                                        echo '<div class="organium_testimonial_photo">';
                                            echo wp_kses($image, array(
                                                'img' => array(
                                                    'src' => true,
                                                    'alt' => true
                                                )
                                            ));
                                        echo '</div>';
                                    }
                                    echo '<div class="organium_testimonials_content">';
                                        echo ( !empty($item['testimonial']) ? '<div class="organium_testimonial">' . organium_output_code($item['testimonial']) . '</div>' : '' );
                                        echo '<div class="organium_author_container">';
                                            echo ( !empty($item['name']) ? '<span class="organium_author_name">' . esc_html($item['name']) . '</span>' : '' );
                                            echo ( !empty($item['position']) ? '<span class="organium_author_position">' . esc_html($item['position']) . '</span>' : '' );
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
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