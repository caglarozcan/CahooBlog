<?Php
include '../library/config.php';
include '../library/database.php';
include '../library/function.php';
if(!isset($_SESSION['blog_giris']['usr_id']) or empty($_SESSION['blog_giris']['usr_id'])){
	header('location:../index.php');
}

$mysqli = new database;

$islem = temiz($_GET['ac']);
$kimlik = temiz($_GET['makale']);

if($islem == 'aktif'){
	
	if(is_numeric($kimlik) and !empty($kimlik)){
		
		$veri = $mysqli->satir('select mkl_drm from makale where mkl_id='.$kimlik);
		
		$durum = $veri->mkl_drm;
		
		if($durum == 1){
		
			$mysqli->islem('update', 'makale', 'mkl_drm=0', 'mkl_id='.$kimlik);
			echo 1;
		
		}elseif($durum == 0){
			
			$mysqli->islem('update', 'makale', 'mkl_drm=1', 'mkl_id='.$kimlik);
			echo 1;
			
		}else{
			echo 'Geçersiz İşlem.';
		}
		
	}else{
		echo 'Yanlış Bilgi';
	}
	
}elseif($islem == 'mklsil'){

	if(is_numeric($kimlik) and !empty($kimlik)){
		
		if($mysqli->say('makale', 'mkl_id='.$kimlik) == 1){
		
			$mysqli->islem('delete', 'makale', 'mkl_id='.$kimlik);
			$mysqli->islem('delete', 'yorum', 'mkl_id='.$kimlik);
			$mysqli->islem('delete', 'mkl_kt', 'mkl_id='.$kimlik);
			
			echo 'Makale Silme işlemi başarılı.';
			
		}else{
			echo 'Makale bulunamadı. Sistemde mevcut değil.';
		}
		
	}else{
		echo 'Yanlış Bilgi.';
	}

}else{
	echo 'Geçersiz İşlem';
}

ob_end_flush();
?>