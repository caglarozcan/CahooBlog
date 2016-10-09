<?Php
include 'library/config.php';
include 'library/database.php';
include 'library/function.php';

if(!isset($_SESSION['blog_giris']['usr_id']) or empty($_SESSION['blog_giris']['usr_id'])){
	header('location:index.php');
}

$mysqli = new database;

$msg = '';

if(isset($_POST['ekle_btn'])){
	
	$kategori = temiz($_POST['kt_isim']);
	
	if(!empty($kategori)){
	
		if($mysqli->say('kategori', "kt_adi='".$kategori."'") == 0){
			$mysqli->islem('insert', 'kategori', 'kt_adi='.$kategori, 'kt_seflink='.seflink($kategori), 'kt_drm=1');
			$msg = '	<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Yeni kategori başarıyla oluşturuldu.
					</div>';
		}else{
			$msg = '	<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Aynı isimde başka bir kategori mevcut.
					</div>';
		}
	}else{
		$msg = '	<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Lütfen bir kategori ismi belirtin.
					</div>';
	}
	
}


if(isset($_POST['edit_btn'])){
	$ktisim = temiz($_POST['kt_isim']);
	$ktid = temiz($_POST['kategori']);
	
	if(!empty($ktisim) and !empty($ktid) and is_numeric($ktid)){
		
		if($mysqli->say('kategori', 'kt_id='.$ktid) == 1){
			
			if($mysqli->say('kategori', "kt_adi='".$ktisim."'") == 0){
				
				$mysqli->islem('update', 'kategori', 'kt_adi='.$ktisim, 'kt_seflink='.seflink($ktisim), 'kt_id='.$ktid);
				$msg = '	<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Kategori başarıyla güncellendi.
					</div>';
				
			}else{
			$msg = '	<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Aynı isimde başka bir kategori mevcut.
					</div>';
			}
			
		}else{
		$msg = '	<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Düzenlemek istediğiniz kategori sistemde mevcut değil.
					</div>';
		}
		
	}else{
		$msg = '	<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Lütfen bir kategori ismi belirtin.
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
	<script type="text/javascript" src="assets/js/kategori.js"></script>
	
	<!--CK EDITOR-->
	<script type="text/javascript" src="plugin/ckeditor/ckeditor.js"></script>
	<title>Kategori Yönetimi</title>
</head>
<body>
<!-- Modal -->
<div id="ktsil" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h4 id="myModalLabel">Kategori Silme Onayla</h4>
	</div>
	<div class="modal-body">
		<p>Kategoriyi silmek istediğinizden emin misiniz?</p>
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


	<div class="row-fluid">
		<div class="span6">		
			<table class="table table-bordered table-hover">
				<!--Tablo Başlık Bildirimi-->
				<thead>
					<tr class="alert-info">
						<th>#</th>
						<th>Kategori İsmi</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<!--Tablo Başlık Bildirimi-->
				<!--Tablo İçerik Bildirimi-->
				<tbody>
				<?Php
					$veri = $mysqli->ful_select('select kt_id, kt_adi, kt_drm from kategori order by kt_id DESC');
					$i = 1;
					foreach($veri as $kt){
					
						if($kt->kt_drm == 0)
							$renk = 'error';
						else
							$renk = '';
				?>
					<tr class="<?=$renk;?>">
						<td width="60"><?=$i++;?></td>
						<td width="300"><?=$kt->kt_adi;?></td>
						<td>
							<!---->
							<div class="btn-group">
								<button class="btn btn-small">İşlem</button>
								<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="javascript:void(0)" class="edit" id="<?=$kt->kt_adi;?>" data="<?=$kt->kt_id;?>"><i class="icon-pencil"></i>&nbsp;&nbsp;Güncelle</a></li>
									<li><a href="#ktsil" data-toggle="modal" id="<?=$kt->kt_id;?>" class="ktsil"><i class="icon-trash"></i>&nbsp;&nbsp;Sil</a></li>
									<li class="divider"></li>
									<li><a href="javascript:void(0)" class="aktif" id="<?=$kt->kt_id;?>"><i class="icon-ban-circle"></i>&nbsp;&nbsp;Aktif / Pasif</a></li>
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
		</div>
		<div class="span6 pull-right">
			<form method="post">
				<div class="input-append">
					<input name="kt_isim" class="input-block-level" id="appendedInputButton" type="text" placeholder="Kategori İsmi">
					<input type="submit" class="btn" name="ekle_btn" value="Kategori Oluştur"/>
					<input type="hidden" name="kategori" value="">
				</div>
			</form>
			<?=$msg;?>
		</div>
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
