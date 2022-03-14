<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


    backend\assets\AppAsset::register($this);

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?> - FKP PORTAL USER MANUAL</title>
        <?php $this->head() ?>
        <style type="text/css">
        
        img {
            display: block;
              max-width: 100%;
              height: auto;
        }
        
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header-guide.php',
				['directoryAsset' => $directoryAsset]
        ) ?>
        
        <?= $this->render(
            'left-guide.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content-guide.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
