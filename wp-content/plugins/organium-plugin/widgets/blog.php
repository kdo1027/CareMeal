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
use Elementor\REPEATER;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Organium_Blog_Listing_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_blog_listing';
    }

    public function get_title() {
        return esc_html__('Blog Listing', 'organium_plugin');
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
                'label' => esc_html__('Blog Listing', 'organium_plugin')
            ]
        );

        $this->add_control(
            'listing_type',
            [
                'label' => esc_html__('Type', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'classic',
                'options' => [
                    'classic' => esc_html__('Classic', 'organium_plugin'),
                    'grid' => esc_html__('Grid', 'organium_plugin')
                ]
            ]
        );

        $this->add_control(
            'columns_number',
            [
                'label' => esc_html__('Columns Number', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 2,
                'max' => 6,
                'condition' => [
                    'listing_type' => 'grid'
                ]
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Items Per Page', 'organium_plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 1
            ]
        );

        $this->add_control(
            'filter_by',
            [
                'label' => esc_html__('Filter by:', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'organium_plugin'),
                    'cat' => esc_html__('Category', 'organium_plugin'),
                    'tag' => esc_html__('Tag', 'organium_plugin'),
                    'id' => esc_html__('ID', 'organium_plugin')
                ],
                'separator' => 'before'
            ]
        );

        $category_arr = [];
        $categories = get_categories(
            [
                'taxonomy' => 'category',
                'type' => 'post',
                'child_of' => 0,
                'parent' => '',
                'orderby' => 'name',
                'order' => 'ASC',
                'hierarchical' => 1,
                'exclude' => '',
                'include' => '',
                'number' => 0,
                'pad_counts' => false
            ]
        );
        if( !empty($categories) ) {
            foreach ($categories as $key => $category) {
                $category_arr[$category->slug] = $category->name;
            }
        }
        $this->add_control(
            'category',
            [
                'label'   => esc_html__('Categories', 'organium_plugin'),
                'label_block' => true,
                'type'    => Controls_Manager::SELECT2,
                'multiple' => true,
                'description' => esc_html__('List of categories.', 'organium_plugin'),
                'options' => $category_arr,
                'condition' => [
                    'filter_by' => 'cat'
                ]
            ]
        );

        $tags_arr = [];
        $tags = get_tags(
            [
                'taxonomy' => 'post_tag',
                'type' => 'post',
                'child_of' => 0,
                'parent' => '',
                'orderby' => 'name',
                'order' => 'ASC',
                'hierarchical' => 1,
                'exclude' => '',
                'include' => '',
                'number' => 0,
                'pad_counts' => false
            ]
        );
        if( !empty($tags) ) {
            foreach ($tags as $key => $tag) {
                $tags_arr[$tag->slug] = $tag->name;
            }
        }
        $this->add_control(
            'tag',
            [
                'label'   => esc_html__('Tags', 'organium_plugin'),
                'label_block' => true,
                'type'    => Controls_Manager::SELECT2,
                'multiple' => true,
                'description' => esc_html__('List of tags.', 'organium_plugin'),
                'options' => $tags_arr,
                'condition' => [
                    'filter_by' => 'tag'
                ]
            ]
        );

        $this->add_control(
            'ids',
            [
                'label' => esc_html__('IDs', 'organium_plugin'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter ID', 'organium_plugin' ),
                'description' => esc_html('Comma separated', 'organium_plugin'),
                'default' => '',
                'condition' => [
                    'filter_by' => 'id'
                ]
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
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'organium_plugin'),
                'label_on' => esc_html__('Show', 'organium_plugin'),
                'default' => 'yes',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'show_cat',
            [
                'label' => esc_html__('Categories', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'organium_plugin'),
                'label_on' => esc_html__('Show', 'organium_plugin'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'show_image',
            [
                'label' => esc_html__('Image', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'organium_plugin'),
                'label_on' => esc_html__('Show', 'organium_plugin'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'show_meta',
            [
                'label' => esc_html__('Meta Info', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'organium_plugin'),
                'label_on' => esc_html__('Show', 'organium_plugin'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'show_tags',
            [
                'label' => esc_html__('Tags', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'organium_plugin'),
                'label_on' => esc_html__('Show', 'organium_plugin'),
                'default' => 'no'
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Title', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'organium_plugin'),
                'label_on' => esc_html__('Show', 'organium_plugin'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => esc_html__('Excerpt', 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'organium_plugin'),
                'label_on' => esc_html__('Show', 'organium_plugin'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'show_read_more',
            [
                'label' => esc_html__("'Read More' Button", 'organium_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'organium_plugin'),
                'label_on' => esc_html__('Show', 'organium_plugin'),
                'default' => 'yes'
            ]
        );

        $this->end_controls_section();


        // ----------------------------------- //
        // ---------- Blog Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Blog Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_size',
                'default' => 'large',
                'condition' => [
                    'show_image' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_grid_blog_item .organium_content_wrapper .organium_post_title',
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'label' => esc_html__('Excerpt Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_grid_blog_item .organium_content_wrapper .organium_post_excerpt',
                'condition' => [
                    'show_excerpt' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__('Excerpt Length, in simbols', 'organium_plugin'),
                'label_block' => true,
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'default' => 190,
                'condition' => [
                    'show_excerpt' => 'yes'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'label' => esc_html__('Meta Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_grid_blog_item .organium_content_wrapper .organium_post_meta .organium_post_meta_item',
                'separator' => 'after',
                'condition' => [
                    'show_meta' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'more_typography',
                'label' => esc_html__('Button Typography', 'organium_plugin'),
                'selector' => '{{WRAPPER}} .organium_grid_blog_item .organium_post_more .read_more_button',
                'condition' => [
                    'show_read_more' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('item_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_item_normal',
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
                            '{{WRAPPER}} .organium_grid_blog_item .organium_content_wrapper .organium_post_title, {{WRAPPER}} .organium_grid_blog_item .organium_content_wrapper .organium_post_title a' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'show_title' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'excerpt_color',
                    [
                        'label' => esc_html__('Excerpt Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_grid_blog_item .organium_content_wrapper .organium_post_excerpt' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'show_excerpt' => 'yes'
                        ],
                        'separator' => 'before',
                    ]
                );

                $this->add_control(
                    'meta_color',
                    [
                        'label' => esc_html__('Meta Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_grid_blog_item .organium_content_wrapper .organium_post_meta .organium_post_meta_item, {{WRAPPER}} .organium_grid_blog_item .organium_content_wrapper .organium_post_meta .organium_post_meta_item a' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before',
                        'condition' => [
                            'show_meta' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'more_color',
                    [
                        'label' => esc_html__('Button Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_grid_blog_item .organium_post_more .read_more_button' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before',
                        'condition' => [
                            'show_read_more' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'more_border_color',
                    [
                        'label' => esc_html__('Button Underline Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_grid_blog_item .organium_post_more .read_more_button' => 'border-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'show_read_more' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'pagination_color',
                    [
                        'label' => esc_html__('Pagination Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_pagination .page-numbers' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'pagination' => 'yes'
                        ],
                        'separator' => 'before'
                    ]
                );

                $this->add_control(
                    'pagination_bg_color',
                    [
                        'label' => esc_html__('Pagination Background', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_pagination .page-numbers' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'pagination' => 'yes'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_item_hover',
                [
                    'label' => esc_html__('Hover', 'organium_plugin')
                ]
            );

                $this->add_control(
                    'title_color_hover',
                    [
                        'label' => esc_html__('Title Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_grid_blog_item .organium_content_wrapper .organium_post_title a:hover' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'show_title' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'meta_color_hover',
                    [
                        'label' => esc_html__('Meta Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_grid_blog_item .organium_content_wrapper .organium_post_meta .organium_post_meta_item a:hover' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before',
                        'condition' => [
                            'show_meta' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'more_color_hover',
                    [
                        'label' => esc_html__('More Button Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_grid_blog_item .organium_post_more .read_more_button:hover' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'before',
                        'condition' => [
                            'show_read_more' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'more_border_color_hover',
                    [
                        'label' => esc_html__('More Button Border Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_grid_blog_item .organium_post_more .read_more_button:hover' => 'border-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'show_read_more' => 'yes'
                        ]
                    ]
                );

                $this->add_control(
                    'pagination_hover',
                    [
                        'label' => esc_html__('Pagination Color', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_pagination a:hover, {{WRAPPER}} .organium_pagination .page-numbers.current' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'pagination' => 'yes'
                        ],
                        'separator' => 'before'
                    ]
                );

                $this->add_control(
                    'pagination_bg_hover',
                    [
                        'label' => esc_html__('Pagination Background', 'organium_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .organium_pagination a:hover, {{WRAPPER}} .organium_pagination .page-numbers.current' => 'background-color: {{VALUE}}; border-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'pagination' => 'yes'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $listing_type = $settings['listing_type'];
        $columns_number = $settings['columns_number'];
        $posts_per_page = $settings['posts_per_page'];
        $post_order_by = $settings['post_order_by'];
        $post_order = $settings['post_order'];
        $pagination = $settings['pagination'];
        $filter_by = $settings['filter_by'];
        $category_filter = !empty($settings['category']) && $filter_by == 'cat' ? implode(',', $settings['category']) : '';
        $tag_filter = !empty($settings['tag']) && $filter_by == 'tag' ? implode(',', $settings['tag']) : '';
        $id_filter = !empty($settings['ids']) && $filter_by == 'id' ? explode(',', str_replace(' ', '', $settings['ids'])) : '';

        $wrapper_class = 'organium_archive_listing_wrapper' . ($listing_type == 'grid' && !empty($columns_number) ? ' grid_listing columns_' . esc_attr($columns_number) : '');
        $item_class = ( $listing_type == 'grid' ? 'organium_grid_blog_item' : 'organium_standard_blog_item' );

        $excerpt_length = $settings['excerpt_length'];

        $show_cat = $settings['show_cat'];
        $show_image = $settings['show_image'];
        $show_meta = $settings['show_meta'];
        $show_title = $settings['show_title'];
        $show_tags = $settings['show_tags'];
        $show_excerpt = $settings['show_excerpt'];
        $show_read_more = $settings['show_read_more'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="organium_blog_listing_widget">
            <div class="organium_archive_listing">
                <div class="<?php echo esc_attr($wrapper_class); ?>">
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                $args = array(
                    'post_type' => 'post',
                    'listing_type' => $listing_type,
                    'columns_number' => $columns_number,
                    'posts_per_page' => $posts_per_page,
                    'orderby' => $post_order_by,
                    'order' => $post_order,
                    'paged' => esc_attr($paged),
                    'category_name' => $category_filter,
                    'tag' => $tag_filter,
                    'post__in' => $id_filter
                );

                query_posts($args);

                while (have_posts()) {
                    the_post();
                    $image_alt_text = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);

                    $featured_image_src = Group_Control_Image_Size::get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'image_size', $settings );

                    $categories = get_the_category();
                    $categ_code = array();
                    if (is_array($categories)) {
                        foreach ($categories as $category) {
                            $categ_code[] = '
            <span class="organium_category" style="background-color: #'.esc_attr(get_term_meta($category->term_id, '_category_bg_color', true)).'; color: #'.esc_attr(get_term_meta($category->term_id, '_category_font_color', true)).';">' . esc_html($category->name) . '</span>
        ';
                        }
                    }
                    $organium_excerpt = substr(get_the_excerpt(), 0, $excerpt_length);
                    ?>
                            <div <?php post_class('column_item ' . esc_attr($item_class)); ?>>
                                <div class="<?php echo esc_attr($item_class); ?>_wrapper">
                                    <div class="organium_featured_image_container">
                                        <?php
                                        if ( is_array($categ_code) && count($categ_code) > 0 && $show_cat == 'yes' ) {
                                            echo '<div class="organium_media_categories">';
                                                echo join('', $categ_code);
                                            echo '</div>';
                                        }
                                        ?>
                                        <?php if ( !empty($featured_image_src) && $show_image == 'yes' ) { ?>
                                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                                <img src="<?php echo esc_url($featured_image_src); ?>" alt="<?php echo esc_attr($image_alt_text); ?>" />
                                            </a>
                                        <?php } ?>
                                    </div>

                                    <div class="organium_content_wrapper">
                                        <?php
                                        if ( $show_meta == 'yes' ) {
                                            if ( $listing_type == 'classic' ) {
                                                echo '<div class="organium_post_meta post_meta_columns">';
                                                    if ( !empty( get_the_author() ) || !empty( get_the_date() ) ) {
                                                        echo '<div class="post_meta_left">';
                                                        if (!empty(get_the_date())) {
                                                            echo '<div class="organium_post_meta_item meta_item meta_item_date">';
                                                                echo '<a href="' . get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')) . '">' . get_the_date() . "</a>";
                                                            echo '</div>';
                                                        }
                                                        if (!empty(get_the_author())) {
                                                            echo '<div class="organium_post_meta_item meta_item meta_item_author">';
                                                                echo esc_html__('By ', 'organium_plugin') . get_the_author_posts_link();
                                                            echo '</div>';
                                                        }
                                                        echo '</div>';
                                                    }
                                                    echo '<div class="post_meta_right">';
                                                        echo '<div class="organium_post_meta_item meta_item meta_item_comments">';
                                                            echo get_comments_number() . ' ' . esc_html(_n('comment', 'comments', get_comments_number(), 'organium_plugin'));
                                                        echo '</div>';
                                                    echo '</div>';
                                                echo '</div>';
                                            } else {
                                                echo '<div class="organium_post_meta">';
                                                        if (!empty(get_the_date())) {
                                                            echo '<div class="organium_post_meta_item meta_item meta_item_date">';
                                                                echo '<a href="' . get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')) . '">' . get_the_date() . "</a>";
                                                            echo '</div>';
                                                        }
                                                        if (!empty(get_the_author())) {
                                                            echo '<div class="organium_post_meta_item meta_item meta_item_author">';
                                                                echo esc_html__('By ', 'organium_plugin') . get_the_author_posts_link();
                                                            echo '</div>';
                                                        }
                                                        echo '<div class="organium_post_meta_item meta_item meta_item_comments">';
                                                            echo get_comments_number();
                                                        echo '</div>';
                                                echo '</div>';
                                            }
                                        }

                                        if ($show_title == 'yes') {
                                            echo '<' . ($listing_type == 'grid' && $columns_number > 2 ? 'h6' : 'h3') . ' class="organium_post_title">';
                                                echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a>';
                                            echo '</' . ($listing_type == 'grid' && $columns_number > 2 ? 'h6' : 'h3') . '>';
                                        }

                                        if ( $show_excerpt == 'yes' && !empty($organium_excerpt) ) {
                                            echo '<p class="organium_post_excerpt">' . esc_html($organium_excerpt) . '</p>';
                                        }
                                        if ( !empty(get_the_tag_list()) && $show_tags == 'yes' ) {
                                            echo '<div class="organium_post_meta">';
                                                echo get_the_tag_list('<div class="organium_post_meta_item meta_item meta_item_tags">', ', ', '</div>');
                                            echo '</div>';
                                        }
                                        if ($show_read_more == 'yes') {
                                            echo '<div class="organium_post_more">';
                                                echo '<a href="' . esc_url(get_permalink()) . '" class="read_more_button">' . esc_html__('Read More', 'organium_plugin') . '</a>';
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>

                                </div>
                            </div>
                    <?php
                    }
                ?>

                </div>

                <?php
                    if ($pagination == 'yes') {
                        ?>
                        <div class="organium_pagination">
                            <?php
                            echo get_the_posts_pagination(array(
                                'prev_text' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                                'next_text' => '<i class="fa fa-angle-right" aria-hidden="true"></i>'
                            ));
                            ?>
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