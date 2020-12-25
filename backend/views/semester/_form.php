<?php


use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use backend\modules\teachingLoad\models\TmplAppointment;

/* @var $this yii\web\View */
/* @var $model backend\models\Semester */
/* @var $form yii\widgets\ActiveForm */

?>
	  
<div class="row">
<div class="col-md-4"><?= $form->field($model, 'is_current')->dropDownList(
        [0 => 'No', 1 => 'Yes']
    ) ?></div>
	
	<div class="col-md-4"><?= $form->field($model, 'is_open')->dropDownList(
        [0 => 'No', 1 => 'Yes']
    ) ?></div>
	



</div>

 

<div class="row">
<div class="col-md-6"><?=$form->field($model, 'description')->textarea(['rows' => 3]) ?></div>

</div>


<div class="row">
<div class="col-md-6">
	<?php
	echo $form->field($model, 'template_appoint_letter')->dropDownList(
        ArrayHelper::map(TmplAppointment::find()->orderBy('created_at DESC')->all(), 'id', 'template_name')
    ) ?>
</div>
</div>


