<?php
/*
Plugin Name: Organium Plugin
Plugin URI: https://demo.artureanec.com/
Description: Register Custom Widgets and Custom Post Types for Organium Theme.
Version: 1.0
Author: Artureanec
Author URI: https://demo.artureanec.com/
Text Domain: organium_plugin
*/

// --- Register Custom Widgets --- //
if (!function_exists('organium_widgets_load')) {
    function organium_widgets_load() {
        require_once(__DIR__ . "/widgets/address.php");
        require_once(__DIR__ . "/widgets/featured-posts.php");
        require_once(__DIR__ . "/widgets/recent-recipes.php");
        require_once(__DIR__ . "/widgets/recipes-categories.php");
        require_once(__DIR__ . "/widgets/banner.php");
        require_once(__DIR__ . "/widgets/socials.php");
    }
}
add_action('plugins_loaded', 'organium_widgets_load');

if (!function_exists('organium_add_custom_widget')) {
    function organium_add_custom_widget($name) {
        register_widget($name);
    }
}

// --- Register Custom Post Types --- //
if (!function_exists('organium_register_custom_post_types')) {
    function organium_register_custom_post_types() {
        # Portfolio
        register_taxonomy('portfolio-category', array('organium-portfolio'), array(
            'hierarchical' => true,
            'label' => esc_html__('Portfolio Categories', 'organium'),
            'singular_name' => esc_html__('Portfolio Category', 'organium')
        ));
        register_post_type('organium-portfolio', array(
                'label' => esc_html__('Portfolios', 'organium'),
                'labels' => array(
                    'name' => esc_html__('Portfolios', 'organium'),
                    'singular_name' => esc_html__('Portfolio', 'organium'),
                    'all_items' => esc_html__('All Portfolios', 'organium'),
                    'archives' => esc_html__('Portfolio', 'organium')
                ),
                'public' => true,
                'show_ui' => true,
                'show_in_nav_menus' => true,
                'rewrite' => array(
                    'slug' => 'portfolio',
                    'with_front' => false
                ),
                'hierarchical' => true,
                'menu_position' => 4,
                'menu_icon' => 'dashicons-format-gallery',
                'supports' => array(
                    'title',
                    'editor',
                    'author',
                    'thumbnail',
                    'excerpt'
                ),
                'taxonomies' => array( 'portfolio-category' ),
                'has_archive' => true
            )
        );

        # Recipes
        register_taxonomy('recipes-category', array('organium-recipes'), array(
            'hierarchical' => true,
            'label' => esc_html__('Recipe Categories', 'organium'),
            'singular_name' => esc_html__('Recipe Category', 'organium')
        ));
        register_post_type('organium-recipes', array(
                'label' => esc_html__('Recipes', 'organium'),
                'labels' => array(
                    'name' => esc_html__('Recipes', 'organium'),
                    'singular_name' => esc_html__('Recipe', 'organium'),
                    'all_items' => esc_html__('All Recipes', 'organium'),
                    'archives' => esc_html__('Recipes', 'organium')
                ),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => true,
                'menu_icon' => 'dashicons-format-aside',
                'capability_type' => 'post',
                'rewrite' => array(
                    'slug' => 'recipes',
                    'with_front' => false
                ),
                'hierarchical' => true,
                'menu_position' => 4,
                'supports' => array(
                    'title',
                    'editor',
                    'author',
                    'thumbnail',
                    'excerpt',
                    'comments'
                ),
                'taxonomies' => array( 'recipes-category' ),
                'has_archive' => true
            )
        );
    }
}

add_action('init', 'organium_register_custom_post_types');

/**
 * Title         : Aqua Resizer
 * Description   : Resizes WordPress images on the fly
 * Version       : 1.2.0
 * Author        : Syamil MJ
 * Author URI    : http://aquagraphite.com
 * License       : WTFPL - http://sam.zoy.org/wtfpl/
 * Documentation : https://github.com/sy4mil/Aqua-Resizer/
 *
 * @param string  $url      - (required) must be uploaded using wp media uploader
 * @param int     $width    - (required)
 * @param int     $height   - (optional)
 * @param bool    $crop     - (optional) default to soft crop
 * @param bool    $single   - (optional) returns an array if false
 * @param bool    $upscale  - (optional) resizes smaller images
 * @uses  wp_upload_dir()
 * @uses  image_resize_dimensions()
 * @uses  wp_get_image_editor()
 *
 * @return str|array
 */

