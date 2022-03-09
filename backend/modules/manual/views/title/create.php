<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\manual\models\Title */

$this->title = 'Create Title';
$this->params['breadcrumbs'][] = ['label' => 'Titles', 'url' => ['index', 'section' => $model->section_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
