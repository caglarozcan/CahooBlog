<?Php
include 'library/config.php';
include 'library/database.php';
include 'library/function.php';

if($_GET['ac'] == 'cikis'){
	unset($_SESSION['blog_giris']['usr_id']);
	session_destroy();
}

$mysqli = new database;	

if(isset($_POST['giris'])){
	
	$kadi = temiz($_POST['kuladi']);
	$pass = temiz($_POST['sifre']);	
	
	
	if(!empty($kadi) and !empty($pass)){
		
		$veri = $mysqli->satir("select usr_id from user where usr_kuladi='".$kadi."' and usr_sifre='".md5($pass)."'");
		
		if($veri->usr_id > 0){
			
			$_SESSION['blog_giris']['usr_id'] = $veri->usr_id;
			header('location:home.php');
			
		}else{
			echo 'Hatalı Giriş';
		}
		
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" href="assets/css/login.css"/>
	<link rel="shortcut icon" href="assets/img/favicon.ico"/>

	<title>Blog Yönetim Paneli</title>
	
</head>
<body>
	
	<div class="login">
	<form method="post">
		<h2>Yönetim Paneli Girişi</h2>
		<input type="text" name="kuladi" class="textbox" placeholder="Kullanıcı Adı">
		<input type="password" name="sifre" class="textbox" placeholder="Şifre">
		<input type="submit" name="giris" value="Giriş Yap" class="buton"/>
		<div style="clear:both;"></div>
	</form>
	</div>

</body>
</html>
<?Php
	ob_end_flush();
?>
