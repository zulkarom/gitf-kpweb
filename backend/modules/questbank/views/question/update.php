<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\questbank\models\Question */

$this->title = $model->course->course_code;

$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<h4><?=$model->qtext?></h4>
<div class="question-update">

    <?= $this->render('_form', [
        'model' => $model,
		'options' => $options,
    ]) ?>

</div>
