<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
/* @var $form yii\widgets\ActiveForm */
?>
<h4>
<?=$course->course_code . ' ' . $course->course_name?>
</h4>
<div class="course-offered-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($course, 'lec_hour')->textInput() ?>
	
	<?= $form->field($course, 'tut_hour')->textInput() ?>
	
<?=$form->field($course, 'page')->hiddenInput(['value' => $page])->label(false)?>

 <?=$form->field($course, 'perpage')->hiddenInput(['value' => $perpage])->label(false)?>
 

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
