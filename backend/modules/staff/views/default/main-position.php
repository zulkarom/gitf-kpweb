<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\modules\staff\models\Staff;


/* @var $this yii\web\View */
/* @var $model backend\modules\staff\models\StaffMainPosition */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Main Position';
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="staff-main-position-form">
	<?php $form = ActiveForm::begin(); ?>

	<!-- Dekan -->
    
	<div class="box">
	<div class="box-header">
          <div class="a">
            <div class="box-title"><b>Main Position</b></div>
          </div>
        </div>
	<div class="box-body">
    <div class="table-responsive">
  	<table class="table table-striped table-hover">
    <thead>
    	<tbody>
        	<?php 
        	if($model){
        		foreach ($model as $position) {
        			echo '<tr><td style="width:40%"><b>'.$position->position_name.'</b></td>
        			<td style="width:60%">';

        			echo Select2::widget([
				    'name' => 'Main['.$position->id.']',
				    'value' => $position->staff_id,
				    'data' => ArrayHelper::map(Staff::getAcademicStaff(), 'id', 'user.fullname'),
				    'options' => ['placeholder' => 'Select']
				]);
        			echo'</td>
        			</tr>';	
        		}
        	}
        	?>
		</tbody>
	</thead>
  </table>

</div>
</div>
</div>

<!-- Ketua Jabatan -->
	<div class="box">
	<div class="box-header">
          <div class="a">
            <div class="box-title"><b>Head of Department</b></div>
          </div>
        </div>
	<div class="box-body">

    

    <div class="table-responsive">
  	<table class="table table-striped table-hover">
    <thead>
    	<tbody>
        	<?php 
        	if($modelDepartment){
        		foreach ($modelDepartment as $depart) {
        			echo '<tr><td style="width:40%"><b>'.$depart->dep_name_bi.'</b></td>
        			<td style="width:60%">';

        			echo Select2::widget([
				    'name' => 'Department['.$depart->id.']',
				    'value' => $depart->head_dep,
				    'data' => ArrayHelper::map(Staff::getAcademicStaff(), 'id', 'user.fullname'),
				    'options' => ['placeholder' => 'Select']
				]);
        			echo'</td>
        			</tr>';	
        		}
        	}
        	?>
		</tbody>
	</thead>
  </table>

</div>
</div>
</div>

<!-- Ketua Program -->
	<div class="box">
	<div class="box-header">
          <div class="a">
            <div class="box-title"><b>Program Coordinator</b></div>
          </div>
        </div>
	<div class="box-body">

    

    <div class="table-responsive">
  	<table class="table table-striped table-hover">
    <thead>
    	<tbody>
        	<?php 
        	if($modelProgram){
        		foreach ($modelProgram as $program) {
        			echo '<tr><td style="width:40%"><b>'.$program->pro_name_bi.'</b></td>
        			<td style="width:60%">';

        			echo Select2::widget([
				    'name' => 'Program['.$program->id.']',
				    'value' => $program->head_program,
				    'data' => ArrayHelper::map(Staff::getAcademicStaff(), 'id', 'user.fullname'),
				    'options' => ['placeholder' => 'Select']
				]);
        			echo'</td>
        			</tr>';	
        		}
        	}
        	?>
		</tbody>
	</thead>
  </table>

    <div class="form-group">
        <?= Html::submitButton('Save Position', ['class' => 'btn btn-success']) ?>
    </div>
</div>
</div>
</div>

    <?php ActiveForm::end(); ?>
