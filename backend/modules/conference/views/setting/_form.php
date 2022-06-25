<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\web\JsExpression;
use common\models\User;
use common\models\Country;
use common\models\UploadFile;
use dosamigos\tinymce\TinyMce;


$model->file_controller = 'setting';

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\Conference */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title"><?=$model->conf_name?></h3>
							<p class="panel-subtitle"><a href="https://fkp-portal.umk.edu.my/conf/<?=$model->conf_url?>"  target="_blank">https://fkp-portal.umk.edu.my/conf/<?=$model->conf_url?></a></p>
						</div>
						<div class="panel-body">
			
			
			
			<div class="conference-form">
			


    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'conf_name')->textInput(['maxlength' => true]) ?>
	
	<div class="row">
<div class="col-md-4"><?= $form->field($model, 'conf_url')->textInput(['maxlength' => true])->label('Conference URL') ?></div>

</div>
	
	<div class="row">
<div class="col-md-4"><?= $form->field($model, 'conf_abbr')->textInput(['maxlength' => true])->label('Abbreviation') ?></div>

<div class="col-md-4"> <?=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
])->label('Date Start');
?>
</div>

<div class="col-md-4"> <?=$form->field($model, 'date_end')->widget(DatePicker::classname(), [
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



    
    <?= $form->field($model, 'conf_venue')->textInput(['maxlength' => true]) ?>
	
<div class="row">
<div class="col-md-4">
 <?= $form->field($model, 'phone_contact')->textInput(['maxlength' => true]) ?>
</div>

<div class="col-md-4">
 <?= $form->field($model, 'email_contact')->textInput(['maxlength' => true]) ?>
</div>

<div class="col-md-4">
 <?= $form->field($model, 'fax_contact')->textInput(['maxlength' => true]) ?>
</div>

</div>

<div class="form-group">
<?= $form->field($model, 'conf_address')->textarea(['rows' => 5]) ?>
</div>

<div class="form-group">
<div class="row">
<div class="col-md-4">
<?= $form->field($model, 'is_active')->dropdownlist([1 => 'Yes', 0 => 'No']) ?>
</div>
<div class="col-md-4">
<?= $form->field($model, 'system_only')->dropdownlist([1 => 'Yes', 0 => 'No']) ?>
</div>
<div class="col-md-4">
<?= $form->field($model, 'is_pg')->dropdownlist([1 => 'Yes', 0 => 'No']) ?>
</div>
</div>

</div>


    <div class="form-group">
        <?= Html::submitButton('Save Setting', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
