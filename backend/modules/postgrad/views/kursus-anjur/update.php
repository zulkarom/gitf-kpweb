<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\KursusAnjur */

$this->title = 'Update Kursus Anjur: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kursus Anjurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kursus-anjur-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
