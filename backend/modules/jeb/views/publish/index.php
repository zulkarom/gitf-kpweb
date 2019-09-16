<?php
$this->title = 'Publish';
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use common\models\Todo;
use backend\modules\jeb\models\Journal;

$jfilter = ArrayHelper::map(Journal::find()->orderBy('id DESC')->all(),'id', 'journalName');

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\jeb\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="article-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
			 'attribute' => 'title',
			 'format' => 'html',
			 'contentOptions' => [ 'style' => 'width: 60%;' ],
			 'value' => function($model){
				 if($model->journal_id == 0){
					 return $model->title;
				 }else{
					 return $model->citation;
				 }
				 
			 }
			]
            ,

			[
				'attribute' => 'journal_id',
				'contentOptions' => ['style' => 'width: 20%'],
				'label' => 'Journal',
				'filter' => Html::activeDropDownList($searchModel, 'journal_id',$jfilter,['class'=> 'form-control','prompt' => 'Choose Journal']),
				'format' => 'html',
				'value' => function($model){
					if($model->journal_id == 0){
						return '-';
					}else{
						return $model->journal->journalName;
					}
				}
				
			],

			
			[
				'label' => 'Journal Status',
				'format' => 'html',
				'value' => function($model){
					if($model->journal_id == 0){
						return '<span class="label label-warning">NOT ASSIGNED</span>';
					}else{
						return $model->journal->statusLabel();
					}
				}
				
			],
			
			
            ['class' => 'yii\grid\ActionColumn',
				 'contentOptions' => ['style' => 'width: 20%'],
				'template' => '{view}',
				//'visible' => false,
				'buttons'=>[
					'view'=>function ($url, $model) {
								
								if(Todo::can('jeb-managing-editor')){
								$btn = '';
								if($model->journal_id == 0){
									$btn = '<a href="'.Url::to(['publish/assign/', 'id' => $model->id]).'" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span> ASSIGN</a>';
								}else if($model->journal->status == 0){
									$btn =  '<a href="'.Url::to(['publish/assign/', 'id' => $model->id]).'" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> CHANGE</a>';
								}
								
								return $btn . ' <a href="'.Url::to(['publish/update/', 'id' => $model->id]).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span> UPDATE</a>';
									
								}
							
						
					}
				],
			
			],
        ],
    ]); ?>
</div></div>
</div>

