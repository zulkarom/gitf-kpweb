<?php
use common\widgets\Alert;
use yii\helpers\Html;
use tu2i\assets\tu2iAsset;
use tu2i\assets\AppAsset;
use kartik\widgets\ActiveForm;

tu2iAsset::register($this);
AppAsset::register($this);
$dirAssests = Yii::$app->assetManager->getPublishedUrl('@tu2i/assets/tu2iAssets');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="<?= $dirAssests?>/pictures/mini-logo.png" type="image/png">
    <title><?= Html::encode($this->title) ?></title>

    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
<?=$content?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
