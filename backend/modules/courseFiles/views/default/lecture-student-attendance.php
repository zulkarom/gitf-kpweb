<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\grid\GridView;
use backend\assets\ExcelAsset;
use kartik\export\ExportMenu;


$offer = $lecture->courseOffered;
$course = $offer->course;
/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Lecture ['.$lecture->lec_name.']';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Assignment', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['teaching-assignment-lecture', 'id' => $lecture->id]];
$this->params['breadcrumbs'][] = 'Student List';
?>

<h4><?=$course->course_code . ' ' . $course->course_name?></h4>
<h4><?=$offer->semester->longFormat()?></h4>
<br />

<?php /* <div class="form-group"><?= Html::a('Manage Class Date', ['/course-files/default/lecture-student-attendance-date', 'id' => $lecture->id], ['class' => 'btn btn-success']) ?></div> */?>
<div class="row">
  <div class="col-md-6" align="right">
  </div>
  <div class="col-md-6" align="right">

   <a href="<?=Url::to(['attendance-sync', 'id' => $lecture->id])?>" class="btn btn-success"><i class="fa fa-refresh"></i> Re-Sync</a>

    <br/>
  </div>
</div>

<div class="box">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Student Attendance</b></div>
          </div>
        </div>
          <div class="box-body">
            <?php $form = ActiveForm::begin() ?>
            <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Matric No.</th>
                    <th>Name</th>
                  
                      <?php 
                      $attendance = json_decode($lecture->attendance_header);
                      if($attendance){
                        foreach($attendance as $attend){
                          echo'<th>'. date('d-m', strtotime($attend)) .'</th>';
                        }
                      }
                  echo'<th>%</th></tr>
				   </thead>
				  ';
                  ?>

                     <?php
                    $i=1;
                    if($lecture->students){
                      foreach ($lecture->students as $student) {
                        if($student->lecture_id == $lecture->id){
                          echo'<tr><td>'.$i.'</td>
                          <td>'.$student->matric_no.'</td>
                          <td>'.$student->student->st_name.'</td>';

                            $attendance = json_decode($student->attendance_check);
                            if($attendance){
                              foreach($attendance as $attend){

                               if($attend == 1)
                               {
                                $check = 'checked';
                               }else{
                                $check ='';
                               }

                                echo'<td>
                                  <input type="checkbox" class ="checkbxAtt" name="cbkAttendance" value="1" '.$check.'/>
                                </td>
                
                ';
                              }
                            }

                          $i++;
                        }
            echo '<td>>80%</td></tr>';
                      }
                    }

                  echo'
          
          
               
              </table>';
              ?>
            </div>
            <?php /*  =$form->field($model, 'attendance_json',['options' => ['tag' => false]])->hiddenInput(['value' => ''])->label(false) */?>
              <div class="form-group">
                  <br/>
                  <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span>  Save', ['class' => 'btn btn-success']) ?>
              </div>

            <?php ActiveForm::end(); ?>
          </div>
        </div>


<?php
$js = "



function arrayChk(){ 
 
    var arrAn = [];  
  
    var m = $('.checkbxAtt'); 
 
    var arrLen = $('.checkbxAtt').length; 
      
    for ( var i= 0; i < arrLen ; i++){  
        var  w = m[i];                     
         if (w.checked == true){  
          arrAn.push( w.value );  
          console.log('Checkbox is checked.' ); 
        }
        if (w.checked == false){
          console.log('Checkbox is unchecked.' );
        }  
      }   
    
    var myJsonString = JSON.stringify(arrAn);  //convert javascript array to JSON string   

    $('#model-attendance_json').val(myJsonString);
   
   }


$('.checkbxAtt ').click(function(e, data){

  arrayChk();
 
   
});


";

$this->registerJs($js);


?>




