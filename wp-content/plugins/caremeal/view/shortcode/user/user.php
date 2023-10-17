<?php
function create_shortcode_user() {
	ob_start();
	header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT"); 
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header ("Cache-Control: no-cache, must-revalidate"); 
	header ("Pragma: no-cache");
	$vuba_version=uniqid();
	wp_enqueue_script('user_js', CARE_MEAL_URL .'view/shortcode/user/user.js', array(),$vuba_version, true);
	global $wpdb;
	?>
	<div>
		<h3>Đăng ký tài khoản</h3>
		<div class="cm-user-loai">
			<label>Chọn loại tài khoản
			<select name="loai_user">
				<option value="phu_huynh">Phụ huynh</option>
				<option value="hoc_sinh">Học sinh</option>
			</select>
			</label>
		</div>
		<div>
			<div class="cm-phu_huynh" style="display: block;">
				<?php echo do_shortcode('[user_registration_form id="3524"]'); ?>
			</div>
			<div class="cm-hoc_sinh" style="display: none">
				<?php echo do_shortcode('[user_registration_form id="3525"]'); ?>
			</div>
		</div>
	</div>
	<?php
	$cm_user = ob_get_contents(); 
	ob_end_clean();
	return $cm_user;
}
add_shortcode( 'user', 'create_shortcode_user' );