<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\models\Semester;
use kartik\date\DatePicker;

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
            'matric_no',
            'nric',
            [
                'label' => 'Emel Pelajar',
                'value' => function($model){
                return $model->user->email;
                }
            ],
            
            'campus.campus_name',
            'program.pro_name',
            'field.field_name',
            [
                'label' => 'Taraf Pengajian',
                'value' => function($model){
                return $model->studyModeText;
                }
            ],
            
            [
                'label' => 'Pembiayaan',
                'value' => function($model){
                return $model->sponsor;
                }
            ],
            
            
            
            [
                'label' => 'Negara Asal',
                'value' => function($model){
                return $model->country ? $model->country->country_name : '-';
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
         
            'remark:ntext'

            
        ],
    ]) ?>
	
	 </div>
</div>

    <div class="clearfix">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    </div>
  
  
</div>


<div class="col-md-6">



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
      <th scope="col">Semester</th>
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
      <td><?= $s->semester ? $s->semester->shortFormat() : '' ?></td>
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
      <th scope="col">Active</th>
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
      <td><?= Html::a($s->supervisor->svName, ['/postgrad/supervisor/view', 'id' => $s->supervisor->id]) ?></td>
      <td><?=$s->roleName()?></td>
      <td><?=$s->supervisor->typeName?></td>
      <td><?= $s->isActiveLabel ?></td>
      <td><a href="<?=Url::to(['student-supervisor/update', 'id' => $s->id])?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>  
      
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
Pendaftaran Semester
</h3>
</div>
<div class="box-body">

<div class="row">
    <div class="col-md-12">
        <table class="table" style="margin-bottom: 15px;">
            <tbody>
                <tr>
                    <th style="width: 220px;">Semester Semasa Pelajar</th>
                    <td><?= Html::encode($model->current_sem) ?></td>
                </tr>
                <tr>
                    <th>Tahun Kemasukan</th>
                    <td><?= Html::encode($model->admission_year) ?></td>
                </tr>
                <tr>
                    <th>Tarikh Kemasukan</th>
                    <td><?= $model->admission_date ? Html::encode(date('d F Y', strtotime($model->admission_date))) : '' ?></td>
                </tr>
                <tr>
                    <th>Sesi Masuk</th>
                    <td><?= $model->semester ? Html::encode($model->semester->longFormat()) : '' ?></td>
                </tr>
            </tbody>
        </table>

        <div class="form-group">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#semesterInfoModal">Update</button>
        </div>
    </div>
</div>

<div class="modal fade" id="semesterInfoModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Maklumat Pendaftaran Semester</h4>
      </div>
      <div class="modal-body">
        <?php $form = ActiveForm::begin([
            'action' => Url::to(['student/update-semester-info', 'id' => $model->id]),
            'method' => 'post',
        ]); ?>

        <?= $form->field($model, 'current_sem')->textInput() ?>
        <?= $form->field($model, 'admission_year')->textInput() ?>
        <?= $form->field($model, 'admission_date')->widget(DatePicker::classname(), [
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true,
            ],
        ]) ?>
        <?= $form->field($model, 'admission_semester')->dropDownList(
            ArrayHelper::map(Semester::find()->orderBy(['id' => SORT_DESC])->all(), 'id', function($m){
                return $m->longFormat();
            }),
            ['prompt' => '']
        ) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>

        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Senarai Rekod Pendaftaran Semester</th>
      <th scope="col">Status Daftar</th>
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
      <td><?= \backend\modules\postgrad\models\StudentRegister::statusDaftarLabel($s->status_daftar) ?></td>
      <td><a href="<?=Url::to(['student-register/update', 'id' => $s->id])?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> 
       <a href="<?=Url::to(['student-register/delete', 'id' => $s->id])?>" class="btn btn-danger btn-sm" data-confirm="Are you sure to delete this semester?"><i class="fa fa-trash"></i></a>
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
<a href="<?=Url::to(['student-register/create', 's' => $model->id])?>" class="btn btn-primary btn-sm">Add Semester</a>
 <a href="<?=Url::to(['student-register/bulk-edit', 's' => $model->id])?>" class="btn btn-warning btn-sm">Bulk Add/Edit</a>
</div>



</div>
</div>









</div>


</div>



    <div class="clearfix">
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this student?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>
</div>
