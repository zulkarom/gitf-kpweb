<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel confmanager\models\ConfRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Registration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title"><?=$this->title?></h3>
						</div>
						<div class="panel-body">
			
			
			
			<div class="conf-registration-index">


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
				'value' => function($model){
					return $model->is_author == 1 ? 'Yes' : 'No';
				}
				
			],

            [
				'attribute' => 'is_reviewer',
				'label' => 'Reviewer',
				'value' => function($model){
					return $model->is_reviewer == 1 ? 'Yes' : 'No';
				}
				
			],

            
			
            'reg_at:datetime',

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
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
                    }

                ],
            
            ],

        ],
    ]); ?>
</div></div>
</div>
