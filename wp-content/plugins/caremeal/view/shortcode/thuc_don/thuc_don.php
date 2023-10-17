<?php
function create_shortcode_cm_thuc_don() {
	ob_start();
	global $wpdb;
	if ( is_user_logged_in() ){
		setcookie("name", "test", time() + 600000000, "/");
		$user=wp_get_current_user();
		$user_roles=$user->roles;
		if($user_roles[0]=="nha_truong"){
			echo do_shortcode('[nha_truong]');
		}else if($user_roles[0]=="phu_huynh"){
			echo do_shortcode('[phu_huynh]');
		}else if($user_roles[0]=="hoc_sinh"){
			echo do_shortcode('[hoc_sinh]');
		}
	}else{
		?>
		<script type="text/javascript">
			alert("Bạn chưa đăng nhập");
			var width = jQuery(window).width();
			if(width<768){
				location.href="/wp-admin/";
			}
			else{
				location.href="/dang-nhap/";
			}
			
			
		</script>
		<?php
	}
	$cm_thuc_don = ob_get_contents(); 
	ob_end_clean();
	return $cm_thuc_don;
}
add_shortcode( 'cm_thuc_don', 'create_shortcode_cm_thuc_don' );