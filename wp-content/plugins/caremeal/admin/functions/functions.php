<?php 
//--------------------------------------------------------------------------
//Thêm css và js trang Admin
////▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
function care_meal_add_js_css() {
  // Thêm css
	wp_enqueue_style( 'care_meal_css', CARE_MEAL_URL .'admin/inc/css/care-meal.css');
  //Thêm Js
	wp_enqueue_script('care_meal_js', CARE_MEAL_URL .'admin/inc/js/care-meal.js', array(), false, true);
}
add_action( 'admin_enqueue_scripts', 'care_meal_add_js_css' );
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {

	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}


//--------------------------------------------------------------------------
//Thêm css và js ngoài giao diện
////▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
function care_meal_add_js_css_fe() {
	$version=uniqid();
  // Thêm css
	wp_enqueue_style( 'care_meal_css', CARE_MEAL_URL .'view/css/care-meal-fe.css',true,$version,'all');
	wp_enqueue_style( 'font_css', CARE_MEAL_URL .'view/fonts/fonts.css',true,$version,'all');
  //Thêm Js
	wp_enqueue_script('thong_bao_js', CARE_MEAL_URL .'view/js/thong_bao/push.min.js', array(), false , true);
	// wp_enqueue_script('ml5_js', CARE_MEAL_URL .'view/js/image/ml5.min.js', array(), false , true);
	wp_enqueue_script('care_meal_js', CARE_MEAL_URL .'view/js/care-meal-fe.js', array(), $version, true);
}
add_action( 'wp_enqueue_scripts', 'care_meal_add_js_css_fe' );

//--------------------------------------------------------------------------
// Lấy URL của domain
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
function getCurURL()
{
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
		$pageURL = "https://";
	} else {
		$pageURL = 'http://';
	}
	$pageURL .= $_SERVER["SERVER_NAME"];
	return $pageURL;
}

//--------------------------------------------------------------------------
//Chuyển đổi ký tự Unicode sang Latin
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
function unicode_convert($str){
	if(!$str) return false;
	$unicode = array(
		'a'=>array('á','à','ả','ã','ạ','à','ă','ắ','ặ','ằ','ẳ','ẵ','â','ấ','ầ','ẩ','ẫ','ậ','Á','À','Ả','á','Ã','Ạ','Ă','Ắ','Ặ','Ằ','Ẳ','Ẵ','Â','Ấ','Ầ','Ẩ','Ẫ','Ậ','ạ'),
		'd'=>array('đ','Đ'),
		'e'=>array('é','è','ẻ','ẽ','ẹ','é','ê','ế','ề','ể','ễ','ệ','É','È','Ẻ','Ẽ','Ẹ','Ê','Ế','Ề','é','Ể','Ễ','Ệ','ẻ'),
		'i'=>array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
		'o'=>array('ơ','ó','ò','ỏ','õ','ọ','ô','ố','ở','ồ','ổ','ỗ','ộ','õ','ớ','ờ','ở','ỡ','ợ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ố','Ồ','Ổ','Ỗ','Ộ','Õ','Ơ','Ớ','Ờ','ợ','Ở','Ỡ','Ợ'),
		'u'=>array('ú','ư','Ư','ù','ủ','ũ','ụ','ý','ú','ứ','ừ','ử','ữ','ự','Ú','Ù','Ủ','Ũ','Ụ','Ý','Ứ','Ừ','Ử','Ữ','Ự','ứ'),
		'y'=>array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','ỳ','Ỹ','Ỵ'),
	);
	foreach($unicode as $nonUnicode=>$uni){
		foreach($uni as $value)
			$str = str_replace($value,$nonUnicode,$str);
	}
	return $str;
}

//--------------------------------------------------------------------------
//Tạo menu trong Admin
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
add_action('admin_menu', 'care_meal_add_pages');
function care_meal_add_pages() {
  // Admin main menu Nguyên Liệu
	add_menu_page( __('Nguyên liệu','theme-wp'), __('Nguyên liệu','theme-wp'), 'manage_options', 'nguyen_lieu','nguyen_lieu','dashicons-carrot', 5.5 );
	add_submenu_page( 'nguyen_lieu', __( 'Nhập nguyên liệu', 'theme-wp' ), __( 'Nhập nguyên liệu', 'theme-wp' ),'manage_options', 'nhap_nguyen_lieu', 'nhap_nguyen_lieu');

  // Admin main menu Món ăn
	add_menu_page( __('Món ăn','theme-wp'), __('Món ăn','theme-wp'), 'manage_options', 'mon_an','mon_an','dashicons-food', 5 );
	add_submenu_page('mon_an', __( 'Thêm món ăn', 'theme-wp' ),__( 'Thêm món ăn', 'theme-wp' ),'manage_options','them_mon_an','them_mon_an');

  // Admin main menu Thực đơn
	add_menu_page( __('Thực đơn','theme-wp'), __('Thực đơn','theme-wp'), 'manage_options', 'thuc_don','thuc_don','dashicons-text-page', 6.5 );
	//add_submenu_page('thuc_don', __( 'Thêm thực đơn', 'theme-wp' ),__( 'Thêm thực đơn', 'theme-wp' ),'manage_options','them_thuc_don','them_thuc_don');
	
	
  // Admin main menu Năng lượng
	add_menu_page( __('Năng lượng','theme-wp'), __('Năng lượng','theme-wp'), 'manage_options', 'nang_luong','nang_luong','dashicons-chart-pie', 6 );
	add_submenu_page('nang_luong', __( 'Thêm', 'theme-wp' ),__( 'Thêm', 'theme-wp' ),'manage_options','them_nang_luong','them_nang_luong');
}

/*→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→
↑                                 NGUYÊN LIỆU                              ↓
←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←*/

