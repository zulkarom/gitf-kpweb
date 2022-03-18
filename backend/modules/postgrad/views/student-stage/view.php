<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentStage */

$this->title = 'View Stage: ' . $model->student->user->fullname;


$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['student/index']];
$this->params['breadcrumbs'][] = ['label' => $model->student->user->fullname, 'url' => ['student/view', 'id' => $model->student->id]];
$this->params['breadcrumbs'][] = 'View Stage';



?>
<div class="student-stage-view">



<div class="row">
	<div class="col-md-6">
	
	
	 <div class="box">
<div class="box-header"></div>
<div class="box-body">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'studentName',
            'stageName',
            'semesterName',
            'stage_date',
            'chairmanName',
            'statusName',
            'remark'
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
Examiners
</h3>
</div>
<div class="box-body">

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Examiners</th>
      <th scope="col">Type</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <?php  
  if($examiners){
      $i = 1;
      foreach($examiners as $s){
          ?>
           <tr>
       <th scope="row"><?=$i?></th>
      <td><?=$s->examiner->svName?></td>
      <td><?=$s->examiner->typeName?></td>
      <td><a href="<?=Url::to(['stage-examiner/update', 'id' => $s->id])?>" class="btn btn-warning btn-sm">View</a>  
      
        <a href="<?=Url::to(['stage-examiner/delete', 'id' => $s->id])?>" class="btn btn-danger btn-sm" data-confirm="Are you sure to delete this examiner?"><i class="fa fa-trash"></i></a>
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
<a href="<?=Url::to(['stage-examiner/create', 'stage' => $model->id])?>" class="btn btn-primary btn-sm">Add Examiner</a> 

  
</div>



</div>
</div>
	
	
	
	</div>
</div>







</div>
