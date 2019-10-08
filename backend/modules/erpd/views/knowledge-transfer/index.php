<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\KnowledgeTransferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Knowledge Transfers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="knowledge-transfer-index">

    <p>
        <?= Html::a('Create Knowledge Transfer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					
					return '<a href="'.Url::to(['download-file', 'attr' => 'ktp', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
				}
				
			],
			[
				'attribute' => 'ktp_title',
				'format' => 'html',
				'value' => function($model){
					return $model->ktp_title . ' <i class="fa fa-tags"></i> by ' . $model->staff->user->fullname;
				}
				
			],
            
			'ktp_source',
			'ktp_community',
			
			[
				'attribute' => 'status',
                'format' => 'html',
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
						if($model->status > 10){
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> VIEW',['/erpd/knowledge-transfer/view', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
						}else{
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['/erpd/knowledge-transfer/update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
						}
                        
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