//--------------------------------------------------------------------------
//Quản lý nguyên liệu
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
function nguyen_lieu(){    
	global $wpdb;
	if (!empty($_GET['edit_nguyen_lieu'])) {
		edit_nguyen_lieu($_GET['edit_nguyen_lieu']);
	} else {        
		$table_name = $wpdb->prefix.'cm_nguyen_lieu';
		if (!empty($_GET['delete_id'])) {
			$xoa = $wpdb->delete( $table_name, array( 'id' => $_GET['delete_id'] ), array( '%d' ) );
		}
		$where = $search = '';
		if (!empty($_REQUEST['xoa_nguyen_lieu'])) {
			$xoa = $wpdb->query('DELETE FROM '.$wpdb->prefix.'cm_nguyen_lieu WHERE id IN('.implode(',', $_REQUEST['xoa_nguyen_lieu']).')');
		} else {
			if (!empty($_REQUEST['search'])) {
				$where .= ' WHERE ten LIKE "%'.$_REQUEST['search'].'%"';
				$search .= '&search='.$_REQUEST['search'];
			}
		}
		$count = $wpdb->get_var( 'SELECT COUNT(id) AS dem FROM '.$table_name.$where );
		$ppage = 25;
		if ($count > $ppage) {
			$maxpage = ceil($count/$ppage);
			if(isset($_REQUEST['paged'])){
				$trang = $_REQUEST['paged'];
				if($trang > $maxpage) $trang = $maxpage;
			}else{
				$trang = 1;
			}
			$dau = ($trang-1)*$ppage;
			$results = $wpdb->get_results( 'SELECT * FROM '.$table_name.$where.' ORDER BY id DESC LIMIT '.$dau.', '.$ppage );
		} else {
			$results = $wpdb->get_results( 'SELECT * FROM '.$table_name.$where.' ORDER BY id DESC' );
		}
		?>
		<div class="wrap">
			<form method="GET" class="form-horizontal" role="form" action="">
				<input type="hidden" name="page" value="nguyen_lieu">
				<h1 class="wp-heading-inline">Nguyên liệu</h1>
				<a class="page-title-action" href="<?php echo get_admin_url().'admin.php?page=nhap_nguyen_lieu'; ?>">Thêm nguyên liệu</a>
				<?php if (!empty($xoa)): ?>
					<div class="updated notice is-dismissible"> 
						<p><strong>Đã xoá thành công.</strong></p>
					</div>
				<?php endif ?>
				<h2>Có tất cả <?php echo $count; ?> nguyên liệu <?php echo (!empty($_REQUEST['search'])) ? 'khớp với từ khóa "'.$_REQUEST['search'].'"' : ''; ?></h2>
				<h2>Tìm kiếm</h2>
				<table>
					<tr>
						<td>
							<input type="text" name="search" placeholder="Tìm theo tên nguyên liệu" style="width: 200px">
						</td>
						<td>
							<input type="submit" name="xem" value="Tìm kiếm" class="button button-primary">
						</td>

						<td>
							<input type="submit" name="xoa" value="Xoá nguyên liệu đã chọn" class="button button-primary">
						</td>
					</tr>
				</table>
				<br>
				<?php if ($count > $ppage): ?>
					<div class="tablenav">
						<div class="tablenav-pages"><span class="displaying-num"><?php echo $count; ?> Nguyên liệu</span>
							<span class="pagination-links">
								<?php if ($trang == 1): ?>
									<span class="tablenav-pages-navspan" aria-hidden="true">«</span>
									<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
									<?php else: ?>
										<a class="first-page" href="<?php echo get_admin_url().'admin.php?page=nguyen_lieu'.$search; ?>">
											<span class="screen-reader-text">Trang Tĩnh Đầu Tiên</span>
											<span aria-hidden="true">«</span>
										</a> 
										<a class="prev-page" href="<?php echo get_admin_url().'admin.php?page=nguyen_lieu&paged='.($trang-1).$search; ?>">
											<span class="screen-reader-text">Trang trước</span>
											<span aria-hidden="true">‹</span>
										</a>
									<?php endif ?>
									<span class="paging-input">
										<input class="current-page" id="current-page-selector" type="text" name="paged" value="<?php echo $trang; ?>" size="4" aria-describedby="table-paging">
										<span class="tablenav-paging-text"> trên 
											<span class="total-pages"><?php echo $maxpage; ?>

										</span>
									</span>
								</span>
								<?php if ($trang == $maxpage): ?>
									<span class="tablenav-pages-navspan" aria-hidden="true">›</span>
									<span class="tablenav-pages-navspan" aria-hidden="true">»</span>
									<?php else: ?>
										<a class="next-page" href="<?php echo get_admin_url().'admin.php?page=nguyen_lieu&paged='.($trang+1).$search; ?>">
											<span class="screen-reader-text">Trang sau</span>
											<span aria-hidden="true">›</span>
										</a>
										<a class="last-page" href="<?php echo get_admin_url().'admin.php?page=nguyen_lieu&paged='.($maxpage).$search; ?>">
											<span class="screen-reader-text">Trang cuối</span>
											<span aria-hidden="true">»</span>
										</a>
									<?php endif ?>
								</span>
							</div>
							<br class="clear">
						</div>
					<?php endif ?>
					<?php if ($count > 0): ?>
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="width: 20px"><input type="checkbox" name="xoa_all_nguyen_lieu" value="ok"></th>
										<th style="width: 24px;">STT</th>
										<th>Ảnh</th>
										<th>Info</th>
										<th>Tên nguyên liệu</th>   
										<th>Nhóm</th>
										<th>Năng lượng (kcal)</th> 
										<th>Protein (g)</th> 
										<th>Glucid (g)</th> 
										<th>Lipid (g)</th>                            
										<th>Quản trị</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = (!empty($dau)) ? ($dau+1) : 1;
									foreach ($results as $result) { ?>
										<tr>
											<td>
												<input class="input_xoa_nguyen_lieu" type="checkbox" name="xoa_nguyen_lieu[]" value="<?php echo $result->id ?>">
											</td>
											<td><?php echo $i;?></td>
											<td width='60px' style='padding: 2px;'>
												<img src="<?php echo getCurURL(); echo $result->anh_av; ?>" width="60" height="60" />
											</td>
											<td width='60px' style='padding: 2px;'>
												<img src="<?php echo getCurURL(); echo $result->anh_if; ?>" width="60" height="60" />
											</td>                                     
											<td>

												<a href="<?php echo getCurURL(); echo $result->url; ?>" target="_blank"><?php echo $result->ten; ?></a>
											</td>
											<td>
												<?php 
												$cmnhom = $result->nhom; 
												switch ($cmnhom) {
													case 'nhom-1':
													$cmnhom ="Ngũ cốc và sản phẩm chế biến";
													break;
													case 'nhom-2':
													$cmnhom ="Khoai củ và sản phẩm chế biến";
													break;
													case 'nhom-3':
													$cmnhom ="Hạt, quả giàu đạm, béo và sản phẩm chế biến";
													break;
													case 'nhom-4':
													$cmnhom ="Rau, quả, củ dùng làm rau";
													break;
													case 'nhom-5':
													$cmnhom ="Quả chín";
													break;
													case 'nhom-6':
													$cmnhom ="Dầu, mỡ, bơ";
													break;
													case 'nhom-7':
													$cmnhom ="Thịt và sản phẩm chế biến";
													break;
													case 'nhom-8':
													$cmnhom ="Thủy sản và sản phẩm chế biến";
													break;
													case 'nhom-9':
													$cmnhom ="Trứng và sản phẩm chế biến";
													break;
													case 'nhom-10':
													$cmnhom ="Sữa và sản phẩm chế biến";
													break;
													case 'nhom-11':
													$cmnhom ="Đồ hộp";
													break;
													case 'nhom-12':
													$cmnhom ="Đồ ngọt (đường, bánh, mứt, kẹo)";
													break;
													case 'nhom-13':
													$cmnhom ="Gia vị, nước chấm";
													break;
													case 'nhom-14':
													$cmnhom ="Nước giải khát, bia, rượu";
													break;
												}                                                
												echo $cmnhom;
												?>
											</td>
											<td><?php echo $result->nang_luong; ?></td>
											<td><?php echo $result->protein; ?></td>
											<td><?php echo $result->glucid; ?></td>
											<td><?php echo $result->lipid; ?></td>
											<td>
												<a href="<?php echo get_admin_url().'admin.php?page=nguyen_lieu&edit_nguyen_lieu='.$result->id; ?>" class="button button-primary">Sửa</a>
												<a href="<?php echo get_admin_url().'admin.php?page=nguyen_lieu&delete_id='.$result->id; ?>" class="button button-primary" onclick="return confirm('Bạn có chắc chắn muốn xoá nguyên liệu này không?');">Xoá</a>
											</td>
										</tr>
										<?php 
										$i++;
									} ?>
								</tbody>
							</table>
						</div>                    
						<?php else: ?>
							<h3>Không tìm thấy nguyên liệu nào nào.</h3>
						<?php endif ?>
					</form>
				</div>
			<?php }
		}

//--------------------------------------------------------------------------
//Nhập nguyên liệu 
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
		function nhap_nguyen_lieu(){ 
			?>
			<div class="wrap">
				<form method="POST" class="form-horizontal" role="form" action="" enctype="multipart/form-data">
					<h1>Nhập nguyên liệu</h1>
					<?php if (!empty($_POST['save'])):
						if (!empty($_POST['ten'])) {
							global $wpdb;
							require_once 'upload-photo.php';
							$insert = $wpdb->insert( 
								$wpdb->prefix.'cm_nguyen_lieu', 
								array( 
									'ten' => $_POST['ten'],
									'nhom' => $_POST['nhom'],
									'nang_luong' => $_POST['nang_luong'],
									'protein' => $_POST['protein'],
									'lipid' => $_POST['lipid'],
									'glucid' => $_POST['glucid'], 
									'anh_av' => $new_file_path_db,
									'anh_if' => $new_file_path_2_db,            
									'anh_av_id' => $av_id,            
									'anh_if_id' => $if_id,  
									'url' => '/nguyen-lieu/?'.str_replace(' ','-',unicode_convert(strtolower($_POST['ten']))),
								), 
								'%s'
							);
						}  else {
							$error = 'Không đủ dữ liệu';
						}
						if (!empty($insert)): ?>
							<div class="updated notice is-dismissible"> 
								<p><strong>Thêm nguyên liệu thành công.</strong></p>
							</div>
							<?php elseif (!empty($error)): ?>
								<div class="error notice is-dismissible"> 
									<p><strong><?php echo $error; ?></strong></p>
								</div>
								<?php else: ?>
									<div class="error notice is-dismissible"> 
										<p><strong>Thêm nguyên liệu thất bại. Thiếu trường dữ liệu hoặc nguyên liệu đã tồn tại</strong></p>
									</div>
								<?php endif;
							endif; ?>
							<table class="cm-nhap__thong-tin">
								<thead>
									<tr>
										<td class=""><b>Tên nguyên liệu:</b></td>
										<td><input type="text" name="ten" style="width: 100%"></td>
										<td><b>Nhóm thực phẩm</b></td>
										<td>  
											<select>
												<option value="nhom-1">Ngũ cốc và sản phẩm chế biến</option>
												<option value="nhom-2">Khoai củ và sản phẩm chế biến </option>
												<option value="nhom-3">Hạt, quả giàu đạm, béo và sản phẩm chế biến  </option>
												<option value="nhom-4">Rau, quả, củ dùng làm rau </option>
												<option value="nhom-5">Quả chín </option>
												<option value="nhom-6">Dầu, mỡ, bơ   </option>
												<option value="nhom-7">Thịt và sản phẩm chế biến  </option>
												<option value="nhom-8">Thủy sản và sản phẩm chế biến </option>
												<option value="nhom-9">Trứng và sản phẩm chế biến</option>
												<option value="nhom-10">Sữa và sản phẩm chế biến </option>
												<option value="nhom-11">Đồ hộp</option>
												<option value="nhom-12">Đồ ngọt (đường, bánh, mứt, kẹo) </option>
												<option value="nhom-13">Gia vị, nước chấm </option>
												<option value="nhom-14">Nước giải khát, bia, rượu </option>       
											</select>
										</td>
										<td style="display:none"><input type="text" name="nhom" value="nhom-1"></td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><b>Ảnh nguyên liệu:</b>
											<input id="imgInp" type="file" name="profilepicture" size="25" style="display: none;" />
											<input type="button" value="Chọn" onclick="document.getElementById('imgInp').click();" />
											<img id="blah" src="/wp-content/uploads/2020/09/Untitled-1.png" width='50' height='50' />
										</td>
										<td><b>Ảnh thông tin chi tiết:</b> 
											<input id="imgInp_2" type="file" name="profilepicture_2" size="25" style="display: none;" />
											<input type="button" value="Chọn" onclick="document.getElementById('imgInp_2').click();" />
											<img id="blah_2" src="/wp-content/uploads/2020/09/Untitled-1.png" width='50' height='50' />
										</td>
									</tr>
									<tr>
										<td><b>Năng lượng (KCal):</b><input type="text" name="nang_luong"></td>
										<td><b>Protein:</b><input type="text" name="protein"></td>
										<td><b>Glucid:</b><input type="text" name="glucid"></td>
										<td><b>Lipid:</b><input type="text" name="lipid"></td>
									</tr>
								</tbody>
								<tfoot>
									<td><input type="submit" name="save" value="Thêm nguyên liệu" class="button button-primary"></td>
								</tfoot>            
							</table>        
						</form>
					</div>
					<?php
				}

