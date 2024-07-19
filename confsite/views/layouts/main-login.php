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
use yii\web\NotFoundHttpException;

confsite\assets\MainAsset::register($this);
$dirAsset = Yii::$app->assetManager->getPublishedUrl('@confsite/views/myasset');

$confurl = Yii::$app->getRequest()->getQueryParam('confurl');
$conf = Conference::findOne(['conf_url' => $confurl]);

if (($conf = Conference::findOne(['conf_url' => $confurl])) == null) {
	throw new NotFoundHttpException('The requested page does not exist.');
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
	<link rel="icon" type="image/png" href="<?=$dirAsset?>/images/icons/favicon.png"/>
	
	<?php $this->head() ?>
	
	

	
</head>
<body class="animsition">
<?php $this->beginBody() ?>

<?php if($conf->is_active == 1){ ?>

	<!-- Header -->
	<?=$this->render('header',  ['conf' => $conf])?>
<section class="bg-title-page flex-col-c-m">
		<img src="<?=Url::to(['site/download-file', 'attr' => 'banner', 'url'=> $confurl])?>" width="100%" />
	</section>

	<!-- content page -->
	<section class="bgwhite">
		<div class="container">
			<div class="row">
	
				<div class="col-md-12 col-lg-12 p-b-75">
					<div class="p-r-50 p-r-0-lg">
						<!-- item blog -->
						<div class="item-blog p-b-80">
							<br/>
						
<?= Alert::widget() ?>
							<?=$content?>
						</div>

		
						
					</div>

				</div>
				
				

				
			</div>
		</div>
	</section>


	<?=$this->render('footer')?>



	<!-- Back to top -->
	<div class="btn-back-to-top bg0-hov" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="fa fa-angle-double-up" aria-hidden="true"></i>
		</span>
	</div>

	<?php }else{echo 'This conference is no longer active!';} ?>
	<?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>