<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\modules\sae\models\Batch;
use backend\modules\sae\models\Common;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BatchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Batches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="batch-index">

    <p>
        <?= Html::a('<span class="fa fa-plus"></span> NEW BATCH', ['batch/create'], ['class' => 'btn btn-success']);?>
    </p>

    <div class="box">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'format' => 'html',
                    'attribute' => 'bat_text',
                    'filter' => Html::activeDropDownList($searchModel, 'bat_text', ArrayHelper::map(Batch::find()->all(),'id', 'bat_text'), ['class'=> 'form-control','prompt' => 'Select Batch']),
                    'value' => function($model){
                        return $model->bat_text; 
                    }
                ], 
                [
                    'format' => 'html',
                    'attribute' => 'bat_show',
                    'filter' => Html::activeDropDownList($searchModel, 'bat_show', Common::showing() ,['class'=> 'form-control','prompt' => 'Select']),
                    'value' => function($model){
                        return $model->showText;
                    }
                ],

                ['class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width: 25%'],
                    'template' => '{view} {update} {participant}',
                    //'visible' => false,
                    'buttons'=>[
                        'view'=>function ($url, $model) {
                            return Html::a('<span class="fa fa-eye"></span> VIEW',['/sae/batch/view', 'id' => $model->id],['class'=>'btn btn-info btn-sm']);
                        },
                        'update'=>function ($url, $model) {
                            return Html::a('<span class="fa fa-edit"></span> UPDATE',['/sae/batch/update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                        },
                        'participant'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-user"></span> PARTICIPANTS',['/sae/batch/view-candidates', 'bat_id' => $model->id],['class'=>'btn btn-success btn-sm']);
                        }
                    ],
                
                ],  
            ],
        ]); ?>
    </div>
</div>


</div>
