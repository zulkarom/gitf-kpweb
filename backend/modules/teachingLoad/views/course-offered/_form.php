<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Semester;
use backend\modules\esiap\models\Course;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-offered-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
<div class="col-md-4"> <?php 
if($model->isNewRecord){
	$model->semester_id = Semester::getCurrentSemester();
}

echo $form->field($model, 'semester_id')->dropDownList(Semester::listSemesterArray()) ?></div>

<div class="col-md-8"><?php

echo $form->field($model, 'courses')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Course::activeCourses(), 'id', 'codeCourseString'),
    'language' => 'en',
    'options' => ['multiple' => true,'placeholder' => 'Select a course ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?>
</div>

</div>


<div class="row">

<div class="col-md-6"> <?= $form->field($model, 'coordinator')->textInput() ?>
</div>

</div>

 

    <div class="form-group">
        <?= Html::submitButton('Add Course Offered', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
