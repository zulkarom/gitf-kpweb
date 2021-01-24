<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\AduanAction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-body">
<div class="aduan-action-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'action_text')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
