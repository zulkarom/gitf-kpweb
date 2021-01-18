<?php

use backend\modules\erpd\models\Stats;
use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\modules\erpd\models\Stats as Erpd;
$dirAsset = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
/* @var $this yii\web\View */

$this->title = 'Dashboard';

?>
<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>&nbsp;</h3>

              <h4>My Info</h4>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
      
            <a href="<?=Url::to(['/staff/profile'])?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>&nbsp;</h3>

              <h4>Staff Data</h4>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="<?=Url::to(['/staff'])?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>&nbsp;</h3>

              <h4>Teaching Loads</h4>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            <a href="<?=Url::to(['/teaching-load/course-offered/index'])?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>&nbsp;</h3>

              <h4>Course Files</h4>
            </div>
            <div class="icon">
              <i class="fa fa-files-o"></i>
            </div>
            <a href="<?=Url::to(['/course-files/default/teaching-assignment'])?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        </div>
        <!-- ./col -->

        <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">&nbsp;</span>
              <span class="info-box-number">Manage Courses</span>

              
                  <span class="progress-description">
                    <a href="<?=Url::to([''])?>" class="small-box-footer"><font color="white">More info </font><i class="fa fa-arrow-circle-right" style="color:white;"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-sticky-note"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">&nbsp;</span>
              <span class="info-box-number">Manage Program</span>

            
                  <span class="progress-description">
                    <a href="<?=Url::to([''])?>" class="small-box-footer"><font color="white">More info </font><i class="fa fa-arrow-circle-right" style="color:white;"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-graduation-cap"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">&nbsp;</span>
              <span class="info-box-number">Student Data</span>

              
                  <span class="progress-description">
                    <a href="<?=Url::to([''])?>" class="small-box-footer"><font color="white">More info </font><i class="fa fa-arrow-circle-right" style="color:white;"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-flask"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">&nbsp;</span>
              <span class="info-box-number">e-RPD</span>

                  <span class="progress-description">
                    <a href="<?=Url::to([''])?>" class="small-box-footer"><font color="white">More info </font><i class="fa fa-arrow-circle-right" style="color:white;"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>

      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-list-alt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">&nbsp;</span>
              <span class="info-box-number">JEB Journal</span>

              <span class="progress-description">
                    <a href="<?=Url::to([''])?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">&nbsp;</span>
              <span class="info-box-number">Website</span>

              <span class="progress-description">
                    <a href="<?=Url::to([''])?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-list"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">&nbsp;</span>
              <span class="info-box-number">eAduan</span>

              <span class="progress-description">
                    <a href="<?=Url::to([''])?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-download"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">&nbsp;</span>
              <span class="info-box-number">My Download</span>

              <span class="progress-description">
                    <a href="<?=Url::to([''])?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      

<?php if($user->staff->is_academic == 1) {?>
<div class="box">
<div class="box-header">
<h3 class="box-title">e-RPD</h3>
</div>
<div class="box-body">

<div class="row">
<div class="col-md-6">

<div class="table-responsive">
  <table class="table table-striped table-hover">
  <thead>
      <tr>
        <th>Item</th>
		<th>Processing</th>
        <th>Verified</th>

      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Research</td>
        <td><a href="<?=Url::to(['/erpd/research'])?>" class="btn btn-warning btn-sm"><?=Erpd::countMyUnverifiedResearch()?></a></td>
		<td><a href="<?=Url::to(['/erpd/research'])?>" class="btn btn-success btn-sm"><?=Erpd::countMyResearch()?></a></td>
      </tr>
	 <tr>
        <td>Publication</td>
        <td><a href="<?=Url::to(['/erpd/publication'])?>" class="btn btn-warning btn-sm"><?=Erpd::countMyUnverifiedPublication()?></a></td>
		<td><a href="<?=Url::to(['/erpd/publication'])?>" class="btn btn-success btn-sm"><?=Erpd::countMyPublication()?></a></td>
      </tr>
	  <tr>
        <td>Membership</td>
        <td><a href="<?=Url::to(['/erpd/membership'])?>" class="btn btn-warning btn-sm"><?=Erpd::countMyUnverifiedMembership()?></a></td>
		<td><a href="<?=Url::to(['/erpd/membership'])?>" class="btn btn-success btn-sm"><?=Erpd::countMyMembership()?></a></td>
      </tr>
	  <tr>
        <td>Award</td>
        <td><a href="<?=Url::to(['/erpd/award'])?>" class="btn btn-warning btn-sm"><?=Erpd::countMyUnverifiedAward()?></a></td>
		<td><a href="<?=Url::to(['/erpd/award'])?>" class="btn btn-success btn-sm"><?=Erpd::countMyAward()?></a></td>
      </tr>
	  <tr>
        <td>Consultation</td>
        <td><a href="<?=Url::to(['/erpd/consultation'])?>" class="btn btn-warning btn-sm"><?=Erpd::countMyUnverifiedConsultation()?></a></td>
		<td><a href="<?=Url::to(['/erpd/consultation'])?>" class="btn btn-success btn-sm"><?=Erpd::countMyConsultation()?></a></td>
      </tr>
    <tr>
        <td>Knowledge Transfer</td>
        <td><a href="<?=Url::to(['/erpd/knowledge-transfer'])?>" class="btn btn-warning btn-sm"><?=Erpd::countMyUnverifiedKtp()?></a></td>
		<td><a href="<?=Url::to(['/erpd/knowledge-transfer'])?>" class="btn btn-success btn-sm"><?=Erpd::countMyKtp()?></a></td>
      </tr>
    </tbody>
  </table>
</div>
</div>

<div class="col-md-6">

<?php
$items = ['Research', 'Publication', 'Membership', 'Award', 'Consultation', 'Knowledge Transfer'];

$processing = [
	Erpd::countMyUnverifiedResearch(),
	Erpd::countMyUnverifiedPublication(),
	Erpd::countMyUnverifiedMembership(),
	Erpd::countMyUnverifiedAward(),
	Erpd::countMyUnverifiedConsultation(),
	Erpd::countMyUnverifiedKtp()
];

$verified = [
	Erpd::countMyResearch(),
	Erpd::countMyPublication(),
	Erpd::countMyMembership(),
	Erpd::countMyAward(),
	Erpd::countMyConsultation(),
	Erpd::countMyKtp()
];

echo ChartJs::widget([
    'type' => 'bar',
    'options' => [
		'scales' => [
				'yAxes' => [
					[
						'ticks' => [
							'min' => 0
						]
					]
					
				]
			],
        'height' => 220
    ],
    'data' => [
        'labels' => $items,
		'yAxisID' => 0,
        'datasets' => [
		[
                'label' => "Processing",
                'backgroundColor' => "#f39c12",
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => $processing
            ],
            [
                'label' => "Verified",
                'backgroundColor' => '#00a65a',
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => $verified
            ],
			
			
        ]
    ]
]);
?>
</div>

</div>




</div>
</div>

<?php } ?>