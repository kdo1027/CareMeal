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
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Organium_Image_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_image';
    }

    public function get_title() {
        return esc_html__('Image', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-image';
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
                'label' => esc_html__('Image', 'organium_plugin')
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
                'label' => esc_html__('Image Style', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'organium_plugin'),
                    'framed' => esc_html__('Framed', 'organium_plugin')
                ]
            ]
        );

        $this->add_responsive_control(
            'image_align',
            [
                'label' => esc_html__('Image Alignment', 'organium_plugin'),
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
                    '{{WRAPPER}} .organium_image_widget' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_float',
            [
                'label' => esc_html__('Image Float', 'organium_plugin'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'organium_plugin'),
                        'icon' => 'fas fa-outdent',
                    ],
                    'none' => [
                        'title' => esc_html__('None', 'organium_plugin'),
                        'icon' => 'fas fa-align-justify',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'organium_plugin'),
                        'icon' => 'fas fa-indent',
                    ]
                ],
                'default' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .organium_image_container' => 'float: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ------------------------------------ //
        // ---------- Image Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'section_heading_settings',
            [
                'label' => esc_html__('Image Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'max_width',
            [
                'label' => __( 'Max Width', 'organium_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => [ '%', 'px', 'vw' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} img.organium_image_widget_main_image' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'frame_color',
            [
                'label' => esc_html__('Frame Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_image_container.organium_image_style_framed:before' => 'border-color: {{VALUE}};'
                ],
                'condition' => [
                    'image_style' => 'framed'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $image = $settings['image'];
        $image_style = $settings['image_style'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //

        $image_src = $image['url'];
        $image_meta = organium_get_attachment_meta($image['id']);
        $image_alt_text = $image_meta['alt'];
        ?>
        <div class="organium_image_widget">
            <div class="organium_image_container<?php echo ( !empty($image_style) ? ' organium_image_style_' . esc_attr($image_style) : ''); ?>">
                <img class="organium_image_widget_main_image" src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($image_alt_text); ?>" />
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
