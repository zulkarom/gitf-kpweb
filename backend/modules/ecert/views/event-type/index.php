<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$str = $event->event_name;
if (strlen($str) > 40) {
    $str = substr($str, 0, 37) . '...';
}
$this->title = $str;
$this->params['breadcrumbs'][] = [
    'label' => 'Event List',
    'url' => [
        '/ecert/event'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-type-index">
<h3>Certificate Types</h3>

    <p>
        <?=Html::a('New Type', ['create','event' => $event->id], ['class' => 'btn btn-success'])?>
    </p>

     <div class="box">
<div class="box-header"></div>
<div class="box-body">

    <?php

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'
            ],

            'type_name',
            'publishLabel:html',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{cert} {update} {delete}',
                // 'visible' => false,
                'buttons' => [
                    'cert' => function ($url, $model) {
                        return Html::a('<span class="fa fa-file"></span>', [
                            '/ecert/document',
                            'type' => $model->id
                        ], [
                            'class' => 'btn btn-success btn-sm'
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="fa fa-search"></span>', [
                            'view',
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
