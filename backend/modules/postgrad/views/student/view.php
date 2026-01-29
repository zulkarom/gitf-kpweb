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

$readOnly = Yii::$app->controller->id === 'mystudent';
$isAdminPostgrad = Yii::$app->user->can('postgrad-manager');
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
            [
                'label' => 'Last Status',
                'format' => 'raw',
                'value' => function($model){
                    return \backend\modules\postgrad\models\StudentRegister::statusDaftarLabel($model->last_status_daftar);
                }
            ],
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

    <?php if (!$readOnly) { ?>
    <div class="clearfix">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    </div>
    <?php } ?>
  
  
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
      <td><?php
            $bm = $s->stage ? (string)$s->stage->stage_name : '';
            $en = $s->stage ? (string)$s->stage->stage_name_en : '';
            echo Html::encode($en !== '' ? $en : $bm);
        ?></td>
      <td><?=$s->statusName?></td>
      <td><?= $s->semester ? $s->semester->shortFormat() : '' ?></td>
      <td>
        <?php if (!$readOnly) { ?>
        <a href="<?=Url::to(['student-stage/view', 'id' => $s->id])?>" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>
        <a href="<?=Url::to(['student-stage/delete', 'id' => $s->id])?>" class="btn btn-danger btn-sm" data-confirm="Are you sure to delete this stage?"><i class="fa fa-trash"></i></a>
        <?php } ?>
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
<?php if (!$readOnly) { ?>
<div class="form-group">
<a href="<?=Url::to(['student-stage/create', 's' => $model->id])?>" class="btn btn-primary btn-sm">Add Stage</a>
</div>
<?php } ?>



</div>
</div>

<div class="box">
<div class="box-header with-border">
<h3 class="box-title">
Thesis
</h3>

</div>
<div class="box-body">

<table class="table" style="margin-bottom: 15px;">
    <tbody>
        <tr>
            <th style="width: 220px;">Thesis Title</th>
            <td><?= isset($thesis) && $thesis && $thesis->thesis_title ? Html::encode($thesis->thesis_title) : '-' ?></td>
        </tr>
    </tbody>
</table>

<div class="box-tools">
    <button type="button" class="btn btn-primary btn-sm" id="thesisTitleToggleBtn">Hide</button>
</div>

