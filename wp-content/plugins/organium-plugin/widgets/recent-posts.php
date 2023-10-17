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

class Organium_Recent_Posts_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_recent_posts';
    }

    public function get_title() {
        return esc_html__('Recent Posts', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
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
                'label' => esc_html__('Recent Posts', 'organium_plugin')
            ]
        );

        $args = array('post_type' => 'post', 'numberposts' => '-1');
        $all_posts = get_posts($args);
        $post_list = array();

        if ($all_posts > 0) {
            foreach ($all_posts as $post) {
                setup_postdata($post);
                $post_list[$post->ID] = $post->post_title;
            }
        } else {
            $post_list = array(
                'no_posts' => esc_html__('No Posts Were Found', 'organium_plugin')
            );
        }

        $this->add_control(
            'posts',
            [
                'label' => esc_html__('Choose Cause Item', 'organium_plugin'),
                'type' => Controls_Manager::SELECT2,
                'options' => $post_list,
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
                'label' => esc_html__('Recent Posts Settings', 'organium_plugin'),
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
                    '{{WRAPPER}} .organium_blog_listing_item' => 'padding-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .organium_recent_posts_wrapper' => 'margin-left: -{{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .organium_blog_item_wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .organium_blog_item_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'items_bg_color',
            [
                'label' => esc_html__('Item Background', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_blog_item_wrapper' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .organium_blog_item_wrapper',
            ]
        );

        $this->add_control(
            'content_padding',
            [
                'label' => esc_html__('Content Part Padding', 'organium_plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .organium_post_info_container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'cat_color',
            [
                'label' => esc_html__('Category Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_category_container' => 'color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'cat_bg_color',
            [
                'label' => esc_html__('Category Background', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_category_container' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'cat_typography',
                'label' => esc_html__('Category Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_category_container'
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
                    '{{WRAPPER}} .organium_post_title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_post_title'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_post_title a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'title_hover',
            [
                'label' => esc_html__('Title Hover', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_post_title a:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'excerpt_margin',
            [
                'label' => esc_html__('Spaces After Excerpt', 'organium_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .organium_post_excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'label' => esc_html__('Excerpt Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_post_excerpt'
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__('Excerpt Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_post_excerpt' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'label' => esc_html__('Post Meta Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_post_meta'
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => esc_html__('Post Meta Color', 'organium_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .organium_post_meta, {{WRAPPER}} .icon' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $posts = $settings['posts'];
        $post_order_by = $settings['post_order_by'];
        $post_order = $settings['post_order'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="organium_recent_posts_widget">
            <div class="organium_recent_posts_wrapper">
                <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'post__in' => $posts,
                    'orderby' => $post_order_by,
                    'order' => $post_order
                );

                query_posts($args);

                while (have_posts()) {
                    the_post();
                    ?>

                    <div class="organium_blog_listing_item organium_blog_item_1">
                        <div class="organium_blog_item_wrapper">
                            <?php
                            $featured_image_url = organium_get_featured_image_url();
                            $image_alt_text = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);

                            $categories = get_the_category();
                            $categ_code = array();

                            if (is_array($categories)) {
                                foreach ($categories as $category) {
                                    $categ_code[] = '
                                        <span class="organium_category">' . esc_html($category->name) . '</span>
                                    ';
                                }
                            }

                            $featured_image_src = aq_resize(esc_url($featured_image_url), 634, 485, true, true, true);
                            $organium_excerpt = substr(get_the_excerpt(), 0, 110);
                            ?>

                            <div class="organium_image_container">
                                <img src="<?php echo esc_url($featured_image_src); ?>" alt="<?php echo esc_attr($image_alt_text); ?>" />

                                <div class="organium_category_container"><?php echo (is_array($categ_code) ? join('', $categ_code) : ''); ?></div>
                            </div>

                            <div class="organium_post_info_container">
                                <h6 class="organium_post_title">
                                    <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(Get_the_title()); ?></a>
                                </h6>

                                <p class="organium_post_excerpt"><?php echo esc_html($organium_excerpt); ?></p>

                                <div class="organium_post_meta">
                                    <span class="organium_post_date"><?php echo get_the_date(); ?></span>
                                    <span class="organium_post_comments_counter">
                                        <svg class="icon">
                                            <svg viewBox="0 0 510 510" id="comment" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M459 0H51C22.95 0 0 22.95 0 51v459l102-102h357c28.05 0 51-22.95 51-51V51c0-28.05-22.95-51-51-51z"></path>
                                            </svg>
                                        </svg>
                                        <?php comments_number('0', '1', '%'); ?>
                                    </span>
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
        wp_reset_query();
    }

    protected function content_template() {}

    public function render_plain_content() {}
}