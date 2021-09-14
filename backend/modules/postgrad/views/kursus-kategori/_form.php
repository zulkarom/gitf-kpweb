<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\KursusKategori */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body">
<div class="kursus-kategori-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kategori_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save Kategori', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
