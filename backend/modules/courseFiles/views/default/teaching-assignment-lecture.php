<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
$offer = $lecture->courseOffered;
$course = $offer->course;

$this->title = 'Lecturer ['.$lecture->lec_name.']';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Assignment', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = $this->title;


?>


<h4><?=$course->course_code . ' ' . $course->course_name?></h4>
<h4><?=$offer->semester->longFormat()?></h4>
<br />


<h4>Student / Attendance / Result Data</h4>
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
	
	
	<tr>
    <td>1. </td>
	<td>Student List</td>
<td><a href="<?=Url::to(['lecture-student-list','id' => $lecture->id])?>" class="btn btn-warning btn-sm" ><span class="fa fa-pencil"></span> Update</a></td>
        
        </tr>
		
	<tr>
    <td>2. </td>
	<td>Student Attendance</td>
	<td><a href="<?=Url::to(['lecture-student-attendance','id' => $lecture->id])?>" class="btn btn-warning btn-sm" ><span class="fa fa-pencil"></span> Update</a></td>
        
        </tr>
	
	<tr>
    <td>3. </td>
	<td>Student Assessment Result</td>

	<td>
	<a href="<?=Url::to(['lecture-student-assessment','id' => $lecture->id])?>" class="btn btn-warning btn-sm" ><span class="fa fa-pencil"></span> Update</a>
	</td>
        
        </tr>
	
   
  </table>
</div>
</div>



<h4>Upload Documents</h4>
<div class="box">

<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:85%">Item</th>
        <th>Action</th>
      </tr>
    
        
        <?php 
    
        if($model->itemDo){
        $i = 1;
          foreach($model->itemDo as $item){
            if($item->lec_upload == 1){
              echo '<tr><td>'.$i.'</td>
                <td>'.$item->item_bi.'</td>
                <td><a href="' . Url::to(['lecture-'.$item->upload_url.'/page','id' => $lecture->id]) . '" class="btn btn-warning btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>';
       
                $i++;
            }
          }
        }
              ?>
    </thead>
   
  </table>
</div>
</div>


