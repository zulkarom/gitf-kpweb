<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\courseFiles\models\MaterialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Teaching Materials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-index">

<h4><?=$course->course_code . ' ' . $course->course_name?></h4>
    <p>
	 <?= Html::a('Back to Course File', ['coordinator/current-coordinator-page', 'course' => $course->id], ['class' => 'btn btn-info']) ?> 
        <?= Html::a('Create Material Group', ['create', 'course' => $course->id], ['class' => 'btn btn-success']) ?>
    </p>

<div class="box">
<div class="box-header"></div>
<div class="box-body">    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        ///'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'material_name',
            'typeDesc',
            [
			'label' => 'Count Items',
                'value' => function($model){
                    return count($model->items);
                    
                }
                
            ],
            
            [
			'label' => 'Editable',
                'format' => 'html',
                'value' => function($model){
                    return $model->editableLabel;
                    /* if($model->status == 1){
                        return 'YES';
                    }else{
                        return 'NO';
                    } */
                    
                }
                
            ],

           

			'created_at:date',
            
			
			['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-search"></span> View ',['view', 'id' => $model->id],['class'=>'btn btn-primary btn-sm']);
                    },
					
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
