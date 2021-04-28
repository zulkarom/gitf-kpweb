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

frontend\assets\ConfAsset::register($this);
$dirAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/assets/conference');

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
	<?=$this->render('header', ['conf' => $conf])?>



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
				<div class="col-md-9 col-lg-9 p-t-20 p-b-75">
				<h4 class="p-b-11">
					<a href="<?=Url::to(['/conference/site/home', 'confurl' => $confurl])?>" class="m-text24">
						<?=$conf->conf_name . ' ('.$conf->conf_abbr.')'?>
					</a>
				</h4>
					<div class="p-r-50 p-r-0-lg">
						<!-- item blog -->
						<div class="item-blog p-b-80">
						
<?= Alert::widget() ?>
							<?=$content?>
						</div>

		
						
					</div>

				</div>
				
				

				
			</div>
		</div>
	</section>


	<!-- Footer -->
	<footer class="bg6 p-t-45 p-b-43 p-l-45 p-r-45">
		

		<div class="t-center p-l-15 p-r-15">
			
			<div class="t-center s-text8 p-t-20">
				Copyright © 2018 All rights reserved. | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
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