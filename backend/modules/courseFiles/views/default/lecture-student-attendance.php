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

<div class="form-group"><?= Html::a('Manage Class Date', ['/course-files/default/lecture-student-attendance-date', 'id' => $lecture->id], ['class' => 'btn btn-success']) ?></div>


<div class="box">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Student Attendance</b></div>
          </div>
        </div>
          <div class="box-body">
            <table class="table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Matric No.</th>
                    <th>Name</th>
                  </tr>
                  <?php
                    $i=1;
                    if($model->studentLecture){
                      foreach ($model->studentLecture as $student) {
                        if($student->lecture_id == $lecture->id){
                          echo'<tr><td>'.$i.'</td>
                          <td>'.$student->matric_no.'</td>
                          <td>'.$student->student->st_name.'</td>';
                          $i++;
                        }
                      }
                    }

                  echo'</tr>
                </thead>
              </table>';

              ?>
          </div>
        </div>
      </div>



