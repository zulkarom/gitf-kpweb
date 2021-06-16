<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;
use backend\modules\conference\models\Conference;

confsite\assets\MainAsset::register($this);
$dirAsset = Yii::$app->assetManager->getPublishedUrl('@confsite/views/myasset');

$confurl = Yii::$app->getRequest()->getQueryParam('confurl');
$conf = Conference::findOne(['conf_url' => $confurl]);


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
	 <title><?=$this->title?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <?= Html::csrfMetaTags() ?>
	<link rel="icon" type="image/png" href="<?=$dirAsset?>/images/icons/favicon.png"/>
	
	<?php $this->head() ?>
	
	

	
</head>
<body class="animsition">
<?php $this->beginBody() ?>
	<!-- Header -->
	<?=$this->render('header',  ['conf' => $conf])?>

	<!-- Title Page -->
	<section class="bg-title-page flex-col-c-m">
		<img src="<?=Url::to(['site/download-file', 'attr' => 'banner', 'url'=> $confurl])?>" width="100%" />
	</section>

	<!-- content page -->
	<section class="bgwhite">
		<div class="container">
			<div class="row">
			<div class="col-md-3 col-lg-3 p-b-75 myleftbar">
					<div class="rightbar">
						<?= $this->render('left', [
        'conf' => $conf,
    ]) ?>

					</div>
				</div>
				<div class="col-md-6 col-lg-6 p-b-75">
					<div class="p-r-50 p-r-0-lg">
						<!-- item blog -->
						<div class="item-blog p-b-80">
						
<?= Alert::widget() ?>
							<?=$content?>
						</div>

		
						
					</div>

				</div>
				
				<div class="col-md-3 col-lg-3 p-b-75">
					<div class="rightbar">
						<!-- Search -->


						<!-- Categories -->
						<h4 class="m-text23 p-t-56 p-b-34">
							ANNOUNCEMENTS
						</h4>

						<ul class="style-menu">
							<li class="p-t-6 p-b-8 bo6">
								<span class="s-text13 p-t-5 p-b-5">
									<?=$conf->announcement?>
								</span>
							</li>
							
						
							
						</ul>
						
						<!-- Categories -->
						<h4 class="m-text23 p-t-56 p-b-34">
							IMPORTANT DATES
						</h4>

						<ul class="style-menu">
						<?php 
						
						$dates = $conf->confDates;
						if($dates){
							foreach($dates as $date){
								if($date->published == 1){
									echo '<li class="p-t-6 p-b-8 bo7">
								<a href="#" class="s-text13 p-t-5 p-b-5">
									'.$date->dateName->date_name .': <br /><strong style="margin-left:20px"><i class="fa fa-calendar"></i> '.date('d F Y', strtotime($date->date_start)) .'</strong>
								</a>
							</li>';
								}
								
							}
						}
						
						$type = $conf->type_name;
						if($type == 1){
						    $n = 'Conference';
						}else if ($type == 2){
						    $n= 'Colloquium';
						}
						
						echo '<li class="p-t-6 p-b-8 bo7">
								<a href="#" class="s-text13 p-t-5 p-b-5">
									'.$n.' Date: <br /><strong style="margin-left:20px"><i class="fa fa-calendar"></i> '.$conf->conferenceDateRange .'</strong>
								</a>
							</li>';
						
									
						?>
						
						

							
						</ul>

					</div>
				</div>

				
			</div>
		</div>
	</section>


	<!-- Footer -->
	<footer class="bg6 p-t-45 p-b-43 p-l-45 p-r-45">
		

		<div class="t-center p-l-15 p-r-15">
			
			<div class="t-center s-text8 p-t-20">
				Copyright © 2018 All rights reserved.
			</div>
		</div>
	</footer>



	<!-- Back to top -->
	<div class="btn-back-to-top bg0-hov" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="fa fa-angle-double-up" aria-hidden="true"></i>
		</span>
	</div>

	
	<?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>