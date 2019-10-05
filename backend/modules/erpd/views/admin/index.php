<?php

use backend\modules\erpd\models\Stats;
use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */

$this->title = 'e-RPD';
$curr_year = date('Y') + 0;
$last_five = $curr_year - 4;


?>
<i>Electronic Research and Publication Data</i>


<section class="content">

<div class="box">
<div class="box-header">
<h3 class="box-title">Research and Publication for the last five years</h3>
</div>
<div class="box-body">


<?php

$pub = Stats::publicationLastFiveYears();
$res = Stats::researchLastFiveYears();



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
                'label' => "Research",
                'backgroundColor' => "#00c0ef",
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => $res_data
            ],
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
			
			
        ]
    ]
]);
?>


</div>
</div>


<div class="row">
<div class="col-md-6">

<div class="box">
<div class="box-header">
<h3 class="box-title"></h3>
</div>
<div class="box-body">

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th></th>
        <?php 
		$cols = '';
		for($i=$last_five;$i<=$curr_year;$i++){
			echo '<th>'.$i.'</th>';
			$cols .= '<td></td>';
		}
		
		?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Research</td>
        <?php 
		
		for($i=$last_five;$i<=$curr_year;$i++){
			echo '<th>'.Stats::countResearchByYear($i).'</th>';
		}
		
		?>
      </tr>
	  
	  <tr>
        <td>Publication</td>
        <?php 
		
		for($i=$last_five;$i<=$curr_year;$i++){
			echo '<th>'.Stats::countPublicationByYear($i).'</th>';
		}
		
		?>
      </tr>
	  
	  <tr>
        <td>Award</td>
        <?php 
		
		for($i=$last_five;$i<=$curr_year;$i++){
			echo '<th>'.Stats::countAwardByYear($i).'</th>';
		}
		
		?>
      </tr>
	  
	  <tr>
        <td>Membership</td>
        <?php 
		
		for($i=$last_five;$i<=$curr_year;$i++){
			echo '<th>'.Stats::countMembershipByYear($i).'</th>';
		}
		
		?>
      </tr>
	  
	  <tr>
        <td>Consultation</td>
        <?php 
		
		for($i=$last_five;$i<=$curr_year;$i++){
			echo '<th>'.Stats::countConsultationByYear($i).'</th>';
		}
		
		?>
      </tr>
      <tr>
        <td>Knowledge Transfer</td>
        <?php 
		
		for($i=$last_five;$i<=$curr_year;$i++){
			echo '<th>'.Stats::countKtpByYear($i).'</th>';
		}
		
		?>
      </tr>
    </tbody>
  </table>
</div>

</div>
</div>

</div>

<div class="col-md-6">

<div class="table-responsive">
  <div class="box">
<div class="box-header">
<h3 class="box-title"></h3>
</div>
<div class="box-body"><table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Publication</th>
		<?php 
		
        $cols = '';
		for($i=$last_five;$i<=$curr_year;$i++){
			echo '<th>'.$i.'</th>';
			$cols .= '<td></td>';
		}
		
		?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Journal Article</td>
        <?php
		for($i=$last_five;$i<=$curr_year;$i++){
			echo '<th>'.Stats::countPublicationByTypeYear(1, $i).'</th>';
		}
		
		?>
      </tr>
	  
	  <tr>
        <td>Book</td>
        <?php
		for($i=$last_five;$i<=$curr_year;$i++){
			echo '<th>'.Stats::countPublicationByTypeYear(2, $i).'</th>';
		}
		
		?>
      </tr>
	  
	  <tr>
        <td>Chapter in Book</td>
        <?php
		for($i=$last_five;$i<=$curr_year;$i++){
			echo '<th>'.Stats::countPublicationByTypeYear(3, $i).'</th>';
		}
		
		?>
      </tr>
	  
	  <tr>
        <td>Proceedings</td>
        <?php
		for($i=$last_five;$i<=$curr_year;$i++){
			echo '<th>'.Stats::countPublicationByTypeYear(4, $i).'</th>';
		}
		
		?>
      </tr>
	  
	  <tr>
        <td>Magazine</td>
        <?php
		for($i=$last_five;$i<=$curr_year;$i++){
			echo '<th>'.Stats::countPublicationByTypeYear(5, $i).'</th>';
		}
		
		?>
      </tr>
	  
	  <tr>
        <td>Newspaper</td>
       <?php
		for($i=$last_five;$i<=$curr_year;$i++){
			echo '<th>'.Stats::countPublicationByTypeYear(6, $i).'</th>';
		}
		
		?>
      </tr>
      
    </tbody>
  </table></div>
</div>
</div>
</div>

</div>



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
        <div class="col-md-3 col-sm-6 col-xs-6">
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
	  
  

        <div class="col-md-3 col-sm-6 col-xs-6">
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
		
		<div class="col-md-3 col-sm-6 col-xs-6">
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
		
		<div class="col-md-3 col-sm-6 col-xs-6">
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

