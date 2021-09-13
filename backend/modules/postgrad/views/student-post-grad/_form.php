<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Common;
/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentPostGrad */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box">
<div class="box-body">  
<div class="student-post-grad-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'nric')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'matric_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'date_birth')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'gender')->dropDownList(
                Common::gender(), ['prompt' => 'Pilih Jantina',  'class' => 'form-control select-choice']) ?>

        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'marital_status')->dropDownList(
                Common::marital(), ['prompt' => 'Pilih Taraf Perkahwinan',  'class' => 'form-control select-choice']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'nationality')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'citizenship')->dropDownList(
                Common::citizen(), ['prompt' => 'Pilih Kewarganegaraan',  'class' => 'form-control select-choice']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'personal_email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'student_email')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phone_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'edu_level')->dropDownList(
                Common::eduLevel(), ['prompt' => 'Pilih Taraf Pengajian',  'class' => 'form-control select-choice']) ?>
        </div>
        
    </div>
    
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'religion')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'race')->textInput() ?>
        </div>
    </div>
    

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'prog_code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'bachelor_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'university_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'bachelor_cgpa')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'bachelor_year')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'session')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'admission_year')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'admission_date_sem1')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'sponsor')->dropDownList(
                Common::sponsor(), ['prompt' => 'Pilih Pembiayaan',  'class' => 'form-control select-choice']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'student_current_sem')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'city_campus')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'student_status')->dropDownList([1=>'Yes', 0 => 'No']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
<?