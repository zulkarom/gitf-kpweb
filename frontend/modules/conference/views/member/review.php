<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\conference\models\ConfPaperSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Review';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conf-paper-index">


	<br />

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
			'contentOptions' => ['style' => 'width: 7%'],
			],

   [
				'label' => 'Paper',
				'value' => function($model){
					return $model->pap_title;
				}
				
			],
           
			
			[
				'attribute' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->paperStatus;
				}
				
			],
      

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-edit"></span> UPDATE',['member/update/', 'confurl' => $model->conference->conf_url ,'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    }
                ],
            
            ],

        ],
    ]); ?>
</div>
