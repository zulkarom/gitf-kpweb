<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Semester;

/* @var $this yii\web\View */
/* @var $model backend\modules\students\models\DeanList */
/* @var $form yii\widgets\ActiveForm */
$model->semester_id = Semester::getCurrentSemester()->id;
?>

<div class="dean-list-form">

<div class="box">
<div class="box-header"></div>
<div class="box-body">    <?php $form = ActiveForm::begin(); ?>


<div class="row">
<div class="col-md-6"><?= $form->field($model, 'semester_id')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>  <?= $form->field($model, 'matric_no')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-6">
</div>

</div>

	

  

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?></div>
</div>


</div>
