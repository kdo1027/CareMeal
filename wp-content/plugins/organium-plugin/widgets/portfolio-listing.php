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

class Organium_Portfolio_Listing_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_portfolio_listing';
    }

    public function get_title() {
        return esc_html__('Portfolio Listing', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-gallery-justified';
    }

    public function get_categories() {
        return ['organium_widgets'];
    }

    public function get_script_depends() {
        return ['portfolio_listing_widget'];
    }

    protected function _register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Portfolio Listing', 'organium_plugin')
            ]
        );

        $args = array(
            'post_type'     => 'organium-portfolio',
            'numberposts'   => '-1'
        );
        $all_portfolio = get_posts($args);
        $portfolio_list = array();

        if ($all_portfolio > 0) {
            foreach ($all_portfolio as $portfolio) {
                setup_postdata($portfolio);
                $portfolio_list[$portfolio->ID] = $portfolio->post_title;
            }
        } else {
            $portfolio_list = array(
                'no_posts' => esc_html__('No Posts Were Found', 'organium_plugin')
            );
        }

        $repeater = new Repeater();

        $repeater->add_control(
            'portfolio_item',
            [
                'label' => esc_html__('Choose Portfolio Item', 'organium_plugin'),
                'type' => Controls_Manager::SELECT2,
                'options' => $portfolio_list,
                'label_block' => true,
                'multiple' => false
            ]
        );

        $this->add_control(
            'portfolio',
            [
                'label' => esc_html__('Items', 'organium_plugin'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'prevent_empty' => false
            ]
        );

        $this->end_controls_section();

        // -------------------------------------- //
        // ---------- Content Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Portfolio Listing Settings', 'organium_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'listing_type',
            [
                'label' => esc_html__('Type', 'organium_plugin'),
                'type' => Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid'      => esc_html__('Grid', 'organium_plugin'),
                    'masonry'   => esc_html__('Masonry', 'organium_plugin')
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
            'filter',
            [
                'label' => esc_html__('Category Filter', 'organium_plugin'),
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
    }

    protected function render() {
        $settings = $this->get_settings();

        $listing_type = $settings['listing_type'];
        $columns_number = $settings['columns_number'];
        $filter = $settings['filter'];
        $portfolios = $settings['portfolio'];

        if ($listing_type == 'grid') {
            $cols = (int)$columns_number;
        } else {
            $cols = 3;
        }

        $wrapper_class = 'organium_archive_listing_wrapper organium_isotope_trigger' . ($listing_type == 'grid' && !empty($columns_number) ? ' grid_listing columns_' . esc_attr($columns_number) : '') . ($listing_type == 'masonry' ? ' masonry_listing' : '');

        $i = 1;

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="organium_portfolio_listing_widget<?php echo ($filter == 'show' ? esc_attr(' organium_isotope_filter') : '') ?>"<?php echo ($filter == 'show' ? ' data-columns="' . esc_attr($cols) . '" data-spacings="true"' : '') ?>>
            <?php
                if ( $filter == 'show' ) {
                    $terms = array();
                    foreach ($portfolios as $portfolio) {
                        $post_id = $portfolio['portfolio_item'];
                        $categories = get_the_terms($post_id, 'portfolio-category');
                        $terms = array_merge($terms, $categories);
                    }

                    if ( count( $terms ) > 1 ) {
                        echo "<div class='container filter_control_wrapper'>";

                        foreach ( $terms as $term ) {
                            $term_name = $term->name;
                            $filter_vals[$term->slug] = $term_name;
                        }
                        if ( $filter_vals > 1 ){
                            echo "<nav class='nav filter_control_list'>";
                                echo "<ul class='dots'>";
                                    echo "<li class='dot filter_control_item all active' data-value='all'>";
                                        echo esc_html__( 'All', 'organium' );
                                    echo "</li>";
                                    foreach ( $filter_vals as $term_slug => $term_name ){
                                        echo "<li class='dot filter_control_item' data-value='" . esc_html( $term_slug ) . "'>";
                                            echo esc_html( $term_name );
                                        echo "</li>";
                                    }
                                echo "</ul>";
                            echo "</nav>";
                        }

                        echo "</div>";
                    }
                }
            ?>
            <div class="organium_archive_listing">
                <div class="<?php echo esc_attr($wrapper_class); ?>">
                    <?php

                    echo '<div class="grid-sizer"></div>';

                    foreach ($portfolios as $portfolio) {
                        $post_id = $portfolio['portfolio_item'];
                        $portfolio_post = get_post($post_id);

                        $featured_image_url = get_the_post_thumbnail_url($post_id, 'full');
                        $image_alt_text = get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true);

                        $categories = get_the_terms($post_id, 'portfolio-category');
                        $cat_array = array();
                        foreach ( $categories as $category ) {
                            $category_name = $category->slug;
                            $cat_array[] = $category_name;
                        }
                        $cat_classes = ' all ' . implode(' ', $cat_array);

                        $item_class = 'organium_portfolio_item column_item organium_item_' . esc_attr($i) . esc_attr($cat_classes);

                        if (function_exists('aq_resize')) {
                            if ( $listing_type == 'grid' ) {
                                $featured_image_src = aq_resize(esc_url($featured_image_url), 960, 960, true, true, true);
                            } else {
                                $featured_image_src_large = aq_resize(esc_url($featured_image_url), 1280, 1280, true, true, true);
                                $featured_image_src_small = aq_resize(esc_url($featured_image_url), 640, 640, true, true, true);
                            }
                        } else {
                            $featured_image_src = $featured_image_url;
                        }
                        if ( $filter == 'show' && $listing_type == 'grid' ) {
                            $data_sizes = ' data-masonry-width="1" data-masonry-height="1"';
                        } else {
                            if ( $i == 2 || $i == 4 ) {
                                $data_sizes = ' data-masonry-width="2" data-masonry-height="2"';
                            } else {
                                $data_sizes = ' data-masonry-width="1" data-masonry-height="1"';
                            }
                        }
                        ?>

                        <div class="<?php echo esc_attr($item_class); ?> elementor-repeater-item-<?php echo esc_attr($portfolio['_id']); ?>"<?php echo esc_attr($data_sizes); ?>>
                            <a class="organium_portfolio_item_wrapper" href="<?php echo esc_url(get_permalink($post_id)); ?>">
                                <span class="organium_portfolio_item_overlay"></span>
                                <?php
                                if ( $listing_type == 'grid' ) {
                                    echo '<img src="' . esc_url($featured_image_src) . '" alt="' . esc_attr($image_alt_text) . '" class="organium_portfolio_img" />';
                                } else {
                                    if ( $i == 2 || $i == 4 ) {
                                        echo '<img src="' . esc_url($featured_image_src_large) . '" alt="' . esc_attr($image_alt_text) . '" class="organium_portfolio_img" />';
                                    } else {
                                        echo '<img src="' . esc_url($featured_image_src_small) . '" alt="' . esc_attr($image_alt_text) . '" class="organium_portfolio_img" />';
                                    }
                                }
                                ?>
                                <div class="organium_content_wrapper">
                                    <h6 class="organium_post_title"><?php echo esc_html($portfolio_post->post_title); ?></h6>
                                </div>
                            </a>
                        </div>
                        <?php

                        if ($i < 6) {
                            $i++;
                        } else {
                            $i = 1;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}