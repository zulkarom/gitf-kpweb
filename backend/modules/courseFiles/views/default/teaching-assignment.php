<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Teaching Assignment';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('teaching-assignment-form', [
        'model' => $semester,
    ]) ?>
 

<div class="teaching-assignment">
<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-sm-6">
      <div class="box">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>My Teaching</b></div>
          </div>
        </div>
          <div class="box-body">
            <table class="table">
                <thead>
                  <tr>
                    <th style="width:5%">#</th>
                    <th style="width:69.3%">Appointment Letters</th>
                    <th style="width:12.7%"></th>
                  </tr>
                     <?php 
					 $boo = false;
					 if($myInv){
						 if($myInv->appointLetters){
						$boo = true;
						 $i = 1;
						 foreach($myInv->appointLetters as $app){
							$crs = $app->courseOffered->course;
							 echo '<tr>
						 <td>'.$i.'. </td>
                           <td>'.$crs->course_code .' '.$crs->course_name .'</td>
                           <td><a href="' . Url::to(['/teaching-load/appointment-letter/pdf', 'id' => $app->id]) . '" class="btn btn-default btn-sm" target="_blank"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
						</tr>';
						$i++;
						 }
					 }
					 }
					 
					 if(!$boo){
						 echo '
						 <tr>
						 <td></td>
                           <td>No Subjects</td>
                           <td></td>
						</tr>';
					 }
						 


                              ?>
                </thead>
              </table>
			  
			   <table class="table">
                <thead>
                  <tr>
                    <th style="width:5%">#</th>
                    <th style="width:69.3%">Timetable</th>
                    <th style="width:12.7%"></th>
                  </tr>
                     <?php 
						$items = $modelItem->itemPlan;
						 echo '
						 <tr>
						 <td>1. </td>
                           <td>Timetable for Individual Teaching Classes</td>
                           <td><a href="' . Url::to(['default/teaching-assignment-lecture-upload']) . '" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
						</tr>';
                              ?>
                </thead>
              </table>
              </table>
			  
          </div>
        </div>
		
		
		  <div class="box">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Coordinator</b></div>
          </div>
        </div>
          <div class="box-body">
            <table class="table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Progress</th>
                    <th></th>
                  </tr>
                
                     <?php 
                
                    if($model->coordinatorIdentity){
                    $i = 1;
                      foreach($model->coordinatorIdentity as $coor){
                        
                      echo '<tr><td>'.$i.'</td>
                            <td>'.$coor->course->course_code.'</td>
                            <td>'.$coor->course->course_name.'</td>
                            <td></td>
                            <td>
							
			
							
							<a href="' . Url::to(['default/teaching-assignment-coordinator', 'id' => $coor->id]) . '" class="btn btn-primary btn-sm" ><span class="glyphicon glyphicon-eye-open"></span> View</a></td>';
                                    
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
	  
	      <div class="col-sm-6">
		  
		  <div class="box">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Lectures</b></div>
          </div>
        </div>
          <div class="box-body">
            
              <table class="table">
                <thead>
                  <tr>
                    <th >No.</th>
                    <th >Course Code</th>
                    <th >Course Name</th>
                    <th >Lecture Name</th>
                    <th >Progress</th>
                    <th ></th>
                  </tr>
                
                     <?php 
                
                    if($model->teachLectureIdentity){
                    $i = 1;
                    foreach($model->teachLectureIdentity as $lecture){
                        
                      echo '<tr><td>'.$i.'</td>
                            <td>'.$lecture->courseLecture->courseOffered->course->course_code.'</td>
                            <td>'.$lecture->courseLecture->courseOffered->course->course_name.'</td>
                            <td>'.$lecture->courseLecture->lec_name.'</td>
                            <td></td>
                            <td><a href="' . Url::to(['default/teaching-assignment-lecture', 'id' => $lecture->lecture_id]) . '" class="btn btn-primary btn-sm" ><span class="glyphicon glyphicon-eye-open"></span> View</a></td>';
                   
                            $i++;
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
          <div class="a">
            <div class="box-title"><b>Tutorials</b></div>
          </div>
        </div>
          <div class="box-body">
              <table class="table">
                <thead>
                  <tr>
                     <th >No.</th>
                    <th >Course Code</th>
                    <th >Course Name</th>
                    <th >Lecture Name</th>
                    <th >Progress</th>
                    <th ></th>
                  </tr>
                
                     <?php 
                
                    if($model->teachTutorialIdentity){
                    $i = 1;
                      foreach($model->teachTutorialIdentity as $tutorial){
                        
                      echo '<tr><td>'.$i.'</td>
                            <td>'.$tutorial->tutorialLec->lecture->courseOffered->course->course_code.'</td>
                            <td>'.$tutorial->tutorialLec->lecture->courseOffered->course->course_name.'</td>
                            <td>'.$tutorial->tutorialLec->tutorial_name.'</td>
                            <td></td>
                            <td><a href="' . Url::to(['default/teaching-assignment-tutorial', 'id' => $tutorial->tutorial_id]) . '" class="btn btn-primary btn-sm" ><span class="glyphicon glyphicon-eye-open"></span> View</a></td>';
                   
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


    <div class="row">
    <div class="col-sm-6">
      
      </div>
	  
	      <div class="col-sm-6">
     
      </div>
    </div>
	
    </div>



<?php ActiveForm::end(); ?>
