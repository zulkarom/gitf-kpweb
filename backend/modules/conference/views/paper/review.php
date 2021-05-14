<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\conference\models\ConfPaperSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Papers in Review';
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
				'label' => 'Reviewer',
				'value' => function($model){
					//return $model->reviewer_user_id;
					if($model->reviewer){
						return $model->reviewer->fullname;
					}
					
				}
				
			],
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
							case 60:
							return Html::a('CHANGE REVIEWER',['paper/change-reviewer/', 'conf' => $model->conf_id, 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
							break;
							
							case 70:
							case 80:
							return Html::a('<i class="fas fa-dollar-sign"></i> VIEW',['paper/reviewer-view/', 'conf' => $model->conf_id, 'id' => $model->id],['class'=>'btn btn-info btn-sm']);
							break;
							
						}
                        
                    }
                ],
            
            ],

        ],
    ]); ?>
</div></div>
</div>
