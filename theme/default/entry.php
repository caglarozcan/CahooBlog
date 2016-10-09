		<!--Makale Gösterim Bloğu-->
			<div class="entry">
				<div class="ust">
					<h2><a href="<?=$ayar['base'].$veri->kt_seflink.'/'.$veri->mkl_seflink;?>.html" title="<?=$veri->mkl_baslik;?>"><?=$veri->mkl_baslik;?></a></h2>
					<div class="sosyal">
						<a href="javascript:void(0)" title="Facebook'da Paylaş" onclick="facebook('<?=$ayar['base'].$veri->kt_seflink.'/'.$veri->mkl_seflink;?>.html')">
							<img src="theme/default/img/fb.png" alt="Facebook da Paylaş"/>
						</a>
					</div>
					<div class="temiz"></div>
				</div>
				<div class="body">
					<?Php
						if($format=='satir')
							echo html_entity_decode(str_replace('[devami]','',$veri->mkl_metin), ENT_QUOTES, 'UTF-8');
						else
							echo html_entity_decode(substr($veri->mkl_metin, 0, strpos($veri->mkl_metin, '[devami]')), ENT_QUOTES, 'UTF-8');
					?>
				</div>
				<ul class="alt">
					<li>Kategori : <a href="<?=$ayar['base'].$veri->kt_seflink;?>/1"><?=$veri->kt_adi;?></a></li>
					<li>Eklenme : <?=tarih($veri->mkl_tarih);?></li>
					<li>Okunma : <?=$veri->mkl_hit;?></li>
				</ul>
			</div>
		<!--Makale Gösterim Bloğu-->