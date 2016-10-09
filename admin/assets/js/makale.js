$(document).ready(function(){
	
	var kimlik = 0;
	
	//Makale Aktif / Pasif
	$('.dropdown-menu .aktif').click(function(){
		
		$.post('process/makale.php?ac=aktif&makale=' + $(this).attr('id'), {}, function(sonuc){
			
			if(sonuc == 1){
				window.location.reload();
			}else{
				alert(sonuc);
			}
			
		});
		
	});
	
	$('.dropdown-menu .mklsil').click(function(){
		
		kimlik = $(this).attr('id');
		
	});
	
	$('button[name="sil"]').click(function(){
		
		$.post('process/makale.php?ac=mklsil&makale=' + kimlik, {}, function(sonuc){
			
			$('#makalesil .modal-body').html(sonuc);
				
			$('#makalesil .modal-footer').html('');
				
			setTimeout("window.location.reload()", 2000);
			
		});
		
	});
	
});