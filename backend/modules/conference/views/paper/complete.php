<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\conference\models\ConfPaperSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Completed Papers';
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
                
                'attribute' => 'confly_number',
                'label' => 'Paper Id',
                //'contentOptions' => [ 'style' => 'width: 60%;' ],
                'value' => function($model){
                
                return $model->paperId;
                
                }
                ],
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
               //  'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{download} {update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-eye"></span> VIEW',['paper/complete-view/', 'conf' => $model->conf_id, 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
                    'download'=>function ($url, $model) {
                    if($model->paper_file){
                        if($model->repaper_file){
                            $attr = 'repaper';
                        }else{
                            $attr = 'paper';
                        }
                        return Html::a('<span class="fa fa-download"></span> Download', ['paper/download-file', 'id' => $model->id, 'attr' => $attr], ['class' => 'btn btn-danger btn-sm','target' => '_blank']);
                    }
                    }
                ],
            
            ],

        ],
    ]); ?>
</div></div>
</div>
