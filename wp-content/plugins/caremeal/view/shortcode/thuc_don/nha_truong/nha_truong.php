<?php
function create_shortcode_nha_truong() {	
	ob_start();
	header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT"); 
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header ("Cache-Control: no-cache, must-revalidate"); 
	header ("Pragma: no-cache");
	$vuba_version=uniqid();
	wp_enqueue_script('nha_truong_js', CARE_MEAL_URL .'view/shortcode/thuc_don/nha_truong/js/nha_truong.js', array(), $vuba_version, true);
	global $wpdb;
	$user=wp_get_current_user();
	$user_id = $user->ID;
	$truong_id=get_user_meta( $user_id, 'user_registration_select_1606738347', true);
	$list_user=$wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'usermeta WHERE meta_key = "user_registration_hs_truong_hoc" AND meta_value= "'.$truong_id.'"');
	date_default_timezone_set('Asia/Ho_Chi_Minh'); 
	$date= date("d/m/Y");
	$date1=getdate();
	$nhatruong = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thuc_don WHERE ngay = "'.$date.'"');
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

	<!-- THÔNG TIN NHÀ TRƯỜNG -->
	<div class="cm_nha_truong_header">
		<h3><?php echo $user->display_name; ?></h3>
		<h6><?php echo get_user_meta( $user_id, 'user_registration_select_1606738347', true); ?></h6>
		<div class="cm_list_hoc_sinh_id" style="display: none">
			<?php
			foreach ($list_user as $iduser) {
				echo $iduser->user_id.',';
			}
			?>
		</div>
	</div>


	<!-- ThỰC ĐƠN HÀNG NGÀY -->
	<div class="cm_nha_truong_thuc_don_area">
		<button class="cm-truong_them">Thêm thực đơn</button>
	</div>
	<div class="cm_truong_td_today">
		<h3>Thực đơn hôm nay - ngày <?php echo $date; ?></h3>
		<div>
			<?php
			if($nhatruong){
				$mon_an_day = $nhatruong->mon_an;
				$mon_an_day = explode(",",$mon_an_day);
				?>
				<div>
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
								<th style="width:8.5%">Kẽm (mg)</th>
								<th style="width:8.5%">Xơ (g)</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$mon_an_sh=[];
							for($i=0;$i<count($mon_an_day)-1; $i++){
								$mon_an_sh[$i] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day[$i].'"');
								echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$i]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$i]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$i]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->lipid.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->canxi.'</td><td style="width:8.5%">'.$mon_an_sh[$i]->sat.'</td>
								<td style="width:8.5%">'.$mon_an_sh[$i]->kem.'</td>
								<td style="width:8.5%">'.$mon_an_sh[$i]->xo.'</td></tr>';
							}
							?>
						</tbody>
						<tfoot>
							<tr>
								<th style="width:6%">Tổng</th>
								<th style="width:20%"></th>
								<th style="width:14.5%"><?php echo $nhatruong->nang_luong ?></th>
								<th style="width:8.5%"><?php echo $nhatruong->protein ?></th>
								<th style="width:8.5%"><?php echo $nhatruong->glucid ?></th>
								<th style="width:8.5%"><?php echo $nhatruong->lipid ?></th>
								<th style="width:8.5%"><?php echo $nhatruong->canxi ?></th>
								<th style="width:8.5%"><?php echo $nhatruong->sat ?></th>
								<th style="width:8.5%"><?php echo $nhatruong->kem ?></th>
								<th style="width:8.5%"><?php echo $nhatruong->xo ?></th>
							</tr>
						</tfoot>
					</table>
				</div>
				<?php
			}
			else{
				echo '<p>Chưa có thực đơn cho ngày hôm nay <span class="btn_them">Thêm ngay</span></p>';
			}
			?>
		</div>
	</div>

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
						$cm_check_ngay = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thuc_don WHERE ngay = "'.$vb_ngay_check.'"');
						if($cm_check_ngay){
							echo '<div id="nd_tuan_1_'.$i.'_ct">';
							?>
							<table>
								<thead>
									<tr>
										<tr>
											<th style="width:6%">Ảnh</th>
											<th style="width:20%">Món ăn</th>
											<th style="width:14.5%">Năng lượng (kcal)</th>
											<th style="width:8.5%">Protein (g)</th>
											<th style="width:8.5%">Glucid (g)</th>
											<th style="width:8.5%">Lipid (g)</th>
											<th style="width:8.5%">Canxi (mg)</th>
											<th style="width:8.5%">Sắt (mg)</th>
											<th style="width:8.5%">Kẽm (mg)</th>
											<th style="width:8.5%">Xơ (g)</th>
										</tr>
									</tr>
								</thead>
								<tbody>
									<?php
									$mon_an_day_1 = $cm_check_ngay->mon_an;
									$mon_an_day_1 = explode(",",$mon_an_day_1);
									$mon_an_sh_1=[];
									for($j=0;$j<count($mon_an_day_1)-1; $j++){
										$mon_an_sh_1[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day_1[$j].'"');
										echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
										<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
										<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td></tr>';
									}
									?>
								</tbody>
								<tfoot>
									<tr>
										<th style="width:6%">Tổng</th>
										<th style="width:20%"></th>
										<th style="width:14.5%"><?php echo $cm_check_ngay->nang_luong ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->protein ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->glucid ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->lipid ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->canxi ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->sat ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->kem ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->xo ?></th>
									</tr>
								</tfoot>
							</table>
							<?php
							echo '</div>';
						}
						else{
							echo '<div id="nd_tuan_1_'.$i.'_ct">';
							echo '<p>Chưa có thực đơn cho ngày'.$vb_ngay_check.'<a href="#">Thêm ngay</a></p>';
							echo '</div>';							
						}
					}
					?>
				</div>
			</div>
			<div id="tuan_2_ct">
				<ul>
					<?php
					for($i=8;$i<15;$i++){
						if(($i+1)<15){
							if($i<10){
								echo '<li id="nd_tuan_2_'.$i.'">Thứ '.($i-7).'<span>(0'.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';
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
						
						$cm_check_ngay = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thuc_don WHERE ngay = "'.$vb_ngay_check.'"');
						if($cm_check_ngay){
							echo '<div id="nd_tuan_2_'.$i.'_ct">';
							?>
							<table>
								<thead>
									<tr>
										<tr>
											<th style="width:6%">Ảnh</th>
											<th style="width:20%">Món ăn</th>
											<th style="width:14.5%">Năng lượng (kcal)</th>
											<th style="width:8.5%">Protein (g)</th>
											<th style="width:8.5%">Glucid (g)</th>
											<th style="width:8.5%">Lipid (g)</th>
											<th style="width:8.5%">Canxi (mg)</th>
											<th style="width:8.5%">Sắt (mg)</th>
											<th style="width:8.5%">Kẽm (mg)</th>
											<th style="width:8.5%">Xơ (g)</th>
										</tr>
									</tr>
								</thead>
								<tbody>
									<?php
									$mon_an_day_1 = $cm_check_ngay->mon_an;
									$mon_an_day_1 = explode(",",$mon_an_day_1);
									$mon_an_sh_1=[];
									for($j=0;$j<count($mon_an_day_1)-1; $j++){
										$mon_an_sh_1[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day_1[$j].'"');
										echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
										<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
										<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td></tr>';
									}
									?>
								</tbody>
								<tfoot>
									<tr>
										<th style="width:6%">Tổng</th>
										<th style="width:20%"></th>
										<th style="width:14.5%"><?php echo $cm_check_ngay->nang_luong ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->protein ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->glucid ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->lipid ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->canxi ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->sat ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->kem ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->xo ?></th>
									</tr>
								</tfoot>
							</table>
							<?php
							echo '</div>';
						}
						else{
							echo '<div id="nd_tuan_2_'.$i.'_ct">';
							echo '<p>Chưa có thực đơn cho ngày'.$vb_ngay_check.'<a href="#">Thêm ngay</a></p>';
							echo '</div>';							
						}
					}
					?>
				</div>
			</div>
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
						$cm_check_ngay = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thuc_don WHERE ngay = "'.$vb_ngay_check.'"');
						if($cm_check_ngay){
							echo '<div id="nd_tuan_3_'.$i.'_ct">';
							?>
							<table>
								<thead>
									<tr>
										<tr>
											<th style="width:6%">Ảnh</th>
											<th style="width:20%">Món ăn</th>
											<th style="width:14.5%">Năng lượng (kcal)</th>
											<th style="width:8.5%">Protein (g)</th>
											<th style="width:8.5%">Glucid (g)</th>
											<th style="width:8.5%">Lipid (g)</th>
											<th style="width:8.5%">Canxi (mg)</th>
											<th style="width:8.5%">Sắt (mg)</th>
											<th style="width:8.5%">Kẽm (mg)</th>
											<th style="width:8.5%">Xơ (g)</th>
										</tr>
									</tr>
								</thead>
								<tbody>
									<?php
									$mon_an_day_1 = $cm_check_ngay->mon_an;
									$mon_an_day_1 = explode(",",$mon_an_day_1);
									$mon_an_sh_1=[];
									for($j=0;$j<count($mon_an_day_1)-1; $j++){
										$mon_an_sh_1[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day_1[$j].'"');
										echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
										<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
										<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td></tr>';
									}
									?>
								</tbody>
								<tfoot>
									<tr>
										<th style="width:6%">Tổng</th>
										<th style="width:20%"></th>
										<th style="width:14.5%"><?php echo $cm_check_ngay->nang_luong ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->protein ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->glucid ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->lipid ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->canxi ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->sat ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->kem ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->xo ?></th>
									</tr>
								</tfoot>
							</table>
							<?php
							echo '</div>';
						}
						else{
							echo '<div id="nd_tuan_3_'.$i.'_ct">';
							echo '<p>Chưa có thực đơn cho ngày'.$vb_ngay_check.'<a href="#">Thêm ngay</a></p>';
							echo '</div>';							
						}
					}
					?>
				</div>
			</div>
			<div id="tuan_4_ct">
				<ul>
					<?php
					for($i=22;$i<29;$i++){
						if(($i+1)<29){
							echo '<li id="nd_tuan_4_'.$i.'">Thứ '.($i-20).'<span>(0'.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';
						}
						else{
							echo '<li id="nd_tuan_4_'.$i.'">Chủ nhật <span>(0'.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';	
						}						
					}
					?>
				</ul>
				<div class="cm_tab_content_tuan">
					<?php
					for($i=22;$i<29;$i++){
						$vb_ngay_check=$i.'/'.$date1_mon.'/'.$date1['year'];
						$cm_check_ngay = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thuc_don WHERE ngay = "'.$vb_ngay_check.'"');
						if($cm_check_ngay){
							echo '<div id="nd_tuan_4_'.$i.'_ct">';
							?>
							<table>
								<thead>
									<tr>
										<tr>
											<th style="width:6%">Ảnh</th>
											<th style="width:20%">Món ăn</th>
											<th style="width:14.5%">Năng lượng (kcal)</th>
											<th style="width:8.5%">Protein (g)</th>
											<th style="width:8.5%">Glucid (g)</th>
											<th style="width:8.5%">Lipid (g)</th>
											<th style="width:8.5%">Canxi (mg)</th>
											<th style="width:8.5%">Sắt (mg)</th>
											<th style="width:8.5%">Kẽm (mg)</th>
											<th style="width:8.5%">Xơ (g)</th>
										</tr>
									</tr>
								</thead>
								<tbody>
									<?php
									$mon_an_day_1 = $cm_check_ngay->mon_an;
									$mon_an_day_1 = explode(",",$mon_an_day_1);
									$mon_an_sh_1=[];
									for($j=0;$j<count($mon_an_day_1)-1; $j++){
										$mon_an_sh_1[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day_1[$j].'"');
										echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
										<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
										<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td></tr>';
									}
									?>
								</tbody>
								<tfoot>
									<tr>
										<th style="width:6%">Tổng</th>
										<th style="width:20%"></th>
										<th style="width:14.5%"><?php echo $cm_check_ngay->nang_luong ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->protein ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->glucid ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->lipid ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->canxi ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->sat ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->kem ?></th>
										<th style="width:8.5%"><?php echo $cm_check_ngay->xo ?></th>
									</tr>
								</tfoot>
							</table>
							<?php
							echo '</div>';
						}
						else{
							echo '<div id="nd_tuan_4_'.$i.'_ct">';
							echo '<p>Chưa có thực đơn cho ngày'.$vb_ngay_check.'<a href="#">Thêm ngay</a></p>';
							echo '</div>';							
						}
					}
					?>
				</div>
			</div>
			<?php
			if($vb_tuan==5){
				?>
				<div id="tuan_5_ct">
					<ul>
						<?php
						for($i=29;$i<$vb_ngay_num;$i++){
							if(($i+1)<=$vb_ngay_num){
								echo '<li id="nd_tuan_5_'.$i.'">Thứ '.($i+1).'<span>(0'.$i.'/'.$date1_mon.'/'.$date1['year'].')</span></li>';
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
							$cm_check_ngay = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thuc_don WHERE ngay = "'.$vb_ngay_check.'"');
							if($cm_check_ngay){
								echo '<div id="nd_tuan_5_'.$i.'_ct">';
								?>
								<table>
									<thead>
										<tr>
											<tr>
												<th style="width:6%">Ảnh</th>
												<th style="width:20%">Món ăn</th>
												<th style="width:14.5%">Năng lượng (kcal)</th>
												<th style="width:8.5%">Protein (g)</th>
												<th style="width:8.5%">Glucid (g)</th>
												<th style="width:8.5%">Lipid (g)</th>
												<th style="width:8.5%">Canxi (mg)</th>
												<th style="width:8.5%">Sắt (mg)</th>
												<th style="width:8.5%">Kẽm (mg)</th>
												<th style="width:8.5%">Xơ (g)</th>
											</tr>
										</tr>
									</thead>
									<tbody>
										<?php
										$mon_an_day_1 = $cm_check_ngay->mon_an;
										$mon_an_day_1 = explode(",",$mon_an_day_1);
										$mon_an_sh_1=[];
										for($j=0;$j<count($mon_an_day_1)-1; $j++){
											$mon_an_sh_1[$j] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten = "'.$mon_an_day_1[$j].'"');
											echo '<tr><td style="width:6%"><img src="'.$mon_an_sh[$j]->anh_av.'"></td><td style="width:20%">'.$mon_an_sh[$j]->ten.'</td><td style="width:14.5%">'.$mon_an_sh[$j]->nang_luong.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->protein.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->glucid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->lipid.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->canxi.'</td><td style="width:8.5%">'.$mon_an_sh[$j]->sat.'</td>
											<td style="width:8.5%">'.$mon_an_sh[$j]->kem.'</td>
											<td style="width:8.5%">'.$mon_an_sh[$j]->xo.'</td></tr>';
										}
										?>
									</tbody>
									<tfoot>
										<tr>
											<th style="width:6%">Tổng</th>
											<th style="width:20%"></th>
											<th style="width:14.5%"><?php echo $cm_check_ngay->nang_luong ?></th>
											<th style="width:8.5%"><?php echo $cm_check_ngay->protein ?></th>
											<th style="width:8.5%"><?php echo $cm_check_ngay->glucid ?></th>
											<th style="width:8.5%"><?php echo $cm_check_ngay->lipid ?></th>
											<th style="width:8.5%"><?php echo $cm_check_ngay->canxi ?></th>
											<th style="width:8.5%"><?php echo $cm_check_ngay->sat ?></th>
											<th style="width:8.5%"><?php echo $cm_check_ngay->kem ?></th>
											<th style="width:8.5%"><?php echo $cm_check_ngay->xo ?></th>
										</tr>
									</tfoot>
								</table>
								<?php
								echo '</div>';
							}
							else{
								echo '<div id="nd_tuan_5_'.$i.'_ct">';
								echo '<p>Chưa có thực đơn cho ngày'.$vb_ngay_check.'<a href="#">Thêm ngay</a></p>';
								echo '</div>';							
							}
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
	$cm_nha_truong = ob_get_contents(); 
	ob_end_clean();
	return $cm_nha_truong;
}
add_shortcode( 'nha_truong', 'create_shortcode_nha_truong' );