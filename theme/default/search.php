		<!--Makale Gösterim Bloğu-->
			<div class="entry">
				<div class="ust">
					<h2>Arama Sonuçları</h2>
					<div class="temiz"></div>
				</div>
				<div class="body" style="border:none;">
				<?Php
					if(count($veri) > 0){
						foreach($veri as $ara){
						
				?>
				
				<div class="search">
					<div class="baslik">
						<a href="<?=$ayar['base'].$ara->kt_seflink.'/'.$ara->mkl_seflink;?>.html"><?=$ara->mkl_baslik;?></a>
					</div>
					<div class="tarih"><?=tarih($ara->mkl_tarih);?></div>
					<div class="temiz"></div>
				</div>	
					
				
				
				<?Php		
						}
					}else{
						echo 'Aradığınız kritere uygun içerik bulunamadı.';
					}
				?>
				</div>
			</div>
		<!--Makale Gösterim Bloğu-->