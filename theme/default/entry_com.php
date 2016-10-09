<?Php
	if($ayar['yorum'] == 1 or $mysqli->say('yorum', 'yrm_drm=1 and mkl_id='.$veri->mkl_id) > 0){
?>
	<div class="entry" id="yorum">
		<div class="ust">
			<h2>Makale Yorumları</h2>
			<div class="temiz"></div>
		</div>
		<div class="body">
		<?Php
			if($mysqli->say('yorum', 'mkl_id='.$veri->mkl_id.' and yrm_drm=1') > 0){
				$data = $mysqli->ful_select('select yrm_tarih,yrm_metin,usr_adi from yorum where yrm_drm=1 and  mkl_id='.$veri->mkl_id);
				foreach($data as $yrm){
		?>
			<ul class="yorum">
				<li><?=$yrm->usr_adi;?></li>
				<li class="tarih"><?=tarih($yrm->yrm_tarih);?></li>
				<li><?=$yrm->yrm_metin;?></li>
			</ul>
		<?Php
				}
			}else{
				echo '<br/><br/><center>Bu makaleye hiç yorum eklenmemiş. <i>İlk yorumu siz ekleyebilirsiniz.</i></center><br/><br/>';
			}
		?>
		</div>
		<?Php
			if($ayar['yorum'] == 1){
		?>
		<div class="ust">
			<h2>Yorum Ekle</h2>
			<div class="temiz"></div>
		</div>
		<div class="form">
			<form name="yorum_form" action="javascript:void(0)">
				<input type="text" name="ad_soyad" class="textbox" placeholder="Adınız Soyadınız"/>
				<input type="text" name="email" class="textbox pull-right" placeholder="Email Adresiniz"/>
				<textarea name="yorum" placeholder="Yorumunuzu Buraya Yazın"></textarea>
				<input type="hidden" name="makale" value="<?=$veri->mkl_id;?>"/>
				<input type="hidden" name="form" value="yorum"/>
				<input type="submit" name="ekle_btn" value="Yorum Ekle" class="buton"/>
			</form>
		</div>
		<?Php
			}
		?>
	</div>
<?Php
	}
?>