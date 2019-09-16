<?php
$this->title = 'Article Editing List';
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\Todo;

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
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'id',
				'label' => 'M.script No.',
				'value' => function($model){
					return $model->manuscriptNo();
				}
			],
			[
			 'attribute' => 'title',
			 'contentOptions' => [ 'style' => 'width: 60%;' ],
			]
            ,
			
			[
				'attribute' => 'scope_id',
				'value' => function($model){
					return $model->scope->scope_name;
				}
				
			],
			
			[
				'attribute' => 'status',
				'format' => 'html',
				'value' => function($model){
					return $model->wfLabelBack;
				}
				
			],

            ['class' => 'yii\grid\ActionColumn',
				 'contentOptions' => ['style' => 'width: 8.7%'],
				'template' => '{view}',
				//'visible' => false,
				'buttons'=>[
					'view'=>function ($url, $model) {
						$color = $model->getWorkflowStatus()->getMetadata('color');
						switch($model->wfStatus){

							case 'galley-proof':
							if(Todo::can('jeb-assistant-editor') and $model->isAssistantEditor()){
							return '<a href="'.Url::to(['editing/galley/', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm"><span class="glyphicon glyphicon-pencil"></span> GALLEY PROOF</a>';	
							}
							break;
							
							case 'assign-proof-reader':
							if(Todo::can('jeb-managing-editor')){
							return '<a href="'.Url::to(['editing/assign-proof-reader/', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm"><span class="glyphicon glyphicon-user"></span> ASSIGN</a>';	
							}
							break;
							
							case 'proofread': 
							//view only
							$button = '';
							if(Todo::can('jeb-managing-editor')){
								$button .= '<a href="'.Url::to(['editing/assign-proof-reader/', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm"><span class="glyphicon glyphicon-search"></span> VIEW</a>';	
							}
							if(Todo::can('jeb-proof-reader')){
								$button .= '<a href="'.Url::to(['editing/login-proof-read/', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm" target="_blank"><span class="glyphicon glyphicon-pencil"></span> PROOFREAD</a>';	
							}
							return $button;
							break;
							
							case 'post-finalise':
							if(Todo::can('jeb-managing-editor')){
							return '<a href="'.Url::to(['editing/post-finalise/', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm"><span class="glyphicon glyphicon-pencil"></span> POST FINALISE</a>';	
							}
							break;
							
							case 'camera-ready':
							if(Todo::can('jeb-managing-editor')){
							return '<a href="'.Url::to(['editing/camera-ready/', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm"><span class="glyphicon glyphicon-pencil"></span> CAMERA READY</a>';	
							}
							break;
							
							
						}
						
					}
				],
			
			],
        ],
    ]); ?>
</div></div>
</div>