if(!class_exists('Aq_Resize')) {
    class Aq_Resize
    {
        /**
         * The singleton instance
         */
        static private $instance = null;

        /**
         * No initialization allowed
         */
        private function __construct() {}

        /**
         * No cloning allowed
         */
        private function __clone() {}

        /**
         * For your custom default usage you may want to initialize an Aq_Resize object by yourself and then have own defaults
         */
        static public function getInstance() {
            if(self::$instance == null) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        /**
         * Run, forest.
         */
        public function process( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
            // Validate inputs.
            if ( ! $url || ( ! $width && ! $height ) ) return false;

            // Caipt'n, ready to hook.
            if ( true === $upscale ) add_filter( 'image_resize_dimensions', array($this, 'aq_upscale'), 10, 6 );

            // Define upload path & dir.
            $upload_info = wp_upload_dir();
            $upload_dir = $upload_info['basedir'];
            $upload_url = $upload_info['baseurl'];

            $http_prefix = "http://";
            $https_prefix = "https://";

            /* if the $url scheme differs from $upload_url scheme, make them match
               if the schemes differe, images don't show up. */
            if(!strncmp($url,$https_prefix,strlen($https_prefix))){ //if url begins with https:// make $upload_url begin with https:// as well
                $upload_url = str_replace($http_prefix,$https_prefix,$upload_url);
            }
            elseif(!strncmp($url,$http_prefix,strlen($http_prefix))){ //if url begins with http:// make $upload_url begin with http:// as well
                $upload_url = str_replace($https_prefix,$http_prefix,$upload_url);
            }


            // Check if $img_url is local.
            if ( false === strpos( $url, $upload_url ) ) return false;

            // Define path of image.
            $rel_path = str_replace( $upload_url, '', $url );
            $img_path = $upload_dir . $rel_path;

            // Check if img path exists, and is an image indeed.
            if ( ! file_exists( $img_path ) or ! getimagesize( $img_path ) ) return false;

            // Get image info.
            $info = pathinfo( $img_path );
            $ext = $info['extension'];
            list( $orig_w, $orig_h ) = getimagesize( $img_path );

            // Get image size after cropping.
            $dims = image_resize_dimensions( $orig_w, $orig_h, $width, $height, $crop );
            $dst_w = $dims[4];
            $dst_h = $dims[5];

            // Return the original image only if it exactly fits the needed measures.
            if ( ! $dims && ( ( ( null === $height && $orig_w == $width ) xor ( null === $width && $orig_h == $height ) ) xor ( $height == $orig_h && $width == $orig_w ) ) ) {
                $img_url = $url;
                $dst_w = $orig_w;
                $dst_h = $orig_h;
            } else {
                // Use this to check if cropped image already exists, so we can return that instead.
                $suffix = "{$dst_w}x{$dst_h}";
                $dst_rel_path = str_replace( '.' . $ext, '', $rel_path );
                $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

                if ( ! $dims || ( true == $crop && false == $upscale && ( $dst_w < $width || $dst_h < $height ) ) ) {
                    // Can't resize, so return false saying that the action to do could not be processed as planned.
                    return false;
                }
                // Else check if cache exists.
                elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
                    $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
                }
                // Else, we resize the image and return the new resized image url.
                else {

                    $editor = wp_get_image_editor( $img_path );

                    if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) )
                        return false;

                    $resized_file = $editor->save();

                    if ( ! is_wp_error( $resized_file ) ) {
                        $resized_rel_path = str_replace( $upload_dir, '', $resized_file['path'] );
                        $img_url = $upload_url . $resized_rel_path;
                    } else {
                        return false;
                    }

                }
            }

            // Okay, leave the ship.
            if ( true === $upscale ) remove_filter( 'image_resize_dimensions', array( $this, 'aq_upscale' ) );

            // Return the output.
            if ( $single ) {
                // str return.
                $image = $img_url;
            } else {
                // array return.
                $image = array (
                    0 => $img_url,
                    1 => $dst_w,
                    2 => $dst_h
                );
            }

            return $image;
        }

        /**
         * Callback to overwrite WP computing of thumbnail measures
         */
        function aq_upscale( $default, $orig_w, $orig_h, $dest_w, $dest_h, $crop ) {
            if ( ! $crop ) return null; // Let the wordpress default function handle this.

            // Here is the point we allow to use larger image size than the original one.
            $aspect_ratio = $orig_w / $orig_h;
            $new_w = $dest_w;
            $new_h = $dest_h;

            if ( ! $new_w ) {
                $new_w = intval( $new_h * $aspect_ratio );
            }

            if ( ! $new_h ) {
                $new_h = intval( $new_w / $aspect_ratio );
            }

            $size_ratio = max( $new_w / $orig_w, $new_h / $orig_h );

            $crop_w = round( $new_w / $size_ratio );
            $crop_h = round( $new_h / $size_ratio );

            $s_x = floor( ( $orig_w - $crop_w ) / 2 );
            $s_y = floor( ( $orig_h - $crop_h ) / 2 );

            return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
        }
    }
}

