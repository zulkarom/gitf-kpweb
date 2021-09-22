<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Common;
use kartik\select2\Select2;
use common\models\Country;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use backend\models\Semester;
/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentPostGrad */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'My Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
<div class="card-body">  
<div class="student-post-grad-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($modelUser, 'fullname')->textInput(['maxlength' => true, 'disabled' => true])->label('Nama Pelajar') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'nric')->textInput(['maxlength' => true, 'disabled' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'matric_no')->textInput(['maxlength' => true, 'disabled' => true]) ?>
        </div>
        <div class="col-md-2">
             <?=$form->field($model, 'date_birth')->widget(DatePicker::classname(), [
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

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'gender')->dropDownList(
                Common::gender(), ['prompt' => 'Pilih Jantina',  'class' => 'form-control select-choice']) ?>

        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'marital_status')->dropDownList(
                Common::marital2(), ['prompt' => 'Pilih Taraf Perkahwinan',  'class' => 'form-control select-choice']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'nationality')->widget(Select2::classname(), [
                'data' =>  ArrayHelper::map(Country::find()->all(),'id', 'country_name'),
                'options' => ['placeholder' => 'Pilih Negara'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                ]);
            ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'citizenship')->dropDownList(
                Common::citizenship(), ['prompt' => 'Pilih Kewarganegaraan',  'class' => 'form-control select-choice']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($modelUser, 'email')->textInput(['maxlength' => true])->label('Emel Pelajar') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'personal_email')->textInput() ?>
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
            <?= $form->field($model, 'religion')->dropDownList(
                Common::religion(), ['prompt' => 'Pilih Agama',  'class' => 'form-control select-choice']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'race')->dropDownList(
                Common::race(), ['prompt' => 'Pilih Bangsa',  'class' => 'form-control select-choice']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'address')->textarea(['rows' => '3']) ?>
        </div>
    </div>
    

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'prog_code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'bachelor_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'university_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'bachelor_cgpa')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'bachelor_year')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?php 
                $session = Yii::$app->session;
                if($model->isNewRecord){
                    if($session->has('semester')){
                        $model->session = $session->get('semester');
                    }else{
                        $model->session = Semester::getCurrentSemester();
                    }
                }
                echo $form->field($model, 'session')->dropDownList(Semester::listSemesterArray()) 
            ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'admission_year')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?=$form->field($model, 'admission_date_sem1')->widget(DatePicker::classname(), [
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

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'sponsor')->dropDownList(
                Common::sponsor(), ['prompt' => 'Pilih Pembiayaan',  'class' => 'form-control select-choice']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'student_current_sem')->input('number', ['min' => 1, 'step' => 1]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'city_campus')->dropDownList(
                Common::campus(), ['prompt' => 'Pilih Kampus',  'class' => 'form-control select-choice']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'student_status')->dropDownList(
                Common::studentStatus(), ['prompt' => 'Pilih Status',  'class' => 'form-control select-choice']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>