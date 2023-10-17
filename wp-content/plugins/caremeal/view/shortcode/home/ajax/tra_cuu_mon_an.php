<?php 
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
if (!empty($_POST['ten'])) {
	global $wpdb;
     $list_nguyen_lieu = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$_POST['ten'].'"' );
    if (!empty($list_nguyen_lieu)) {
       echo json_encode($list_nguyen_lieu);
    } else {
    	echo $_POST['ten'];
    }
}else {
	echo 1;
}
die();