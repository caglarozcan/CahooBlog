<?php

$demo_mode = false;
$upload_dir = '../../grafik/';
$allowed_ext = array('jpg','jpeg','png','gif');

if(array_key_exists('pic',$_FILES) && $_FILES['pic']['error'] == 0 ){
	
	$pic = $_FILES['pic'];

	if(!in_array(get_extension($pic['name']),$allowed_ext)){
		exit_status('Sadece '.implode(',',$allowed_ext).' türünde dosya yükleyebilirsiniz.');
	}		
	
	if(move_uploaded_file($pic['tmp_name'], $upload_dir.$pic['name'])){
		
		$resim=$upload_dir.$pic['name'];
		//yeni resmin genişliğini girin
		$r_genislik=226;
		//yeni resmin yüksekliğini girin
		$r_yukseklik=183; 
		 
		//resmin bilgilerinin alınması
		list($gen, $yuk, $type) = getimagesize($resim);
		 
		//en ve boy oranının hesaplanması
		$enOran = $r_genislik / $gen;
		$boyOran = $r_yukseklik / $yuk;
		 
		//aranın ayarlanması
		if($enOran > $boyOran){
			$yEn = floor($gen * $enOran);
			$yBoy = floor($yuk * $enOran);
		}else{
			$yEn = floor($gen * $boyOran);
			$yBoy = floor($yuk * $boyOran);
		}
		 
		//kesilmeye başlangıç noktalarının hesaplanaması
		$fEn = floor(0 - (($yEn - $r_genislik) / 2));
		$fBoy = floor(0 - (($yBoy - $r_yukseklik) / 2));
		 
		//resmin hafızaya alınması
		$o_img = imagecreatefromjpeg($resim);
		 
		//renklerin belirlenmesi
		$g_img = imagecreatetruecolor($r_genislik, $r_yukseklik);
		 
		//resmi keserek oluşturma
		imagecopyresampled($g_img,$o_img,$fEn,$fBoy,0,0,$yEn,$yBoy,$gen,$yuk);
		imagejpeg($g_img, '../../grafik/thumb/'.$pic['name']); 
		 
		//resmin kaynağını silme
		imagedestroy($o_img);
		imagedestroy($g_img);

		exit_status('Grafik Yükleme Başarılı!');
	}
	
}

exit_status('Yükleme İşlemi Başarısız!');


// Helper functions

function exit_status($str){
	echo json_encode(array('status'=>$str));
	exit;
}

function get_extension($file_name){
	$ext = explode('.', $file_name);
	$ext = array_pop($ext);
	return strtolower($ext);
}
?>