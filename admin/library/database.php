<?Php
/*!
*|----------------------------------------------------------|
*|   +--------------------------------------------------+   |
*|   |       MySQL Veritabanı Yönetim Sınıfı            |   |
*|   +--------------------------------------------------+   |
*|----------------------------------------------------------|
*|   +--------------------------------------------------+   |
*|   |            Copyright © Çağlar ÖZCAN              |   |
*|   +--------------------------------------------------+   |
*|----------------------------------------------------------|
*/

class database{

	public $baglan;
	public $hatavw;
	public $sql_str;
	public $affrow;
	public $insertid;
	public $cache_dir;

	public function __construct(){

		$this->baglan = NULL;

		$this->baglan = mysqli_connect('127.0.0.1', 'root', '12345', 'blog');
		mysqli_set_charset($this->baglan, 'UTF8');

		$this->hatavw = TRUE;

		if(!$this->baglan){
			print $this->hata_mesaj(mysqli_connect_errno($this->baglan));
			return false;
		}else{
			return true;
		}

	}

	#   +---------------------------+
	#   |     Select Sorguları      |
	#   +---------------------------+

	public function sorgu($sql){  #SQL sorgusu derleme
		if(!empty($sql)){
			$sql = preg_replace('/\s\s+|\t\t+/', ' ', trim($sql));
			return mysqli_query($this->baglan, $sql);
		}else{
			return false;
		}
	}

	public function ful_select($sql){  # Çoklu satır veri okuma fonksiyonu.

		$result = $this->sorgu($sql);

		if($result){

			while($veri =  mysqli_fetch_object($result)){
				$veri_dizi[] = $veri;
			}

			$this->sql_str = $sql;
			mysqli_free_result($result);
			return $veri_dizi;

		}else{
			return false;
		}

	}

	public function satir($sql){  #Tek satır veri okuma fonksiyonu.
		$result = $this->sorgu($sql);

		if($result){

			$veri = mysqli_fetch_object($result);
			mysqli_free_result($result);
			return $veri;

		}else{
			return false;
		}
	}

	public function temiz($veri){   #SQL-Injection'a karşı güvenlik fonksiyonu.

		if(is_null($veri))
			return 'NULL';

		if(is_numeric($veri))
			return $veri;

		if(function_exists('mysqli_real_escape_string')){
			$veri = mysqli_real_escape_string($this->baglan, stripslashes($veri));
		}else{
			$veri = addslashes(stripslashes($veri));
		}

		 return "'$veri'";
	}

	#   +-----------------------------------+
	#   |     İşlem Sorgusu Çalıştırma      |
	#   +-----------------------------------+
	public function islem(){   #insert, update, delete sorgusu oluşturma fonksiyonu.

		$param = func_get_args();


		if($param[0] == 'insert'){  #insert sorgusu oluşturma.

			for($i = 2; $i < count($param); $i++){
				$bol = explode('=', $param[$i], 2);
				$sutun .= $bol[0].',';
				$data .= $this->temiz($bol[1]).',';
			}

			$sql = 'insert into '.$param[1].' ('.substr($sutun, 0, -1).') values('.substr($data, 0, -1).')';

		}
		elseif($param[0] == 'update'){   #Update sorgusu oluşturma.

			for($i = 2; $i < (count($param) - 1); $i++){
				$bol = explode('=', $param[$i], 2);
				$sutun .= $bol[0].'='.$this->temiz($bol[1]).',';
			}

			$kosul = explode('=', $param[(count($param) - 1)], 2);

			$sql = "update ".$param[1]." set ".substr($sutun, 0, -1)." where ".$kosul[0].'='.$this->temiz($kosul[1]);

		}
		elseif($param[0] == 'delete'){


			$sql = "delete from ".$param[1]." where ".$param[2];
		}

		$this->sql_str = $sql;
		if($query = $this->sorgu($sql)){

			$this->affrow = mysqli_affected_rows($this->baglan);


			if($param[0] == 'insert'){
				$this->insertid = mysqli_insert_id($this->baglan);
			}

			return true;

		}else{
			return false;
		}

	}

