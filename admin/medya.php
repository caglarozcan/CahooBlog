<?Php
include 'library/config.php';
include 'library/database.php';
include 'library/function.php';

if(!isset($_SESSION['blog_giris']['usr_id']) or empty($_SESSION['blog_giris']['usr_id'])){
	header('location:index.php');
}

$mysqli = new database;
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
	<script type="text/javascript" src="assets/js/medya.js"></script>
	<script type="text/javascript" src="assets/js/filedrop.js"></script>
	<script type="text/javascript" src="assets/js/fileupt.js"></script>
	<title>Medya Yönetimi</title>
	<style type="text/css">
		<!--
			img{
				width:141px;
				height:140px;
				cursor:pointer;
			}
		-->
	</style>
</head>
<body>
<!-- Modal -->
<div id="resimsil" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Resim Silme Onayla</h4>
  </div>
  <div class="modal-body">
    <p>Resmi Silmek istediğinizden emin misiniz?</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">İptal</button>
    <button class="btn btn-primary" name="sil">Evet Sil</button>
  </div>
</div>
	<!--Header Başladı-->
		<?Php
			include 'includes/menu.php';
		?>
	<!--Header Bitti-->

	<div class="row-fluid border">
		<div class="span12">
			<table class="table table-bordered">
				<thead>
					<th class="alert-info">
						Yüklü  Grafik Dosyaları
						<button class="btn btn-small pull-right margin0" id="yukle">Yeni Grafik Yükle</button>
					</th>
				</thead>
				<tbody>
					<tr class="hide" id="grafik">
						<td>
							<div id="dropbox">
								<span class="message">Yüklenecek Dosyaları Buraya Sürükle</span>
							</div>
						</td>
					</tr>
					<tr>
						<td>
						<?Php
					$dir = '../grafik/thumb/';
					$open = opendir($dir);
					$i = 1;
					while($resim = readdir($open)){
						if($resim != '.' and $resim != '..'){
				?>
							<div class="img">
								<div class="rsmmenu">
									&nbsp;<a href="#resimsil" data-toggle="modal" class="rsmsil" id="<?=$resim;?>">Sil</a>
									&nbsp;|&nbsp;<span><?=$resim;?></span>
								</div>
								<img src="../grafik/thumb/<?=$resim;?>"/>
							</div>
				<?Php
						}
					}
				?>
						</td>
					</tr>
				</tbody>
			</table>
			
			<div class="temiz"></div>
			<hr/>
			<footer>
				Copyright &copy; Çağlar Özcan
			</footer>
		</div>
	</div>
</body>
</html>
<?Php
	ob_end_flush();
?>