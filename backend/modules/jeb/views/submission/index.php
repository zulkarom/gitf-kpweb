<?php
$this->title = 'Submission List';
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\Todo;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\jeb\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;

?>


<div class="form-group">
<?=Html::a('Submit Manuscript', ['submission/submit-manuscript'] , ['class' => 'btn btn-success', 'target' => '_blank']);?>
</div>

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
							case 'correction':
							return '<a href="'.Url::to(['submission/correction', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm" target="_blank"><span class="glyphicon glyphicon-pencil"></span> CORRECT</a>';
							break;
							
							case 'finalise':
							return '<a href="'.Url::to(['submission/finalise', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm" target="_blank"><span class="glyphicon glyphicon-pencil"></span> FINALISE</a>';
							break;
						}
						
					}
				],
			
			],
        ],
    ]); ?>
</div></div>
</div>

