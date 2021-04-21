<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\downloads\models\Download */

$this->title =  $model->student->st_name;
$this->params['breadcrumbs'][] = ['label' => 'Downloads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="download-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
