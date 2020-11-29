<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
    <div class="col-sm-12">
      <div class="box">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Coordinator</b></div>
          </div>
        </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Progress</th>
                    <th>Action</th>
                  </tr>
                
                     <?php 
                
                    if($model->coordinatorIdentity){
                    $i = 1;
                      foreach($model->coordinatorIdentity as $coor){
                        
                      echo '<tr><td>'.$i.'</td>
                            <td>'.$coor->course->course_code.'</td>
                            <td>'.$coor->course->course_name.'</td>
                            <td></td>
                            <td><a href="" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> View</a></td>';
                   
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

    <div class="row">
    <div class="col-sm-12">
      <div class="box">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Lectures</b></div>
          </div>
        </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Lecture Name</th>
                    <th>Progress</th>
                    <th>Action</th>
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
                            <td><a href="" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> View</a></td>';
                   
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

    <div class="row">
    <div class="col-sm-12">
      <div class="box">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Tutorials</b></div>
          </div>
        </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Tutorial Name</th>
                    <th>Progress</th>
                    <th>Action</th>
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
                            <td><a href="" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> View</a></td>';
                   
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
</div>

<?php ActiveForm::end(); ?>
