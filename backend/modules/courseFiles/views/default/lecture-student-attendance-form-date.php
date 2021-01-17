<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\date\DatePicker;

$this->title = 'Student Attendance';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="student-form">

    <?php $form = ActiveForm::begin() ?>
    <div class="row">
    <div class="col-sm-4">
	    <?=$form->field($model, 'date')->widget(DatePicker::classname(), [
		    'removeButton' => false,
		    'pluginOptions' => [
		        'autoclose'=>true,
		        'format' => 'yyyy-mm-dd',
		        'todayHighlight' => true,
		        
		    ],  
		]);
		?>
	</div>

	<div class="col-sm-4">
		<?= $form->field($model, 'number_of_class')->textInput(['maxlength' => true]) ?>
	</div>
	</div>

    <div class="form-group">
        <br/>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>