//--------------------------------------------------------------------------
// Sửa nguyên liệu
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
				function edit_nguyen_lieu($id){
					global $wpdb;
					$table_name = $wpdb->prefix.'cm_nguyen_lieu';
					if (!empty($id) && current_user_can( 'administrator' )): ?>
						<div class="wrap">
							<form action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
								<?php
								if (!empty($_POST['save'])):
									require_once 'upload-photo.php';
									$update = $wpdb->update( 
										$wpdb->prefix.'cm_nguyen_lieu',
										array(
											'ten' => $_POST['ten'],
											'nhom' => $_POST['nhom'],
											'nang_luong' => $_POST['nang_luong'],
											'protein' => $_POST['protein'],
											'lipid' => $_POST['lipid'],
											'glucid' => $_POST['glucid'], 
											'anh_av' => $new_file_path_db,
											'anh_if' => $new_file_path_2_db,            
											'anh_av_id' => $av_id,            
											'anh_if_id' => $if_id,  
											'url' => '/nguyen-lieu/?'.str_replace(' ','-',unicode_convert(strtolower($_POST['ten']))),
										), 
										array( 'id' => $id ), 
										'%s',
										'%s'
									);
									if (!empty($update)): ?>
										<div class="updated notice is-dismissible"> 
											<p><strong>Đã sửa nguyên liệu.</strong></p>
										</div>
										<?php elseif (!empty($error)): ?>
											<div class="error notice is-dismissible"> 
												<p><strong><?php echo $error; ?></strong></p>
											</div>
											<?php else: ?>
												<div class="error notice is-dismissible"> 
													<p><strong>Sửa nguyên liệu thất bại.</strong></p>
												</div>
											<?php endif;
										endif;
										$result = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_nguyen_lieu WHERE id = "'.$id.'"' ); ?>
										<h1>Sửa nguyên liệu</h1>
										<?php if (!empty($result)): ?>
											<table class="cm-nhap__thong-tin">
												<thead>
													<tr>
														<td class=""><b>Tên nguyên liệu:</b></td>
														<td><input type="text" name="ten" value="<?php echo $result->ten; ?>"></td>
														<td><b>Nhóm thực phẩm</b></td>
														<td>  
															<select>
																<?php                   
																$cmnhom=$result->nhom;
																switch ($cmnhom) {
																	case 'nhom-1':
																	$cmnhom ="Ngũ cốc và sản phẩm chế biến";
																	break;
																	case 'nhom-2':
																	$cmnhom ="Khoai củ và sản phẩm chế biến";
																	break;
																	case 'nhom-3':
																	$cmnhom ="Hạt, quả giàu đạm, béo và sản phẩm chế biến";
																	break;
																	case 'nhom-4':
																	$cmnhom ="Rau, quả, củ dùng làm rau";
																	break;
																	case 'nhom-5':
																	$cmnhom ="Quả chín";
																	break;
																	case 'nhom-6':
																	$cmnhom ="Dầu, mỡ, bơ";
																	break;
																	case 'nhom-7':
																	$cmnhom ="Thịt và sản phẩm chế biến";
																	break;
																	case 'nhom-8':
																	$cmnhom ="Thủy sản và sản phẩm chế biến";
																	break;
																	case 'nhom-9':
																	$cmnhom ="Trứng và sản phẩm chế biến";
																	break;
																	case 'nhom-10':
																	$cmnhom ="Sữa và sản phẩm chế biến";
																	break;
																	case 'nhom-11':
																	$cmnhom ="Đồ hộp";
																	break;
																	case 'nhom-12':
																	$cmnhom ="Đồ ngọt (đường, bánh, mứt, kẹo)";
																	break;
																	case 'nhom-13':
																	$cmnhom ="Gia vị, nước chấm";
																	break;
																	case 'nhom-14':
																	$cmnhom ="Nước giải khát, bia, rượu";
																	break;
																}    
																?> 
																<option value="<?php echo $result->nhom; ?>"><?php echo $cmnhom; ?></option>
																<option value="nhom-1">Ngũ cốc và sản phẩm chế biến</option>
																<option value="nhom-2">Khoai củ và sản phẩm chế biến </option>
																<option value="nhom-3">Hạt, quả giàu đạm, béo và sản phẩm chế biến  </option>
																<option value="nhom-4">Rau, quả, củ dùng làm rau </option>
																<option value="nhom-5">Quả chín </option>
																<option value="nhom-6">Dầu, mỡ, bơ   </option>
																<option value="nhom-7">Thịt và sản phẩm chế biến  </option>
																<option value="nhom-8">Thủy sản và sản phẩm chế biến </option>
																<option value="nhom-9">Trứng và sản phẩm chế biến</option>
																<option value="nhom-10">Sữa và sản phẩm chế biến </option>
																<option value="nhom-11">Đồ hộp</option>
																<option value="nhom-12">Đồ ngọt (đường, bánh, mứt, kẹo) </option>
																<option value="nhom-13">Gia vị, nước chấm </option>
																<option value="nhom-14">Nước giải khát, bia, rượu </option>       
															</select>
														</td>
														<td style="display:none"><input type="text" name="nhom" value="nhom-1"></td>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><b>Ảnh nguyên liệu:</b>
															<input id="imgInp" type="file" name="profilepicture" size="25" style="display: none;" />
															<input type="button" value="Chọn" onclick="document.getElementById('imgInp').click();" />
															<img id="blah" src="<?php echo getCurURL(); echo $result->anh_av; ?>" width="50" height="50" />
														</td>
														<td><b>Ảnh thông tin chi tiết:</b> 
															<input id="imgInp_2" type="file" name="profilepicture_2" size="25" style="display: none;" />
															<input type="button" value="Chọn" onclick="document.getElementById('imgInp_2').click();" />
															<img id="blah_2" src="<?php echo getCurURL(); echo $result->anh_if; ?>" width="50" height="50" />
														</td>
													</tr>
													<tr>
														<td><b>Năng lượng (KCal):</b><input type="text" name="nang_luong" value="<?php echo $result->nang_luong; ?>"></td>
														<td><b>Protein:</b><input type="text" name="protein" value="<?php echo $result->protein; ?>"></td>
														<td><b>Glucid:</b><input type="text" name="glucid" value="<?php echo $result->glucid; ?>"></td>
														<td><b>Lipid:</b><input type="text" name="lipid" value="<?php echo $result->lipid; ?>"></td>
													</tr>
												</tbody>
												<tfoot>
													<td><input type="submit" name="save" value="Cập nhật" class="button button-primary"></td>
												</tfoot>            
											</table> 
											<br>    
											<?php else: ?>
												<div class="error notice"><p>ID không hợp lệ.</p></div>
											<?php endif ?>
										</form>
									</div>
									<?php else: ?>
										<div class="wrap"><div class="error notice"><p>ID không hợp lệ hoặc bạn không đủ quyền truy cập.</p></div></div>
									<?php endif; 
								}

/*→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→
↑                             END NGUYÊN LIỆU                              ↓
←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←*/


/*→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→
↑                                   MÓN ĂN                                 ↓
←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←*/

