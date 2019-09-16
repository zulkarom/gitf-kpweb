<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(); ?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Reject Form</h3>

</div>

<div class="box-body"> 


<?=$form->field($model, 'reject_note')->textarea(['rows' => '3']) ?>



</div>
</div>
<input type="hidden" name="form-choice" value="btn-approve" />

  <?=$form->field($model, 'reject_at')->hiddenInput(['value' => time()])->label(false)?>
  
 
<div class="form-group">

		
	<?=Html::submitButton('Reject Manuscript', ['class' => 'btn btn-danger', 'name' => 'wfaction', 'value' => 'reject', 'data' => [
                'confirm' => 'Are you sure to reject this manuscript?'
            ],
])?>

    </div>
<?php 

ActiveForm::end(); 


