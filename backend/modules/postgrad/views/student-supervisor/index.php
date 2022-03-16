<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\StudentSupervisorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Supervisors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-supervisor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Student Supervisor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'supervisor_id',
            'appoint_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
