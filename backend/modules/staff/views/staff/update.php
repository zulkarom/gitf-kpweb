<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\staff\models\Staff */

$this->title = 'Update Staff';
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->staff_id, 'url' => ['view', 'id' => $model->staff_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
