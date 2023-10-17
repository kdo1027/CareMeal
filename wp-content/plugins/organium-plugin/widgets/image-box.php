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
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Organium_Image_Box_Widget extends Widget_Base {

    public function get_name() {
        return 'organium_image_box';
    }

    public function get_title() {
        return esc_html__('Image Box', 'organium_plugin');
    }

    public function get_icon() {
        return 'eicon-image-box';
    }

    public function get_categories() {
        return ['organium_widgets'];
    }

    protected function _register_controls() {

    }

    protected function render() {

    }

    protected function content_template() {}

    public function render_plain_content() {}
}
