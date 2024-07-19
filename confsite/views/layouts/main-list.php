<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

confsite\assets\MainAsset::register($this);
$dirAsset = Yii::$app->assetManager->getPublishedUrl('@confsite/views/myasset');

$confurl = Yii::$app->getRequest()->getQueryParam('confurl');

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
	
	

	
</head>
<body class="animsition">
<?php $this->beginBody() ?>
	<!-- Header -->

	<!-- content page -->
	<section class="bgwhite">
		<div class="container">
			<div class="row">
			<div class="col-md-1 col-lg-1 p-b-75">
					
				</div>
				<div class="col-md-10 col-lg-10 p-b-75">
					<?=$content?>

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

	
	<?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>