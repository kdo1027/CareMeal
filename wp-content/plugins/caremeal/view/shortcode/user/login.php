<?php
function create_shortcode_login() {
	ob_start();
	global $wpdb;
  ?>
  <div class="login-msg"></div>
  <?php
  wp_login_form();
  ?>
  <p>Chưa có tài khoản ? <a href="/dang-ky/">Đăng ký ngay</a></p>
  <?php
  $login = (isset($_GET['login']) ) ? $_GET['login'] : 0;
  if ( $login === "failed" ) { 
   echo '<p style="color:red" class="login-msg"> Tài khoản hoặc mật khẩu không chính xác.</p>'; 
 } 
 elseif ( $login === "empty" ) { 
   echo '<p style="color:red" class="login-msg"> Tài khoản hoặc mật khẩu không được để trống.</p>'; 
 } 
 elseif ( $login === "false" ) { 
   echo '<p style="color:red" class="login-msg"> Bạn đã đăng xuất.</p>'; 
 }
 $cm_login = ob_get_contents(); 
 ob_end_clean();
 return $cm_login;
}
add_shortcode( 'login', 'create_shortcode_login' );

/* Tự động chuyển đến một trang khác sau khi login */
function my_login_redirect( $redirect_to, $request, $user ) {
        //is there a user to check?
  global $user;
  if ( isset( $user->roles ) && is_array( $user->roles ) ) {
                //check for admins
    if ( in_array( 'administrator', $user->roles ) ) {
                        // redirect them to the default place
      return admin_url();
    } else {
      return 'https://caremeal.vn/thuc-don/';
    }
  } else {
    return $redirect_to;
  }
}

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );


// Kiểm tra lỗi đăng nhập
function login_failed() {
  $login_page  = home_url( '/dang-nhap/' );
  wp_redirect( $login_page . '?login=failed' );
  exit;
}
add_action( 'wp_login_failed', 'login_failed' );
// function verify_username_password( $user, $username, $password ) {
//   $login_page  = home_url( '/dang-nhap/' );
//   if( $username == "" || $password == "" ) {
//     wp_redirect( $login_page . "?login=empty" );
//     exit;
//   }
// }
// add_filter( 'authenticate', 'verify_username_password', 1, 3);