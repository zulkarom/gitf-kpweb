<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\apprentice\models\Apprentice */

$this->title = 'Update Apprentice: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Apprentices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="apprentice-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
