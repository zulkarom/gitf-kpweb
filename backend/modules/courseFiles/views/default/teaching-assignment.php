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
 

 <style>
#course {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#course td, #course th {
  border: 1px solid #ddd;
  padding: 8px;
}

#course tr:nth-child(even){background-color: #f2f2f2;}

#course tr:hover {background-color: #ddd;}

#course th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
}
</style>

<div class="teaching-assignment">
<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Staff Upload</b></div>
          </div>
        </div>
          <div class="box-body">
            <table id="course">
                <thead>
                  <tr>
                    <th style="width:5%">No.</th>
                    <th style="width:69.3%">Item Name</th>
                    <th style="width:13%">Progress</th>
                    <th style="width:12.7%">Action</th>
                  </tr>
                
                     <?php 
    
                       if($modelItem->itemStaff){
                        $i = 1;
                          foreach($modelItem->itemStaff as $item){
                          echo '<tr><td>'.$i.'</td>
                                <td>'.$item->item.'<i><br/>'.$item->item_bi.'</i></td>
                                <td></td>
                                <td><a href="' . Url::to(['default/teaching-assignment-course-file-upload']) . '" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> Upload</a></td>';
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
    <div class="col-sm-12">
      <div class="box box-success">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Coordinator</b></div>
          </div>
        </div>
          <div class="box-body">
            <table id="course">
                <thead>
                  <tr>
                    <th style="width:5%">No.</th>
                    <th style="width:15%">Course Code</th>
                    <th style="width:54.3%">Course Name</th>
                    <th style="width:13%">Progress</th>
                    <th style="width:12.7%">Action</th>
                  </tr>
                
                     <?php 
                
                    if($model->coordinatorIdentity){
                    $i = 1;
                      foreach($model->coordinatorIdentity as $coor){
                        
                      echo '<tr><td>'.$i.'</td>
                            <td>'.$coor->course->course_code.'</td>
                            <td>'.$coor->course->course_name.'</td>
                            <td></td>
                            <td><a href="' . Url::to(['default/teaching-assignment-coordinator', 'id' => $coor->coordinator]) . '" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> View</a></td>';
                                    
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
    <div class="col-sm-12">
      <div class="box box-info">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Lectures</b></div>
          </div>
        </div>
          <div class="box-body">
            
              <table id="course">
                <thead>
                  <tr>
                    <th style="width:5%">No.</th>
                    <th style="width:15%">Course Code</th>
                    <th style="width:27.15%">Course Name</th>
                    <th style="width:27.15%">Lecture Name</th>
                    <th style="width:13%">Progress</th>
                    <th style="width:12.7%">Action</th>
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
                            <td><a href="' . Url::to(['default/teaching-assignment-lecture', 'id' => $lecture->lecture_id]) . '" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> View</a></td>';
                   
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
    <div class="col-sm-12">
      <div class="box box-danger">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Tutorials</b></div>
          </div>
        </div>
          <div class="box-body">
              <table id="course">
                <thead>
                  <tr>
                    <th style="width:5%">No.</th>
                    <th style="width:15%">Course Code</th>
                    <th style="width:27.15%">Course Name</th>
                    <th style="width:27.15%">Tutorial Name</th>
                    <th style="width:13%">Progress</th>
                    <th style="width:12.7%">Action</th>
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
                            <td><a href="' . Url::to(['default/teaching-assignment-course-file', 'id' => $tutorial->staff_id]) . '" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> View</a></td>';
                   
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
