<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
if (!empty($_POST['id'])) {
  global $wpdb;
  if($_POST['bua_an']=="an_sang"){
    $update = $wpdb->update( 
      $wpdb->prefix.'cm_thong_ke',
      array(
        'an_sang' => $_POST['mon_an'],
        'an_sang_nang_luong' => $_POST['nang_luong'],
        'an_sang_protein' => $_POST['protein'],
        'an_sang_glucid' => $_POST['glucid'],
        'an_sang_lipid' => $_POST['lipid'],
        'an_sang_canxi' => $_POST['canxi'],
        'an_sang_sat' => $_POST['sat'],
        'an_sang_kem' => $_POST['kem'],
        'an_sang_xo' => $_POST['xo'],
        'tong_nang_luong' => $_POST['tong_nang_luong'],
        'tong_protein' => $_POST['tong_protein'],
        'tong_glucid' => $_POST['tong_glucid'],
        'tong_lipid' => $_POST['tong_lipid'],
        'tong_canxi' => $_POST['tong_canxi'],
        'tong_sat' => $_POST['tong_sat'],
        'tong_kem' =>$_POST['tong_kem'],
        'tong_xo' =>$_POST['tong_xo'],
      ), 
      array(
       'ngay' => $_POST['ngay'],
       'user_id' => $_POST['id'],
     ), 
      '%s',
      '%s'
    );
  }
  if($_POST['bua_an']=="an_trua"){
    $update = $wpdb->update( 
      $wpdb->prefix.'cm_thong_ke',
      array(
        'an_trua' => $_POST['mon_an'],
        'an_trua_nang_luong' => $_POST['nang_luong'],
        'an_trua_protein' => $_POST['protein'],
        'an_trua_glucid' => $_POST['glucid'],
        'an_trua_lipid' => $_POST['lipid'],
        'an_trua_canxi' => $_POST['canxi'],
        'an_trua_sat' => $_POST['sat'],
        'an_trua_kem' => $_POST['kem'],
        'an_trua_xo' => $_POST['xo'],
        'tong_nang_luong' => $_POST['tong_nang_luong'],
        'tong_protein' => $_POST['tong_protein'],
        'tong_glucid' => $_POST['tong_glucid'],
        'tong_lipid' => $_POST['tong_lipid'],
        'tong_canxi' => $_POST['tong_canxi'],
        'tong_sat' => $_POST['tong_sat'],
        'tong_kem' =>$_POST['tong_kem'],
        'tong_xo' =>$_POST['tong_xo'],
      ), 
      array(
       'ngay' => $_POST['ngay'],
       'user_id' => $_POST['id'],
     ), 
      '%s',
      '%s'
    );
  }
  if($_POST['bua_an']=="an_toi"){
    $update = $wpdb->update( 
      $wpdb->prefix.'cm_thong_ke',
      array(
        'an_toi' => $_POST['mon_an'],
        'an_toi_nang_luong' => $_POST['nang_luong'],
        'an_toi_protein' => $_POST['protein'],
        'an_toi_glucid' => $_POST['glucid'],
        'an_toi_lipid' => $_POST['lipid'],
        'an_toi_canxi' => $_POST['canxi'],
        'an_toi_sat' => $_POST['sat'],
        'an_toi_kem' => $_POST['kem'],
        'an_toi_xo' => $_POST['xo'],
        'tong_nang_luong' => $_POST['tong_nang_luong'],
        'tong_protein' => $_POST['tong_protein'],
        'tong_glucid' => $_POST['tong_glucid'],
        'tong_lipid' => $_POST['tong_lipid'],
        'tong_canxi' => $_POST['tong_canxi'],
        'tong_sat' => $_POST['tong_sat'],
        'tong_kem' =>$_POST['tong_kem'],
        'tong_xo' =>$_POST['tong_xo'],
      ), 
      array(
       'ngay' => $_POST['ngay'],
       'user_id' => $_POST['id'],
     ), 
      '%s',
      '%s'
    );
  }
  if($_POST['bua_an']=="phu_toi"){
    $update = $wpdb->update( 
      $wpdb->prefix.'cm_thong_ke',
      array(
        'phu_toi' => $_POST['mon_an'],
        'phu_toi_nang_luong' => $_POST['nang_luong'],
        'phu_toi_protein' => $_POST['protein'],
        'phu_toi_glucid' => $_POST['glucid'],
        'phu_toi_lipid' => $_POST['lipid'],
        'phu_toi_canxi' => $_POST['canxi'],
        'phu_toi_sat' => $_POST['sat'],
        'phu_toi_kem' => $_POST['kem'],
        'phu_toi_xo' => $_POST['xo'],
        'tong_nang_luong' => $_POST['tong_nang_luong'],
        'tong_protein' => $_POST['tong_protein'],
        'tong_glucid' => $_POST['tong_glucid'],
        'tong_lipid' => $_POST['tong_lipid'],
        'tong_canxi' => $_POST['tong_canxi'],
        'tong_sat' => $_POST['tong_sat'],
        'tong_kem' =>$_POST['tong_kem'],
        'tong_xo' =>$_POST['tong_xo'],
      ), 
      array(
       'ngay' => $_POST['ngay'],
       'user_id' => $_POST['id'],
     ), 
      '%s',
      '%s'
    );
  }

  if($update){
    echo 4;
  } else {
    echo 5;
  }

}else{
  echo 0;
}

die();