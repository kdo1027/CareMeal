<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
if (!empty($_POST['user_id'])) {
  global $wpdb;
  $check_sang = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$_POST['ngay'].'" AND user_id = "'.$_POST['user_id'].'" AND an_sang !="" ' );
  $check_trua = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$_POST['ngay'].'" AND user_id = "'.$_POST['user_id'].'" AND an_trua !="" ' );
  $check_toi = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$_POST['ngay'].'" AND user_id = "'.$_POST['user_id'].'" AND an_toi !="" ' );
  $check_phu = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$_POST['ngay'].'" AND user_id = "'.$_POST['user_id'].'" AND phu_toi !="" ' );
  if($check_sang){echo 1;}
  else{echo 2;}
  if($check_trua){echo 3;}
  else{echo 4;}
  if($check_toi){echo 5;}
  else{echo 6;}
  if($check_phu){echo 7;}
  else{echo 8;}
}else{
  echo 0;
}

die();