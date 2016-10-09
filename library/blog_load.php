<?Php
include_once(LIBRARY.'function.php');

$mysqli = new database;

$mysqli->cache_dir = 'cache/';

//Ziyaretçi logları tutulması
if($mysqli->say('log', "DATE( log_tarih ) =  DATE( NOW( ) ) and log_ip='".$_SERVER['REMOTE_ADDR']."'") == 0){
	$mysqli->islem('insert','log','log_tarih='.date('Y-m-d H:i:s'), 'log_ip='.$_SERVER['REMOTE_ADDR']);
}

//Ayarlar tablosunu getir.
$veri = $mysqli->satir('select * from ayar');

//Ayarlar diziye atanıyor
$ayar = array();
$ayar['base']	= 	$veri->base;
$ayar['title'] = 	$veri->title;
$ayar['head']	= 	$veri->head;
$ayar['tema']	= 	$veri->tema;
$ayar['sayfala'] =  $veri->sayfala;
$ayar['cache'] = 	$veri->cache;
$ayar['yorum'] =	$veri->yorum;
$ayar['meta']	= 	$veri->meta;
$ayar['onay']	= 	$veri->yorum_onay;
$ayar['desc'] = $veri->description;

if(!is_dir(TEMA.$ayar['tema'])){ 
	if(is_dir(TEMA.'default')){
		$ayar['tema'] = 'default';
	}else{
		echo 'Sistemde tema bulunamadı.';
		exit();
	}
}


include_once(LIBRARY.'body_load.php');
include_once(TEMA.$ayar['tema'].SEPT.'footer.php');

?>