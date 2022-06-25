<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel confmanager\models\ConfRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Participants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-headline">
					
						<div class="panel-body">
			
			
			
			<div class="conf-registration-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'fullname',
				'label' => 'Name',
				'value' => function($model){
					return $model->user->fullname;
				}
				
			],
			[
				'attribute' => 'email',
				'label' => 'Email',
				'value' => function($model){
					return $model->user->email;
				}
				
			],

            [
				'attribute' => 'is_author',
				'label' => 'Author',
				'filter' => Html::activeDropDownList($searchModel, 'is_author', [0 => 'No', 1=>'Yes'],['class'=> 'form-control','prompt' => 'Choose']),
				'value' => function($model){
					return $model->is_author == 1 ? 'Yes' : 'No';
				}
				
			],

            [
				'attribute' => 'is_reviewer',
				'label' => 'Reviewer',
				'filter' => Html::activeDropDownList($searchModel, 'is_reviewer', [0 => 'No', 1=>'Yes'],['class'=> 'form-control','prompt' => 'Choose']),
				'value' => function($model){
					return $model->is_reviewer == 1 ? 'Yes' : 'No';
				}
				
			],

			[
				'attribute' => 'fee_status',
				'label' => 'Payment',
				'filter' => Html::activeDropDownList($searchModel, 'fee_status',$searchModel->listFeeStatus(),['class'=> 'form-control','prompt' => 'Choose']),
				'value' => function($model){
					return $model->statusFeeLabel;;
				}
				
			],

			[
				'label' => 'Paper',
				'value' => function($model){
					//return $model->statusFeeLabel;;
				}
				
			],

            
			
           // 'reg_at:datetime',

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{view} {update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-trash"></span>', ['unregister', 'id' => $model->id, 'conf' => $model->conf_id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to unregister this user?',
                'method' => 'post',
            ],
        ]) 
;
                    },
					'view'=>function ($url, $model) {
                        return Html::a('View', ['view', 'id' => $model->id, 'conf' => $model->conf_id], [
            'class' => 'btn btn-warning btn-sm',
        ]) 
;
                    }

                ],
            
            ],

        ],
    ]); ?>
</div></div>
</div>
