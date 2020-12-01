<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UploadFile;

$model->file_controller = 'paper';

/* @var $this yii\web\View */
/* @var $model backend\modules\proceedings\models\Paper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paper-form">

    <?php $form = ActiveForm::begin(); ?>

 
    <?= $form->field($model, 'paper_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paper_no')->textInput() ?>

    <?= $form->field($model, 'paper_page')->textInput(['maxlength' => true]) ?>

    <?php 
	if(!$model->isNewRecord){
		echo UploadFile::fileInput($model, 'paper');
		$button = 'Save';
	}else{
		$button = 'Next';
	}
	
	
	?>

    <div class="form-group">
        <?= Html::submitButton($button, ['class' => 'btn btn-success', 'name'=> 'btn-submit', 'value' => $button]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
