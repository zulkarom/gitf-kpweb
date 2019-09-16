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
<h3 class="box-title">Camera Ready Form</h3>

</div>

<div class="box-body"> 

<div class="row">
<div class="col-md-8">	 

<?=Upload::fileInput($model, 'cameraready')?>

<?=$form->field($model, 'camera_ready_note')->textarea(['rows' => '6']) ?>




	
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

