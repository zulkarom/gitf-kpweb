<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\downloads\models\DownloadCategory */

$this->title = 'Update: ' . $model->category_name;
$this->params['breadcrumbs'][] = ['label' => 'Download Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="download-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