<div id="thesisTitleSection" style="display:none;">
<?php if (isset($thesisList) && $thesisList) { ?>
<table class="table table-bordered table-striped" style="margin-bottom: 15px;">
    <thead>
        <tr>
            <th style="width: 60px;">#</th>
            <th>Thesis Title</th>
            <th style="width: 150px;">Date Applied</th>
            <th style="width: 90px;">Active</th>
            <?php if (!$readOnly) { ?><th style="width: 90px;"></th><?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; foreach ($thesisList as $t) { ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $t && $t->thesis_title ? Html::encode($t->thesis_title) : '-' ?></td>
            <td><?= $t && $t->date_applied ? Html::encode(date('d F Y', strtotime($t->date_applied))) : '-' ?></td>
            <td><?= (int)$t->is_active === 1 ? 'Yes' : 'No' ?></td>
            <?php if (!$readOnly) { ?>
            <td>
                <a class="btn btn-xs btn-primary" href="<?= Url::to(['student/thesis-update', 'id' => $model->id, 'thesis_id' => $t->id]) ?>">Edit</a>
            </td>
            <?php } ?>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>
<?php } ?>

<?php if (!$readOnly) { ?>
<div class="form-group" style="margin-top: 0;">
    <a href="<?= Url::to(['student/thesis-create', 'id' => $model->id]) ?>" class="btn btn-success btn-sm">Add Title</a>
</div>
<?php } ?>
</div>

<?php
$thesisTitleToggleKey = 'pg_student_thesis_title_section_hidden_' . (int)$model->id;
$this->registerJs("(function(){\n" .
"  var btn = document.getElementById('thesisTitleToggleBtn');\n" .
"  var section = document.getElementById('thesisTitleSection');\n" .
"  if(!btn || !section) return;\n" .
"  var key = " . json_encode($thesisTitleToggleKey) . ";\n" .
"  function setState(hidden){\n" .
"    section.style.display = hidden ? 'none' : '';\n" .
"    btn.textContent = hidden ? 'Show Titles List' : 'Hide Titles List';\n" .
"    try { localStorage.setItem(key, hidden ? '1' : '0'); } catch(e) {}\n" .
"  }\n" .
"  setState(true);\n" .
"  btn.addEventListener('click', function(){\n" .
"    hidden = section.style.display !== 'none';\n" .
"    setState(hidden);\n" .
"  });\n" .
"})();");
?>

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
      <td><?php
            $sv = $s->supervisor;
            $label = $sv ? $sv->svName : '';
            if ($sv && (int)$sv->is_internal === 1 && $sv->staff) {
                $staffNo = (string)$sv->staff->staff_no;
                $staffName = (string)$sv->staff->staff_name;
                if ($staffName === '' && $sv->staff->user) {
                    $staffName = (string)$sv->staff->user->fullname;
                }
                if ($staffNo !== '' && $staffName !== '') {
                    $label = $staffNo . ' - ' . strtoupper($staffName);
                }
            }

            if ($isAdminPostgrad && $sv) {
                echo Html::a(Html::encode($label), ['supervisor/view', 'id' => $sv->id]);
            } else {
                echo Html::encode($label);
            }
        ?></td>
      <td><?=$s->roleName()?></td>
      <td><?=$s->supervisor->typeName?></td>
      <td><?= $s->isActiveLabel ?></td>
      <td>
        <?php if (!$readOnly) { ?>
        <a href="<?=Url::to(['student-supervisor/update', 'id' => $s->id])?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>  
        <a href="<?=Url::to(['student-supervisor/delete', 'id' => $s->id])?>" class="btn btn-danger btn-sm" data-confirm="Are you sure to delete this supervisor?"><i class="fa fa-trash"></i></a>
        <?php } ?>
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
<?php if (!$readOnly) { ?>
<div class="form-group">
<a href="<?=Url::to(['student-supervisor/create', 's' => $model->id])?>" class="btn btn-primary btn-sm">Add Supervisor</a>
</div>
<?php } ?>



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
                    <th>Tarikh Kemasukan</th>
                    <td><?= $model->admission_date ? Html::encode(date('d F Y', strtotime($model->admission_date))) : '' ?></td>
                </tr>
                <tr>
                    <th>Sesi Masuk</th>
                    <td><?= $model->semester ? Html::encode($model->semester->longFormat()) : '' ?></td>
                </tr>
                 <tr>
                    <th style="width: 220px;">Semester Semasa Pelajar</th>
                    <td><?= Html::encode($model->current_sem) ?></td>
                </tr>
            </tbody>
        </table>

        <?php if (!$readOnly) { ?>
        <div class="form-group">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#semesterInfoModal">Update</button>
        </div>
        <?php } ?>
    </div>
</div>

<?php if (!$readOnly) { ?>
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
<?php } ?>

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
      <td><a href="#" class="js-student-reg-modal" data-url="<?=Url::to(['student-register/modal', 'id' => $s->id])?>"><?=$s->semester->longFormat()?></a></td>
      <td><?= \backend\modules\postgrad\models\StudentRegister::statusDaftarOutlineLabel($s->status_daftar) ?></td>
      <td>
        <?php if (!$readOnly) { ?>
        <a href="<?=Url::to(['student-register/update', 'id' => $s->id])?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> 
        <a href="<?=Url::to(['student-register/delete', 'id' => $s->id])?>" class="btn btn-danger btn-sm" data-confirm="Are you sure to delete this semester?"><i class="fa fa-trash"></i></a>
        <?php } ?>
      </td>
    </tr>
          
          <?php 
          $i++;
      }
  }
  
  ?>
   

  </tbody>
</table>

<div class="modal fade" id="studentRegDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Maklumat Pendaftaran Semester</h4>
      </div>
      <div class="modal-body" id="studentRegDetailModalBody">
        Loading...
      </div>
    </div>
  </div>
</div>

<?php
    $this->registerJs(<<<JS
    (function(){
        function setBody(html){
            $('#studentRegDetailModalBody').html(html);
        }

        $(document).on('click', '.js-student-reg-modal', function(e){
            e.preventDefault();
            var url = $(this).data('url');
            if(!url){
                return;
            }

            setBody('Loading...');
            $('#studentRegDetailModal').modal('show');

            $.get(url).done(function(html){
                setBody(html);
            }).fail(function(xhr){
                var msg = 'Failed to load details';
                try {
                    if(xhr && xhr.responseText){
                        msg += ': ' + xhr.responseText;
                    }
                } catch(e) {}
                setBody('<div class="alert alert-danger">'+msg+'</div>');
            });
        });
    })();
JS);
?>


<br />
<?php if (!$readOnly) { ?>
<div class="form-group">
<a href="<?=Url::to(['student-register/create', 's' => $model->id])?>" class="btn btn-primary btn-sm">Add Semester</a>
 <a href="<?=Url::to(['student-register/bulk-edit', 's' => $model->id])?>" class="btn btn-warning btn-sm">Bulk Add/Edit</a>
</div>
<?php } ?>



</div>
</div>









</div>


</div>



    <div class="clearfix">
        <?php if (!$readOnly) { ?>
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this student?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <?php } ?>
    </div>
</div>
