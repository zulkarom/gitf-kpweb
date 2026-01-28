<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\modules\postgrad\models\StudentStage;
use backend\models\Semester;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\Supervisor */

$this->title = 'View Supervisor / Examiner';
$semesterId = Yii::$app->request->get('semester_id');
$currentSem = Semester::getCurrentSemester();
if (empty($semesterId) && $currentSem) {
    $semesterId = $currentSem->id;
}
$this->params['breadcrumbs'][] = ['label' => 'Supervisors', 'url' => ['index', 'semester_id' => $semesterId]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
table.detail-view th {
    width:15%;
}
</style>

<div class="supervisor-view">


<h3><i class="fa fa-user"></i> <?= $model->svName ?></h3>


<div class="row">
	<div class="col-md-4">


	
	     <div class="box">
<div class="box-header"></div>
<div class="box-body">
    <?php 
    $data[] = 'svName';
    $data[] = 'typeName';
        
        $data[] = 'svFieldsString';
    
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $data,
    ]) ?>
    
    	<br />
	    <p>
<?= Html::a('Supervisors', ['index', 'semester_id' => $semesterId], ['class' => 'btn btn-default']) ?> 
<?= Html::a('Examination Committees', ['stage-examiner/index', 'supervisor_id' => $model->id], ['class' => 'btn btn-default']) ?>

        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> 
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
</div>
	
	

	
	</div>
	<div class="col-md-8">

    <?php $form = \yii\widgets\ActiveForm::begin([
    'method' => 'get',
    'action' => ['view', 'id' => $model->id],
]); ?>
<div class="row" style="margin-bottom:10px;">
    <div class="col-md-4">
        <?= Html::hiddenInput('id', $model->id) ?>
        <?= $form->field($model, 'id')->dropDownList(Semester::listSemesterArray(), ['name' => 'semester_id', 'value' => $semesterId, 'prompt' => 'Semester', 'onchange' => 'this.form.submit();'])->label(false) ?>
    </div>
</div>
<?php \yii\widgets\ActiveForm::end(); ?>
	
	
	<div class="box">
<div class="box-header">
<h3 class="box-title">
Senarai Pelajar
</h3>
</div>
<div class="box-body">

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Matric No / Name</th>
      <th scope="col">Program</th>
      <th scope="col">Role</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
  <?php  
  if($supervisees){
      $i = 1;
      foreach($supervisees as $s){
          ?>
           <tr>
      <th scope="row"><?=$i?></th>
      <td><?= Html::a($s->student->matric_no . ' - ' . strtoupper($s->student->user->fullname), ['/postgrad/student/view', 'id' => $s->student->id, 'semester_id' => $semesterId]) ?></td>
      <td><?= $s->student->program ? $s->student->program->pro_name : '' ?></td>
      <td>
        <?php $roleClass = ($s->sv_role == 1 ? 'primary' : ($s->sv_role == 2 ? 'warning' : 'default')); ?>
        <span class="label label-<?=$roleClass?>"><?=$s->roleName()?> </span>
      </td>
		<td>
		    <?php
		    if (isset($superviseeRegs[$s->student_id])) {
		        echo $superviseeRegs[$s->student_id]->statusDaftarLabel;
		    } else {
		        echo '<span class="label label-default">N/A</span>';
		    }
		    ?>
		</td>
    </tr>
          
          <?php 
          $i++;
      }
  }
  
  ?>
   

  </tbody>
</table>


</div>
</div>



	<div class="box">
<div class="box-header">
<h3 class="box-title">
Jawatankuasa Pemeriksa <?php count($examinees)?>
</h3>
</div>
<div class="box-body">

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Stage</th>
      <th scope="col">Committee Role</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
  <?php  
  if($examinees){
      $i = 1;
      foreach($examinees as $x){
          ?>
           <tr>
      <th scope="row"><?=$i?></th>
      <td><?= Html::a((($x->matric_no ? $x->matric_no . ' - ' : '') . strtoupper($x->fullname)), ['/postgrad/student/view', 'id' => $x->id, 'semester_id' => $semesterId]) ?></td>
      <td><?=$x->stage_name?></td>
	  <td><?= isset($x->committee_role_label) ? Html::encode($x->committee_role_label) : '' ?></td>
		<td><?=StudentStage::statusText($x->stage_status)?></td>
    </tr>
          
          <?php 
          $i++;
      }
  }
  ?>
  </tbody>
</table>


</div>
</div>



	
	
	</div>
</div>




    
    




</div>
