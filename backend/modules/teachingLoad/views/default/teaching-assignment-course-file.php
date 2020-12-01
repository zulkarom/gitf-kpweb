<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Course Files';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Assignment', 'url' => ['/teaching-load/default/teaching-assignment']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
#course {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#course td, #course th {
  border: 1px solid #ddd;
  padding: 8px;
}

#course tr:nth-child(even){background-color: #f2f2f2;}

#course tr:hover {background-color: #ddd;}

#course th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #3c8dbc;
  color: white;
}
</style>

<div class="teaching-assignment-course-file">
<?php $form = ActiveForm::begin(); ?>


<div class="box box-primary">
<div class="box-header">
	<div class="box-title"><b>Peringkat Perancangan/Planning Level
    <br/><div class="box-title">(PLAN)</b></div>
</div>
</div>
<div class="box-body">
<table id="course">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
    	  <th style="width:85%">Item</th>
        <th>Action</th>
      </tr>
    
        
        <tr>
        <?php 
    
       if($model->itemPlan){
        $i = 1;
          foreach($model->itemPlan as $item){
        	echo '<tr><td>'.$item->id.'</td>
              	<td>'.$item->item.'<i><br/>'.$item->item_bi.'</i></td>
                <td><a href="" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> Upload</a></td>';
       
                $i++;
          }
        }
              ?>
      </tr>
    </thead>
  </table>

</div>
<div class="box-header">
	<div class="box-title"><b>Peringkat Pelaksanaan/ Implementation Level
    <br/><div class="box-title">(DO)</b></div>
</div>
</div>
<div class="box-body">

  <table id="course">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:85%">Item</th>
        <th>Action</th>
      </tr>
    
        
        <tr>
        <?php 
    
        if($model->itemDo){
        $i = 1;
          foreach($model->itemDo as $item){
        	echo '<tr><td>'.$item->id.'</td>
              	<td>'.$item->item.'<i><br/>'.$item->item_bi.'</i></td>
                <td><a href="" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> Upload</a></td>';
       
                $i++;
          }
        }
              ?>
      </tr>
    </thead>
   
  </table>
</div>

<div class="box-header">
	<div class="box-title"><b>Peringkat Semak/ Evaluation Level
     <br/><div class="box-title">(CHECK)</b></div>
</div>
</div>
<div class="box-body">
  <table id="course">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:85%">Item</th>
        <th>Action</th>
      </tr>
    
        
        <tr>
        <?php 
    
        if($model->itemCheck){
        $i = 1;
          foreach($model->itemCheck as $item){
        	echo '<tr><td>'.$item->id.'</td>
              	<td>'.$item->item.'<i><br/>'.$item->item_bi.'</i></td>
                <td><a href="" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> Upload</a></td>';
       
                $i++;
          }
        }
              ?>
      </tr>
    </thead>
   
  </table>
</div>

<div class="box-header">
	<div class="box-title"><b>Peringkat Tindakan/ Review Level
    <br/><div class="box-title">(ACT)</b></div>
</div>
</div>
<div class="box-body">
  <table id="course">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:85%">Item</th>
        <th>Action</th>
      </tr>
    
        
        <tr>
        <?php 
    
        if($model->itemAct){
        $i = 1;
          foreach($model->itemAct as $item){
        	echo '<tr><td>'.$item->id.'</td>
              	<td>'.$item->item.'<i><br/>'.$item->item_bi.'</i></td>
                <td><a href="" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> Upload</a></td>';
       
                $i++;
          }
        }
              ?>
      </tr>
    </thead>
   
  </table>
</div>

</div>

</div>




</div>
<?php ActiveForm::end(); ?>


</div>
