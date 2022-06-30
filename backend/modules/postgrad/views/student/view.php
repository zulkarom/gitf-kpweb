<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\Student */

$this->title = $model->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="student-post-grad-view">




  <div class="row">
	<div class="col-md-6">
<div class="box">
<div class="box-header">
<h3 class="box-title">
Profile
</h3>
</div>

<div class="box-body">  
  
  
 <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            [
                'label' => 'Name',
                'value' => function($model){
                    return $model->user->fullname;
                }
            ],
            [
                'label' => 'Status Pelajar',
                'value' => function($model){
                return $model->statusText;
                }
                ],
            'matric_no',
            'nric',
            [
                'label' => 'Emel Pelajar',
                'value' => function($model){
                return $model->user->email;
                }
            ],
            'current_sem',
            'campus.campus_name',
            'program.pro_name',
            'field.field_name',
            [
                'label' => 'Taraf Pengajian',
                'value' => function($model){
                return $model->studyModeText;
                }
            ],
            'admission_year',
            [
                'label' => 'Tarikh Kemasukan ',
                'value' => function($model){
                return date('d F Y', strtotime($model->admission_date));
                }
                ],
            [
                'label' => 'Pembiayaan',
                'value' => function($model){
                return $model->sponsor;
                }
            ],
            [
                'label' => 'Sesi Masuk',
                'value' => function($model){
                if($model->semester){
                    return $model->semester->longFormat();
                }
                
                }
            ],
            
            
            [
                'label' => 'Negara Asal',
                'value' => function($model){
                return $model->country->country_name;
                }
                ],



            [
                'label' => 'Tarikh Lahir',
                'value' => function($model){
                    return date('d F Y', strtotime($model->date_birth));
                }
            ],
            [
                'label' => 'Jantina',
                'value' => function($model){
                    return $model->genderText;
                }
            ],
            [
                'label' => 'Taraf Perkahwinan',
                'value' => function($model){
                    return $model->maritalText;
                }
            ],
       
            [
                'label' => 'Kewarganegaraan',
                'value' => function($model){
                    return $model->citizenText;
                }
            ],
            
            'address',
            'city',
            'phone_no',
            'personal_email',
           
            [
                'label' => 'Agama',
                'value' => function($model){
                    return $model->religionText;
                }
            ],
            [
                'label' => 'Bangsa',
                'value' => function($model){
                    return $model->raceText;
                }
            ],
            'bachelor_name',
            'bachelor_university',
            'bachelor_cgpa',
            'bachelor_year',
            'relatedUniversity.uni_name',
            'outstanding_fee',
            'remark:ntext'

            
        ],
    ]) ?>
	
	 </div>
</div>

    <p>
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


<div class="col-md-6">



<div class="box">
<div class="box-header">
<h3 class="box-title">
Semester
</h3>
</div>
<div class="box-body">

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Semester</th>
      <th scope="col">Status</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <?php  
  if($semesters){
      $i = 1;
      foreach($semesters as $s){
          ?>
           <tr>
      <th scope="row"><?=$i?></th>
      <td><?=$s->semester->longFormat()?></td>
      <td><?=$s->statusText?></td>
      <td><a href="<?=Url::to(['student-semester/view', 'id' => $s->id])?>" class="btn btn-warning btn-sm">View</a> 
       <a href="<?=Url::to(['student-semester/delete', 'id' => $s->id])?>" class="btn btn-danger btn-sm" data-confirm="Are you sure to delete this semester?"><i class="fa fa-trash"></i></a>
      </td>
    </tr>
          
          <?php 
          $i++;
      }
  }
  
  ?>
   

  </tbody>
</table>


<br />
<div class="form-group">
<a href="<?=Url::to(['student-semester/create', 's' => $model->id])?>" class="btn btn-primary btn-sm">Add Semester</a>
</div>



</div>
</div>

<div class="box">
<div class="box-header">
<h3 class="box-title">
Supervisor
</h3>
</div>
<div class="box-body">

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Role</th>
      <th scope="col">In/External</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <?php  
  if($supervisors){
      $i = 1;
      foreach($supervisors as $s){
          ?>
           <tr>
      <th scope="row"><?=$i?></th>
      <td><?=$s->supervisor->svName?></td>
      <td><?=$s->roleName()?></td>
      <td><?=$s->supervisor->typeName?></td>
      <td><a href="<?=Url::to(['student-supervisor/update', 'id' => $s->id])?>" class="btn btn-warning btn-sm">View</a>  
      
       <a href="<?=Url::to(['student-supervisor/delete', 'id' => $s->id])?>" class="btn btn-danger btn-sm" data-confirm="Are you sure to delete this supervisor?"><i class="fa fa-trash"></i></a>
      </td>
    </tr>
          
          <?php 
          $i++;
      }
  }
  
  ?>
   

  </tbody>
</table>


<br />
<div class="form-group">
<a href="<?=Url::to(['student-supervisor/create', 's' => $model->id])?>" class="btn btn-primary btn-sm">Add Supervisor</a>
</div>



</div>
</div>


<div class="box">
<div class="box-header">
<h3 class="box-title">
Research Stage
</h3>
</div>
<div class="box-body">

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Stage</th>
      <th scope="col">Status</th>
      <th scope="col">Date</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <?php  
  if($stages){
      $i = 1;
      foreach($stages as $s){
          ?>
           <tr>
      <th scope="row"><?=$i?></th>
      <td><?=$s->stage->stage_name?></td>
      <td><?=$s->statusName?></td>
      <td><?=date('d/m/Y', strtotime($s->stage_date))?></td>
      <td><a href="<?=Url::to(['student-stage/view', 'id' => $s->id])?>" class="btn btn-warning btn-sm">View</a> 
      
        <a href="<?=Url::to(['student-stage/delete', 'id' => $s->id])?>" class="btn btn-danger btn-sm" data-confirm="Are you sure to delete this stage?"><i class="fa fa-trash"></i></a>
      </td>
    </tr>
          
          <?php 
          $i++;
      }
  }
  
  ?>
   

  </tbody>
</table>


<br />
<div class="form-group">
<a href="<?=Url::to(['student-stage/create', 's' => $model->id])?>" class="btn btn-primary btn-sm">Add Stage</a>
</div>



</div>
</div>









</div>


</div>
</div>
