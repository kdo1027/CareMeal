<?php
//--------------------------------------------------------------------------
//Mô tả plugin
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
/**
 * Plugin Name: Care Meal
 * Plugin URI: https://caremeal.vn/
 * Description: Plugin quản lý dinh dưỡng cho học sinh
 * Version: 1.0
 * Author: Nhóm Care Meal
 * Author URI: https://caremeal.vn/
 * License: GPLv2
 */

//--------------------------------------------------------------------------
//Khởi tạo đường dẫn đến thư mục plugin
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
define( 'CARE_MEAL_PATH', plugin_dir_path( __FILE__ ) );
define( 'CARE_MEAL_URL', plugin_dir_url( __FILE__ ) );

//--------------------------------------------------------------------------
//Thêm các file php
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
require_once 'admin/functions/functions.php';
require_once 'view/shortcode/user/user.php';
require_once 'view/shortcode/user/login.php';
require_once 'view/shortcode/user/quen_pass.php';
require_once 'view/shortcode/tra_cuu/tra_cuu.php';
require_once 'view/shortcode/home/home.php';
require_once 'view/shortcode/home/goi_y_mon_an_toi.php';
require_once 'view/shortcode/thuc_don/thuc_don.php';
require_once 'view/shortcode/thuc_don/hoc_sinh/hoc_sinh.php';
require_once 'view/shortcode/thuc_don/hoc_sinh/thuc_don_thang.php';
require_once 'view/shortcode/thuc_don/nha_truong/nha_truong.php';
require_once 'view/shortcode/thuc_don/phu_huynh/phu_huynh.php';
require_once 'view/shortcode/thuc_don/phu_huynh/thuc_don_thang.php';
//--------------------------------------------------------------------------
//Khởi tạo DB
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
function plugin_care_meal() {
	require_once 'admin/functions/create-database.php';
}
register_activation_hook( __FILE__, 'plugin_care_meal' );


