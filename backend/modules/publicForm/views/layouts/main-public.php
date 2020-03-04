<?php
use yii\helpers\Html;
use dmstr\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
backend\assets\AppAsset::register($this);
$dirAsset = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> : FKP ONLINE FORM</title>
    <?php $this->head() ?>
	
	<style>
	.mybox{
		margin-top:10px;
	}
	.login-mybox-body{
		border-radius: 15px 15px 15px; 
		padding:28px;
		background-color:#FFFFFF;
		opacity: 0.99;
  filter: alpha(opacity=95); 
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}
	.login-page {
		background-image: url('<?=$dirAsset?>/img/bg.jpg');
		background-repeat: no-repeat;
		background-size: cover; 
	}
</style>
</head>
<body class="login-page" >

<?php $this->beginBody() ?>

<div class="row">
<div class="col-md-1"></div>

<div class="col-md-10">
<div class="mybox">
<div class="login-mybox-body" style="padding:20px;">

    <div style="font-family:verdana" align="center">
        <span style="font-size:18px;">FKP ONLINE FORMS</span><br /><span style="font-size:28px; font-weight:bold"><?=$this->title?></span>
    </div>
	<?= Alert::widget() ?>

	<?= $content ?>
	
	
	  
		<br />
		<div align="center">
		</div>
</div>

</div>
</div>

</div>


    

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
