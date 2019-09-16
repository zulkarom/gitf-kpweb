<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\esiap\models\CourseType;
use backend\modules\esiap\models\CourseLevel;
use backend\modules\esiap\models\Program;
use backend\models\Department;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-form">

    <?php $form = ActiveForm::begin(); ?>
	
<div class="box">
<div class="box-header"></div>
<div class="box-body">	

<div class="row">
<div class="col-md-4"><?= $form->field($model, 'course_code')->textInput(['maxlength' => true]) ?></div>
<div class="col-md-4">

<?= $form->field($model, 'course_type')->dropDownList(
        ArrayHelper::map(CourseType::find()->all(),'id', 'type_name'), ['prompt' => 'Please Select' ]
    ) ?>

</div>

<div class="col-md-4">

<?= $form->field($model, 'course_level')->dropDownList(
        ArrayHelper::map(CourseLevel::find()->all(),'id', 'lvl_name'), ['prompt' => 'Please Select' ]
    ) ?>
</div>

</div>

    <div class="row">
<div class="col-md-6"> <?= $form->field($model, 'course_name')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-6"><?= $form->field($model, 'course_name_bi')->textInput(['maxlength' => true]) ?>
</div>

</div>

  <div class="row">
<div class="col-md-6"><?= $form->field($model, 'credit_hour')->textInput() ?></div>

<div class="col-md-6">

<?= $form->field($model, 'program')->dropDownList(
        ArrayHelper::map(Program::find()->where(['faculty' => 1, 'trash' => 0])->all(),'id', 'pro_name'), ['prompt' => 'Please Select' ]
    ) ?>

</div>

</div>

<div class="row">
<div class="col-md-6">

<?= $form->field($model, 'department')->dropDownList(
        ArrayHelper::map(Department::find()->all(),'id', 'dep_name'), ['prompt' => 'Please Select' ]
    ) ?>



</div>

<div class="col-md-6"><?= $form->field($model, 'is_dummy')->dropDownList( [ 0 => 'NO', 1 => 'YES' ] ) ?>
</div>

</div>


    
</div>
</div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
