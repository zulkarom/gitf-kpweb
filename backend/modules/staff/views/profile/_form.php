<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\staff\models\Staff */
/* @var $form yii\widgets\ActiveForm */

$model->file_controller = 'profile';
?>

<div class="box box-primary">
<div class="box-header">
<h3 class="box-title">

BASIC PROFILE
</h3>

</div>
<div class="box-body">

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tbody>
	<tr>
        <td></td>
        <td><img src="<?=Url::to(['/staff/profile/download-file', 'attr' => 'image', 'id' => Yii::$app->user->identity->staff->id])?>" width="200" /></td>
      </tr>
      <tr>
        <td><b>Name</b></td>
        <td><?=$model->user->fullname?></td>
      </tr>
      <tr>
        <td><b>Staff No.</b></td>
        <td><?=$model->staff_no?></td>
      </tr>
	  
	  <tr>
        <td><b>Email</b></td>
        <td><?=$model->user->email?></td>
      </tr>
	  
	  
    </tbody>
  </table>
</div>

</div>
</div>


<div class="box box-danger">
<div class="box-header">
<h3 class="box-title">

UPDATE PROFILE
</h3>
</div>
<div class="box-body"><div class="staff-form">

 <?php $form = ActiveForm::begin(); ?>

<?php 
if($model->id){
	echo UploadFile::fileInput($model, 'image', true);
}
?>

<div class="row">
<div class="col-md-3">
<?= $form ->field($model, 'staff_title')->label('Title')?>
</div>

<div class="col-md-7">



</div>

</div>



<div class="row">
<div class="col-md-6">

<?= $form->field($model, 'staff_edu', ['template' => '{label}{input}<i style="font-size:small">*e.g. PhD (UK), MSc (UM), BSc (UPM)</i>{error}'])->textInput(['maxlength' => true]) ?>

</div>

<div class="col-md-6"><?= $form->field($model, 'staff_gscholar')->textInput(['maxlength' => true]) ?>
</div>

</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'staff_expertise')->textarea(['rows' => '3']) ?></div>

<div class="col-md-6"><?= $form->field($model, 'staff_interest')->textarea(['rows' => '3']) ?>
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
<div class="col-md-6"> <?= $form->field($model, 'personal_email')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-6">  <?= $form->field($model, 'ofis_location')->textInput(['maxlength' => true]) ?>
</div>

</div>




    <div class="form-group">
        <?= Html::submitButton('Save Profile', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>

