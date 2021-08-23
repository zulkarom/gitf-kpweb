<?php

use common\models\UploadFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$lecture->file_controller = 'attendance-lecture-file';


$offer = $lecture->courseOffered;
$course = $offer->course;

$this->title = 'Student Attendance ['.$lecture->lec_name.']';
$this->params['breadcrumbs'][] = ['label' => 'My Course File', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => 'Lecture['.$lecture->lec_name.']', 'url' => ['teaching-assignment-lecture', 'id' => $lecture->id]];
$this->params['breadcrumbs'][] = 'Student Attendance';

?> 
<div class="row">
  <div class="col-md-6">
  
  <h4><?=$course->course_code . ' ' . $course->course_name?></h4>
<h4><?=$offer->semester->longFormat()?></h4>
  </div>

</div>

<div class="box">

          <div class="box-body">
           
            


<?=UploadFile::fileInput($lecture, 'attendance')?>
             

           
          </div>
        </div>
		
		
		
		
<?php $form = ActiveForm::begin() ?>
		<input type="hidden" name="pg" value="1" />
		 <div class="form-group">
                  <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span>  Save Attendance', ['class' => 'btn btn-success', 'id' => 'btn-save']) ?>
              </div>
		
 <?php ActiveForm::end(); ?>





