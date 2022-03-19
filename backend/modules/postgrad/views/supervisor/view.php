<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\modules\postgrad\models\StudentStage;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\Supervisor */

$this->title = 'View Supervisor / Examiner';
$this->params['breadcrumbs'][] = ['label' => 'Supervisors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
table.detail-view th {
    width:15%;
}
</style>

<div class="supervisor-view">


<div class="row">
	<div class="col-md-6">
	
	     <div class="box">
<div class="box-header"></div>
<div class="box-body">
    <?php 
    
    $data = ['typeName'];
        $data[] = 'svName';
        $data[] = 'svFieldsString';
    $data[] = 'created_at';
    $data[] = 'updated_at';
    
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $data,
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
Supervisee
</h3>
</div>
<div class="box-body">

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
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
      <td><?=$s->student->user->fullname?></td>
      <td><?=$s->roleName()?></td>
		<td><?=$s->student->statusText?></td>
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
Examinees <?php count($examinees)?>
</h3>
</div>
<div class="box-body">

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Stage</th>
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
      <td><?=$x->fullname?></td>
      <td><?=$x->stage_name?></td>
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