//--------------------------------------------------------------------------
//Quản lý món ăn
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
function mon_an(){
	global $wpdb;
	if (!empty($_GET['edit_mon_an'])) {
		edit_mon_an($_GET['edit_mon_an']);
	} else {        
		$table_name = $wpdb->prefix.'cm_mon_an';
		if (!empty($_GET['delete_id'])) {
			$xoa = $wpdb->delete( $table_name, array( 'id' => $_GET['delete_id'] ), array( '%d' ) );
		}
		$where = $search = '';
		if (!empty($_REQUEST['xoa_mon_an'])) {
			$xoa = $wpdb->query('DELETE FROM '.$wpdb->prefix.'cm_mon_an WHERE id IN('.implode(',', $_REQUEST['xoa_mon_an']).')');
		} else {
			if (!empty($_REQUEST['search'])) {
				$where .= ' WHERE ten LIKE "%'.$_REQUEST['search'].'%"';
				$search .= '&search='.$_REQUEST['search'];
			}
		}
		$count = $wpdb->get_var( 'SELECT COUNT(id) AS dem FROM '.$table_name.$where );
		$ppage = 25;
		if ($count > $ppage) {
			$maxpage = ceil($count/$ppage);
			if(isset($_REQUEST['paged'])){
				$trang = $_REQUEST['paged'];
				if($trang > $maxpage) $trang = $maxpage;
			}else{
				$trang = 1;
			}
			$dau = ($trang-1)*$ppage;
			$results = $wpdb->get_results( 'SELECT * FROM '.$table_name.$where.' ORDER BY id DESC LIMIT '.$dau.', '.$ppage );
		} else {
			$results = $wpdb->get_results( 'SELECT * FROM '.$table_name.$where.' ORDER BY id DESC' );
		}
		?>
		<div class="wrap">
			<form method="GET" class="form-horizontal" role="form" action="">
				<input type="hidden" name="page" value="mon_an">
				<h1 class="wp-heading-inline">Món ăn</h1>
				<a class="page-title-action" href="<?php echo get_admin_url().'admin.php?page=them_mon_an'; ?>">Thêm món ăn</a>
				<?php if (!empty($xoa)): ?>
					<div class="updated notice is-dismissible"> 
						<p><strong>Đã xoá thành công.</strong></p>
					</div>
				<?php endif ?>
				<h2>Có tất cả <?php echo $count; ?> món ăn <?php echo (!empty($_REQUEST['search'])) ? 'khớp với từ khóa "'.$_REQUEST['search'].'"' : ''; ?></h2>
				<h2>Tìm kiếm</h2>
				<table>
					<tr>
						<td>
							<input type="text" name="search" placeholder="Tìm theo tên món ăn" style="width: 200px">
						</td>
						<td>
							<input type="submit" name="xem" value="Tìm kiếm" class="button button-primary">
						</td>

						<td>
							<input type="submit" name="xoa" value="Xoá món ăn đã chọn" class="button button-primary">
						</td>
					</tr>
				</table>
				<br>
				<?php if ($count > $ppage): ?>
					<div class="tablenav">
						<div class="tablenav-pages"><span class="displaying-num"><?php echo $count; ?> Món ăn</span>
							<span class="pagination-links">
								<?php if ($trang == 1): ?>
									<span class="tablenav-pages-navspan" aria-hidden="true">«</span>
									<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
									<?php else: ?>
										<a class="first-page" href="<?php echo get_admin_url().'admin.php?page=mon_an'.$search; ?>">
											<span class="screen-reader-text">Trang Tĩnh Đầu Tiên</span>
											<span aria-hidden="true">«</span>
										</a> 
										<a class="prev-page" href="<?php echo get_admin_url().'admin.php?page=mon_an&paged='.($trang-1).$search; ?>">
											<span class="screen-reader-text">Trang trước</span>
											<span aria-hidden="true">‹</span>
										</a>
									<?php endif ?>
									<span class="paging-input">
										<input class="current-page" id="current-page-selector" type="text" name="paged" value="<?php echo $trang; ?>" size="4" aria-describedby="table-paging">
										<span class="tablenav-paging-text"> trên 
											<span class="total-pages"><?php echo $maxpage; ?>
											
										</span>
									</span>
								</span>
								<?php if ($trang == $maxpage): ?>
									<span class="tablenav-pages-navspan" aria-hidden="true">›</span>
									<span class="tablenav-pages-navspan" aria-hidden="true">»</span>
									<?php else: ?>
										<a class="next-page" href="<?php echo get_admin_url().'admin.php?page=mon_an&paged='.($trang+1).$search; ?>">
											<span class="screen-reader-text">Trang sau</span>
											<span aria-hidden="true">›</span>
										</a>
										<a class="last-page" href="<?php echo get_admin_url().'admin.php?page=mon_an&paged='.($maxpage).$search; ?>">
											<span class="screen-reader-text">Trang cuối</span>
											<span aria-hidden="true">»</span>
										</a>
									<?php endif ?>
								</span>
							</div>
							<br class="clear">
						</div>
					<?php endif ?>
					<?php if ($count > 0): ?>
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="width: 20px"><input type="checkbox" name="xoa_all_mon_an" value="ok"></th>
										<th style="width: 24px;">STT</th>
										<th style="width: 24px;">Ảnh</th>
										<th>Tên món ăn</th>  
										<th>Nhóm</th> 
										<!-- <th>Nguyên liệu</th>  --> 
										<th>Năng lượng (kcal)</th> 
										<th>Protein (g)</th> 
										<th>Glucid (g)</th> 
										<th>Lipid (g)</th>                            
										<th>Quản trị</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = (!empty($dau)) ? ($dau+1) : 1;
									foreach ($results as $result) { ?>
										<tr>
											<td>
												<input class="input_xoa_mon_an" type="checkbox" name="xoa_mon_an[]" value="<?php echo $result->id ?>">
											</td>
											<td><?php echo $i;?></td>                                   
											<td>
												<?php echo $result->ten; ?>
												<!-- <a href="<?php //echo getCurURL().'/mon-an/?'.str_replace(' ','-',unicode_convert(strtolower($result->ten))); ?>" target="_blank"><?php //echo $result->ten; ?></a> -->
											</td>
											<td><img src="<?php echo getCurURL(); echo $result->anh_av; ?>" width="60" height="60" /></td>
											<td><?php echo $result->nhom; ?></td>
											<!-- <td><?php //echo $result->nguyen_lieu; ?></td> -->
											<td><?php echo $result->nang_luong; ?></td>
											<td><?php echo $result->protein; ?></td>
											<td><?php echo $result->glucid; ?></td>
											<td><?php echo $result->lipid; ?></td>
											<td>
												<a href="<?php echo get_admin_url().'admin.php?page=mon_an&edit_mon_an='.$result->id; ?>" class="button button-primary">Sửa</a>
												<a href="<?php echo get_admin_url().'admin.php?page=mon_an&delete_id='.$result->id; ?>" class="button button-primary" onclick="return confirm('Bạn có chắc chắn muốn xoá món ăn này không?');">Xoá</a>
											</td>
										</tr>
										<?php 
										$i++;
									} ?>
								</tbody>
							</table>
						</div>                    
						<?php else: ?>
							<h3>Không tìm thấy món ăn nào.</h3>
						<?php endif ?>
					</form>
				</div>
			<?php }
		}


//--------------------------------------------------------------------------
//Thêm món ăn
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
		function them_mon_an(){ 
			?>
			<div class="wrap">
				<form method="POST" class="form-horizontal" role="form" action="" enctype="multipart/form-data">
					<h1>Thêm món  ăn</h1>
					<?php if (!empty($_POST['save'])):
						if (!empty($_POST['ten'])) {
							global $wpdb;
							require_once 'upload-photo.php';
							$insert = $wpdb->insert( 
								$wpdb->prefix.'cm_mon_an', 
								array( 
									'ten' => $_POST['ten'],
									'nhom' => $_POST['nhom'],
									'nguyen_lieu' => $_POST['nguyen_lieu'],
									'nang_luong' => $_POST['nang_luong'],
									'protein' => $_POST['protein'],
									'lipid' => $_POST['lipid'],
									'glucid' => $_POST['glucid'], 
									'anh_av' => $new_file_path_db,            
									'anh_av_id' => $av_id,  
									'url' =>'/mon-an/?'.str_replace(' ','-',unicode_convert(strtolower($_POST['ten']))),
								), 
								'%s'
							);
						}  else {
							$error = 'Không đủ dữ liệu';
						}
						if (!empty($insert)): ?>
							<div class="updated notice is-dismissible"> 
								<p><strong>Thêm món ăn thành công.</strong></p>
							</div>
							<?php elseif (!empty($error)): ?>
								<div class="error notice is-dismissible"> 
									<p><strong><?php echo $error; ?></strong></p>
								</div>
								<?php else: ?>
									<div class="error notice is-dismissible"> 
										<p><strong>Thêm Món ăn thất bại. Thiếu trường dữ liệu hoặc món ăn đã tồn tại</strong></p>
									</div>
								<?php endif;
							endif; ?>
							<table class="cm-nhap__thong-tin">
								<thead>
									<tr>
										<td class=""><b>Tên món ăn:</b></td>
										<td><input type="text" name="ten" style="width: 100%"></td>
									</tr>
									<tr>
										<td><b>Nhóm</b></td>
										<td class="cm-add__mon-an">  
											<input type="text" name="nhom">
											<label for="ma1"><input type="checkbox" value="Bữa sáng" id="ma1" class="cm-add__mon-an__nhom">Bữa sáng</label>
											<label for="ma2"><input type="checkbox" value="Bữa phụ chiều" id="ma2" class="cm-add__mon-an__nhom">Bữa phụ chiều</label>
											<label for="ma3"><input type="checkbox" value="Bữa phụ tối" id="ma3" class="cm-add__mon-an__nhom">Bữa phụ tối</label>
										</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><b>Ảnh món ăn:</b>
											<input id="imgInp" type="file" name="profilepicture" size="25" style="display: none;" />
											<input type="button" value="Chọn" onclick="document.getElementById('imgInp').click();" />
											<img id="blah" src="/wp-content/uploads/2020/09/Untitled-1.png" width='50' height='50' />
										</td>
									</tr>
									<tr>
										<td><b>Năng lượng (KCal):</b><input type="text" name="nang_luong"></td>
										<td><b>Protein:</b><input type="text" name="protein"></td>
										<td><b>Glucid:</b><input type="text" name="glucid"></td>
										<td><b>Lipid:</b><input type="text" name="lipid"></td>
									</tr>
								</tbody>
								<tfoot>
									<td><input type="submit" name="save" value="Thêm món ăn" class="button button-primary"></td>
								</tfoot>            
							</table>        
						</form>
					</div>
					<?php
				}

