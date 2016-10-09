<?Php

include '../library/config.php';
include '../library/database.php';
include '../library/function.php';
if(!isset($_SESSION['blog_giris']['usr_id']) or empty($_SESSION['blog_giris']['usr_id'])){
	header('location:../index.php');
}

$mysqli = new database;

$islem = temiz($_GET['ac']);
$kimlik = temiz($_GET['kt']);

if($islem == 'aktif'){
	
	if(!empty($kimlik) and is_numeric($kimlik)){
		
		$veri = $mysqli->satir('select kt_drm from kategori where kt_id='.$kimlik);
		
		$durum = $veri->kt_drm;
		
		if($durum == 1){
			$mysqli->islem('update', 'kategori', 'kt_drm=0', 'kt_id='.$kimlik);
			echo 1;
		}elseif($durum == 0){
			$mysqli->islem('update', 'kategori', 'kt_drm=1', 'kt_id='.$kimlik);
			echo 1;
		}else{
			echo 'Geçersiz Değer.';
		}
		
	}else{
		echo 'Geçersiz Değer.';
	}
	
}elseif($islem == 'ktsil'){
	
	if(!empty($kimlik) and is_numeric($kimlik)){
		
		if($mysqli->say('kategori', 'kt_id='.$kimlik) == 1){
			
			if($mysqli->say('mkl_kt', 'kt_id='.$kimlik) == 0){
				
				$mysqli->islem('delete', 'kategori', 'kt_id='.$kimlik);
				echo 'Kategori başarıyla sistemden silindi.';
				
			}else{
				echo 'Kategoriye ait makale(ler) var. Silme işlemi iptal edildi.';
			}
			
		}else{
			echo 'Geçersiz Değer.';
		}
		
	}else{
		echo 'Geçersiz Değer.';
	}
	
}else{
	echo 'Geçersiz İşlem.';
}

?>