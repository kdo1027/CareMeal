<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
if (!empty($_POST['id'])) {
  global $wpdb;
  $update = $wpdb->update( 
    $wpdb->prefix.'usermeta',
    array(
      'meta_value' => $_POST['id'],
    ), 
    array( 
      'user_id' => $_POST['idp'],
      'meta_key' => 'user_registration_input_box_1606780902',
    ), 
    '%s',
    '%s'
  );
} else{
  echo 0;
}
die();