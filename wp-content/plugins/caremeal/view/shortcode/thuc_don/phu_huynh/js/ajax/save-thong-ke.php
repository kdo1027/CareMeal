<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
if (!empty($_POST['ngay'])) {
  global $wpdb;
  $check = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$_POST['ngay'].'" AND user_id = "'.$_POST['user_id'].'"' );
  $check_sang = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$_POST['ngay'].'" AND an_sang !="" AND user_id = "'.$_POST['user_id'].'"' );
  $check_trua = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$_POST['ngay'].'" AND an_trua !="" AND user_id = "'.$_POST['user_id'].'"' );
  $check_toi = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$_POST['ngay'].'" AND an_toi !="" AND user_id = "'.$_POST['user_id'].'"' );
  $check_phu_toi = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$_POST['ngay'].'" AND phu_toi !="" AND user_id = "'.$_POST['user_id'].'"' );
  if($check){   
    if($_POST['bua_an']=="sang"){
      if($check_sang){
        echo 3;
      } else{
        $nang_luong=(float)$_POST['nang_luong']+$check[0]->an_trua_nang_luong+$check[0]->an_toi_nang_luong+$check[0]->phu_toi_nang_luong;
        $protein=(float)$_POST['protein']+$check[0]->an_trua_protein+$check[0]->an_toi_protein+$check[0]->phu_toi_protein;
        $glucid=(float)$_POST['glucid']+$check[0]->an_trua_glucid+$check[0]->an_toi_glucid+$check[0]->phu_toi_glucid;
        $lipid=(float)$_POST['lipid']+$check[0]->an_trua_lipid+$check[0]->an_toi_lipid+$check[0]->phu_toi_lipid;
        $canxi=(float)$_POST['canxi']+$check[0]->an_trua_canxi+$check[0]->an_toi_canxi+$check[0]->phu_toi_canxi;
        $sat=(float)$_POST['sat']+$check[0]->an_trua_sat+$check[0]->an_toi_sat+$check[0]->phu_toi_sat;
        $kem=(float)$_POST['kem']+$check[0]->an_trua_kem+$check[0]->an_toi_kem+$check[0]->phu_toi_kem;
        $xo=(float)$_POST['xo']+$check[0]->an_trua_xo+$check[0]->an_toi_xo+$check[0]->phu_toi_xo;
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
            'ngay' => $_POST['ngay'],
            'user_id' => $_POST['user_id'],
          ), 
          '%s',
          '%s'
        );
        if($update){
          echo 1;
        }else{
          echo 2;
        }  
      }
    }
    if($_POST['bua_an']=="trua"){
      if($check_trua){
        echo 3;
      } else{
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
            'an_trua' => $_POST['mon_an'],
            'an_trua_nang_luong' => $_POST['nang_luong'],
            'an_trua_protein' => $_POST['protein'],
            'an_trua_glucid' => $_POST['glucid'],
            'an_trua_lipid' => $_POST['lipid'],
            'an_trua_canxi' => $_POST['canxi'],
            'an_trua_sat' => $_POST['sat'],
            'an_trua_kem' => $_POST['kem'],
            'an_trua_xo' => $_POST['xo'],
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
            'ngay' => $_POST['ngay'],
            'user_id' => $_POST['user_id'],
          ), 
          '%s',
          '%s'
        );
        if($update){
          echo 1;
        }else{
          echo 2;
        }  
      }
    }
    if($_POST['bua_an']=="toi"){
      if($check_toi){
        echo 3;
      } else{
        $nang_luong=(float)$_POST['nang_luong']+$check[0]->an_trua_nang_luong+$check[0]->an_sang_nang_luong+$check[0]->phu_toi_nang_luong;
        $protein=(float)$_POST['protein']+$check[0]->an_trua_protein+$check[0]->an_sang_protein+$check[0]->phu_toi_protein;
        $glucid=(float)$_POST['glucid']+$check[0]->an_trua_glucid+$check[0]->an_sang_glucid+$check[0]->phu_toi_glucid;
        $lipid=(float)$_POST['lipid']+$check[0]->an_trua_lipid+$check[0]->an_sang_lipid+$check[0]->phu_toi_lipid;
        $canxi=(float)$_POST['canxi']+$check[0]->an_trua_canxi+$check[0]->an_sang_canxi+$check[0]->phu_toi_canxi;
        $sat=(float)$_POST['sat']+$check[0]->an_trua_sat+$check[0]->an_sang_sat+$check[0]->phu_toi_sat;
        $kem=(float)$_POST['kem']+$check[0]->an_trua_kem+$check[0]->an_sang_kem+$check[0]->phu_toi_kem;
        $xo=(float)$_POST['xo']+$check[0]->an_trua_xo+$check[0]->an_sang_xo+$check[0]->phu_toi_xo;
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
            'ngay' => $_POST['ngay'],
            'user_id' => $_POST['user_id'],
          ), 
          '%s',
          '%s'
        );
        if($update){
          echo 1;
        }else{
          echo 2;
        }  
      }
    }
    if($_POST['bua_an']=="phu_toi"){
      if($check_phu_toi){
        echo 3;
      } else{
        $nang_luong=(float)$_POST['nang_luong']+$check[0]->an_trua_nang_luong+$check[0]->an_sang_nang_luong+$check[0]->an_toi_nang_luong;
        $protein=(float)$_POST['protein']+$check[0]->an_trua_protein+$check[0]->an_sang_protein+$check[0]->an_toi_protein;
        $glucid=(float)$_POST['glucid']+$check[0]->an_trua_glucid+$check[0]->an_sang_glucid+$check[0]->an_toi_glucid;
        $lipid=(float)$_POST['lipid']+$check[0]->an_trua_lipid+$check[0]->an_sang_lipid+$check[0]->an_toi_lipid;
        $canxi=(float)$_POST['canxi']+$check[0]->an_trua_canxi+$check[0]->an_sang_canxi+$check[0]->an_toi_canxi;
        $sat=(float)$_POST['sat']+$check[0]->an_trua_sat+$check[0]->an_sang_sat+$check[0]->an_toi_sat;
        $kem=(float)$_POST['kem']+$check[0]->an_trua_kem+$check[0]->an_sang_kem+$check[0]->an_toi_kem;
        $xo=(float)$_POST['xo']+$check[0]->an_trua_xo+$check[0]->an_sang_xo+$check[0]->an_toi_xo;
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
            'ngay' => $_POST['ngay'],
            'user_id' => $_POST['user_id'],
          ), 
          '%s',
          '%s'
        );
        if($update){
          echo 1;
        }else{
          echo 2;
        }  
      }
    }
  } else{
   if($_POST['bua_an']=="sang"){     
    $insert = $wpdb->insert( 
      $wpdb->prefix.'cm_thong_ke',
      array(
        'user_id' => $_POST['user_id'],
        'ngay' => $_POST['ngay'],
        'an_sang' => $_POST['mon_an'],
        'an_sang_nang_luong' => $_POST['nang_luong'],
        'an_sang_protein' => $_POST['protein'],
        'an_sang_glucid' => $_POST['glucid'],
        'an_sang_lipid' => $_POST['lipid'],
        'an_sang_canxi' => $_POST['canxi'],
        'an_sang_sat' => $_POST['sat'],
        'an_sang_kem' => $_POST['kem'],
        'an_sang_xo' => $_POST['xo'],
        'tong_nang_luong' => $_POST['nang_luong'],
        'tong_protein' => $_POST['protein'],
        'tong_glucid' => $_POST['glucid'],
        'tong_lipid' => $_POST['lipid'],
        'tong_canxi' => $_POST['canxi'],
        'tong_sat' => $_POST['sat'],
        'tong_kem' => $_POST['kem'],
        'tong_xo' => $_POST['xo'],
      ), 
      '%s'
    ); 
    if($insert){
      echo 1;
    }else{
      echo 2;
    }  
  }
  if($_POST['bua_an']=="trua"){     
    $insert = $wpdb->insert( 
      $wpdb->prefix.'cm_thong_ke',
      array(
        'user_id' => $_POST['user_id'],
        'ngay' => $_POST['ngay'],
        'an_trua' => $_POST['mon_an'],
        'an_trua_nang_luong' => $_POST['nang_luong'],
        'an_trua_protein' => $_POST['protein'],
        'an_trua_glucid' => $_POST['glucid'],
        'an_trua_lipid' => $_POST['lipid'],
        'an_trua_canxi' => $_POST['canxi'],
        'an_trua_sat' => $_POST['sat'],
        'an_trua_kem' => $_POST['kem'],
        'an_trua_xo' => $_POST['xo'],
        'tong_nang_luong' => $_POST['nang_luong'],
        'tong_protein' => $_POST['protein'],
        'tong_glucid' => $_POST['glucid'],
        'tong_lipid' => $_POST['lipid'],
        'tong_canxi' => $_POST['canxi'],
        'tong_sat' => $_POST['sat'],
        'tong_kem' => $_POST['kem'],
        'tong_xo' => $_POST['xo'],
      ), 
      '%s'
    ); 
    if($insert){
      echo 1;
    }else{
      echo 2;
    }  
  }
  if($_POST['bua_an']=="toi"){     
    $insert = $wpdb->insert( 
      $wpdb->prefix.'cm_thong_ke',
      array(
        'user_id' => $_POST['user_id'],
        'ngay' => $_POST['ngay'],
        'an_toi' => $_POST['mon_an'],
        'an_toi_nang_luong' => $_POST['nang_luong'],
        'an_toi_protein' => $_POST['protein'],
        'an_toi_glucid' => $_POST['glucid'],
        'an_toi_lipid' => $_POST['lipid'],
        'an_toi_canxi' => $_POST['canxi'],
        'an_toi_sat' => $_POST['sat'],
        'an_toi_kem' => $_POST['kem'],
        'an_toi_xo' => $_POST['xo'],
        'tong_nang_luong' => $_POST['nang_luong'],
        'tong_protein' => $_POST['protein'],
        'tong_glucid' => $_POST['glucid'],
        'tong_lipid' => $_POST['lipid'],
        'tong_canxi' => $_POST['canxi'],
        'tong_sat' => $_POST['sat'],
        'tong_kem' => $_POST['kem'],
        'tong_xo' => $_POST['xo'],
      ), 
      '%s'
    ); 
    if($insert){
      echo 1;
    }else{
      echo 2;
    }  
  }
  if($_POST['bua_an']=="phu_toi"){     
    $insert = $wpdb->insert( 
      $wpdb->prefix.'cm_thong_ke',
      array(
        'user_id' => $_POST['user_id'],
        'ngay' => $_POST['ngay'],
        'phu_toi' => $_POST['mon_an'],
        'phu_toi_nang_luong' => $_POST['nang_luong'],
        'phu_toi_protein' => $_POST['protein'],
        'phu_toi_glucid' => $_POST['glucid'],
        'phu_toi_lipid' => $_POST['lipid'],
        'phu_toi_canxi' => $_POST['canxi'],
        'phu_toi_sat' => $_POST['sat'],
        'phu_toi_kem' => $_POST['kem'],
        'phu_toi_xo' => $_POST['xo'],
        'tong_nang_luong' => $_POST['nang_luong'],
        'tong_protein' => $_POST['protein'],
        'tong_glucid' => $_POST['glucid'],
        'tong_lipid' => $_POST['lipid'],
        'tong_canxi' => $_POST['canxi'],
        'tong_sat' => $_POST['sat'],
        'tong_kem' => $_POST['kem'],
        'tong_xo' => $_POST['xo'],
      ), 
      '%s'
    ); 
    if($insert){
      echo 1;
    }else{
      echo 2;
    }  
  }
}
}else{
  echo 0;
}

die();