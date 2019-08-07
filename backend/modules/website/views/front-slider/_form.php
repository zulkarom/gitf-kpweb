<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use common\models\UploadFile;

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
<div class="col-md-9"><?= $form->field($model, 'slide_url')->textInput(['maxlength' => true])->label('Slide Url (if any)') ?></div>



</div>



   

<?php 
if($model->id){
	echo UploadFile::fileInput($model, 'image');
	echo '<p>Max File Size: 1MB, Best Dimensions (px):1300 x 450</p> <br />';
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
