<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Upload;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\TmplAppointmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Appointment Letter Template';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tmpl-appointment-index">

    <div class="box">
<div class="box-header"></div>
<div class="box-body">  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'template_name',
            'dekan',
            'created_at:ntext',
            //'per1:ntext',
            //'signiture_file:ntext',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 15%'],
                'template' => '{update} {copy}',
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
                    'copy'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-copy"></span> Copy',['create', 'id' => $model->id],['class'=>'btn btn-success btn-sm']);
                    },
                    
                ],
            
            ],
        ],
    ]); ?></div>
</div>
</div>
