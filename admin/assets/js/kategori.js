$(document).ready(function(){

	var kimlik = 0;

	$('.aktif').click(function(){
		
		$.post('process/kategori.php?ac=aktif&kt=' + $(this).attr('id'), {}, function(sonuc){
			
			if(sonuc == '1'){
				window.location.reload();
			}else{
				alert(sonuc);
			}
			
		});
		
	});
	
	$('.dropdown-menu .ktsil').click(function(){
		
		kimlik = $(this).attr('id');
		
	});
	
	$('button[name="sil"]').click(function(){
		
		$.post('process/kategori.php?ac=ktsil&kt=' + kimlik, {}, function(sonuc){
			
			$('#ktsil .modal-body').html(sonuc);
				
			$('#ktsil .modal-footer').html('');
				
			setTimeout("window.location.reload()", 2500);
			
		});
		
	});
	
	//Kategori Güncelle
	
	$('.edit').click(function(){
		
		$('input[name="kt_isim"]').val($(this).attr('id'));
		$('input[name="ekle_btn"]').val('Kategori Güncelle').attr('name','edit_btn');
		$('input[name="kategori"]').val($(this).attr('data'));
		
	});

});