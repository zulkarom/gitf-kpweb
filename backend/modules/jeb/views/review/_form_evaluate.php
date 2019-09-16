<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\jeb\models\ReviewForm;

$form = ActiveForm::begin(); ?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Evaluation Form</h3>

</div>

<div class="box-body"> 
	<?=$form->field($model, 'evaluate_note')->textarea(['rows' => '6']) ?>
	
<h5><b>Recommended disposition of the manuscript: check one.</b></h5>

<?php 
$options = ReviewForm::reviewOptions();
unset($options[0]);
echo $form->field($model, 'evaluate_option')->radioList($options, ['encode' => false, 'separator' => '<br />']) ->label(false) ?>


  <?=$form->field($model, 'evaluate_at')->hiddenInput(['value' => time()])->label(false)?>
  


<div class="form-group">

		
	<?=Html::submitButton('Submit Evaluation', ['class' => 'btn btn-success', 'name' => 'wfaction', 'value' => 'recommend', 'data' => [
                'confirm' => 'Are you sure to submit this evaluation?'
            ],
])?>

    </div>
<?php 

ActiveForm::end(); 

?>

</div>
</div>