//--------------------------------------------------------------------------
// Sửa món ăn
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
				function edit_mon_an($id){
					global $wpdb;
					$table_name = $wpdb->prefix.'cm_mon_an';
					if (!empty($id) && current_user_can( 'administrator' )): ?>
						<div class="wrap">
							<form action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
								<?php
								if (!empty($_POST['save'])):
									require_once 'upload-photo.php';
									$update = $wpdb->update( 
										$wpdb->prefix.'cm_mon_an',
										array(
											'ten' => $_POST['ten'],
											'nhom' => $_POST['nhom'],
											'nang_luong' => $_POST['nang_luong'],
											'protein' => $_POST['protein'],
											'lipid' => $_POST['lipid'],
											'glucid' => $_POST['glucid'], 
											'canxi' => $_POST['canxi'],
											'sat' => $_POST['sat'],
											'kem' => $_POST['kem'],
											'xo' => $_POST['xo'],
											'anh_av' => $new_file_path_db,            
											'anh_av_id' => $av_id,  
											'url' =>'/mon-an/?'.str_replace(' ','-',unicode_convert(strtolower($_POST['ten']))),
										), 
										array( 'id' => $id ), 
										'%s',
										'%s'
									);
									if (!empty($update)): ?>
										<div class="updated notice is-dismissible"> 
											<p><strong>Đã sửa món ăn.</strong></p>
										</div>
										<?php elseif (!empty($error)): ?>
											<div class="error notice is-dismissible"> 
												<p><strong><?php echo $error; ?></strong></p>
											</div>
											<?php else: ?>
												<div class="error notice is-dismissible"> 
													<p><strong>Sửa món ăn thất bại.</strong></p>
												</div>
											<?php endif;
										endif;
										$result = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE id = "'.$id.'"' ); ?>
										<h1>Sửa món ăn</h1>
										<?php if (!empty($result)): ?>
											<table class="cm-nhap__thong-tin">
												<thead>
													<tr>
														<td class=""><b>Tên món ăn:</b></td>
														<td><input type="text" name="ten" value="<?php echo $result->ten; ?>"></td>
														<td class="cm-edit__mon-an"><b>Nhóm</b>
															<label for="ma1"><input type="checkbox" value="Bữa sáng" id="ma1" class="cm-edit__mon-an__nhom">Bữa sáng</label>
															<label for="ma2"><input type="checkbox" value="Bữa phụ chiều" id="ma2" class="cm-edit__mon-an__nhom">Bữa phụ chiều</label>
															<label for="ma3"><input type="checkbox" value="Bữa phụ tối" id="ma3" class="cm-edit__mon-an__nhom">Bữa phụ tối</label>
															<input type="text" name="nhom" value="<?php echo $result->nhom; ?>">
														</td>     
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><b>Ảnh:</b>
															<input id="imgInp" type="file" name="profilepicture" size="25" style="display: none;" />
															<input type="button" value="Chọn" onclick="document.getElementById('imgInp').click();" />
															<input style="display: none" name="anh_av" type="text" value="<?php echo $result->anh_av; ?>"/>
															<input style="display: none" name="anh_av_id" type="text" value="<?php echo $result->anh_av_id; ?>"/>
															<img id="blah" src="<?php echo getCurURL(); echo $result->anh_av; ?>" width="50" height="50" />
														</td>
													</tr>
													<tr>
														<td><b>Năng lượng (KCal):</b><input type="text" name="nang_luong" value="<?php echo $result->nang_luong; ?>"></td>
														<td><b>Protein(g):</b><input type="text" name="protein" value="<?php echo $result->protein; ?>"></td>
														<td><b>Glucid(g):</b><input type="text" name="glucid" value="<?php echo $result->glucid; ?>"></td>
														<td><b>Lipid(g):</b><input type="text" name="lipid" value="<?php echo $result->lipid; ?>"></td>
													</tr>
													<tr>
														<td><b>Canxi:</b><input type="text" name="canxi" value="<?php echo $result->canxi; ?>"></td>
														<td><b>Sắt(mg):</b><input type="text" name="sat" value="<?php echo $result->sat; ?>"></td>
														<td><b>Kẽm(mg):</b><input type="text" name="kem" value="<?php echo $result->kem; ?>"></td>
														<td><b>Xơ(g):</b><input type="text" name="xo" value="<?php echo $result->xo; ?>"></td>
													</tr>
												</tbody>
												<tfoot>
													<td><input type="submit" name="save" value="Cập nhật" class="button button-primary"></td>
												</tfoot>            
											</table> 
											<br>    
											<?php else: ?>
												<div class="error notice"><p>ID không hợp lệ.</p></div>
											<?php endif ?>
										</form>
									</div>
									<?php else: ?>
										<div class="wrap"><div class="error notice"><p>ID không hợp lệ hoặc bạn không đủ quyền truy cập.</p></div></div>
									<?php endif; 
								}

/*→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→
↑                                 END MÓN ĂN                               ↓
←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←*/

/*→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→
↑                                 NĂNG LƯỢNG                              ↓
←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←*/

//--------------------------------------------------------------------------
//Quản lý năng lượng
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼

function nang_luong(){
	global $wpdb;
	if (!empty($_GET['edit_nang_luong'])) {
		edit_nang_luong($_GET['edit_nang_luong']);
	} else {        
		$table_name = $wpdb->prefix.'cm_nang_luong';
		if (!empty($_GET['delete_id'])) {
			$xoa = $wpdb->delete( $table_name, array( 'id' => $_GET['delete_id'] ), array( '%d' ) );
		}
		$where = $search = '';
		if (!empty($_REQUEST['xoa_nang_luong'])) {
			$xoa = $wpdb->query('DELETE FROM '.$wpdb->prefix.'cm_nang_luong WHERE id IN('.implode(',', $_REQUEST['xoa_nang_luong']).')');
		} else {
			if (!empty($_REQUEST['search'])) {
				$where .= ' WHERE tuoi LIKE "%'.$_REQUEST['search'].'%"';
				$search .= '&search='.$_REQUEST['search'];
			}
		}
		$count = $wpdb->get_var( 'SELECT COUNT(id) AS dem FROM '.$table_name.$where );
		$ppage = 25;
		if ($count > $ppage) {
			$maxpage = ceil($count/$ppage);
			if(isset($_REQUEST['paged'])){
				$trang = $_REQUEST['paged'];
				if($trang > $maxpage) $trang = $maxpage;
			}else{
				$trang = 1;
			}
			$dau = ($trang-1)*$ppage;
			$results = $wpdb->get_results( 'SELECT * FROM '.$table_name.$where.' ORDER BY id DESC LIMIT '.$dau.', '.$ppage );
		} else {
			$results = $wpdb->get_results( 'SELECT * FROM '.$table_name.$where.' ORDER BY id DESC' );
		}
		?>
		<div class="wrap">
			<form method="GET" class="form-horizontal" role="form" action="">
				<input type="hidden" name="page" value="nang_luong">
				<h1 class="wp-heading-inline">Nhu cầu năng lượng và chỉ số BMI</h1>
				<a class="page-title-action" href="<?php echo get_admin_url().'admin.php?page=them_nang_luong'; ?>">Thêm</a>
				<?php if (!empty($xoa)): ?>
					<div class="updated notice is-dismissible"> 
						<p><strong>Đã xoá thành công.</strong></p>
					</div>
				<?php endif ?>
				<h2>Có tất cả <?php echo $count; ?> bản ghi <?php echo (!empty($_REQUEST['search'])) ? 'khớp với từ khóa "'.$_REQUEST['search'].'"' : ''; ?></h2>
				<h2>Tìm kiếm</h2>
				<table>
					<tr>
						<td>
							<input type="text" name="search" placeholder="Tìm theo độ tuổi" style="width: 200px">
						</td>
						<td>
							<input type="submit" name="xem" value="Tìm kiếm" class="button button-primary">
						</td>

						<td>
							<input type="submit" name="xoa" value="Xoá bản ghi đã chọn" class="button button-primary">
						</td>
					</tr>
				</table>
				<br>
				<?php if ($count > $ppage): ?>
					<div class="tablenav">
						<div class="tablenav-pages"><span class="displaying-num"><?php echo $count; ?> Bản ghi</span>
							<span class="pagination-links">
								<?php if ($trang == 1): ?>
									<span class="tablenav-pages-navspan" aria-hidden="true">«</span>
									<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
									<?php else: ?>
										<a class="first-page" href="<?php echo get_admin_url().'admin.php?page=nang_luong'.$search; ?>">
											<span class="screen-reader-text">Trang Tĩnh Đầu Tiên</span>
											<span aria-hidden="true">«</span>
										</a> 
										<a class="prev-page" href="<?php echo get_admin_url().'admin.php?page=nang_luong&paged='.($trang-1).$search; ?>">
											<span class="screen-reader-text">Trang trước</span>
											<span aria-hidden="true">‹</span>
										</a>
									<?php endif ?>
									<span class="paging-input">
										<input class="current-page" id="current-page-selector" type="text" name="paged" value="<?php echo $trang; ?>" size="4" aria-describedby="table-paging">
										<span class="tablenav-paging-text"> trên 
											<span class="total-pages"><?php echo $maxpage; ?>

										</span>
									</span>
								</span>
								<?php if ($trang == $maxpage): ?>
									<span class="tablenav-pages-navspan" aria-hidden="true">›</span>
									<span class="tablenav-pages-navspan" aria-hidden="true">»</span>
									<?php else: ?>
										<a class="next-page" href="<?php echo get_admin_url().'admin.php?page=nang_luong&paged='.($trang+1).$search; ?>">
											<span class="screen-reader-text">Trang sau</span>
											<span aria-hidden="true">›</span>
										</a>
										<a class="last-page" href="<?php echo get_admin_url().'admin.php?page=nang_luong&paged='.($maxpage).$search; ?>">
											<span class="screen-reader-text">Trang cuối</span>
											<span aria-hidden="true">»</span>
										</a>
									<?php endif ?>
								</span>
							</div>
							<br class="clear">
						</div>
					<?php endif ?>
					<?php if ($count > 0): ?>
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="width: 20px"><input type="checkbox" name="xoa_all_nang_luong" value="ok"></th>
										<th style="width: 24px;">STT</th>
										<th>Tuổi</th> 
										<th>Giới tính</th>  
										<th>Năng lượng (kcal/kg)</th> 
										<th>Protein (g/kg)</th> 
										<th>Glucid (g)</th> 
										<th>Lipid (g)</th>  
										<th>Canxi (mg)</th> 
										<th>Sắt (mg)</th>
										<th>Xẽm (mg)</th>
										<th>Xơ (g)</th>                         
										<th>Quản trị</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = (!empty($dau)) ? ($dau+1) : 1;
									foreach ($results as $result) { ?>
										<tr>
											<td>
												<input class="input_xoa_nang_luong" type="checkbox" name="xoa_nang_luong[]" value="<?php echo $result->id ?>">
											</td>
											<td><?php echo $i;?></td>                                   
											<td>
												<?php echo $result->tuoi; ?>
											</td>
											<td><?php echo $result->gioi_tinh; ?></td>
											<td><?php echo $result->nang_luong; ?></td>
											<td><?php echo $result->protein; ?></td>
											<td><?php echo $result->glucid; ?></td>
											<td><?php echo $result->lipid; ?></td>
											<td><?php echo $result->canxi; ?></td>
											<td><?php echo $result->sat; ?></td>
											<td><?php echo $result->kem; ?></td>
											<td><?php echo $result->xo; ?></td>
											<td>
												<a href="<?php echo get_admin_url().'admin.php?page=nang_luong&edit_nang_luong='.$result->id; ?>" class="button button-primary">Sửa</a>
												<a href="<?php echo get_admin_url().'admin.php?page=nang_luong&delete_id='.$result->id; ?>" class="button button-primary" onclick="return confirm('Bạn có chắc chắn muốn xoá bản ghi này không?');">Xoá</a>
											</td>
										</tr>
										<?php 
										$i++;
									} ?>
								</tbody>
							</table>
						</div>                    
						<?php else: ?>
							<h3>Không tìm thấy dữ liệu nào.</h3>
						<?php endif ?>
					</form>
				</div>
			<?php }
		}

