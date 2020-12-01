<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\proceedings\models\Proceeding */

$this->title = 'Update Chapter in Book: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Proceedings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="proceeding-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
