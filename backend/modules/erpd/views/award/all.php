<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\AwardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Awards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="award-index">

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'staff_search',
				'label' => 'Staff',
				'value' => function($model){
					if($model->staff){
						return $model->staff->user->fullname;
					}
					
				}
				
			],
            'awd_name',
			[
				'attribute' => 'awd_level',
				'filter' => Html::activeDropDownList($searchModel, 'awd_level', $searchModel->listLevel(),['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->levelName;
				}
			]
            ,
			[
				'attribute' => 'awd_date',
				'filter' => Html::activeDropDownList($searchModel, 'duration', $searchModel->listYears(),['class'=> 'form-control','prompt' => 'All']),
				'format' => 'date',
			],
			[
				'attribute' => 'status',
                'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->statusListAdmin(),['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->showStatus();
				}
			],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						if($model->status < 50){
							return Html::a('<span class="glyphicon glyphicon-eye-open"></span> VERIFY',['/erpd/award/view-verify', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
						}else{
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> VIEW',['/erpd/award/view-verify', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
						}
                        
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