//--------------------------------------------------------------------------
//Thêm năng lượng
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
		function them_nang_luong(){ 
			?>
			<div class="wrap">
				<form method="POST" class="form-horizontal" role="form" action="" enctype="multipart/form-data">
					<h1>Thêm món  ăn</h1>
					<?php if (!empty($_POST['save'])):
						if (!empty($_POST['tuoi'])) {
							global $wpdb;
							$insert = $wpdb->insert( 
								$wpdb->prefix.'cm_nang_luong', 
								array( 
									'tuoi' => $_POST['tuoi'],
									'thang' => $_POST['thang'],
									'gioi_tinh' => $_POST['gioi_tinh'],
									'nang_luong' => $_POST['nang_luong'],
									'protein' => $_POST['protein'],
									'lipid' => $_POST['lipid'],
									'glucid' => $_POST['glucid'], 
									'canxi' => $_POST['canxi'],
									'sat' => $_POST['sat'],
									'kem' => $_POST['kem'],
									'xo' => $_POST['xo'],
									'sd1' => $_POST['sd1'],
									'sd2' => $_POST['sd2'],
									'sd3' => $_POST['sd3'],
									'sd4' => $_POST['sd4'],
									'sd5' => $_POST['sd5'],
									'sd6' => $_POST['sd6'],
									'sd7' => $_POST['sd7'],
								), 
								'%s'
							);
						}  else {
							$error = 'Không đủ dữ liệu';
						}
						if (!empty($insert)): ?>
							<div class="updated notice is-dismissible"> 
								<p><strong>Thêm dữ liệu thành công.</strong></p>
							</div>
							<?php elseif (!empty($error)): ?>
								<div class="error notice is-dismissible"> 
									<p><strong><?php echo $error; ?></strong></p>
								</div>
								<?php else: ?>
									<div class="error notice is-dismissible"> 
										<p><strong>Thêm dữ liệu thất bại. Thiếu trường dữ liệu hoặc độ tuổi đã tồn tại</strong></p>
									</div>
								<?php endif;
							endif; ?>
							<table class="cm-nhap__thong-tin">
								<thead>
									<tr>
										<td  style="width: 25%"><b style="width: 50%; display: inline-block;">Tuổi:</b><input type="text" name="tuoi" style="width: 49%"></td>
										<td  style="width: 25%"><b style="width: 50%; display: inline-block;">Tháng:</b><input type="text" name="thang" style="width: 49%"></td>
										<td  style="width: 25%" class="cm_gioi_tinh"><b style="width: 50%; display: inline-block;">Giới tính:</b>
											<input type="text" name="gioi_tinh" style="display: none">
											<input type="radio" name="cm_gioi_tinh" value="nam">Nam
											<input type="radio" name="cm_gioi_tinh" value="nu">Nữ
										</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="width: 25%"><b style="width: 50%; display: inline-block;">Năng lượng (KCal/kg):</b><input style="width: 49%" type="text" name="nang_luong"></td>
										<td style="width: 25%"><b style="width: 50%; display: inline-block;">Protein (g/kg):</b><input style="width: 49%" type="text" name="protein"></td>
										<td style="width: 25%"><b style="width: 50%; display: inline-block;">Glucid (g):</b><input style="width: 49%" type="text" name="glucid"></td>
										<td style="width: 25%"><b style="width: 50%; display: inline-block;">Lipid (g):</b><input style="width: 49%" type="text" name="lipid"></td>
									</tr>
									<tr>
										<td style="width: 25%"><b style="width: 50%; display: inline-block;">Canxi (mg):</b><input style="width: 49%" type="text" name="canxi"></td>
										<td style="width: 25%"><b style="width: 50%; display: inline-block;">Sắt (mg):</b><input style="width: 49%" type="text" name="sat"></td>
										<td style="width: 25%"><b style="width: 50%; display: inline-block;">Kẽm (mg):</b><input style="width: 49%" type="text" name="kem"></td>
										<td style="width: 25%"><b style="width: 50%; display: inline-block;">Xơ (g):</b><input style="width: 49%" type="text" name="xo"></td>
									</tr>
									<tr>
										<td style="width: 12.5%"><b style="width: 50%; display: inline-block;">-3 SD:</b><input style="width: 49%" type="text" name="sd1"></td>
										<td style="width: 12.5%"><b style="width: 50%; display: inline-block;">-2 SD:</b><input style="width: 49%" type="text" name="sd2"></td>
										<td style="width: 12.5%"><b style="width: 50%; display: inline-block;">-1 SD:</b><input style="width: 49%" type="text" name="sd3"></td>
										<td style="width: 12.5%"><b style="width: 50%; display: inline-block;">Median:</b><input style="width: 49%" type="text" name="sd4"></td>
									</tr>
									<tr>
										<td style="width: 12.5%"><b style="width: 50%; display: inline-block;">1 SD:</b><input style="width: 49%" type="text" name="sd5"></td>
										<td style="width: 12.5%"><b style="width: 50%; display: inline-block;">2 SD:</b><input style="width: 49%" type="text" name="sd6"></td>
										<td style="width: 12.5%"><b style="width: 50%; display: inline-block;">3 SD:</b><input style="width: 49%" type="text" name="sd7"></td>
									</tr>
								</tbody>
								<tfoot>
									<td><input type="submit" name="save" value="Thêm" class="button button-primary"></td>
								</tfoot>            
							</table>        
						</form>
					</div>
					<?php
				}

