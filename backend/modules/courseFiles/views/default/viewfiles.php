<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Course Files';
$this->params['breadcrumbs'][] = $this->title;
?>


<style>
  div.a {
  text-align: center;
}
</style>    
<div class="course-offered-session">
<?php $form = ActiveForm::begin(); ?>


<div class="box">
<div class="box-header">
  <div class="a">
	<div class="box-title"><b>Peringkat Perancangan/Planning Level
    <br/><div class="box-title">(PLAN)</b></div>
</div>
</div>
</div>
<div class="box-body">
<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>No.</th>
    	<th>Item</th>
      </tr>
    
        
        <tr>
        <?php 
    
       if($model->itemPlan){
        $i = 1;
          foreach($model->itemPlan as $item){
        	echo '<tr><td>'.$item->id.'</td>
              	<td>'.$item->item.'</td>';
       
                $i++;
          }
        }
              ?>
      </tr>
    </thead>
  </table>
</div>
</div>
<div class="box-header">
  <div class="a">
	<div class="box-title"><b>Peringkat Pelaksanaan/ Implementation Level
    <br/><div class="box-title">(DO)</b></div>
</div>
</div>
</div>
<div class="box-body">
<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>No.</th>
    	<th>Item</th>
      </tr>
    
        
        <tr>
        <?php 
    
        if($model->itemDo){
        $i = 1;
          foreach($model->itemDo as $item){
        	echo '<tr><td>'.$item->id.'</td>
              	<td>'.$item->item.'</td>';
       
                $i++;
          }
        }
              ?>
      </tr>
    </thead>
   
  </table>
</div>
</div>

<div class="box-header">
  <div class="a">
	<div class="box-title"><b>Peringkat Semak/ Evaluation Level
     <br/><div class="box-title">(CHECK)</b></div>
</div>
</div>
</div>
<div class="box-body">
<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>No.</th>
    	<th>Item</th>
      </tr>
    
        
        <tr>
        <?php 
    
        if($model->itemCheck){
        $i = 1;
          foreach($model->itemCheck as $item){
        	echo '<tr><td>'.$item->id.'</td>
              	<td>'.$item->item.'</td>';
       
                $i++;
          }
        }
              ?>
      </tr>
    </thead>
   
  </table>
</div>
</div>

<div class="box-header">
  <div class="a">
	<div class="box-title"><b>Peringkat Tindakan/ Review Level
    <br/><div class="box-title">(ACT)</b></div>
</div>
</div>
</div>
<div class="box-body">
<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>No.</th>
    	<th>Item</th>
      </tr>
    
        
        <tr>
        <?php 
    
        if($model->itemAct){
        $i = 1;
          foreach($model->itemAct as $item){
        	echo '<tr><td>'.$item->id.'</td>
              	<td>'.$item->item.'</td>';
       
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




</div>
<?php ActiveForm::end(); ?>


</div>