	public function say($tablo, $kosul = NULL){    #Tablodaki kayıt sayısını alma.
		if(!empty($tablo)){
			if(is_null($kosul)){
				$sql = 'select count(*) as adet from '.$tablo;
			}else{
				$sql = 'select count(*) as adet from '.$tablo.' where '.$kosul;
			}

			$sorgu = $this->sorgu($sql);
			if($sorgu){
				$veri = mysqli_fetch_object($sorgu);
				mysqli_free_result($sorgu);
				return $veri->adet;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	#   +----------------------------------+
	#   |     Saklı Yordam Çalıştırma      |
	#   +----------------------------------+
	public function sp_call($sql, $tur){   #Saklı Yordam kullanım fonksiyonu.

		if($tur == 'ful'){

			$data = $this->ful_select($sql);
			mysqli_next_result($this->baglan);
			return $data;

		}elseif($tur == 'str'){

			$data = $this->satir($sql);
			mysqli_next_result($this->baglan);
			return $data;

		}

	}

	#   +-----------------------------+
	#   |     Dosya Önbellekleme      |
	#   +-----------------------------+
	public function cache($sql, $tur, $tm){   #Cache Fonksiyonu.

		$dosya = $this->cache_dir.md5($sql).'.cache';

		if(file_exists($dosya)){

			if(time() - filemtime($dosya) > $tm){
				$this->cache_al($sql, $dosya, $tur);
				return $this->cache_oku($dosya);
			}else{
				return $this->cache_oku($dosya);
			}

		}else{
			$this->cache_al($sql, $dosya, $tur);
			return $this->cache_oku($dosya);
		}

	}

	public function cache_oku($dosya){   #Önbellek dosyasından sorgu cache değeri okunması.
		 $veri = unserialize(file_get_contents($dosya));
		 return $veri;
	}

	public function cache_al($sql, $dosya, $tur){   # Önbellekleme fonksiyonu.

		if($tur == 'ful'){

			$this->dosya_yaz($dosya, serialize($this->ful_select($sql)));
			return true;

		}elseif($tur == 'str'){

			$this->dosya_yaz($dosya, serialize($this->satir($sql)));
			return true;

		}elseif($tur == 'sp_ful'){

			$this->dosya_yaz($dosya, serialize($this->sp_call($sql, 'ful')));
			return true;

		}elseif($tur == 'sp_str'){

			$this->dosya_yaz($dosya, serialize($this->sp_call($sql, 'str')));
			return true;

		}else{
			return false;
		}

	}

	public function dosya_yaz($yol, $veri){   #cache dosyasına veri yazılması
		$fp = fopen($yol, 'w');
		//chmod($yol, 0777);

		if( flock($fp, LOCK_EX)) {
			fwrite($fp, $veri);
			flock($fp, LOCK_UN);
		}

		//chmod($yol, 0750);
		fclose($fp);
	}

	#   +-------------------------------+
	#   |     Hata Mesajı Gösterme      |
	#   +-------------------------------+

	public function hata_mesaj($errNo){   #Hata mesajları fonksiyonu.
		$hata = array(
		// Mysql Sunucusu hata kodu ve mesajları
			1044 => 'Erişim engellendi. Veritabanı ismini kontrol edin',
			1045 => 'Erişim engellendi. Kullanıcı adını veya şifreyi kontrol edin',
			1046 => 'Veritabanı seçilemedi. Veritabanı ismini kontrol edin',
			1048 => 'İlgili kolona (sütuna) boş veri giremezsiniz',
			1049 => 'Bilinmeyen veritabanı. Veritabanı ismini kontrol edin',
			1050 => 'Zaten var olan bir tabloyu yeniden oluşturamazsınız',
			1051 => 'Bilinmeyen tablo ismi. Sql cümleciğini kontrol edin',
			1054 => 'Bilinmeyen kolon (sütun) ismi. Sql cümleciğini kontrol edin',
			1062 => 'Daha önceden zaten varolan bir kayıt eklenemez',
			1064 => 'Sorgu çalıştırılamadı. Sql cümleciğini kontrol edin',
			1115 => 'Bilinmeyen karakter seti. Sql cümleciğini kontrol edin',
			1136 => 'Kolon sayısı ile değer sayısı eşleşmiyor',
			1146 => 'Bilinmeyen tablo ismi. Sql cümleciğini kontrol edin',
			1193 => 'Bilinmeyen sistem değişkeni',
			1227 => 'Erişim engellendi. Bu işlem için gerekli yetkiniz yok',
			1292 => 'Yanlış bir değer girilmeye çalışıyor',
			1364 => 'Varsayılan değere sahip olması gereken bir alan var',
			1366 => 'Girilmeye çalışılan verilerden birisi sayısal değil',
			1406 => 'Girilmeye çalışılan verilerden birisi gereğinden fazla uzun',

			//İstemci hata kodu ve mesajları.
			2000 => 'Bilinmeyen MySQL hatası',
			2003 => 'Veritabanı sunucusuna bağlanılamadı. Adresi kontrol edin',
			2005 => 'Bilinmeyen veritabanı sunucusu. Adresi kontrol edin'
		);

		if($this->hatavw){
			return $hata[$errNo];
		}else{
			return 'Bilinmeyen bir hata oluştu.';
			//return false;
		}
	}

	public function hata_no(){  #Hata numarası bulma fonksiyonu.
		if($this->baglan){
			return mysqli_errno($this->baglan);
		}
	}

	public function __destruct() {   #Veritabanı bağlantısını kapatma fonksiyonu.
		if( $this->baglan){
			mysqli_close($this->baglan);
			$this->baglan = null;
			return;
		}
	}

}
?>
