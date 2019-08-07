<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use common\models\Upload;

$model->file_controller = 'front-slider';

/* @var $this yii\web\View */
/* @var $model backend\modules\website\models\FrontSlider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="front-slider-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
<div class="col-md-6"><?= $form->field($model, 'slide_name')->textInput(['maxlength' => true]) ?></div>
<div class="col-md-3">
<?= $form->field($model, 'is_publish')->dropDownList( [0 => 'NO' , 1 => 'YES'] ) ?>

</div>


</div>

	<div class="row">
<div class="col-md-3">

<?= $form->field($model, 'slide_order')->textInput() ?>
</div>

</div>

   

<?php 
if($model->id){
	echo Upload::fileInput($model, 'image');
	$btn = 'Update';
}else{
	$btn = 'Next';
}



?>


    

    <div class="form-group">
        <?= Html::submitButton($btn, ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
