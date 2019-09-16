<?php

use yii\bootstrap\Modal;
use backend\modules\jeb\models\ReviewForm;
use common\models\Upload;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>



<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Review Report</h3>

</div>
<div class="box-body">

<table class="table table-bordered table-striped">
        <thead>
            <tr>
				<th>Internal / External</th>
				<th width="30%">Reviewer Name<br />
				<i>(Reviewer's Field)</i></th>
				<th>Appoint At</th>
                <th>Recommended Disposition</th>
				<th>Uploaded File</th>
				 <th>Status</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php
		if($reviewers){
			foreach($reviewers as $review){
				echo '<tr>
				<td>' . $review->getInternalExternalText() . '</td>
				<td>' . $review->user->fullname . '<br />
				<i>(' . $review->scope->scope_name . ')</i></td>
				<td>'.$review->created_at .'</td>
			<td>' . ReviewForm::reviewOptions()[$review->review_option] . '</td>
			
				<td>' . Upload::showFile($review, 'reviewed', 'review') . '</td>
				
				<td>' . $review->getStatusLabel() . '</td>
				<td>';
				
	if($review->status == 20){
		Modal::begin([
		'header' => '<h5><b>REVIEW REPORT : '.strtoupper($review->user->fullname) .'</b></h5>',
		'toggleButton' => ['label' => 'VIEW', 'class'=> 'btn btn-warning btn-sm'],
		'size' => 'modal-lg'
		]);

	

	?>
	
	<div class="row">
<div class="col-md-10">

<table class="table table-striped table-hover">
<thead>
<tr>
	<th>#</th>
	<th>Review Items</th>
	<th>1 - 5 / NA 
	</th>
</tr>
</thead>
<tbody>
	
	<?php 
	
	$i =1;
	foreach(ReviewForm::find()->all() as $f){
$quest = 'q_'.$i;
$res = $review->{$quest};
if($res == 9){
	$res = 'NA';
}
		echo '<tr>
		<td>'.$i.'</td>
		<td>'.$f->form_quest.'</td>
		<td>'. $res .'</td>
	</tr>';
	$i++;
	}
	
	?>
</tbody>
</table>

<b>Review Note.</b>

<p><?=nl2br($review->review_note) ?></p>
<br />

<b>Recommended disposition of the manuscript.</b>

<p><?=ReviewForm::reviewOptions()[$review->review_option] ?></p>
<br />




</div>
</div>
	
	
	<?php

	Modal::end();
	
	}else if($review->status == 0 or $review->status == 10){
		//echo $model->status;
		
	echo Html::a('<i class="fa fa-remove"></i> Cancel', ['review/cancel-review', 'id' => $review->id ], 
		['class' => 'btn btn-danger btn-sm', 'name' => 'wfaction', 'value' => 'review-cancel', 'data' => [
                'confirm' => 'Are you sure to cancel this reviewer?'
            ],
    ]);
	

		
	}
				
				echo '</td>
				</tr>';
				
			}
		}
		
		?>
        </tbody>
        

        
    </table>
</div>
</div>

