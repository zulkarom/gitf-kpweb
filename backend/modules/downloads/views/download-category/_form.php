<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\downloads\models\DownloadCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="download-category-form">

<div class="box">
<div class="box-header"></div>
	<div class="box-body">    <?php $form = ActiveForm::begin(); ?>
		
		<?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>
		
		<?= $form->field($model, 'is_default')->dropdownList([1 => 'Yes', 0 => 'No']) ?>
		
		<?= $form->field($model, 'is_active')->dropdownList([1 => 'Yes', 0 => 'No']) ?>
		
		<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
		
		
		<div class="form-group">
			<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
		</div>
		
    <?php ActiveForm::end(); ?></div>
</div>

</div>
