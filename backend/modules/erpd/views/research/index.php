<?php

use yii\helpers\Html;
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
                'attribute' => 'res_title',
                'format' => 'ntext',
                'contentOptions' => [ 'style' => 'width: 60%;' ],
            ],
			[
				'attribute' => 'res_status',
				'value' => function($model){
					if($model->res_progress == 1){
						return 'Completed';
					}else{
						return 'On Going';
					}
				}
			],
            
            'date_start',
            'date_end',
            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['/erpd/research/update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>
</div>
