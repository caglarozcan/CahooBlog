$(document).ready(function(){
	
	var resim = "";
	
	$('.img').mouseover(function(){
		$('.img:eq(' + $(this).index() + ') > .rsmmenu').show();
	});
	
	$('.img').mouseout(function(){
		$('.img:eq(' + $(this).index() + ') > .rsmmenu').hide();
	});
	
	//resim silme
	$('.rsmsil').click(function(){
		
		resim = $(this).attr('id');
		
	});
	
	$('button[name="sil"]').click(function(){
		
		$.post('process/medya.php?ac=rsmsil&resim=' + resim, {}, function(sonuc){
	
			$('#resimsil .modal-body').html(sonuc);
				
			$('#resimsil .modal-footer').html('');
				
			setTimeout("window.location.reload()", 2000);
			
		});
		
	});
	
	//yükle
	$('#yukle').click(function(){
		
		$('#grafik').removeClass('hide');
		
	});
	
});