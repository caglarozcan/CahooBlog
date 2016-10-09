<?Php
include '../library/config.php';
include '../library/database.php';
include '../library/function.php';
if(!isset($_SESSION['blog_giris']['usr_id']) or empty($_SESSION['blog_giris']['usr_id'])){
	header('location:../index.php');
}

$mysqli = new database;

$islem = temiz($_GET['ac']);
$kimlik = temiz($_GET['yorum']);

if($islem == 'aktif'){
	
	if(is_numeric($kimlik) and !empty($kimlik)){
		
		$veri = $mysqli->satir('select yrm_drm from yorum where yrm_id='.$kimlik);
		
		$durum = $veri->yrm_drm;
		
		if($durum == 1){
		
			$mysqli->islem('update', 'yorum', 'yrm_drm=0', 'yrm_id='.$kimlik);
			echo 1;
		
		}elseif($durum == 0){
			
			$mysqli->islem('update', 'yorum', 'yrm_drm=1', 'yrm_id='.$kimlik);
			echo 1;
			
		}else{
			echo 'Geçersiz İşlem.';
		}
		
	}else{
		echo 'Yanlış Bilgi';
	}
	
}elseif($islem == 'yrmsil'){

	if(is_numeric($kimlik) and !empty($kimlik)){
		
		if($mysqli->say('yorum', 'yrm_id='.$kimlik) == 1){
		
			$mysqli->islem('delete', 'yorum', 'yrm_id='.$kimlik);
			
			echo 'Yorum Silme işlemi başarılı.';
			
		}else{
			echo 'Yorum bulunamadı. Sistemde mevcut değil.';
		}
		
	}else{
		echo 'Yanlış Bilgi.';
	}

}elseif($islem == 'yrmget'){

	if(is_numeric($kimlik) and !empty($kimlik)){
		
		if($mysqli->say('yorum', 'yrm_id='.$kimlik) == 1){
		
			$veri = $mysqli->satir('select yrm_metin from yorum where yrm_id='.$kimlik);
			echo $veri->yrm_metin;
			
		}else{
			echo 'Yorum bulunamadı. Sistemde mevcut değil.';
		}
		
	}else{
		echo 'Yanlış Bilgi.';
	}

}else{
	echo 'Geçersiz İşlem';
}

ob_end_flush();
?>