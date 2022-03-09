<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\manual\models\Title */

$this->title = 'Update Title: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Titles', 'url' => ['index', 'section' => $model->section_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="title-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
