$(document).ready(function(){
	
	$('a[data-toggle="modal"]').click(function(){
		
		var ayar = $(this).attr('id');
		
		if(ayar == 1){
		
			$('.modal-body form[name="kaydet"]').html('<label>Site Base URL : <input type="text" name="base" class="span6" value="' + $('tr:eq(' + ayar + ') > td:eq(1)').text() + '"/></label><input type="hidden" name="ayar" value="' + ayar + '"/>')
		
		}else if(ayar == 2){
		
			$('.modal-body form[name="kaydet"]').html('<label>Site Title Bilgisi : <input type="text" name="title" class="span6" value="' + $('tr:eq(' + ayar + ') > td:eq(1)').text() + '"/></label><input type="hidden" name="ayar" value="' + ayar + '"/>')
		
		}else if(ayar == 3){
		
			$('.modal-body form[name="kaydet"]').html('<label>Site Head Mesajı : <input type="text" name="head" class="span6" value="' + $('tr:eq(' + ayar + ') > td:eq(1)').text() + '"/></label><input type="hidden" name="ayar" value="' + ayar + '"/>')
		
		}else if(ayar == 4){
		
			$('.modal-body form[name="kaydet"]').html('<label>Site Meta Tagları : <input type="text" name="meta" class="span6" value="' + $('tr:eq(' + ayar + ') > td:eq(1)').text() + '"/></label><input type="hidden" name="ayar" value="' + ayar + '"/>')
		
		}else if(ayar == 5){
		
			$('.modal-body form[name="kaydet"]').html('<label>Site Teması : ' + window.secim + '</label><input type="hidden" name="ayar" value="' + ayar + '"/>');
		
		}else if(ayar == 6){
		
			$('.modal-body form[name="kaydet"]').html('<label><input type="radio" name="yorum" value="1"/> Makaleler yorumlamaya açık.</label><br/><label><input type="radio" name="yorum" value="0"/> Makaleler yorumlamaya kapalı.</label><input type="hidden" name="ayar" value="' + ayar + '"/>');
		
		}else if(ayar == 7){
		
			$('.modal-body form[name="kaydet"]').html('<label><input type="radio" name="yonay" value="1"/> Yorum yayınlanması için admin onayı gerekir.</label><br/><label><input type="radio" name="yonay" value="0"/> Yorum yayınlanması için admin onayı gerekemez.</label><input type="hidden" name="ayar" value="' + ayar + '"/>');
		
		}else if(ayar == 8){
		
			$('.modal-body form[name="kaydet"]').html('<label><input type="text" name="sayfala" class="span1" value="' + $('tr:eq(' + ayar + ') > td:eq(1)').text().substring(0, $('tr:eq(' + ayar + ') > td:eq(1)').text().indexOf(' ')) + '"/> Kayıtta bir sayfalama yapılacak.</label><input type="hidden" name="ayar" value="' + ayar + '"/>');
		
		}else if(ayar == 9){
		
			$('.modal-body form[name="kaydet"]').html('<label><input type="radio" name="cache" value="1"/> Cache Kullanımı Aktif</label><br/><label><input type="radio" name="cache" value="0"/> Cache Kullanımı Pasif</label><input type="hidden" name="ayar" value="' + ayar + '"/>');
		
		}
	});
	
	
	$('#kytbtn').click(function(){
		
		$.ajax({
			type:'POST',
			url:'process/ayar.php',
			data:$('form[name="kaydet"]').serialize(),
			success:function(sonuc){
				
				$('.modal-body').html(sonuc);
				
				$('.modal-footer').html('');
				
				setTimeout("window.location.reload()", 2500);
			
			}
		});
		
	});

});