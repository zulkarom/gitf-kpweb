<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\ConsultationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consultations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultation-index">


    <p>
        <?= Html::a('New Consultation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

   <div class="box">
<div class="box-header"></div>
<div class="box-body"> <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					
					return '<a href="'.Url::to(['download-file', 'attr' => 'csl', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
				}
				
			],
			[
				'attribute' => 'csl_title',
				'format' => 'html',
				'value' => function($model){
					$note = '';
					if($model->status == 10){
						$note = '<br /> <span style="color:red">*Review Note: ' . $model->review_note . '</span>';
					}
					return $model->csl_title . $note;
				}
				
			],
            
            [
				'attribute' => 'csl_funder',
				'label'  => 'Funder'
			],
            //'csl_amount',
            [
				'attribute' => 'csl_level',
				'value' => function($model){
					return $model->levelName;
				}
			],
            //'date_start',
            //'date_end',
            //'csl_file',
			
			[
				'attribute' => 'status',
                'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->statusList(),['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->showStatus();
				}
			]

            ,

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 13.7%'],
                'template' => '{update} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						if($model->status > 10){
							return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['/erpd/consultation/view', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
						}else{
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['/erpd/consultation/update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
						}
                        
                    },
					'delete' => function ($url, $model) {
						if($model->status == 0 or  $model->status == 10){
							return Html::a('<span class="glyphicon glyphicon-trash"></span>',['/erpd/consultation/delete', 'id' => $model->id],['class'=>'btn btn-danger btn-sm', 'data' => [
								'confirm' => 'Are you sure you want to delete this consultation?',
								'method' => 'post',
							],
							]);
						}else{
							return '';
						}
                        
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
