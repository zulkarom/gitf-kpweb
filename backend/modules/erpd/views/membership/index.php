<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\MembershipSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Memberships';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="membership-index">

    <p>
        <?= Html::a('New Membership', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<div class="box">
<div class="box-header"></div>
<div class="box-body">    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					
					return '<a href="'.Url::to(['download-file', 'attr' => 'msp', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
				}
				
			],
			[
				'attribute' => 'msp_body',
				'format' => 'html',
				'value' => function($model){
					$note = '';
					if($model->status == 10){
						$note = '<br /> <span style="color:red">*Review Note: ' . $model->review_note . '</span>';
					}
					return $model->msp_body . $note;
				}
				
			],
            
            'msp_type',
			[
				'attribute' => 'msp_level',
				'value' => function($model){
					return $model->levelName;
				}
			]
            ,
			
			[
				'attribute' => 'status',
                'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->statusList(),['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->showStatus();
				}
			],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 13.7%'],
                'template' => '{update} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						if($model->status > 10){
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> VIEW',['/erpd/membership/view', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
						}else{
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['/erpd/membership/update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
						}
                        
                    },
					'delete' => function ($url, $model) {
						if($model->status == 0 or  $model->status == 10){
							return Html::a('<span class="glyphicon glyphicon-trash"></span>',['/erpd/membership/delete', 'id' => $model->id],['class'=>'btn btn-danger btn-sm', 'data' => [
								'confirm' => 'Are you sure you want to delete this membership?',
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
