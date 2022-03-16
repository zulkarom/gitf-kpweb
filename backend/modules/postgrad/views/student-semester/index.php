<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\StudentSemesterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Semesters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-semester-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Student Semester', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'semester_id',
            'date_register',
            'status',
            'fee_amount',
            //'fee_paid_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
