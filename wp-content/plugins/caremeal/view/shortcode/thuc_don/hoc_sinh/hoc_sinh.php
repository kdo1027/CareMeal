<?php 
function create_shortcode_hoc_sinh() { 
	ob_start();
	header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT"); 
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header ("Cache-Control: no-cache, must-revalidate"); 
	header ("Pragma: no-cache");
	$vuba_version=uniqid();
	wp_enqueue_script('bieu_do_js', CARE_MEAL_URL .'view/shortcode/thuc_don/hoc_sinh/js/highcharts.js', array(), false, true);
	wp_enqueue_script('hoc_sinh_js', CARE_MEAL_URL .'view/shortcode/thuc_don/hoc_sinh/js/hoc-sinh.js', array(), $vuba_version, true);
	global $wpdb;
	$user=wp_get_current_user();
	$user_id = $user->ID;
	date_default_timezone_set('Asia/Ho_Chi_Minh'); 
	$date= date("d/m/Y");
	$date1=getdate();
	$phuhuynh = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$date.'" AND user_id ="'.$user_id.'"' );
	$phuhuynh_sang =  $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$date.'" AND an_sang !="" AND user_id ="'.$user_id.'"' );
	$phuhuynh_trua = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$date.'" AND an_trua !=""' );
	$phuhuynh_toi = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$date.'" AND an_toi !="" AND user_id ="'.$user_id.'"' );
	$phuhuynh_phutoi = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$date.'" AND phu_toi !="" AND user_id ="'.$user_id.'"' );
	?>
	<div class="cm_thong_tin_hs">
		<h3><?php echo $user->display_name; ?> (ID: <span id="cm_us_id"><?php echo $user_id; ?>)</span></h3>
		<div class="cm_thong_tin_hs_1">
			<h6 class="cm_hs_gioi_tinh">Giới tính: <span><?php echo get_user_meta( $user_id, 'user_registration_radio_1606749096', true); ?></span></h6>
			<h6 class="cm_hs_tuoi">Ngày sinh: <span><?php echo get_user_meta( $user_id, 'user_registration_date_box_1606738801', true); ?></span></h6>
			<h6 class="cm_hs_chieu_cao">Chiều cao: <span><?php echo get_user_meta($user_id, 'user_registration_input_box_1606738777', true); ?></span>m</h6>
			<h6 class="cm_hs_can_nang">Cân nặng: <span><?php echo get_user_meta($user_id, 'user_registration_input_box_1606738754', true); ?></span>kg</h6>
		</div>
	</div>
	<div id="bmi">
	</div>

	<!-- DINH DƯỠNG HÔM NAY -->
	<div class="cm_truong_td_today">
		<h3>Thực đơn hôm nay - ngày <?php echo $date; ?></h3>
		<div class="nhucau_check">
			<h5>Dinh dưỡng đã dùng</h5>
			<table>
				<tr>
					<th>Năng lượng (kcal)</th>
					<th>Protein (g)</th>
					<th>Glucid (g)</th>
					<th>Lipid (g)</th>
					<th>Canxi (mg)</th>
					<th>Sắt (mg)</th>
					<th>Kẽm (mg)</th>
					<th>Xơ (g)</th>
				</tr>
				<tr class="nhucau_check_4123">
					<td><?php echo $phuhuynh->tong_nang_luong ?></td>
					<td><?php echo $phuhuynh->tong_protein ?></td>
					<td><?php echo $phuhuynh->tong_glucid ?></td>
					<td><?php echo $phuhuynh->tong_lipid ?></td>
					<td><?php echo $phuhuynh->tong_canxi ?></td>
					<td><?php echo $phuhuynh->tong_sat ?></td>
					<td><?php echo $phuhuynh->tong_kem ?></td>
					<td><?php echo $phuhuynh->tong_xo ?></td>
				</tr>
				<tr class="nhucau_check_4100">
					<?php
					$pt_protein=round((($phuhuynh->tong_protein)*4/($phuhuynh->tong_nang_luong))*100 , 2);
					$pt_lipid=round((($phuhuynh->tong_lipid)*9/($phuhuynh->tong_nang_luong))*100 , 2);
					$pt_glucid=round((100-$pt_protein-$pt_lipid), 2);
					?>
					<td>Tỷ lệ:</td>
					<td class="<?php if($pt_protein <= 13){echo "cl-thieu";} else if($pt_protein <= 20){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_protein>0){echo $pt_protein;}else{echo "0";}?>%</span></td>
					<td class="<?php if($pt_glucid <= 60){echo "cl-thieu";} else if($pt_glucid <= 65){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_glucid>0){echo $pt_glucid;}else{echo "0";}?>%</span></td>
					<td class="<?php if($pt_lipid <= 20){echo "cl-thieu";} else if($pt_lipid <= 30){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_lipid>0){echo $pt_lipid;}else{echo "0";}?>%</span></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Tỷ lệ chuẩn:</td>
					<td>13% - 20%</td>
					<td>50% - 65%</td>
					<td>20% - 30%</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		</div>
	</div>

	<!-- THỰC ĐƠN HÔM NAY -->
	<div class="ph_td_today_main">
		<div class="ph_td_today_main_ct">
			<!-- BỮA SÁNG -->
			<div id="ph_td_menu_s_ct" class="ph_td_ct_active">
				<a href="#" id="ph_td_menu_s" class="active"><i class="fa fa-caret-right"></i> Bữa sáng</a>
				<div class="ph_td_menu_s_ct_1 active">
					<?php
					if($phuhuynh && $phuhuynh_sang){
						$mon_an_day = $phuhuynh_sang->an_sang;
						$mon_an_day = explode(",",$mon_an_day);
						?>
						<table>
							<thead>
								<tr>
									<th style="width:6%">Ảnh</th>
									<th style="width:20%">Món ăn</th>
									<th style="width:14.5%">Năng lượng (kcal)</th>
									<th style="width:8.5%">Protein (g)</th>
									<th style="width:8.5%">Glucid (g)</th>
									<th style="width:8.5%">Lipid (g)</th>
									<th style="width:8.5%">Canxi (mg)</th>
									<th style="width:8.5%">Sắt (mg)</th>
									<th style="width:8.5%">Kẽm (gm)</th>
									<th style="width:8.5%">Xơ (g)</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$mon_an_sh=[];
								for($i=0;$i<count($mon_an_day)-1; $i++){
									$mon_an_sh[$i] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$i].'"');
									echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$i]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$i]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$i]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->lipid.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->canxi.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->sat.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->kem.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->xo.'</td></tr>';
								}
								?>
							</tbody>
							<tfoot>
								<tr>
									<th style="width:6%">Tổng</th>
									<th style="width:30%"></th>
									<th style="width:14.5%"><?php echo $phuhuynh->an_sang_nang_luong ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_sang_protein ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_sang_glucid ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_sang_lipid ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_sang_canxi ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_sang_sat ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_sang_kem ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_sang_xo ?></th>
								</tr>
							</tfoot>
						</table>
						<?php
					}
					else{
						echo '<p>Chưa có thực đơn cho bữa sáng</p>';
					}
					?>
				</div>
			</div>
			<!-- BỮA TRƯA -->
			<div id="ph_td_menu_tr_ct">
				<a href="#" id="ph_td_menu_tr" ><i class="fa fa-caret-right"></i> Bữa trưa</a>
				<div class="ph_td_menu_s_ct_2">
					<?php
					if($phuhuynh && $phuhuynh_trua){
						$mon_an_day = $phuhuynh_trua->an_trua;
						$mon_an_day = explode(",",$mon_an_day);
						?>
						<table>
							<thead>
								<tr>
									<th style="width:6%">Ảnh</th>
									<th style="width:20%">Món ăn</th>
									<th style="width:14.5%">Năng lượng (kcal)</th>
									<th style="width:8.5%">Protein (g)</th>
									<th style="width:8.5%">Glucid (g)</th>
									<th style="width:8.5%">Lipid (g)</th>
									<th style="width:8.5%">Canxi (mg)</th>
									<th style="width:8.5%">Sắt (mg)</th>
									<th style="width:8.5%">Kẽm (gm)</th>
									<th style="width:8.5%">Xơ (g)</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$mon_an_sh=[];
								for($i=0;$i<count($mon_an_day)-1; $i++){
									$mon_an_sh[$i] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$i].'"');
									echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$i]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$i]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$i]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->lipid.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->canxi.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->sat.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->kem.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->xo.'</td></tr>';
								}
								?>
							</tbody>
							<tfoot>
								<tr>
									<th style="width:6%">Tổng</th>
									<th style="width:30%"></th>
									<th style="width:14.5%"><?php echo $phuhuynh->an_trua_nang_luong ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_trua_protein ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_trua_glucid ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_trua_lipid ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_trua_canxi ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_trua_sat ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_trua_kem ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_trua_xo ?></th>
								</tr>
							</tfoot>
						</table>
						<?php

					}else{
						echo '<p>Chưa có thực đơn cho bữa trưa</p>';
					}
					?>
				</div>
			</div>
			<!-- BỮA TỐI -->
			<div id="ph_td_menu_t_ct">
				<a href="#" id="ph_td_menu_t"><i class="fa fa-caret-right"></i> Bữa tối</a>
				<div class="ph_td_menu_s_ct_3">
					<?php
					if($phuhuynh && $phuhuynh_toi){
						$mon_an_day = $phuhuynh_toi->an_toi;
						$mon_an_day = explode(",",$mon_an_day);
						?>
						<table>
							<thead>
								<tr>
									<th style="width:6%">Ảnh</th>
									<th style="width:20%">Món ăn</th>
									<th style="width:14.5%">Năng lượng (kcal)</th>
									<th style="width:8.5%">Protein (g)</th>
									<th style="width:8.5%">Glucid (g)</th>
									<th style="width:8.5%">Lipid (g)</th>
									<th style="width:8.5%">Canxi (mg)</th>
									<th style="width:8.5%">Sắt (mg)</th>
									<th style="width:8.5%">Kẽm (gm)</th>
									<th style="width:8.5%">Xơ (g)</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$mon_an_sh=[];
								for($i=0;$i<count($mon_an_day)-1; $i++){
									$mon_an_sh[$i] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$i].'"');
									echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$i]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$i]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$i]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->lipid.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->canxi.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->sat.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->kem.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->xo.'</td></tr>';
								}
								?>
							</tbody>
							<tfoot>
								<tr>
									<th style="width:6%">Tổng</th>
									<th style="width:30%"></th>
									<th style="width:14.5%"><?php echo $phuhuynh->an_toi_nang_luong ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_toi_protein ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_toi_glucid ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_toi_lipid ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_toi_canxi ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_toi_sat ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_toi_kem ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->an_toi_xo ?></th>
								</tr>
							</tfoot>
						</table>
						<?php

					}else{
						echo '<p>Chưa có thực đơn cho bữa tối  </p>';
					}
					?>
				</div>
			</div>
			<!-- BỮA PHỤ -->
			<div id="ph_td_menu_pt_ct">
				<a href="#" id="ph_td_menu_pt"><i class="fa fa-caret-right"></i> Bữa phụ</a>
				<div class="ph_td_menu_s_ct_4">
					<?php
					if($phuhuynh && $phuhuynh_phutoi){
						$mon_an_day = $phuhuynh_phutoi->phu_toi;
						$mon_an_day = explode(",",$mon_an_day);
						?>
						<table>
							<thead>
								<tr>
									<th style="width:6%">Ảnh</th>
									<th style="width:20%">Món ăn</th>
									<th style="width:14.5%">Năng lượng (kcal)</th>
									<th style="width:8.5%">Protein (g)</th>
									<th style="width:8.5%">Glucid (g)</th>
									<th style="width:8.5%">Lipid (g)</th>
									<th style="width:8.5%">Canxi (mg)</th>
									<th style="width:8.5%">Sắt (mg)</th>
									<th style="width:8.5%">Kẽm (gm)</th>
									<th style="width:8.5%">Xơ (g)</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$mon_an_sh=[];
								for($i=0;$i<count($mon_an_day)-1; $i++){
									$mon_an_sh[$i] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$i].'"');
									echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$i]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$i]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$i]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->lipid.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->canxi.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->sat.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->kem.'</td>
									<td style="width:8.5%">'.$mon_an_sh[$i]->xo.'</td></tr>';
								}
								?>
							</tbody>
							<tfoot>
								<tr>
									<th style="width:6%">Tổng</th>
									<th style="width:30%"></th>
									<th style="width:14.5%"><?php echo $phuhuynh->phu_toi_nang_luong ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->phu_toi_protein ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->phu_toi_glucid ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->phu_toi_lipid ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->phu_toi_canxi ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->phu_toi_sat ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->phu_toi_kem ?></th>
									<th style="width:8.5%"><?php echo $phuhuynh->phu_toi_xo ?></th>
								</tr>
							</tfoot>
						</table>
						<?php

					}else{
						echo '<p>Chưa có thực đơn cho bữa phụ  </p>';
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<!-- THỰC ĐƠN THÁNG -->
	<?php
	echo do_shortcode('[thu_don_thang]');
	?>

	<!-- BIỂU ĐỒ -->
	<div style="margin-top: 50px;">
		<h3>Thống kê dinh dưỡng tháng <?php if($date1['mon']<10) {echo "0".$date1['mon'];}else{echo $date1['mon'];} ?>/<?php echo $date1['year']; ?></h3>
		<?php 
		$results = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE user_id ="'.$user_id.'" ORDER BY ngay ASC'  );
		?>
		<div id="cm_ngay_1" style="display: none"> 
			<?php
			foreach ($results as $result) { echo $result->ngay.' ';} 
			?>
		</div>
		<div id="cm_nang_luong_1" style="display: none"> 
			<?php
			foreach ($results as $result) { echo $result->tong_nang_luong.' ';} 
			?>
		</div>
		<div id="cm_protein_1" style="display: none"> 
			<?php
			foreach ($results as $result) { echo $result->tong_protein.' ';} 
			?>
		</div>
		<div id="cm_glucid_1" style="display: none"> 
			<?php
			foreach ($results as $result) { echo $result->tong_glucid.' ';} 
			?>
		</div>
		<div id="cm_lipid_1" style="display: none"> 
			<?php
			foreach ($results as $result) { echo $result->tong_lipid.' ';} 
			?>
		</div>
		<div class="cm_flex">
			<figure class="highcharts-figure">
				<div id="container"></div>
			</figure>
			<figure class="highcharts-figure">
				<div id="container_1"></div>
			</figure>
			<figure class="highcharts-figure">
				<div id="container_2"></div>
			</figure>
			<figure class="highcharts-figure">
				<div id="container_3"></div>
			</figure>
		</div>
	</div>
	<?php
	$cm_hoc_sinh = ob_get_contents(); 
	ob_end_clean();
	return $cm_hoc_sinh;
}
add_shortcode( 'hoc_sinh', 'create_shortcode_hoc_sinh' );
