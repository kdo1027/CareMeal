<?php
function create_shortcode_goi_y_home() {
	ob_start();
	global $wpdb;
	$list_monan_trua = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE nhom NOT LIKE "%sáng%" ' );
	$list_monan_sang = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE nhom LIKE "%sáng%" ' );
	$list_nguyen_lieu = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_nguyen_lieu WHERE ten !="" ORDER BY id ASC' );
	$list_bua_phu = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_nguyen_lieu WHERE ten !="" AND nhom ="nhom-5" OR nhom = "nhom-10" OR nhom = "nhom-12" ORDER BY id ASC' );
	$date= date("d/m/Y");
	$nhatruong = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thuc_don WHERE ngay = "'.$date.'"');
	?>
	<div class="cm_ktra_dinh_duong" style="display: none">
		<div class="cm_ktra_dinh_duong_content">
			<div class="cm_chon_bua_an">
				<div class="cm_chon_bua_an_sang">
					<h4>Bữa Sáng</h4>
					<select>
						<option value="chon_mon_an">Chọn món ăn</option>
						<?php
						foreach ($list_monan_sang as $mon_an_sang) {
							?>
							<option value="<?php echo $mon_an_sang->ten ?>"><?php echo $mon_an_sang->ten ?></option>
							<?php
						}
						?>
					</select>
				</div>
				<div class="cm_chon_bua_an_trua">
					<h4>Bữa Trưa</h4>
					<select>
						<option value="chon_mon_an">Chọn món ăn</option>
						<?php
						foreach ($list_monan_trua as $mon_an_trua) {
							?>
							<option value="<?php echo $mon_an_trua->ten ?>"><?php echo $mon_an_trua->ten ?></option>
							<?php
						}
						?>
					</select>
				</div>
				<div class="cm_chon_bua_an_toi">
					<h4>Bữa Tối</h4>
					<select>
						<option value="chon_mon_an">Chọn món ăn</option>
						<?php
						foreach ($list_monan_trua as $mon_an_trua) {
							?>
							<option value="<?php echo $mon_an_trua->ten ?>"><?php echo $mon_an_trua->ten ?></option>
							<?php
						}
						?>
					</select>
				</div>
				<div class="cm_chon_bua_an_toi">
					<h4>Bữa Phụ</h4>
					<select>
						<option value="chon_mon_an">Chọn món ăn</option>
						<?php
						foreach ($list_bua_phu as $mon_an_phu) {
							?>
							<option value="<?php echo $mon_an_phu->ten ?>"><?php echo $mon_an_phu->ten ?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
			<div class="cm_ket_qua_bua_an">
				<div class="cm_ket_qua_bua_an_sang" style="display: none">
					<h4>Dinh dưỡng bữa ăn sáng</h4>
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
						<tbody>
							
						</tbody>
						<tfoot>
							<th>Tổng</th>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php
	$bmi_dinh_duong_home = ob_get_contents(); 
	ob_end_clean();
	return $bmi_dinh_duong_home;
}
add_shortcode( 'goi_y_home', 'create_shortcode_goi_y_home' );