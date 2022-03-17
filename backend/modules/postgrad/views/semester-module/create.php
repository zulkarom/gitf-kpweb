<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\SemesterModule */

$this->title = 'Create Semester Module';
$this->params['breadcrumbs'][] = ['label' => 'Semester Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semester-module-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
