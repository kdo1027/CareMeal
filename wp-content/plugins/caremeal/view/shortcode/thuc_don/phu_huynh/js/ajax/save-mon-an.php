<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
if (!empty($_POST['ten'])) {
  global $wpdb;
  $check = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$_POST['ten'].'"' );
  if($check){
    echo 1;
  }
  else{
    echo 2;
    $insert = $wpdb->insert( 
      $wpdb->prefix.'cm_mon_an', 
      array( 
        'ten' => $_POST['ten'],
        'nang_luong' => $_POST['nang_luong'],
        'protein' => $_POST['protein'],
        'lipid' => $_POST['lipid'],
        'glucid' => $_POST['glucid'], 
        'canxi' => $_POST['canxi'],
        'sat' => $_POST['sat'],
        'kem' => $_POST['kem'],
        'xo' => $_POST['xo'],
      ), 
      '%s'
    );
  }

} else{
  echo 0;
}
die();