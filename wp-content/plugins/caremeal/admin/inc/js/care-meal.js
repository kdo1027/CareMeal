//--------------------------------------------------------------------------
//Input ảnh đại diện (Nguyên liệu, món ăn)
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();                
    reader.onload = function(e) {
      jQuery('#blah').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]); 
  }
}
jQuery("#imgInp").change(function() {
  readURL(this);
});

//--------------------------------------------------------------------------
//Input ảnh chi tiết (Nguyên liệu)
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
function readURL_2(input) {
  if (input.files && input.files[0]) {
    var reader_2 = new FileReader();
    reader_2.onload = function(e) {
      jQuery('#blah_2').attr('src', e.target.result);
    }
    reader_2.readAsDataURL(input.files[0]); 
  }
}
jQuery("#imgInp_2").change(function() {
  readURL_2(this);
});

//--------------------------------------------------------------------------
//Input nhóm nguyên liệu
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
jQuery('.cm-nhap__thong-tin select').change(function(){
  jQuery('input[name="nhom"]').val(jQuery('.cm-nhap__thong-tin select option:selected').val());
});

//--------------------------------------------------------------------------
//Xóa nguyên liệu
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
jQuery('input[name="xoa_all_nguyen_lieu"]').change(function() {
  if (jQuery(this).prop('checked') == true) {
    jQuery('.input_xoa_nguyen_lieu').prop('checked', true);
  } else {
    jQuery('.input_xoa_nguyen_lieu').prop('checked', false);
  }
});

//--------------------------------------------------------------------------
//Thêm nhóm món ăn
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
var mon_an__nhom = "";
jQuery('.cm-add__mon-an__nhom').each(function(){
  jQuery(this).change(function(){
    if(jQuery(this).prop('checked')){
      mon_an__nhom +=jQuery(this).val()+",";
    }else{
      mon_an__nhom = mon_an__nhom.replace(jQuery(this).val()+",", "");
    }
    jQuery('.cm-add__mon-an input[name="nhom"]').val(mon_an__nhom);
  });
});

//--------------------------------------------------------------------------
//Sửa nhóm món ăn
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
var list_mon_an__nhom=jQuery('.cm-edit__mon-an input[name="nhom"]').val();
if(list_mon_an__nhom){
  let list_mon_an__nhom_array=list_mon_an__nhom.split(",");
}
jQuery('.cm-edit__mon-an__nhom').each(function(){
  for(var i=0;i<list_mon_an__nhom_array.length;i++){
    if(jQuery(this).val()==list_mon_an__nhom_array[i]){
      jQuery(this).prop('checked',true);
    }
  }
  jQuery(this).change(function(){
    if(jQuery(this).prop('checked')){
      list_mon_an__nhom +=jQuery(this).val()+",";
    }else{
      list_mon_an__nhom = list_mon_an__nhom.replace(jQuery(this).val()+",", "");
    }
    jQuery('.cm-edit__mon-an input[name="nhom"]').val(list_mon_an__nhom);
  });
});
//--------------------------------------------------------------------------
//Giới tính
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
jQuery( '.cm_gioi_tinh input[type="radio"]' ).on( "click", function() {
  jQuery('input[name="gioi_tinh"]').val(jQuery( '.cm_gioi_tinh input[type="radio"]:checked' ).val());
});

//--------------------------------------------------------------------------
//Lấy này tháng và thứ
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
function mydate(){
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
    switch(day){
      case 0:{
        day="Chủ nhật";
        break;
      }
      case 1:{
        day="Thứ 2";
        break;
      }
      case 2:{
       day="Thứ 3";
        break;
      }
      case 3:{
        day="Thứ 4";
        break;
      }
      case 4:{
        day="Thứ 5";
        break;
      }
      case 5:{
        day="Thứ 6";
        break;
      }
      default: {
        day="Thứ 7";
        break;
      }
    }    
  document.getElementById("day").value=day;
}
jQuery('input[type="date"]').change(function(){
  var cmdate=jQuery('input[type="date"]').val().trim();
  cmdate=cmdate.split('-');
  cmdate=cmdate[2]+'/'+cmdate[1]+'/'+cmdate[0];
  jQuery('input[name="td_ngay"]').val(cmdate);
});   
//--------------------------------------------------------------------------
//Thêm món ăn cho thực đơn
//▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
let domain="https://"+location.hostname;
let thuc_don_nang_luong=thuc_don_protein=thuc_don_glucid=thuc_don_lipid=0;
let count_mon_a_thuc_don=0;
var mon_an__thuc_don = "";
jQuery('.cm-add__mon-an__thuc-don').each(function(){
  jQuery(this).change(function(){
    if(jQuery(this).prop('checked')){
      if(count_mon_a_thuc_don<6){
        mon_an__thuc_don +=jQuery(this).val()+",";
        count_mon_a_thuc_don++;
        jQuery.ajax({
          type:"POST",
          url:domain+'/wp-content/plugins/caremeal/inc/ajax/mon-an.php',
          beforeSend: function( xhr ){
           jQuery('.loading-web').removeClass('hidden');
         },
         data:{'mon-an':jQuery(this).val()},
         success:function(response){ console.log(response);
          if (response != 0) {
            response = JSON.parse(response);
            thuc_don_nang_luong = Math.round((thuc_don_nang_luong+Number(response[0].nang_luong))*100)/100;
            thuc_don_protein = Math.round((thuc_don_protein+Number(response[0].protein))*100)/100;
            thuc_don_glucid = Math.round((thuc_don_glucid+Number(response[0].glucid))*100)/100;
            thuc_don_lipid = Math.round((thuc_don_lipid+Number(response[0].lipid))*100)/100;
            jQuery('input[name="nang_luong"]').val(thuc_don_nang_luong);
            jQuery('input[name="protein"]').val(thuc_don_protein);
            jQuery('input[name="glucid"]').val(thuc_don_glucid);
            jQuery('input[name="lipid"]').val(thuc_don_lipid);
          } 
          jQuery('.loading-web').removeClass('hidden');
        }
      });
      }
      else{
        alert("Bạn chỉ được chọn tối đa 6 món");
        jQuery(this).prop('checked',false);
      }
    }else{
      mon_an__thuc_don = mon_an__thuc_don.replace(jQuery(this).val()+",", "");
      count_mon_a_thuc_don--;
      jQuery.ajax({
          type:"POST",
          url:domain+'/wp-content/plugins/caremeal/inc/ajax/mon-an.php',
          beforeSend: function( xhr ){
           jQuery('.loading-web').removeClass('hidden');
         },
         data:{'mon-an':jQuery(this).val()},
         success:function(response){ console.log(response);
          if (response != 0) {
            response = JSON.parse(response);
            thuc_don_nang_luong = Math.round((thuc_don_nang_luong-Number(response[0].nang_luong))*100)/100;
            thuc_don_protein = Math.round((thuc_don_protein-Number(response[0].protein))*100)/100;
            thuc_don_glucid = Math.round((thuc_don_glucid-Number(response[0].glucid))*100)/100;
            thuc_don_lipid = Math.round((thuc_don_lipid-Number(response[0].lipid))*100)/100;
            jQuery('input[name="nang_luong"]').val(thuc_don_nang_luong);
            jQuery('input[name="protein"]').val(thuc_don_protein);
            jQuery('input[name="glucid"]').val(thuc_don_glucid);
            jQuery('input[name="lipid"]').val(thuc_don_lipid);
          } 
          jQuery('.loading-web').removeClass('hidden');
        }
      });
    }
    jQuery('.cm-add__mon-an input[name="add__mon_an"]').val(mon_an__thuc_don);
  });
});