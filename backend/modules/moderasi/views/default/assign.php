<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\moderasi\models\CourseChecker */
/* @var $offered backend\modules\teachingLoad\models\CourseOffered */
/* @var $staffList array */

$this->title = 'Assign Checker/Vetter';
$this->params['breadcrumbs'][] = ['label' => 'Moderasi - Offered Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="moderasi-assign">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">
                <?= $offered->course ? Html::encode($offered->course->codeCourseString) : 'Course' ?>
            </h3>
        </div>
        <div class="box-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'checker1_staff_id')->dropDownList($staffList, ['prompt' => '- Select Checker/Vetter 1 -']) ?>

            <?= $form->field($model, 'checker2_staff_id')->dropDownList($staffList, ['prompt' => '- Select Checker/Vetter 2 -']) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
