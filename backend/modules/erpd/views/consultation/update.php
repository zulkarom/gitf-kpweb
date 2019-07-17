<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Consultation */

$this->title = 'Update Consultation';
$this->params['breadcrumbs'][] = ['label' => 'Consultations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="consultation-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
