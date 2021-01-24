<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\Guideline */

$this->title = 'Update Guideline: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Guidelines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="guideline-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
