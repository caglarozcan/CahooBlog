<?Php
include '../library/config.php';
include '../library/database.php';
include '../library/function.php';
if(!isset($_SESSION['blog_giris']['usr_id']) or empty($_SESSION['blog_giris']['usr_id'])){
	header('location:../index.php');
}

$mysqli = new database;

$islem = temiz($_GET['ac']);
$kimlik = temiz($_GET['resim']);

if($islem == 'rsmsil'){
	
	if(file_exists('../../grafik/thumb/'.$kimlik)){
		
		if(file_exists('../../grafik/'.$kimlik)){
		
			unlink('../../grafik/thumb/'.$kimlik);
			unlink('../../grafik/'.$kimlik);
			
			echo 'Resim sistemden başarıyla silindi.';
		
		}else{
			echo 'Silmek istediğiniz resim sistemde mevcut değil.';
		}
		
	}else{
		echo 'Silmek istediğiniz resim sistemde mevcut değil.';
	}
	
}else{
	echo 'Geçersiz İşlem';
}
                                   
ob_end_flush();
?>