<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\courseFiles\models\Material */

$this->title = 'Create Material Group';
$this->params['breadcrumbs'][] = ['label' => 'Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-create">
<h4><?=$course->course_code . ' ' . $course->course_name?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
