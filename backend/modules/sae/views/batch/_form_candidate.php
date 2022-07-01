<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\sae\models\Batch;
/* @var $this yii\web\View */
/* @var $model backend\models\Candidate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-6">

    <div class="box">
<div class="box-header">
</div>
<div class="box-body">


<div class="candidate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('Username:<br/><i>Letak No. Kad Pengenalan tanpa (-) e.g. 900213035599</i>') ?>

    <?= $form->field($model, 'can_name')->textInput(['maxlength' => true])->label('Fullname:') ?>

    <?php
        if($modelBatch->column1){
            echo $form->field($modelAnswer, 'column1')->textInput(['maxlength' => true])->label($modelBatch->column1);
        }
        if($modelBatch->column2){
            echo $form->field($modelAnswer, 'column2')->textInput(['maxlength' => true])->label($modelBatch->column2);
        }
        if($modelBatch->column3){
            echo $form->field($modelAnswer, 'column3')->textInput(['maxlength' => true])->label($modelBatch->column3);
        }
    ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="fa fa-floppy-o"></span> Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



</div></div>

    </div>
</div>





