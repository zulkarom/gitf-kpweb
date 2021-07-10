<?php

use richardfan\widget\JSRegister;
use yii\helpers\Html;
use backend\modules\conference\models\ReviewForm;
use yii\widgets\ActiveForm;
use confsite\models\UploadReviewerFile as UploadFile;


$review->file_controller = 'reviewer';

?>
<?php $form = ActiveForm::begin(); ?>
	<div class="row">
<div class="col-md-12">

<h4>Review Form</h4>
<br />
If there is no remark for particular section, kindly <b>put dash (-)</b> in the corresponding text input box.
<table class="table table-striped table-hover">
<thead>
<tr>
	<th>#</th>
	<th width="35%">Review Items</th>
	<th>Remark</th>
</tr>
</thead>
<tbody>
	
	<?php 
	
	$i =1;
	foreach(ReviewForm::find()->all() as $f){
		echo '<tr>
		<td>'.$i.'</td>
		<td>'.$f->form_quest.'</td>
	
		<td>'. $form->field($review, 'q_'. $i . '_note')->textarea(['rows' => '3']) ->label(false) .'
		</td>
	</tr>';
	$i++;
	}
	
	?>
</tbody>
</table>





<h5>Overall evaluation: check one.</h5>
<br />
<div class="form-group"><?php 
$options = ReviewForm::reviewOptions();
unset($options[0]);
echo $form->field($review, 'review_option')->radioList($options, ['encode' => false, 'separator' => '<br />']) ->label(false) ;

$reject_hide = 'style="display:none"';
if($review->review_option == 1){
    $reject_hide = '';
}

?></div>


<div class="form-group" id="con-reject" <?=$reject_hide?>>
<?php echo $form->field($review, 'reject_note')->textarea(['rows' => 4])?>
</div>


<h5>Upload Reviewed/Commented Document (if any).</h5>
<br />
<?php echo UploadFile::fileInput($review, 'reviewed', $review->paper->conference->conf_url)?>
	<br /><br />

</div>
</div>
	
	
	
<div class="form-group">
<label>How likely is it that you would nominate/recommend for best paper award. 
<br />From 0 (Not all likely) to 10 (Extremely likely)</label>
<table class="table table-bordered"><tr>
<?php 


for($i=0;$i<=10;$i++){
    echo '<td align="center">'.$i.'<br /> '. 
    
        $form->field($review, 'paper_rate'
            )->radio(['label' => '', 'value' => $i, 'required' => true, 'uncheck' => null])->label(false)
    
    .' </td>';
}


?>

</tr></table>
</div>



	
	<br /><br />
<?=Html::submitButton('<i class="fa fa-save"></i> Save Review', 
    ['class' => 'btn btn-info', 'name' => 'wfaction', 'value' => 'save'
    ])?> 
<?=Html::submitButton('Submit Review <i class="fa fa-send"></i>', 
    ['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'submit', 'data' => [
                'confirm' => 'Are you sure to submit this review?'
            ],
    ])?>





    <?php ActiveForm::end(); ?>

	


<br /><br /><br />


<?php JSRegister::begin(); ?>
<script>
$("input[name='PaperReviewer[review_option]']").click(function(){
	if($(this).val() == 1){
		$('#con-reject').slideDown();
	}else{
		$('#con-reject').slideUp();
	}
});
</script>
<?php JSRegister::end(); ?>