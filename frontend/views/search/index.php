<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
 
$this->title = 'SEARCH RESULT';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
?>
<img src="<?=$directoryAsset?>/img/background-simple.jpg" width="100%" />

<?php $form = ActiveForm::begin([
        'action' => ['search/index'],
        'method' => 'get',
    ]); ?>
		<div class="row">
		<div class="col-md-2"></div>
			<div class="col-md-6">
			<div class="form-group">
			
			 <?= $form->field($searchModel, 'search_article')->textInput(['class' => 'form-control', 'style' => 'height:45px', 'placeholder' => 'Search articles in title, abstract or keywords...'])->label(false); ?>
			 
			</div>
			</div>
			<div class="col-md-2">
			<div class="form-group">
			
			
		
			
			 <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary', 'style' => 'height:45px']) ?>
			
			
			</div>
			</div>
		</div>
		 <?php ActiveForm::end(); ?>

<div class="block-content">
		<div class="container">
		
		<div class="row">
				<div class="col">
					<h2 class="section_title text-center">SEARCH RESULT</h2>
				</div>
		</div>
		
			<div class="row">
			
			<div class="col-lg-12">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'pager' => [
		'prevPageCssClass'=>'page-item', 
		'nextPageCssClass'=>'page-item',

        'linkOptions' => ['class' => 'page-link'],
		'disabledPageCssClass' => 'page-link',
		'activePageCssClass' => 'page-item active',


		],
		
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'title',
				'format' => 'raw',
				'label' => 'List of Articles',
				'value' => function ($model){
					return $model->title . '<br /><i>'.
					$model->stringAuthors . '</i><br/>' .
					$model->journalInfo . '<br /></i> <a href="'.Url::to($model->linkArticle()).'" target="_blank"><i class="fa fa-file-pdf-o"></i> Full Text</a>'
					;
				}
			]
           
        ],
    ]); ?>
</div>
				
				
			
			</div>
			<br />

	
			
			
		</div>
	</div>
