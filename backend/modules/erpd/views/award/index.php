<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\AwardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Awards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="award-index">

    <p>
        <?= Html::a('New Award', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'awd_name',
            [
				'attribute' => 'awd_level',
				'value' => function($model){
					return $model->levelName;
				}
			],
            'awd_by',
            'awd_date:date',
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
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> VIEW',['/erpd/award/view', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
						}else{
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['/erpd/award/update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
						}
                        
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
