<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\modules\erpd\models\PubType;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\PublicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Publications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publication-index">

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
				'contentOptions' => [ 'style' => 'width: 10%;' ],
				'filter' => Html::activeDropDownList($searchModel, 'pub_year', $searchModel->myUniqueYear(),['class'=> 'form-control','prompt' => 'All']),
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
				'filter' => Html::activeDropDownList($searchModel, 'status', [10 => 'SUBMIT', 20 => 'VERIFIED'],['class'=> 'form-control','prompt' => 'Choose Status']),
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
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span> VIEW',['/erpd/publication/view-verify/', 'id' => $model->id],['class'=>'btn btn-primary btn-sm']);
                       
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