//--------------------------------------------------------------------------
// Sửa nguyên liệu
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
				function edit_nang_luong($id){
					global $wpdb;
					$table_name = $wpdb->prefix.'cm_nang_luong';
					if (!empty($id) && current_user_can( 'administrator' )): ?>
						<div class="wrap">
							<form action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
								<?php
								if (!empty($_POST['save'])):
									$update = $wpdb->update( 
										$wpdb->prefix.'cm_nang_luong',
										array(
											'tuoi' => $_POST['tuoi'],
											'thang' => $_POST['thang'],
											'gioi_tinh' => $_POST['gioi_tinh'],
											'nang_luong' => $_POST['nang_luong'],
											'protein' => $_POST['protein'],
											'lipid' => $_POST['lipid'],
											'glucid' => $_POST['glucid'], 
											'canxi' => $_POST['canxi'],
											'sat' => $_POST['sat'],
											'kem' => $_POST['kem'],
											'xo' => $_POST['xo'],
											'sd1' => $_POST['sd1'],
											'sd2' => $_POST['sd2'],
											'sd3' => $_POST['sd3'],
											'sd4' => $_POST['sd4'],
											'sd5' => $_POST['sd5'],
											'sd6' => $_POST['sd6'],
											'sd7' => $_POST['sd7'],
										), 
										array( 'id' => $id ), 
										'%s',
										'%s'
									);
									if (!empty($update)): ?>
										<div class="updated notice is-dismissible"> 
											<p><strong>Đã sửa thành công.</strong></p>
										</div>
										<?php elseif (!empty($error)): ?>
											<div class="error notice is-dismissible"> 
												<p><strong><?php echo $error; ?></strong></p>
											</div>
											<?php else: ?>
												<div class="error notice is-dismissible"> 
													<p><strong>Sửa thất bại.</strong></p>
												</div>
											<?php endif;
										endif;
										$result = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_nang_luong WHERE id = "'.$id.'"' ); ?>
										<h1>Sửa nhu cầu năng lượng</h1>
										<?php if (!empty($result)): ?>
											<table class="cm-nhap__thong-tin">
												<thead>
													<tr>
														<td  style="width: 25%"><b style="width: 50%; display: inline-block;">Tuổi:</b><input type="text" name="tuoi" style="width: 49%" value="<?php echo $result->tuoi; ?>"></td>
														<td  style="width: 25%"><b style="width: 50%; display: inline-block;">Tháng:</b><input type="text" name="thang" style="width: 49%" value="<?php echo $result->thang; ?>"></td>
														<td  style="width: 25%" class="cm_gioi_tinh"><b style="width: 50%; display: inline-block;">Giới tính:</b>
															<input type="text" name="gioi_tinh" style="display: none" value="<?php echo $result->gioi_tinh; ?>">
															<input type="radio" name="cm_gioi_tinh" value="nam">Nam
															<input type="radio" name="cm_gioi_tinh" value="nu">Nữ
														</td>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td style="width: 25%"><b style="width: 50%; display: inline-block;">Năng lượng (KCal/kg):</b><input style="width: 49%" type="text" name="nang_luong" value="<?php echo $result->nang_luong; ?>"></td>
														<td style="width: 25%"><b style="width: 50%; display: inline-block;">Protein (g):</b><input style="width: 49%" type="text" name="protein" value="<?php echo $result->protein; ?>"></td>
														<td style="width: 25%"><b style="width: 50%; display: inline-block;">Glucid (g):</b><input style="width: 49%" type="text" name="glucid" value="<?php echo $result->glucid; ?>"></td>
														<td style="width: 25%"><b style="width: 50%; display: inline-block;">Lipid (g):</b><input style="width: 49%" type="text" name="lipid" value="<?php echo $result->lipid; ?>"></td>
													</tr>
													<tr>
														<td style="width: 25%"><b style="width: 50%; display: inline-block;">Canxi (mg):</b><input style="width: 49%" type="text" name="canxi" value="<?php echo $result->canxi; ?>"></td>
														<td style="width: 25%"><b style="width: 50%; display: inline-block;">Sắt (mg):</b><input style="width: 49%" type="text" name="sat" value="<?php echo $result->sat; ?>"></td>
														<td style="width: 25%"><b style="width: 50%; display: inline-block;">Kẽm (mg):</b><input style="width: 49%" type="text" name="kem" value="<?php echo $result->kem; ?>"></td>
														<td style="width: 25%"><b style="width: 50%; display: inline-block;">Xơ (g):</b><input style="width: 49%" type="text" name="xo" value="<?php echo $result->xo; ?>"></td>
													</tr>
													<tr>
														<td style="width: 12.5%"><b style="width: 50%; display: inline-block;">-3 SD:</b><input style="width: 49%" type="text" name="sd1" value="<?php echo $result->sd1; ?>"></td>
														<td style="width: 12.5%"><b style="width: 50%; display: inline-block;">-2 SD:</b><input style="width: 49%" type="text" name="sd2" value="<?php echo $result->sd2; ?>"></td>
														<td style="width: 12.5%"><b style="width: 50%; display: inline-block;">-1 SD:</b><input style="width: 49%" type="text" name="sd3" value="<?php echo $result->sd3; ?>"></td>
														<td style="width: 12.5%"><b style="width: 50%; display: inline-block;">Median:</b><input style="width: 49%" type="text" name="sd4" value="<?php echo $result->sd4; ?>"></td>
													</tr>
													<tr>
														<td style="width: 12.5%"><b style="width: 50%; display: inline-block;">1 SD:</b><input style="width: 49%" type="text" name="sd5" value="<?php echo $result->sd5; ?>"></td>
														<td style="width: 12.5%"><b style="width: 50%; display: inline-block;">2 SD:</b><input style="width: 49%" type="text" name="sd6" value="<?php echo $result->sd6; ?>"></td>
														<td style="width: 12.5%"><b style="width: 50%; display: inline-block;">3 SD:</b><input style="width: 49%" type="text" name="sd7" value="<?php echo $result->sd7; ?>"></td>
													</tr>
												</tbody>
												<tfoot>
													<td><input type="submit" name="save" value="Cập nhật" class="button button-primary"></td>
												</tfoot>            
											</table> 
											<br>    
											<?php else: ?>
												<div class="error notice"><p>ID không hợp lệ.</p></div>
											<?php endif ?>
										</form>
									</div>
									<?php else: ?>
										<div class="wrap"><div class="error notice"><p>ID không hợp lệ hoặc bạn không đủ quyền truy cập.</p></div></div>
									<?php endif; 
								}


/*→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→
↑                                 END NĂNG LƯỢNG                           ↓
←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←*/

/*→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→
↑                                    THỰC ĐƠN                              ↓
←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←*/

//--------------------------------------------------------------------------
//Quản lý thực đơn
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
function thuc_don(){
	global $wpdb;
	if (!empty($_GET['edit_thuc_don'])) {
		edit_thuc_don($_GET['edit_thuc_don']);
	} else {        
		$table_name = $wpdb->prefix.'cm_thuc_don';
		if (!empty($_GET['delete_id'])) {
			$xoa = $wpdb->delete( $table_name, array( 'id' => $_GET['delete_id'] ), array( '%d' ) );
		}
		$where = $search = '';
		if (!empty($_REQUEST['xoa_thuc_don'])) {
			$xoa = $wpdb->query('DELETE FROM '.$wpdb->prefix.'cm_thuc_don WHERE id IN('.implode(',', $_REQUEST['xoa_thuc_don']).')');
		} else {
			if (!empty($_REQUEST['search'])) {
				$where .= ' WHERE ngay LIKE "%'.$_REQUEST['search'].'%"';
				$search .= '&search='.$_REQUEST['search'];
			}
		}
		$count = $wpdb->get_var( 'SELECT COUNT(id) AS dem FROM '.$table_name.$where );
		$ppage = 25;
		if ($count > $ppage) {
			$maxpage = ceil($count/$ppage);
			if(isset($_REQUEST['paged'])){
				$trang = $_REQUEST['paged'];
				if($trang > $maxpage) $trang = $maxpage;
			}else{
				$trang = 1;
			}
			$dau = ($trang-1)*$ppage;
			$results = $wpdb->get_results( 'SELECT * FROM '.$table_name.$where.' ORDER BY id DESC LIMIT '.$dau.', '.$ppage );
		} else {
			$results = $wpdb->get_results( 'SELECT * FROM '.$table_name.$where.' ORDER BY id DESC' );
		}
		?>
		<div class="wrap">
			<form method="GET" class="form-horizontal" role="form" action="">
				<input type="hidden" name="page" value="nang_luong">
				<h1 class="wp-heading-inline">Thực đơn</h1>
				<!-- <a class="page-title-action" href="<?php //echo get_admin_url().'admin.php?page=them_thuc_don'; ?>">Thêm</a> -->
				<?php if (!empty($xoa)): ?>
					<div class="updated notice is-dismissible"> 
						<p><strong>Đã xoá thành công.</strong></p>
					</div>
				<?php endif ?>
				<h2>Có tất cả <?php echo $count; ?> bản ghi <?php echo (!empty($_REQUEST['search'])) ? 'khớp với từ khóa "'.$_REQUEST['search'].'"' : ''; ?></h2>
				<h2>Tìm kiếm</h2>
				<table>
					<tr>
						<td>
							<input type="text" name="search" placeholder="Tìm theo ngày" style="width: 200px">
						</td>
						<td>
							<input type="submit" name="xem" value="Tìm kiếm" class="button button-primary">
						</td>

						<td>
							<input type="submit" name="xoa" value="Xoá bản ghi đã chọn" class="button button-primary">
						</td>
					</tr>
				</table>
				<br>
				<?php if ($count > $ppage): ?>
					<div class="tablenav">
						<div class="tablenav-pages"><span class="displaying-num"><?php echo $count; ?> Bản ghi</span>
							<span class="pagination-links">
								<?php if ($trang == 1): ?>
									<span class="tablenav-pages-navspan" aria-hidden="true">«</span>
									<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
									<?php else: ?>
										<a class="first-page" href="<?php echo get_admin_url().'admin.php?page=thuc_don'.$search; ?>">
											<span class="screen-reader-text">Trang Tĩnh Đầu Tiên</span>
											<span aria-hidden="true">«</span>
										</a> 
										<a class="prev-page" href="<?php echo get_admin_url().'admin.php?page=thuc_don&paged='.($trang-1).$search; ?>">
											<span class="screen-reader-text">Trang trước</span>
											<span aria-hidden="true">‹</span>
										</a>
									<?php endif ?>
									<span class="paging-input">
										<input class="current-page" id="current-page-selector" type="text" name="paged" value="<?php echo $trang; ?>" size="4" aria-describedby="table-paging">
										<span class="tablenav-paging-text"> trên 
											<span class="total-pages"><?php echo $maxpage; ?>
											
										</span>
									</span>
								</span>
								<?php if ($trang == $maxpage): ?>
									<span class="tablenav-pages-navspan" aria-hidden="true">›</span>
									<span class="tablenav-pages-navspan" aria-hidden="true">»</span>
									<?php else: ?>
										<a class="next-page" href="<?php echo get_admin_url().'admin.php?page=thuc_don&paged='.($trang+1).$search; ?>">
											<span class="screen-reader-text">Trang sau</span>
											<span aria-hidden="true">›</span>
										</a>
										<a class="last-page" href="<?php echo get_admin_url().'admin.php?page=thuc_don&paged='.($maxpage).$search; ?>">
											<span class="screen-reader-text">Trang cuối</span>
											<span aria-hidden="true">»</span>
										</a>
									<?php endif ?>
								</span>
							</div>
							<br class="clear">
						</div>
					<?php endif ?>
					<?php if ($count > 0): ?>
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="width: 20px"><input type="checkbox" name="xoa_all_thuc_don" value="ok"></th>
										<th style="width: 24px;">STT</th>
										<th>Ngày</th> 
										<th>Món ăn</th>
										<th>Năng lượng (kcal)</th> 
										<th>Protein (g)</th> 
										<th>Glucid (g)</th> 
										<th>Lipid (g)</th>                            
										<th>Quản trị</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = (!empty($dau)) ? ($dau+1) : 1;
									foreach ($results as $result) { ?>
										<tr>
											<td>
												<input class="input_xoa_thuc_don" type="checkbox" name="xoa_thuc_don[]" value="<?php echo $result->id ?>">
											</td>
											<td><?php echo $i;?></td>                                   
											<td>
												<?php echo $result->ngay; ?>
											</td>
											<td><?php echo $result->mon_an; ?></td>
											<td><?php echo $result->nang_luong; ?></td>
											<td><?php echo $result->protein; ?></td>
											<td><?php echo $result->glucid; ?></td>
											<td><?php echo $result->lipid; ?></td>
											<td>
												<!-- <a href="<?php //echo get_admin_url().'admin.php?page=thuc_don&edit_thuc_don='.$result->id; ?>" class="button button-primary">Sửa</a> -->
												<a href="<?php echo get_admin_url().'admin.php?page=thuc_don&delete_id='.$result->id; ?>" class="button button-primary" onclick="return confirm('Bạn có chắc chắn muốn xoá bản ghi này không?');">Xoá</a>
											</td>
										</tr>
										<?php 
										$i++;
									} ?>
								</tbody>
							</table>
						</div>                    
						<?php else: ?>
							<h3>Không tìm thấy dữ liệu nào.</h3>
						<?php endif ?>
					</form>
				</div>
			<?php }
		}

