<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Papers\' Overview';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title"><?=$this->title?></h3>
						</div>
						<div class="panel-body">

<div class="conf-paper-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'created_at',
                'label' => 'Date',
                'format' => 'date'
            ],
			[
			    
			 'attribute' => 'pap_title',
			 'format' => 'raw',
			 //'contentOptions' => [ 'style' => 'width: 60%;' ],
			 'value' => function($model){

					 return "<a href='#' data-toggle='modal' idx='".$model->id."' data-target='#modal-article-info'>".Html::encode($model->pap_title) ."    &nbsp;<span class='glyphicon glyphicon-pencil'></span> </a>";
				 
			 }
			],
			
			[
			    'label' => 'Scope',
			    'value' => function($model){
			    if($model->scope){
			        return $model->scope->scope_name;
			    }else{
			        return 'NULL';
			    }
			    
			    }
			    
			    ],
			
			
            [
				'label' => 'Participant',
                'format' => 'html',
				'value' => function($model){
				return $model->user->fullname . '<br />(<i>' . $model->user->email . ')</i>';
				}
				
			],
			[
			    'label' => 'Supervisors',
			    'format' => 'html',
			    'value' => function($model){
    			    if($model->user->associate){
    			        return $model->user->associate->supervisorsList;
    			    }
			         
			    }
			    
			    ],
			[
				'attribute' => 'paper_file',
				'label' => 'Full Paper',
				'format' => 'raw',
				'value' => function($model){
					if($model->paper_file){
						return Html::a('Full Paper', ['paper/download-file', 'id' => $model->id, 'attr' => 'paper'], ['target' => '_blank']);
					}else{
						return 'NULL';
					}
					
				}
			],
			[
			    'label' => 'Reviewer',
			    'value' => function($model){
			    if($model->reviewer){
			        return $model->reviewer->fullname;
			    }else{
			        return 'NULL';
			    }
			    
			    }
			    
			    ],
			[
			    'attribute' => 'status',
			    'format' => 'raw',
			    'value' => function($model){
			    return $model->statusLabel;
			    }
			    
			    ],
			['class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return "<a href='javascript:void(0)' class='btn btn-warning btn-sm' data-toggle='modal' idx='".$model->id."' data-target='#modal-article-info'><span class='fa fa-edit'></span></a>";
                    },
                    'delete'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this paper?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ],
            
            ],
			/* [
				'label' => 'Role',
				'value' => function($model){
					if($model->authorRole){
						return $model->authorRole->fee_name;
					}
					
				}
				
			],
			[
				'label' => 'Invoice',
				'format' => 'raw',
				'value' => function($model){
					if($model->payment_file){
						return '<a href="'.Url::to(['paper/invoice-pdf', 'id' => $model->id]).'" target="_blank"><span class="label label-danger">Invoice</span></a>';
					}else{
						return 'Issue Now';
					}
					
				}
				
			],
			[
				'label' => 'Amount',
				'value' => function($model){
					return $model->niceAmount;
					
				}
				
			],
			[
				'label' => 'Payment',
				'value' => function($model){
					if($model->receipt_ts == 0){
						return 'NO';
					}else{
						return 'YES';
					}
					
				}
				
			],
			[
				'label' => 'Presenter',
				'value' => function($model){
					if($model->attending == 0){
						return 'NO';
					}else{
						return 'YES';
					}
				}
				
			], */
			
			

        ],
    ]); ?>
</div></div>
</div>



<div class="modal fade" id="modal-article-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Paper Details</h4>
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
  modal.find('#con-info').load("<?=Url::to(['paper/overwrite-form', 'conf' => $conf, 'id' => ''])?>" + manuscript);
});

$('body').on('hidden.bs.modal', '.modal', function () {
  $(this).removeData('bs.modal');
});

</script>
<?php JSRegister::end(); ?>