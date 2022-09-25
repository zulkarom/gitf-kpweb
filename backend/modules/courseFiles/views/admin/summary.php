<?php 
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\CourseOfferedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Files Summary';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
         <div class="small-box bg-default">
            <div class="inner">
              <h3>#</h3>

              <p>TOTAL COURSE FILES</p>
            </div>
            <div class="icon">
              <i class="fa fa-folder"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
           <div class="small-box bg-default">
            <div class="inner">
              <h3>#</h3>

              <p>COURSE FILE SUBMITTED</p>
            </div>
            <div class="icon">
              <i class="fa fa-folder"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-default">
            <div class="inner">
              <h3>#</h3>

              <p>COURSE FILES FULLFILLED</p>
            </div>
            <div class="icon">
              <i class="fa fa-folder"></i>
            </div>
            
          </div>
		  </div>
        <div class="col-lg-3 col-xs-6">
           <div class="small-box bg-default">
            <div class="inner">
              <h3>#</h3>

              <p>COURSE FILE VERIFIED</p>
            </div>
            <div class="icon">
              <i class="fa fa-folder"></i>
            </div>
            
          </div>
      </div>
	  
	  </div>

    
    <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
         <div class="small-box bg-default">
            <div class="inner">
              <h3>#</h3>

              <p>COURSE FILES AUDITED</p>
            </div>
            <div class="icon">
              <i class="fa fa-edit"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
           <div class="small-box bg-default">
            <div class="inner">
              <h3>#</h3>

              <p>COURSE FILES NOT AUDITED</p>
            </div>
            <div class="icon">
              <i class="fa fa-edit"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-default">
            <div class="inner">
              <h3>#</h3>

              <p>COURSE INFO SUBMITTED</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            
          </div>
		  </div>
        <div class="col-lg-3 col-xs-6">
           <div class="small-box bg-default">
            <div class="inner">
              <h3>#</h3>

              <p>COURSE INFO VERIFIED</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            
          </div>
      </div>
	  
	  </div>