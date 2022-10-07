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

<h4 class="m-text23">Payment Form</h4>


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

<?=$form->field($model, 'fee_package') ->dropDownList($model->listPackages, ['prompt' => 'Select a Category'])?>

<div class="row">
<div class="col-md-5">
<div class="form-group highlight-addon field-confregistration-paper_number required">
<label class="has-star" for="confregistration-fee_amount">Number of Paper</label>

<input type="text" class="form-control disabled" value="<?=$model->countNotRejectPapers?>"  disabled>

</div>
    
    
    <?php 
$arr = [];
for($i=1;$i<=10;$i++){
    $arr[$i] = $i;
}
//echo '<input type="text" id="show_number" class="form-control disabled" value="'.$model->paper_number.'">';
echo $form->field($model, 'paper_number')->hiddenInput(['value' => $model->countNotRejectPapers])->label(false)?>

</div>
</div>

<div class="row">
<div class="col-md-4"><?=$form->field($model, 'fee_currency') ->dropDownList($model->listCurrencyCode())?></div>
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



<?php
$this->registerJs('
//setPaper();

$("#confregistration-fee_package").change(function(){
    calc();
});

$("#confregistration-paper_number").change(function(){
    calc();
});

function setPaper(){
    var kira = '.$model->countNotRejectPapers.' ;
    kira = kira ? kira : 1;
    $("#confregistration-paper_number").val(kira);
}

function calc(){
    
    var val = $("#confregistration-fee_package").val();
    var pac = setPackage();
    var item;
    var fee;
    var cur;
    var qty;
    //var amount = pac[val].fee_amount;
    for(i=0;i<pac.length;i++){
        item = pac[i];
        if(item.id == val){
            fee = parseFloat(item.fee_amount);
            qty = parseInt($("#confregistration-paper_number").val());
            fee = fee * qty;

            cur = item.fee_currency;
            $("#confregistration-fee_amount").val(fee);
            
            $("#confregistration-fee_currency").val(cur);


            break;
        }
    }
    
   // $("#confregistration-fee_amount").val(amount);
    //confregistration-fee_currency
}

function setPackage(){
    var json = \''.$model->getListPackagesJson().'\';
    var arr = JSON.parse(json);
    return arr;

}



');
?>



