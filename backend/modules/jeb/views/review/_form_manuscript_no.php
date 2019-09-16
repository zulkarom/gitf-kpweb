<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$form = ActiveForm::begin(); ?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Set Manuscript No.</h3>

</div>

<div class="box-body"> 



		<div class="row">
		<div class="col-md-4">
		<div class="form-group"><?=$form->field($model, 'manuscript_no')->textInput() ?>
		</div>
		
		
		</div>
		
		
		
		</div>
		
		<div class="form-group"><?=Html::submitButton('Save', ['class' => 'btn btn-success'
])?></div>
	


</div>
</div>





    
<?php 

ActiveForm::end(); 


