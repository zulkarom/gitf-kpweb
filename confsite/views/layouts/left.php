<?php
use yii\helpers\Url;

?>


<h4 class="m-text23 p-t-56 p-b-34">
		MEMBER
	</h4>
	<ul class="style-menu">
<?php 
if (Yii::$app->user->isGuest) {
?>
		<li class="p-t-6 p-b-8 bo6">
			<a href="<?=Url::to(['/page/submission','confurl' => $conf->conf_url])?>" class="s-text13 p-t-5 p-b-5">
			SUBMIT PAPER
			</a>
		</li>
		<li class="p-t-6 p-b-8 bo6">
			<a href="<?=Url::to(['/site/login','confurl' => $conf->conf_url])?>" class="s-text13 p-t-5 p-b-5">
			LOGIN / REGISTER
			</a>
		</li>

<?php
}else{
?>

<li class="p-t-6 p-b-8 bo6">
			<a href="<?=Url::to(['/member/paper','confurl' => $conf->conf_url])?>" class="s-text13 p-t-5 p-b-5">
			PAPER SUBMISSION
			</a>
		</li>

		<li class="p-t-6 p-b-8 bo6">
			<a href="<?=Url::to(['/member/review','confurl' => $conf->conf_url])?>" class="s-text13 p-t-5 p-b-5">
			MY REVIEW
			</a>
		</li>

		
		<?php
		if($conf->commercial){
			?>
		<li class="p-t-6 p-b-8 bo6">
			<a href="<?=Url::to(['/payment/index','confurl' => $conf->conf_url])?>" class="s-text13 p-t-5 p-b-5">
			FEE PAYMENT
			</a>
		</li>
			<?php
		}
		?>

<li class="p-t-6 p-b-8 bo6">
			<a href="<?=Url::to(['/member/profile','confurl' => $conf->conf_url])?>" class="s-text13 p-t-5 p-b-5">
			PROFILE
			</a>
		</li>

		<li class="p-t-6 p-b-8 bo6">
			<a href="<?=Url::to(['/site/logout','confurl' => $conf->conf_url])?>" class="s-text13 p-t-5 p-b-5">
			LOG OUT
			</a>
		</li>


<?php
}
?>
</ul>

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