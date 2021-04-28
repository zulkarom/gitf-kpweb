<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\conference\models\ConfPaperSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accepted Full Papers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title"><?=$this->title?></h3>
						</div>
						<div class="panel-body">
			
			
<div class="conf-paper-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
				'attribute' => 'fullname',
				'label' => 'Name',
				'value' => function($model){
					return $model->user->fullname;
				}
				
			],
            'pap_title:ntext',
			[
				'attribute' => 'status',
				'format' => 'raw',
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
						$status = $model->status;
						switch($status){
							case 80:
							case 95:
							return Html::a('ACCEPTANCE LETTER <br />& INVOICE',['paper/invoice-view/', 'conf' => $model->conf_id, 'id' => $model->id],['class'=>'btn btn-info btn-sm']);
							break;
							
							
							case 90:
							
							return Html::a('<i class="fas fa-dollar-sign"></i> REVIEW PAYMENT',['paper/payment-view/', 'conf' => $model->conf_id, 'id' => $model->id],['class'=>'btn btn-info btn-sm']);
							break;
							
						}
                        
                    }
                ],
            
            ],

        ],
    ]); ?>
</div></div>
</div>
