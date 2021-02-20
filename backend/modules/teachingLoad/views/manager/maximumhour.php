<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Staff Loading Hour';
$this->params['breadcrumbs'][] = $this->title;
?>
    
<div class="maximum_hour">



<?php $form = ActiveForm::begin(); ?>


<br/>
<div class="box">
<div class="box-header">
<div class="box-title">General Setting</div>
</div>
<div class="box-body"><div class="row">
  <div class="col-md-2">
	<?= $form->field($setting, 'max_hour')->textInput() ?>
  </div>
   <div class="col-md-2">
   <?= $form->field($setting, 'accept_hour')->textInput() ?>
  </div>
</div>

 <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save General Setting', ['class' => 'btn btn-primary']) ?>

</div>

</div>

<?php ActiveForm::end(); ?>



<?php $form = ActiveForm::begin(); ?>
<div class="box">
<div class="box-header">
<div class="box-title">Staff Custom Maximum Hour</div>
</div>
<div class="box-body">

<div class="form-group"><a class="btn btn-success" href="<?=Url::to(['add-staff'])?>"><span class="glyphicon glyphicon-plus"></span> Add Staff</a></div>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Staff Name</th>
        <th width="15%">Maximum Hour</th>
        <th></th>
      </tr>
	  </thead>
	  <tbody>
        <?php
         if($model){
         $i = 1;
         foreach($model as $staff){
            echo'<tr>
            <td>'.$i.'</td>
            <td>'.$staff->staff->staff_title .' '.$staff->staff->user->fullname.'</td>
            <td>
			
			<input name="Max['.$staff->id.'][max_hour]" type="text" style="width:50%" value="'.$staff->max_hour.'" class="form-control "/>
			
			</td>
            <td><a class="btn btn-danger btn-sm" href="' . Url::to(['manager/delete-maximum-hour', 'id' => $staff->id]) . '" data-confirm="Are you sure you want to delete this?" ><span class="fa fa-trash"></span></a></td>';
            $i++;
          }
        }
        ?>
      </tr>
    </tbody>
  </table>
  <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save Custom Hour', ['class' => 'btn btn-primary']) ?>
</div>
</div>

</div>





<?php ActiveForm::end(); ?>


</div>
