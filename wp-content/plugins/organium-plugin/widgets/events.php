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

class Organium_Events_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_events';
    }

    public function get_title() {
        return esc_html__('Events', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-posts-grid';
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
                'label' => esc_html__('Events', 'organium_plugin')
            ]
        );

        $args = array('post_type' => 'organium-events', 'numberposts' => '-1');
        $all_events = get_posts($args);
        $events_list = array();

        if ($all_events > 0) {
            foreach ($all_events as $event) {
                setup_postdata($event);
                $events_list[$event->ID] = $event->post_title;
            }
        } else {
            $events_list = array(
                'no_posts' => esc_html__('No Posts Were Found', 'organium_plugin')
            );
        }

        $this->add_control(
            'events',
            [
                'label' => esc_html__('Choose Cause Item', 'organium_plugin'),
                'type' => Controls_Manager::SELECT2,
                'options' => $events_list,
                'label_block' => true,
                'multiple' => true
            ]
        );

        $this->add_control(
            'post_order_by',
            [
                'label' => esc_html__('Order By', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => esc_html__('Post Date', 'organium_plugin'),
                    'rand' => esc_html__('Random', 'organium_plugin'),
                    'ID' => esc_html__('Post ID', 'organium_plugin'),
                    'title' => esc_html__('Post Title', 'organium_plugin')
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'post_order',
            [
                'label' => esc_html__('Order', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'desc' => esc_html__('Descending', 'organium_plugin'),
                    'asc' => esc_html__('Ascending', 'organium_plugin')
                ]
            ]
        );

        $this->end_controls_section();

        // -------------------------------------- //
        // ---------- Content Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Events Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
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
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_event_item' => 'padding-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .organium_events_wrapper' => 'margin-left: -{{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'items_margin',
            [
                'label' => esc_html__('Spaces After Items', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_event_item_wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'items_wrapper_padding',
            [
                'label' => esc_html__('Item Padding', 'organium_plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .organium_event_item_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'items_bg_color',
            [
                'label' => esc_html__('Item Background', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_event_item_wrapper' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .organium_event_item_wrapper',
            ]
        );

        $this->add_control(
            'content_padding',
            [
                'label' => esc_html__('Content Part Padding', 'organium_plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .organium_event_content_container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'title_margin',
            [
                'label' => esc_html__('Space After Title', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_event_title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_event_title'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_event_title a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'title_hover',
            [
                'label' => esc_html__('Title Hover', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_event_title a:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'info_fields_margin',
            [
                'label' => esc_html__('Spaces Between Info Fields', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_event_content_container p:not(:last-of-type)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'info_fields_typography',
                'label' => esc_html__('Info Fields Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_event_content_container p'
            ]
        );

        $this->add_control(
            'info_fields_color',
            [
                'label' => esc_html__('Info Fields Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_event_content_container p' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $events = $settings['events'];
        $post_order_by = $settings['post_order_by'];
        $post_order = $settings['post_order'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="organium_events_widget">
            <div class="organium_events_wrapper">
                <?php
                $args = array(
                    'post_type' => 'organium-events',
                    'posts_per_page' => 3,
                    'post__in' => $events,
                    'orderby' => $post_order_by,
                    'order' => $post_order
                );

                query_posts($args);

                while (have_posts()) {
                    the_post();

                    $featured_image_url = organium_get_featured_image_url();
                    $image_alt_text = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
                    $featured_image_src = aq_resize(esc_url($featured_image_url), 640, 489, true, true, true);
                    ?>

                    <div class="organium_event_item">
                        <div class="organium_event_item_wrapper">
                            <div class="organium_image_container">
                                <img src="<?php echo esc_url($featured_image_src); ?>" alt="<?php echo esc_attr($image_alt_text); ?>" />
                            </div>

                            <div class="organium_event_content_container">
                                <h6 class="organium_event_title">
                                    <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a>
                                </h6>

                                <?php
                                if (organium_get_post_option('event_address') !== false) {
                                    ?>
                                    <p><?php echo organium_output_code(organium_get_post_option('event_address')); ?></p>
                                    <?php
                                }

                                if (organium_get_post_option('event_date') !== false) {
                                    ?>
                                    <p><?php echo organium_output_code(organium_get_post_option('event_date')); ?></p>
                                    <?php
                                }

                                if (organium_get_post_option('event_time') !== false) {
                                    ?>
                                    <p><?php echo organium_output_code(organium_get_post_option('event_time')); ?></p>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        wp_reset_query();
    }

    protected function content_template() {}

    public function render_plain_content() {}
}