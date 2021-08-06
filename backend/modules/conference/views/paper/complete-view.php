<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\modules\conference\models\ReviewForm;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = 'View Complete Paper';
$this->params['breadcrumbs'][] = ['label' => 'Conf Papers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="panel panel-headline">
						<div class="panel-body">
<style>
table.detail-view th {
    width:15%;
}
</style>

			
			<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                
                'attribute' => 'confly_number',
                'label' => 'Paper Id',
                //'contentOptions' => [ 'style' => 'width: 60%;' ],
                'value' => function($model){
                
                return $model->paperId;
                
                }
                ]
			,
			[
			    'attribute' => 'status',
			    'format' => 'raw',
			    'value' => function($model){
			    return $model->statusLabel;
			    }
			    
			    ],
            'pap_title:ntext',
			[
				'label' => 'Authors',
				'format' => 'html',
				'value' => function($model){
					return $model->authorString();
				}
				
			],
            'pap_abstract:ntext',
			'keyword:ntext',
			[
				'attribute' => 'myrole',
				'label' => 'Role Selection',
				'value' => function($model){
					if($model->authorRole){
						return $model->authorRole->fee_name;
					}
					
				}
				
			],
			[
				'attribute' => 'paper_file',
				'label' => 'Full Paper (Fist Submission)',
				'format' => 'raw',
				'value' => function($model){
				    
				if($model->paper_file){

				    return Html::a('<span class="fa fa-download"></span> Download', ['paper/download-file', 'id' => $model->id, 'attr' => 'paper'], ['class' => 'btn btn-warning btn-sm','target' => '_blank']);
				}
				
				
			
				}
			],
			
			[
			    'attribute' => 'paper_file',
			    'label' => 'Full Paper (Reviewed)',
			    'format' => 'raw',
			    'value' => function($model){
			    
			    if($model->paper_file){
			        return Html::a('<span class="fa fa-download"></span> Download', ['paper/download-file', 'id' => $model->id, 'attr' => 'repaper'], ['class' => 'btn btn-success btn-sm','target' => '_blank']);
			    }
			    
			    
			    
			    }
			 ],
			
			[
			    'label' => 'Supervisors',
			    'format' => 'raw',
			    'value' => function($model){
			    
			    if($model->user->associate){
			        $assoc= $model->user->associate;
			        $str = strtoupper($assoc->sv_main) . ' (MAIN)<br />';
			        if($assoc->sv_co1 and trim($assoc->sv_co1) != ''){
			            $str .= strtoupper($assoc->sv_co1) . ' (CO.SV I)<br />';
			        }
			        if($assoc->sv_co2){
			            $str .= strtoupper($assoc->sv_co1) . ' (CO.SV II)<br />';
			        }
			        if($assoc->sv_co3){
			            $str .= strtoupper($assoc->sv_co1) . ' (CO.SV III)<br />';
			        }
			        return $str;
			    }
			    
			    
			    }
			    ],
			    
			    [
			        'label' => 'Reviewer',
			        'value' => function($model){
			        //return $model->reviewer_user_id;
			    if($model->reviewer){
			        return $model->reviewer->fullname;
			    }
			    
			        }
			        
			        ],
			        
			        
			 
			    
			    
			    
			/* [
				'label' => 'Invoice',
				'format' => 'raw',
				'value' => function($model){
					if($model->payment_file){
						return '<a href="'.Url::to(['paper/invoice-pdf', 'id' => $model->id]).'" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-download"></i> DOWNLOAD INVOICE</a>';
					}else{
						return 'NO FILE';
					}
					
				}
				
			],
			[
				'label' => 'Invoice Amount',
				'value' => function($model){
					return $model->invoice_currency . ' ' . number_format($model->invoice_amount, 2);
					
				}
				
			],
			'payment_at:datetime',
			'payment_info:ntext',
			[
				'attribute' => 'payment_file',
				'format' => 'raw',
				'value' => function($model){
					if($model->payment_file){
						return '<a href="'.Url::to(['paper/download-file', 'attr' => 'payment', 'id' => $model->id]).'" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-download"></i> DOWNLOAD PAYMENT</a>';
					}else{
						return 'NO FILE';
					}
					
				}
				
			], */
  
        ],
    ]) ?></div>
</div>


<div class="box">
<div class="box-header">
<h4>Review</h4>
</div>
<div class="box-body">


<br />
<table class="table table-striped table-hover">
<thead>
<tr>
	<th width="1%">#</th>
	<th width="35%">Review Items</th>
	<th>Remark</th>
</tr>
</thead>
<tbody>
	
	<?php 
	
	$i =1;
	foreach(ReviewForm::find()->all() as $f){
	    $attr = 'q_'. $i . '_note';
	    echo '<tr>
		<td>'.$i.'. </td>
		<td>'.$f->form_quest.'</td>
	
		<td> ' . $review->$attr .' </td>
	</tr>';
	$i++;
	}
	
	
	if($review->reviewed_file){
	    echo '<tr>
		<td> </td>
		<td><a href="'. Url::to(['paper/download-reviewed-file', 'id' => $review->id, 'attr' => 'reviewed']) .'" target="_blank" class="btn btn-primary btn-xs"> <span class="glyphicon glyphicon-download-alt"></span> Reviewer\'s Additional File</a></td>
    
		<td> </td>
	</tr>';
	}
	
	?>
</tbody>
</table>

</div>
</div>
