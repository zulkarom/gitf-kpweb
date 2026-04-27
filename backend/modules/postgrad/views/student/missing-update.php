<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\postgrad\models\StudentRegister;

/* @var $this yii\web\View */
/* @var $semesterId int */
/* @var $prevSemesterId int */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students Missing Registration Update';
$this->params['breadcrumbs'][] = ['label' => 'Students List (Research)', 'url' => ['index', 'semester_id' => $semesterId]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="student-missing-update">

    <p>
        <?= Html::a('Back to Students List', ['index', 'semester_id' => $semesterId], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Student',
                'format' => 'html',
                'value' => function($model) use ($semesterId) {
                    $name = $model->user ? strtoupper($model->user->fullname) : '';
                    $matric = $model->matric_no;
                    $nric = $model->nric;
                    $line2 = trim($matric . ' | ' . $nric, " | ");
                    return Html::a($name, ['view', 'id' => $model->id, 'semester_id' => $semesterId]) . '<br />' . Html::encode($line2);
                }
            ],
            [
                'label' => 'Previous Status Daftar',
                'format' => 'raw',
                'value' => function($model) {
                    return StudentRegister::statusDaftarOutlineLabel($model->prev_status_daftar);
                }
            ],
            [
                'header' => 'Action',
                'format' => 'raw',
                'value' => function($model) use ($semesterId) {
                    return Html::a('VIEW', ['view', 'id' => $model->id, 'semester_id' => $semesterId], ['class' => 'btn btn-warning btn-sm']);
                }
            ],
        ],
    ]); ?>

</div>
