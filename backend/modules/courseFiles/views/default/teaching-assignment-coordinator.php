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


<h4>Course Configuration</h4>
<div class="box">


<div class="box-body">
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($offer, 'course_version')->dropDownList(ArrayHelper::map($offer->course->versions, 'id', 'version_name')) ?>
	<?= $form->field($offer, 'material_version')->dropDownList(ArrayHelper::map($offer->course->materials, 'id', 'material_name')) ?>
<div class="form-group">
        
<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
</div>

<h4>Assessment Materials & Rubrics</h4>
<div class="box">

<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:85%">Item</th>
        <th>Action</th>
      </tr>
	  
	  </thead>
    
      <?php 
    
        if($model->assessMaterials){
        $i = 1;
          
            foreach($model->assessMaterials as $item){
              if($item->coor_upload == 1){
                echo '<tr><td>'.$i.'. </td>
                  <td>'.$item->item_bi.'</td>
                  <td><a href="' . Url::to([$item->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-warning btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>';
         
                  $i++;
              }
            
            }
          
        }
              ?>
   
   
  </table>
</div>
</div>

<h4>Assessment Scripts</h4>
<div class="box">

<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:85%">Item</th>
        <th>Action</th>
      </tr>
	  </thead>
	  
	  <?php 
    
        $i = 1;
          
            foreach($model->assessScripts as $item){
              if($item->coor_upload == 1){
                echo '<tr><td>'.$i.'. </td>
                  <td>'.$item->item_bi.'</td>
                  <td><a href="' . Url::to([$item->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-warning btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>';
         
                  $i++;
              }
            
            }
          
              ?>
    
      
   
   
  </table>
</div>
</div>




<h4>Continuous Quality Improvement (CQI)</h4>
<div class="box">


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
                echo '<tr><td>'.$i.'</td>
                  <td>Plan for Course Improvement (if any)</td>
                  <td><a href="' . Url::to(['coordinator/course-cqi','id' => $offered_id]) . '" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-pencil"></span> Update</a></td>';
         
              ?>
      </tr>
    </thead>
   
  </table>
</div>
</div>




