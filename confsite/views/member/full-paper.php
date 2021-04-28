<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use confsite\models\UploadFile;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = 'Upload Paper: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Conf Papers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$model->file_controller = 'member';
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
<div class="conf-paper-update">

    <h4 class="m-text23 p-b-34">Upload Paper</h4>


<div class="conf-paper-form">

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>


    <h4><?=$model->pap_title ?></h4>
	<br /><br />



<div class="row">
<div class="col-md-7"><?php 
$fees = $model->conference->confFees;
echo $form->field($model, 'myrole') ->dropDownList(
        ArrayHelper::map($fees,'id', 'fee_name'), ['prompt' => 'Please Select' ]
    ) ?></div>
</div>
<br />
	
	
	<?=UploadFile::fileInput($model, 'paper')?>
	
	


<br />
    <div class="form-group">
        <?= Html::submitButton('SUBMIT PAPER', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


</div>

