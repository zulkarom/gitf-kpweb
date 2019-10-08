<?php

use backend\modules\erpd\models\Stats;
use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\modules\erpd\models\Stats as Erpd;

/* @var $this yii\web\View */

$this->title = 'Dashboard';

?>
<div class="row">
<div class="col-md-12"><div class="form-group"><img src="images/umktag.png" width="100%" /></div></div>
</div>

<div class="box">
<div class="box-header">
<h3 class="box-title">Staff</h3>
</div>
<div class="box-body">



<div class="row">

<div class="col-md-2">
<img width="100%" src="<?=Url::to(['/staff/profile/image'])?>" />

</div>



<div class="col-md-5">

<div class="table-responsive">
  <table class="table table-striped table-hover">

    <tbody>
      <tr>
        <td><b>Staff Name</b></td>
        <td><?=$user->fullname?></td>
      </tr>
	  <tr>
        <td><b>Staff No.</b></td>
        <td><?=$user->staff->staff_no?></td>
      </tr>
      <tr>
        <td><b>Email</b></td>
        <td><?=$user->email?></td>
      </tr>
	  <tr>
        <td><b>Education (abbr.)</b></td>
        <td><?=$user->staff->staff_edu?></td>
      </tr>
	  

    </tbody>
  </table>
</div>
</div>

<div class="col-md-5">

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tbody>
	<tr>
	  
        <td><b>Type</b></td>
        <td><?=$user->staff->typeName?></td>
      </tr>
	<tr>
        <td><b>Position</b></td>
        <td><?=$user->staff->staffPosition->position_name?></td>
      </tr>
      
	  <tr>
        <td><b>Office Location</b></td>
        <td><?=$user->staff->ofis_location?></td>
      </tr>

    </tbody>
  </table>
</div>

<a href="<?=Url::to(['/staff/profile'])?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit Information</a>


</div>

</div>


</div>
</div>


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
                'backgroundColor' => "#00c0ef",
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
