<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\KursusPeserta */

$this->title = 'Update Pendaftaran Kursus ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pendaftaran Kursus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kursus-peserta-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
