<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use frontend\models\Stats;

frontend\assets\ConfAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/assets/conference');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-144386179-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-144386179-1');
</script>

	<title><?= Html::encode($this->title) ?> : FAKULTI KEUSAHAWANAN DAN PERNIAGAAN</title>
	<meta charset="UTF-8">
	<meta name="description" content="Faculty of Entrepreneurship and Business">
	<meta name="keywords" content="event, fkp, creative, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->   
	<link rel="icon" type="image/x-icon" href="<?=$directoryAsset?>/img/umkicon.png" />

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i" rel="stylesheet">
	
	  <?php $this->head() ?>
	  
	   <style>@media print {#ghostery-purple-box {display:none !important}}</style>


	<!-- Stylesheets -->


	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<!--[if lt IE 9]>
    <link rel="stylesheet" href="css/ie8-core.min.css">
    <link rel="stylesheet" href="css/ie8-layout.min.css">
    <script src="js/html5shiv.min.js"></script>
    <![endif]-->

<script src="<?=$directoryAsset?>/js/rem.min.js"></script>
	

</head>
<body>
<?php $this->beginBody() ?>



	
	<header class="header-section">
		<div class="container">
						<div class="row">
				<div class="col-md-5 col-sm-12">
					
					<a href="http://fkp.umk.edu.my/index.cfm" class="site-logo"><img src="<?=$directoryAsset?>/img/logo.png" alt=""></a>
					
				</div>
				<div class="col-md-7 col-sm-12">
					<h2 style="font-family: &#39;Signika&#39;, sans-serif;font-size:18px;">
					<br>FACULTY OF ENTREPRENEURSHIP AND BUSINESS<br>
					Universiti Malaysia Kelantan
					</h2>
				</div>
			</div>
			<div class="nav-switch">
				<i class="fa fa-bars"></i>
			</div>
			<div class="header-info">

			</div>
		</div>
	</header>
	<nav class="nav-section">
		<div class="container">
			<div class="nav-right">
				<a href="http://fkp.umk.edu.my/search.cfm"><i class="fa fa-search"></i></a>
				
			</div>
			<?= $this->render('_menu') ?>
		</div>
	</nav>
	<section class="hero-section">
	<div class="row no-gutters">
	</div>
	</section>
	
		<section>
		
		
		<div class="container services">
			<div style="padding:30px;">
			<div class="row">
				<div class="col-md-12">
				
				

					
					
					
				</div>
			</div>
			</div>
		</div>
		<?= Alert::widget() ?>
		<div style="min-height:50px;"></div>
	
	</section>

	
	

	<?=$content?>
	
	<?= $this->render('_footer') ?>



<script>
$('.nav').nav();
jssor_1_slider_init();
</script>
	

<?php $this->endBody() ?>
<script>
$('.nav').nav();
jssor_1_slider_init();
</script>

</body>
</html>
<?php $this->endPage() ?>
