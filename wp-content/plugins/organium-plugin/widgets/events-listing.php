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

class Organium_Events_Listing_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_events_listing';
    }

    public function get_title() {
        return esc_html__('Events Listing', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-post-list';
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
                'label' => esc_html__('Events Listing', 'organium_plugin')
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Items Per Page', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
                'separator' => 'before'
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

        $this->add_control(
            'pagination',
            [
                'label' => esc_html__('Pagination', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'show',
                'options' => [
                    'show' => esc_html__('Show', 'organium_plugin'),
                    'hide' => esc_html__('Hide', 'organium_plugin')
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // --------------------------------------------- //
        // ---------- Events Listing Settings ---------- //
        // --------------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Events Listing Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
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
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .upcoming-item' => 'margin-bottom: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .upcoming-item__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'items_bg_color',
            [
                'label' => esc_html__('Item Background', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .upcoming-item__body' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .upcoming-item__body',
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
                    '{{WRAPPER}} .upcoming-item__title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .upcoming-item__title'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .upcoming-item__title a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'title_hover',
            [
                'label' => esc_html__('Title Hover', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .upcoming-item__title a:hover' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'label' => esc_html__('Excerpt Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_excerpt'
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__('Excerpt Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_excerpt' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'info_fields_cont_margin',
            [
                'label' => esc_html__('Spaces Before Info Fields', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .upcoming-item__details' => 'margin-top: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'before'
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
                    '{{WRAPPER}} .upcoming-item__details p:not(:last-of-type)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'info_fields_typography',
                'label' => esc_html__('Info Fields Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .upcoming-item__details p'
            ]
        );

        $this->add_control(
            'info_fields_color',
            [
                'label' => esc_html__('Info Fields Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .upcoming-item__details p' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' => esc_html__('Date Part Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .upcoming-item__date' => 'color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'date_bg_color',
            [
                'label' => esc_html__('Date Part Background', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .upcoming-item__date' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'date_padding',
            [
                'label' => esc_html__('Date Part Padding', 'organium_plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .upcoming-item__date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $posts_per_page = $settings['posts_per_page'];
        $post_order_by = $settings['post_order_by'];
        $post_order = $settings['post_order'];
        $pagination = $settings['pagination'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="organium_events_listing_widget">
            <div class="organium_events_listing_wrapper">
                <div class="row">
                    <?php
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    $args = array(
                        'post_type' => 'organium-events',
                        'posts_per_page' => $posts_per_page,
                        'orderby' => $post_order_by,
                        'order' => $post_order,
                        'paged' => esc_attr($paged)
                    );

                    query_posts($args);

                    while (have_posts()) {
                        the_post();

                        $featured_image_url = organium_get_featured_image_url();
                        $image_alt_text = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
                        $featured_image_src = aq_resize(esc_url($featured_image_url), 640, 546, true, true, true);
                        $organium_excerpt = substr(get_the_excerpt(), 0, 130);
                        ?>

                        <div class="organium_event_listing_item col-xl-10 offset-xl-1">
                            <div class="upcoming-item">
                                <div class="upcoming-item__date">
                                    <span><?php echo esc_attr(get_the_date('d')); ?></span>
                                    <span><?php echo esc_attr(get_the_date('M, y')); ?></span>
                                </div>

                                <div class="upcoming-item__body">
                                    <div class="row align-items-center">
                                        <div class="col-lg-5 col-xl-4">
                                            <div class="upcoming-item__img">
                                                <img src="<?php echo esc_url($featured_image_src); ?>" alt="<?php echo esc_attr($image_alt_text); ?>" />
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-xl-8">
                                            <div class="upcoming-item__description">
                                                <h6 class="upcoming-item__title">
                                                    <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a>
                                                </h6>

                                                <p class="organium_excerpt"><?php echo esc_html($organium_excerpt); ?></p>

                                                <div class="upcoming-item__details">
                                                    <?php
                                                    if (organium_get_post_option('event_date') !== false) {
                                                        ?>
                                                        <p class="organium_event_date">
                                                            <svg class="icon">
                                                                <svg viewBox="0 0 488.878 488.878" id="check" xmlns="http://www.w3.org/2000/svg"><path d="M143.294 340.058l-92.457-92.456L0 298.439l122.009 122.008.14-.141 22.274 22.274L488.878 98.123l-51.823-51.825z"/></svg>
                                                            </svg>
                                                            <?php echo organium_output_code(organium_get_post_option('event_date')); ?>
                                                        </p>
                                                        <?php
                                                    }

                                                    if (organium_get_post_option('event_time') !== false) {
                                                        ?>
                                                        <p class="organium_event_time">
                                                            <svg class="icon">
                                                                <svg fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ahfeather ahfeather-clock" viewBox="0 0 24 24" id="clock" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                                            </svg>
                                                            <?php echo organium_output_code(organium_get_post_option('event_time')); ?>
                                                        </p>
                                                        <?php
                                                    }

                                                    if (organium_get_post_option('event_address') !== false) {
                                                        ?>
                                                        <p class="organium_event_address">
                                                            <svg class="icon">
                                                                <svg fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="aufeather aufeather-map-pin" viewBox="0 0 24 24" id="placeholder" xmlns="http://www.w3.org/2000/svg"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                                            </svg>
                                                            <?php echo organium_output_code(organium_get_post_option('event_address')); ?>
                                                        </p>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <?php
            if ($pagination == 'show') {
                ?>
                <div class="organium_pagination">
                    <?php
                    echo get_the_posts_pagination(array(
                        'prev_text' => '<i class="fa fa-angle-left" aria-hidden="true"></i>' . esc_html__('Back', 'organium_plugin'),
                        'next_text' => esc_html__('Next', 'organium_plugin') . '<i class="fa fa-angle-right" aria-hidden="true"></i>'
                    ));
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        wp_reset_query();
    }

    protected function content_template() {}

    public function render_plain_content() {}
}