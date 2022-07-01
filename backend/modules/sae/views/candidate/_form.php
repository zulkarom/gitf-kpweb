<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\sae\models\Batch;
/* @var $this yii\web\View */
/* @var $model backend\models\Candidate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="candidate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('USERNAME:<br/><i>Letak No. Kad Pengenalan tanpa (-) e.g. 900213035599</i>') ?>

    <?= $form->field($model, 'can_name')->textInput(['maxlength' => true])->label('FULLNAME:') ?>

    <?= $form->field($model, 'department')->textInput(['maxlength' => true])->label('DEPARTMENT:') ?>

    <?= $form->field($model, 'can_batch')->dropDownList(
        ArrayHelper::map(Batch::find()->all(),'id', 'bat_text'), ['prompt' => 'Select Batch']
    )?>

    <div class="form-group">
        <?= Html::submitButton('<span class="fa fa-floppy-o"></span> Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
