<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\Supervisor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="supervisor-form">

    <?php $form = ActiveForm::begin(); ?>
    
     <div class="box">
<div class="box-header"></div>
<div class="box-body">

<?= $form->field($model, 'is_internal')->textInput() ?>


 <?= $form->field($model, 'staff_id')->textInput() ?>

    <?= $form->field($model, 'external_id')->textInput() ?>


</div>
</div>

   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
