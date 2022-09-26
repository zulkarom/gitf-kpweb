<?php

use backend\modules\courseFiles\models\Stats;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\CourseOfferedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Files Summary';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
  .a-dash{
    color:darkblue;
  }
</style>
<?=$this->render('_form_semester', ['model' => $semester])?>


<?php 
$semester = $semester->semester_id;

?>

<div class="box box-solid">
<div class="box-header">
</div>
<div class="box-body">

<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <a href="<?=Url::to(['index'])?>" class="a-dash"><div class="small-box bg-default">
            <div class="inner">
              <h3><?=Stats::countTotalCourseFile($semester)?></h3>

              <p>TOTAL COURSE FILES</p>
            </div>
            <div class="icon">
              <i class="fa fa-folder"></i>
            </div>
            
          </div>
          </a>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <a href="<?=Url::to(['index', 'SemesterForm[status]' => 10, 'SemesterForm[semester_id]' => $semester])?>" class="a-dash"><div class="small-box bg-default">
            <div class="inner">
            <h3><?=Stats::countTotalCourseFileStatus($semester, 10)?></h3>

              <p>COURSE FILE SUBMITTED</p>
            </div>
            <div class="icon">
              <i class="fa fa-folder"></i>
            </div>
            
          </div></a>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
        <a href="<?=Url::to(['index', 'SemesterForm[status]' => 30, 'SemesterForm[semester_id]' => $semester])?>" class="a-dash"> <div class="small-box bg-default">
            <div class="inner">
            <h3><?=Stats::countTotalCourseFileStatus($semester, 30)?></h3>

              <p>COURSE FILES FULLFILLED</p>
            </div>
            <div class="icon">
              <i class="fa fa-folder"></i>
            </div>
            
          </div>
        </a>
		  </div>
        <div class="col-lg-3 col-xs-6">
        <a href="<?=Url::to(['index', 'SemesterForm[status]' => 50, 'SemesterForm[semester_id]' => $semester])?>" class="a-dash">  <div class="small-box bg-default">
            <div class="inner">
            <h3><?=Stats::countTotalCourseFileStatus($semester, 50)?></h3>

              <p>COURSE FILE VERIFIED</p>
            </div>
            <div class="icon">
              <i class="fa fa-folder"></i>
            </div>
            
          </div>
        </a>
      </div>
	  
	  </div>

    
    <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <a href="<?=Url::to(['index', 'SemesterForm[is_audited]' => 1, 'SemesterForm[semester_id]' => $semester])?>" class="a-dash"> 
          <div class="small-box bg-default">
            <div class="inner">
            <h3><?=Stats::countTotalCourseFileAudited($semester, 1)?></h3>

              <p>COURSE FILES AUDITED</p>
            </div>
            <div class="icon">
              <i class="fa fa-edit"></i>
            </div>
            
          </div>
          </a>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <a href="<?=Url::to(['index', 'SemesterForm[is_audited]' => 0, 'SemesterForm[semester_id]' => $semester])?>" class="a-dash"> 
           <div class="small-box bg-default">
            <div class="inner">
            <h3><?=Stats::countTotalCourseFileAudited($semester, 0)?></h3>

              <p>COURSE FILES NOT AUDITED</p>
            </div>
            <div class="icon">
              <i class="fa fa-edit"></i>
            </div>
            
          </div>
          </a>
        </div>
        <!-- ./col -->
        <a href="<?=Url::to(['course-info', 'SemesterForm[status]' => 10, 'SemesterForm[semester_id]' => $semester])?>" class="a-dash">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-default">
            <div class="inner">
            <h3><?=Stats::countTotalCourseInfo($semester, 10)?></h3>

              <p>COURSE INFO SUBMITTED</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            
          </div>
		  </div>
        </a>
        <div class="col-lg-3 col-xs-6">
        <a href="<?=Url::to(['course-info', 'SemesterForm[status]' => 20, 'SemesterForm[semester_id]' => $semester])?>" class="a-dash">
           <div class="small-box bg-default">
            <div class="inner">
            <h3><?=Stats::countTotalCourseInfo($semester, 20)?></h3>

              <p>COURSE INFO VERIFIED</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            
          </div>
        </a>
      </div>
	  
	  </div>

</div></div>

