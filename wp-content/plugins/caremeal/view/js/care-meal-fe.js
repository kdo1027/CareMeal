(function($){
	let domain_fe="https://"+location.hostname;
	var width = $(window).width();
	if(width<768){
	//Tra cứu bằng hình ảnh		
	$('.tk-box').append('<form enctype="multipart/form-data" action="/image" method="post"><input type="file" accept="image/*" capture="camera" / style="display:none" class="cm_camera_ip"></form><i class="fa fa-camera cm_camera"></i>');
	$('#results').append('<div class="container js-file-list" style="display:none"></div> ')
	$('.cm_camera').click(function(){
		$('.cm_camera_ip').trigger('click');
	})
	$('.cm_camera_ip').on('change', function() {
		var file = $(this)[0].files[0];
		var fileReader = new FileReader();
		fileReader.onload = function() {
			$('.js-file-list').html("");
			var str = '<div class="col-md-2"><img class="img-thumbnail js-file-image" style="width: 100%; height: 100%"></div>';
			$('.js-file-list').append(str);
			var imageSrc = event.target.result;
			$('.js-file-image').attr('src', imageSrc);
			$('.page_loader_container').css({
				"opacity":"0.8",
				"display":"block"
			});
			const classifier = ml5.imageClassifier('MobileNet', (err, model) => {
				console.log('Model Loaded!');
			});
			const image = document.querySelector(".js-file-image");
			classifier.predict(image, (err, results) => {
				if (err) {
					console.error(err);
				} else {
					var a=results[0].label;
					switch(a){
						case "banana":
						a="chuối tiêu";
						break;
						case "orange":
						a="cam";
						break;
						case "lemon":
						a="cam";
						break;
						case "French loaf":
						a="Cà rốt";
						break;
						case "croquet ball":
						case "acorn squash":
						case "Granny Smith":
						a="Táo tây";
						break;
						case "zucchini, courgette":
						a="Dưa chuột";
						$('#search-tra_cuu').val(a);
						break;
						case "wool, woolen, woollen":
						case "purse":
						case "bath towel":
						a="Thịt lợn";
						
						break;
						case "oil filter":
						case "radio, wireless":
						case "digital clock":
						case "pop bottle, soda bottle":
						case "pill bottle":
						case "brass, memorial tablet, plaque":
						case "packet":
						{
							a="";
							$('.tk-box').append('<div class="cm_thong_tin_sua"><h6>Sữa tươi tiệt trùng Vinamilk 100%(Có đường) 180ml</h6></div>');
							$('.cm_thong_tin_sua').append("<p>Năng lượng: 72.8 kcal</p>");
							$('.cm_thong_tin_sua').append("<p>Chất béo: 5 g</p>")
							$('.cm_thong_tin_sua').append("<p>Protein: 3 g</p>")
							$('.cm_thong_tin_sua').append("<p>Canxi: 103 mg</p>")
							break;
						}
						// case "packet":
						// {
						// 	a="";
						// 	$('.tk-box').append('<div class="cm_thong_tin_sua"><h6>Bánh Choco Pie</h6></div>');
						// 	$('.cm_thong_tin_sua').append("<p>Năng lượng: 140 kcal</p>");
						// 	$('.cm_thong_tin_sua').append("<p>Chất béo: 3.6 g</p>")
						// 	$('.cm_thong_tin_sua').append("<p>Chất đạm: 1 g</p>")
						// 	$('.cm_thong_tin_sua').append("<p>Canxi: 16 mg</p>")
						// 	$('.cm_thong_tin_sua').append("<p>Sắt: 1 mg</p>")
						// 	break;
						//}
						default:
						a="";


						alert('Không tìm thấy dữ liệu')
						break;
					}
					$('#search-tra_cuu').val(a);
					$('.page_loader_container').css({
						"opacity":"0",
						"display":"none"
					});

        // GET SEARCH TERM
        var data = new FormData();
        data.append('search-tra_cuu', document.getElementById("search-tra_cuu").value);
        data.append('ajax', 1);
        // AJAX SEARCH REQUEST
        var xhr = new XMLHttpRequest();
        xhr.open('POST', "/wp-content/plugins/caremeal/view/tra_cuu/tra-cuu.php", true);
        xhr.onload = function () {
        	if (this.status==200) {
        		var results = JSON.parse(this.response),
        		wrapper = document.getElementById("results");
        		wrapper_2 = document.getElementById("results_2");
        		wrapper.innerHTML = "<table></table>";
        		wrapper_2.innerHTML = "<table></table>";
        		jQuery('<td colspan="5"><h1>Nguyên liệu</h1></td>').appendTo('#results table');
        		jQuery('<td colspan="5"><h1>Món ăn</h1></td>').appendTo('#results_2 table');
        		if (results.length > 0) {
        			var i = 0;
        			var j = 0;
        			for(var res of results) {
        				var line = document.createElement("tr");
        				var line_2 = document.createElement("tr");
        				if (parseInt(res['id']) !== 0) {
        					line.innerHTML = '<td><img src="' + res['anh_av'] + '"></td><td style="color: #fa6c47;">' + res['ten'] + ' </td><td>Năng lượng: ' + res['nang_luong'] + " KCal/100g" + '</td><td>Protein: ' + res['protein'] + ' </td><td>Chất béo: ' + res['lipid'] + ' </td><td style="width:111px;"><a href="'+domain_fe+res['url']+'" style="color: #ffab00;">Chi tiết</a></td>';
        					i++;
        				} else {
        					line_2.innerHTML = '<td style="color: #fa6c47;">' + res['nl_f2'] + ' </td><td>Năng lượng: ' + res['nl_f3'] + " KCal" + '</td><td>Protein: ' + res['nl_f4'] + ' </td><td>Chất béo: ' + res['nl_f5'] + ' </td><td style="width:111px;"><a href="#" style="color: #ffab00;">Chi tiết</a></td>';
        					j++;
        				}
        				jQuery(line).appendTo('#results table');
        				jQuery(line_2).appendTo('#results_2 table');
        				if (document.getElementById("search-tra_cuu").value == '') {
        					line.innerHTML = '';
        					line_2.innerHTML = '';
        				}
        			}
        			if ( i === 0 ) {
        				jQuery('<p>Không có Nguyên liệu</p>').appendTo('#results')
        			} else {
        				jQuery('<p></p>').appendTo('#results')

        			}
        			if ( j === 0 ) {
        				jQuery('<p>Không có Món ăn</p>').appendTo('#results_2 table')
        			}
        		} else {
        			wrapper.innerHTML = "Không có kết quả";
        			wrapper_2.innerHTML = "";
        		}
        	} else {
        		alert("ERROR LOADING FILE!");
        	}
        };
        xhr.send(data);
        return false;
    }
});
};
fileReader.readAsDataURL(file); 
})
		// Auto đẩy thông báo sau 30 phút
		var intervalID;     
		function showTime() {
			window.location.reload(true);
		}
		var intervalID = setInterval(showTime, 1800000);
		function stopClock() {
			clearInterval(intervalID);
		}
	}

//Phần tra cứu
var input = $('#search-tra_cuu');
var typingTimer;              
var doneTypingInterval = 1000;

//on keyup, start the countdown
input.on('keyup', function () {
	clearTimeout(typingTimer);
	typingTimer = setTimeout(fetchD, doneTypingInterval);
});
//on keydown, clear the countdown 
input.on('keydown', function () {
	clearTimeout(typingTimer);
});
function fetchD() {
        // GET SEARCH TERM
        var data = new FormData();
        data.append('search-tra_cuu', document.getElementById("search-tra_cuu").value);
        data.append('ajax', 1);
        // AJAX SEARCH REQUEST
        var xhr = new XMLHttpRequest();
        xhr.open('POST', "/wp-content/plugins/caremeal/view/tra_cuu/tra-cuu.php", true);
        xhr.onload = function () {
        	if (this.status==200) {
        		var results = JSON.parse(this.response),
        		wrapper = document.getElementById("results");
        		wrapper_2 = document.getElementById("results_2");
        		wrapper.innerHTML = "<table></table>";
        		wrapper_2.innerHTML = "<table></table>";
        		jQuery('<td colspan="5"><h1>Nguyên liệu</h1></td>').appendTo('#results table');
        		jQuery('<td colspan="5"><h1>Món ăn</h1></td>').appendTo('#results_2 table');
        		if (results.length > 0) {
        			var i = 0;
        			var j = 0;
        			for(var res of results) {
        				var line = document.createElement("tr");
        				var line_2 = document.createElement("tr");
        				if (parseInt(res['id']) !== 0) {
        					line.innerHTML = '<td><img src="' + res['anh_av'] + '"></td><td style="color: #fa6c47;">' + res['ten'] + ' </td><td>Năng lượng: ' + res['nang_luong'] + " KCal/100g" + '</td><td>Protein: ' + res['protein'] + ' </td><td>Chất béo: ' + res['lipid'] + ' </td><td style="width:111px;"><a href="'+domain_fe+res['url']+'" style="color: #ffab00;">Chi tiết</a></td>';
        					i++;
        				} else {
        					line_2.innerHTML = '<td style="color: #fa6c47;">' + res['nl_f2'] + ' </td><td>Năng lượng: ' + res['nl_f3'] + " KCal" + '</td><td>Protein: ' + res['nl_f4'] + ' </td><td>Chất béo: ' + res['nl_f5'] + ' </td><td style="width:111px;"><a href="#" style="color: #ffab00;">Chi tiết</a></td>';
        					j++;
        				}
        				jQuery(line).appendTo('#results table');
        				jQuery(line_2).appendTo('#results_2 table');
        				if (document.getElementById("search-tra_cuu").value == '') {
        					line.innerHTML = '';
        					line_2.innerHTML = '';
        				}
        			}
        			if ( i === 0 ) {
        				jQuery('<p>Không có Nguyên liệu</p>').appendTo('#results')
        			} else {
        				jQuery('<p></p>').appendTo('#results')

        			}
        			if ( j === 0 ) {
        				jQuery('<p>Không có Món ăn</p>').appendTo('#results_2 table')
        			}
        		} else {
        			wrapper.innerHTML = "Không có kết quả";
        			wrapper_2.innerHTML = "";
        		}
        	} else {
        		alert("ERROR LOADING FILE!");
        	}
        };
        xhr.send(data);
        return false;
    }

//Đẩy thông báo
Push.Permission.request();
var domain ="https://"+location.hostname;
var day = new Date();
var time = Number(day.getHours()); 
if(Number(day.getDate())<10){
	if(Number(day.getMonth()+1)<10){
		var ngay = '0'+day.getDate()+'/0'+(day.getMonth()+1)+'/'+day.getFullYear();
	}
	else{
		var ngay = '0'+day.getDate()+'/'+(day.getMonth()+1)+'/'+day.getFullYear();
	}   
}
else{
	if(Number(day.getMonth()+1)<10){
		var ngay = day.getDate()+'/0'+(day.getMonth()+1)+'/'+day.getFullYear();
	}
	else{
		var ngay = day.getDate()+'/'+(day.getMonth()+1)+'/'+day.getFullYear();
	}   
}

if(time >= 7 && time<=8 ){
	thong_bao_sang();
} else if(time >= 12 && time<=13 ){
	thong_bao_trua();
}
else if(time >= 18 && time<=19 ){
	thong_bao_toi();
}
else if(time >= 21 && time<=22 ){
    //thong_bao();
}
function thong_bao_sang(){
	$.ajax({
		type:"POST",
		url:domain+'/wp-content/plugins/caremeal/view/js/ajax/check_thuc_don.php', 
		data:{
			'ngay':ngay,
			'user_id':$('.body-overlay').attr('cm_id_use').trim()
		},
		success:function(response){
			if (response.indexOf('2') > -1) {
				Push.create('Bạn chưa ăn sáng', {
					body: 'Hãy thêm bữa sáng ngay',
					icon: 'https://caremeal.vn/caremeal.png',
					timeout: 8000,             
					onClick: function() {
						location.href="/thuc-don/"
					}  
				});
			}
		},
		error: function(){
			alert("Không tìm thấy dữ liệu");
		}
	});     
}
function thong_bao_trua(){
	$.ajax({
		type:"POST",
		url:domain+'/wp-content/plugins/caremeal/view/js/ajax/check_thuc_don.php', 
		data:{
			'ngay':ngay,
			'user_id':$('.body-overlay').attr('cm_id_use').trim()
		},
		success:function(response){ console.log(response)
			if (response.indexOf('4') > -1) {
				Push.create('Bạn chưa ăn trưa', {
					body: 'Hãy thêm bữa trưa ngay',
					icon: 'https://caremeal.vn/caremeal.png',
					timeout: 8000,             
					onClick: function() {
						location.href="/thuc-don/"
					}  
				});
			}
		},
		error: function(){
			alert("Không tìm thấy dữ liệu");
		}
	});     
}
function thong_bao_toi(){
	$.ajax({
		type:"POST",
		url:domain+'/wp-content/plugins/caremeal/view/js/ajax/check_thuc_don.php', 
		data:{
			'ngay':ngay,
			'user_id':$('.body-overlay').attr('cm_id_use').trim()
		},
		success:function(response){
			if (response.indexOf('6') > -1) {
				Push.create('Bạn chưa ăn tối', {
					body: 'Hãy thêm bữa tối ngay',
					icon: 'https://caremeal.vn/caremeal.png',
					timeout: 8000,             
					onClick: function() {
						location.href="/thuc-don/"
					}  
				});
			}
		},
		error: function(){
			alert("Không tìm thấy dữ liệu");
		}
	});     
}
})(jQuery)



