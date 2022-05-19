<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\ecert\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <?php
    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?=Html::a('Create Event', ['create'], ['class' => 'btn btn-success'])?>
    </p>


     <div class="box">
<div class="box-header"></div>
<div class="box-body">

  <?php

echo GridView::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn'
        ],
        'id',
        'event_name',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{type} {certs} {update} {delete}',
            // 'visible' => false,
            'buttons' => [
                'type' => function ($url, $model) {
                    return Html::a('<span class="fa fa-cube"></span>', [
                        '/ecert/event-type',
                        'event' => $model->id
                    ], [
                        'class' => 'btn btn-info btn-sm'
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a('<span class="fa fa-edit"></span>', [
                        'update',
                        'id' => $model->id
                    ], [
                        'class' => 'btn btn-warning btn-sm'
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<span class="fa fa-trash"></span>', [
                        'delete',
                        'id' => $model->id
                    ], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this data?',
                            'method' => 'post'
                        ]
                    ]);
                }
            ]
        ]
    ]
]);
?>
</div>
</div>
</div>
