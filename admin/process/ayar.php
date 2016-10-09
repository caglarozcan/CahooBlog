<?Php
include '../library/config.php';
include '../library/database.php';
include '../library/function.php';
if(!isset($_SESSION['blog_giris']['usr_id']) or empty($_SESSION['blog_giris']['usr_id'])){
	header('location:../index.php');
}

$mysqli = new database;

$ayar = temiz($_POST['ayar']);

if(is_numeric($ayar) and $ayar > 0 and $ayar < 10){
	
	$base = temiz($_POST['base']);
	$title = temiz($_POST['title']);
	$head = temiz($_POST['head']);
	$meta = temiz($_POST['meta']);
	$tema = temiz($_POST['tema']);
	$yorum = temiz($_POST['yorum']);
	$yonay = temiz($_POST['yonay']);
	$sayfala = temiz($_POST['sayfala']);
	$cache = temiz($_POST['cache']);
	
	if($ayar == 1){
		if(!empty($base)){
			$mysqli->islem('update', 'ayar', 'base='.$base, 'ayar_id=1');
			echo 'Ayar değiştirme başarılı';
		}else{
			echo 'Bir hata oluştu ';
		}
	}elseif($ayar == 2){
		if(!empty($title)){
			$mysqli->islem('update', 'ayar', 'title='.$title, 'ayar_id=1');
			echo 'Ayar değiştirme başarılı';
		}else{
			echo 'Bir hata oluştu ';
		}
	}elseif($ayar == 3){
		if(!empty($head)){
			$mysqli->islem('update', 'ayar', 'head='.$head, 'ayar_id=1');
			echo 'Ayar değiştirme başarılı';
		}else{
			echo 'Bir hata oluştu ';
		}
	}elseif($ayar == 4){
		if(!empty($meta)){
			$mysqli->islem('update', 'ayar', 'meta='.$meta, 'ayar_id=1');
			echo 'Ayar değiştirme başarılı';
		}else{
			echo 'Bir hata oluştu ';
		}
	}elseif($ayar == 5){
		if(!empty($tema)){
			$mysqli->islem('update', 'ayar', 'tema='.$tema, 'ayar_id=1');
			echo 'Ayar değiştirme başarılı';
		}else{
			echo 'Bir hata oluştu ';
		}
	}elseif($ayar == 6){
		if($yorum == 1 or $yorum == 0){
			$mysqli->islem('update', 'ayar', 'yorum='.$yorum, 'ayar_id=1');
			echo 'Ayar değiştirme başarılı';
		}else{
			echo 'Bir hata oluştu ';
		}
	}elseif($ayar == 7){
		if($yonay == 1 or $yonay == 0){
			$mysqli->islem('update', 'ayar', 'yorum_onay='.$yonay, 'ayar_id=1');
			echo 'Ayar değiştirme başarılı';
		}else{
			echo 'Bir hata oluştu ';
		}
	}elseif($ayar == 8){
		if(!empty($sayfala)){
			$mysqli->islem('update', 'ayar', 'sayfala='.$sayfala, 'ayar_id=1');
			echo 'Ayar değiştirme başarılı';
		}else{
			echo 'Bir hata oluştu ';
		}
	}elseif($ayar == 9){
		if($cache == 1 or $cache == 0){
			$mysqli->islem('update', 'ayar', 'cache='.$cache, 'ayar_id=1');
			echo 'Ayar değiştirme başarılı';
		}else{
			echo 'Bir hata oluştu ';
		}
	}else{
		echo 'Hata';
	}
	
}else{
	echo 'Geçersiz İşlem';
}

ob_end_flush();
?>