<?php
$this->title = 'Article Review List';
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\Todo;
use richardfan\widget\JSRegister;

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
			 'format' => 'raw',
			 'contentOptions' => [ 'style' => 'width: 60%;' ],
			 'value' => function($model){
				 if(Todo::can('jeb-managing-editor')){
					 return "<a href='#' data-toggle='modal' idx='".$model->id."' data-target='#modal-article-info'>".$model->title ." <span class='glyphicon glyphicon-search'></span> </a>";
				 }else{
					 return $model->title;
				 }
				 
			 }
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
							case 'pre-evaluate':
							if(Todo::can('jeb-managing-editor')){
							return '<a href="'.Url::to(['review/pre-evaluate', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm"><span class="glyphicon glyphicon-pencil"></span> PRE-EVALUATE</a>';	
							}
							break;
							
							case 'assign-reviewer':
							if($model->associate_editor == Yii::$app->user->identity->id){
							return '<a href="'.Url::to(['review/assign-reviewer', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm"><span class="glyphicon glyphicon-user"></span> ASSIGN</a>';	
							}
							break;
							
							case 'review':
							$button = '';
							if(Todo::can('jeb-reviewer') and $model->isReviewer()){
								if($model->myReview->status == 20){
									$button =  '<a href="'.Url::to(['review/login-reviewer/', 'id' => $model->myReview->id]).'" class="btn btn-info btn-sm" target="_blank"><span class="glyphicon glyphicon-ok"></span> REVIEW COMPLETED</a>';
								}else{
									$button =  '<a href="'.Url::to(['review/login-reviewer/', 'id' => $model->myReview->id]).'" class="btn btn-'.$color.' btn-sm" target="_blank"><span class="glyphicon glyphicon-pencil"></span> REVIEW</a> ';
								}
								
							
							}
							if(Todo::can('jeb-associate-editor') and $model->isAssociateEditor()){
								$button .= '<a href="'.Url::to(['review/update-reviewer/', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm"><span class="glyphicon glyphicon-user"></span> MANAGE REVIEW</a>';
							}
							return $button;
							
							break;
							
													
							case 'recommend':
							if(Todo::can('jeb-managing-editor')){
								return '<a href="'.Url::to(['review/recommend/', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm"><span class="glyphicon glyphicon-pencil"></span> RECOMMEND</a>';
							}
							
							break;
							
							case 'evaluate':
							if(Todo::can('jeb-editor-in-chief')){
							return '<a href="'.Url::to(['review/evaluate/', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm"><span class="glyphicon glyphicon-pencil"></span> EVALUATE</a>';	
							}
							break;
							
							case 'response':
							if(Todo::can('jeb-managing-editor')){
							return '<a href="'.Url::to(['review/response/', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm"><span class="glyphicon glyphicon-pencil"></span> RESPONSE</a>';	
							}
							break;
							
							case 'post-evaluate':
							if(Todo::can('jeb-managing-editor')){
							return '<a href="'.Url::to(['review/post-evaluate/', 'id' => $model->id]).'" class="btn btn-'.$color.' btn-sm"><span class="glyphicon glyphicon-pencil"></span> REVIEW CORRECTION</a>';	
							}
							break;
							
							
						}
						
						if($model->isCompletedReviewer())
						return '<a href="'.Url::to(['review/login-reviewer/', 'id' => $model->myReview->id]).'" class="btn btn-info btn-sm" target="_blank"><span class="glyphicon glyphicon-ok"></span> MY REVIEW</a>';
						
					}
				],
			
			],
        ],
    ]); ?>
</div></div>
</div>

<div class="modal fade" id="modal-article-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Manuscript Details</h4>
      </div>
      <div class="modal-body" id="con-info">
	  Loading...
		

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	
    </div>
  </div>
</div>



<?php JSRegister::begin(); ?>
<script>
$('#modal-article-info').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) ;
  var manuscript = button.attr('idx') ;
  var modal = $(this);
  modal.find('#con-info').load("<?=Url::to(['review/manuscript-info', 'id' => ''])?>" + manuscript);
});

$('body').on('hidden.bs.modal', '.modal', function () {
  $(this).removeData('bs.modal');
});

</script>
<?php JSRegister::end(); ?>
