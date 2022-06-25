<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use confsite\models\UploadPaperFile as UploadFile;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = 'Fee Payment ';
$model->file_controller = 'payment';
?>
<style>
.table td, .table th {
    padding: 0rem;
    border: none;
}
label{
	font-weight:bold;
}
	</style>


<div class="row">
    <div class="col-md-6">
    <h4 class="m-text23 p-b-34">Payment Methods</h4>

    <div style="padding-right:10px;">
<?=$conf->payment_info?>
    </div>
    </div>
    <div class="col-md-6"><div class="conf-paper-update">

<h4 class="m-text23 p-b-34">Payment Form</h4>


<div class="conf-paper-form">

<?php $form = ActiveForm::begin(); ?>


<?php 

/* if($model->papers){
foreach($model->papers as $paper){
    echo '<h5>' . $paper->pap_title  . '</h5>
    <br />';
}
} */




?>


<br />



<div class="row">
<div class="col-md-4"><?=$form->field($model, 'fee_currency') ->dropDownList($curr)?></div>
<div class="col-md-8"><?=$form->field($model, 'fee_amount') ->textInput()?></div>
</div>


<?=$form->field($model, 'fee_note') ->textarea(['rows' => 3])?>

<br />


<?=UploadFile::fileInput($model, 'fee', $model->conference->conf_url)?>




<br />
<div class="form-group">
    <?= Html::submitButton('SUBMIT PAYMENT', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>


</div></div>
</div>





