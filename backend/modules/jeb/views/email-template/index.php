<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Email Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-template-index">

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'on_enter_workflow',
			[
				'attribute' => 'target_role',
				'format' => 'html',
				'value' => function($model){
					return $model->showRoleString();
				}
			],
			'description',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{view}',
                //'visible' => false,
                'buttons'=>[
                    'view'=>function ($url, $model) {

                        return '<a href="'.Url::to(['email-template/update/', 'id' => $model->id]).'" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-envelope"></span> UPDATE</a>';
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>
</div>
