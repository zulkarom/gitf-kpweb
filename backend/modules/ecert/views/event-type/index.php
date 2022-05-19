<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$str =  $event->event_name;
if(strlen($str) > 40){
    $str = substr($str, 0,37) . '...';
}
$this->title = $str;
$this->params['breadcrumbs'][] = ['label' => 'Event List', 'url' => ['/ecert/event']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-type-index">
<h3>Certificate Types</h3>

    <p>
        <?= Html::a('New Type', ['create', 'event' => $event->id], ['class' => 'btn btn-success']) ?>
    </p>
    
     <div class="box">
<div class="box-header"></div>
<div class="box-body">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'type_name',

            //'field2_mt',
            //'field2_size',
            //'field3_mt',
            //'field3_size',
            //'field4_mt',
            //'field4_size',
            //'field5_mt',
            //'field5_size',
            //'margin_right',
            //'margin_left',
            //'set_type',
            //'custom_html:ntext',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{cert} {update} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'cert'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-file"></span>',
                        ['/ecert/document', 'type' => $model->id], ['class'=>'btn btn-success btn-sm']);
                    },
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-edit"></span>', 
                            ['update', 'id' => $model->id], ['class'=>'btn btn-warning btn-sm']);
                    },
                    'delete'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this data?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ],
            
            ],
        ],
    ]); ?>
    
</div>
</div>


</div>
