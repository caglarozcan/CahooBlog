<?Php
	/*
	*	SEFLINK FONKSİYONU
	*/
	function seflink($text){                         
		$bul = array('ç','ö','ü','ı','ş','ğ','Ç','Ö','Ü','İ','Ş','Ğ','1','2','3','4','5','6','7','8','9','0');
		$deg = array('c','o','u','i','s','g','c','o','u','i','s','g','','','','','','','','','','');
		$text = str_replace($bul, $deg, $text);
		$text = mb_strtolower($text,'UTF-8');
		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($text, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));  
	}
	
	/*
	*	TARİH DÜZENLEME FONKSİYONU
	*/
	function tarih($tarih){
		$ay = array('Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık');
		
		$yeni = date('d-m-Y-H:i:s', strtotime($tarih));
		
		$bul = explode('-', $yeni);
		
		return $bul[0].' '.$ay[($bul[1]-1)].' '.$bul[2].'&nbsp;&nbsp;<i>'.$bul[3].'</i>';
	}
	
	/*
	*	XSS VE SQL-INJECTİON TEMİZLEME FONKSİYONU
	*/
	function temiz($veri){
	
		if(is_numeric($veri)){
			return $veri;
		}elseif(is_null($veri)){
			return $veri;
		}else{
			return addslashes(strip_tags($veri));
		}
	}
	
	/*
	*	EMAIL KONTROL FONKSİYONU
	*/
	function emailk($email){
		if(strpos($email,'@')>0){
			
			$bol = explode('@', $email);
			
			if(strlen($bol[0])>3){
				if($bol[1]=='hotmail.com' or $bol[1]=='hotmail.com.tr' or $bol[1]=='gmail.com' or $bol[1]=='yahoo.com' or $bol[1]=='windowslive.com'){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
?>
