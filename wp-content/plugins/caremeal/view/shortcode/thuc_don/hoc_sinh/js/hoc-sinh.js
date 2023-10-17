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
	$(window).load(function(){
		var bmi=can_nang=chieu_cao="0";
		can_nang=Number($('.cm_hs_can_nang span').text().trim());
		chieu_cao=Number($('.cm_hs_chieu_cao span').text().trim());
		bmi=roundNumber(can_nang/(chieu_cao*chieu_cao),2);
		$('#bmi').show();
		tinh_bmi(bmi);		
	})

	//Tính BMI
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
		$.ajax({
			type:"POST",
			url:domain+'/wp-content/plugins/caremeal/view/shortcode/home/ajax/nhu-cau-nang-luong.php', 
			data:{
				'tuoi':tuoi,
				'gioi_tinh':$('.cm_hs_gioi_tinh span').text().trim().toLowerCase()
			},
			success:function(response){
				if (response != 0) {
					response = JSON.parse(response); console.log(response);
					for(j=0;j < response.length;j++){
						if(i<response[j].sd1){
							$('#bmi').append('<h5>BMI = '+i+'</h5><p>Trẻ suy dinh dưỡng thể nhẹ cân, mức độ nặng, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');
						} else if(i<response[j].sd2){
							$('#bmi').append('<h5>BMI = '+i+'</h5><p>Trẻ suy dinh dưỡng thể nhẹ cân, mức độ vừa, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');

						} else if(i<response[j].sd5){
							$('.cm_thong_tin_hs h3').append('<span class="cm_tre_tuoi">     '+tuoi_1+' tuổi '+thang_1+' tháng</span>');
							$('#bmi').append('<div class="cm-nhucau-hang-ngay"></div>');							
							$('.cm-nhucau-hang-ngay').append('<h5>Nhu cầu dinh dưỡng hàng ngày</h5>');
							$('.cm-nhucau-hang-ngay').append('<p><span><b>Năng lượng: </b><i>'+roundNumber(response[j].nang_luong*can_nang,2)+'</i>kcal</span><span><b>Protein: </b><i>'+roundNumber(response[j].protein*can_nang,2)+'</i>g</span><span><b>Glucid: </b><i>'+response[j].glucid+'</i>g</span><span><b>Lipid: </b><i>'+response[j].lipid+'</i>g</span><span><b>Sắt: </b><i>'+response[j].sat+'</i>g</span><span><b>Kẽm: </b><i>'+response[j].kem+'</i>g</span><span><b>Canxi: </b><i>'+response[j].canxi+'</i>g</span><span><b>Chất xơ: </b><i>'+response[j].xo+'</i>g</span><p>');

						}  else if(i<response[j].sd6){
							$('#bmi').append('<h5>BMI = '+i+'</h5><p>Trẻ thừa cân, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');

						} else{
							$('#bmi').append('<h5>BMI = '+i+'</h5><p>Trẻ béo phì, hãy <a href="/dat-lich-tu-van/">liên hệ</a> với chuyên gia để được tư vấn</p>');

						}return bmi_kq;

					}
				}else{alert("Chương trình chỉ hỗ trợ độ tuổi từ 6-18 tuổi, vui lòng nhập lại dữ liệu")}
			},
			error: function(){
				alert("Không tìm thấy dữ liệu");
			}
		});			
	}
	$('.ph_td_today_main_ct >div >a').click(function(e){
		var t= $(this).parent();
		e.preventDefault();
		$('.ph_td_today_main_ct >div >a.active').removeClass('active');
		$(this).addClass('active');
		$('.ph_td_today_main_ct >div >div.active').removeClass('active')
		t.find('> div').addClass('active');
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
 				text: 'Năng lượng (kcal)'
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