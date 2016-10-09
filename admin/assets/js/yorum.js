$(document).ready(function(){
	
	var kimlik = 0;
	
	//Yorum Aktif Pasif
	$('.aktif').click(function(){
		
		var id = $.trim($(this).attr('id'));
		
		if(id != ''){
			$.post('process/yorum.php?ac=aktif&yorum=' + id, {}, function(sonuc){
				
				if(sonuc == '1'){
					window.location.reload();
				}else{
					alert(sonuc);
				}
				
			});
		}
		
	});
	
	//Yorum Silme
	$('.dropdown-menu .yrmsil').click(function(){
		
		kimlik = $(this).attr('id');
		
		$('#yorumsil .modal-body p').html('Yorumu Silmek istediğinizden emin misiniz?');
		$('#yorumsil .modal-footer').html('<button class="btn" data-dismiss="modal" aria-hidden="true">İptal</button><button class="btn btn-primary" name="sil">Evet Sil</button>');
		
	});
	
	$('#yorumsil .modal-footer').delegate('button[name="sil"]', 'click', function(){
		
		$.post('process/yorum.php?ac=yrmsil&yorum=' + kimlik, {}, function(sonuc){
			
			$('#yorumsil .modal-body').html(sonuc);
				
			$('#yorumsil .modal-footer').html('');
				
			setTimeout("window.location.reload()", 2500);
			
		});
		
	});
	
	
	//Yorum Metni
	$('.dropdown-menu .gozat').click(function(){
		
		$.post('process/yorum.php?ac=yrmget&yorum=' + $(this).attr('id'), {}, function(sonuc){
		
			$('#yorumsil .modal-body p').html(sonuc);
			$('#yorumsil .modal-footer').html('<button class="btn" data-dismiss="modal" aria-hidden="true">Kapat</button>');
			
		});
		
	});
	
	
});