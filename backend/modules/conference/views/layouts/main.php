<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;


backend\modules\conference\assets\ManagerAsset::register($this);
$dirAsset = Yii::$app->assetManager->getPublishedUrl('@confmanager/views/manager_asset');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- Required meta tags-->
    <meta charset="UTF-8">
	<?= Html::csrfMetaTags() ?>
    <meta name="description" content="conference">
    <meta name="author" content="skyhint design">
    <meta name="keywords" content="conference manager">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="<?=$dirAsset?>/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?=$dirAsset?>/img/favicon.png">
</head>
<?php
$controller = Yii::$app->controller;
$full = '';
$arrow = 'left';
if($controller->action->id == 'overview' && $controller->id == 'paper'){
	$full = 'class="layout-fullwidth"';
	$arrow = 'right';
}

?>
<body <?=$full?>>
<?php $this->beginBody() ?>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand" style="padding-top:20px">
				<a href="<?=Url::to(['site/index'])?>">
				
				<img src="<?=$dirAsset?>/img/icon/logo-confvalley.png" alt="CONFVALLEY" class="img-responsive logo" />
				
				</a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-<?=$arrow?>-circle"></i></button>
				</div>
				<form class="navbar-form navbar-left">
					<div class="input-group">
						<input type="text" value="" class="form-control" placeholder="Search dashboard...">
						<span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
					</div>
				</form>
	
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
					
							</a>
							
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="lnr lnr-question-circle"></i> <span>Help</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
			
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?=$dirAsset?>/img/user.png" class="img-circle" alt="Avatar"> <span><?=Yii::$app->user->identity->fullname?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="#"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>
							
								<li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>
								<li>
								
				
								 <a href="<?=Url::to(['/site/logout'])?>" data-method="post"><i class="lnr lnr-exit"></i> <span>Logout</span></a>
								</li>
							</ul>
						</li>
			
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<?= $this->render('menu', [
    ]) ?>
		
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					
					
					<div class="row">
<div class="col-md-12">	<?= Alert::widget() ?></div>
</div>


					 <?=$content?>
					
					
					<!-- END OVERVIEW -->
					
					
					
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">&copy; 2017 <a href="https://www.themeineed.com" target="_blank">Theme I Need</a>. All Rights Reserved.</p>
			</div>
		</footer>
	</div>

<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>