<?php
$this->title = 'Withdrew Manuscripts';
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

							case 'withdraw-request':
							if(Todo::can('jeb-managing-editor')){
							
							return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW', ['view-withdraw', 'id' => $model->id], [
								'class' => 'btn btn-'.$color . ' btn-sm '
							]);

							break;
							
							}
							
						}
						
					}
				],
			
			],
        ],
    ]); ?>
</div></div>
</div>

