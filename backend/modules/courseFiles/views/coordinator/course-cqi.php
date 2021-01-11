<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
$course = $model->course;
$title = 'Plan for Course Improvement';
$this->title = $course->course_code . ' ' . $course->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Course Files', 'url' => ['/course-files/default/teaching-assignment-coordinator', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $title;

?>

<h4>
<?=$title?>
</h4>

  <div class="box">

<div class="box-body">
<?php $form = ActiveForm::begin(); ?>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'course_cqi')->textarea(['rows' => '6'])->label('Course Improvement') ?></div>

</div>

 <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div></div>

