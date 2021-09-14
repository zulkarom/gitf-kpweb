<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\KursusAnjurSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Anjuran Kursus';
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?= Html::a('Anjur Kursus Baru', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<div class="box">
<div class="box-header"></div>
<div class="box-body">
<div class="kursus-anjur-index">   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Nama Kursus',
                'value' => function($model){
                    return $model->kursus->kursus_name;
                    
                }
            ],
            'kursus_siri',
            'date_start:date',
            'date_end:date',
            'capacity',
            'location',
            [
                'format' => 'html',
                'label' => 'Total Participant',
                'value' => function($model){
                    return Html::a($model->getCountPeserta($model->id),['view', 'id' => $model->id]);
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 18%'],
                'template' => '{view} {delete}',
                //'visible' => false,
                'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-eye"></span> View',['view', 'id' => $model->id],['class'=>'btn btn-primary btn-sm']);
                },
                'delete'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-trash"></span>',['delete', 'id' => $model->id],['class'=>'btn btn-danger btn-sm', 'data' => [
                    'confirm' => 'Are you sure to delete this data?'
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
