<?php

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





<h5>6.	Overall evaluation: check one.</h5>
<br />
<div class="form-group"><?php 
$options = ReviewForm::reviewOptions();
unset($options[0]);
echo $form->field($review, 'review_option')->radioList($options, ['encode' => false, 'separator' => '<br />']) ->label(false) ?></div>

<h5>Upload Reviewed Manuscript if any.</h5>
<br />
<?php echo UploadFile::fileInput($review, 'reviewed', $review->paper->conference->conf_url)?>
	<br /><br />

</div>
</div>
	
	



	
	
<?=Html::submitButton('<i class="fa fa-save"></i> Save Review', 
    ['class' => 'btn btn-info', 'name' => 'wfaction', 'value' => 'save'
    ])?> 
<?=Html::submitButton('Submit Review <i class="fa fa-send"></i>', 
    ['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'submit', 'data' => [
                'confirm' => 'Are you sure to submit this review?'
            ],
    ])?>



    </div>

    <?php ActiveForm::end(); ?>

	


<br /><br /><br />