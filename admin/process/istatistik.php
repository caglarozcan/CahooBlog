<?Php
include '../library/config.php';
include '../library/database.php';
include '../library/function.php';
if(!isset($_SESSION['blog_giris']['usr_id']) or empty($_SESSION['blog_giris']['usr_id'])){
	header('location:../index.php');
}

$mysqli = new database;

$islem = temiz($_GET['ac']);
$ay = temiz($_GET['ay']);

if($islem == 'log_getir'){
	
	if(is_numeric($ay) and $ay > 0 and $ay < 13){
?>
		<table class="table table-bordered table-striped">
			<tbody>
			
			<?Php
				$veri = $mysqli->ful_select('select log_tarih,log_ip from log where MONTH(log_tarih) = '.$ay.' and YEAR(log_tarih) = '.date('Y').' order by log_tarih DESC');
				$i = 0;
				
				if(count($veri) > 0){
					foreach($veri as $log){
						if($i % 2 == 0){
							echo '<tr><td>',$log->log_ip,'&nbsp;&nbsp;-&nbsp;&nbsp;',tarih($log->log_tarih),'</td>';
						}else{
							echo '<td>',$log->log_ip,'&nbsp;&nbsp;-&nbsp;&nbsp;',tarih($log->log_tarih),'</td></tr>';
						}
						
						$i++;
					}
				}else{
					echo '<tr><td><br/><br/><center>İlgili aya ait log kaydı bulunamadı.</center><br/><br/></td></tr>';
				}
			?>
			</tbody>
		</table>	
<?Php		
	}
	
}else{
	echo 'Geçersiz İşlem';
}

ob_end_flush();
?>