<?php
//Hàm shortcode
function create_shortcode_dinh_duong_home() {
	ob_start();
	?>
	<style type="text/css">
		.home .organium_page_title_container{
			display: none !important;
		}
	</style>
	<?php
	$vuba_version=uniqid();
	wp_enqueue_script('bmi_dinh_duong_home_js', CARE_MEAL_URL .'view/shortcode/home/js/bmi_dinh_duong_home.js', array(),$vuba_version, true);
	global $wpdb;
	?>
	<div class="cm-dinh-duong-home-main">
		<div class="cm-nhap__thong-tin">
			<form class=" align-equal cm-nang-luong" action="" method="GET">
				<div class="cm-dinh-duong-home">
					<div class="elementor-row cm-dinh-duong-home_top">
						<div class="cm-tuoi cm-display-block elementor-column elementor-col-25 elementor-top-column">
							<h6>Ngày sinh</h6>
							<input type="date" name="ngay_sinh">
						</div> 

						<div class="cm-gioi -->__tinh cm-display-block elementor-column elementor-col-25 elementor-top-column">
							<h6>Giới tính</h6>
							<input type="text" name="gioi_tinh" style="display: none">
							<div class="gioi__tinh-ct">
								<label for="nam"><input type="radio" name="cm_gioi_tinh" value="nam" id="nam"> Nam</label>
								<label for="nu"><input type="radio" name="cm_gioi_tinh" value="nu" id="nu"> Nữ</label>
							</div>
						</div>
						<div class="cm-display-block cm-cang__nang elementor-column elementor-col-25 elementor-top-column" >
							<h6>Cân nặng (kg):</h6>
							<input type="number" name="can-nang" style="width: 50%;padding-left: 15px !important">
						</div>
						<div class="cm-chieu__cao cm-display-block elementor-column elementor-col-25 elementor-top-column">
							<h6>Chiều cao (m):</h6>
							<input type="number" name="chieu-cao" style="width: 50%; padding-left: 15px !important">
						</div>			
						<div class="cm-home-kq-btn">
							<p>Kết quả</p>
						</div>
					</div>	
					<div class="elementor-row" style="width: 98%" >
						<div class=" elementor-column elementor-col-100 elementor-top-column" >
							<div id="bmi" style="width: 100%; display: none" >
								
							</div>
						</div>
					</div>
					<div id="goi_y_dinh_duong" style="width: 100%; display: none" >

					</div>	
				</div>
			</form>
		</div>
	</div>
	<?php
	$bmi_dinh_duong_home = ob_get_contents(); 
	ob_end_clean();
	return $bmi_dinh_duong_home;
}
add_shortcode( 'dinh_duong_home', 'create_shortcode_dinh_duong_home' );