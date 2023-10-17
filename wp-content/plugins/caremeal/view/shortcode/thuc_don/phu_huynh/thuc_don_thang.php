<?php
function create_shortcode_thuc_don_phu_huynh() {
	ob_start();
	global $wpdb;
	$user=wp_get_current_user();
	$user_id = $user->ID;
	$list_user=$wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'users WHERE ID != ""');
	$id_hs=get_user_meta( $user_id, 'user_registration_input_box_1606780902', true);
	date_default_timezone_set('Asia/Ho_Chi_Minh'); 
	$date= date("d/m/Y");
	$date1=getdate();
	$vb_ngay_num=0;
	switch($date1['mon']){
		case "1":
		case "3":
		case "5":
		case "7":
		case "8":
		case "10":
		case "12":{
			$vb_ngay_num=31;
			break;
		}		
		case  "4":
		case  "6":
		case  "9":
		case  "11":{
			$vb_ngay_num=30;
			break;
		}		
		case "2":{
			$vb_ngay_num=28;
			break;
		}
		
	}
	$vb_tuan=0;
	$vb_thu_start="";
	for($i=1;$i<=$vb_ngay_num;$i++){
		$dateint = mktime(0, 0, 0, $date1['mon'], $i, 2021);
		$ngay= date('d/m/Y', $dateint);
		$thu = date('l', $dateint);
		if($i==1 && $thu !="Monday"){
			$vb_tuan++;
		}
		else{
			$vb_thu_start="Monday";
		}
		if($i==1 && $thu =="Tuesday"){
			$vb_thu_start="Tuesday";
		}
		if($i==1 && $thu =="Wednesday"){
			$vb_thu_start="Wednesday";
		}
		if($i==1 && $thu =="Thursday"){
			$vb_thu_start="Thursday";
		}
		if($i==1 && $thu =="Friday"){
			$vb_thu_start="Friday";
		}
		if($i==1 && $thu =="Saturday"){
			$vb_thu_start="Saturday";
		}
		if($i==1 && $thu =="Sunday"){
			$vb_thu_start="Sunday";
		}
		if($thu=="Monday"){
			$vb_tuan++;
		}
		if($thu=="Tuesday"){
		}
		if($thu=="Wednesday"){
		}
		if($thu=="Thursday"){
		}
		if($thu=="Friday"){
		}
		if($thu=="Saturday"){
		}
		if($thu=="Sunday"){
			
		}
	}
	if($date1['mon']<10){
		$date1_mon="0".$date1['mon'];
	}
	else{
		$date1_mon=$date1['mon'];
	}
	?>
	<!-- ThỰC ĐƠN THEO THÁNG -->
	<div class="cm_nha_truong_thuc_don_thang">
		<h3>Thực đơn Tháng <?php if($date1['mon']<10) {echo "0".$date1['mon'];}else{echo $date1['mon'];} ?>/<?php echo $date1['year']; ?></h3>
		<div class="cm_tab">
			<a href="#" id="tuan_1" class="active">Tuần 1</a>
			<a href="#" id="tuan_2">Tuần 2</a>
			<a href="#" id="tuan_3">Tuần 3</a>
			<a href="#" id="tuan_4">Tuần 4</a>
			<?php
			if($vb_tuan==5){
				echo '<a href="#" id="tuan_5">Tuần 5</a>';
			}
			?>	
		</div>
		<div class="cm_tab_ct">
			<!-- TUẦN 1 -->
			<div id="tuan_1_ct" class="active">
				<ul>
					<?php
					for($i=1;$i<8;$i++){
						if(($i+1)<8){
							echo '<li id="nd_tuan_1_'.$i.'">Thứ '.($i+1).'<span>(0'.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';
						}
						else{
							echo '<li id="nd_tuan_1_'.$i.'">Chủ nhật <span>(0'.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';	
						}						
					}
					?>
				</ul>
				<div class="cm_tab_content_tuan">
					<?php
					for($i=1;$i<8;$i++){
						$vb_ngay_check='0'.$i.'/'.$date1_mon.'/'.$date1['year'];
						//$cm_check_ngay = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thuc_don WHERE ngay = "'.$vb_ngay_check.'"');
						$phuhuynh = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND user_id ="'.$id_hs.'"' );
						$phuhuynh_sang =  $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_sang !="" AND user_id ="'.$id_hs.'"' );
						$phuhuynh_trua = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_trua !=""' );
						$phuhuynh_toi = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_toi !="" AND user_id ="'.$id_hs.'"' );
						$phuhuynh_phutoi = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND phu_toi !="" AND user_id ="'.$id_hs.'"' );
						//if($cm_check_ngay){
						echo '<div id="nd_tuan_1_'.$i.'_ct">';
						?>
						<!-- NHU CẦU DINH DƯỠNG -->
						<div class="nhucau_check">
							<table>
								<tr>
									<th></th>
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
									<td><h5>Dinh dưỡng đã dùng</h5></td>
									<td><?php echo $phuhuynh->tong_nang_luong ?></td>
									<td><?php echo $phuhuynh->tong_protein ?></td>
									<td><?php echo $phuhuynh->tong_glucid ?></td>
									<td><?php echo $phuhuynh->tong_lipid ?></td>
									<td><?php echo $phuhuynh->tong_canxi ?></td>
									<td><?php echo $phuhuynh->tong_sat ?></td>
									<td><?php echo $phuhuynh->tong_kem ?></td>
									<td><?php echo $phuhuynh->tong_xo ?></td>
								</tr>
								<tr class="nhucau_con_lai_4124">
									<td><h5>Dinh Dưỡng Còn Lại</h5></td>
								</tr>
								<tr class="nhucau_check_4100">
									<?php
									$pt_protein=round((($phuhuynh->tong_protein)*4/($phuhuynh->tong_nang_luong))*100 , 2);
									$pt_lipid=round((($phuhuynh->tong_lipid)*9/($phuhuynh->tong_nang_luong))*100 , 2);
									$pt_glucid=round((100-$pt_protein-$pt_lipid), 2);
									?>
									<td>Tỷ lệ:</td>
									<td></td>
									<td class="<?php if($pt_protein <= 13){echo "cl-thieu";} else if($pt_protein <= 20){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_protein>0){echo $pt_protein;}else{echo "0";}?>%</span></td>
									<td class="<?php if($pt_glucid <= 50){echo "cl-thieu";} else if($pt_glucid <= 65){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_glucid>0){echo $pt_glucid;}else{echo "0";}?>%</span></td>
									<td class="<?php if($pt_lipid <= 20){echo "cl-thieu";} else if($pt_lipid <= 30){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_lipid>0){echo $pt_lipid;}else{echo "0";}?>%</span></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Tỷ lệ chuẩn:</td>
									<td></td>
									<td style="padding: 0">13% - 20%</td>
									<td style="padding: 0">50% - 65%</td>
									<td style="padding: 0">20% - 30%</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</table>
						</div>
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa sáng  <a href="#" class="cm_them_bua_sang">Thêm ngay</a></p>';
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa trưa  <a href="#">Thêm ngay</a></p>';
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa tối <a href="#">Thêm ngay</a> </p>';
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa phụ  <a href="#">Thêm ngay</a></p>';
										}
										?>
									</div>
								</div>
							</div>
						</div>
						<?php
						echo '</div>';
						// }
						// else{
						// 	echo '<div id="nd_tuan_1_'.$i.'_ct">';
						// 	echo '<p>Chưa có thực đơn cho ngày'.$vb_ngay_check.'<a href="#">Thêm ngay</a></p>';
						// 	echo '</div>';							
						// }
					}
					?>
				</div>
			</div>
			<!-- TUẦN 2 -->
			<div id="tuan_2_ct">
				<ul>
					<?php
					for($i=8;$i<15;$i++){
						if(($i+1)<15){
							if($i<10){
								echo '<li id="nd_tuan_2_'.$i.'">Thứ '.($i-6).'<span>(0'.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';
							}
							else{
								echo '<li id="nd_tuan_2_'.$i.'">Thứ '.($i-7).'<span>('.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';
							}
							
						}
						else{
							echo '<li id="nd_tuan_2_'.$i.'">Chủ nhật <span>(0'.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';	
						}						
					}
					?>
				</ul>
				<div class="cm_tab_content_tuan">
					<?php
					for($i=8;$i<15;$i++){
						if($i<10){
							$vb_ngay_check='0'.$i.'/'.$date1_mon.'/'.$date1['year'];
						}else{
							$vb_ngay_check=$i.'/'.$date1_mon.'/'.$date1['year'];
						}
						$phuhuynh = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND user_id ="'.$id_hs.'"' );
						$phuhuynh_sang =  $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_sang !="" AND user_id ="'.$id_hs.'"' );
						$phuhuynh_trua = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_trua !=""' );
						$phuhuynh_toi = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_toi !="" AND user_id ="'.$id_hs.'"' );
						$phuhuynh_phutoi = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND phu_toi !="" AND user_id ="'.$id_hs.'"' );
						//$cm_check_ngay = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thuc_don WHERE ngay = "'.$vb_ngay_check.'"');
						//if($cm_check_ngay){
						echo '<div id="nd_tuan_2_'.$i.'_ct">';
						?>
						<!-- NHU CẦU DINH DƯỠNG -->
						<div class="nhucau_check">
							<table>
								<tr>
									<th></th>
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
									<td><h5>Dinh dưỡng đã dùng</h5></td>
									<td><?php echo $phuhuynh->tong_nang_luong ?></td>
									<td><?php echo $phuhuynh->tong_protein ?></td>
									<td><?php echo $phuhuynh->tong_glucid ?></td>
									<td><?php echo $phuhuynh->tong_lipid ?></td>
									<td><?php echo $phuhuynh->tong_canxi ?></td>
									<td><?php echo $phuhuynh->tong_sat ?></td>
									<td><?php echo $phuhuynh->tong_kem ?></td>
									<td><?php echo $phuhuynh->tong_xo ?></td>
								</tr>
								<tr class="nhucau_con_lai_4124">
									<td><h5>Dinh Dưỡng Còn Lại</h5></td>
								</tr>
								<tr class="nhucau_check_4100">
									<?php
									$pt_protein=round((($phuhuynh->tong_protein)*4/($phuhuynh->tong_nang_luong))*100 , 2);
									$pt_lipid=round((($phuhuynh->tong_lipid)*9/($phuhuynh->tong_nang_luong))*100 , 2);
									$pt_glucid=round((100-$pt_protein-$pt_lipid), 2);
									?>
									<td>Tỷ lệ:</td>
									<td></td>
									<td class="<?php if($pt_protein <= 13){echo "cl-thieu";} else if($pt_protein <= 20){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_protein>0){echo $pt_protein;}else{echo "0";}?>%</span></td>
									<td class="<?php if($pt_glucid <= 50){echo "cl-thieu";} else if($pt_glucid <= 65){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_glucid>0){echo $pt_glucid;}else{echo "0";}?>%</span></td>
									<td class="<?php if($pt_lipid <= 20){echo "cl-thieu";} else if($pt_lipid <= 30){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_lipid>0){echo $pt_lipid;}else{echo "0";}?>%</span></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Tỷ lệ chuẩn:</td>
									<td></td>
									<td style="padding: 0">13% - 20%</td>
									<td style="padding: 0">50% - 65%</td>
									<td style="padding: 0">20% - 30%</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</table>
						</div>
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa sáng  <a href="#" class="cm_them_bua_sang">Thêm ngay</a></p>';
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa trưa  <a href="#">Thêm ngay</a></p>';
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa tối <a href="#">Thêm ngay</a> </p>';
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa phụ  <a href="#">Thêm ngay</a></p>';
										}
										?>
									</div>
								</div>
							</div>
						</div>
						<?php
						echo '</div>';
						// }
						// else{
						// 	echo '<div id="nd_tuan_2_'.$i.'_ct">';
						// 	echo '<p>Chưa có thực đơn cho ngày'.$vb_ngay_check.'<a href="#">Thêm ngay</a></p>';
						// 	echo '</div>';							
						// }
					}
					?>
				</div>
			</div>
			<!-- TUẦN 3 -->
			<div id="tuan_3_ct">
				<ul>
					<?php
					for($i=15;$i<22;$i++){
						if(($i+1)<22){
							echo '<li id="nd_tuan_3_'.$i.'">Thứ '.($i-13).'<span>('.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';
						}
						else{
							echo '<li id="nd_tuan_3_'.$i.'">Chủ nhật <span>(0'.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';	
						}						
					}
					?>
				</ul>
				<div class="cm_tab_content_tuan">
					<?php
					for($i=15;$i<22;$i++){
						$vb_ngay_check=$i.'/'.$date1_mon.'/'.$date1['year'];
						//$cm_check_ngay = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thuc_don WHERE ngay = "'.$vb_ngay_check.'"');
						$phuhuynh = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND user_id ="'.$id_hs.'"' );
						$phuhuynh_sang =  $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_sang !="" AND user_id ="'.$id_hs.'"' );
						$phuhuynh_trua = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_trua !="" AND user_id ="'.$id_hs.'"' );
						$phuhuynh_toi = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_toi !="" AND user_id ="'.$id_hs.'"' );
						$phuhuynh_phutoi = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND phu_toi !="" AND user_id ="'.$id_hs.'"' );
						//if($cm_check_ngay){
						echo '<div id="nd_tuan_3_'.$i.'_ct">';
						?>
						<!-- NHU CẦU DINH DƯỠNG -->
						<div class="nhucau_check">
							<table>
								<tr>
									<th></th>
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
									<td><h5>Dinh dưỡng đã dùng</h5></td>
									<td><?php echo $phuhuynh->tong_nang_luong ?></td>
									<td><?php echo $phuhuynh->tong_protein ?></td>
									<td><?php echo $phuhuynh->tong_glucid ?></td>
									<td><?php echo $phuhuynh->tong_lipid ?></td>
									<td><?php echo $phuhuynh->tong_canxi ?></td>
									<td><?php echo $phuhuynh->tong_sat ?></td>
									<td><?php echo $phuhuynh->tong_kem ?></td>
									<td><?php echo $phuhuynh->tong_xo ?></td>
								</tr>
								<tr class="nhucau_con_lai_4124">
									<td><h5>Dinh Dưỡng Còn Lại</h5></td>
								</tr>
								<tr class="nhucau_check_4100">
									<?php
									$pt_protein=round((($phuhuynh->tong_protein)*4/($phuhuynh->tong_nang_luong))*100 , 2);
									$pt_lipid=round((($phuhuynh->tong_lipid)*9/($phuhuynh->tong_nang_luong))*100 , 2);
									$pt_glucid=round((100-$pt_protein-$pt_lipid), 2);
									?>
									<td>Tỷ lệ:</td>
									<td></td>
									<td class="<?php if($pt_protein <= 13){echo "cl-thieu";} else if($pt_protein <= 20){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_protein>0){echo $pt_protein;}else{echo "0";}?>%</span></td>
									<td class="<?php if($pt_glucid <= 50){echo "cl-thieu";} else if($pt_glucid <= 65){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_glucid>0){echo $pt_glucid;}else{echo "0";}?>%</span></td>
									<td class="<?php if($pt_lipid <= 20){echo "cl-thieu";} else if($pt_lipid <= 30){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_lipid>0){echo $pt_lipid;}else{echo "0";}?>%</span></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Tỷ lệ chuẩn:</td>
									<td></td>
									<td style="padding: 0">13% - 20%</td>
									<td style="padding: 0">50% - 65%</td>
									<td style="padding: 0">20% - 30%</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</table>
						</div>
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa sáng  <a href="#" class="cm_them_bua_sang">Thêm ngay</a></p>';
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa trưa  <a href="#">Thêm ngay</a></p>';
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa tối <a href="#">Thêm ngay</a> </p>';
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa phụ  <a href="#">Thêm ngay</a></p>';
										}
										?>
									</div>
								</div>
							</div>
						</div>
						<?php
						echo '</div>';
						// }
						// else{
						// 	echo '<div id="nd_tuan_3_'.$i.'_ct">';
						// 	echo '<p>Chưa có thực đơn cho ngày'.$vb_ngay_check.'<a href="#">Thêm ngay</a></p>';
						// 	echo '</div>';							
						// }
					}
					?>
				</div>
			</div>
			<!-- TUẦN 4 -->
			<div id="tuan_4_ct">
				<ul>
					<?php
					for($i=22;$i<29;$i++){
						if(($i+1)<29){
							echo '<li id="nd_tuan_4_'.$i.'">Thứ '.($i-20).'<span>('.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';
						}
						else{
							echo '<li id="nd_tuan_4_'.$i.'">Chủ nhật <span>('.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';	
						}						
					}
					?>
				</ul>
				<div class="cm_tab_content_tuan">
					<?php
					for($i=22;$i<29;$i++){
						$vb_ngay_check=$i.'/'.$date1_mon.'/'.$date1['year'];
						//$cm_check_ngay = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thuc_don WHERE ngay = "'.$vb_ngay_check.'"');
						$phuhuynh = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND user_id ="'.$id_hs.'"' );
						$phuhuynh_sang =  $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_sang !="" AND user_id ="'.$id_hs.'"' );
						$phuhuynh_trua = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_trua !=""' );
						$phuhuynh_toi = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_toi !="" AND user_id ="'.$id_hs.'"' );
						$phuhuynh_phutoi = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND phu_toi !="" AND user_id ="'.$id_hs.'"' );
						//if($cm_check_ngay){
						echo '<div id="nd_tuan_4_'.$i.'_ct">';
						?>
						<!-- NHU CẦU DINH DƯỠNG -->
						<div class="nhucau_check">
							<table>
								<tr>
									<th></th>
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
									<td><h5>Dinh dưỡng đã dùng</h5></td>
									<td><?php echo $phuhuynh->tong_nang_luong ?></td>
									<td><?php echo $phuhuynh->tong_protein ?></td>
									<td><?php echo $phuhuynh->tong_glucid ?></td>
									<td><?php echo $phuhuynh->tong_lipid ?></td>
									<td><?php echo $phuhuynh->tong_canxi ?></td>
									<td><?php echo $phuhuynh->tong_sat ?></td>
									<td><?php echo $phuhuynh->tong_kem ?></td>
									<td><?php echo $phuhuynh->tong_xo ?></td>
								</tr>
								<tr class="nhucau_con_lai_4124">
									<td><h5>Dinh Dưỡng Còn Lại</h5></td>
								</tr>
								<tr class="nhucau_check_4100">
									<?php
									$pt_protein=round((($phuhuynh->tong_protein)*4/($phuhuynh->tong_nang_luong))*100 , 2);
									$pt_lipid=round((($phuhuynh->tong_lipid)*9/($phuhuynh->tong_nang_luong))*100 , 2);
									$pt_glucid=round((100-$pt_protein-$pt_lipid), 2);
									?>
									<td>Tỷ lệ:</td>
									<td></td>
									<td class="<?php if($pt_protein <= 13){echo "cl-thieu";} else if($pt_protein <= 20){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_protein>0){echo $pt_protein;}else{echo "0";}?>%</span></td>
									<td class="<?php if($pt_glucid <= 50){echo "cl-thieu";} else if($pt_glucid <= 65){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_glucid>0){echo $pt_glucid;}else{echo "0";}?>%</span></td>
									<td class="<?php if($pt_lipid <= 20){echo "cl-thieu";} else if($pt_lipid <= 30){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_lipid>0){echo $pt_lipid;}else{echo "0";}?>%</span></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Tỷ lệ chuẩn:</td>
									<td></td>
									<td style="padding: 0">13% - 20%</td>
									<td style="padding: 0">50% - 65%</td>
									<td style="padding: 0">20% - 30%</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</table>
						</div>
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa sáng  <a href="#" class="cm_them_bua_sang">Thêm ngay</a></p>';
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa trưa  <a href="#">Thêm ngay</a></p>';
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa tối <a href="#">Thêm ngay</a> </p>';
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
													for($j=0;$j<count($mon_an_day)-1; $j++){
														$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
														echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
														<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
											echo '<p>Chưa có thực đơn cho bữa phụ  <a href="#">Thêm ngay</a></p>';
										}
										?>
									</div>
								</div>
							</div>
						</div>
						<?php
						echo '</div>';
						// }
						// else{
						// 	echo '<div id="nd_tuan_4_'.$i.'_ct">';
						// 	echo '<p>Chưa có thực đơn cho ngày'.$vb_ngay_check.'<a href="#">Thêm ngay</a></p>';
						// 	echo '</div>';							
						// }
					}
					?>
				</div>
			</div>
			<!-- TUẦN 5 -->
			<?php
			if($vb_tuan==5){
				?>
				<div id="tuan_5_ct">
					<ul>
						<?php
						for($i=29;$i<=$vb_ngay_num;$i++){
							if(($i+1)<=$vb_ngay_num+2){
								echo '<li id="nd_tuan_5_'.$i.'">Thứ '.($i-27).'<span>(0'.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';
							}
							else{
								echo '<li id="nd_tuan_5_'.$i.'">Chủ nhật <span>(0'.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';	
							}						
						}
						?>
					</ul>
					<div class="cm_tab_content_tuan">
						<?php
						for($i=29;$i<=$vb_ngay_num;$i++){
							$vb_ngay_check=$i.'/'.$date1_mon.'/'.$date1['year'];
							//$cm_check_ngay = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thuc_don WHERE ngay = "'.$vb_ngay_check.'"');
							$phuhuynh = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND user_id ="'.$id_hs.'"' );
							$phuhuynh_sang =  $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_sang !="" AND user_id ="'.$id_hs.'"' );
							$phuhuynh_trua = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_trua !=""' );
							$phuhuynh_toi = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND an_toi !="" AND user_id ="'.$id_hs.'"' );
							$phuhuynh_phutoi = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$vb_ngay_check.'" AND phu_toi !="" AND user_id ="'.$id_hs.'"' );
							//if($cm_check_ngay){
							echo '<div id="nd_tuan_5_'.$i.'_ct">';
							?>
							<!-- NHU CẦU DINH DƯỠNG -->
							<div class="nhucau_check">
								<table>
									<tr>
										<th></th>
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
										<td><h5>Dinh dưỡng đã dùng</h5></td>
										<td><?php echo $phuhuynh->tong_nang_luong ?></td>
										<td><?php echo $phuhuynh->tong_protein ?></td>
										<td><?php echo $phuhuynh->tong_glucid ?></td>
										<td><?php echo $phuhuynh->tong_lipid ?></td>
										<td><?php echo $phuhuynh->tong_canxi ?></td>
										<td><?php echo $phuhuynh->tong_sat ?></td>
										<td><?php echo $phuhuynh->tong_kem ?></td>
										<td><?php echo $phuhuynh->tong_xo ?></td>
									</tr>
									<tr class="nhucau_con_lai_4124">
									<td><h5>Dinh Dưỡng Còn Lại</h5></td>
								</tr>
									<tr class="nhucau_check_4100">
										<?php
										$pt_protein=round((($phuhuynh->tong_protein)*4/($phuhuynh->tong_nang_luong))*100 , 2);
										$pt_lipid=round((($phuhuynh->tong_lipid)*9/($phuhuynh->tong_nang_luong))*100 , 2);
										$pt_glucid=round((100-$pt_protein-$pt_lipid), 2);
										?>
										<td>Tỷ lệ:</td>
										<td></td>
										<td class="<?php if($pt_protein <= 13){echo "cl-thieu";} else if($pt_protein <= 20){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_protein>0){echo $pt_protein;}else{echo "0";}?>%</span></td>
										<td class="<?php if($pt_glucid <= 50){echo "cl-thieu";} else if($pt_glucid <= 65){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_glucid>0){echo $pt_glucid;}else{echo "0";}?>%</span></td>
										<td class="<?php if($pt_lipid <= 20){echo "cl-thieu";} else if($pt_lipid <= 30){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_lipid>0){echo $pt_lipid;}else{echo "0";}?>%</span></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td>Tỷ lệ chuẩn:</td>
										<td></td>
										<td style="padding: 0">13% - 20%</td>
										<td style="padding: 0">50% - 65%</td>
										<td style="padding: 0">20% - 30%</td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</table>
							</div>
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
														for($j=0;$j<count($mon_an_day)-1; $j++){
															$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
															echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
												echo '<p>Chưa có thực đơn cho bữa sáng  <a href="#" class="cm_them_bua_sang">Thêm ngay</a></p>';
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
														for($j=0;$j<count($mon_an_day)-1; $j++){
															$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
															echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
												echo '<p>Chưa có thực đơn cho bữa trưa  <a href="#">Thêm ngay</a></p>';
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
														for($j=0;$j<count($mon_an_day)-1; $j++){
															$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
															echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
												echo '<p>Chưa có thực đơn cho bữa tối <a href="#">Thêm ngay</a> </p>';
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
														for($j=0;$j<count($mon_an_day)-1; $j++){
															$mon_an_sh[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$j].'"');
															echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
															<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td><td><a href="#" class="cm_delete_mon_an_month">x</a></td></tr>';
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
												echo '<p>Chưa có thực đơn cho bữa phụ  <a href="#">Thêm ngay</a></p>';
											}
											?>
										</div>
									</div>
								</div>
							</div>
							<?php
							echo '</div>';
							// }
							// else{
							// 	echo '<div id="nd_tuan_5_'.$i.'_ct">';
							// 	echo '<p>Chưa có thực đơn cho ngày'.$vb_ngay_check.'<a href="#">Thêm ngay</a></p>';
							// 	echo '</div>';							
							// }
						}
						?>
					</div>
				</div>
				<?php
			}
			?>
		</div>				
	</div>
	<?php
	$cm_thuc_don_thang = ob_get_contents(); 
	ob_end_clean();
	return $cm_thuc_don_thang;
}
add_shortcode( 'thu_don_phu_huynh', 'create_shortcode_thuc_don_phu_huynh' );