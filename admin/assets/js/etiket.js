$(document).ready(function(){
	
	var deger = $('input[name="etiket"]').val();
	
	$('#etkt_btn').click(function(){
		
		var etiket = $.trim($('input[name="txtetiket"]').val());
		
		if(etiket != ""){
			
			if(deger.indexOf(etiket) == -1){
				
				deger += etiket + ',';
				
				$('#etiket').append('<div class="etiket">' + etiket + ' <i class="icon-remove"></i> </div>');
				$('input[name="txtetiket"]').val('');
				$('input[name="txtetiket"]').focus();
				$('input[name="etiket"]').val(deger);
				
			}else{
				alert('Bu etiket daha önce eklenmiş.');
			}
			
		}else{
			alert('Boş Etiket Ekleyemezsiniz.');
		}
		
	});
	
	$('#etiket').delegate('i', 'click', function(){
		
		var sil = $.trim($(this).parent().text()) + ',';
		
		if(deger.indexOf(sil) != -1){
			
			deger = deger.replace(sil, '');
			$('input[name="etiket"]').val(deger);
			$(this).parent('.etiket').remove();
			
		}else{
			alert("Etiket bulunamadı.");
		}
		
	});
	
});