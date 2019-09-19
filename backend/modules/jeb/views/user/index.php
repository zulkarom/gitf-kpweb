<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="user-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'fullname',
			[
				'label' => 'Roles',
				'format' => 'html',
				'value' => function($model){
					$str = '';
					$roles = $model->authAssignments;
					if($roles){
						foreach($roles as $role){
							$str .= $role->itemName->description . '<br />';
						}
					}
					return $str;
				}
			]
            ,
			[
				'label' => 'Fields',
				'format' => 'html',
				'value' => function($model){
					$str = '';
					$scopes = $model->userScopes;
					if($scopes){
						foreach($scopes as $scope){
							$str .= $scope->scope->scope_name . '<br />';
						}
					}
					return $str;
				}
			]
            ,


            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{view}',
                //'visible' => false,
                'buttons'=>[
                    'view'=>function ($url, $model) {

                        return '<a href="'.Url::to(['user/view/', 'id' => $model->id]).'" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span> UPDATE</a>';
                    }
                ],
			]

        ],
    ]); ?>
</div></div>
</div>