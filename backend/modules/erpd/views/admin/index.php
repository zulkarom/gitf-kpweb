<?php

use backend\modules\erpd\models\Stats;
/* @var $this yii\web\View */

$this->title = 'e-RPD';

?>
<i>Electronic Research and Publication Data</i>


<section class="content">

<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?=Stats::countTotalResearch()?></h3>

              <p>Total Research</p>
            </div>
            <div class="icon">
              <i class="fa fa-flask"></i>
            </div>
			
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?=Stats::countTotalPublication()?></h3>

              <p>Total Publication</p>
            </div>
            <div class="icon">
              <i class="fa fa-send"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?=Stats::countTotalMembership()?></h3>

              <p>Total Membership</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?=Stats::countTotalAward()?></h3>

              <p>Total Award</p>
            </div>
            <div class="icon">
              <i class="fa fa-trophy"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>



      <!-- Info boxes -->
      <div class="row">
	  
	       <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-microphone"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Consultation</span>
              <span class="info-box-number"><?=Stats::countTotalConsultation()?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
	  
  

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-truck"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Knowledge <br />Transfer Program</span>
              <span class="info-box-number"><?=Stats::countTotalKtp()?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		
		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-flask"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Completed <br />Research</span>
              <span class="info-box-number"><?=Stats::countTotalCompletedResearch()?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		
		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-flask"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">On Going <br />Research</span>
              <span class="info-box-number"><?=Stats::countTotalOnGoingResearch()?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		
		
        <!-- /.col -->
      </div>
      <!-- /.row -->


      <!-- Main row -->
      
      <!-- /.row -->
    <div>
</div></section>

