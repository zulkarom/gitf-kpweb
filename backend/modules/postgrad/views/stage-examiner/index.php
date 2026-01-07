<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stage Examiners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stage-examiner-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Stage Examiner', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'examiner_id',
            'stage_id',
            [
                'attribute' => 'committee_role',
                'value' => function ($model) {
                    return $model->committeeRoleLabel;
                },
            ],
            'appoint_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
