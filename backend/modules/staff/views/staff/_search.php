<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\staff\models\StaffPosition;
use backend\modules\staff\models\StaffPositionStatus;
use backend\modules\staff\models\StaffWorkingStatus;
use backend\models\Faculty;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\staff\models\StaffSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header">
<div class="box-title">
Search Staff

</div>

</div>
<div class="box-body"><div class="staff-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= Html::hiddenInput('tab', $tab ?? Yii::$app->request->get('tab', 'staff')) ?>

<div class="row">
<div class="col-md-4"><?= $form->field($model, 'staff_no') ?></div>
<div class="col-md-4"><?php  echo $form->field($model, 'staff_name') ?>
</div>


<div class="col-md-4">
<?php  echo $form->field($model, 'position_id')->dropDownList( ArrayHelper::map(StaffPosition::find()->where(['>', 'id',0])->all(),'id', 'position_name'),['class'=> 'form-control','prompt' => 'All']) ?>

</div>

</div>
    


    <div class="row">
	
	<div class="col-md-3"><?php  echo $form->field($model, 'is_academic')->dropDownList([1=>'Academic', 0 => 'Administrative'], ['prompt' => 'All'])?>
</div>
	
<div class="col-md-3">

<?php  echo $form->field($model, 'position_status')->dropDownList( ArrayHelper::map(StaffPositionStatus::find()->where(['>', 'id',0])->all(),'id', 'status_name'),['class'=> 'form-control','prompt' => 'All']) ?>


</div>

<div class="col-md-3">

<?php  echo $form->field($model, 'working_status')->dropDownList( ArrayHelper::map(StaffWorkingStatus::find()->where(['>', 'id',0])->all(),'id', 'work_name'),['class'=> 'form-control','prompt' => 'All']) ?>
</div>

</div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'faculty_id')->dropDownList(
                ArrayHelper::map(Faculty::find()->all(), 'id', 'faculty_name'),
                ['prompt' => 'All']
            )->label('Faculty') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'staff_active')->dropDownList([
                1 => 'Active',
                0 => 'Inactive',
            ], ['prompt' => 'All']) ?>
        </div>
    </div>

    

    

  



    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Search Staff', ['class' => 'btn btn-default']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?> 
		<?= Html::button('Hide', ['id' => 'hide-form', 'class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
</div>

