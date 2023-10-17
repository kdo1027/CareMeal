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

class Organium_Person_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_person';
    }

    public function get_title() {
        return esc_html__('Person', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-person';
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
                'label' => esc_html__('Person', 'organium_plugin')
            ]
        );

        $this->add_control(
            'person_name',
            [
                'label' => esc_html__('Person Name', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => ''
            ]
        );

        $this->add_control(
            'person_position',
            [
                'label' => esc_html__('Person Position', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => ''
            ]
        );

        $this->add_control(
            'person_image',
            [
                'label' => esc_html__('Person Image', 'organium_plugin'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'social_icon',
            [
                'label' => esc_html__('Icon', 'organium_plugin'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'fa4compatibility' => 'social',
                'default' => [
                    'value' => 'fab fa-wordpress',
                    'library' => 'brand'
                ]
            ]
        );

        $repeater->add_control(
            'social_link',
            [
                'label' => esc_html__('Link', 'organium_plugin'),
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
            'socials',
            [
                'label' => esc_html__('Social Icons', 'organium_plugin'),
                'type' => Controls_Manager::REPEATER,
                'default' => [],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{elementor.helpers.renderIcon(this, social_icon, {}, "i", "panel")}}}',
                'prevent_empty' => false,
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // ------------------------------------- //
        // ---------- Person Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Person Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => esc_html__('Person Image Size', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'min' => 20,
                'max' => 500,
                'separator' => 'after'
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label' => esc_html__('Space between image and name', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_person_description_container' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'label' => esc_html__('Name Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_person_name'
            ]
        );

        $this->add_responsive_control(
            'name_margin',
            [
                'label' => esc_html__('Space between name and position', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_person_position' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'position_typography',
                'label' => esc_html__('Position Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_person_position'
            ]
        );

        $this->add_responsive_control(
            'position_margin',
            [
                'label' => esc_html__('Space between position and social icons', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_person_socials' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs('person_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'person_normal',
                [
                    'label' => esc_html__('Normal', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'person_border_color',
                    [
                        'label' => esc_html__('Person Border Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .organium_person_image_wrapper:before' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'name_color',
                    [
                        'label' => esc_html__('Name Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .organium_person_name' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'position_color',
                    [
                        'label' => esc_html__('Position Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .organium_person_position' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'socials_icon_color',
                    [
                        'label' => esc_html__('Socials Icon Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .organium_person_socials a' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'socials_bg_color',
                    [
                        'label' => esc_html__('Socials Background Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .organium_person_socials a' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );


            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'person_hover',
                [
                    'label' => esc_html__('Hover', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'person_border_hover',
                    [
                        'label' => esc_html__('Person Border Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}}:hover .organium_person_image_wrapper:before' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'name_hover',
                    [
                        'label' => esc_html__('Name Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}}:hover .organium_person_name' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after'
                    ]
                );

                $this->add_control(
                    'position_hover',
                    [
                        'label' => esc_html__('Position Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .organium_person_wrapper:hover .organium_person_position' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after'
                    ]
                );

                $this->add_control(
                    'socials_hover',
                    [
                        'label' => esc_html__('Socials Icon Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .organium_person_socials a:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'socials_bg_hover',
                    [
                        'label' => esc_html__('Socials Background Hover', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .organium_person_socials a:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $person_name = $settings['person_name'];
        $person_position = $settings['person_position'];
        $person_image = $settings['person_image'];
        $socials = $settings['socials'];
        $image_size = $settings['image_size'];

        $image_meta = organium_get_attachment_meta($person_image['id']);
        $image_alt_text = $image_meta['alt'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="organium_person_widget">
            <div class="organium_person_wrapper">

                <div class="organium_person_image_container">
                    <div class="organium_person_image_wrapper"<?php echo ( !empty($image_size) ? ' style="max-width: ' . esc_attr($image_size) . 'px;"' : '' ); ?>>
                        <img src="<?php echo esc_url($person_image['url']); ?>" alt="<?php echo esc_attr($image_alt_text); ?>" />
                    </div>
                </div>

                <?php
                if ( !empty($person_name) || !empty($person_position) ) {
                    echo '<div class="organium_person_description_container">';
                        if ($person_name !== '') {
                            echo '<h6 class="organium_person_name">' . esc_html($person_name) . '</h6>';
                        }

                        if ($person_position !== '') {
                            echo '<div class="organium_person_position">' . esc_html($person_position) . '</div>';
                        }
                    echo '</div>';
                }

                if (!empty($socials)) {
                    echo '<ul class="organium_person_socials">';
                        foreach ($socials as $social) {
                            if ($social['social_link']['url'] !== '') {
                                $social_url = $social['social_link']['url'];
                            } else {
                                $social_url = '#';
                            }
                            echo '<li>';
                                echo '<a href="' . esc_url($social_url) . '"' . (($social['social_link']['is_external'] == true) ? ' target="_blank"' : '') . (($social['social_link']['nofollow'] == 'on') ? ' rel="nofollow"' : '') . '><i class="' . esc_attr($social['social_icon']['value']) . '"></i></a>';
                            echo '</li>';
                        }
                    echo '</ul>';
                }
                ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
