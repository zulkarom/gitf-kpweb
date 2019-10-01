<?php

use backend\modules\erpd\models\Stats;
use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */

$this->title = 'Dashboard';

?>
<section class="content">



<div class="box">
<div class="box-header">
<h3 class="box-title">My Research and Publication for the last five years</h3>
</div>
<div class="box-body">


<?php

$pub = Stats::myPublicationLastFiveYears();
$res = Stats::myResearchLastFiveYears();

$curr_year = date('Y') + 0;
$last_five = $curr_year - 4;

$year = []; $data = [];$res_data = [];
for($i=$last_five;$i<=$curr_year;$i++){
	//echo $i;
	$year[] = $i;
	$x = false;
	$y = false;
	foreach($pub as $row){
		if($row->pub_label == $i){
			$data[] = $row->pub_data;
			$x = true;
		}
	}
	foreach($res as $row){
		if($row->res_label == $i){
			$res_data[] = $row->res_data;
			$y = true;
		}
	}
	if(!$x){
		$data[] = 0;
	}
	if(!$y){
		$res_data[] = 0;
	}
}
//print_r($year);
array_push($year, '');
array_push($data, 0);
array_push($res_data, 0);

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
        'height' => 90
    ],
    'data' => [
        'labels' => $year,
		'yAxisID' => 0,
        'datasets' => [
            [
                'label' => "Publication",
                'backgroundColor' => '#00a65a',
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => $data
            ],
			
			[
                'label' => "Research",
                'backgroundColor' => "#00c0ef",
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => $res_data
            ],
        ]
    ]
]);
?>


</div>
</div>


<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?=Stats::countMyResearch()?></h3>

              <p>My Research</p>
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
              <h3><?=Stats::countMyPublication()?></h3>

              <p>My Publication</p>
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
              <h3><?=Stats::countMyMembership()?></h3>

              <p>My Membership</p>
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
              <h3><?=Stats::countMyAward()?></h3>

              <p>My Award</p>
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
              <span class="info-box-text">My Consultation</span>
              <span class="info-box-number"><?=Stats::countMyConsultation()?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
	  
  

        <div class="col-md-3 col-sm-6 col-xs-6">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-truck"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">My Knowledge <br />Transfer Program</span>
              <span class="info-box-number"><?=Stats::countMyKtp()?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		
		<div class="col-md-3 col-sm-6 col-xs-6">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-flask"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Completed <br />Research</span>
              <span class="info-box-number"><?=Stats::countMyCompletedResearch()?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		
		<div class="col-md-3 col-sm-6 col-xs-6">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-flask"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">On Going <br />Research</span>
              <span class="info-box-number"><?=Stats::countMyOnGoingResearch()?></span>
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

