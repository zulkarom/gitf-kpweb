<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Award */

$this->title = 'Update Award';
$this->params['breadcrumbs'][] = ['label' => 'Awards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="award-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
