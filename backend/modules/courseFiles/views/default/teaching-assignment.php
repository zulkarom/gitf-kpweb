<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Teaching Load';
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
            <div class="box-title"><b>List of Courses</b></div>
          </div>
        </div>
          <div class="box-body">
            <table class="table">
			 <thead>
			   <th>No.</th>
			   <th>Courses</th>
			   <th>Appointment Letter</th>
			   <th>Student Evaluation</th>
			   <th width="13%">Progress</th>
			   
			   </thead>
                     <?php 
					 if($myInv){
						 if($myInv->appointLetters){
						 $i = 1;
						 foreach($myInv->appointLetters as $app){
							$crs = $app->courseOffered->course;
							$offer = $app->courseOffered;
							$status = $offer->status;
							 echo '<tr>
						 <td>'.$i.'. </td>
                           <td>'.$crs->course_code .' '.$crs->course_name .'</td>
                           <td>';
						   if($app->status == 10){
							    echo '<a href="' . Url::to(['/teaching-load/appointment-letter/pdf', 'id' => $app->id]) . '" class="btn btn-default btn-sm" target="_blank"><span class="glyphicon glyphicon-download-alt"></span> Download</a>';
						   }else{
							   echo '<span style="font-weight:normal;font-style:italic">In progress...</span>';
						   }
						  
						   
						   echo '</td>
						   <td>';
						   
						   if($app->steva_file){
							   echo '<a href="'.  Url::to(['appointment/download-file', 'attr' => 'steva','id' => $app->id]) .' " class="btn btn-default btn-sm" target="_blank"><span class="fa fa-download" ></span></a> ';
							   if($status == 0){
								   echo '<a href="'.  Url::to(['default/student-evaluation', 'id' => $app->id]) .' " class="btn btn-default btn-sm" ><span class="fa fa-pencil"></span></a>';
							   }
							   
						   }else{
							   if($status == 0){
								   echo '<a href="'.  Url::to(['default/student-evaluation', 'id' => $app->id]) .' " class="btn btn-default btn-sm" ><span class="fa fa-upload"></span> Upload</a>';
							   }
							   
						   }
						   
						   
						   
						   
						   echo '</td>
						   <td>'.$app->progressAppointmentBar.'</td>
						</tr>';
						$i++;
						 }
					 }
					 }
					 
				
						 


                              ?>
                
              </table>
			  
		
			  
          </div>
        </div>
		
		<div class="box">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Timetable</b></div>
          </div>
        </div>
          <div class="box-body">
            
			  
			   <table class="table">
			   
			   <thead>
			   <th>No.</th>
			   <th>Item</th>
			   <th>Update</th>
			   <th width="13%">Progress</th>
			   
			   
			   </thead>
			   
			    <tr><td>1. </td>
              <td>Timetable for Individual Teaching Classes</td>
			  
              <td>
			  <?php 
			  
			  if($myInv->timetable_file){
			   echo '<a href="'.  Url::to(['staff/download-file', 'attr' => 'timetable','id' => $myInv->id]) .' " class="btn btn-default btn-sm" target="_blank"><span class="fa fa-download" ></span></a> ';
			   if($myInv->editable){
				    echo '<a href="'.  Url::to(['default/timetable']) .' " class="btn btn-default btn-sm" ><span class="fa fa-pencil"></span></a>';
			   }
			  
		   }else{
			   if($myInv->editable){
				   echo '<a href="'.  Url::to(['default/timetable']) .' " class="btn btn-default btn-sm" ><span class="fa fa-upload"></span> Upload</a>';
			   }
			   
		   }
						   
			  
			  
			  ?>
			  
			 </td>
			 <td><?=$myInv->progressTimetable?></td>
						</tr>
     
               
              </table>
			  
          </div>
        </div>
		
		<?php 
		if($model->coordinatorIdentity){
		?>
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
                    <th>Course</th>
                    <th>Status</th>
                    <th>Update</th>
					<th width="13%">Progress</th>
                  </tr>
                
                     <?php 
                
                    
                    $i = 1;
                      foreach($model->coordinatorIdentity as $coor){
                        
                      echo '<tr><td>'.$i.'</td>
                            <td>'.$coor->course->course_code.' '.$coor->course->course_name.'</td>
							<td>'. $coor->statusName .'</td>
                            <td>';
						if($coor->status == 0){
							echo '<a href="' . Url::to(['default/teaching-assignment-coordinator', 'id' => $coor->id]) . '" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon-pencil"></span> Update</a>';
						}else{
							echo '<a href="' . Url::to(['default/coordinator-view', 'id' => $coor->id]) . '" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon-search"></span> View</a>';
						}
						
						
						echo '</td>
							 <td>'.$coor->progressOverallBar .'</td>
							';
                                    
                            $i++;
                       }
                     
                          ?>
                  </tr>
                </thead>
              </table>
			  
			  
			  
          </div>
        </div>
		
		<?php 
		}
		
		?>
		
		
      </div>
	  
	      <div class="col-sm-6">
		  <?php 
		  if($model->teachLectureIdentity){
		  ?>
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
                    <th >Course</th>
					
                    <th >Lecture</th>
                    
                    <th >Update</th>
					<th width="13%">Progress</th>
                  </tr>
                
                     <?php 
                
                    
                    $i = 1;
                    foreach($model->teachLectureIdentity as $lecture){
                        $course = $lecture->courseLecture->courseOffered->course;
						$status = $lecture->courseLecture->courseOffered->status;
                      echo '<tr><td>'.$i.'</td>
                            <td>'.$course->course_code.' '.$course->course_name.'</td>
                    
                            <td>'.$lecture->courseLecture->lec_name.'</td>
                            
                            <td>';
					if($status == 0){
						echo '<a href="' . Url::to(['default/teaching-assignment-lecture', 'id' => $lecture->lecture_id]) . '" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon-pencil"></span> Update</a>';
					}else{
						echo '<i>--submitted--</i>';
					}	
					
					
					
						echo '</td>
							<td>'.$lecture->courseLecture->progressOverallBar .'</td>
							';
                   
                            $i++;
                      }
                    
                          ?>
                  </tr>
                </thead>
              </table>
          
          </div>
        </div>
		
		<?php 
		}
		  
		  
		  if($model->teachTutorialIdentity){
		?>
		
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
                    <th >Course</th>
                    <th>Tutorial</th>
					<th >Update</th>
					<th width="13%">Progress</th>
					
                    
                    
                  </tr>
                
                     <?php 
                
                    
                    $i = 1;
                      foreach($model->teachTutorialIdentity as $tutorial){
                        $course = $tutorial->tutorialLec->lecture->courseOffered->course;
						$status = $tutorial->tutorialLec->lecture->courseOffered->status;
						$lec = $tutorial->tutorialLec->lecture->lec_name;
                      echo '<tr><td>'.$i.'</td>
                            <td>'.$course->course_code.' '.$course->course_name.'</td>
             
                            <td>'.$lec . $tutorial->tutorialLec->tutorial_name.'</td>
                            
                            <td>';
					if($status==0){
						echo '<a href="' . Url::to(['default/teaching-assignment-tutorial', 'id' => $tutorial->tutorial_id]) . '" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon-pencil"></span> Update</a>';
					}else{
						echo '<i>--submitted--</i>';
					}	
					
					
					echo '</td>
							<td>'.$tutorial->tutorialLec->progressOverallBar .'</td>
							';
                   
                            $i++;
                      }
                   
                          ?>
                  </tr>
                </thead>
              </table>
            
          </div>
        </div>
		
		<?php 
		 }
		?>
    
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

