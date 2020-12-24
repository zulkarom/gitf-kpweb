<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\students\models\Student */

$this->title = 'Update Student: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
