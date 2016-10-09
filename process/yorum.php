<?Php
include '../library/database.php';
include '../library/function.php';

$mysqli = new database;

	if($_POST['form'] == 'yorum'){
		
		$adsoyad = temiz($_POST['ad_soyad']);
		$emailad = temiz($_POST['email']);
		$kyorum = temiz($_POST['yorum']);
		$mklid = temiz($_POST['makale']);
		
		if(!empty($mklid) and is_numeric($mklid)){
			if(emailk($emailad)){
				if(!empty($adsoyad) and !empty($emailad) and !empty($kyorum)){
				
					if($mysqli->say('makale', 'mkl_id='.$mklid) == 1){
				
						$veri = $mysqli->satir("select yrm_tarih from yorum where yrm_ip='".$_SERVER['REMOTE_ADDR']."' order by yrm_id DESC LIMIT 1");

						if(time() - strtotime($veri->yrm_tarih) > 300 or empty($veri->yrm_tarih)){
						
							$veri = $mysqli->satir('select yorum_onay from ayar');
							$onay = $veri->yorum_onay;

							if($onay == '1'){
								$drm = '0';
							}else{
								$drm = '1';
							}
				
							$mysqli->islem('insert', 'yorum', 'mkl_id='.$mklid, 'yrm_tarih='.date('Y-m-d H:i:s'), 'yrm_metin='.$kyorum, 'usr_adi='.$adsoyad, 'usr_email='.$emailad, 'yrm_ip='.$_SERVER['REMOTE_ADDR'], 'yrm_drm='.$drm);
							echo 'Yorumunuz Eklendi';
				
						}else{
							echo 'Beş dakika içerisinde yalnızca bir yorum ekleyebilirsiniz.';
						}
					}else{
						echo 'Amacınız nedir? Ne yapmaya çalışıyorsunuz?';
					}
				}else{
					echo 'Gerekli alanları doldurmalısınız.';
				}
			}else{
				echo 'Geçerli bir email adresi girin.';
			}
		}else{
			echo 'Ne yapmaya çalıştığını anlayamadım.';
		}
	}
?>
