<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
if (!empty($_POST['id'])) {
  global $wpdb;
  $update = $wpdb->update( 
    $wpdb->prefix.'usermeta',
    array(
      'meta_value' => $_POST['chieu_cao'],
    ), 
    array( 
      'user_id' => $_POST['id'],
      'meta_key' => 'user_registration_input_box_1606738777',
    ), 
    '%s',
    '%s'
  );
  $update1 = $wpdb->update( 
    $wpdb->prefix.'usermeta',
    array(
      'meta_value' => $_POST['can_nang'],
    ), 
    array( 
      'user_id' => $_POST['id'],
      'meta_key' => 'user_registration_input_box_1606738754',
    ), 
    '%s',
    '%s'
  );
  if($update){
          echo 4;
        } else {
          echo 5;
        }
} else{
  echo 0;
}
die();