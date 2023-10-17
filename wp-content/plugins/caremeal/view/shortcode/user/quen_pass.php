<?php
function create_shortcode_quen_pass() {
	ob_start();
	add_action( 'wp_ajax_forgotajax', 'forgotajax_init' );
	add_action( 'wp_ajax_nopriv_forgotajax', 'forgotajax_init' );
	function forgotajax_init() {
		$email = (isset($_POST['usernamelog']))?esc_attr($_POST['usernamelog']) : '';
		$email = trim($email);
		$result ="";

		$random_password = wp_generate_password( 12, false );
		if (! is_email( $email )){
			$result ="NOT_EMAIL";
		}
		else if( ! email_exists( $email ) ) {
			$result ="NOT_HAVE_EMAIL";
		}
		else {
			$user = get_user_by( 'email', $email );
			$update_user = wp_update_user( array (
				'ID' => $user->ID, 
				'user_pass' => $random_password
			)
		);
			if( $update_user ) {
				$result ="CHANGE_SUCCES";   
				$to = $email;
				$subject = 'Mật khẩu mới của bạn';
				$sender = get_option('name');
				$message = 'Đây là mật khẩu mới của bạn: '.$random_password;

				$headers[] = 'MIME-Version: 1.0' . "\r\n";
				$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers[] = "X-Mailer: PHP \r\n";
				$headers[] = 'From: '.$sender.' < '.$email.'>' . "\r\n";

				$mail = wp_mail( $to, $subject, $message, $headers );
				if( $mail ){
					$result ="CHANGE_SUCCES";
				}

			} else {
				$result ="CHANGE_FAIL";   
			}
		}

		wp_send_json_success($result);
		die();
	}
	$cm_user = ob_get_contents(); 
	ob_end_clean();
	return $cm_user;
}
add_shortcode( 'quen_pass', 'create_shortcode_quen_pass' );