<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Semester Modules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semester-module-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Semester Module', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'student_sem_id',
            'module_id',
            'result',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