//--------------------------------------------------------------------------
//Thêm Thực Đơn
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
		function them_thuc_don(){ 
			global $wpdb;
			$list_mon_an = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_mon_an WHERE ten != "" AND ten IS NOT NULL GROUP BY ten ORDER BY ten ASC' );
			?>
			<div class="wrap">
				<form method="POST" class="form-horizontal" role="form" action="" enctype="multipart/form-data">
					<h1>Thêm thực đơn</h1>
					<?php if (!empty($_POST['save'])):
						if (!empty($_POST['ngay'])) {
							$insert = $wpdb->insert( 
								$wpdb->prefix.'cm_thuc_don', 
								array( 
									'ngay' => $_POST['ngay'],
									'mon_an' => $_POST['add__mon_an'],
									'nang_luong' => $_POST['nang_luong'],
									'protein' => $_POST['protein'],
									'lipid' => $_POST['lipid'],
									'glucid' => $_POST['glucid'], 
								), 
								'%s'
							);
						}  else {
							$error = 'Không đủ dữ liệu';
						}
						if (!empty($insert)): ?>
							<div class="updated notice is-dismissible"> 
								<p><strong>Thêm dữ liệu thành công.</strong></p>
							</div>
							<?php elseif (!empty($error)): ?>
								<div class="error notice is-dismissible"> 
									<p><strong><?php echo $error; ?></strong></p>
								</div>
								<?php else: ?>
									<div class="error notice is-dismissible"> 
										<p><strong>Thêm dữ liệu thất bại. Thiếu trường dữ liệu hoặc ngày đã tồn tại</strong></p>
									</div>
								<?php endif;
							endif; ?>
							<table class="cm-nhap__thong-tin">
								<thead>
									<tr>
										<td><b>Ngày:</b>
											<input type="date" id="dt" onchange="mydate();" style="width: 100%">
											<input type="text" id="ndt" name="ngay" style="width: 100%; display: none">
											<input type="text" id="day" name="thu" value="0" style="width: 100%; display: none">
										</td>
									</tr>                  
								</thead>
								<tbody>
									<tr><td><b>Món ăn</b></td></tr>
									<tr>
										
										<td class="cm-add__mon-an">  
											<input type="text" name="add__mon_an" style="width: 100%; display: none" >
											<div>
												<?php if (!empty($list_mon_an)): ?>
													<?php foreach ($list_mon_an as $key => $value): ?>
														<label><input type="checkbox"  class="cm-add__mon-an__thuc-don" value="<?php echo $value->ten ?>"><?php echo $value->ten ?></label>
													<?php endforeach ?>
												<?php endif ?>
											</div>
										</td>
									</tr>
									<tr>
										<td><b>Năng lượng (KCal):</b><input type="text" name="nang_luong"></td>
										<td><b>Protein:</b><input type="text" name="protein"></td>
										<td><b>Glucid:</b><input type="text" name="glucid"></td>
										<td><b>Lipid:</b><input type="text" name="lipid"></td>
									</tr>
									<tr>
										<td><b>Canxi:</b><input type="text" name="canxi"></td>
										<td><b>Sắt:</b><input type="text" name="sat"></td>
										<td><b>Kẽm:</b><input type="text" name="kem"></td>
										<td><b>Xơ:</b><input type="text" name="xo"></td>
									</tr>
								</tbody>
								<tfoot>
									<td><input type="submit" name="save" value="Thêm" class="button button-primary"></td>
								</tfoot>            
							</table>        
						</form>
					</div>
					<?php
				}
				function edit_thuc_don($id){
					global $wpdb;
					$table_name = $wpdb->prefix.'cm_thuc_don';
					if (!empty($id) && current_user_can( 'administrator' )): ?>
						<div class="wrap">
							<form action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
								<?php
								if (!empty($_POST['save'])):
									$update = $wpdb->update( 
										$wpdb->prefix.'cm_thuc_don',
										array(
											'ten' => $_POST['ten'],
											'nang_luong' => $_POST['nang_luong'],
											'protein' => $_POST['protein'],
											'lipid' => $_POST['lipid'],
											'glucid' => $_POST['glucid'],   
										), 
										array( 'id' => $id ), 
										'%s',
										'%s'
									);
									if (!empty($update)): ?>
										<div class="updated notice is-dismissible"> 
											<p><strong>Đã sửa thực đơn.</strong></p>
										</div>
										<?php elseif (!empty($error)): ?>
											<div class="error notice is-dismissible"> 
												<p><strong><?php echo $error; ?></strong></p>
											</div>
											<?php else: ?>
												<div class="error notice is-dismissible"> 
													<p><strong>Sửa thực đơn thất bại.</strong></p>
												</div>
											<?php endif;
										endif;
										$result = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cm_thuc_don WHERE id = "'.$id.'"' ); ?>
										<h1>Sửa Thực Đơn</h1>
										<?php if (!empty($result)): ?>
											<table class="cm-nhap__thong-tin">
												<thead>
													<tr>
														<td class=""><b>Tên nguyên liệu:</b></td>
														<td><input type="text" name="ten" value="<?php echo $result->ten; ?>"></td>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><b>Năng lượng (KCal):</b><input type="text" name="nang_luong" value="<?php echo $result->nang_luong; ?>"></td>
														<td><b>Protein:</b><input type="text" name="protein" value="<?php echo $result->protein; ?>"></td>
														<td><b>Glucid:</b><input type="text" name="glucid" value="<?php echo $result->glucid; ?>"></td>
														<td><b>Lipid:</b><input type="text" name="lipid" value="<?php echo $result->lipid; ?>"></td>
													</tr>
												</tbody>
												<tfoot>
													<td><input type="submit" name="save" value="Cập nhật" class="button button-primary"></td>
												</tfoot>            
											</table> 
											<br>    
											<?php else: ?>
												<div class="error notice"><p>ID không hợp lệ.</p></div>
											<?php endif ?>
										</form>
									</div>
									<?php else: ?>
										<div class="wrap"><div class="error notice"><p>ID không hợp lệ hoặc bạn không đủ quyền truy cập.</p></div></div>
									<?php endif; 
				}


				