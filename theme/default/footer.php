		</div>
		<div class="sag">
			
			<div class="panel">
				<form name="ara_from" method="get" action="arama.html">
					<input type="text" name="q" placeholder="Arama" class="stextbox"/>
					<button class="sbuton" onclick="this.ara_form.submit();">
						<img src="theme/default/img/find.png" alt="Ara" title="Ara"/>
					</button>
				</form>
				<div class="temiz"></div>
			</div>
			
			<!--Kategori Listeleme-->	
			<div class="panel">
				<span>
					Kategoriler
				</span>
				<ul>
				<?Php
					$veri = $mysqli->ful_select('select * from kategori where kt_drm = 1');
					foreach($veri as $kat){
				?>
					<li><a href="<?=$ayar['base'].$kat->kt_seflink;?>/1"><?=$kat->kt_adi;?></a></li>
				<?}?>
				</ul>
			</div>
			<!--Kategori Listeleme-->
			
			<!--Kategori Listeleme-->	
			<div class="panel">
				<span>
					İlgi Gören Makaleler
				</span>
				<ul>
				<?Php
					$veri = $mysqli->ful_select("select mkl_baslik,mkl_seflink,kt_seflink from makale,mkl_kt,kategori where makale.mkl_id=mkl_kt.mkl_id and mkl_kt.kt_id=kategori.kt_id order by mkl_hit DESC LIMIT 5");
					foreach($veri as $kat){
				?>
					<li><a href="<?=$ayar['base'].$kat->kt_seflink.'/'.$kat->mkl_seflink;?>.html"><?=$kat->mkl_baslik;?></a></li>
				<?}?>
				</ul>
			</div>
			<!--Kategori Listeleme-->
			<!--Referanslar-->	
			<div class="panel">
				<span>
					Referanslar
				</span>
				<ul>
					<li><a href="http://www.facebook.com/caglar.ozcan" target="_blank">Facebook Profilim</a></li>
					<li><a href="https://plus.google.com/u/0/101564539953603280760" target="_blank">Google Profilim</a></li>
				</ul>
			</div>
			<!--Referanslar-->
		
		</div>
		<div class="temiz"></div>
		<footer>
			Copyright &copy; Çağlar ÖZCAN
		</footer>
	</div>
	
</body>
</html>
