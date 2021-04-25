<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\courseFiles\models\MaterialAdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Teaching Materials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="material-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'course',
				'label' => 'Course',
				'value' => function($model){
					return $model->course->course_code . ' ' . $model->course->course_name;
				}
				
			],
            'material_name',
			[
				'attribute' => 'status',
				'label' => 'Status',
				'filter' => Html::activeDropDownList($searchModel, 'status', [0 => 'DRAFT', 10 => 'SUBMIT'],['class'=> 'form-control','prompt' => 'Choose Status']),
				'format' => 'html',
				'value' => function($model){
					return $model->statusName;
				}
				
			],
			
			['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['view', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
                ],
            
            ],
        ],
    ]); ?>
</div></div>
</div>

