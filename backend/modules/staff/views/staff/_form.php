<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Faculty;
use backend\modules\staff\models\StaffPosition;
use backend\modules\staff\models\StaffPositionStatus;
use backend\modules\staff\models\StaffWorkingStatus;
use backend\modules\staff\models\LetterDesignation;
use common\models\UploadFile;
use kartik\date\DatePicker;
use richardfan\widget\JSRegister;
use common\models\Country;
use kartik\select2\Select2;

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
<?= $form->field($model, 'staff_title', ['template' => '{label}<div id="con-title">{input}</div>{error}']
)->label('Title') ?>
</div>

<div class="col-md-7">
<?= $form->field($user, 'fullname', ['template' => '{label}{input}<i style="font-size:small">*Capitalise Each Word. e.g. Muhammad Alif Bin Mohd Satar</i>{error}'])->textInput(['maxlength' => true])->label('Staff Name')?>



</div>

</div>

	<div class="row">
<div class="col-md-3">
<?= $form->field($model, 'designation')->dropDownList(ArrayHelper::map(LetterDesignation::find()->all(), 'designation_name', 'designation_name'), ['prompt' => 'Select'])->label('Title (letter)') ?>
</div>
<div class="col-md-7">
<?php 
if($model->isNewRecord){
	$model->faculty_id = Yii::$app->params['faculty_id'];
}
echo $form->field($model, 'faculty_id')->dropDownList(ArrayHelper::map(Faculty::find()->where(['academic' => 1])->all(), 'id', 'faculty_name'), ['prompt' => 'Select Faculty'])->label('Faculty') ?>
</div>

</div>

<div class="row">
<div class="col-md-3"><?= $form->field($model, 'staff_no')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-5"><?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>

</div>

<div class="col-md-3"><?= $form->field($model, 'gender')->dropDownList([1=>'Male', 0 => 'Female'], ['prompt' => 'Please Select' ]
    ) ?></div>

</div>


<div class="row">
<div class="col-md-3"><?= $form->field($model, 'is_academic')->dropDownList([1=>'Academic', 0 => 'Administrative'], ['prompt' => 'Please Select' ]
    ) ?></div>

<div class="col-md-5"><?= $form->field($model, 'position_id')->dropDownList(
        StaffPosition::positionList(), ['prompt' => 'Please Select' ]
    ) ?>
</div>

<div class="col-md-2">

<?= $form->field($model, 'position_status')->dropDownList(
        ArrayHelper::map(StaffPositionStatus::find()->where(['>', 'id', 0])->all(),'id', 'status_name'), ['prompt' => 'Please Select' ]
    ) ?>

</div>

<div class="col-md-2">

<?= $form->field($model, 'working_status')->dropDownList(
        ArrayHelper::map(StaffWorkingStatus::find()->where(['>', 'id', 0])->all(),'id', 'work_name'), ['prompt' => 'Please Select' ]
    ) ?>
</div>

</div>

<div class="row">
<div class="col-md-3">
<?php 


echo $form->field($model, 'nationality')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Country::find()->all(),'country_code', 'country_name'),
    'language' => 'en',
    'options' => ['multiple' => false,'placeholder' => 'Select a country ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Country');

?>


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





<?= $form->field($model, 'staff_note')->textarea(['rows' => '6']) ?>

<?= $form->field($model, 'staff_active')->dropDownList([1 => 'Yes, actively engaged with faculty in teaching or other activities', 0 => 'No, quit or transfered and not actively engaged with the faculty'])->label('Actively Engaged with the Faculty') ?>

<div class="row">
<div class="col-md-6">  <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save Staff Data', ['class' => 'btn btn-success']) ?>
    </div></div>



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