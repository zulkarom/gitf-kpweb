<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
$offer = $lecture->courseOffered;
$course = $offer->course;
$this->title = 'Lecture ['.$lecture->lec_name.']';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Load', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = $this->title;
?>


<h4><?=$course->course_code . ' ' . $course->course_name?> - <?=$offer->semester->longFormat()?></h4>

<h4>Student / Attendance / Result Data</h4>
<div class="box">

<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:75%">Item</th>
        <th style="width:10%">Action</th>
		<th>Progress</th>
      
        
      </tr>
    </thead>
	
	
	<tr>
    <td>1. </td>
	<td>Student List</td>
<td><a href="<?=Url::to(['lecture-student-list','id' => $lecture->id])?>" class="btn btn-warning btn-sm" ><span class="fa fa-pencil"></span> Update</a></td>

<td><?=$lecture->progressStudentList?></td>
        
        </tr>
		
	<tr>
    <td>2. </td>
	<td>Student Attendance</td>
	<td><a href="<?=Url::to(['lecture-student-attendance','id' => $lecture->id])?>" class="btn btn-warning btn-sm" ><span class="fa fa-pencil"></span> Update</a></td>
        <td><?=$lecture->progressStudentAttendance?></td>
        </tr>
	
	<tr>
    <td>3. </td>
	<td>Student Assessment Result</td>

	<td>
	<a href="<?=Url::to(['lecture-student-assessment','id' => $lecture->id])?>" class="btn btn-warning btn-sm" ><span class="fa fa-pencil"></span> Update</a>
	</td>
        <td><?=$lecture->progressStudentAssessment?></td>
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
        <th style="width:75%">Item</th>
        <th style="width:10%">Action</th>
		 <th>Progress</th>
      </tr>
    
        
        <?php 
    $item = $model->itemDo;
        if($model->itemDo){
        $i = 1;
          foreach($model->itemDo as $item){
            if($item->lec_upload == 1){
				$progress_function = $item->progress_function;
              echo '<tr><td>'.$i.'</td>
                <td>'.$item->item_bi.'</td>
                <td><a href="' . Url::to(['lecture-'.$item->upload_url.'/page','id' => $lecture->id]) . '" class="btn btn-warning btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>
				<td>'.$lecture->$progress_function .'</td>
				
				';
       
                $i++;
            }
          }
        }
              ?>

    </thead>
   
  </table>
</div>
</div>


