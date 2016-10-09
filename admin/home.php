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
	<script type="text/javascript" src="assets/js/makale.js"></script>
	<title>Blog Admin Paneli</title>
	<style type="text/css">
		<!--
			tr  td:nth-child(3){
				font-size:12px;
				text-align:center;
			}

			tr  td:nth-child(4){
				text-align:center;
			}

			tr  td:nth-child(5){
				text-align:center;
			}
		-->
	</style>
</head>
<body>
<!-- Modal -->
<div id="makalesil" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Makale Silme Onayla</h4>
  </div>
  <div class="modal-body">
    <p>Makaleyi Silmek istediğinizden emin misiniz?</p>
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
		<!-- Button to trigger modal -->
			<table class="table table-bordered table-hover">
			<!--Tablo Başlık Bildirimi-->
				<thead>
					<tr class="alert-info">
						<th>#</th>
						<th>Makale Başlığı</th>
						<th>Eklenme Tarihi</th>
						<th>Hit</th>
						<th>Yorum</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
			<!--Tablo Başlık Bildirimi-->
			<!--Tablo İçerik Bildirimi-->
				<tbody>
				<?Php
					
					$top_sayfa = ceil($mysqli->say('makale') / 20);
					
					$sayfa = temiz($_GET['pg']);
					
					if(!is_numeric($sayfa) or empty($sayfa)){
						$sayfa = 1;
					}
					
					$baslangic  = (($sayfa - 1) * 20);
					
					$veri = $mysqli->ful_select("select mkl_id,mkl_baslik,mkl_tarih,mkl_hit,mkl_drm,(select count(mkl_id) from yorum where mkl_id=m.mkl_id) as yrm_sys from makale as m order by mkl_id DESC LIMIT ".$baslangic.",20");
					$i = $baslangic + 1;
					foreach($veri as $mkl){
					if($mkl->mkl_drm == 0)
						$renk = 'error';
					else
						$renk = '';
				?>
					<tr class="<?=$renk;?>">
						<td width="80"><?=$i++;?></td>
						<td><?=$mkl->mkl_baslik;?></td>
						<td width="190"><?=tarih($mkl->mkl_tarih);?></td>
						<td width="60"><?=$mkl->mkl_hit;?></td>
						<td width="60"><?=$mkl->yrm_sys;?></td>
						<td width="80">
							<!---->
							<div class="btn-group">
								<button class="btn btn-small">İşlem</button>
								<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="makaleEdit.php?mklid=<?=$mkl->mkl_id;?>"><i class="icon-pencil"></i>&nbsp;&nbsp;Güncelle</a></li>
									<li><a href="#makalesil" data-toggle="modal" class="mklsil" id="<?=$mkl->mkl_id;?>"><i class="icon-trash"></i>&nbsp;&nbsp;Sil</a></li>
									<li class="divider"></li>
									<li><a href="javascript:void(0)" class="aktif" id="<?=$mkl->mkl_id;?>"><i class="icon-ban-circle"></i>&nbsp;&nbsp;Aktif / Pasif</a></li>
								</ul>
							</div>
							<!---->
						</td>
					</tr>
				<?Php
					}
				?>
				</tbody>
			<!--Tablo İçerik Bildirimi-->
			</table>
			<div class="pagination">
				<ul>
					<?Php
						for($i = 1; $i<=$top_sayfa; $i++){
							if($i == $sayfa)
								echo '<li class="active"><a href="javascript:void(0)">',$i,'</a></li>';
							else
								echo '<li><a href="?pg=',$i,'">',$i,'</a></li>';
						}
					?>
				</ul>
			</div>
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
