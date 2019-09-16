<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\jeb\models\Journal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">

<div class="journal-form">

    <?php $form = ActiveForm::begin(); ?>

		<div class="row">

<div class="col-md-6">


<?= $form->field($model, 'journal_name')->textInput() ?>


<div class="row">

<div class="col-md-3"><?= $form->field($model, 'volume')->textInput() ?></div>
<div class="col-md-3"><?= $form->field($model, 'issue')->textInput() ?></div>
<div class="col-md-6">

 <?=$form->field($model, 'published_at')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>

</div>

</div>



<?php 
if(!$model->id){
	$model->status = 0;
}
echo $form->field($model, 'status')->dropDownList(
        $model->journalStatus(), ['prompt' => 'Please Select' ]
    )
 ?>

</div>

<div class="col-md-6">

<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

</div>
</div>
	





    <div class="form-group">
        <?php 
		
		if($model->id){
			$btn = 'Update Journal';
		}else{
			$btn = 'Create Journal';
		}
		
		echo Html::submitButton($btn, ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
</div>
