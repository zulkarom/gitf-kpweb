<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentRegister */

$name = $model->student->user->fullname;
$this->title = 'View Semester: ' . $name;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['student/index']];
$this->params['breadcrumbs'][] = ['label' => $name, 'url' => ['student/view', 'id' => $model->student_id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="student-register-view">


<div class="row">
	<div class="col-md-6">


	 <div class="box">
<div class="box-header"></div>
<div class="box-body">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'studentName',
            'semesterName',
            'date_register:date',
            'fee_amount',
            'fee_paid_at',
        ],
    ]) ?>
    <br />
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
</div>



	</div>
	<div class="col-md-6">



	<div class="box">
<div class="box-header">
<h3 class="box-title">
Modules
</h3>
</div>
<div class="box-body">

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Module</th>
      <th scope="col">Result</th>
      <th scope="col" width="20%"></th>
    </tr>
  </thead>
  <tbody>
  <?php
  if($modules){
      $i = 1;
      foreach($modules as $m){
          ?>
           <tr>
       <th scope="row"><?=$i?></th>
      <td><?=$m->moduleName?></td>
      <td><?=$m->resultName?></td>
      <td><a href="<?=Url::to(['semester-module/update', 'id' => $m->id])?>" class="btn btn-warning btn-sm">View</a>

       <a href="<?=Url::to(['semester-module/delete', 'id' => $m->id])?>" class="btn btn-danger btn-sm" data-confirm="Are you sure to delete this module?"><i class="fa fa-trash"></i></a>

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
<a href="<?=Url::to(['semester-module/create', 'semester' => $model->id])?>" class="btn btn-primary btn-sm">Add Module</a>
</div>



</div>
</div>



	</div>
</div>










</div>
