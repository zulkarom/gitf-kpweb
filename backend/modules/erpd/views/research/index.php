<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\ResearchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Researches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="research-index">


    <p>
        <?= Html::a('Create Research', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

  <div class="box">
<div class="box-header"></div>
<div class="box-body">  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
		'options' => [ 'style' => 'table-layout:fixed;' ],
		
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					
					return '<a href="'.Url::to(['download-file', 'attr' => 'res', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
				}
				
			],
			[
                'attribute' => 'res_title',
				'label' => 'Title',
                'format' => 'ntext',
                'contentOptions' => [ 'style' => 'width: 60%;' ],
            ],
			[
				'attribute' => 'res_grant',
				'label' => 'Grant',
				'value' => function($model){
					return $model->researchGrant->gra_abbr;
				}
				
			],
			[
				'attribute' => 'res_progress',
				'value' => function($model){
					if($model->res_progress == 1){
						return 'Completed';
					}else{
						return 'On Going';
					}
				}
			],
            [
				'attribute' => 'status',
                'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->statusList(),['class'=> 'form-control','prompt' => 'All']),
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
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> VIEW',['/erpd/research/view', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
						}else{
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['/erpd/research/update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
						}
                        
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>
</div>
