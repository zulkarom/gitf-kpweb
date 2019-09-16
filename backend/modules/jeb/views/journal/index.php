<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\Todo;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\staff\models\JournalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Journals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-index">

    <p>
        <?= Html::a('Create Journal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'journal_name',
			[
				'label' => 'Year',
				
				'value' => function($model){
					return $model->publishYear();
				}
			]
            ,
			[
				'attribute' => 'volume',
				'value' => function($model){
					return 'Volume ' . $model->volume;
				}
			]
            ,
			[
				'attribute' => 'issue',
				'value' => function($model){
					return 'Issue ' . $model->issue;
				}
			]
           ,
			[
				'attribute' => 'status',
				'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->journalStatus(),['class'=> 'form-control','prompt' => 'Choose Status']),
				'value' => function($model){
					return $model->statusLabel();
				}
			]
			,
			[
				'label' => 'Articles',
				'format' => 'html',
				'value' => function($model){
					return Html::a('<i class="fa fa-search"></i> Articles', ['journal/article', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm']);
				}
			]
            ,

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{view}',
                //'visible' => false,
                'buttons'=>[
                    'view'=>function ($url, $model) {
						if(Todo::can('jeb-managing-editor')){
							return '<a href="'.Url::to(['journal/update/', 'id' => $model->id]).'" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span> UPDATE</a>';
						}
                        
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>
</div>
