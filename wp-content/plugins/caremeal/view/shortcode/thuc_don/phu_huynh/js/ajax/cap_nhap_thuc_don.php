<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
if (!empty($_POST['user_id'])) {
  global $wpdb;
  $check_td=$wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_thuc_don WHERE ngay != ""' );
  if($check_td){
    foreach ($check_td as $check_tds) {
      $check = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$check_tds->ngay.'" AND user_id = "'.$_POST['user_id'].'"' );
      $check_trua = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$check_tds->ngay.'" AND an_trua !=""' );
      if($check){
        if($check_trua){
          echo 3;
        }
        else{
          $nang_luong=(float)$_POST['nang_luong']+$check[0]->an_sang_nang_luong+$check[0]->an_toi_nang_luong+$check[0]->phu_toi_nang_luong;
          $protein=(float)$_POST['protein']+$check[0]->an_sang_protein+$check[0]->an_toi_protein+$check[0]->phu_toi_protein;
          $glucid=(float)$_POST['glucid']+$check[0]->an_sang_glucid+$check[0]->an_toi_glucid+$check[0]->phu_toi_glucid;
          $lipid=(float)$_POST['lipid']+$check[0]->an_sang_lipid+$check[0]->an_toi_lipid+$check[0]->phu_toi_lipid;
          $canxi=(float)$_POST['canxi']+$check[0]->an_sang_canxi+$check[0]->an_toi_canxi+$check[0]->phu_toi_canxi;
          $sat=(float)$_POST['sat']+$check[0]->an_sang_sat+$check[0]->an_toi_sat+$check[0]->phu_toi_sat;
          $kem=(float)$_POST['kem']+$check[0]->an_sang_kem+$check[0]->an_toi_kem+$check[0]->phu_toi_kem;
          $xo=(float)$_POST['xo']+$check[0]->an_sang_xo+$check[0]->an_toi_xo+$check[0]->phu_toi_xo;
          $update = $wpdb->update( 
            $wpdb->prefix.'cm_thong_ke',
            array(
              'an_trua' => $check_tds->mon_an,
              'an_trua_nang_luong' => $check_tds->nang_luong,
              'an_trua_protein' => $check_tds->protein,
              'an_trua_glucid' => $check_tds->glucid,
              'an_trua_lipid' => $check_tds->lipid,
              'an_trua_canxi' => $check_tds->canxi,
              'an_trua_sat' => $check_tds->sat,
              'an_trua_kem' => $check_tds->kem,
              'an_trua_xo' => $check_tds->xo,
              'tong_nang_luong' => $nang_luong,
              'tong_protein' => $protein,
              'tong_glucid' => $glucid,
              'tong_lipid' => $lipid,
              'tong_canxi' => $canxi,
              'tong_sat' => $sat,
              'tong_kem' => $kem,
              'tong_xo' => $xo,
            ), 
            array(
             'ngay' => $check_tds->ngay,
             'user_id' => $_POST['user_id'],
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
      }
      else{    
        $insert = $wpdb->insert( 
          $wpdb->prefix.'cm_thong_ke',
          array(
            'user_id' => $_POST['user_id'],
            'ngay' => $check_tds->ngay,
            'an_trua' => $check_tds->mon_an,
            'an_trua_nang_luong' => $check_tds->nang_luong,
            'an_trua_protein' => $check_tds->protein,
            'an_trua_glucid' => $check_tds->glucid,
            'an_trua_lipid' => $check_tds->lipid,
            'an_trua_canxi' => $check_tds->canxi,
            'an_trua_sat' => $check_tds->sat,
            'an_trua_kem' => $check_tds->kem,
            'an_trua_xo' => $check_tds->xo,
            'tong_nang_luong' => $check_tds->nang_luong,
            'tong_protein' => $check_tds->protein,
            'tong_glucid' => $check_tds->glucid,
            'tong_lipid' => $check_tds->lipid,
            'tong_canxi' => $check_tds->canxi,
            'tong_sat' => $check_tds->sat,
            'tong_kem' => $check_tds->kem,
            'tong_xo' => $check_tds->xo,
          ), 
          '%s'
        );     

        if($insert){
          echo 6;
        } else{
          echo 7;
        }
      }
    }
  }
}else{
  echo 0;
}

die();