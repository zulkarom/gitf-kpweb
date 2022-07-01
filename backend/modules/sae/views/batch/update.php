<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Batch */

$this->title = 'Update Batch';
$this->params['breadcrumbs'][] = ['label' => 'Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bat_text, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="batch-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
