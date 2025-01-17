<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Tutorial ['.$tutorial->tutorialName.']';
$this->params['breadcrumbs'][] = ['label' => 'My Course File', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = $this->title;
$course = $tutorial->lecture->courseOffered->course;
?>

<h4><?=$course->course_code . ' ' . $course->course_name?> - <?=$tutorial->lecture->courseOffered->semester->longFormat()?></h4>


<?php $form = ActiveForm::begin(); ?>

<h4>Student Attendance</h4>
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
	<td>Student Attendance</td>
	<td><a href="<?=Url::to(['tutorial-student-attendance','id' => $tutorial->id])?>" class="btn btn-default btn-sm" ><span class="fa fa-pencil"></span> Update</a></td>
        <td><?=$tutorial->progressStudentAttendance?></td>
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
    
        
        <tr>
        <?php 
    
        if($model->itemDo){
        $i = 1;
          foreach($model->itemDo as $item){
			  $progress_function = $item->progress_function;
            if($item->lec_upload == 1){
              echo '<tr><td>'.$i.'</td>
                <td>'.$item->item_bi.'</td>
                <td><a href="' . Url::to(['tutorial-'.$item->upload_url.'/page','id' => $tutorial->id]) . '" class="btn btn-default btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>
				<td>'.$tutorial->$progress_function .'</td>
				';
       
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

<?php ActiveForm::end(); ?>

