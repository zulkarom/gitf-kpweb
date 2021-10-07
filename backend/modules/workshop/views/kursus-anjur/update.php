<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\KursusAnjur */

$this->title = 'Update Workshop';
$this->params['breadcrumbs'][] = ['label' => 'Kursus Anjurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kursus-anjur-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
