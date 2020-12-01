<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\proceedings\models\Proceeding */

$this->title = 'Update Proceeding: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Proceedings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="proceeding-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
