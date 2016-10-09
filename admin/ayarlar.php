<?Php
include 'library/config.php';
include 'library/database.php';
include 'library/function.php';

if(!isset($_SESSION['blog_giris']['usr_id']) or empty($_SESSION['blog_giris']['usr_id'])){
	header('location:index.php');
}

$mysqli = new database;

$dizin_ac = opendir('../theme');
$kutu = '<select name="tema" class="span6">';
while($fldr = readdir($dizin_ac)){
	
	if($fldr != '.' and $fldr != '..' and $fldr != 'js'){
		$kutu .= '<option value="'.$fldr.'">'.$fldr.'</option>';
	}
	
}

$kutu .= '</select>';
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
	<script type="text/javascript" src="assets/js/ayarlar.js"></script>
	<title>Blog Ayarları</title>
	<script type="text/javascript">
		var secim = '<?=$kutu;?>';
	</script>
	<style type="text/css">
		<!--
			tr  td:nth-child(2){
				text-align:center;
			}
		-->
	</style>
</head>
<body>

<!--Açılır Kutu-->

<div id="gunmodel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h4 id="myModalLabel">Blog Ayarlarını Değiştir</h4>
	</div>
	<div class="modal-body">
		<form name="kaydet" action="javascript:void(0)">
		
		</form>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">İptal</button>
		<button class="btn btn-primary" id="kytbtn">&nbsp;Kaydet&nbsp;</button>
	</div>
</div>

<!--Açılır Kutu-->

	<!--Header Başladı-->
		<?Php
			include 'includes/menu.php';
		?>
	<!--Header Bitti-->

	<div class="row-fluid border">
		<div class="span12">
			
			<?Php
				$veri = $mysqli->satir('select * from ayar');
			?>
			
			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="alert-info" colspan="3">Blog Ayarlarını Değiştir</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="150">URL Bilgisi</td>
						<td><?=$veri->base;?></td>
						<td width="65"><a href="#gunmodel" data-toggle="modal" id="1">Değiştir</a></td>
					</tr>
					<tr>
						<td>Title Bilgisi</td>
						<td><?=$veri->title;?></td>
						<td><a href="#gunmodel" data-toggle="modal" id="2">Değiştir</a></td>
					</tr>
					<tr>
						<td>Head Bilgisi</td>
						<td><?=$veri->head;?></td>
						<td><a href="#gunmodel" data-toggle="modal" id="3">Değiştir</a></td>
					</tr>
					<tr>
						<td>Meta Bilgisi</td>
						<td><?=$veri->meta;?></td>
						<td><a href="#gunmodel" data-toggle="modal" id="4">Değiştir</a></td>
					</tr>
					<tr>
						<td>Site Teması</td>
						<td>Şu an tema olarak <b><?=$veri->tema;?></b> tema kullanılmakta.</td>
						<td><a href="#gunmodel" data-toggle="modal" id="5">Değiştir</a></td>
					</tr>
					<tr>
						<td>Makale Yorumlama</td>
						<td><?Php
							if($veri->yorum == 1)
								echo 'Kullanıcılar makalelere yorum yapabilir.';
							else
								echo 'Makaleler kullanıcı yorumlarına kapalı.';
						?></td>
						<td><a href="#gunmodel" data-toggle="modal" id="6">Değiştir</a></td>
					</tr>
					<tr>
						<td>Yoruma Admin Onayı</td>
						<td><?Php
							if($veri->yorum_onay == 1)
								echo 'Yorumun yayınlanması için admin onayı gerekli.';
							else
								echo 'Admin onayı gerekmeden yorumlar yayınlanır.';
						?></td>
						<td><a href="#gunmodel" data-toggle="modal" id="7">Değiştir</a></td>
					</tr>
					<tr>
						<td>Veri Sayfalama Değeri</td>
						<td><b><?=$veri->sayfala;?></b> Kayıtta bir sayfalama yapılacak.</td>
						<td><a href="#gunmodel" data-toggle="modal" id="8">Değiştir</a></td>
					</tr>
					<tr>
						<td>Cache Kullanımı</td>
						<td><?Php
							if($veri->cache == 1)
								echo 'Makaleler veri tabanından çekilerek önbelleklenecek.';
							else
								echo 'Makaleler için önbellekleme kullanımı kapalı.';
						?></td>
						<td><a href="#gunmodel" data-toggle="modal" id="9">Değiştir</a></td>
					</tr>
				</tbody>
			</table>
			
			
			<hr/>
			<footer>Copyright &copy; Çağlar Özcan</footer>
		</div>
	</div>
</body>
</html>
<?Php
	ob_end_flush();
?>


