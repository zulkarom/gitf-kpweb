<?php

use backend\modules\courseFiles\models\Stats;
use backend\modules\courseFiles\models\Common;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\CourseOfferedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Files Summary';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
  .a-dash{
    color:#3c8dbc;
  }
  .progress-dash{
    font-size: 16px;
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
    <div class="col-md-3">
<?php $v = $stats->progressSubmission();?>
    <div class="clearfix progress-dash">
      <span class="pull-left">SUBMISSION PROGRESS</span>
      <small class="pull-right"><?=($v*100)?>%</small>
    </div>
    <?=Common::progress($v)?>

    </div>

    <div class="col-md-3">
    <?php $v = $stats->progressAudit();?>
    <div class="clearfix progress-dash">
      <span class="pull-left" >AUDIT PROGRESS</span>
      <small class="pull-right"><?=($v*100)?>%</small>
    </div>
    <?=Common::progress($v)?>

    </div>

    <div class="col-md-3">
    <?php $v = $stats->progressCourseInfo();?>
    <div class="clearfix progress-dash">
      <span class="pull-left">COURSE INFO PROGRESS</span>
      <small class="pull-right"><?=($v*100)?>%</small>
    </div>
    <?=Common::progress($v)?>

    </div>

    <div class="col-md-3">
    <?php $v = $stats->progressCourseFileVerification();?>
    <div class="clearfix progress-dash">
      <span class="pull-left">VERIFICATION PROGRESS</span>
      <small class="pull-right"><?=($v*100)?>%</small>
    </div>
    <?=Common::progress($v)?>

    </div>
    
</div>




                
</div></div>






<div class="box box-solid">
<div class="box-header">
</div>
<div class="box-body">

<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <a href="<?=Url::to(['index'])?>" class="a-dash"><div class="small-box bg-default">
            <div class="inner">
              <h3><?=$stats->total?></h3>

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
        <a href="<?=Url::to(['index', 'SemesterForm[status]' => 0, 'SemesterForm[semester_id]' => $semester])?>" class="a-dash"> <div class="small-box bg-default">
            <div class="inner">
            <h3><?=$stats->countTotalCourseFileDraftOrReupdate()?></h3>

              <p>COURSE FILES DRAFTED/REUPDATE</p>
            </div>
            <div class="icon">
              <i class="fa fa-folder"></i>
            </div>
            
          </div>
        </a>
		  </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <a href="<?=Url::to(['index', 'SemesterForm[status]' => 10, 'SemesterForm[semester_id]' => $semester])?>" class="a-dash"><div class="small-box bg-default">
            <div class="inner">
            <h3><?=$stats->countTotalCourseFileSubmitted()?></h3>

              <p>COURSE FILE SUBMITTED</p>
            </div>
            <div class="icon">
              <i class="fa fa-folder"></i>
            </div>
            
          </div></a>
        </div>
        <!-- ./col -->
       
        <div class="col-lg-3 col-xs-6">
        <a href="<?=Url::to(['index', 'SemesterForm[status]' => 50, 'SemesterForm[semester_id]' => $semester])?>" class="a-dash">  <div class="small-box bg-default">
            <div class="inner">
            <h3><?=$stats->countTotalCourseFileStatus(50)?></h3>

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
            <h3><?=$stats->countTotalCourseFileAudited(1)?></h3>

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
            <h3><?=$stats->countTotalCourseFileAudited(0)?></h3>

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
            <h3><?=$stats->countTotalCourseInfo(10)?></h3>

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
            <h3><?=$stats->countTotalCourseInfo(20)?></h3>

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

