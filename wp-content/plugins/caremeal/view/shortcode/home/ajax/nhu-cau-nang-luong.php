<?php 
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
if (!empty($_POST['tuoi']) && !empty($_POST['gioi_tinh']) ) {
	global $wpdb;
    $nhu_cau_nang_luong = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_nang_luong WHERE tuoi = "'.$_POST['tuoi'].'" AND gioi_tinh = "'.$_POST['gioi_tinh'].'"' );
    if (!empty($nhu_cau_nang_luong)) {
        echo json_encode($nhu_cau_nang_luong);
    } else {
    	echo 0;
    }
}else {
	echo 0;
}
die();
