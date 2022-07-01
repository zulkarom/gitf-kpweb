<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap4\Modal;
/* @var $this yii\web\View */
/* @var $model backend\models\Batch */

$this->title = $model->bat_text;
$this->params['breadcrumbs'][] = ['label' => 'Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$column1[] = array();
$column2[] = array();
$column3[] = array();

$attributes = [
            'bat_text',
    [
        'attribute' => 'bat_show',
        'value' => function($model){
        return $model->showText;
        }
        ],
            [
                'attribute' => 'allow_register',
                'value' => function($model){
                return $model->allowText;
                }
                ],
                [
                    'attribute' => 'allow_update',
                    'value' => function($model){
                    return $model->allowUpdateText;
                    }
                    ],
                [
                    'attribute' => 'is_open',
                    'value' => function($model){
                    return $model->openText;
                    }
                    ],
                  
            [
                'attribute' => 'start_date',
                'value' => function($model){
                    if($model->start_date && $model->start_date != '0000-00-00'){
                        return date("d F Y",strtotime($model->start_date));
                    }
                }
            ],
            [
                'attribute' => 'end_date',
                'value' => function($model){
                    if($model->start_date && $model->end_date != '0000-00-00'){
                        return date("d F Y",strtotime($model->end_date));
                    }
                    
                }
            ],
            
            
            
        ];
        if($model->column1)
        {
            $attributes[] = [
                'attribute' => 'column1',
                'value' => function($model){
                    return $model->column1;
                }
            ];
        }
        if($model->column2)
        {
            $attributes[] = [
                'attribute' => 'column2',
                'value' => function($model){
                    return $model->column2;
                }
            ];
        }
        if($model->column3)
        {
            $attributes[] = [
                'attribute' => 'column3',
                'value' => function($model){
                    return $model->column3;
                }
            ];
        }
        if($model->column4)
        {
            $attributes[] = [
                'attribute' => 'column4',
                'value' => function($model){
                    return $model->column4;
                }
            ];
        }
?>
<style>
table.detail-view th {
    width:15%;
}
</style>

<div class="box">
<div class="box-body">
<div class="batch-view">

  

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>
	
	  <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('View Participants', ['view-candidates', 'bat_id' => $model->id], ['class' => 'btn btn-success']) ?>
       

        
    </p>
</div>
</div>
</div>

