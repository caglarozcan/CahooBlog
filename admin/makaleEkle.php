<?Php
include 'library/config.php';
include 'library/database.php';
include 'library/function.php';

if(!isset($_SESSION['blog_giris']['usr_id']) or empty($_SESSION['blog_giris']['usr_id'])){
	header('location:index.php');
}

$mysqli = new database;

if(isset($_POST['kayit_btn'])){
	
	$mklbaslik = temiz($_POST['baslik']);
	$mklicerik = $_POST['mkl_icerik'];
	$kategori = $_POST['kategori'];
	$etiket = substr(temiz($_POST['etiket']), 0, -1);
	
	if(!empty($mklbaslik) and !empty($mklicerik) and !empty($kategori) and !empty($etiket)){
		$mysqli->islem('insert', 'makale', 'mkl_baslik='.$mklbaslik, 'mkl_metin='.htmlspecialchars($mklicerik, ENT_QUOTES, 'UTF-8'), 'mkl_tarih='.date('Y-m-d H:i:s'), 'mkl_seflink='.seflink($mklbaslik), 'mkl_etiket='.$etiket, 'mkl_hit=1', 'mkl_drm=1');
		
		foreach($_POST['kategori'] as $kat){
			$mysqli->islem('insert','mkl_kt', 'mkl_id='.$mysqli->insertid, 'kt_id='.temiz($kat));
		}
		
		$msg = '	<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Makale sisteme başarıyla eklendi. <a href="home.php">Makale Listesi</a>
					</div>';
		
	}else{
		$msg = '	<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Lütfen tüm alanları doldurun.
					</div>';
	}
	
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
	<title>Yeni Makale Oluştur</title>
</head>
<body onload="prettyPrint()">

<!--Header Başladı-->
	<?Php
		include 'includes/menu.php';
	?>
<!--Header Bitti-->


	<div class="row-fluid">
		<form method="post">
			<div class="span9">
				<?=$msg;?>
			
				<input type="text" name="baslik" class="span12" placeholder="Makale Başlığı" value="<?=$_POST['baslik'];?>"/>
				<textarea cols="80" id="mkl_icerik" name="mkl_icerik" rows="10"><?=$_POST['mkl_icerik'];?></textarea>
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
				<input type="reset" name="reset_btn" value="Makaleyi Sil" class="btn pull-left"/>
				<input type="submit" name="kayit_btn" value="Makaleyi Kaydet" class="btn btn-primary pull-right"/>
			</div>
			<div class="span3 pull-right">
				<h2><small>Kategoriler</small></h2>
				<?Php
					$veri = $mysqli->ful_select('select kt_id,kt_adi from kategori where kt_drm = 1');
					foreach($veri as $kat){
						echo '<label class="checkbox">';
						echo '<input type="checkbox" name="kategori[]" value="'.$kat->kt_id.'"/> '.$kat->kt_adi;
						echo '</label>';
					}
				?>
			</div>
			
			<div class="span3 pull-right">
				<h2><small>Makale Etiketleri</small></h2>
				<div id="etiket"></div>
				<div class="input-prepend input-append">
					<span class="add-on"><i class="icon-tag"></i></span>
					<input name="txtetiket" id="appendedPrependedInput" type="text" placeholder="Etiket İsmi">
					<button class="btn" type="button" id="etkt_btn">Ekle</button>
					<input type="hidden" name="etiket" value=""/>
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