if(!function_exists('aq_resize')) {
    /**
     * This is just a tiny wrapper function for the class above so that there is no
     * need to change any code in your own WP themes. Usage is still the same :)
     */
    function aq_resize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
        $demo_url = 'https://organium.artureanec.com';
        $current_url = get_home_url();
        $aq_resize = Aq_Resize::getInstance();
        if ( strpos($url, $demo_url) === false ) {
            return $aq_resize->process( $url, $width, $height, $crop, $single, $upscale );
        } else {
            $url = str_replace($demo_url, $current_url, $url);
            return $aq_resize->process( $url, $width, $height, $crop, $single, $upscale );
        }
    }
}

// Init Custom Widgets for Elementor
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

final class Organium_Custom_Widgets
{
    const  VERSION = '1.0.0';
    const  MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const  MINIMUM_PHP_VERSION = '5.4';
    private static $_instance = null;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function i18n()
    {
        load_plugin_textdomain('organium_plugin', false, plugin_basename(dirname(__FILE__)) . '/languages');
    }

    public function init()
    {
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'organium_admin_notice_missing_main_plugin']);
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'organium_admin_notice_minimum_elementor_version']);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'organium_admin_notice_minimum_php_version']);
            return;
        }

        // Include Additional Files
        add_action('elementor/init', [$this, 'organium_include_additional_files']);

        // Add new Elementor Categories
        add_action('elementor/init', [$this, 'organium_add_elementor_category']);

        // Register Widget Scripts
        add_action('elementor/frontend/after_register_scripts', [$this, 'organium_register_widget_scripts']);

        add_action('wp_enqueue_scripts', function () {
            wp_localize_script('ajax_query_products', 'organium_ajaxurl',
                array(
                    'url' => admin_url('admin-ajax.php')
                )
            );
        });

        // Register Widget Styles
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'organium_register_widget_styles']);

        // Register New Widgets
        add_action('elementor/widgets/widgets_registered', [$this, 'organium_widgets_register']);

        // Register Editor Styles
        add_action('elementor/editor/before_enqueue_scripts', function () {
            wp_register_style('organium_elementor_admin', plugins_url('organium-plugin/css/organium_plugin_admin.css'));
            wp_enqueue_style('organium_elementor_admin');
        });
    }


    public function organium_admin_notice_missing_main_plugin() {
        $message = sprintf(
        /* translators: 1: Restbeef Core 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'organium_plugin'),
            '<strong>' . esc_html__('Restbeef Core', 'organium_plugin') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'organium_plugin') . '</strong>'
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function organium_admin_notice_minimum_elementor_version() {
        $message = sprintf(
        /* translators: 1: Restbeef Core 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'organium_plugin'),
            '<strong>' . esc_html__('Restbeef Core', 'organium_plugin') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'organium_plugin') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function organium_admin_notice_minimum_php_version() {
        $message = sprintf(
        /* translators: 1: Press Elements 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'organium_plugin'),
            '<strong>' . esc_html__('Press Elements', 'organium_plugin') . '</strong>',
            '<strong>' . esc_html__('PHP', 'organium_plugin') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function organium_include_additional_files() {

    }

    public function organium_add_elementor_category() {
        \Elementor\Plugin::$instance->elements_manager->add_category(
            'organium_widgets',
            [
                'title' => esc_html__('Organium Widgets', 'organium_plugin'),
                'icon' => 'fa fa-plug',
            ],
            5 // position
        );

    }

    public function organium_register_widget_scripts() {
        // Lib
        wp_register_script('fancybox', plugins_url('organium-plugin/js/lib/jquery.fancybox.min.js'), array('jquery'));
        wp_register_script('slick_slider', plugins_url('organium-plugin/js/lib/slick.min.js'), array('jquery'));
        wp_register_script('isotope', plugins_url('organium-plugin/js/lib/isotope.pkgd.min.js'), array('jquery', 'imagesloaded'));
        wp_register_script('plugin', plugins_url('organium-plugin/js/lib/jquery.plugin.js'), array('jquery'));
        wp_register_script('countdown', plugins_url('organium-plugin/js/lib/jquery.countdown.min.js'), array('jquery', 'plugin'));

        // Scripts
        wp_register_script('content_slider_widget', plugins_url('organium-plugin/js/content-slider-widget.js'), array('jquery', 'slick_slider', 'fancybox'));
        wp_register_script('tabs_widget', plugins_url('organium-plugin/js/tabs-widget.js'), array('jquery', 'fancybox'));
        wp_register_script('free_tabs_widget', plugins_url('organium-plugin/js/free-tabs-widget.js'), array('jquery'));
        wp_register_script('testimonials_widget', plugins_url('organium-plugin/js/testimonial-carousel-widget.js'), array('jquery', 'slick_slider'));
        wp_register_script('video_widget', plugins_url('organium-plugin/js/video-widget.js'), array('jquery'));
        wp_register_script('countdown_widget', plugins_url('organium-plugin/js/countdown-widget.js'), array('jquery', 'countdown'));
        wp_register_script('products_widget', plugins_url('organium-plugin/js/products-widget.js'), array('jquery', 'slick_slider'));
        wp_register_script('image_carousel_widget', plugins_url('organium-plugin/js/image-carousel-widget.js'), array('jquery', 'swiper'));
    }

    public function organium_register_widget_styles() {
        // Main Widgets Styles
        wp_register_style('organium_styles', plugins_url('organium-plugin/css/organium_plugin.css'));
        wp_enqueue_style('organium_styles');

        wp_register_style('fancybox_styles', plugins_url('organium-plugin/css/jquery.fancybox.min.css'));
        wp_enqueue_style('fancybox_styles');
    }

    public function organium_widgets_register() {

        // --- Include Widget Files --- //
        require_once __DIR__ . '/widgets/ad-banner.php';
        require_once __DIR__ . '/widgets/blog.php';
        require_once __DIR__ . '/widgets/button.php';
        require_once __DIR__ . '/widgets/content-slider.php';
        require_once __DIR__ . '/widgets/countdown.php';
        require_once __DIR__ . '/widgets/free-tabs.php';
        require_once __DIR__ . '/widgets/heading.php';
        require_once __DIR__ . '/widgets/icon-box.php';
        require_once __DIR__ . '/widgets/image.php';
        require_once __DIR__ . '/widgets/person.php';
        require_once __DIR__ . '/widgets/portfolio-listing.php';
        require_once __DIR__ . '/widgets/price-inline.php';
        require_once __DIR__ . '/widgets/price-item.php';
        require_once __DIR__ . '/widgets/price-schedule.php';
        require_once __DIR__ . '/widgets/promo.php';
        require_once __DIR__ . '/widgets/recent-posts.php';
        require_once __DIR__ . '/widgets/recipes-listing.php';
        require_once __DIR__ . '/widgets/tabs.php';
        require_once __DIR__ . '/widgets/testimonial-carousel.php';
        require_once __DIR__ . '/widgets/timeline.php';
        require_once __DIR__ . '/widgets/video.php';

        // --- Register Widgets --- //
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Ad_Banner_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Blog_Listing_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Button_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Content_Slider_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Countdown_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Free_Tabs_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Heading_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Icon_Box_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Image_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Person_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Portfolio_Listing_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Price_Inline_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Price_Item_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Price_Schedule_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Promo_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Recent_Posts_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Recipes_Listing_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Tabs_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Testimonial_Carousel_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Timeline_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Video_Widget());

        if (class_exists('WooCommerce')) {
            require_once __DIR__ . '/widgets/products.php';
            require_once __DIR__ . '/widgets/product-masonry.php';
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Products_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Product_Masonry_Widget());
        }

        if ( function_exists( 'wpforms' ) ) {
            require_once __DIR__ . '/widgets/wpforms.php';
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Organium\Widgets\Organium_Wpforms_Widget());
        }
    }
}

Organium_Custom_Widgets::instance();

add_action('elementor/element/before_section_end', function( $section, $section_id, $args ) {
    if( $section->get_name() == 'text-editor' && $section_id == 'section_editor' ){
        $section->add_control(
            'columns_number',
            [
                'label' => esc_html__('Number of Columns', 'organium_plugin'),
                'type' => Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => esc_html__('One Column', 'organium_plugin'),
                    '2' => esc_html__('Two Columns', 'organium_plugin'),
                    '3' => esc_html__('Three Columns', 'organium_plugin'),
                    '4' => esc_html__('Four Columns', 'organium_plugin')
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-text-editor' => 'column-count: {{VALUE}}'
                ]
            ]
        );
    }
}, 10, 3);

if ( did_action( 'elementor/loaded' ) ) {
    add_action('elementor/widgets/widgets_registered', function ($widget_manager) {
        $widget_manager->unregister_widget_type('tabs');
    }, 15);

    add_action('elementor/element/before_section_end', function ($element, $section_id, $args) {
        if ('counter' === $element->get_name() && 'section_counter' === $section_id) {
            $element->add_responsive_control(
                'info_align',
                [
                    'label' => esc_html__('Text Alignment', 'organium_plugin'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
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
                        '{{WRAPPER}} .elementor-counter .elementor-counter-title, {{WRAPPER}} .elementor-counter .elementor-counter-number-wrapper' => 'text-align: {{VALUE}};',
                    ],
                ]
            );
        }

        if ('image-carousel' === $element->get_name() && 'section_image_carousel' === $section_id) {
            $element->add_control(
                'view_style',
                [
                    'label'   => esc_html__('View Style', 'organium_plugin'),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'default' => 'style_1',
                    'options' => [
                        'style_1' => esc_html__('Style 1', 'organium_plugin'),
                        'style_2'  => esc_html__('Style 2', 'organium_plugin')
                    ],
                    'separator' => 'before',
                    'prefix_class' => 'image_',
                    'toggle' => false
                ]
            );
        }
//        if ( 'image-carousel' === $element->get_name() && 'section_image_carousel' === $section_id ) {
//            function get_script_depends() {
//                return ['image_carousel_widget'];
//            }
//            $scripts = new Widget_Image_Carousel();
//            $scripts->get_script_depends();
//        }
        if ('image-carousel' === $element->get_name() && 'section_style_navigation' === $section_id) {
            $element->remove_control('dots_position');
            $element->remove_control('dots_size');
            $element->remove_control('dots_color');
            $element->start_controls_tabs('button_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $element->start_controls_tab(
                'pagination_normal',
                [
                    'label' => esc_html__('Normal', 'organium_plugin')
                ]
            );

            $element->add_control(
                'dot_color',
                [
                    'label' => esc_html__('Pagination Dot Color', 'organium_plugin'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet:after' => 'background: {{VALUE}};'
                    ]
                ]
            );

            $element->add_control(
                'dot_border',
                [
                    'label' => esc_html__('Pagination Dot Border', 'organium_plugin'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->end_controls_tab();

            // ------------------------ //
            // ------ Active Tab ------ //
            // ------------------------ //
            $element->start_controls_tab(
                'pagination_active',
                [
                    'label' => esc_html__('Active', 'organium_plugin')
                ]
            );

            $element->add_control(
                'dot_active',
                [
                    'label' => esc_html__('Pagination Active Dot Color', 'organium_plugin'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active:after' => 'background: {{VALUE}};'
                    ]
                ]
            );

            $element->add_control(
                'dot_border_active',
                [
                    'label' => esc_html__('Pagination Active Dot Border', 'organium_plugin'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->end_controls_tab();

            $element->end_controls_tabs();
        }

        if ('image-carousel' === $element->get_name() && 'section_style_image' === $section_id) {
            $element->remove_control('image_spacing');
            $element->remove_control('image_spacing_custom');
            $element->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'image_shadow',
                    'selector' => '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .swiper-slide-image',
                ]
            );

            $element->add_control(
                'image_spacing',
                [
                    'label' => esc_html__( 'Spacing', 'organium_plugin' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        '' => esc_html__( 'Default', 'organium_plugin' ),
                        'custom' => esc_html__( 'Custom', 'organium_plugin' ),
                    ],
                    'default' => '',
                    'condition' => [
                        'slides_to_show!' => '1',
                    ],
                ]
            );
            $element->add_control(
                'image_spacing_custom',
                [
                    'label' => __( 'Image Spacing', 'organium_plugin' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'size' => 20,
                    ],
                    'show_label' => false,
                    'condition' => [
                        'image_spacing' => 'custom',
                        'slides_to_show!' => '1',
                    ],
                    'frontend_available' => true,
                    'render_type' => 'none',
                    'separator' => 'after',
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image-carousel-wrapper' => 'margin: -{{SIZE}}px; padding: {{SIZE}}px !important;'
                    ],
                ]
            );

            $element->add_control(
                'icon_color',
                [
                    'label' => esc_html__('Icon Color', 'organium_plugin'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-slide a:after' => 'color: {{VALUE}};'
                    ],
                    'separator' => 'before',
                    'condition' => [
                        'link_to' => ['file', 'custom']
                    ]
                ]
            );

            $element->add_control(
                'icon_bg_color',
                [
                    'label' => esc_html__('Icon Background Color', 'organium_plugin'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-slide a:after' => 'background-color: {{VALUE}};'
                    ],
                    'condition' => [
                        'link_to' => ['file', 'custom']
                    ]
                ]
            );

            $element->add_control(
                'overlay_color',
                [
                    'label' => esc_html__('Image Overlay Color', 'organium_plugin'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-slide a:before' => 'background-color: {{VALUE}};'
                    ],
                    'condition' => [
                        'link_to' => ['file', 'custom'],
                        'view_style' => 'style_2'
                    ]
                ]
            );


            $element->start_controls_tabs('frame_settings_tabs');

                // ------------------------ //
                // ------ Normal Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'frame_normal',
                    [
                        'label' => esc_html__('Normal', 'organium_plugin'),
                        'condition' => [
                            'link_to'    => ['file', 'custom'],
                            'view_style' => 'style_2'
                        ]
                    ]
                );

                    $element->add_control(
                        'frame_color',
                        [
                            'label' => esc_html__('Frame Color', 'organium_plugin'),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .swiper-slide a:before' => 'border-color: {{VALUE}};'
                            ],
                            'condition' => [
                                'link_to'    => ['file', 'custom'],
                                'view_style' => 'style_2'
                            ]
                        ]
                    );

                $element->end_controls_tab();

                // ------------------------ //
                // ------ Active Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'frame_hover',
                    [
                        'label' => esc_html__('Hover', 'organium_plugin'),
                        'condition' => [
                            'link_to'    => ['file', 'custom'],
                            'view_style' => 'style_2'
                        ]
                    ]
                );

                    $element->add_control(
                        'frame_color_hover',
                        [
                            'label' => esc_html__('Frame Color on Hover', 'organium_plugin'),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .swiper-slide a:hover:before' => 'border-color: {{VALUE}};'
                            ],
                            'condition' => [
                                'link_to'    => ['file', 'custom'],
                                'view_style' => 'style_2'
                            ]
                        ]
                    );

                $element->end_controls_tab();

            $element->end_controls_tabs();
        }
    }, 10, 3);
}