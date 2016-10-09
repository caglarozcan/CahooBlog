<?Php
include 'library/config.php';
include 'library/database.php';
include 'library/function.php';

if(!isset($_SESSION['blog_giris']['usr_id']) or empty($_SESSION['blog_giris']['usr_id'])){
	header('location:index.php');
}

$mysqli = new database;

$ay = array('Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık');

$logsay = $mysqli->ful_select('select count(*) as say, MONTH(log_tarih) as ay from log where YEAR(log_tarih) = '.date('Y').' GROUP BY MONTH(log_tarih)');

$i = 0;
foreach($logsay as $log){
	$yil .= "['".$ay[(($log->ay) - 1)]."', ".$log->say."],";
}

$loggun = $mysqli->ful_select('select count(*) as say,DAY(log_tarih) as gun from log where YEAR(log_tarih) = '.date('Y').' and MONTH(log_tarih) = '.date('m').' GROUP BY DAY(log_tarih)');
foreach($loggun as $log){
	$gun .= "['".$log->gun." ".$ay[date('m') - 1]."', ".$log->say."],";
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
	<script type="text/javascript" src="assets/js/istatistik.js"></script>
	<!--FlowChart-->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
	
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Yıl', 'Ziyaretçi Sayısı'],
				<?=$yil;?>
				//Değerleri buraya verilecek.
			]);
			
			var options = {
				title: 'Aylık Ziyaretçi Verileri',
				pointSize:3,
				backgroundColor:'#FFFFFF',
				chartArea:{left:25,top:35,width:"950",height:"150"},
				legend: 'none'
			};

			var chart = new google.visualization.LineChart(document.getElementById('aylik'));
			chart.draw(data, options);
		}

		google.setOnLoadCallback(gunluk);
		function gunluk() {
			var data = google.visualization.arrayToDataTable([
				['Gün', 'Ziyaretçi Sayısı'],
				<?=$gun;?>
				//Verileri buraya yazılacak
			]);
			var options = {
				title: '<?=$ay[date('m') - 1];?> Ayı Verileri',
				pointSize:3,
				backgroundColor:'#FFFFFF',
				chartArea:{left:25,top:35,width:"950",height:"150"},
				legend: 'none'
			};

			var chart = new google.visualization.LineChart(document.getElementById('gunluk'));
			chart.draw(data, options);
		}
	</script>
	<!--FlowChart Bitti-->
	<style type="text/css">
		<!--
			table:nth-child(3) tr td{
				font-size:12px;
				text-align:center;
			}
			
			.log_vw{
				max-height:350px;
				overflow:auto;
				width:100%;
			}
		-->
	</style>
	<title>Blog İstatistikleri</title>
</head>
<body>
	<!--Header Başladı-->
		<?Php
			include 'includes/menu.php';
		?>
	<!--Header Bitti-->

	<div class="row-fluid border">
		<div class="span12">
	<!--Aylık Verileri Göster-->
			<table class="table table-bordered">
			<!--Tablo Başlık Bildirimi-->
				<thead>
					<tr class="alert-info">
						<th>Aylık Ziyaretçi Verileri</th>
					</tr>
				</thead>
			<!--Tablo Başlık Bildirimi-->
			<!--Tablo İçerik Bildirimi-->
				<tbody>
					<td>
						<div id="aylik" style="height:220px;"></div>
					</td>
				</tbody>
			<!--Tablo İçerik Bildirimi-->
			</table>
	<!--Aylık Verileri Göster-->
	<!--Günlük Verileri Göster-->
			<table class="table table-bordered">
			<!--Tablo Başlık Bildirimi-->
				<thead>
					<tr class="alert-info">
						<th>
							Günlük Ziyaretçi Verileri
							<!---->
							<div class="btn-group pull-right">
								<button class="btn btn-small">İşlem</button>
								<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="javascript:void(0)" onclick="window.location.reload()"><i class="icon-refresh"></i>&nbsp;&nbsp;Yenile</a></li>
								</ul>
							</div>
							<!---->
						</th>
					</tr>
				</thead>
			<!--Tablo Başlık Bildirimi-->
			<!--Tablo İçerik Bildirimi-->
				<tbody>
					<td>
						<div id="gunluk" style="height:220px;"></div>
					</td>
				</tbody>
			<!--Tablo İçerik Bildirimi-->
			</table>
	<!--Günlük Verileri Göster-->
	<!--Logları Verileri Göster-->
			<table class="table table-bordered">
			<!--Tablo Başlık Bildirimi-->
				<thead>
					<tr class="alert-info">
						<th>
							Ziyaretçi Logları
							<!---->
							<div class="btn-group pull-right">
								<button class="btn btn-small">İşlem</button>
								<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="javascript:void(0)" onclick="window.location.reload()"><i class="icon-refresh"></i>&nbsp;&nbsp;Yenile</a></li>
									<li class="divider"></li>
									<li><a href="javascript:void(0)" onclick="log_getir(1)">Ocak</a></li>
									<li><a href="javascript:void(0)" onclick="log_getir(2)">Şubat</a></li>
									<li><a href="javascript:void(0)" onclick="log_getir(3)">Mart</a></li>
									<li><a href="javascript:void(0)" onclick="log_getir(4)">Nisan</a></li>
									<li><a href="javascript:void(0)" onclick="log_getir(5)">Mayıs</a></li>
									<li><a href="javascript:void(0)" onclick="log_getir(6)">Haziran</a></li>
									<li><a href="javascript:void(0)" onclick="log_getir(7)">Temmuz</a></li>
									<li><a href="javascript:void(0)" onclick="log_getir(8)">Ağustos</a></li>
									<li><a href="javascript:void(0)" onclick="log_getir(9)">Eylül</a></li>
									<li><a href="javascript:void(0)" onclick="log_getir(10)">Ekim</a></li>
									<li><a href="javascript:void(0)" onclick="log_getir(11)">Kasım</a></li>
									<li><a href="javascript:void(0)" onclick="log_getir(12)">Aralık</a></li>
								</ul>
							</div>
							<!---->
						</th>
					</tr>
				</thead>
			<!--Tablo Başlık Bildirimi-->
			<!--Tablo İçerik Bildirimi-->
				<tbody>
					<td>
					<div class="log_vw">
						<table class="table table-bordered table-striped">
							<tbody>
							
							<?Php
								$veri = $mysqli->ful_select('select log_tarih,log_ip from log where MONTH(log_tarih) = '.date('m').' order by log_tarih DESC');
								$i = 0;
								foreach($veri as $log){
									if($i % 2 == 0){
										echo '<tr><td>',$log->log_ip,'&nbsp;&nbsp;-&nbsp;&nbsp;',tarih($log->log_tarih),'</td>';
									}else{
										echo '<td>',$log->log_ip,'&nbsp;&nbsp;-&nbsp;&nbsp;',tarih($log->log_tarih),'</td></tr>';
									}
									
									$i++;
								}
							?>
							</tbody>
						</table>
					</div>
					</td>
				</tbody>
			<!--Tablo İçerik Bildirimi-->
			</table>
	<!--Logları Verileri Göster-->
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
