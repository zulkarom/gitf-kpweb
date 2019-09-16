<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\modules\jeb\models\Journal;


$form = ActiveForm::begin(); ?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Assign Journal Volume Form</h3>

</div>

<div class="box-body"> 

<div class="row">
<div class="col-md-8">	 


<?=$form->field($model, 'journal_id')->dropDownList(
        ArrayHelper::map(Journal::listCompilingJournal(),'id', 'journalName'), ['prompt' => 'Please Select' ]
    )->label('Choose Journal Volume & Issue');
 ?>


	
	</div>

	
	
</div>

	
	

<div class="form-group">

		
	<?=Html::submitButton('Send to Journal', ['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'recommend', 'data' => [
                'confirm' => 'Are you sure to send this article to journal?'
            ],
])?>

    </div>
<?php 

ActiveForm::end(); 

?>

</div>
</div>

