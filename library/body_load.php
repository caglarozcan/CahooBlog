<?Php
$sayfa		= temiz($_GET['page']);
$makale		= temiz($_GET['mkl']);
$kategori	= temiz($_GET['kat']);
$arama		= temiz($_GET['q']);
$harici		= temiz($_GET['sayfa']);

if(!empty($makale) and !empty($kategori)){  //Makale Ayrıntılarını Okuma
	
	if($mysqli->say('kategori',"kt_seflink='".$kategori."'") == 1 and $mysqli->say('makale', "mkl_seflink='".$makale."'") == 1){
		//Kullanıcı queryString değeri ile oynanamışsa makaleyi göster.
		$mysqli->sorgu("update makale set mkl_hit = mkl_hit + 1 where mkl_seflink='".$makale."'");
		$sql = "select mkl_id,mkl_baslik,mkl_metin,mkl_tarih,mkl_etiket,mkl_seflink,mkl_hit,kt_adi,kt_seflink from makale,kategori where makale.mkl_seflink = '".$makale."' and kategori.kt_seflink='".$kategori."'";
		
		if($ayar['cache'] == 1){
			$veri = $mysqli->cache($sql, 'str', 500);
		}else{
			$veri = $mysqli->satir($sql);
		}
		
		$ayar['title'] = $veri->mkl_baslik;
		$ayar['meta'] = $veri->mkl_etiket;
		$ayar['desc'] = substr($veri->mkl_metin, 0, 250);
		
		$format = 'satir';
		
		include_once(TEMA.$ayar['tema'].SEPT.'header.php');
		include_once(TEMA.$ayar['tema'].SEPT.'entry.php');
		include_once(TEMA.$ayar['tema'].SEPT.'entry_com.php');
		
	}else{
		//Kullanıcı queryString değeri ile oynamışsa makale listesini getir.
		include_once(TEMA.$ayar['tema'].SEPT.'header.php');
		
		$top_mkl = $mysqli->say('makale', 'mkl_drm=1');
		
		$top_sf = ceil($top_mkl / $ayar['sayfala']);
		
		if(empty($sayfa) or !is_numeric($sayfa) or $sayfa > $top_sf or $sayfa == 0)
			$sayfa = 1;
		
		$baslangic  = (($sayfa - 1) * $ayar['sayfala']);
		$format = 'liste';
		
		$sql = "select makale.mkl_id,mkl_baslik,mkl_metin,mkl_tarih,mkl_seflink,mkl_hit,kt_adi,kt_seflink from makale,kategori,mkl_kt where makale.mkl_id=mkl_kt.mkl_id and mkl_kt.kt_id=kategori.kt_id and mkl_drm=1 order by makale.mkl_id DESC LIMIT ".$baslangic.",".$ayar['sayfala'];
		
		if($ayar['cache'] == 1){
			$mkl = $mysqli->cache($sql, 'ful', 500);
		}else{
			$mkl = $mysqli->ful_select($sql);
		}
		
		foreach($mkl as $veri){
			include(TEMA.$ayar['tema'].SEPT.'entry.php');
		}
		
		echo '<ul class="sayfala">';
		for($i = 1; $i <= $top_sf; $i++){
		
			if($i != $sayfa)
				echo '<li><a href="'.$ayar['base'].'sayfa/'.$i.'">'.$i.'</a></li>';
			else
				echo '<li class="aktif">'.$i.'</li>';
				
		}
		echo '</ul>';
	}
	
}elseif(!empty($kategori)){  //Seçilen kategoriye ait makaleleri listeleme.
	
	if($mysqli->say('kategori', "kt_seflink='".$kategori."'") == 1){
		//Eğer kategori varsa kategoriye ait makaleleri listele.
		include_once(TEMA.$ayar['tema'].SEPT.'header.php');
		
		$top_mkl = $mysqli->say('makale,kategori,mkl_kt', "makale.mkl_id=mkl_kt.mkl_id and mkl_kt.kt_id = kategori.kt_id and kt_seflink='mysql-ve-sql-server-notlari' and mkl_drm=1");
		
		$top_sf = ceil($top_mkl / $ayar['sayfala']);
		
		if(empty($sayfa) or !is_numeric($sayfa) or $sayfa > $top_sf or $sayfa == 0)
			$sayfa = 1;
		
		$baslangic  = (($sayfa - 1) * $ayar['sayfala']);
		$format = 'liste';
		
		$sql = "select makale.mkl_id,mkl_baslik,mkl_metin,mkl_tarih,mkl_seflink,mkl_hit,kt_adi,kt_seflink 
									from 
									makale,kategori,mkl_kt 
									where 
									makale.mkl_id=mkl_kt.mkl_id and
									mkl_kt.kt_id=kategori.kt_id and
									mkl_drm=1 and
									kt_seflink='".$kategori."' 
									order by makale.mkl_id DESC
									LIMIT ".$baslangic.",".$ayar['sayfala'];
		
		if($ayar['cache'] == 1){
			$mkl = $mysqli->cache($sql, 'ful', 500);
		}else{
			$mkl = $mysqli->ful_select($sql);
		}
		
		foreach($mkl as $veri){
			include(TEMA.$ayar['tema'].SEPT.'entry.php');
		}
		
		echo '<ul class="sayfala">';
		for($i = 1; $i <= $top_sf; $i++){
		
			if($i != $sayfa)
				echo '<li><a href="'.$ayar['base'].'sayfa/'.$i.'">'.$i.'</a></li>';
			else
				echo '<li class="aktif">'.$i.'</li>';
				
		}
		echo '</ul>';
	
	}else{
	//Eğer kategori veritabanında bulunmazsa normal makale listesini getir.
		include_once(TEMA.$ayar['tema'].SEPT.'header.php');
		
		$top_mkl = $mysqli->say('makale', 'mkl_drm=1');
		
		$top_sf = ceil($top_mkl / $ayar['sayfala']);
		
		if(empty($sayfa) or !is_numeric($sayfa) or $sayfa > $top_sf or $sayfa == 0)
			$sayfa = 1;
		
		$baslangic  = (($sayfa - 1) * $ayar['sayfala']);
		$format = 'liste';
		
		$sql = "select makale.mkl_id,mkl_baslik,mkl_metin,mkl_tarih,mkl_seflink,mkl_hit,kt_adi,kt_seflink from makale,kategori,mkl_kt where makale.mkl_id=mkl_kt.mkl_id and mkl_kt.kt_id=kategori.kt_id and mkl_drm=1 order by makale.mkl_id DESC LIMIT ".$baslangic.",".$ayar['sayfala'];
		
		if($ayar['cache'] == 1){
			$mkl = $mysqli->cache($sql, 'ful', 500);
		}else{
			$mkl = $mysqli->ful_select($sql);
		}
		
		foreach($mkl as $veri){
			include(TEMA.$ayar['tema'].SEPT.'entry.php');
		}
		
		echo '<ul class="sayfala">';
		for($i = 1; $i <= $top_sf; $i++){
		
			if($i != $sayfa)
				echo '<li><a href="'.$ayar['base'].'sayfa/'.$i.'">'.$i.'</a></li>';
			else
				echo '<li class="aktif">'.$i.'</li>';
				
		}
		echo '</ul>';
	}

}elseif(!empty($arama) and strlen($arama) >= 3){
	
	$veri = $mysqli->ful_select("select mkl_baslik,mkl_tarih,mkl_seflink,kt_seflink from makale,kategori,mkl_kt where makale.mkl_id=mkl_kt.mkl_id and kategori.kt_id=mkl_kt.kt_id and mkl_baslik LIKE '%".$arama."%'");
	include_once(TEMA.$ayar['tema'].SEPT.'header.php');
	include(TEMA.$ayar['tema'].SEPT.'search.php');
	
}elseif($harici == 'hakkimda'){
	include_once(TEMA.$ayar['tema'].SEPT.'header.php');
	include(TEMA.$ayar['tema'].SEPT.'member.php');
}else{
//Normal makale listesini getir.
	$top_mkl = $mysqli->say('makale', 'mkl_drm=1');
	
	$top_sf = ceil($top_mkl / $ayar['sayfala']);
	
	if(empty($sayfa) or !is_numeric($sayfa) or $sayfa > $top_sf or $sayfa == 0)
		$sayfa = 1;
	
	$baslangic  = (($sayfa - 1) * $ayar['sayfala']);
	
	include_once(TEMA.$ayar['tema'].SEPT.'header.php');
	$format = 'liste';
	
	$sql = "select makale.mkl_id,mkl_baslik,mkl_metin,mkl_tarih,mkl_seflink,mkl_hit,kt_adi,kt_seflink from makale,kategori,mkl_kt where makale.mkl_id=mkl_kt.mkl_id and mkl_kt.kt_id=kategori.kt_id and mkl_drm=1 order by makale.mkl_id DESC LIMIT ".$baslangic.",".$ayar['sayfala'];
	
	if($ayar['cache'] == 1){
		$mkl =  $mysqli->cache($sql, 'ful', 500);
	}else{
		$mkl = $mysqli->ful_select($sql);
	}
	
	foreach($mkl as $veri){
		include(TEMA.$ayar['tema'].SEPT.'entry.php');
	}
	
	echo '<ul class="sayfala">';
	for($i = 1; $i <= $top_sf; $i++){
	
		if($i != $sayfa)
			echo '<li><a href="'.$ayar['base'].'sayfa/'.$i.'">'.$i.'</a></li>';
		else
			echo '<li class="aktif">'.$i.'</li>';
	}
	echo '</ul>';
	
}

?>