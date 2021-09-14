<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\Kursus */

$this->title = 'Update Kursus: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kursuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kursus-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
