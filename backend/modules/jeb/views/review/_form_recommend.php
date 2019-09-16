<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\modules\jeb\models\ReviewForm;

$form = ActiveForm::begin(); ?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Recommendation Form</h3>

</div>

<div class="box-body"> 
	<?=$form->field($model, 'recommend_note')->textarea(['rows' => '6']) ?>
	
<h5><b>Recommended disposition of the manuscript: check one.</b></h5>

<?php 
$options = ReviewForm::reviewOptions();
unset($options[0]);
echo $form->field($model, 'recommend_option')->radioList($options, ['encode' => false, 'separator' => '<br />']) ->label(false) ?>


  <?=$form->field($model, 'recommend_at')->hiddenInput(['value' => time()])->label(false)?>
  


<div class="form-group">

		
	<?=Html::submitButton('Make Recommendation', ['class' => 'btn btn-success', 'name' => 'wfaction', 'value' => 'recommend', 'data' => [
                'confirm' => 'Are you sure to make this recommendation?'
            ],
])?>

    </div>
<?php 

ActiveForm::end(); 

?>

</div>
</div>

