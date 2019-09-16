<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\jeb\models\ReviewForm;

$form = ActiveForm::begin(); ?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Response to Author Form</h3>

</div>

<div class="box-body"> 
	<?=$form->field($model, 'response_note')->textarea(['rows' => '6']) ?>


  <?=$form->field($model, 'response_at')->hiddenInput(['value' => time()])->label(false)?>
  


<div class="form-group">

	<?=Html::submitButton('Reject', ['class' => 'btn btn-danger', 'name' => 'wfaction', 'value' => 'reject', 'data' => [
                'confirm' => 'Are you sure to reject this article?'
            ],
])?>
		
	<?=Html::submitButton('Request for Correction', ['class' => 'btn btn-success', 'name' => 'wfaction', 'value' => 'correction', 'data' => [
                'confirm' => 'Are you sure to send the response to author?'
            ],
])?>



    </div>
<?php 

ActiveForm::end(); 

?>

</div>
</div>

