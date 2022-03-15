<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Common;
use kartik\select2\Select2;
use common\models\Country;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use backend\models\Semester;
use backend\models\Campus;
use backend\modules\esiap\models\Program;
/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\Student*/
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box">
<div class="box-body">  
<div class="student-post-grad-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($modelUser, 'fullname')->textInput(['maxlength' => true])->label('Nama Pelajar') ?>
        </div>
          <div class="col-md-3">
            <?= $form->field($model, 'matric_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'program_code')->dropDownList(
                ArrayHelper::map(Program::find()->where(['pro_level' => 3])->all(), 'program_code', 'programNameCode'), ['prompt' => 'Pilih Program',  'class' => 'form-control select-choice']) ?>
        </div>
        
        <div class="col-md-3">
            <?= $form->field($model, 'status')->dropDownList(
                $model->statusList(), ['prompt' => 'Pilih Status',  'class' => 'form-control select-choice']) ?>
        </div>

    </div>
    
    <div class="row">

        <div class="col-md-3">
            <?= $form->field($model, 'study_mode')->dropDownList(
                Common::studyMode(), ['prompt' => 'Pilih Taraf Pengajian',  'class' => 'form-control select-choice']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'nric')->textInput(['maxlength' => true]) ?>
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
        
        <div class="col-md-3">
            <?= $form->field($model, 'bachelor_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'bachelor_university')->textInput(['maxlength' => true]) ?>
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
                        $model->admission_semester = $session->get('semester');
                    }else{
                        $model->admission_semester = Semester::getCurrentSemester();
                    }
                }
                echo $form->field($model, 'admission_semester')->dropDownList(Semester::listSemesterArray()) 
            ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'admission_year')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?=$form->field($model, 'admission_date')->widget(DatePicker::classname(), [
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
            <?= $form->field($model, 'sponsor') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'current_sem')->input('number', ['min' => 1, 'step' => 1]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'campus_id')->dropDownList(
                ArrayHelper::map(Campus::find()->all(), 'id', 'campus_name'), ['prompt' => 'Pilih Kampus',  'class' => 'form-control select-choice']) ?>
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