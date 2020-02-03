<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\modules\erpd\models\PubType;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\PublicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Publications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publication-index">

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Add Publication', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

 <div class="box">
<div class="box-header"></div>
<div class="box-body">   <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					
					return '<a href="'.Url::to(['download-file', 'attr' => 'pubupload', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
				}
				
			],
			[
				'attribute' => 'pub_year',
				'filter' => Html::activeDropDownList($searchModel, 'pub_year', $searchModel->myUniqueYear(),['class'=> 'form-control','prompt' => 'All']),
			],
            
			[
                'attribute' => 'pub_title',
                'format' => 'html',
				'value' => function($model){
					$note = '';
					if($model->status == 10){
						$note = '<br /> <span style="color:red">*Review Note: ' . $model->review_note . '</span>';
					}
					return $model->showApaStyle() . '<br /><i class="fa fa-tags"></i> by ' . $model->staff->user->fullname . $note;
				},
                'contentOptions' => [ 'style' => 'width: 50%;' ],
            ],
			
			
            [
				'attribute' => 'pub_type',
				'filter' => Html::activeDropDownList($searchModel, 'pub_type', ArrayHelper::map(PubType::find()->all(), 'id','type_name'),['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->pubType->type_name;
				},
				'label' => 'Type'
			],
			
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
						$status = $model->status;
						if($status > 10){
							 return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['/erpd/publication/update/', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
						}else{
							 return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['/erpd/publication/update/', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
						}
                       
                    },
					'delete' => function ($url, $model) {
						if($model->status == 0 or  $model->status == 10){
							return Html::a('<span class="glyphicon glyphicon-trash"></span>',['/erpd/publication/delete', 'id' => $model->id],['class'=>'btn btn-danger btn-sm', 'data' => [
								'confirm' => 'Are you sure you want to delete this publication?',
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
