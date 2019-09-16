<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Upload;

$model->file_controller = 'editing';

$form = ActiveForm::begin(); ?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Galley Proof Form</h3>

</div>

<div class="box-body"> 

<div class="form-group">
<?=Upload::fileInput($model, 'galley')?>
</div>

	<?=$form->field($model, 'galley_proof_note')->textarea(['rows' => '6']) ?>
	

<div class="form-group">

		
	<?=Html::submitButton('Send Galley Proof', ['class' => 'btn btn-success', 'name' => 'wfaction', 'value' => 'recommend', 'data' => [
                'confirm' => 'Are you sure to send this galley proof file?'
            ],
])?>

    </div>
<?php 

ActiveForm::end(); 

?>

</div>
</div>

