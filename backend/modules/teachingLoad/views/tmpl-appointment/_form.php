<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\TmplAppointment */
/* @var $form yii\widgets\ActiveForm */
$model->file_controller = 'tmpl-appointment';
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">
<div class="tmpl-appointment-form">


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'template_name')->textInput(['maxlength' => true]) ?>

    <div class="row">
<div class="col-md-6"> <?= $form->field($model, 'yg_benar')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-6"><?= $form->field($model, 'dekan')->textInput(['maxlength' => true]) ?>
</div>

</div>


    <?= $form->field($model, 'tema')->textarea(['rows' => 2]) ?>

    <?= $form->field($model, 'per1')->textarea(['rows' => 6]) ?>

    <div class="row">
    <div class="col-md-9">
    <?=UploadFile::fileInput($model, 'signiture', true)?>
    * png file with transparent background. Suggested dimension (131 x 122)
    <br /><br />
    </div>

</div>
    
    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
</div>