<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel confsite\models\ConfPaperSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Review';
$this->params['breadcrumbs'][] = $this->title;
?>
<h4>My Review</h4>
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
                    if(in_array($model->status, [60,70])){
                        if($model->status == 60){
                            $txt = 'REVIEW';
                            $color = 'warning';
                        }else{
                            $txt = 'EDIT';
                            $color = 'secondary';
                        }
                         return Html::a('<span class="fa fa-edit"></span> ' . $txt ,['member/review-form/', 
                            'confurl' => $model->conference->conf_url ,'id' => $model->id],['class'=>'btn btn-'.$color.' btn-sm']);
                    }
                       
                    }
                ],
            
            ],

        ],
    ]); ?>
</div>
