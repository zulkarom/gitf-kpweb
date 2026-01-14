<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\grant\models\Type */

$this->title = 'Update Type: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Grant Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
