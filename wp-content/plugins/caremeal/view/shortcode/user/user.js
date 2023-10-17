(function($){
	var domain="https://"+location.hostname;
	$('.cm-user-loai select').change(function(){
		var a=$('.cm-user-loai select option:selected').val().trim();
		if(a=="phu_huynh"){
			$(".cm-phu_huynh").show();
			$(".cm-hoc_sinh").hide();
		}else if(a=="hoc_sinh"){
			$(".cm-phu_huynh").hide();
			$(".cm-hoc_sinh").show();
		}
	});
})(jQuery);