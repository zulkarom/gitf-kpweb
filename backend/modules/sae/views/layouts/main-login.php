<?php
use common\widgets\Alert;
use yii\helpers\Html;
use backend\assets\AdminleAsset;
use backend\assets\AppAsset;
use kartik\widgets\ActiveForm;

AdminleAsset::register($this);
AppAsset::register($this);
$dirAssests = Yii::$app->assetManager->getPublishedUrl('@backend/assets/adminlte');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= $dirAssests?>/pictures/mini-logo.png" type="image/png">
    <title><?= Html::encode($this->title) ?></title>

    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body class="hold-transition login-page">

<?php $this->beginBody() ?>
<?=$content?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
