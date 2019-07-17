<?php

use yii\helpers\Html;
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
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'pub_year',
				'filter' => Html::activeDropDownList($searchModel, 'pub_year', $searchModel->myUniqueYear(),['class'=> 'form-control','prompt' => 'Choose Year']),
			],
            [
				'attribute' => 'pub_type',
				'filter' => Html::activeDropDownList($searchModel, 'pub_type', ArrayHelper::map(PubType::find()->all(), 'id','type_name'),['class'=> 'form-control','prompt' => 'Choose Type']),
				'value' => function($model){
					return $model->pubType->type_name;
				},
				'label' => 'Type'
			],
            
			[
                'attribute' => 'pub_title',
                'format' => 'html',
				'value' => function($model){
					return $model->showApaStyle();
				},
                'contentOptions' => [ 'style' => 'width: 60%;' ],
            ],
			
			[
				'attribute' => 'status',
                'format' => 'html',
				'value' => function($model){
					return $model->showStatus();
				}
			]

            ,

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						$status = $model->status;
						if($status > 0){
							 return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['/erpd/publication/update/', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
						}else{
							 return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['/erpd/publication/update/', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
						}
                       
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
