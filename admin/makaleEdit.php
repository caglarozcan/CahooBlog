<?Php
include 'library/config.php';
include 'library/database.php';
include 'library/function.php';

if(!isset($_SESSION['blog_giris']['usr_id']) or empty($_SESSION['blog_giris']['usr_id'])){
	header('location:index.php');
}

$mysqli = new database;

$makale = temiz($_GET['mklid']);

if(isset($_POST['kayit_btn'])){
	
	$mklbaslik = temiz($_POST['baslik']);
	$mklicerik = $_POST['mkl_icerik'];
	$kategori = $_POST['kategori'];
	$etiket = temiz($_POST['etiket']);
	$etiket = substr($etiket, 0, -1);
	
	if(!empty($mklbaslik) and !empty($mklicerik) and !empty($kategori) and !empty($etiket)){
		
		$mysqli->islem('delete', 'mkl_kt', 'mkl_id='.$makale);
		$mysqli->islem('update', 'makale', 'mkl_baslik='.$mklbaslik, 'mkl_metin='.htmlspecialchars($mklicerik, ENT_QUOTES, 'UTF-8'), 'mkl_seflink='.seflink($mklbaslik), 'mkl_etiket='.$etiket, 'mkl_id='.$makale);
		
		foreach($_POST['kategori'] as $kat){
			$mysqli->islem('insert','mkl_kt', 'mkl_id='.$makale, 'kt_id='.temiz($kat));
		}
		
		$msg = '	<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Makale sisteme başarıyla güncellendi. <a href="home.php">Makale Listesi</a>
					</div>';
		
	}else{
		$msg = '	<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Lütfen tüm alanları doldurun.
					</div>';
	}
	
}


if(!empty($makale) and is_numeric($makale) and $mysqli->say('makale','mkl_id='.$makale) == 1){
	
	$veri = $mysqli->satir('select mkl_baslik,mkl_metin,mkl_etiket from makale where mkl_id='.$makale);
	
	$mklbaslik = $veri->mkl_baslik;
	$mklicerik = $veri->mkl_metin;
	$etiket = $veri->mkl_etiket;
	
	$ktgr = $mysqli->ful_select('select kt_id from mkl_kt where mkl_id='.$makale);
	$kategori = array();
	
	foreach($ktgr as $kat){
		$kategori[] = $kat->kt_id;
	}
	
	
}else{
	header('location:home.php');
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" href="assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="assets/css/stil.css"/>
	<link rel="shortcut icon" href="assets/img/favicon.ico"/>
	
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/etiket.js"></script>
	
	<!--CK EDITOR-->
	<script type="text/javascript" src="plugin/ckeditor/ckeditor.js"></script>
	<title>Makale Güncelle</title>
</head>
<body>

<!--Header Başladı-->
	<?Php
		include 'includes/menu.php';
	?>
<!--Header Bitti-->


	<div class="row-fluid">
		<form method="post">
			<div class="span9">
				<?=$msg;?>
			
				<input type="text" name="baslik" class="span12" placeholder="Makale Başlığı" value="<?=$mklbaslik;?>"/>
				<textarea cols="80" id="mkl_icerik" name="mkl_icerik" rows="10"><?=$mklicerik;?></textarea>
					<script type="text/javascript">
						CKEDITOR.replace( 'mkl_icerik',{
							toolbar : [
						{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Subscript','Superscript' ] },
						{ name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
						{ name: 'links',       items : [ 'Link','Unlink','Anchor','Source' ] },
						{ name: 'insert',      items : [ 'Image','Table','SpecialChar','PageBreak','Syntaxhighlight' ] },
						{ name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
						{ name: 'colors',      items : [ 'TextColor','BGColor' ] }
						],
						height:420,
		
						});
					</script>
			</div>
		
			<div class="span3 pull-right">
				<input type="submit" name="kayit_btn" value="Makaleyi Güncelle" class="btn btn-primary pull-right span12"/>
			</div>
			<div class="span3 pull-right">
				<h2><small>Kategoriler</small></h2>
				<?Php
					$veri = $mysqli->ful_select('select kt_id,kt_adi from kategori where kt_drm = 1');
					foreach($veri as $kat){
					
						if(in_array($kat->kt_id, $kategori))
							$sec = 'checked';
						else
							$sec = '';
					
						echo '<label class="checkbox">';
						echo '<input type="checkbox" name="kategori[]" value="'.$kat->kt_id.'" '.$sec.'/> '.$kat->kt_adi;
						echo '</label>';
					}
				?>
			</div>
			
			<div class="span3 pull-right">
				<h2><small>Makale Etiketleri</small></h2>
				<div id="etiket">
				<?Php
					$bol = explode(',', $etiket);
					foreach($bol as $etkt)
						echo '<div class="etiket">'.$etkt.' <i class="icon-remove"></i></div>';
				?>
				</div>
				<div class="input-prepend input-append">
					<span class="add-on"><i class="icon-tag"></i></span>
					<input name="txtetiket" id="appendedPrependedInput" type="text" placeholder="Etiket İsmi">
					<button class="btn" type="button" id="etkt_btn">Ekle</button>
					<input type="hidden" name="etiket" value="<?=$etiket;?>,"/>
				</div>
			</div>
		</form>
		<div class="span12">
			<hr/>
			<footer>
				Copyright &copy Çağlar ÖZCAN
			</footer>
		</div>
	</div>
	
</body>
</html>
<?Php
	ob_end_flush();
?>
