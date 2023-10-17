<?php 
function create_shortcode_phu_huynh()  { 
	ob_start();
	$version=uniqid();
	wp_enqueue_script('bieu_do_js', CARE_MEAL_URL .'view/shortcode/thuc_don/hoc_sinh/js/highcharts.js', array(), false, true);
	wp_enqueue_script('hoc_sinh_js', CARE_MEAL_URL .'view/shortcode/thuc_don/phu_huynh/js/phu_huynh.js', array(), $version, true);
	global $wpdb;
	$user=wp_get_current_user();
	$user_id = $user->ID;
	$list_user=$wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'users WHERE ID != ""');
	$id_hs=get_user_meta( $user_id, 'user_registration_input_box_1606780902', true);
	date_default_timezone_set('Asia/Ho_Chi_Minh'); 
	$date= date("d/m/Y");
	$date1=getdate();
	$phuhuynh = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$date.'" AND user_id ="'.$id_hs.'"' );
	$phuhuynh_sang =  $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$date.'" AND an_sang !="" AND user_id ="'.$id_hs.'"' );
	$phuhuynh_trua = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$date.'" AND an_trua !=""' );
	$phuhuynh_toi = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$date.'" AND an_toi !="" AND user_id ="'.$id_hs.'"' );
	$phuhuynh_phutoi = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE ngay = "'.$date.'" AND phu_toi !="" AND user_id ="'.$id_hs.'"' );
	?>
	<!-- THÔNG TIN HỌC SINH -->
	<div class="cm_thong_tin_hs">
		<h3><?php echo $user->display_name; ?></h3>
		<?php
		if($id_hs=="0"){ 
			if (!empty($list_user)){
				?>
				<div style="display: none" class="cm_user_check_ph">
					<?php echo $user_id; ?>
				</div>
				<div style="display: none" class="cm_user_check_hs">
					<?php foreach ($list_user as $key => $value): ?>
						<?php 
						$vb=get_userdata($value->ID);
						$vb1= $vb->roles; 
						if($vb1[0]=="hoc_sinh"){
							echo  $value->ID;           
						}
						?>
					<?php endforeach ?>
				</div>
				<?php
			}
			?>
			<div class="cm_ket_noi_hs" style="display: block">
				<div class="cm_ket_noi_hs_ov">
				</div>
				<div class="cm_ket_noi_hs_main">
					<label>Nhập ID của học sinh<input type="number" name="id_hoc_sinh"></label>
					<button class="cm_ket_noi_hs_id">Kết nối ngay</button>
				</div>
			</div>
			<?php
		}
		else{
			$hs_user=get_userdata($id_hs);
			?>
			<div class="cm_thong_tin_hs">
				<h6 class="cm_id_hoc_sinh" style="display: none"><?php echo $id_hs;  ?></h6>
				<h6 class="cm_ten_hoc_sinh">Học sinh: <?php echo $hs_user->display_name; ?><a href="#">Cập nhật thông tin</a></h6> 
				<span style="display: none" id="cm_us_id"><?php echo $hs_user->ID; ?> </span>
				<h6 class="cm_hs_gioi_tinh" style="display:none">Giới tính: <span><?php echo get_user_meta( $hs_user->ID, 'user_registration_radio_1606749096', true); ?></span></h6>
				<h6 class="cm_hs_tuoi" style="display: none">Ngày sinh: <span><?php echo get_user_meta( $hs_user->ID, 'user_registration_date_box_1606738801', true); ?></span></h6>
				<h6 class="cm_hs_chieu_cao" style="display: none">Chiều cao: <span><?php echo get_user_meta($hs_user->ID, 'user_registration_input_box_1606738777', true); ?></span>m</h6>
				<h6 class="cm_hs_can_nang" style="display: none">Cân nặng: <span><?php echo get_user_meta($hs_user->ID, 'user_registration_input_box_1606738754', true); ?></span>kg</h6>
			</div>

			<div id="bmi">
			</div>
			<div id="cm_show_thong_tin_hoc_sinh" style="display: block">
				<!-- THÊM THỰC ĐƠN -->
				<div>
					<button class="cm-truong_them">Thêm thực đơn</button>
					<a href="#" class="cm-truong_update">Cập nhập thực đơn nhà trường</a>
				</div>
				<div>
					<?php 
					$list_monan = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an ORDER BY ten ASC' );
					$list_nguyen_lieu= $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_nguyen_lieu ORDER BY ten ASC' );
					?>
					<div class="wrap" id="cm_them_thuc_don" style="display: none">
						<div class="cm_overlsy"></div>
						<div class="cm_them_thuc_don_content">
							<i class="fa fa-times"></i>
							<h3>Thêm thực đơn</h3>
							<div class="cm_chon_mon_area">
								<select name="" id="">
									<option value="chon">Chọn bữa ăn</option>
									<option value="sang">Bữa sáng</option>
									<option value="trua">Bữa trưa</option>
									<option value="toi">Bữa tối</option>
									<option value="phu_toi">Bữa phụ</option>
								</select>
								<div class="cm_chon_ngay_112 cm_chon_ngay_812">
									<h5>Chọn ngày: </h5>
									<input type="date" id="dt" style="width: 60%">
									<input type="text" id="ndt" name="ngay" style="width: 100%; display: none">
									<input type="text" id="day" name="thu" value="0" style="width: 100%; display: none">
								</div>
								<h6 class="cm_chon_mon_btn">Chọn món ăn</h6>
								<h6 class="cm_tao_mon_btn">Tạo món ăn</h6>
								<!-- <h6 class="cm_tao_thuc_don_mau_btn">Thực đơn mẫu</h6> -->
							</div>
							<div class="cm_truong_thong_tin" style="display: none"> 
								<div>
									<table>
										<thead>
											<tr>
												<th style="width: 6%;">Ảnh</th>
												<th style="width: 20%;">Món ăn</th>
												<th style="width: 14.5%; padding:0">Năng lượng (kcal)</th>
												<th style="width: 8.5%; padding:0">Protein (g)</th>
												<th style="width: 8.5%; padding:0">Glucid (g)</th>
												<th style="width: 8.5%; padding:0">Lipid (g)</th>
												<th style="width: 8.5%; padding:0">Canxi (mg)</th>
												<th style="width: 8.5%; padding:0">Sắt (mg)</th>
												<th style="width: 8.5%; padding:0">Kẽm (mg)</th>
												<th style="width: 8.5%; padding:0">Xơ (g)</th>
											</tr>
										</thead>
									</table>
								</div>
								<div class="cm_truong_thong_tin_table">
									<table>
										<tbody>

										</tbody>
									</table>
								</div>
								<div>
									<table>
										<tfoot>
											<tr>
												<th style="width:6%"></th>
												<th style="width: 20%;">Tổng</th>
												<th style="width:14.5%" class="cm-total_nang_luong">Năng lượng (kcal)</th>
												<th style="width:8.5%" class="cm-total_protein">Protein (g)</th>
												<th style="width:8.5%" class="cm-total_glucid">Glucid (g)</th>
												<th style="width:8.5%" class="cm-total_lipid">Lipid (g)</th>
												<th style="width:8.5%" class="cm-total_canxi">Canxi (mg)</th>
												<th style="width:8.5%" class="cm-total_sat">Sắt (mg)</th>
												<th style="width:8.5%" class="cm-total_kem">Kẽm (mg)</th>
												<th style="width:8.5%" class="cm-total_xo">Xơ (g)</th>
											</tr>
											<tr>
												<th style="width:6%"></th>
												<th style="width: 20%;">Dinh dưỡng còn lại</th>
												<th style="width:14.5%" class="cm-total_nang_luong_cl"></th>
												<th style="width:8.5%" class="cm-total_protein_cl"></th>
												<th style="width:8.5%" class="cm-total_glucid_cl"></th>
												<th style="width:8.5%" class="cm-total_lipid_cl"></th>
												<th style="width:8.5%" class="cm-total_canxi_cl"></th>
												<th style="width:8.5%" class="cm-total_sat_cl"></th>
												<th style="width:8.5%" class="cm-total_kem_cl"></th>
												<th style="width:8.5%" class="cm-total_xo_cl"></th>
											</tr>
											<tr>
												<th style="width:6%"></th>
												<th style="width: 20%;">Dinh dưỡng đã dùng</th>
												<th style="width:14.5%" class="cm-total_nang_luong_dd"></th>
												<th style="width:8.5%" class="cm-total_protein_dd"></th>
												<th style="width:8.5%" class="cm-total_glucid_dd"></th>
												<th style="width:8.5%" class="cm-total_lipid_dd"></th>
												<th style="width:8.5%" class="cm-total_canxi_dd"></th>
												<th style="width:8.5%" class="cm-total_sat_dd"></th>
												<th style="width:8.5%" class="cm-total_kem_dd"></th>
												<th style="width:8.5%" class="cm-total_xo_dd"></th>
											</tr>
											<tr>
												<th style="width:6%"></th>
												<th style="width: 20%;">Tỷ lệ</th>
												<th style="width:14.5%" class=""></th>
												<th style="width:8.5%" class="cm_1111"></th>
												<th style="width:8.5%" class="cm_1112"></th>
												<th style="width:8.5%" class="cm_1113"></th>
												<th style="width:8.5%" class=""></th>
												<th style="width:8.5%" class=""></th>
												<th style="width:8.5%" class=""></th>
												<th style="width:8.5%" class=""></th>
											</tr>
											<tr>
												<th style="width:6%"></th>
												<th style="width: 20%;">Tỷ lệ chuẩn</th>
												<th style="width:14.5%" class=""></th>
												<th style="width:8.5%;padding: 0" class="">13% - 20%</th>
												<th style="width:8.5%;padding: 0" class="">50% - 65%</th>
												<th style="width:8.5%;padding: 0" class="">20% - 30%</th>
												<th style="width:8.5%" class=""></th>
												<th style="width:8.5%" class=""></th>
												<th style="width:8.5%" class=""></th>
												<th style="width:8.5%" class=""></th>
											</tr>
										</tfoot>
									</table>
								</div>
								<a href="#" class="cm-btn cm_add_thuc_don">Thêm thực đơn</a>
							</div>
						</div>
					</div>
					<div class="cm-them_thu_don-chon_nguyen__lieu" style="display: none">
						<div class="cm-them_thu_don-chon_nguyen__lieu_ov"></div>
						<div class="cm-them_thu_don-chon_nguyen__lieu_ct">
							<i class="fa fa-times"></i>
							<h2>Tạo món ăn</h2>
							<div class="cm-them_thu_don-chon_nguyen__lieu-header truong_tao_mon_an_header">
								<h3>Tên món ăn :</h3>
								<input type="text">
							</div>  
							<div class="cm-them_thu_don-chon_nguyen__lieu-chitiet">
								<div class="cm_chon_nguyen__lieu-chitiet_712">
									<h4>Nguyên liệu</h4>
									<a href="#" class="cm-btn cm_chon_nguyen__lieu-chitiet_712_btn">Chọn nguyên liệu</a>
								</div>
								<div class="cm_chon_nguyen__lieu-chitiet_712_nlt" style="display: none">	
									<div>
										<table>
											<thead>
												<tr>
													<th style="width: 6%">Ảnh</th>
													<th style="width: 18%">Tên</th>
													<th style="width: 14%">Năng lượng (kcal)</th>
													<th style="width: 7.5%">Protein(g)</th>
													<th style="width: 7.5%">Glucid(g)</th>
													<th style="width: 7.5%">Lipid(g)</th>
													<th style="width: 7.5%">Canxi(mg)</th>
													<th style="width: 7.5%">Sắt(mg)</th>
													<th style="width: 7.5%">Kẽm(mg)</th>
													<th style="width: 7.5%">Xơ(g)</th>
													<th style="width: 9.5%">Khối lượng (g)</th>
												</tr>
											</thead>
										</table>
									</div>
									<div class="cm_chitiet_712_nlt_tba">
										<table>
											<tbody>
											</tbody>
										</table>
									</div>
									<table>
										<tfoot>
											<tr>
												<th style="width: 6%">Tổng</th>
												<th style="width: 18%"></th>
												<th style="width: 14%" class="cm-them_thu_don-chon_nguyen__lieu-tong_nl"></th>
												<th style="width: 7.5%" class="cm-them_thu_don-chon_nguyen__lieu-tong_protein"></th>
												<th style="width: 7.5%" class="cm-them_thu_don-chon_nguyen__lieu-tong_glucid"></th>
												<th style="width: 7.5%" class="cm-them_thu_don-chon_nguyen__lieu-tong_lipid"></th>
												<th style="width: 7.5%" class="cm-them_thu_don-chon_nguyen__lieu-tong_canxi"></th>
												<th style="width: 7.5%" class="cm-them_thu_don-chon_nguyen__lieu-tong_sat"></th>
												<th style="width: 7.5%" class="cm-them_thu_don-chon_nguyen__lieu-tong_kem"></th>
												<th style="width: 7.5%" class="cm-them_thu_don-chon_nguyen__lieu-tong_xo"></th>
												<th style="width: 9.5%;padding: 0" ></th>

											</tr>
										</tfoot>
									</table>
									<a href="#" class="cm-btn cm_tao_new_mon_an">Tạo món ăn</a>
								</div>	
							</div>
						</div>
					</div>
					<div class="truong_chon_nguyen_lieu_71220" style="display: none;">
						<div class="truong_chon_nguyen_lieu_71220_ov"></div>
						<div class="truong_chon_nguyen_lieu_71220_ct">
							<i class="fa fa-times"></i>
							<div class="truong_chon_nguyen_lieu_71220_1hd">
								<h5>Chọn nguyên liệu</h5>
								<input type="text" placeholder="Tìm kiếm" id="search-tra_cuu_3">
							</div>
							<div class="truong_chon_nguyen_lieu_71220_1ct">
								<div class="truong_chon_nguyen_lieu_71220_1ct_hd">
									<table>
										<thead>
											<tr>
												<th style="width: 6%">Ảnh</th>
												<th style="width: 20%">Tên</th>
												<th style="width: 14.5%">Năng lượng (kcal)</th>
												<th style="width: 8.5%">Protein(g)</th>
												<th style="width: 8.5%">Glucid(g)</th>
												<th style="width: 8.5%">Lipid(g)</th>
												<th style="width: 8.5%">Canxi(mg)</th>
												<th style="width: 8.5%">Sắt(mg)</th>
												<th style="width: 8.5%">Kẽm(mg)</th>
												<th style="width: 8.5%">Xơ(g)</th>
											</tr>
										</thead>
									</table>
								</div>
								<div class="truong_chon_nguyen_lieu_71220_1ct_tb">
									<table>
										<tbody>
											<?php if (!empty($list_nguyen_lieu)): ?>
												<?php foreach ($list_nguyen_lieu as $key => $value): ?>
													<tr>
														<td style="width: 6%"><img src="<?php echo $value->anh_av ?>" alt=""></td>
														<td style="width: 20%"><label><input type="checkbox" value="<?php echo $value->ten ?>"><?php echo $value->ten ?></label>
														</td>
														<td style="width: 14.5%"><?php echo $value->nang_luong ?></td>
														<td style="width: 8.5%"><?php echo $value->protein ?></td>
														<td style="width: 8.5%"><?php echo $value->glucid ?></td>
														<td style="width: 8.5%"><?php echo $value->lipid ?></td>
														<td style="width: 8.5%"><?php echo $value->canxi ?></td>
														<td style="width: 8.5%"><?php echo $value->sat ?></td>
														<td style="width: 8.5%"><?php echo $value->kem ?></td>
														<td style="width: 8.5%"><?php echo $value->xo ?></td>
													</tr>
												<?php endforeach ?>
											<?php endif ?>
										</tbody>
									</table>
								</div>
								<a href="#" class="cm-btn truong_chon_nguyen_lieu_71220_1ct_tb_btn">Thêm nguyên liệu</a>
							</div>
						</div>
					</div>
					<div class="truong_them__mon__an" style="display: none">
						<div class="truong_them__mon__an_ov"></div>
						<div class="truong_them__mon__an_ct">
							<div class="truong_them__mon__an_ct_hd">
								<h2>Chọn món ăn</h2>
								<input type="text" id="search-tra_cuu_2" name="truong_search_mon_sang" placeholder="Tìm theo tên món ăn">
							</div>
							<div class="truong_them__mon__an_ct_m">
								<?php if (!empty($list_monan)): ?>
									<i class="fa fa-times"></i>
									<div>
										<table>
											<thead>
												<tr>
													<th style="width: 6%;">Ảnh</th>
													<th style="width: 18%;">Món ăn</th>
													<th style="width: 12%; padding:0">Năng lượng (kcal)</th>
													<th style="width: 8.5%; padding:0">Protein (g)</th>
													<th style="width: 8.5%; padding:0">Glucid (g)</th>
													<th style="width: 8.5%; padding:0">Lipid (g)</th>
													<th style="width: 8.5%; padding:0">Canxi (mg)</th>
													<th style="width: 8%; padding:0">Sắt (mg)</th>
													<th style="width: 8%; padding:0">Kẽm (mg)</th>
													<th style="width: 8%; padding:0">Xơ (g)</th>
													<th style="width: 6%; padding:0">Phần ăn</th>
												</tr>
											</thead>
										</table>
									</div>
									<div class="truong_them__mon__an_ct_m_tb2">
										<table>           
											<tbody>
												<?php foreach ($list_monan as $key => $value): ?>
													<tr>
														<td style="width: 6%;padding:0"><img src="<?php echo $value->anh_av ?>" alt=""></td>
														<td class="cm_ten_mon_an_2103" style="width: 18%;"><label><input type="checkbox" value="<?php echo $value->ten ?>"><?php echo $value->ten ?></label></td>
														<td style="width: 12%;"><?php echo $value->nang_luong ?></td>
														<td style="width: 8.5%;"><?php echo $value->protein ?></td>
														<td style="width: 8.5%;"><?php echo $value->glucid ?></td>
														<td style="width: 8.5%;"><?php echo $value->lipid ?></td>
														<td style="width: 8.5%;"><?php echo $value->canxi ?></td>
														<td style="width: 8%;"><?php echo $value->sat ?></td>
														<td style="width: 8%;"><?php echo $value->kem ?></td>
														<td style="width: 8%;"><?php echo $value->xo ?></td>
														<td class="cm_chon_khau_phan" style="width: 6%;">
															<label><input type="radio" name="khau_phan_an<?php echo $key ?>" value="1">100%</label>
															<label><input type="radio" name="khau_phan_an<?php echo $key ?>" value="0.75">75%</label>
															<label><input type="radio" name="khau_phan_an<?php echo $key ?>" value="0.5">50%</label>
														</td>
													</tr>
												<?php endforeach ?>
											</tbody>
										</table>
									</div>
									<a href="#" class="cm-btn cm_truong_them_td_btn_712">Thêm vào thực đơn</a>
								<?php endif ?>
							</div>
						</div>
					</div> 
				</div>

				<!-- DINH DƯỠNG HÔM NAY -->
				<div class="cm_truong_td_today">
					<h3>Thực đơn hôm nay <span class="cm_none_mb">- ngày</span><span> <?php echo $date; ?></span></h3>
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
								<tr class="nhucau_con_lai_4123">
									<td><h5>Dinh Dưỡng Còn Lại</h5></td>
								</tr>
								<tr class="nhucau_check_4100">
									<?php
									$pt_protein=round((($phuhuynh->tong_protein)*4/($phuhuynh->tong_nang_luong))*100 , 2);
									$pt_lipid=round((($phuhuynh->tong_lipid)*9/($phuhuynh->tong_nang_luong))*100 , 2);
									$pt_glucid=round((100-$pt_protein-$pt_lipid), 2);
									?>
									<td><h5>Tỷ lệ:</h5></td>
									<td></td>
									<td class="<?php if($pt_protein <= 13){echo "cl-thieu";} else if($pt_protein <= 20){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_protein>0){echo $pt_protein;}else{echo "0";}?>%</span></td>
									<td class="<?php if($pt_glucid <= 50){echo "cl-thieu";} else if($pt_glucid <= 65){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_glucid>0){echo $pt_glucid;}else{echo "0";}?>%</span></td>
									<td class="<?php if($pt_lipid <= 20){echo "cl-thieu";} else if($pt_lipid <= 30){echo "cl-ok";}else{echo "cl-thua";} ?>"><span><?php if($pt_lipid>0){echo $pt_lipid;}else{echo "0";}?>%</span></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td><h5>Tỷ lệ chuẩn:</h5></td>
									<td></td>
									<td>13% - 20%</td>
									<td>50% - 65%</td>
									<td>20% - 30%</td>
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
													<th style="width:8.5%">Kẽm (mg)</th>
													<th style="width:8.5%">Xơ (g)</th>
													<th></th>
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
													<td style="width:8.5%">'.$mon_an_sh[$i]->xo.'</td><td><a href="#" class="cm_delete_mon_an">x</a></td></tr>';
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
													<th></th>
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
													<td style="width:8.5%">'.$mon_an_sh[$i]->xo.'</td><td><a href="#" class="cm_delete_mon_an">x</a></td></tr>';
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
													<th></th>
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
													<td style="width:8.5%">'.$mon_an_sh[$i]->xo.'</td><td><a href="#" class="cm_delete_mon_an">x</a></td></tr>';
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
													<th></th>
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
													<td style="width:8.5%">'.$mon_an_sh[$i]->xo.'</td><td><a href="#" class="cm_delete_mon_an">x</a></td></tr>';
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

					<!-- THỰC ĐƠN THÁNG -->
					<?php
					echo do_shortcode('[thu_don_phu_huynh]');
					?>
					<!-- BIỂU ĐỒ -->
					<div style="margin-top: 50px;">
						<h3>Thống kê dinh dưỡng tháng <?php if($date1['mon']<10) {echo "0".$date1['mon'];}else{echo $date1['mon'];} ?>/<?php echo $date1['year']; ?></h3>
						<?php 
						$results = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_thong_ke WHERE user_id ="'.$id_hs.'" ORDER BY ngay ASC'  );
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
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
		<?php
		$cm_hoc_sinh = ob_get_contents(); 
		ob_end_clean();
		return $cm_hoc_sinh;
	}
	add_shortcode( 'phu_huynh', 'create_shortcode_phu_huynh' );
