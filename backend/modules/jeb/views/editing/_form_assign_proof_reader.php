<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Upload;
use common\models\AuthAssignment;

$model->file_controller = 'editing';

$form = ActiveForm::begin(); ?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Assign Proof Reader Form</h3>

</div>

<div class="box-body"> 

<div class="row">
<div class="col-md-8">	 


<?= $form->field($model, 'proof_reader')->dropDownList(
        ArrayHelper::map(AuthAssignment::getUsersByAssignment('jeb-proof-reader'),'user.id', 'user.fullname'), ['prompt' => 'Please Select' ]
    ) ?>
	
	
	<?=$form->field($model, 'asgn_profrdr_note')->textarea(['rows' => '6']) ?>
	
	</div>

	
	
</div>

	
	

<div class="form-group">

		
	<?=Html::submitButton('Assign Proof Reader', ['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'recommend', 'data' => [
                'confirm' => 'Are you sure to assign this proof reader?'
            ],
])?>

    </div>
<?php 

ActiveForm::end(); 

?>

</div>
</div>

