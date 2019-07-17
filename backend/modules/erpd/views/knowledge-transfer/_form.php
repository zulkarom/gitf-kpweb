<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\KnowledgeTransfer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="knowledge-transfer-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
<div class="col-md-10"><?= $form->field($model, 'ktp_title')->textarea(['rows' => '3'])  ?></div>
</div>

    <div class="row">
<div class="col-md-8"><?= $form->field($model, 'ktp_research')->textInput(['maxlength' => true]) ?></div>
</div>

    <div class="row">
<div class="col-md-8"><?= $form->field($model, 'ktp_community')->textInput(['maxlength' => true]) ?></div>
</div>

<div class="row">
<div class="col-md-3"> 
 <?=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
?>
</div>

<div class="col-md-3"> 
 <?=$form->field($model, 'date_end')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
?>

</div>

</div>

       <div class="row">
<div class="col-md-8"><?= $form->field($model, 'ktp_source')->textInput(['maxlength' => true]) ?></div>
</div> 


    <div class="row">
<div class="col-md-3">

<?= $form->field($model, 'ktp_amount', [
    'addon' => ['prepend' => ['content'=>'RM']]
]); ?>

</div>

</div>

<div class="row">
<div class="col-md-10"> <?= $form->field($model, 'ktp_description')->textarea(['rows' => 4]) ?></div>
</div>
   



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
