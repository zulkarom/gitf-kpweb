<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\staff\models\StaffPosition;
use backend\modules\staff\models\StaffPositionStatus;
use backend\modules\staff\models\StaffWorkingStatus;
use common\models\UploadFile;
use kartik\date\DatePicker;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $model backend\modules\staff\models\Staff */
/* @var $form yii\widgets\ActiveForm */

$model->file_controller = 'staff';
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="staff-form">

 <?php $form = ActiveForm::begin(); ?>


<?php 

if($model->id){
	echo UploadFile::fileInput($model, 'image', true);
}



?>

	
	<div class="row">
<div class="col-md-3">
<?= $form
            ->field($model, 'staff_title', ['template' => '{label}<div id="con-title">{input}</div>{error}']
)
            ->label('Title')
            ->dropDownList($model->listTitles) ?>
</div>

<div class="col-md-7">
<?= $form->field($user, 'fullname', ['template' => '{label}{input}<i style="font-size:small">*Capitalise Each Word. e.g. Muhammad Alif Bin Mohd Satar</i>{error}'])->textInput(['maxlength' => true])->label('Staff Name')?>



</div>

</div>

<div class="row">
<div class="col-md-3"><?= $form->field($model, 'staff_no')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-7"><?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>

</div>

</div>


<div class="row">
<div class="col-md-3"><?= $form->field($model, 'is_academic')->dropDownList([1=>'Academic', 2 => 'Administrative'], ['prompt' => 'Please Select' ]
    ) ?></div>

<div class="col-md-5"><?= $form->field($model, 'position_id')->dropDownList(
        StaffPosition::positionList(), ['prompt' => 'Please Select' ]
    ) ?>
</div>

<div class="col-md-2">

<?= $form->field($model, 'position_status')->dropDownList(
        ArrayHelper::map(StaffPositionStatus::find()->where(['>', 'status_id', 0])->all(),'status_id', 'status_name'), ['prompt' => 'Please Select' ]
    ) ?>

</div>

<div class="col-md-2">

<?= $form->field($model, 'working_status')->dropDownList(
        ArrayHelper::map(StaffWorkingStatus::find()->where(['>', 'work_id', 0])->all(),'work_id', 'work_name'), ['prompt' => 'Please Select' ]
    ) ?>
</div>

</div>

<div class="row">
<div class="col-md-6">

<?= $form->field($model, 'staff_edu', ['template' => '{label}{input}<i style="font-size:small">*e.g. PhD (Salford, Manchester, UK), MSc, BSc (UPM)</i>{error}'])->textInput(['maxlength' => true]) ?>

</div>

<div class="col-md-6"><?= $form->field($model, 'staff_gscholar')->textInput(['maxlength' => true]) ?>
</div>

</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'staff_expertise')->textarea(['rows' => '6']) ?></div>

<div class="col-md-6"><?= $form->field($model, 'staff_interest')->textarea(['rows' => '6']) ?>
</div>

</div>


<div class="row">
<div class="col-md-4"><?= $form->field($model, 'officephone')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-4"><?= $form->field($model, 'handphone1')->textInput(['maxlength' => true]) ?>
</div>

<div class="col-md-4"><?= $form->field($model, 'handphone2')->textInput(['maxlength' => true]) ?>
</div>

</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'staff_ic')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-6"><?= $form->field($model, 'staff_dob')->textInput() ?>
</div>

</div>

   <div class="row">
<div class="col-md-3">



 <?=$form->field($model, 'date_begin_umk')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>

</div>
<div class="col-md-3">

 <?=$form->field($model, 'date_begin_service')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>

</div>

</div> 

    <div class="row">
<div class="col-md-6"> <?= $form->field($model, 'personal_email')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-6">  <?= $form->field($model, 'ofis_location')->textInput(['maxlength' => true]) ?>
</div>

</div>

<div class="row">
<div class="col-md-3"><?= $form->field($model, 'staff_active', ['template' => '{label}{input}<i style="font-size:small">*NO value will put this staff in Inactive page</i>{error}'])->dropDownList( [1 => 'YES' , 0 => 'NO'] ) ?></div>

</div>



<?= $form->field($model, 'staff_note')->textarea(['rows' => '6']) ?>



    <div class="form-group">
        <?= Html::submitButton('Save Staff Data', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>


<?php JSRegister::begin(); ?>
<script>
$("#staff-staff_title").change(function(){
	var val = $(this).val();
	if(val == 999){
		var html = '<input type="text" id="staff-staff_title" placeholder="Please specify" class="form-control" name="staff[title]" / >';
		$("#con-title").html(html);
	}
});
</script>
<?php JSRegister::end(); ?>