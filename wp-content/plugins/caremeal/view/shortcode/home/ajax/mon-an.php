<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
global $wpdb;
$list_monan_sang = $wpdb->get_results( 'SELECT ten FROM '.$wpdb->prefix.'cm_mon_an WHERE nhom LIKE "%sáng%" ' );
$list_monan_trua = $wpdb->get_results( 'SELECT ten FROM '.$wpdb->prefix.'cm_mon_an WHERE nhom NOT LIKE "%sáng%" ' );
if ($_POST['mon-an']=="sang") {	
    if (!empty($list_monan_sang)) {
        echo json_encode($list_monan_sang);
    } else {
    	echo 1;
    }
} else if ($_POST['mon-an']=="trua") {  
    if (!empty($list_monan_trua)) {
        echo json_encode($list_monan_trua);
    } else {
        echo 2;
    }
} else if ($_POST['mon-an']=="toi") {  
    if (!empty($list_monan_trua)) {
        echo json_encode($list_monan_trua);
    } else {
        echo 3;
    }
} else if ($_POST['mon-an']=="phu") {  
    if (!empty($list_monan_sang)) {
        echo json_encode($list_monan_sang);
    } else {
        echo 4;
    }
} else{
    echo 0;
}

die();

