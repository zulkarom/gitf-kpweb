<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\AuthAssignment;
use common\models\Upload;

$model->file_controller = 'submission';


$form = ActiveForm::begin(); ?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Assignment Form</h3>

</div>

<div class="box-body"> 

 <?= $form->field($model, 'associate_editor')->dropDownList(
        ArrayHelper::map(AuthAssignment::getUsersByAssignment('jeb-associate-editor'),'user.id', 'user.fullname'), ['prompt' => 'Please Select' ]
    ) ?>




<div class="form-group">
<?=Upload::fileInput($model, 'review')?>
</div>

<?=$form->field($model, 'pre_evaluate_note')->textarea(['rows' => '3']) ?>

</div>
</div>
<input type="hidden" name="form-choice" value="btn-approve" />

  <?=$form->field($model, 'asgn_reviewer_at')->hiddenInput(['value' => time()])->label(false)?>
  
 




<div class="form-group">

		
	<?=Html::submitButton('Assign Associate Editor', ['class' => 'btn btn-success', 'name' => 'wfaction', 'value' => 'assign-associate', 'data' => [
                'confirm' => 'Are you sure to assign this associate editor?'
            ],
])?>

    </div>
<?php 

ActiveForm::end(); 


