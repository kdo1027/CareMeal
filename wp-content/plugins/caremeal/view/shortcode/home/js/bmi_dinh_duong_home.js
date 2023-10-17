(function($){
	let domain="https://"+location.hostname;	
	function roundNumber(num, scale) {
		if(!("" + num).includes("e")) {
			return +(Math.round(num + "e+" + scale)  + "e-" + scale);
		} else {
			var arr = ("" + num).split("e");
			var sig = ""
			if(+arr[1] + scale > 0) {
				sig = "+";
			}
			return +(Math.round(+arr[0] + "e" + sig + (+arr[1] + scale)) + "e-" + scale);
		}
	}
	$('.cm-home-kq-btn').click(function(){
		if($('input[name="ngay_sinh"]').val().trim() == "" || $('input[name="can-nang"]').val().trim() == "" || $('input[name="chieu-cao"]').val().trim() == "" || $('.gioi__tinh-ct input[type="radio"]:checked').val() == "")
		{			
			alert("Bạn chưa nhập đủ dữ liệu");
		}
		else
		{
			var bmi=can_nang=chieu_cao="0";
			can_nang=Number($('input[name="can-nang"]').val());
			chieu_cao=Number($('input[name="chieu-cao"]').val());
			var a=$('input[name="ngay_sinh"]').val().trim();
			var a1=a.slice(0,4); 
			var a2=Number(a.slice(5,7))-1;
			var a3=Number(a.slice(8,10));
			var d = new Date();
			var d2=d.getFullYear();
			var t = new Date(a1,a2,a3);
			var t2=t.getFullYear();	
			var tuoi=d2-t2;
			if(tuoi<6 || tuoi>14){
				alert("Phần mềm chỉ hỗ trợ độ tuổi từ 6 - 14 tuổi. Vui lòng nhập lại thông tin !!!")
			}else{
				$('#bmi').show();
				$('#bmi').html('');
				$.ajax({
					type:"POST",
					url:domain+'/wp-content/plugins/caremeal/view/shortcode/home/ajax/nhu-cau-nang-luong.php', 
					data:{
						'tuoi':tuoi,
						'gioi_tinh':$('.gioi__tinh-ct input[type="radio"]:checked').val()
					},
					success:function(response){
						if (response != 0) {
							response = JSON.parse(response); 
							for(j=0;j < response.length;j++){
								if(chieu_cao<Number(response[j].chieu_cao_tb)-0.3){
									if(can_nang<Number(response[j].can_nang_tb)-30){
										$('#bmi').append('<p>Chiều cao và cân nặng nhỏ hơn trung bình theo độ tuổi rất nhiều, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
									}else if(can_nang>Number(response[j].can_nang_tb)+30){
										$('#bmi').append('<p>Chiều cao nhỏ hơn và cân nặng lớn hơn trung bình theo độ tuổi rất nhiều, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
									}else{
										$('#bmi').append('<p>Chiều cao nhỏ hơn trung bình theo độ tuổi rất nhiều, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
									}							
								} else if(chieu_cao>Number(response[j].chieu_cao_tb)+0.3){
									if(can_nang<Number(response[j].can_nang_tb-30)){
										$('#bmi').append('<p>Chiều cao lớn hơn và cân nặng nhỏ hơn trung bình theo độ tuổi rất nhiều, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
									}else if(can_nang>Number(response[j].can_nang_tb)+30){
										$('#bmi').append('<p>Chiều cao và cân nặng lớn hơn trung bình theo độ tuổi rất nhiều, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
									}else{
										$('#bmi').append('<p>Chiều cao lớn hơn trung bình theo độ tuổi rất nhiều, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
									}			
								}else if(can_nang<Number(response[j].can_nang_tb)-30){
									$('#bmi').append('<p>Cân nặng nhỏ hơn trung bình theo độ tuổi rất nhiều, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
								}else if(can_nang>Number(response[j].can_nang_tb)+30){
									$('#bmi').append('<p>Cân nặng lớn hơn trung bình theo độ tuổi rất nhiều, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
								}else{
									bmi=roundNumber(can_nang/(chieu_cao*chieu_cao),2);
									tinh_bmi(bmi);
								}		
							}
						}
					},
					error: function(){
						alert("Không tìm thấy dữ liệu");
					}
				});	
			}
			
		}
	})
	//Tính BMI
	function tinh_bmi(i){
		var a=$('input[name="ngay_sinh"]').val().trim();
		var a1=a.slice(0,4); 
		var a2=Number(a.slice(5,7))-1;
		var a3=Number(a.slice(8,10));
		var d = new Date();
		var d2=d.getFullYear();
		var d3=d.getMonth();
		var t = new Date(a1,a2,a3);
		var t2=t.getFullYear();		
		var t3=t.getMonth();
		var thang=0;
		var tuoi=d2-t2;
		var tuoi_1=0;
		var thang_1=0;
		var can_nang=Number($('input[name="can-nang"]').val().trim());
		if(d3>=t3){
			thang=(d2-t2)*12+(d3-t3);
			tuoi_1=d2-t2;
			thang_1=d3-t3;
		}
		else{
			thang=(d2-t2-1)*12+(11-t3)+(d3-0);
			tuoi_1=d2-t2-1;
			thang_1=(11-t3)+(d3-0);
		}
		var bmi_kq="";
		$.ajax({
			type:"POST",
			url:domain+'/wp-content/plugins/caremeal/view/shortcode/home/ajax/nhu-cau-nang-luong.php', 
			data:{
				'tuoi':tuoi,
				'gioi_tinh':$('.gioi__tinh-ct input[type="radio"]:checked').val()
			},
			success:function(response){
				if (response != 0) {
					response = JSON.parse(response); 
					for(j=0;j < response.length;j++){
						if(i<response[j].sd1){
							$('#bmi').append('<h5>Trẻ '+tuoi_1+' tuổi '+thang_1+' tháng (BMI = '+i+')</h5><p>Trẻ suy dinh dưỡng thể nhẹ cân, mức độ nặng, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
						} else if(i<response[j].sd2){
							$('#bmi').append('<h5>Trẻ '+tuoi_1+' tuổi '+thang_1+' tháng (BMI = '+i+')</h5><p>Trẻ suy dinh dưỡng thể nhẹ cân, mức độ vừa, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
						} else if(i<response[j].sd5){
							$('#bmi').append('<div class="vb_nhu_cau_dd"><h5>Trẻ '+tuoi_1+' tuổi '+thang_1+' tháng (BMI = '+i+')</h5></div>');
							$('#bmi').append('<div class="cm-nhucau-hang-ngay"></div>');							
							$('.cm-nhucau-hang-ngay').append('<h5>Nhu cầu dinh dưỡng hàng ngày</h5>');
							$('.cm-nhucau-hang-ngay').append('<p><span><b>Năng lượng: </b><i>'+roundNumber(response[j].nang_luong*can_nang,2)+'</i>kcal</span><span><b>Protein: </b><i>'+roundNumber(response[j].protein*can_nang,2)+'</i>g</span><span><b>Glucid: </b><i>'+response[j].glucid+'</i>g</span><span><b>Lipid: </b><i>'+response[j].lipid+'</i>g</span><span><b>Sắt: </b><i>'+response[j].sat+'</i>mg</span><span><b>Canxi: </b><i>'+response[j].canxi+'</i>mg</span><span class="cm_3cham">...</span><span class="cm_xem"> >> </span><span class="cm_112"><b>Kẽm: </b><i>'+response[j].kem+'</i>mg</span><span class="cm_112"><b>Chất xơ: </b><i>'+response[j].xo+'</i>g</span><span class="cm_thu_lai cm_112"> << </span><p>');
							$('.cm-nhucau-hang-ngay').append('<a href="#">Kiểm tra dinh dưỡng</a>');
							$('.cm-nhucau-hang-ngay a').click(function(e){
								e.preventDefault();
								$('#goi_y_dinh_duong').html('').show();
								$('#goi_y_dinh_duong').append('<div class="cm_dinh_duong_total_143"></div><div class="cm_bua_sang_143"></div><div class="cm_bua_trua_143"></div><div class="cm_bua_toi_143"></div><div class="cm_bua_phu_143"></div>');
								$('.cm_bua_sang_143').append('<div class="cm_bua_an_143_1"><h5>Bữa sáng</h5><select><option value="chon">Chọn món ăn</option></select></div><div class="cm_bua_sang_143_ct"></div>');
								$.ajax({
									type:"POST",
									url:domain+'/wp-content/plugins/caremeal/view/shortcode/home/ajax/mon-an.php', 
									data:{
										'mon-an':"sang",
									},
									success:function(response){ 
										if (response != 0) {
											response = JSON.parse(response); 
											for(j=0;j < response.length;j++){
												$('.cm_bua_sang_143 select').append('<option value="'+response[j].ten+'">'+response[j].ten+'</option>');
											}
											$('.cm_bua_sang_143_ct').append('<div class="cm_mon_an_ct_143_head"><span>Ảnh</span><span>Tên</span><span>Năng lượng(kcal)</span><span>Protein(g)</span><span>Glucid(g)</span><span>Lipid(g)</span><span>Canxi(mg)</span><span>Sắt(mg)</span><span>Kẽm(mg)</span><span>Xơ(g)</span></div>');
											$('.cm_mon_an_ct_143_head').hide();
											$('.cm_bua_sang_143 select').change(function(){ 
												let ten_mon_sang = $('.cm_bua_sang_143 select option:selected').val().trim();
												if($('.cm_close_mon_sang').size()<2){
													if($('.cm_close_mon_sang').size()==0){
														$.ajax({
															type:"POST",
															url:domain+'/wp-content/plugins/caremeal/view/shortcode/home/ajax/tra_cuu_mon_an.php', 
															data:{
																'ten':ten_mon_sang,
															},
															success:function(response){
																if (response != 0) {
																	response = JSON.parse(response); 
																	$('.cm_mon_an_ct_143_head').show();
																	$('.cm_bua_sang_143_ct').append('<div class="cm_mon_an_ct_143_body"><span><img src="'+response[0].anh_av+'"></span><span class="cm_sang_ten_mon_an">'+response[0].ten+'</span><span>'+response[0].nang_luong+'</span><span>'+response[0].protein+'</span><span>'+response[0].glucid+'</span><span>'+response[0].lipid+'</span><span>'+response[0].canxi+'</span><span>'+response[0].sat+'</span><span>'+response[0].kem+'</span><span>'+response[0].xo+'</span><span class="cm_close_mon_sang">x</span></div>');
																	$('.cm_close_mon_sang').each(function(){
																		$(this).click(function(){
																			$(this).parent().remove();
																			if($('.cm_close_mon_sang').size()==0){
																				$('.cm_mon_an_ct_143_head').hide();
																			}
																		})
																	})
																}
															}
														});
													}else {
														$('.cm_sang_ten_mon_an').each(function(){
															if($(this).text().trim()==ten_mon_sang){
																alert("Món ăn này đã được chọn");
															}
															else{
																$.ajax({
																	type:"POST",
																	url:domain+'/wp-content/plugins/caremeal/view/shortcode/home/ajax/tra_cuu_mon_an.php', 
																	data:{
																		'ten':ten_mon_sang,
																	},
																	success:function(response){
																		if (response != 0) {
																			response = JSON.parse(response); 
																			$('.cm_mon_an_ct_143_head').show();
																			$('.cm_bua_sang_143_ct').append('<div class="cm_mon_an_ct_143_body"><span><img src="'+response[0].anh_av+'"></span><span class="cm_sang_ten_mon_an">'+response[0].ten+'</span><span>'+response[0].nang_luong+'</span><span>'+response[0].protein+'</span><span>'+response[0].glucid+'</span><span>'+response[0].lipid+'</span><span>'+response[0].canxi+'</span><span>'+response[0].sat+'</span><span>'+response[0].kem+'</span><span>'+response[0].xo+'</span><span class="cm_close_mon_sang">x</span></div>');
																			$('.cm_close_mon_sang').each(function(){
																				$(this).click(function(){
																					$(this).parent().remove();
																					if($('.cm_close_mon_sang').size()==0){
																						$('.cm_mon_an_ct_143_head').hide();
																					}
																				})
																			})
																		}
																	}
																});
															}
														})
													}
												}
												else{
													alert("Bữa sáng chọn tối đa 2 món");
												}
											})
										}
									}
								});	
$('.cm_bua_trua_143').append('<div class="cm_bua_an_trua_143_1"><h5>Bữa Trưa</h5><select><option value="chon">Chọn món ăn</option></select></div><div class="cm_bua_trua_143_ct"></div>');
$.ajax({
	type:"POST",
	url:domain+'/wp-content/plugins/caremeal/view/shortcode/home/ajax/mon-an.php', 
	data:{
		'mon-an':"trua",
	},
	success:function(response){ 
		if (response != 0) {
			response = JSON.parse(response); 
			for(j=0;j < response.length;j++){
				$('.cm_bua_trua_143 select').append('<option value="'+response[j].ten+'">'+response[j].ten+'</option>');
			}
			$('.cm_bua_trua_143_ct').append('<div class="cm_mon_an_trua_ct_143_head"><span>Ảnh</span><span>Tên</span><span>Năng lượng(kcal)</span><span>Protein(g)</span><span>Glucid(g)</span><span>Lipid(g)</span><span>Canxi(mg)</span><span>Sắt(mg)</span><span>Kẽm(mg)</span><span>Xơ(g)</span></div>');
			$('.cm_mon_an_trua_ct_143_head').hide();
			$('.cm_bua_trua_143 select').change(function(){ 
				let ten_mon_trua = $('.cm_bua_trua_143 select option:selected').val().trim();
				if($('.cm_close_mon_trua').size()<6){
					if($('.cm_close_mon_trua').size()==0){
						$.ajax({
							type:"POST",
							url:domain+'/wp-content/plugins/caremeal/view/shortcode/home/ajax/tra_cuu_mon_an.php', 
							data:{
								'ten':ten_mon_trua,
							},
							success:function(response){
								if (response != 0) {
									response = JSON.parse(response); 
									$('.cm_mon_an_trua_ct_143_head').show();
									$('.cm_bua_trua_143_ct').append('<div class="cm_mon_an_trua_ct_143_body"><span><img src="'+response[0].anh_av+'"></span><span class="cm_trua_ten_mon_an">'+response[0].ten+'</span><span>'+response[0].nang_luong+'</span><span>'+response[0].protein+'</span><span>'+response[0].glucid+'</span><span>'+response[0].lipid+'</span><span>'+response[0].canxi+'</span><span>'+response[0].sat+'</span><span>'+response[0].kem+'</span><span>'+response[0].xo+'</span><span class="cm_close_mon_trua">x</span></div>');
									$('.cm_close_mon_trua').each(function(){
										$(this).click(function(){
											$(this).parent().remove();
											if($('.cm_close_mon_trua').size()==0){
												$('.cm_mon_an-trua_ct_143_head').hide();
											}
										})
									})
								}
							}
						});
					}else {
						$('.cm_trua_ten_mon_an').each(function(){
							if($(this).text().trim()==ten_mon_trua){
								alert("Món ăn này đã được chọn");
							}
							else{
								$.ajax({
									type:"POST",
									url:domain+'/wp-content/plugins/caremeal/view/shortcode/home/ajax/tra_cuu_mon_an.php', 
									data:{
										'ten':ten_mon_trua,
									},
									success:function(response){
										if (response != 0) {
											response = JSON.parse(response); 
											$('.cm_mon_an_trua_ct_143_head').show();
											$('.cm_bua_trua_143_ct').append('<div class="cm_mon_an_trua_ct_143_body"><span><img src="'+response[0].anh_av+'"></span><span class="cm_trua_ten_mon_an">'+response[0].ten+'</span><span>'+response[0].nang_luong+'</span><span>'+response[0].protein+'</span><span>'+response[0].glucid+'</span><span>'+response[0].lipid+'</span><span>'+response[0].canxi+'</span><span>'+response[0].sat+'</span><span>'+response[0].kem+'</span><span>'+response[0].xo+'</span><span class="cm_close_mon_trua">x</span></div>');
											$('.cm_close_mon_trua').each(function(){
												$(this).click(function(){
													$(this).parent().remove();
													if($('.cm_close_mon_trua').size()==0){
														$('.cm_mon_an_trua_ct_143_head').hide();
													}
												})
											})
										}
									}
								});
							}
						})
					}
				}
				else{
					alert("Bữa trưa chọn tối đa 6 món");
				}
			})
		}
	}
});	

$('.cm_bua_toi_143').append('<h5>Bữa tối</h5><select><option value="chon">Chọn món ăn</option></select><div class="cm_bua_toi_143_ct"></div>');
$.ajax({
	type:"POST",
	url:domain+'/wp-content/plugins/caremeal/view/shortcode/home/ajax/mon-an.php', 
	data:{
		'mon-an':"toi",
	},
	success:function(response){ 
		if (response != 0) {
			response = JSON.parse(response); 

			for(j=0;j < response.length;j++){
				$('.cm_bua_toi_143 select').append('<option value="'+response[j].ten+'">'+response[j].ten+'</option>');
			}
		}
	}
});	
$('.cm_bua_phu_143').append('<h5>Bữa phụ</h5><select><option value="chon">Chọn món ăn</option></select><div class="cm_bua_phu_143_ct"></div>');
$.ajax({
	type:"POST",
	url:domain+'/wp-content/plugins/caremeal/view/shortcode/home/ajax/mon-an.php', 
	data:{
		'mon-an':"phu",
	},
	success:function(response){ 
		if (response != 0) {
			response = JSON.parse(response); 

			for(j=0;j < response.length;j++){
				$('.cm_bua_phu_143 select').append('<option value="'+response[j].ten+'">'+response[j].ten+'</option>');
			}
		}
	}
});	

});
$('.cm_xem').click(function(){ 
	$(this).hide();
	$('.cm_3cham').hide();
	$('.cm_112').css("display","inline-block");
})
$('.cm_thu_lai').click(function(){
	$('.cm_3cham').css("display","inline-block");
	$('.cm_xem').css("display","inline-block");
	$('.cm_112').hide();
})
}  else if(i<response[j].sd6){
	$('#bmi').append('<h5>Trẻ '+tuoi_1+' tuổi '+thang_1+' tháng (BMI = '+i+')</h5><p>Trẻ thừa cân, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');

} else{
	$('#bmi').append('<h5>Trẻ '+tuoi_1+' tuổi '+thang_1+' tháng (BMI = '+i+')</h5><p>Trẻ béo phì, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');

}return bmi_kq;

}
}else{alert("Chương trình chỉ hỗ trợ độ tuổi từ 6-14 tuổi, vui lòng nhập lại dữ liệu")}
},
error: function(){
	alert("Không tìm thấy dữ liệu");
}
});			
}
})(jQuery);