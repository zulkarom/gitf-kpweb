<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;



/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
$course = $offer->course;
$offered_id = $offer->id;
$this->title = 'Coordinator';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Assignment', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = $this->title;


?>
<h4><?=$course->course_code . ' ' . $course->course_name?></h4>
<h4><?=$offer->semester->longFormat()?></h4>


<div class="form-group"><a href="<?=Url::to(['default/teaching-assignment-coordinator', 'id' => 1])?>" class="btn btn-warning" ><span class="fa fa-book"></span> Course Management</a>
							
<a href="<?=Url::to(['material/index', 'course' => $course->id])?>" class="btn btn-info" ><span class="glyphicon glyphicon-book"></span> Teaching Materials</a></div>

<div class="box">
<div class="box-header">
  <div class="box-title">Course Configuration</div>
</div>


<div class="box-body">
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($offer, 'course_version')->dropDownList(ArrayHelper::map($offer->course->versions, 'id', 'version_name')) ?>
	<?= $form->field($offer, 'material_version')->textInput() ?>
<div class="form-group">
        
<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
</div>



<div class="box">
<div class="box-header">
  <div class="box-title"><b>Peringkat Perancangan/Planning Level 
    <br/><div class="box-title">(PLAN)</b></div>
</div>
</div>

<div class="box-body">

  <table class="table">
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
              if($item->coor_upload == 1){
                echo '<tr><td>'.$i.'</td>
                  <td>'.$item->item.'<i><br/>'.$item->item_bi.'</i></td>
                  <td><a href="' . Url::to([$item->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> Upload</a></td>';
         
                  $i++;
              }
            
            }
          
        }
              ?>
      </tr>
    </thead>
   
  </table>
</div>
</div>

<div class="box">

<div class="box-header">
  <div class="box-title"><b>Peringkat Pelaksanaan/ Implementation Level
    <br/><div class="box-title">(DO)</b></div>
</div>
</div>
<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:85%">Item</th>
        <th></th>
      </tr>
    
        
        <tr>
        <?php 
    
        if($model->itemDo){
        $i = 1;
          
            foreach($model->itemDo as $item){
              if($item->coor_upload == 1){
                echo '<tr><td>'.$i.'</td>
                  <td>'.$item->item.'<i><br/>'.$item->item_bi.'</i></td>
                  <td><a href="' . Url::to([$item->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> Upload</a></td>';
         
                  $i++;
              }
            
            }
          
        }
              ?>
      </tr>
    </thead>
   
  </table>
</div>
</div>

<div class="box">
<div class="box-header">
  <div class="box-title"><b>Peringkat Semak/ Evaluation Level
    <br/><div class="box-title">(CHECK)</b></div>
</div>
</div>
<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:85%">Item</th>
        <th></th>
      </tr>
    
        
        <tr>
        <?php 
    
        if($model->itemCheck){
        $i = 1;
          
            foreach($model->itemCheck as $item){
              if($item->coor_upload == 1){
                echo '<tr><td>'.$i.'</td>
                  <td>'.$item->item.'<i><br/>'.$item->item_bi.'</i></td>
                  <td><a href="' . Url::to([$item->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> Upload</a></td>';
         
                  $i++;
              }
            
            }
          
        }
              ?>
      </tr>
    </thead>
   
  </table>
</div>
</div>

<div class="box">

<div class="box-header">
  <div class="box-title"><b>Peringkat Tindakan/ Review Level
    <br/><div class="box-title">(ACT)</b></div>
</div>
</div>

<div class="box-body">

  <table class="table">
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
              if($item->coor_upload == 1){
                echo '<tr><td>'.$i.'</td>
                  <td>'.$item->item.'<i><br/>'.$item->item_bi.'</i></td>
                  <td><a href="' . Url::to([$item->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> Upload</a></td>';
         
                  $i++;
              }
            
            }
          
        }
              ?>
      </tr>
    </thead>
   
  </table>
</div>
</div>




