(function($){
	let domain="https://"+location.hostname;
	// LÀM TRÒN SỐ
	function tron(num, scale) {
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

	// SHOW BMI
	$(window).load(function(){
		$('#bmi').html('');
		var bmi=can_nang=chieu_cao="0";
		can_nang=Number($('.cm_hs_can_nang span').text().trim());
		chieu_cao=Number($('.cm_hs_chieu_cao span').text().trim());
		bmi=tron(can_nang/(chieu_cao*chieu_cao),2);
		tinh_bmi(bmi);	
	})
	function nhap_nhu_cau_dinh_duong(){
		if($('.cm-nhucau-hang-ngay').text().trim() == ""){
			$('#bmi').append('<h6>Nhập nhu cầu dinh dưỡng của trẻ</h6>');
			$('#bmi').append('<label>Năng lượng <input class="cm_nl_nhap" type="text"></label');
			$('#bmi').append('<label>Protein <input class="cm_pr_nhap" type="text"></label');
			$('#bmi').append('<label>Glucid <input class="cm_gl_nhap" type="text"></label');
			$('#bmi').append('<label>Lipid <input class="cm_li_nhap" type="text"></label');
			$('#bmi').append('<label>Canxi <input class="cm_ca_nhap" type="text"></label');
			$('#bmi').append('<label>Sắt <input class="cm_sa_nhap" type="text"></label');
			$('#bmi').append('<label>Kẽm <input class="cm_ke_nhap" type="text"></label');
			$('#bmi').append('<label>Chất xơ <input class="cm_xo_nhap" type="text"></label');
			$('#bmi').append('<a href="#" class="cm-btn cm_luu_nc">Lưu</a>');
			$('.cm_luu_nc').click(function(e){
				e.preventDefault();
				$.ajax({
					type:"POST",
					url:domain+'/wp-content/plugins/caremeal/inc/ajax/save_nhu_cau.php',
					data:{
						'id':$('#cm_us_id').text().trim(),
						'nang_luong': $('.cm_nl_nhap').val().trim(),
						'protein' :$('.cm_pr_nhap').val().trim(),
						'glucid' :$('.cm_gl_nhap').val().trim(),
						'lipid' :$('.cm_li_nhap').val().trim(),
						'canxi' :$('.cm_ca_nhap').val().trim(),
						'sat' :$('.cm_sa_nhap').val().trim(),
						'kem' :$('.cm_ke_nhap').val().trim(),
						'xo' :$('.cm_xo_nhap').val().trim()
					},
					success:function(response){  
						alert ('Thêm thành công');
						location.href="https://caremeal.vn/thuc-don/";

					},
					error:function(){
						alert ('Thêm thất bại');
					}
				});
			})
		}
	}
	// TÍNH BMI VÀ NHU CẦU DINH DƯỠNG
	function tinh_bmi(i){
		var a=$('.cm_hs_tuoi span').text().trim();
		var a1=a.slice(0,4); 
		var a2=Number(a.slice(5,7));
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
		$('.cm_ten_hoc_sinh').append('<span> ('+tuoi_1+' tuổi '+thang_1+' tháng)</span>');
		$.ajax({
			type:"POST",
			url:domain+'/wp-content/plugins/caremeal/view/shortcode/home/ajax/nhu-cau-nang-luong.php', 
			data:{
				'tuoi':tuoi,
				'gioi_tinh':$('.cm_hs_gioi_tinh span').text().trim().toLowerCase()
			},
			success:function(response){
				if (response != 0) {
					response = JSON.parse(response); 
					for(j=0;j < response.length;j++){
						if(i<response[j].sd1){
							$('#bmi').append('<h5>BMI = '+i+'</h5><p>Trẻ suy dinh dưỡng thể nhẹ cân, mức độ nặng, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
							nhap_nhu_cau_dinh_duong()
						} else if(i<response[j].sd2){
							$('#bmi').append('<h5>BMI = '+i+'</h5><p>Trẻ suy dinh dưỡng thể nhẹ cân, mức độ vừa, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
							nhap_nhu_cau_dinh_duong()

						} else if(i<response[j].sd5){
							$('#cm_show_thong_tin_hoc_sinh').show();
							$('#bmi').append('<div><h5>BMI = '+i+'</h5></p>Trẻ bình thường</p></div>');
							$('#bmi').append('<div class="cm-nhucau-hang-ngay"></div>');							
							$('.cm-nhucau-hang-ngay').append('<h5>Nhu cầu dinh dưỡng hàng ngày</h5>');
							let cm_do="cm_do";
							let cm_xanh="cm_xanh";
							let cm_vang="cm_vang";
							$('.cm-nhucau-hang-ngay').append('<p><span><b>Năng lượng: </b><i>'+tron(response[j].nang_luong*can_nang,2)+'</i>kcal</span><span><b>Protein: </b><i>'+tron(response[j].protein*can_nang,2)+'</i>g</span><span><b>Glucid: </b><i>'+response[j].glucid+'</i>g</span><span><b>Lipid: </b><i>'+response[j].lipid+'</i>g</span><span><b>Sắt: </b><i>'+response[j].sat+'</i>mg</span><span><b>Canxi: </b><i>'+response[j].canxi+'</i>mg</span><span class="cm_3cham">...</span><span class="cm_xem"> >> </span><span class="cm_112"><b>Kẽm: </b><i>'+response[j].kem+'</i>mg</span><span class="cm_112"><b>Chất xơ: </b><i>'+response[j].xo+'</i>g</span><span class="cm_thu_lai cm_112"> << </span><p>');
							var nl_conlai=tron(Number(response[j].nang_luong*can_nang)-Number($($('.cm_truong_td_today .nhucau_check_4123 td')[1]).text().trim()),2)
							if(nl_conlai<-100){
								$('.nhucau_con_lai_4123').append('<td class="cm_do">'+nl_conlai+'</td>')
							} else if(nl_conlai >100){
								$('.nhucau_con_lai_4123').append('<td class="cm_vang">'+nl_conlai+'</td>')
							}else{
								$('.nhucau_con_lai_4123').append('<td class="cm_xanh">'+nl_conlai+'</td>')
							}							
							var pro_conlai=tron(Number(response[j].protein*can_nang)-Number($($('.cm_truong_td_today .nhucau_check_4123 td')[2]).text().trim()),2)
							if(pro_conlai<-2){
								$('.nhucau_con_lai_4123').append('<td class="cm_do">'+pro_conlai+'</td>')
							} else if(pro_conlai >2){
								$('.nhucau_con_lai_4123').append('<td class="cm_vang">'+pro_conlai+'</td>')
							}else{
								$('.nhucau_con_lai_4123').append('<td class="cm_xanh">'+pro_conlai+'</td>')
							}		
							var glu_conlai_arr=response[j].glucid;
							glu_conlai_arr=glu_conlai_arr.split('-');
							var glu_conlai_min=tron(Number(glu_conlai_arr[0])-Number($($('.cm_truong_td_today .nhucau_check_4123 td')[3]).text().trim()),2)
							var glu_conlai_max=tron(Number(glu_conlai_arr[1])-Number($($('.cm_truong_td_today .nhucau_check_4123 td')[3]).text().trim()),2)
							if(glu_conlai_min<0 && glu_conlai_max>0){
								glu_conlai_min=0;
							}
							if(glu_conlai_max<0){
								$('.nhucau_con_lai_4123').append('<td class="cm_do">'+glu_conlai_min+'-'+glu_conlai_max+'</td>')
							} else if(glu_conlai_min >0){
								$('.nhucau_con_lai_4123').append('<td class="cm_vang">'+glu_conlai_min+'-'+glu_conlai_max+'</td>')
							}else{
								$('.nhucau_con_lai_4123').append('<td class="cm_xanh">'+glu_conlai_min+'-'+glu_conlai_max+'</td>')
							}	
							var lipid_conlai_arr=response[j].lipid;
							lipid_conlai_arr=lipid_conlai_arr.split('-');
							var lipid_conlai_min=tron(Number(lipid_conlai_arr[0])-Number($($('.cm_truong_td_today .nhucau_check_4123 td')[4]).text().trim()),2)
							var lipid_conlai_max=tron(Number(lipid_conlai_arr[1])-Number($($('.cm_truong_td_today .nhucau_check_4123 td')[4]).text().trim()),2)
							if(lipid_conlai_min<0 && lipid_conlai_max>0){
								lipid_conlai_min=0;
							}
							if(lipid_conlai_max<0){
								$('.nhucau_con_lai_4123').append('<td class="cm_do">'+lipid_conlai_min+'-'+lipid_conlai_max+'</td>')
							} else if(lipid_conlai_min >0){
								$('.nhucau_con_lai_4123').append('<td class="cm_vang">'+lipid_conlai_min+'-'+lipid_conlai_max+'</td>')
							}else{
								$('.nhucau_con_lai_4123').append('<td class="cm_xanh">'+lipid_conlai_min+'-'+lipid_conlai_max+'</td>')
							}	
							var canxi_conlai=tron(Number(response[j].canxi)-Number($($('.cm_truong_td_today .nhucau_check_4123 td')[5]).text().trim()),2)
							if(canxi_conlai<-100){
								$('.nhucau_con_lai_4123').append('<td class="cm_do">'+canxi_conlai+'</td>')
							} else if(canxi_conlai >100){
								$('.nhucau_con_lai_4123').append('<td class="cm_vang">'+canxi_conlai+'</td>')
							}else{
								$('.nhucau_con_lai_4123').append('<td class="cm_xanh">'+canxi_conlai+'</td>')
							}	
							var sat_conlai_arr=response[j].sat;
							sat_conlai_arr=sat_conlai_arr.split('-');
							var sat_conlai_min=tron(Number(sat_conlai_arr[0])-Number($($('.cm_truong_td_today .nhucau_check_4123 td')[6]).text().trim()),2)
							var sat_conlai_max=tron(Number(sat_conlai_arr[1])-Number($($('.cm_truong_td_today .nhucau_check_4123 td')[6]).text().trim()),2)
							if(sat_conlai_min<0 && sat_conlai_max>0){
								sat_conlai_min=0;
							}
							if(sat_conlai_max<0){
								$('.nhucau_con_lai_4123').append('<td class="cm_do">'+sat_conlai_min+'-'+sat_conlai_max+'</td>')
							} else if(sat_conlai_min >0){
								$('.nhucau_con_lai_4123').append('<td class="cm_vang">'+sat_conlai_min+'-'+sat_conlai_max+'</td>')
							}else{
								$('.nhucau_con_lai_4123').append('<td class="cm_xanh">'+sat_conlai_min+'-'+sat_conlai_max+'</td>')
							}	
							var kem_conlai_arr=response[j].kem;
							kem_conlai_arr=kem_conlai_arr.split('-');
							var kem_conlai_min=tron(Number(kem_conlai_arr[0])-Number($($('.cm_truong_td_today .nhucau_check_4123 td')[7]).text().trim()),2)
							var kem_conlai_max=tron(Number(kem_conlai_arr[1])-Number($($('.cm_truong_td_today .nhucau_check_4123 td')[7]).text().trim()),2)
							if(kem_conlai_min<0 && kem_conlai_max>0){
								kem_conlai_min=0;
							}
							if(kem_conlai_max<0){
								$('.nhucau_con_lai_4123').append('<td class="cm_do">'+kem_conlai_min+'-'+kem_conlai_max+'</td>')
							} else if(kem_conlai_min >0){
								$('.nhucau_con_lai_4123').append('<td class="cm_vang">'+kem_conlai_min+'-'+kem_conlai_max+'</td>')
							}else{
								$('.nhucau_con_lai_4123').append('<td class="cm_xanh">'+kem_conlai_min+'-'+kem_conlai_max+'</td>')
							}	
							var xo_conlai=response[j].xo;
							xo_conlai=xo_conlai.split('-');
							var xo_conlai_min=tron(Number(xo_conlai[0])-Number($($('.cm_truong_td_today .nhucau_check_4123 td')[8]).text().trim()),2)
							var xo_conlai_max=tron(Number(xo_conlai[1])-Number($($('.cm_truong_td_today .nhucau_check_4123 td')[8]).text().trim()),2)
							if(xo_conlai_min<0 && xo_conlai_max>0){
								xo_conlai_min=0;
							}
							if(xo_conlai_max<0){
								$('.nhucau_con_lai_4123').append('<td class="cm_do">'+xo_conlai_min+'-'+xo_conlai_max+'</td>')
							} else if(xo_conlai_min >0){
								$('.nhucau_con_lai_4123').append('<td class="cm_vang">'+xo_conlai_min+'-'+xo_conlai_max+'</td>')
							}else{
								$('.nhucau_con_lai_4123').append('<td class="cm_xanh">'+xo_conlai_min+'-'+xo_conlai_max+'</td>')
							}	
							
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
							$('#bmi').append('<h5>BMI = '+i+'</h5><p>Trẻ thừa cân, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
							nhap_nhu_cau_dinh_duong()

						} else{
							$('#bmi').append('<h5>BMI = '+i+'</h5><p>Trẻ béo phì, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
							nhap_nhu_cau_dinh_duong()

						}
						return bmi_kq;
					}
				}
			},
			error: function(){
				alert("Không tìm thấy dữ liệu");
			}
		});			
}
	//Cập nhật thực đơn
	$('.cm-truong_update').click(function(e){
		e.preventDefault();
		$.ajax({
			type:"POST",
			url:domain+'/wp-content/plugins/caremeal/view/js/ajax/cap_nhap_thuc_don.php',
			data:{
				'user_id':$('#cm_us_id').text().trim()
			},
			success:function(response){                 
				alert('Cập nhật thực đơn nhà trường thành công');    
				window.location.reload(true);              
			}
		});
	})
	
	// KẾT NỐI HỌC SINH
	$('.cm_ket_noi_hs_id').click(function(){
		var b=$('input[name="id_hoc_sinh"]').val().trim();
		if($('.cm_user_check_hs').text().indexOf(b) >=0){
			$.ajax({
				type:"POST",
				url:domain+'/wp-content/plugins/caremeal/view/shortcode/thuc_don/phu_huynh/js/ajax/load-user.php',
				data:{
					'id':b,
					'idp':$('.cm_user_check_ph').text().trim()
				},
				success:function(response){  
					if (response != 0) {
						alert ('Kết nối thành công');
					} else{
						$.ajax({
							type:"POST",
							url:domain+'/wp-content/plugins/caremeal/view/js/ajax/cap_nhap_thuc_don.php',
							data:{
								'user_id':$('input[name="id_hoc_sinh"]').val().trim()
							},
							success:function(response){                 
								console.log("a")                    
							}
						});
						alert ('Kết nối thành công');
						location.reload(true);
					}

				},
				error:function(){
					alert ('Kết nối thất bại 5');
				}
			});
		}
		else{
			alert("ID vừa nhập không chính xác");
		}
	})

	// THÊM THỰC ĐƠN
	$('.cm-truong_them').click(function(e){
		e.preventDefault();
		$('#cm_them_thuc_don').show();
	});
	$('#cm_them_thuc_don .cm_overlsy, #cm_them_thuc_don .fa-times').click(function(){
		$('#cm_them_thuc_don').hide();
	})
	$('.cm_chon_mon_btn').click(function(e){
		e.preventDefault();		
		var a=$('.cm_chon_mon_area select option:selected').val().trim();
		var b=$('.cm_chon_ngay_112.cm_chon_ngay_812 #ndt').val().trim()
		if(a=="chon"){
			if(b==""){
				alert("Bạn chưa chọn bữa ăn và ngày");
				$('.truong_them__mon__an tbody label input[type="checkbox"]').prop('checked',false);
			}
			else{
				alert("Bạn chưa chọn bữa ăn");
				$('.truong_them__mon__an tbody label input[type="checkbox"]').prop('checked',false);
			}
			
		}else{
			if(b==""){
				alert("Bạn chưa ngày");
				$('.truong_them__mon__an tbody label input[type="checkbox"]').prop('checked',false);
			}
			else{
				$('.truong_them__mon__an').show();
			}
		}		
	});	
	$('.truong_them__mon__an .truong_them__mon__an_ov, .truong_them__mon__an .fa-times').click(function(){
		$('.truong_them__mon__an').hide();
	})
	$('.cm_tao_mon_btn').click(function(e){
		e.preventDefault();
		$('.cm-them_thu_don-chon_nguyen__lieu').show();
	});
	$('.cm-them_thu_don-chon_nguyen__lieu i.fa-times,.cm-them_thu_don-chon_nguyen__lieu_ov').click(function(){
		$('.cm-them_thu_don-chon_nguyen__lieu').hide();
	});
	$('.cm_chon_nguyen__lieu-chitiet_712_btn').click(function(e){
		e.preventDefault();
		$('.truong_chon_nguyen_lieu_71220').show();
	});
	$('.truong_chon_nguyen_lieu_71220_ct i.fa-times, .truong_chon_nguyen_lieu_71220_ov').click(function(){
		$('.truong_chon_nguyen_lieu_71220').hide();
	});
	//THÊM MÓN ĂN
	let count_mon_an_truong=0;
	let thuc_don_nang_luong_truong=thuc_don_protein_truong=thuc_don_protein_truong=thuc_don_glucid_truong=thuc_don_lipid_truong=0;
	$('.truong_them__mon__an tbody label input[type="checkbox"]').each(function(){
		$(this).change(function(){
			if($(this).prop('checked')){
				if(count_mon_an_truong<6){
					var cm_mon_an=$(this).parent().text();
					console.log(cm_mon_an);
					count_mon_an_truong++;
					for(var n=1;n<=jQuery('.cm_tab_ct ul li').size();n++){
						if($('.cm_chon_ngay_112.cm_chon_ngay_812 #ndt').val().trim()==$($('.cm_tab_ct ul li')[n]).find('span').text().trim().slice(1,11)){
							var cm_a=$($('.cm_tab_ct .cm_tab_content_tuan >div')[n]);
							cm_a.find('tbody tr').each(function(){
								if($($(this).find('td')[1]).text()==cm_mon_an){
									alert("Món ăn này đã có trong thực đơn ngày"+$('.cm_chon_ngay_112.cm_chon_ngay_812 #ndt').val().trim());
								}
							})
						}
					}
				}
				else{
					alert("Bạn chỉ được chọn tối đa 6 món ăn");
					$(this).prop('checked',false);
				}
			}else{
				count_mon_an_truong--;
			}

		})
	});
	$('.cm_truong_them_td_btn_712').click(function(e){
		e.preventDefault();
		if(count_mon_an_truong==0){
			$('.cm_truong_thong_tin').hide();
		}
		else
		{
			$('.cm_truong_thong_tin').show();
		}
		$('.cm_truong_thong_tin tbody').html('');
		$('.truong_them__mon__an tbody label input[type="checkbox"]').each(function(){
			if($(this).prop('checked')){
				var cha=$(this).parent().parent().parent();
				$('.cm_truong_thong_tin tbody').prepend('<tr><td style="width:6%"><img src="'+$(cha.find('img')).attr('src')+'"></td><td class="cm_truong_mon_an_ten" style="width: 20%">'+$(cha.find('td')[1]).text().trim()+'</td><td style="width: 14.5%">'+$(cha.find('td')[2]).text().trim()+'</td><td style="width: 8.5%">'+$(cha.find('td')[3]).text().trim()+'</td><td style="width:8.5%">'+$(cha.find('td')[4]).text().trim()+'</td><td style="width: 8.5%">'+$(cha.find('td')[5]).text().trim()+'</td><td style="width: 8.5%">'+$(cha.find('td')[6]).text().trim()+'</td><td style="width: 8.5%">'+$(cha.find('td')[7]).text().trim()+'</td><td style="width: 8.5%">'+$(cha.find('td')[8]).text().trim()+'</td><td style="width: 8.5%">'+$(cha.find('td')[9]).text().trim()+'</td></tr>');
				cm_total_nang_luong();
				
			}else{
				let cm_mon_an_uncheck=$(this).val();
				$('.cm-them_thu_don-chon_nguyen__lieu-chitiet tbody tr').each(function(){
					if($(this).find('.cm_truong_mon_an_ten').text().trim()==cm_mon_an_uncheck){
						$(this).remove();
						cm_total_nang_luong();
					}
				})
			}
		});
		$('#dt').change(function(){
			
		})
		$('.truong_them__mon__an').hide();
	});
	
	function cm_total_nang_luong(){
		let nl_cl=pro_cl=gl_cl=li_cl=ca_cl=sat_cl=kem_cl=xo_cl=0;
		let nl_dd=pro_dd=gl_dd=li_dd=ca_dd=sat_dd=kem_dd=xo_dd=0;
		for(var n=1;n<=jQuery('.cm_tab_ct ul li').size();n++){
			if($('.cm_chon_ngay_112.cm_chon_ngay_812 #ndt').val().trim()==$($('.cm_tab_ct ul li')[n]).find('span').text().trim().slice(1,11)){
				var cm_a=$($('.cm_tab_ct .cm_tab_content_tuan >div')[n]);
				nl_cl=Number($(cm_a.find('.nhucau_con_lai_4124 td')[1]).text().trim());
				pro_cl=Number($(cm_a.find('.nhucau_con_lai_4124 td')[2]).text().trim());
				gl_cl=$(cm_a.find('.nhucau_con_lai_4124 td')[3]).text().trim();
				gl_cl=gl_cl.split("-");
				gl_cl_min=Number(gl_cl[0]);
				gl_cl_max=Number(gl_cl[1]);
				li_cl=$(cm_a.find('.nhucau_con_lai_4124 td')[4]).text().trim();
				li_cl=li_cl.split("-");
				li_cl_min=Number(li_cl[0]);
				li_cl_max=Number(li_cl[1]);
				ca_cl=Number($(cm_a.find('.nhucau_con_lai_4124 td')[5]).text().trim());
				sat_cl=$(cm_a.find('.nhucau_con_lai_4124 td')[6]).text().trim();
				sat_cl=sat_cl.split("-");
				sat_cl_min=Number(sat_cl[0]);
				sat_cl_max=Number(sat_cl[1]);
				kem_cl=$(cm_a.find('.nhucau_con_lai_4124 td')[7]).text().trim();
				kem_cl=kem_cl.split("-");
				kem_cl_min=Number(kem_cl[0]);
				kem_cl_max=Number(kem_cl[1]);
				xo_cl=$(cm_a.find('.nhucau_con_lai_4124 td')[8]).text().trim();
				xo_cl=xo_cl.split("-");
				xo_cl_min=Number(xo_cl[0]);
				xo_cl_max=Number(xo_cl[1]);
				nl_dd=Number($(cm_a.find('.nhucau_check_4123 td')[1]).text().trim());
				pro_dd=Number($(cm_a.find('.nhucau_check_4123 td')[2]).text().trim());
				gl_dd=Number($(cm_a.find('.nhucau_check_4123 td')[3]).text().trim());
				li_dd=Number($(cm_a.find('.nhucau_check_4123 td')[4]).text().trim());
				ca_dd=Number($(cm_a.find('.nhucau_check_4123 td')[5]).text().trim());
				sat_dd=Number($(cm_a.find('.nhucau_check_4123 td')[6]).text().trim());
				kem_dd=Number($(cm_a.find('.nhucau_check_4123 td')[7]).text().trim());
				xo_dd=Number($(cm_a.find('.nhucau_check_4123 td')[8]).text().trim());
			}
		}
		var nang_luong=protein=glucid=lipid=canxi=sat=kem=xo=0;
		$('.cm_truong_thong_tin tbody tr').each(function(){
			var t=$(this).find('td');
			nang_luong+=Number($(t[2]).text()); 
			nang_luong=tron(nang_luong,2);
			protein+=Number($(t[3]).text());
			protein=tron(protein,2); 
			glucid+=Number($(t[4]).text());
			glucid=tron(glucid,2); 
			lipid+=Number($(t[5]).text()); 
			lipid=tron(lipid,2);
			canxi+=Number($(t[6]).text());
			canxi=tron(canxi,2); 
			sat+=Number($(t[7]).text());
			sat=tron(sat,2); 
			kem+=Number($(t[8]).text());
			kem=tron(kem,2);
			xo+=Number($(t[9]).text()); 
			xo=tron(xo,2);
		})
		nl_cl=tron(nl_cl-nang_luong,2);
		pro_cl=tron(pro_cl-protein,2);
		
		gl_cl_min=tron(gl_cl_min-glucid,2);
		gl_cl_max=tron(gl_cl_max-glucid,2);
		
		li_cl_min=tron(li_cl_min-lipid,2);
		li_cl_max=tron(li_cl_max-lipid,2);
		ca_cl=tron(ca_cl-canxi,2);
		
		sat_cl_min=tron(sat_cl_min-sat,2);
		sat_cl_max=tron(sat_cl_max-sat,2);
		
		kem_cl_min=tron(kem_cl_min-kem,2);
		kem_cl_max=tron(kem_cl_max-kem,2);
		
		xo_cl_min=tron(xo_cl_min-xo,2);
		xo_cl_max=tron(xo_cl_max-xo,2);
		
		$('.cm-total_nang_luong').text(nang_luong);
		$('.cm-total_protein').text(protein);
		$('.cm-total_glucid').text(glucid);
		$('.cm-total_lipid').text(lipid);
		$('.cm-total_canxi').text(canxi);
		$('.cm-total_sat').text(sat);
		$('.cm-total_kem').text(kem);
		$('.cm-total_xo').text(xo);
		if(nl_cl<-100){
			$('.cm-total_nang_luong_cl').text(nl_cl).addClass("cm_do");
		}
		else if(nl_cl>100){
			$('.cm-total_nang_luong_cl').text(nl_cl).addClass("cm_vang");
		}
		else{
			$('.cm-total_nang_luong_cl').text(nl_cl).addClass("cm_xanh");
		}
		
		if(pro_cl<-2){
			$('.cm-total_protein_cl').text(pro_cl).addClass("cm_do");
		}
		else if(pro_cl>2){
			$('.cm-total_protein_cl').text(pro_cl).addClass("cm_vang");
		}
		else{
			$('.cm-total_protein_cl').text(pro_cl).addClass("cm_xanh");
		}
		
		if(gl_cl_min<0 && gl_cl_max>0){
			gl_cl_min=0;
		}
		if(gl_cl_max<0){
			$('.cm-total_glucid_cl').text(gl_cl_min+"-"+gl_cl_max).addClass("cm_do");
		} else if(gl_cl_min >0){
			$('.cm-total_glucid_cl').text(gl_cl_min+"-"+gl_cl_max).addClass("cm_vang");
		}else{
			$('.cm-total_glucid_cl').text(gl_cl_min+"-"+gl_cl_max).addClass("cm_xanh");
		}	
		//$('.cm-total_lipid_cl').text(li_cl_min+"-"+li_cl_max);
		if(li_cl_min<0 && li_cl_max>0){
			li_cl_min=0;
		}
		if(li_cl_max<0){
			$('.cm-total_lipid_cl').text(li_cl_min+"-"+li_cl_max).addClass("cm_do");
		} else if(li_cl_min >0){
			$('.cm-total_lipid_cl').text(li_cl_min+"-"+li_cl_max).addClass("cm_vang");
		}else{
			$('.cm-total_lipid_cl').text(li_cl_min+"-"+li_cl_max).addClass("cm_xanh");
		}	
		$('.cm-total_canxi_cl').text(ca_cl);
		if(ca_cl<-100){
			$('.cm-total_canxi_cl').text(ca_cl).addClass("cm_do");
		}
		else if(ca_cl>100){
			$('.cm-total_canxi_cl').text(ca_cl).addClass("cm_vang");
		}
		else{
			$('.cm-total_canxi_cl').text(ca_cl).addClass("cm_xanh");
		}
		if(sat_cl_min<0 && sat_cl_max>0){
			sat_cl_min=0;
		}
		if(sat_cl_max<0){
			$('.cm-total_sat_cl').text(sat_cl_min+"-"+sat_cl_max).addClass("cm_do");
		} else if(sat_cl_min >0){
			$('.cm-total_sat_cl').text(sat_cl_min+"-"+sat_cl_max).addClass("cm_vang");
		}else{
			$('.cm-total_sat_cl').text(sat_cl_min+"-"+sat_cl_max).addClass("cm_xanh");
		}	
		if(kem_cl_min<0 && kem_cl_max>0){
			kem_cl_min=0;
		}
		if(kem_cl_max<0){
			$('.cm-total_kem_cl').text(kem_cl_min+"-"+kem_cl_max).addClass("cm_do");
		} else if(kem_cl_min >0){
			$('.cm-total_kem_cl').text(kem_cl_min+"-"+kem_cl_max).addClass("cm_vang");
		}else{
			$('.cm-total_kem_cl').text(kem_cl_min+"-"+kem_cl_max).addClass("cm_xanh");
		}	
		if(xo_cl_min<0 && xo_cl_max>0){
			xo_cl_min=0;
		}
		if(xo_cl_max<0){
			$('.cm-total_xo_cl').text(xo_cl_min+"-"+xo_cl_max).addClass("cm_do");
		} else if(xo_cl_min >0){
			$('.cm-total_xo_cl').text(xo_cl_min+"-"+xo_cl_max).addClass("cm_vang");
		}else{
			$('.cm-total_xo_cl').text(xo_cl_min+"-"+xo_cl_max).addClass("cm_xanh");
		}	
		nl_dd=tron(nl_dd+nang_luong,2);
		pro_dd=tron(pro_dd+protein,2);
		gl_dd=tron(gl_dd+glucid,2);
		li_dd=tron(li_dd+lipid,2);
		ca_dd=tron(ca_dd+canxi,2);
		sat_dd=tron(sat_dd+sat,2);
		kem_dd=tron(kem_dd+kem,2);
		xo_dd=tron(xo_dd+xo,2); 
		let pt_protein=pt_lipid=pt_glucid=0;
		pt_protein=tron(((pro_dd*4)/nl_dd)*100,2);
		pt_lipid=tron(((li_dd*9)/nl_dd)*100,2);
		pt_glucid=tron(100-pt_protein-pt_lipid,2);
		$('.cm-total_nang_luong_dd').text(nl_dd);
		$('.cm-total_protein_dd').text(pro_dd);
		$('.cm-total_glucid_dd').text(gl_dd);
		$('.cm-total_lipid_dd').text(li_dd);
		$('.cm-total_canxi_dd').text(ca_dd);
		$('.cm-total_sat_dd').text(sat_dd);
		$('.cm-total_kem_dd').text(kem_dd);
		$('.cm-total_xo_dd').text(xo_dd);
		$('.cm_1111').html('');
		$('.cm_1112').html('');
		$('.cm_1113').html('');
		if(pt_protein<13){
			$('.cm_1111').addClass('cl-thieu').append('<span>'+pt_protein+'%</span>')
		}else if(pt_protein>20){
			$('.cm_1111').addClass('cl-thua').append('<span >'+pt_protein+'%</span>')
		}
		else{
			$('.cm_1111').addClass('cl-ok').append('<span>'+pt_protein+'%</span>')
		}
		if(pt_glucid<50){
			$('.cm_1112').addClass('cl-thieu').append('<span>'+pt_glucid+'%</span>')
		}else if(pt_glucid>65){
			$('.cm_1112').addClass('cl-thua').append('<span>'+pt_glucid+'%</span>')
		}
		else{
			$('.cm_1112').addClass('cl-ok').append('<span>'+pt_glucid+'%</span>')
		}
		if(pt_lipid<20){
			$('.cm_1113').addClass('cl-thieu').append('<span>'+pt_lipid+'%</span>')
		}else if(pt_lipid>30){
			$('.cm_1113').addClass('cl-thua').append('<span>'+pt_lipid+'%</span>')
		}
		else{
			$('.cm_1113').addClass('cl-ok').append('<span>'+pt_lipid+'%</span>')
		}
		$('#dt').change(function(){
			for(var n=1;n<=jQuery('.cm_tab_ct ul li').size();n++){
				if($('.cm_chon_ngay_112.cm_chon_ngay_812 #ndt').val().trim()==$($('.cm_tab_ct ul li')[n]).find('span').text().trim().slice(1,11)){
					var cm_a=$($('.cm_tab_ct .cm_tab_content_tuan >div')[n]);
					nl_cl=Number($(cm_a.find('.nhucau_con_lai_4124 td')[1]).text().trim());
					pro_cl=Number($(cm_a.find('.nhucau_con_lai_4124 td')[2]).text().trim());
					gl_cl=$(cm_a.find('.nhucau_con_lai_4124 td')[3]).text().trim();
					gl_cl=gl_cl.split("-");
					gl_cl_min=Number(gl_cl[0]);
					gl_cl_max=Number(gl_cl[1]);
					li_cl=$(cm_a.find('.nhucau_con_lai_4124 td')[4]).text().trim();
					li_cl=li_cl.split("-");
					li_cl_min=Number(li_cl[0]);
					li_cl_max=Number(li_cl[1]);
					ca_cl=Number($(cm_a.find('.nhucau_con_lai_4124 td')[5]).text().trim());
					sat_cl=$(cm_a.find('.nhucau_con_lai_4124 td')[6]).text().trim();
					sat_cl=sat_cl.split("-");
					sat_cl_min=Number(sat_cl[0]);
					sat_cl_max=Number(sat_cl[1]);
					kem_cl=$(cm_a.find('.nhucau_con_lai_4124 td')[7]).text().trim();
					kem_cl=kem_cl.split("-");
					kem_cl_min=Number(kem_cl[0]);
					kem_cl_max=Number(kem_cl[1]);
					xo_cl=$(cm_a.find('.nhucau_con_lai_4124 td')[8]).text().trim();
					xo_cl=xo_cl.split("-");
					xo_cl_min=Number(xo_cl[0]);
					xo_cl_max=Number(xo_cl[1]);
					nl_dd=Number($(cm_a.find('.nhucau_check_4123 td')[1]).text().trim());
					pro_dd=Number($(cm_a.find('.nhucau_check_4123 td')[2]).text().trim());
					gl_dd=Number($(cm_a.find('.nhucau_check_4123 td')[3]).text().trim());
					li_dd=Number($(cm_a.find('.nhucau_check_4123 td')[4]).text().trim());
					ca_dd=Number($(cm_a.find('.nhucau_check_4123 td')[5]).text().trim());
					sat_dd=Number($(cm_a.find('.nhucau_check_4123 td')[6]).text().trim());
					kem_dd=Number($(cm_a.find('.nhucau_check_4123 td')[7]).text().trim());
					xo_dd=Number($(cm_a.find('.nhucau_check_4123 td')[8]).text().trim());
				}
			}
			var nang_luong=protein=glucid=lipid=canxi=sat=kem=xo=0;
			$('.cm_truong_thong_tin tbody tr').each(function(){
				var t=$(this).find('td');
				nang_luong+=Number($(t[2]).text()); 
				nang_luong=tron(nang_luong,2);
				protein+=Number($(t[3]).text());
				protein=tron(protein,2); 
				glucid+=Number($(t[4]).text());
				glucid=tron(glucid,2); 
				lipid+=Number($(t[5]).text()); 
				lipid=tron(lipid,2);
				canxi+=Number($(t[6]).text());
				canxi=tron(canxi,2); 
				sat+=Number($(t[7]).text());
				sat=tron(sat,2); 
				kem+=Number($(t[8]).text());
				kem=tron(kem,2);
				xo+=Number($(t[9]).text()); 
				xo=tron(xo,2);
			})
			nl_cl=tron(nl_cl-nang_luong,2);
			pro_cl=tron(pro_cl-protein,2);

			gl_cl_min=tron(gl_cl_min-glucid,2);
			gl_cl_max=tron(gl_cl_max-glucid,2);

			li_cl_min=tron(li_cl_min-lipid,2);
			li_cl_max=tron(li_cl_max-lipid,2);
			ca_cl=tron(ca_cl-canxi,2);

			sat_cl_min=tron(sat_cl_min-sat,2);
			sat_cl_max=tron(sat_cl_max-sat,2);

			kem_cl_min=tron(kem_cl_min-kem,2);
			kem_cl_max=tron(kem_cl_max-kem,2);

			xo_cl_min=tron(xo_cl_min-xo,2);
			xo_cl_max=tron(xo_cl_max-xo,2);

			$('.cm-total_nang_luong').text(nang_luong);
			$('.cm-total_protein').text(protein);
			$('.cm-total_glucid').text(glucid);
			$('.cm-total_lipid').text(lipid);
			$('.cm-total_canxi').text(canxi);
			$('.cm-total_sat').text(sat);
			$('.cm-total_kem').text(kem);
			$('.cm-total_xo').text(xo);
			if(nl_cl<-100){
				$('.cm-total_nang_luong_cl').text(nl_cl).addClass("cm_do");
			}
			else if(nl_cl>100){
				$('.cm-total_nang_luong_cl').text(nl_cl).addClass("cm_vang");
			}
			else{
				$('.cm-total_nang_luong_cl').text(nl_cl).addClass("cm_xanh");
			}

			if(pro_cl<-2){
				$('.cm-total_protein_cl').text(pro_cl).addClass("cm_do");
			}
			else if(pro_cl>2){
				$('.cm-total_protein_cl').text(pro_cl).addClass("cm_vang");
			}
			else{
				$('.cm-total_protein_cl').text(pro_cl).addClass("cm_xanh");
			}

			if(gl_cl_min<0 && gl_cl_max>0){
				gl_cl_min=0;
			}
			if(gl_cl_max<0){
				$('.cm-total_glucid_cl').text(gl_cl_min+"-"+gl_cl_max).addClass("cm_do");
			} else if(gl_cl_min >0){
				$('.cm-total_glucid_cl').text(gl_cl_min+"-"+gl_cl_max).addClass("cm_vang");
			}else{
				$('.cm-total_glucid_cl').text(gl_cl_min+"-"+gl_cl_max).addClass("cm_xanh");
			}	
		//$('.cm-total_lipid_cl').text(li_cl_min+"-"+li_cl_max);
		if(li_cl_min<0 && li_cl_max>0){
			li_cl_min=0;
		}
		if(li_cl_max<0){
			$('.cm-total_lipid_cl').text(li_cl_min+"-"+li_cl_max).addClass("cm_do");
		} else if(li_cl_min >0){
			$('.cm-total_lipid_cl').text(li_cl_min+"-"+li_cl_max).addClass("cm_vang");
		}else{
			$('.cm-total_lipid_cl').text(li_cl_min+"-"+li_cl_max).addClass("cm_xanh");
		}	
		$('.cm-total_canxi_cl').text(ca_cl);
		if(ca_cl<-100){
			$('.cm-total_canxi_cl').text(ca_cl).addClass("cm_do");
		}
		else if(ca_cl>100){
			$('.cm-total_canxi_cl').text(ca_cl).addClass("cm_vang");
		}
		else{
			$('.cm-total_canxi_cl').text(ca_cl).addClass("cm_xanh");
		}
		if(sat_cl_min<0 && sat_cl_max>0){
			sat_cl_min=0;
		}
		if(sat_cl_max<0){
			$('.cm-total_sat_cl').text(sat_cl_min+"-"+sat_cl_max).addClass("cm_do");
		} else if(sat_cl_min >0){
			$('.cm-total_sat_cl').text(sat_cl_min+"-"+sat_cl_max).addClass("cm_vang");
		}else{
			$('.cm-total_sat_cl').text(sat_cl_min+"-"+sat_cl_max).addClass("cm_xanh");
		}	
		if(kem_cl_min<0 && kem_cl_max>0){
			kem_cl_min=0;
		}
		if(kem_cl_max<0){
			$('.cm-total_kem_cl').text(kem_cl_min+"-"+kem_cl_max).addClass("cm_do");
		} else if(kem_cl_min >0){
			$('.cm-total_kem_cl').text(kem_cl_min+"-"+kem_cl_max).addClass("cm_vang");
		}else{
			$('.cm-total_kem_cl').text(kem_cl_min+"-"+kem_cl_max).addClass("cm_xanh");
		}	
		if(xo_cl_min<0 && xo_cl_max>0){
			xo_cl_min=0;
		}
		if(xo_cl_max<0){
			$('.cm-total_xo_cl').text(xo_cl_min+"-"+xo_cl_max).addClass("cm_do");
		} else if(xo_cl_min >0){
			$('.cm-total_xo_cl').text(xo_cl_min+"-"+xo_cl_max).addClass("cm_vang");
		}else{
			$('.cm-total_xo_cl').text(xo_cl_min+"-"+xo_cl_max).addClass("cm_xanh");
		}	
		nl_dd=tron(nl_dd+nang_luong,2);
		pro_dd=tron(pro_dd+protein,2);
		gl_dd=tron(gl_dd+glucid,2);
		li_dd=tron(li_dd+lipid,2);
		ca_dd=tron(ca_dd+canxi,2);
		sat_dd=tron(sat_dd+sat,2);
		kem_dd=tron(kem_dd+kem,2);
		xo_dd=tron(xo_dd+xo,2); 
		let pt_protein=pt_lipid=pt_glucid=0;
		pt_protein=tron(((pro_dd*4)/nl_dd)*100,2);
		pt_lipid=tron(((li_dd*4)/nl_dd)*100,2);
		pt_glucid=tron(100-pt_protein-pt_lipid,2);
		$('.cm-total_nang_luong_dd').text(nl_dd);
		$('.cm-total_protein_dd').text(pro_dd);
		$('.cm-total_glucid_dd').text(gl_dd);
		$('.cm-total_lipid_dd').text(li_dd);
		$('.cm-total_canxi_dd').text(ca_dd);
		$('.cm-total_sat_dd').text(sat_dd);
		$('.cm-total_kem_dd').text(kem_dd);
		$('.cm-total_xo_dd').text(xo_dd);
		$('.cm_1111').html('');
		$('.cm_1112').html('');
		$('.cm_1113').html('');
		if(pt_protein<13){
			$('.cm_1111').addClass('cl-thieu').append('<span>'+pt_protein+'%</span>')
		}else if(pt_protein>20){
			$('.cm_1111').addClass('cl-thua').append('<span >'+pt_protein+'%</span>')
		}
		else{
			$('.cm_1111').addClass('cl-ok').append('<span>'+pt_protein+'%</span>')
		}
		if(pt_glucid<50){
			$('.cm_1112').addClass('cl-thieu').append('<span>'+pt_glucid+'%</span>')
		}else if(pt_glucid>65){
			$('.cm_1112').addClass('cl-thua').append('<span>'+pt_glucid+'%</span>')
		}
		else{
			$('.cm_1112').addClass('cl-ok').append('<span>'+pt_glucid+'%</span>')
		}
		if(pt_lipid<20){
			$('.cm_1113').addClass('cl-thieu').append('<span>'+pt_lipid+'%</span>')
		}else if(pt_lipid>30){
			$('.cm_1113').addClass('cl-thua').append('<span>'+pt_lipid+'%</span>')
		}
		else{
			$('.cm_1113').addClass('cl-ok').append('<span>'+pt_lipid+'%</span>')
		}
	})
}
let count_mon_an_truong_1=0;
let thuc_don_nang_luong_truong_1=thuc_don_protein_truong_1=thuc_don_protein_truong_1=thuc_don_glucid_truong_1=thuc_don_lipid_truong_1=0;
$('.truong_chon_nguyen_lieu_71220_1ct_tb label input[type="checkbox"]').each(function(){
	$(this).change(function(){
		if($(this).prop('checked')){
			if(count_mon_an_truong_1<6){
				count_mon_an_truong_1++;
			}
			else{
				alert("Bạn chỉ được chọn tối đa 6 nguyên liệu");
				$(this).prop('checked',false);
			}
		}else{
			count_mon_an_truong_1--;
		}

	})
});
$('.truong_chon_nguyen_lieu_71220_1ct_tb_btn').click(function(e){
	e.preventDefault();
	if(count_mon_an_truong_1==0){
		$('.cm_chon_nguyen__lieu-chitiet_712_nlt').hide();
	}
	else
	{

		$('.cm_chon_nguyen__lieu-chitiet_712_nlt').show();
	}
	$('.cm-them_thu_don-chon_nguyen__lieu-chitiet tbody').html('');
	$('.truong_chon_nguyen_lieu_71220_1ct_tb label input[type="checkbox"]').each(function(){
		if($(this).prop('checked')){
			var cha=$(this).parent().parent().parent();
			$('.cm-them_thu_don-chon_nguyen__lieu-chitiet tbody').prepend('<tr><td style="display:none"><i class="hs_nl">'+Number($(cha.find('td')[2]).text().trim())/100+'</i><i class="hs_pr">'+Number($(cha.find('td')[3]).text().trim())/100+'</i><i class="hs_gl">'+Number($(cha.find('td')[4]).text().trim())/100+'</i><i class="hs_li">'+Number($(cha.find('td')[5]).text().trim())/100+'</i><i class="hs_caxi">'+Number($(cha.find('td')[6]).text().trim())/100+'</i><i class="hs_sat">'+Number($(cha.find('td')[7]).text().trim())/100+'</i><i class="hs_kem">'+Number($(cha.find('td')[8]).text().trim())/100+'</i><i class="hs_xo">'+Number($(cha.find('td')[9]).text().trim())/100+'</i></td><td style="width: 6%" ><img src="'+$(cha.find('img')).attr('src')+'"></td><td class="cm_truong_mon_an_ten_1" style="width: 18%">'+$(cha.find('td')[1]).text().trim()+'</td><td style="width: 14%">'+$(cha.find('td')[2]).text().trim()+'</td><td style="width: 7.5%">'+$(cha.find('td')[3]).text().trim()+'</td><td style="width: 7.5%">'+$(cha.find('td')[4]).text().trim()+'</td><td style="width: 7.5%">'+$(cha.find('td')[5]).text().trim()+'</td><td style="width:7.5%">'+$(cha.find('td')[6]).text().trim()+'</td><td style="width:7.5%">'+$(cha.find('td')[7]).text().trim()+'</td><td style="width:7.5%">'+$(cha.find('td')[8]).text().trim()+'</td><td style="width:7.5%">'+$(cha.find('td')[9]).text().trim()+'</td><td style="width:9.5%;padding:0"><input type="number" value="100"></td></tr>');
			cm_total_nang_luong_1();

		}else{
			let cm_mon_an_uncheck_1=$(this).val();
			$('.cm-them_thu_don-chon_nguyen__lieu-chitiet tbody tr').each(function(){
				if($(this).find('.cm_truong_mon_an_ten_1').text().trim()==cm_mon_an_uncheck_1){
					$(this).remove();
					cm_total_nang_luong_1();
				}
			})
		}
	});
	$('.truong_chon_nguyen_lieu_71220').hide();
	$('.cm_chitiet_712_nlt_tba tbody tr input').change(function(){
		var t=$(this).parent().parent();
		var a=Number($(this).val().trim()); 
		var nl=Number($(t.find('.hs_nl')).text().trim()) ; 
		var pr=Number($(t.find('.hs_pr')).text().trim()) ; 
		var gl=Number($(t.find('.hs_gl')).text().trim()) ; 
		var lp=Number($(t.find('.hs_li')).text().trim()) ; 
		var canxi=Number($(t.find('.hs_li')).text().trim()) ;
		var sat=Number($(t.find('.hs_li')).text().trim()) ;
		var kem=Number($(t.find('.hs_li')).text().trim()) ;
		var xo=Number($(t.find('.hs_li')).text().trim()) ;
		$(t.find('td')[3]).text(tron(a*nl,2))
		$(t.find('td')[4]).text(tron(a*pr,2))
		$(t.find('td')[5]).text(tron(a*gl,2))
		$(t.find('td')[6]).text(tron(a*lp,2))
		$(t.find('td')[7]).text(tron(a*canxi,2))
		$(t.find('td')[8]).text(tron(a*sat,2))
		$(t.find('td')[9]).text(tron(a*kem,2))
		$(t.find('td')[10]).text(tron(a*xo,2))
		cm_total_nang_luong_1();
	})
})
function cm_total_nang_luong_1(){
	var nang_luong=protein=glucid=lipid=canxi=sat=kem=xo=0;
	$('.cm-them_thu_don-chon_nguyen__lieu-chitiet tbody tr').each(function(){
		var t=$(this).find('td');
		nang_luong+=Number($(t[3]).text()); 
		nang_luong=tron(nang_luong,2)
		protein+=Number($(t[4]).text()); 
		protein=tron(protein,2)
		glucid+=Number($(t[5]).text());
		glucid=tron(glucid,2) 
		lipid+=Number($(t[6]).text());
		lipid=tron(lipid,2) 
		canxi+=Number($(t[7]).text());
		canxi=tron(canxi,2) 
		sat+=Number($(t[8]).text()); 
		sat=tron(sat,2)
		kem+=Number($(t[9]).text());
		kem=tron(kem,2) 
		xo+=Number($(t[10]).text());
		xo=tron(xo,2) 
	})
	$('.cm-them_thu_don-chon_nguyen__lieu-tong_nl').text(nang_luong);
	$('.cm-them_thu_don-chon_nguyen__lieu-tong_protein').text(protein);
	$('.cm-them_thu_don-chon_nguyen__lieu-tong_glucid').text(glucid);
	$('.cm-them_thu_don-chon_nguyen__lieu-tong_lipid').text(lipid);
	$('.cm-them_thu_don-chon_nguyen__lieu-tong_canxi').text(canxi);
	$('.cm-them_thu_don-chon_nguyen__lieu-tong_sat').text(sat);
	$('.cm-them_thu_don-chon_nguyen__lieu-tong_kem').text(kem);
	$('.cm-them_thu_don-chon_nguyen__lieu-tong_xo').text(xo);
}



	// Tìm kiếm món ăn
	var search_nl = jQuery('#search-tra_cuu_2');
	var typingTimer1;              
	var doneTypingInterval1 = 1000;

	//on keyup, start the countdown
	search_nl.on('keyup', function () {
		clearTimeout(typingTimer1);
		typingTimer1 = setTimeout(searchma, doneTypingInterval1);
	});

 	//on keydown, clear the countdown 
 	search_nl.on('keydown', function () {
 		clearTimeout(typingTimer1);
 	});
 	function searchma() {
 		var data=$('#search-tra_cuu_2').val().trim().toLowerCase();
 		$('.truong_them__mon__an_ct_m_tb2 .cm_ten_mon_an_2103 label').each(function(){
 			var b=$(this).parent().parent();
 			var a=$(this).text().trim().toLowerCase();
 			if(a.indexOf(data)== -1){
 				b.hide();
 			}
 			else{
 				b.show();
 			}
 		})
 	}
 	// Tìm kiếm nguyên liệu
 	var search_nl = jQuery('#search-tra_cuu_3');
 	var typingTimer1;              
 	var doneTypingInterval1 = 1000;

	//on keyup, start the countdown
	search_nl.on('keyup', function () {
		clearTimeout(typingTimer1);
		typingTimer1 = setTimeout(searchnl34, doneTypingInterval1);
	});

 	//on keydown, clear the countdown 
 	search_nl.on('keydown', function () {
 		clearTimeout(typingTimer1);
 	});
 	function searchnl34() {
 		var data=$('#search-tra_cuu_3').val().trim().toLowerCase();
 		$('.truong_chon_nguyen_lieu_71220_1ct_tb label').each(function(){
 			var b=$(this).parent().parent();
 			var a=$(this).text().trim().toLowerCase();
 			if(a.indexOf(data)== -1){
 				b.hide();
 			}
 			else{
 				b.show();
 			}
 		})
 	}

 	$('.cm_tao_new_mon_an').click(function(e){
 		e.preventDefault();
 		var ten=$('.cm-them_thu_don-chon_nguyen__lieu-header.truong_tao_mon_an_header input').val().trim();
 		if(ten ==""){
 			alert("Món ăn chưa có tên");
 		} else if($('.cm_truong_mon_an_ten_1').size()==0){
 			alert("Món ăn chưa có nguyên liệu");
 		} else{
 			$.ajax({
 				type:"POST",
 				url:domain+'/wp-content/plugins/caremeal/view/shortcode/thuc_don/phu_huynh/js/ajax/save-mon-an.php',
 				data:{
 					'ten':ten,
 					'nang_luong': $('.cm-them_thu_don-chon_nguyen__lieu-tong_nl').text().trim(),
 					'protein':$('.cm-them_thu_don-chon_nguyen__lieu-tong_protein').text().trim(),
 					'glucid':$('.cm-them_thu_don-chon_nguyen__lieu-tong_glucid').text().trim(),
 					'lipid':$('.cm-them_thu_don-chon_nguyen__lieu-tong_lipid').text().trim(),
 					'canxi':$('.cm-them_thu_don-chon_nguyen__lieu-tong_canxi').text().trim(),
 					'sat':$('.cm-them_thu_don-chon_nguyen__lieu-tong_sat').text().trim(),
 					'kem':$('.cm-them_thu_don-chon_nguyen__lieu-tong_kem').text().trim(),
 					'xo':$('.cm-them_thu_don-chon_nguyen__lieu-tong_xo').text().trim()
 				},
 				success:function(response){ 
 					if (response == 1) {
 						alert("Tên món ăn đã tồn tại")
 					} else if( response ==0){
 						alert("Thêm món ăn thất bại");
 					} else if(response==2){
 						alert("Thêm món ăn thành công");
 						location.href="https://caremeal.vn/thuc-don/";
 						setTimeout(function(){ 
 							$('.cm-truong_them').trigger('click');
 						}, 3000);
 					}
 				}
 			});
 		}
 	})
 	$('#dt').click(function(){
 		d=new Date(document.getElementById("dt").value);
 		dt=d.getDate();
 		mn=d.getMonth();
 		mn++;
 		yy=d.getFullYear(); 
 		if(dt<10){
 			if(mn<10){
 				document.getElementById("ndt").value="0"+dt+"/0"+mn+"/"+yy;
 			}
 			else{
 				document.getElementById("ndt").value="0"+dt+"/"+mn+"/"+yy;
 			}
 		}else if(mn<10){
 			document.getElementById("ndt").value=dt+"/0"+mn+"/"+yy;
 		} else{
 			document.getElementById("ndt").value=dt+"/"+mn+"/"+yy;
 		}
 		day=d.getDay();		 
 		document.getElementById("day").value=day;
 	});
 	jQuery('input[type="date"]').change(function(){
 		var cmdate=jQuery('input[type="date"]').val().trim();
 		cmdate=cmdate.split('-');
 		cmdate=cmdate[2]+'/'+cmdate[1]+'/'+cmdate[0];
 		jQuery('input[name="ngay"]').val(cmdate);
 	}); 
 	$('.cm_add_thuc_don').click(function(e){
 		e.preventDefault();
 		var mon_an="";
 		$('.cm_truong_mon_an_ten').each(function(){
 			mon_an+=$(this).text().trim()+",";
 		})
 		var ngay=$('#ndt').val().trim();
 		if(ngay ==""){
 			alert("Chưa chọn ngày cho thực đơn");
 		} else if($('.cm_truong_mon_an_ten').size()==0){
 			alert("Thực đơn chưa có món ăn");
 		} else{
 			$.ajax({
 				type:"POST",
 				url:domain+'/wp-content/plugins/caremeal/view/shortcode/thuc_don/phu_huynh/js/ajax/save-thong-ke.php',
 				data:{
 					'user_id':$('.cm_id_hoc_sinh').text().trim(),
 					'ngay':ngay,
 					'mon_an': mon_an,
 					'bua_an':$('.cm_chon_mon_area select option:selected').val().trim(),
 					'nang_luong':$('.cm-total_nang_luong').text().trim(),
 					'protein':$('.cm-total_protein').text().trim(),
 					'glucid':$('.cm-total_glucid').text().trim(),
 					'lipid':$('.cm-total_lipid').text().trim(),
 					'canxi':$('.cm-total_canxi').text().trim(),
 					'sat':$('.cm-total_sat').text().trim(),
 					'kem':$('.cm-total_kem').text().trim(),
 					'xo':$('.cm-total_xo').text().trim(),
 				},
 				success:function(response){
 					if (response == 1) {
 						alert("Thêm thành công") 						
 						location.href="https://caremeal.vn/thuc-don/";
 					} else if( response ==2){
 						alert("Thêm thất bại, bữa ăn đã tồn tại");
 					} else if(response==3){
 						alert("Bữa ăn đã tồn tại trong ngày");
 					}
 				}
 			});
 		}
 	})
 	$('.ph_td_today_main_ct >div >a').click(function(e){
 		var t= $(this).parent();
 		e.preventDefault();
 		$('.ph_td_today_main_ct >div >a.active').removeClass('active');
 		$(this).addClass('active');
 		$('.ph_td_today_main_ct >div >div.active').removeClass('active')
 		t.find('> div').addClass('active');
 	})
 	$('.ph_td_today_main_ct p a').click(function(e){
 		e.preventDefault();
 		$('.cm-truong_them').trigger('click');
 	})
 	$('.cm_tab a').each(function(){
 		$(this).click(function(e){			
 			e.preventDefault();
 			$('.cm_tab .active').removeClass('active');
 			$(this).addClass('active');
 			var a=$(this).attr('id').trim()+'_ct'; 
 			$('.cm_tab_ct > div').each(function(){
 				if($(this).attr('id')==a){
 					$('.cm_tab_ct .active').removeClass('active');
 					$(this).addClass('active');
 				} 
 			})
 		})
 	})
 	$('.cm_tab_ct ul').each(function(){
 		$($(this).find('li')[0]).addClass('cm-active');
 	})
 	$('.cm_tab_content_tuan').each(function(){
 		$($(this).find('>div')[0]).addClass('cm-active_1');
 	})
 	$('.cm_tab_ct > div').each(function(){
 		var a=$(this);
 		a.find('li').each(function(){
 			$(this).click(function(){
 				var t=$(this).attr('id').trim()+'_ct'; 
 				a.find('.cm-active').removeClass('cm-active');
 				$(this).addClass('cm-active');	
 				$(a.find('.cm_tab_content_tuan > div')).each(function(){
 					if($(this).attr('id')==t){
 						a.find('.cm-active_1').removeClass('cm-active_1');
 						$(this).addClass('cm-active_1');
 					}
 				});

 			});
 		});
 	});
	// Cập nhật thông tin học sinh
	$('.cm_ten_hoc_sinh a').click(function(e){
		e.preventDefault();
		$('.cm_thong_tin_hs').append('<div class="cm_update_profile"><div class="cm_update_profile_ct"></div></div>')
		$('.cm_update_profile_ct').append('<div class="cm_update_profile_chieu_cao"></div>')
		$('.cm_update_profile_chieu_cao').append('<h6>Chiều cao</h6><input type="number" name="update_chieu_cao">')
		$('.cm_update_profile_ct').append('<div class="cm_update_profile_can_nang"></div>')
		$('.cm_update_profile_can_nang').append('<h6>Cân nặng</h6><input type="number" name="update_can_nang">')
		$('.cm_update_profile_ct').append('<div class="cm_update_profile_btn"></div>')
		$('.cm_update_profile_btn').append('<a href="#">Cập nhật</a>')
		$('.cm_update_profile_btn a').click(function(e){
			e.preventDefault();
			$.ajax({
				type:"POST",
				url:domain+'/wp-content/plugins/caremeal/view/shortcode/thuc_don/phu_huynh/js/ajax/cap_nhat_thong_tin.php',
				data:{
					'id':$('#cm_us_id').text().trim(),
					'chieu_cao': $('.cm_update_profile_chieu_cao input[name="update_chieu_cao"]').val().trim(),
					'can_nang' :$('.cm_update_profile_can_nang input[name="update_can_nang"]').val().trim()
				},
				success:function(response){  
					alert ('Thêm thành công');
					window.location.reload(true);
				},
				error:function(){
					alert ('Thêm thất bại');
				}
			});
		})
	})
	//THÊM THỰC ĐƠN MẪU
	$('.cm_tao_thuc_don_mau_btn').click(function(){
		alert("Không tìm thấy dữ liệu")
	})
	//Xóa món ăn
	$('.cm_delete_mon_an').click(function(e){
		e.preventDefault();
		let cm_tt=$(this).parent().parent().parent().parent().parent();
		let cm_tt_tr=$(this).parent().parent();	
		let cm_mon_an_no_nang_luong_total=cm_mon_an_no_protein_total=cm_mon_an_no_glucid_total=cm_mon_an_no_lipid_total=cm_mon_an_no_can_xi_total=cm_mon_an_no_sat_total=cm_mon_an_no_kem_total=cm_mon_an_no_xo_total=0;
		cm_mon_an_no_nang_luong_total=tron(Number($($('.nhucau_check_4123').find('td')[0]).text().trim())-Number($(cm_tt_tr.find('td')[2]).text().trim()),2);
		cm_mon_an_no_protein_total=tron(Number($($('.nhucau_check_4123').find('td')[1]).text().trim())-Number($(cm_tt_tr.find('td')[3]).text().trim()),2);
		cm_mon_an_no_glucid_total=tron(Number($($('.nhucau_check_4123').find('td')[2]).text().trim())-Number($(cm_tt_tr.find('td')[4]).text().trim()),2);
		cm_mon_an_no_lipid_total=tron(Number($($('.nhucau_check_4123').find('td')[3]).text().trim())-Number($(cm_tt_tr.find('td')[5]).text().trim()),2);
		cm_mon_an_no_can_xi_total=tron(Number($($('.nhucau_check_4123').find('td')[4]).text().trim())-Number($(cm_tt_tr.find('td')[6]).text().trim()),2);
		cm_mon_an_no_sat_total=tron(Number($($('.nhucau_check_4123').find('td')[5]).text().trim())-Number($(cm_tt_tr.find('td')[7]).text().trim()),2);
		cm_mon_an_no_kem_total=tron(Number($($('.nhucau_check_4123').find('td')[6]).text().trim())-Number($(cm_tt_tr.find('td')[8]).text().trim()),2);
		cm_mon_an_no_xo_total=tron(Number($($('.nhucau_check_4123').find('td')[7]).text().trim())-Number($(cm_tt_tr.find('td')[9]).text().trim()),2);
		$($('.nhucau_check_4123').find('td')[0]).text(cm_mon_an_no_nang_luong_total);
		$($('.nhucau_check_4123').find('td')[1]).text(cm_mon_an_no_protein_total);
		$($('.nhucau_check_4123').find('td')[2]).text(cm_mon_an_no_glucid_total);
		$($('.nhucau_check_4123').find('td')[3]).text(cm_mon_an_no_lipid_total);
		$($('.nhucau_check_4123').find('td')[4]).text(cm_mon_an_no_can_xi_total);
		$($('.nhucau_check_4123').find('td')[5]).text(cm_mon_an_no_sat_total);
		$($('.nhucau_check_4123').find('td')[6]).text(cm_mon_an_no_kem_total);
		$($('.nhucau_check_4123').find('td')[7]).text(cm_mon_an_no_xo_total);
		cm_tt_tr.remove();
		let cm_tt_check_bua_an=cm_tt.attr('class');
		if(cm_tt_check_bua_an.indexOf("ph_td_menu_s_ct_1")>-1){
			cm_tt_check_bua_an="an_sang";
		} else if(cm_tt_check_bua_an.indexOf("ph_td_menu_s_ct_2")>-1){
			cm_tt_check_bua_an="an_trua";
		}else if(cm_tt_check_bua_an.indexOf("ph_td_menu_s_ct_3")>-1){
			cm_tt_check_bua_an="an_toi";
		}else if(cm_tt_check_bua_an.indexOf("ph_td_menu_s_ct_4")>-1){
			cm_tt_check_bua_an="phu_toi";
		}
		let cm_mon_an_no_dele="";
		let cm_mon_an_no_nang_luong=cm_mon_an_no_protein=cm_mon_an_no_glucid=cm_mon_an_no_lipid=cm_mon_an_no_can_xi=cm_mon_an_no_sat=cm_mon_an_no_kem=cm_mon_an_no_xo=0;		
		if(cm_tt.find('tbody tr').size()>0){
			cm_tt.find('tbody tr').each(function(){
				cm_mon_an_no_dele += $($(this).find('td')[1]).text().trim() + ",";
				cm_mon_an_no_nang_luong +=tron(Number($($(this).find('td')[2]).text().trim()),2);
				cm_mon_an_no_protein +=tron(Number($($(this).find('td')[3]).text().trim()),2);
				cm_mon_an_no_glucid +=tron(Number($($(this).find('td')[4]).text().trim()),2);
				cm_mon_an_no_lipid +=tron(Number($($(this).find('td')[5]).text().trim()),2);
				cm_mon_an_no_can_xi +=tron(Number($($(this).find('td')[6]).text().trim()),2);
				cm_mon_an_no_sat +=tron(Number($($(this).find('td')[7]).text().trim()),2);
				cm_mon_an_no_kem +=tron(Number($($(this).find('td')[8]).text().trim()),2);
				cm_mon_an_no_xo +=tron(Number($($(this).find('td')[9]).text().trim()),2);
				$(cm_tt.find('tfoot th')[2]).text(tron(cm_mon_an_no_nang_luong,2));
				$(cm_tt.find('tfoot th')[3]).text(tron(cm_mon_an_no_protein,2));
				$(cm_tt.find('tfoot th')[4]).text(tron(cm_mon_an_no_glucid,2));
				$(cm_tt.find('tfoot th')[5]).text(tron(cm_mon_an_no_lipid,2));
				$(cm_tt.find('tfoot th')[6]).text(tron(cm_mon_an_no_can_xi,2));
				$(cm_tt.find('tfoot th')[7]).text(tron(cm_mon_an_no_sat,2));
				$(cm_tt.find('tfoot th')[8]).text(tron(cm_mon_an_no_kem,2));
				$(cm_tt.find('tfoot th')[9]).text(tron(cm_mon_an_no_xo,2));
			})
		}
		else{
			cm_mon_an_no_nang_luong=cm_mon_an_no_protein=cm_mon_an_no_glucid=cm_mon_an_no_lipid=cm_mon_an_no_can_xi=cm_mon_an_no_sat=cm_mon_an_no_kem=cm_mon_an_no_xo=0;
			$(cm_tt.find('tfoot th')[2]).text(tron(cm_mon_an_no_nang_luong,2));
			$(cm_tt.find('tfoot th')[3]).text(tron(cm_mon_an_no_protein,2));
			$(cm_tt.find('tfoot th')[4]).text(tron(cm_mon_an_no_glucid,2));
			$(cm_tt.find('tfoot th')[5]).text(tron(cm_mon_an_no_lipid,2));
			$(cm_tt.find('tfoot th')[6]).text(tron(cm_mon_an_no_can_xi,2));
			$(cm_tt.find('tfoot th')[7]).text(tron(cm_mon_an_no_sat,2));
			$(cm_tt.find('tfoot th')[8]).text(tron(cm_mon_an_no_kem,2));
			$(cm_tt.find('tfoot th')[9]).text(tron(cm_mon_an_no_xo,2));
		}
		$.ajax({
			type:"POST",
			url:domain+'/wp-content/plugins/caremeal/view/shortcode/thuc_don/phu_huynh/js/ajax/delete_mon_an.php',
			data:{
				'id':$('#cm_us_id').text().trim(),
				'ngay': $($('.cm_truong_td_today h3 span')[1]).text().trim(),
				'bua_an':cm_tt_check_bua_an,
				'mon_an': cm_mon_an_no_dele,
				'nang_luong':cm_mon_an_no_nang_luong,
				'protein':cm_mon_an_no_protein,
				'glucid':cm_mon_an_no_glucid,
				'lipid':cm_mon_an_no_lipid,
				'canxi': cm_mon_an_no_can_xi,
				'sat':cm_mon_an_no_sat,
				'kem': cm_mon_an_no_kem,
				'xo': cm_mon_an_no_xo,
				'tong_nang_luong':cm_mon_an_no_nang_luong_total,
				'tong_protein':cm_mon_an_no_protein_total,
				'tong_glucid':cm_mon_an_no_glucid_total,
				'tong_lipid': cm_mon_an_no_lipid_total,
				'tong_canxi': cm_mon_an_no_can_xi_total,
				'tong_sat': cm_mon_an_no_sat_total,
				'tong_kem':cm_mon_an_no_kem_total,
				'tong_xo': cm_mon_an_no_xo_total
			},
			success:function(response){ 
				alert ('Đã xóa món ăn');
				window.location.reload(true);
			},
			error:function(){
				alert ('Xóa thất bại');
			}
		});
	})
    //Xóa món ăn
    $('.cm_delete_mon_an_month').click(function(e){
    	e.preventDefault();
    	let cm_tt=$(this).parent().parent().parent().parent().parent();
    	let cm_tt_t=$(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().addClass('â');
    	let cm_tt_tt=cm_tt_t.find('.nhucau_check_4123');
    	cm_tt_tt.addClass('lllls')
    	let cm_tt_tr=$(this).parent().parent();	
    	let cm_mon_an_no_nang_luong_total=cm_mon_an_no_protein_total=cm_mon_an_no_glucid_total=cm_mon_an_no_lipid_total=cm_mon_an_no_can_xi_total=cm_mon_an_no_sat_total=cm_mon_an_no_kem_total=cm_mon_an_no_xo_total=0;
    	cm_mon_an_no_nang_luong_total=tron(Number($(cm_tt_tt.find('td')[0]).text().trim())-Number($(cm_tt_tr.find('td')[2]).text().trim()),2);
    	cm_mon_an_no_protein_total=tron(Number($(cm_tt_tt.find('td')[1]).text().trim())-Number($(cm_tt_tr.find('td')[3]).text().trim()),2);
    	cm_mon_an_no_glucid_total=tron(Number($(cm_tt_tt.find('td')[2]).text().trim())-Number($(cm_tt_tr.find('td')[4]).text().trim()),2);
    	cm_mon_an_no_lipid_total=tron(Number($(cm_tt_tt.find('td')[3]).text().trim())-Number($(cm_tt_tr.find('td')[5]).text().trim()),2);
    	cm_mon_an_no_can_xi_total=tron(Number($(cm_tt_tt.find('td')[4]).text().trim())-Number($(cm_tt_tr.find('td')[6]).text().trim()),2);
    	cm_mon_an_no_sat_total=tron(Number($(cm_tt_tt.find('td')[5]).text().trim())-Number($(cm_tt_tr.find('td')[7]).text().trim()),2);
    	cm_mon_an_no_kem_total=tron(Number($(cm_tt_tt.find('td')[6]).text().trim())-Number($(cm_tt_tr.find('td')[8]).text().trim()),2);
    	cm_mon_an_no_xo_total=tron(Number($(cm_tt_tt.find('td')[7]).text().trim())-Number($(cm_tt_tr.find('td')[9]).text().trim()),2);
    	$(cm_tt_tt.find('td')[0]).text(cm_mon_an_no_nang_luong_total);
    	$(cm_tt_tt.find('td')[1]).text(cm_mon_an_no_protein_total);
    	$(cm_tt_tt.find('td')[2]).text(cm_mon_an_no_glucid_total);
    	$(cm_tt_tt.find('td')[3]).text(cm_mon_an_no_lipid_total);
    	$(cm_tt_tt.find('td')[4]).text(cm_mon_an_no_can_xi_total);
    	$(cm_tt_tt.find('td')[5]).text(cm_mon_an_no_sat_total);
    	$(cm_tt_tt.find('td')[6]).text(cm_mon_an_no_kem_total);
    	$(cm_tt_tt.find('td')[7]).text(cm_mon_an_no_xo_total);
    	cm_tt_tr.remove();
    	let cm_tt_check_bua_an=cm_tt.attr('class');
    	if(cm_tt_check_bua_an.indexOf("ph_td_menu_s_ct_1")>-1){
    		cm_tt_check_bua_an="an_sang";
    	} else if(cm_tt_check_bua_an.indexOf("ph_td_menu_s_ct_2")>-1){
    		cm_tt_check_bua_an="an_trua";
    	}else if(cm_tt_check_bua_an.indexOf("ph_td_menu_s_ct_3")>-1){
    		cm_tt_check_bua_an="an_toi";
    	}else if(cm_tt_check_bua_an.indexOf("ph_td_menu_s_ct_4")>-1){
    		cm_tt_check_bua_an="phu_toi";
    	}
    	let cm_mon_an_no_dele="";
    	let cm_mon_an_no_nang_luong=cm_mon_an_no_protein=cm_mon_an_no_glucid=cm_mon_an_no_lipid=cm_mon_an_no_can_xi=cm_mon_an_no_sat=cm_mon_an_no_kem=cm_mon_an_no_xo=0;		
    	if(cm_tt.find('tbody tr').size()>0){
    		cm_tt.find('tbody tr').each(function(){
    			cm_mon_an_no_dele += $($(this).find('td')[1]).text().trim() + ",";
    			cm_mon_an_no_nang_luong +=tron(Number($($(this).find('td')[2]).text().trim()),2);
    			cm_mon_an_no_protein +=tron(Number($($(this).find('td')[3]).text().trim()),2);
    			cm_mon_an_no_glucid +=tron(Number($($(this).find('td')[4]).text().trim()),2);
    			cm_mon_an_no_lipid +=tron(Number($($(this).find('td')[5]).text().trim()),2);
    			cm_mon_an_no_can_xi +=tron(Number($($(this).find('td')[6]).text().trim()),2);
    			cm_mon_an_no_sat +=tron(Number($($(this).find('td')[7]).text().trim()),2);
    			cm_mon_an_no_kem +=tron(Number($($(this).find('td')[8]).text().trim()),2);
    			cm_mon_an_no_xo +=tron(Number($($(this).find('td')[9]).text().trim()),2);
    			$(cm_tt.find('tfoot th')[2]).text(tron(cm_mon_an_no_nang_luong,2));
    			$(cm_tt.find('tfoot th')[3]).text(tron(cm_mon_an_no_protein,2));
    			$(cm_tt.find('tfoot th')[4]).text(tron(cm_mon_an_no_glucid,2));
    			$(cm_tt.find('tfoot th')[5]).text(tron(cm_mon_an_no_lipid,2));
    			$(cm_tt.find('tfoot th')[6]).text(tron(cm_mon_an_no_can_xi,2));
    			$(cm_tt.find('tfoot th')[7]).text(tron(cm_mon_an_no_sat,2));
    			$(cm_tt.find('tfoot th')[8]).text(tron(cm_mon_an_no_kem,2));
    			$(cm_tt.find('tfoot th')[9]).text(tron(cm_mon_an_no_xo,2));
    		})
    	}
    	else{
    		cm_mon_an_no_nang_luong=cm_mon_an_no_protein=cm_mon_an_no_glucid=cm_mon_an_no_lipid=cm_mon_an_no_can_xi=cm_mon_an_no_sat=cm_mon_an_no_kem=cm_mon_an_no_xo=0;
    		$(cm_tt.find('tfoot th')[2]).text(tron(cm_mon_an_no_nang_luong,2));
    		$(cm_tt.find('tfoot th')[3]).text(tron(cm_mon_an_no_protein,2));
    		$(cm_tt.find('tfoot th')[4]).text(tron(cm_mon_an_no_glucid,2));
    		$(cm_tt.find('tfoot th')[5]).text(tron(cm_mon_an_no_lipid,2));
    		$(cm_tt.find('tfoot th')[6]).text(tron(cm_mon_an_no_can_xi,2));
    		$(cm_tt.find('tfoot th')[7]).text(tron(cm_mon_an_no_sat,2));
    		$(cm_tt.find('tfoot th')[8]).text(tron(cm_mon_an_no_kem,2));
    		$(cm_tt.find('tfoot th')[9]).text(tron(cm_mon_an_no_xo,2));
    	}

    	$.ajax({
    		type:"POST",
    		url:domain+'/wp-content/plugins/caremeal/view/shortcode/thuc_don/phu_huynh/js/ajax/delete_mon_an.php',
    		data:{
    			'id':$('#cm_us_id').text().trim(),
    			'ngay': cm_tt_t.find('.cm-active span').text().trim().slice(1,11),
    			'bua_an':cm_tt_check_bua_an,
    			'mon_an': cm_mon_an_no_dele,
    			'nang_luong':cm_mon_an_no_nang_luong,
    			'protein':cm_mon_an_no_protein,
    			'glucid':cm_mon_an_no_glucid,
    			'lipid':cm_mon_an_no_lipid,
    			'canxi': cm_mon_an_no_can_xi,
    			'sat':cm_mon_an_no_sat,
    			'kem': cm_mon_an_no_kem,
    			'xo': cm_mon_an_no_xo,
    			'tong_nang_luong':cm_mon_an_no_nang_luong_total,
    			'tong_protein':cm_mon_an_no_protein_total,
    			'tong_glucid':cm_mon_an_no_glucid_total,
    			'tong_lipid': cm_mon_an_no_lipid_total,
    			'tong_canxi': cm_mon_an_no_can_xi_total,
    			'tong_sat': cm_mon_an_no_sat_total,
    			'tong_kem':cm_mon_an_no_kem_total,
    			'tong_xo': cm_mon_an_no_xo_total
    		},
    		success:function(response){ 
    			alert ('Đã xóa món ăn');
    			window.location.reload(true);
    		},
    		error:function(){
    			alert ('Xóa thất bại');
    		}
    	});
    })
    //Chọn Phần ăn
    $('.cm_chon_khau_phan').each(function(){
    	let cm_khau_phan_cha=$(this).parent();
    	let cm_khau_phan_nang_luong=Number($(cm_khau_phan_cha.find('td')[2]).text().trim());
    	let cm_khau_phan_protein=Number($(cm_khau_phan_cha.find('td')[3]).text().trim());
    	let cm_khau_phan_glucid=Number($(cm_khau_phan_cha.find('td')[4]).text().trim());
    	let cm_khau_phan_lipid=Number($(cm_khau_phan_cha.find('td')[5]).text().trim());
    	let cm_khau_phan_canxi=Number($(cm_khau_phan_cha.find('td')[6]).text().trim());
    	let cm_khau_phan_sat=Number($(cm_khau_phan_cha.find('td')[7]).text().trim());
    	let cm_khau_phan_kem=Number($(cm_khau_phan_cha.find('td')[8]).text().trim());
    	let cm_khau_phan_xo=Number($(cm_khau_phan_cha.find('td')[9]).text().trim());
    	$(this).find('input').change(function(){   		  		
    		var cm_chon_khau_phan_cha=$(this).parent().parent().parent();
    		var cm_chon_khau_phan=$(cm_chon_khau_phan_cha.find('input[type="radio"]:checked'));
    		var cm_chon_khau_phan_nl_ch=cm_khau_phan_nang_luong*Number(cm_chon_khau_phan.val());
    		var cm_chon_khau_phan_pro_ch=cm_khau_phan_protein*Number(cm_chon_khau_phan.val());
    		var cm_chon_khau_phan_glu_ch=cm_khau_phan_glucid*Number(cm_chon_khau_phan.val());
    		var cm_chon_khau_phan_li_ch=cm_khau_phan_lipid*Number(cm_chon_khau_phan.val());
    		var cm_chon_khau_phan_ca_ch=cm_khau_phan_canxi*Number(cm_chon_khau_phan.val());
    		var cm_chon_khau_phan_sa_ch=cm_khau_phan_sat*Number(cm_chon_khau_phan.val());
    		var cm_chon_khau_phan_ke_ch=cm_khau_phan_kem*Number(cm_chon_khau_phan.val());
    		var cm_chon_khau_phan_xo_ch=cm_khau_phan_xo*Number(cm_chon_khau_phan.val());
    		$(cm_chon_khau_phan_cha.find('td')[2]).text(tron(cm_chon_khau_phan_nl_ch,2));
    		$(cm_chon_khau_phan_cha.find('td')[3]).text(tron(cm_chon_khau_phan_pro_ch,2));
    		$(cm_chon_khau_phan_cha.find('td')[4]).text(tron(cm_chon_khau_phan_glu_ch,2));
    		$(cm_chon_khau_phan_cha.find('td')[5]).text(tron(cm_chon_khau_phan_li_ch,2));
    		$(cm_chon_khau_phan_cha.find('td')[6]).text(tron(cm_chon_khau_phan_ca_ch,2));
    		$(cm_chon_khau_phan_cha.find('td')[7]).text(tron(cm_chon_khau_phan_sa_ch,2));
    		$(cm_chon_khau_phan_cha.find('td')[8]).text(tron(cm_chon_khau_phan_ke_ch,2));
    		$(cm_chon_khau_phan_cha.find('td')[9]).text(tron(cm_chon_khau_phan_xo_ch,2));
    	})
    });
    function dinh_duong_con_lai(cm_tuan,cm_tuan_n){
    	var a=$('.cm_hs_tuoi span').text().trim();
    	var a1=a.slice(0,4); 
    	var a2=Number(a.slice(5,7));
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
    	var can_nang=Number($('.cm_hs_can_nang span').text().trim());
    	$.ajax({
    		type:"POST",
    		url:domain+'/wp-content/plugins/caremeal/view/shortcode/home/ajax/nhu-cau-nang-luong.php', 
    		data:{
    			'tuoi':tuoi,
    			'gioi_tinh':$('.cm_hs_gioi_tinh span').text().trim().toLowerCase()
    		},
    		success:function(response){ 
    			response = JSON.parse(response); 
    			if (response != 0) {
    				var nl_conlai=tron(Number(response[0].nang_luong*can_nang)-Number($($('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_check_4123 td')[1]).text().trim()),2)
    				if(nl_conlai<-100){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_do">'+nl_conlai+'</td>')
    				} else if(nl_conlai >100){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_vang">'+nl_conlai+'</td>')
    				}else{
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_xanh">'+nl_conlai+'</td>')
    				}		
    				var pro_conlai=tron(Number(response[0].protein*can_nang)-Number($($('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_check_4123 td')[2]).text().trim()),2)
    				if(pro_conlai<-2){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_do">'+pro_conlai+'</td>')
    				} else if(pro_conlai >2){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_vang">'+pro_conlai+'</td>')
    				}else{
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_xanh">'+pro_conlai+'</td>')
    				}		
    				var glu_conlai_arr=response[0].glucid;
    				glu_conlai_arr=glu_conlai_arr.split('-');
    				var glu_conlai_min=tron(Number(glu_conlai_arr[0])-Number($($('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_check_4123 td')[3]).text().trim()),2)
    				var glu_conlai_max=tron(Number(glu_conlai_arr[1])-Number($($('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct.nhucau_check_4123 td')[3]).text().trim()),2)
    				if(glu_conlai_min<0 && glu_conlai_max>0){
    					glu_conlai_min=0;
    				}
    				if(glu_conlai_max<0){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_do">'+glu_conlai_min+'-'+glu_conlai_max+'</td>')
    				} else if(glu_conlai_min >0){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_vang">'+glu_conlai_min+'-'+glu_conlai_max+'</td>')
    				}else{
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_xanh">'+glu_conlai_min+'-'+glu_conlai_max+'</td>')
    				}	
    				var lipid_conlai_arr=response[0].lipid;
    				lipid_conlai_arr=lipid_conlai_arr.split('-');
    				var lipid_conlai_min=tron(Number(lipid_conlai_arr[0])-Number($($('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_check_4123 td')[4]).text().trim()),2)
    				var lipid_conlai_max=tron(Number(lipid_conlai_arr[1])-Number($($('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_check_4123 td')[4]).text().trim()),2)
    				if(lipid_conlai_min<0 && lipid_conlai_max>0){
    					lipid_conlai_min=0;
    				}
    				if(lipid_conlai_max<0){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_do">'+lipid_conlai_min+'-'+lipid_conlai_max+'</td>')
    				} else if(lipid_conlai_min >0){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_vang">'+lipid_conlai_min+'-'+lipid_conlai_max+'</td>')
    				}else{
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_xanh">'+lipid_conlai_min+'-'+lipid_conlai_max+'</td>')
    				}	
    				var canxi_conlai=tron(Number(response[0].canxi)-Number($($('.cm_truong_td_today .nhucau_check_4123 td')[5]).text().trim()),2)
    				if(canxi_conlai<-100){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_do">'+canxi_conlai+'</td>')
    				} else if(canxi_conlai >100){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_vang">'+canxi_conlai+'</td>')
    				}else{
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_xanh">'+canxi_conlai+'</td>')
    				}	
    				var sat_conlai_arr=response[0].sat;
    				sat_conlai_arr=sat_conlai_arr.split('-');
    				var sat_conlai_min=tron(Number(sat_conlai_arr[0])-Number($($('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_check_4123 td')[6]).text().trim()),2)
    				var sat_conlai_max=tron(Number(sat_conlai_arr[1])-Number($($('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_check_4123 td')[6]).text().trim()),2)
    				if(sat_conlai_min<0 && sat_conlai_max>0){
    					sat_conlai_min=0;
    				}
    				if(sat_conlai_max<0){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_do">'+sat_conlai_min+'-'+sat_conlai_max+'</td>')
    				} else if(sat_conlai_min >0){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_vang">'+sat_conlai_min+'-'+sat_conlai_max+'</td>')
    				}else{
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_xanh">'+sat_conlai_min+'-'+sat_conlai_max+'</td>')
    				}	
    				var kem_conlai_arr=response[0].sat;
    				kem_conlai_arr=kem_conlai_arr.split('-');
    				var kem_conlai_min=tron(Number(kem_conlai_arr[0])-Number($($('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_check_4123 td')[7]).text().trim()),2)
    				var kem_conlai_max=tron(Number(kem_conlai_arr[1])-Number($($('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_check_4123 td')[7]).text().trim()),2)
    				if(kem_conlai_min<0 && kem_conlai_max>0){
    					kem_conlai_min=0;
    				}
    				if(kem_conlai_max<0){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_do">'+kem_conlai_min+'-'+kem_conlai_max+'</td>')
    				} else if(kem_conlai_min >0){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_vang">'+kem_conlai_min+'-'+kem_conlai_max+'</td>')
    				}else{
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_xanh">'+kem_conlai_min+'-'+kem_conlai_max+'</td>')
    				}	
    				var xo_conlai=response[0].xo;
    				xo_conlai=xo_conlai.split('-');
    				var xo_conlai_min=tron(Number(xo_conlai[0])-Number($($('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_check_4123 td')[8]).text().trim()),2)
    				var xo_conlai_max=tron(Number(xo_conlai[1])-Number($($('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct.nhucau_check_4123 td')[8]).text().trim()),2)
    				if(xo_conlai_min<0 && xo_conlai_max>0){
    					xo_conlai_min=0;
    				}
    				if(xo_conlai_max<0){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_do">'+xo_conlai_min+'-'+xo_conlai_max+'</td>')
    				} else if(xo_conlai_min >0){
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_vang">'+xo_conlai_min+'-'+xo_conlai_max+'</td>')
    				}else{
    					$('#nd_tuan_'+cm_tuan+'_'+cm_tuan_n+'_ct .nhucau_con_lai_4124').append('<td class="cm_xanh">'+xo_conlai_min+'-'+xo_conlai_max+'</td>')
    				}	
    			}
    		},
    		error: function(){
    			alert("Không tìm thấy dữ liệu");
    		}
    	});	
}
dinh_duong_con_lai(1,1);
dinh_duong_con_lai(1,2);
dinh_duong_con_lai(1,3);
dinh_duong_con_lai(1,4);
dinh_duong_con_lai(1,5);
dinh_duong_con_lai(1,6);
dinh_duong_con_lai(1,7);
dinh_duong_con_lai(2,8);
dinh_duong_con_lai(2,9);
dinh_duong_con_lai(2,10);
dinh_duong_con_lai(2,11);
dinh_duong_con_lai(2,12);
dinh_duong_con_lai(2,13);
dinh_duong_con_lai(2,14);
dinh_duong_con_lai(3,15);
dinh_duong_con_lai(3,16);
dinh_duong_con_lai(3,17);
dinh_duong_con_lai(3,18);
dinh_duong_con_lai(3,19);
dinh_duong_con_lai(3,20);
dinh_duong_con_lai(3,21);
dinh_duong_con_lai(4,22);
dinh_duong_con_lai(4,23);
dinh_duong_con_lai(4,24);
dinh_duong_con_lai(4,25);
dinh_duong_con_lai(4,26);
dinh_duong_con_lai(4,27);
dinh_duong_con_lai(4,28);
dinh_duong_con_lai(5,29);
dinh_duong_con_lai(5,30);
dinh_duong_con_lai(5,31);
 	// BIỂU ĐỒ
 	var nang_luong_11=jQuery('#cm_nang_luong_1').text().trim().split(" ");
 	var ngay_11=jQuery('#cm_ngay_1').text().trim().split(" ");
 	for(var i=0;i<nang_luong_11.length;i++){
 		nang_luong_11[i]=Number(nang_luong_11[i]);
 	}
 	var protein_11=jQuery('#cm_protein_1').text().trim().split(" ");
 	for(var i=0;i<protein_11.length;i++){
 		protein_11[i]=Number(protein_11[i]);
 	}
 	var glucid_11=jQuery('#cm_glucid_1').text().trim().split(" ");
 	for(var i=0;i<glucid_11.length;i++){
 		glucid_11[i]=Number(glucid_11[i]);
 	}
 	var lipid_11=jQuery('#cm_lipid_1').text().trim().split(" ");
 	for(var i=0;i<lipid_11.length;i++){
 		lipid_11[i]=Number(lipid_11[i]);
 	}
 	Highcharts.chart('container', {
 		chart: {
 			type: 'line'
 		},
 		title: {
 			text: ''
 		},
 		subtitle: {
 			text: ''
 		},
 		xAxis: {
 			categories: ngay_11
 		},
 		yAxis: {
 			title: {
 				text: '(Kcal)'
 			},
 			min: 0
 		},
 		plotOptions: {
 			line: {
 				dataLabels: {
 					enabled: false
 				},
 				enableMouseTracking: true
 			}
 		},
 		series: [{
 			name: 'Năng Lượng',
 			data: nang_luong_11
 		}]
 	});
 	Highcharts.chart('container_1', {
 		chart: {
 			type: 'line'
 		},
 		title: {
 			text: ''
 		},
 		subtitle: {
 			text: ''
 		},
 		xAxis: {
 			categories: ngay_11
 		},
 		yAxis: {
 			title: {
 				text: '(g)'
 			},
 			min: 0
 		},
 		plotOptions: {
 			line: {
 				dataLabels: {
 					enabled: false
 				},
 				enableMouseTracking: true
 			}
 		},
 		series: [{
 			name: 'Protein',
 			data: protein_11
 		},
 		{
 			name: 'Glucid',
 			data: glucid_11
 		},
 		{
 			name: 'Lipid',
 			data: lipid_11
 		}]
 	});
 	
 })(jQuery);