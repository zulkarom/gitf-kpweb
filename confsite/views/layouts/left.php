<?php
use yii\helpers\Url;

?>

	<h4 class="m-text23 p-t-56 p-b-34">
		MENU
	</h4>
	
	<ul class="style-menu">
		<li class="p-t-6 p-b-8 bo6">
			<a href="<?=Url::to(['site/home','confurl' => $conf->conf_url])?>" class="s-text13 p-t-5 p-b-5">
				HOME
			</a>
		</li>
		
	<?php 
	$list = json_decode($conf->page_menu);
	if($list){
		foreach($list as $item){
			$page = $conf->pages[$item];
			echo '<li class="p-t-6 p-b-8 bo7">
			<a href="'. Url::to(['page/' . $page[1],'confurl' => $conf->conf_url]) . '" class="s-text13 p-t-5 p-b-5">
				'.strtoupper($page[0]).'
			</a>
		</li>';
		}
	}
	?>
	

		
		
	</ul>
	
	<!-- Categories -->
	<h4 class="m-text23 p-t-56 p-b-34">
		DOWNLOADS
	</h4>

	<ul class="style-menu">
	
	<?php 
	
	$downloads = $conf->confDownloads;
	if($downloads){
		foreach($downloads as $d){
			echo '<li class="p-t-6 p-b-8 bo7">
			<a href="'.Url::to(['download/download-file', 'id' => $d->id]).'" class="s-text13 p-t-5 p-b-5" target="_blank">
				<i class="fa fa-download"></i> '.$d->download_name .'
			</a>
		</li>';
		}
	}
	
	?>
	


		
	</ul>