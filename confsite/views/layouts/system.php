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
if($conf){
	$conf_name = $conf->conf_name . ' ('. $conf->conf_abbr .')';
}


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
	 <title><?=$this->title?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <?= Html::csrfMetaTags() ?>
	
	<?php $this->head() ?>
	
	<style>
.btn-primary {
    color: #fff;
    background-color: #13294e;
    border-color: #13294e;
}
</style>

	
</head>
<body class="animsition">

<?php $this->beginBody() ?>


<section class="flex-col-c-m" style="background-color:#13294e;margin-bottom:30px;">
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">


	<a href="<?=Url::to(['/site/home','confurl' => $confurl])?>" style="color:white;font-weight:bold">
		<h1 style="margin-top:20px;text-align:center;font-size:30px;margin-bottom:30px;"><?=$conf_name?></h1></a>
	</div>
</div>

	</section>

	<!-- content page -->
	<section class="bgwhite">
		<div class="container">
		
			<div class="row">
		
				<div class="col-md-12 col-lg-12 p-b-75">
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
				Copyright © FKP Portal | Conference Management System | All rights reserved.
			</div>
		</div>
	</footer>





	
	<?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>