<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\AuthAssignment;

$form = ActiveForm::begin(); ?>
 

<input type="hidden" name="form-choice" value="btn-approve" />

<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Assistant Editor Assignment</h3>

</div>

<div class="box-body"> 


<div class="row">
<div class="col-md-6"><?=$form->field($model, 'assistant_editor')->dropDownList(
        ArrayHelper::map(AuthAssignment::getUsersByAssignment('jeb-assistant-editor'),'user_id', 'user.fullname'), ['prompt' => 'Please Select' ]
    ) 
 ?></div>

</div>



</div>
</div>

  <?=$form->field($model, 'post_evaluate_at')->hiddenInput(['value' => time()])->label(false)?>
  
 
<div class="form-group">

		
	<?=Html::submitButton('Accept Manuscript and Send to Galley Proof', ['class' => 'btn btn-success', 'name' => 'wfaction', 'value' => 'send-galley', 'data' => [
                'confirm' => 'Are you sure to send this manuscript to galley proof?'
            ],
])?>

    </div>
<?php 

ActiveForm::end(); 


