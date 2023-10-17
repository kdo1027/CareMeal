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
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Organium_Promo_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_promo';
    }

    public function get_title() {
        return esc_html__('Promo', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-posts-group';
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
                'label' => esc_html__('Promo', 'organium_plugin')
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
                ]
            ]
        );

        $this->add_control(
            'central_image',
            [
                'label' => esc_html__( 'Central Image', 'organium_plugin' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'central_image_thumbnail',
                'include' => [],
                'default' => 'full',
            ]
        );

        $this->add_control(
            'central_image_v_align',
            [
                'label' => esc_html__('Image Vertical Alignment', 'organium_plugin'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'bottom',
                'options' => [
                    'top' => [
                        'title' => esc_html__( 'Top', 'organium_plugin' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => esc_html__( 'Middle', 'organium_plugin' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__( 'Bottom', 'organium_plugin' ),
                        'icon' => 'eicon-v-align-bottom',
                    ]
                ]
            ]
        );

        $this->add_control(
            'promo_items',
            [
                'label' => esc_html__('Promo Items', 'organium_plugin'),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'title' => '',
                        'description' => '',
                        'image' => ''
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
                        'name' => 'image',
                        'label' => esc_html__('Image', 'organium_plugin'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ]
                    ]
                ],
                'title_field' => '{{{title}}}',
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // ----------------------------------------- //
        // ---------- Promo Item Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Promo Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'image_margin',
            [
                'label' => esc_html__('Space Between Image and Content', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.01
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .promo_item:nth-child(2n) .promo_item_image_wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .promo_item:nth-child(2n+1) .promo_item_image_wrapper' => 'margin-left: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .promo_item_title'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promo_item_title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'title_margin',
            [
                'label' => esc_html__('Space After Title', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.01
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .promo_item_title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__('Description Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .promo_item_description'
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promo_item_description' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $view_type = $settings['view_type'];
        $central_image_v_align = $settings['central_image_v_align'];
        $promo_items = $settings['promo_items'];

        $wrapper_class = 'organium_promo_widget';
        $wrapper_class .= !empty($central_image_v_align) ? ' central_image_' . esc_attr($central_image_v_align) : '';
        $wrapper_class .= !empty($view_type) ? ' view_' . esc_attr($view_type) : '';

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <?php if (!empty($promo_items)) {
            echo '<div class="' . esc_attr($wrapper_class) . '">';
                echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'central_image_thumbnail', 'central_image' );
                echo '<div class="organium_promo_wrapper">';
                    foreach ($promo_items as $item) {
                        $image = $item['image'];
                        $image_url = $image['url'];
                        $image_meta = organium_get_attachment_meta($image['id']);
                        $image_alt_text = $image_meta['alt'];
                        if (function_exists('aq_resize')) {
                            if ($view_type == 'type_1') {
                                $image_src = aq_resize(esc_url($image_url), 100, 100, true, true, true);
                            } elseif ($view_type == 'type_2') {
                                $image_src = aq_resize(esc_url($image_url), 70, 70, true, true, true);
                            }
                        } else {
                            $image_src = wp_get_attachment_image_src($image['id'], 'thumbnail');
                        }
                        echo '<div class="promo_item">';
                            if ( !empty($item['title']) || !empty($item['description']) ) {
                                echo '<div class="promo_item_content">';
                                    echo ( !empty($item['title']) ? '<h6 class="promo_item_title">' . esc_html($item['title']) . '</h6>' : '' );
                                    echo ( !empty($item['description']) ? '<div class="promo_item_description">' . esc_html($item['description']) . '</div>' : '' );
                                echo '</div>';
                            }
                            if ( !empty($item['image']) ) {
                                echo '<div class="promo_item_image_wrapper">';
                                    echo '<img class="promo_item_image" src="' . esc_url($image_src) . '" alt="' . esc_attr($image_alt_text) . '" />';
                                echo '</div>';
                            }
                        echo '</div>';
                    }
                echo '</div>';

            echo '</div>';
        }
    }

    protected function content_template() {}

    public function render_plain_content() {}
}