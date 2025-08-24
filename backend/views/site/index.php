<?php

use backend\modules\erpd\models\Stats;
use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\modules\erpd\models\Stats as Erpd;
$dirAsset = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
/* @var $this yii\web\View */

$this->title = 'Modules';

?>
<style>
  .dashboard-intro{margin:2px 0 12px;color:#7b7b7b}
  .module-grid .small-box{border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,.06);transition:transform .15s ease,box-shadow .15s ease}
  .module-grid .small-box .inner{min-height:120px}
  .module-grid .small-box .inner h3{font-size:20px;margin:0 0 8px;font-weight:600}
  .module-grid .small-box .inner p{margin:0;color:rgba(255,255,255,.95)}
  .module-grid .small-box .icon{top:10px;right:15px;opacity:.25}
  .module-grid .small-box .small-box-footer{background:transparent;color:#fff;text-decoration:none}
  .module-grid .small-box:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(0,0,0,.12)}
  @media (max-width: 767px){.module-grid .small-box .inner{min-height:100px}}
</style>

<div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">Active Modules</h3>
    <div class="dashboard-intro">Quick access to the key areas of the system</div>
  </div>
  <div class="box-body">
    <div class="row module-grid">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/staff']) ?>">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>Staff Information</h3>
              <p>Profiles, positions, departments and contacts.</p>
            </div>
            <div class="icon"><i class="fa fa-id-badge"></i></div>
            <span class="small-box-footer">Open <i class="fa fa-arrow-circle-right"></i></span>
          </div>
        </a>
      </div>
     
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/postgrad/student']) ?>">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>Postgraduate</h3>
              <p>Students, supervisors, progress tracking and stages.</p>
            </div>
            <div class="icon"><i class="fa fa-graduation-cap"></i></div>
            <span class="small-box-footer">Open <i class="fa fa-arrow-circle-right"></i></span>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/students/default']) ?>">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>Students</h3>
              <p>View and manage undergraduate student data.</p>
            </div>
            <div class="icon"><i class="fa fa-users"></i></div>
            <span class="small-box-footer">Open <i class="fa fa-arrow-circle-right"></i></span>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/esiap']) ?>">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>Course Management</h3>
              <p>Create and update courses, CLOs and mappings.</p>
            </div>
            <div class="icon"><i class="fa fa-mortar-board"></i></div>
            <span class="small-box-footer">Open <i class="fa fa-arrow-circle-right"></i></span>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>

<style>
  /* Distinct style for Additional Modules */
  .module-cards .module-card{background:#fff;border-radius:10px;border:1px solid #e7e9ee;box-shadow:0 2px 6px rgba(0,0,0,.05);transition:transform .15s ease,box-shadow .15s ease;position:relative;overflow:hidden}
  .module-cards .module-card .bar{height:4px;width:100%;position:absolute;top:0;left:0}
  .module-cards .module-card .inner{padding:18px 16px 18px 16px;min-height:110px}
  .module-cards .module-card h4{margin:0 0 6px;font-size:18px;font-weight:700;color:#1d2430}
  .module-cards .module-card p{margin:0;color:#5a6577}
  .module-cards .module-card .icon{position:absolute;right:14px;bottom:12px;color:#b9c2d0;font-size:28px;opacity:.6}
  .module-cards .module-card .footer{display:block;padding:10px 16px;border-top:1px solid #eef1f5;color:#274c77;background:#f9fbfd;font-weight:600;text-decoration:none}
  .module-cards .module-card:hover{transform:translateY(-2px);box-shadow:0 10px 20px rgba(0,0,0,.10)}
  .theme-purple .bar{background:#7e57c2}
  .theme-orange .bar{background:#fb8c00}
  .theme-teal .bar{background:#26a69a}
  .theme-blue .bar{background:#1e88e5}
</style>

<div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">Additional Modules</h3>
    <div class="dashboard-intro">Quick access to additional key areas of the system</div>
  </div>
  <div class="box-body">
    <div class="row module-cards">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/conference/conference/index']) ?>">
          <div class="module-card theme-purple">
            <span class="bar"></span>
            <div class="inner">
              <h4>Conference</h4>
              <p>Manage conferences and schedules.</p>
              <i class="fa fa-microphone icon"></i>
            </div>
            <span class="footer">Open <i class="fa fa-arrow-circle-right"></i></span>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/sae']) ?>">
          <div class="module-card theme-orange">
            <span class="bar"></span>
            <div class="inner">
              <h4>SAE Interview</h4>
              <p>Interview setup, sessions and results.</p>
              <i class="fa fa-video-camera icon"></i>
            </div>
            <span class="footer">Open <i class="fa fa-arrow-circle-right"></i></span>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/protege/session']) ?>">
          <div class="module-card theme-blue">
            <span class="bar"></span>
            <div class="inner">
              <h4>Protege</h4>
              <p>Programs, sessions and participants.</p>
              <i class="fa fa-user-plus icon"></i>
            </div>
            <span class="footer">Open <i class="fa fa-arrow-circle-right"></i></span>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/proceedings']) ?>">
          <div class="module-card theme-teal">
            <span class="bar"></span>
            <div class="inner">
              <h4>Proceedings</h4>
              <p>Proceedings management and publishing.</p>
              <i class="fa fa-book icon"></i>
            </div>
            <span class="footer">Open <i class="fa fa-arrow-circle-right"></i></span>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>




      

<?php /* if($user->staff->is_academic == 1) {?>
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

<?php } */ ?>