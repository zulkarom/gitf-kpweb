<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\CourseVersion */

$this->title = 'Create Course Version';
$this->params['breadcrumbs'][] = ['label' => 'Course Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-version-create">

<div class="course-version-form">

    <?php $form = ActiveForm::begin(); ?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">    

<?= $form->field($model, 'version_name')->textInput(['maxlength' => true]) ?>


<div class="row">
<div class="col-md-4">

<?= $form->field($model, 'is_developed')->dropDownList( [1 => 'YES' , 0 => 'NO'] ) ?>

<?= $form->field($model, 'duplicate')->dropDownList( [1 => 'YES' , 0 => 'NO'] ) ?>

<div id="con_course">

</div>

</div>







</div>



</div>
