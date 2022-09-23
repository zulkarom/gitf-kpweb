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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	
	<style>
	.login-box-body{
		border-radius: 15px 50px 15px; 
		padding:28px;
		opacity: 0.95;
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
<body class="login-page">

<?php $this->beginBody() ?>

<div class="login-box">
<div class="login-box-body">

    <div class="login-logo" style="font-family:verdana">
        <b>FKP PORTAL</b><br /><span style="font-size:28px">STAFF LOGIN</span>
    </div>
	<?= Alert::widget() ?>

	<?= $content ?>
	
	
	  
		<br />
		<div align="center">
		<?= Html::a('Log In Page', ['/user/security/login']) ?></div>
</div>

</div>
    

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
