<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\staff\models\StaffEduLevel;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\modules\staff\models\StaffEducation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="staff-education-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
<div class="col-md-6">




<?= $form->field($model, 'edu_level') ->dropDownList(
        ArrayHelper::map(StaffEduLevel::find()->all(),'id', 'level_name'), ['prompt' => 'Please Select' ]
    ) ?>



</div>

<div class="col-md-3"> <?= $form->field($model, 'edu_year')->textInput(['maxlength' => true]) ?>
</div>

</div>

   
   <div class="row">
<div class="col-md-9"> <?= $form->field($model, 'edu_qualification')->textInput(['maxlength' => true]) ?></div>

</div>

   
   <div class="row">
<div class="col-md-9"> <?= $form->field($model, 'edu_institution')->textInput(['maxlength' => true]) ?></div>

</div>

   

   

   

    <div class="form-group">
        <?= Html::submitButton('Save Education', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
</div>

