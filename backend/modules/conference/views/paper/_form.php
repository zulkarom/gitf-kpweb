<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="conf-paper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'conf_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'pap_title')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pap_abstract')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'paper_file')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
