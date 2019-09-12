<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'fullname',
            'email:email',


            [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view}',
	'buttons'=>[
					'view'=>function ($url, $model) {
						
						$edit = '';
						
						if($model->associate){
							$edit .= Html::a('<span class="glyphicon glyphicon-pencil"></span>Edit Info',['/user/update', 'id' => $model->id], ['class'=>'btn btn-warning btn-sm']) . ' ';
						}
						
						
						return $edit . Html::a('<span class="glyphicon glyphicon-pencil"></span> Role Assignment',['/admin/assignment/view', 'id' => $model->id], ['class'=>'btn btn-primary btn-sm']);
						
						
					
					}
				],

]
        ],
    ]); ?>
</div>
</div>
</div>