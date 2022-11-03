<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Papers\' Overview';
$this->params['breadcrumbs'][] = $this->title;


$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        
        'attribute' => 'confly_number',
        'label' => 'Paper Id',
        //'contentOptions' => [ 'style' => 'width: 60%;' ],
        'value' => function($model){
        
        return $model->paperId;
        
        }
        ],
    [
        'attribute' => 'created_at',
        'label' => 'Date',
        'format' => 'date'
    ],
    [
        'label' => 'Full Name',
        'value' => function($model){
        return $model->user->fullname;
        }
        
        ],
        
        [
            'label' => 'Matric Number',
            'value' => function($model){
            if($model->user->associate){
                return $model->user->associate->matric_no;
            }
            
            }
            
            ],
            
            [
                'label' => 'Programme of Study',
                'value' => function($model){
                if($model->user->associate){
                    return $model->user->associate->programStudyText;
                }
                
                }
                
                ],
                
                [
                    'label' => 'Cumulative Semester',
                    'value' => function($model){
                    if($model->user->associate){
                        return $model->user->associate->cumm_sem;
                    }
                    
                    }
                    
                    ],
                    [
                        'label' => 'Address',
                        'value' => function($model){
                        if($model->user->associate){
                            return $model->user->associate->assoc_address;
                        }
                        
                        }
                        
                        ],
                    [
                        'label' => 'Country',
                        'value' => function($model){
                        if($model->user->associate){
                            if($model->user->associate->country){
                                return $model->user->associate->country->country_name;
                            }
                        }
                        
                        }
                        
                        ],
                        [
                            'label' => 'Phone',
                            'value' => function($model){
                            if($model->user->associate){
                                return $model->user->associate->phone;
                            }
                            
                            }
                            
                            ],
            
            [
                'label' => 'Email',
                'value' => function($model){
                    return $model->user->email;
                
                }
                
                ],
        
    [
        'label' => 'Title of Paper',
        'attribute' => 'pap_title',
        //'contentOptions' => [ 'style' => 'width: 60%;' ],
        'value' => function($model){
        
        return Html::encode($model->pap_title);
        
        }
        ],

        [
            'label' => 'Authors',
            'value' => function($model){
            
            return $model->authorString(', ');
            
            }
        ],
        
        [
            'label' => 'Field of Study',
            'value' => function($model){
            if($model->scope){
                return $model->scope->scope_name;
            }else{
                return 'NULL';
            }
            
            }
            
            ],
            
            
           
                [
                    'label' => 'Supervisors',
                    'format' => 'html',
                    'value' => function($model){
                    if($model->user->associate){
                        return $model->user->associate->getSupervisorsList("\n");
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
                                'label' => 'Reviewer Email',
                                'value' => function($model){
                                if($model->reviewer){
                                    return $model->reviewer->email;
                                }else{
                                    return 'NULL';
                                }
                                
                                }
                                
                                ],
                                
                                [
                                    'label' => 'Rate',
                                    'value' => function($model){
                                    if($model->reviewer){
                                        return $model->paperReviewer->paper_rate;
                                    }else{
                                        return '-';
                                    }
                                    
                                    }
                                    
                                    ],
                            
                            [
                                'attribute' => 'status',
                                'label' => 'Paper Status',
                                'format' => 'raw',
                                'value' => function($model){
                                return $model->statusLabel;
                                }
                                
                                ],

                                [
                                    'label' => 'Payment Status',
                                    'format' => 'raw',
                                    'value' => function($model){
                                    return $model->userRegistration->statusFeeLabel;
                                    }
                                    
                                    ],
                                    [
                                        'label' => 'Payment Category',
                                        'format' => 'raw',
                                        'value' => function($model){
                                            if($model->userRegistration->package){
                                                return $model->userRegistration->package->feeText;
                                            }
                                        
                                        }
                                        
                                        ],
                                        [
                                            'label' => 'Payment Currency',
                                            'format' => 'raw',
                                            'value' => function($model){
                                                    return $model->userRegistration->fee_currency;
                                            
                                            }
                                            
                                            ],
                                        [
                                            'label' => 'Payment Amount',
                                            'format' => 'raw',
                                            'value' => function($model){
                                                    return $model->userRegistration->fee_amount;
                                            
                                            }
                                            
                                            ],
                                
]

 
                                        
                                        ;
?>
<div class="form-group">

		
		<?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
	'filename' => 'PAPER_OVERVIEW_' . date('Y-m-d'),
	'onRenderSheet'=>function($sheet, $grid){
		$sheet->getStyle('A2:'.$sheet->getHighestColumn().$sheet->getHighestRow())
		->getAlignment()->setWrapText(true);
	},
	'exportConfig' => [
        ExportMenu::FORMAT_PDF => false,
		ExportMenu::FORMAT_EXCEL_X => false,
    ],
]);?>
		
		
		

</div>

<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title"><?=$this->title?></h3>
						</div>
						<div class="panel-body">

<div class="conf-paper-index">
    <div class="table-responsive">
    

    <?php 
    
    $web_col = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'created_at',
            'label' => 'Date',
            'format' => 'date'
        ],
        [
            
            'attribute' => 'confly_number',
            'label' => 'Paper Id',
            //'contentOptions' => [ 'style' => 'width: 60%;' ],
            'value' => function($model){
            
            return $model->paperId;
            
            }
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
            'label' => 'Field of Study',
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
            
        ]
        ];
        if($conf->is_pg == 1){
            $web_col[] = [
                'label' => 'Supervisors',
                'format' => 'html',
                'value' => function($model){
                    if($model->user->associate){
                        return $model->user->associate->supervisorsList;
                    }
                     
                }
                
            ];
        }
       

        $web_col[] = [
            'label' => 'Reviewer',
            'value' => function($model){
            if($model->reviewer){
                return $model->reviewer->fullname;
            }else{
                return '-';
            }
            
            }
            
        ];
    
        $web_col[] = [
            'label' => 'Rate',
            'value' => function($model){
            if($model->reviewer){
                return $model->paperReviewer->paper_rate;
            }else{
                return '-';
            }
            
            }
            
        ];

        $web_col[] = [
            'attribute' => 'paper_file',
            'label' => 'Download Paper',
            'format' => 'raw',
            'value' => function($model){
            if($model->paper_file){
                if($model->repaper_file){
                    $attr = 'repaper';
                }else{
                    $attr = 'paper';
                }
                return Html::a('<span class="fa fa-download"></span> Paper', ['paper/download-file', 'id' => $model->id, 'attr' => $attr], ['target' => '_blank']);
            }else{
                return '-';
            }
            
            }
        ];
        $web_col[] =[
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function($model){
            return $model->statusLabel;
            }
            
        ];
        $web_col[] = ['class' => 'yii\grid\ActionColumn',
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
    
    ];
    
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => $web_col,
			
    ]); ?>
    </div>
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
  modal.find('#con-info').load("<?=Url::to(['paper/overwrite-form', 'conf' => $conf->id, 'id' => ''])?>" + manuscript);
});

$('body').on('hidden.bs.modal', '.modal', function () {
  $(this).removeData('bs.modal');
});

</script>
<?php JSRegister::end(); ?>