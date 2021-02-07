<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\students\models\DownloadCategory */

$this->title = 'Create Download Category';
$this->params['breadcrumbs'][] = ['label' => 'Download Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="download-category-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
