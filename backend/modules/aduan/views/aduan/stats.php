<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\modules\aduan\models\AduanProgress;
use yii\helpers\ArrayHelper;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\Aduan */

$this->title = 'Ringkasan';
$this->params['breadcrumbs'][] = ['label' => 'Aduan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


//print_r($model->dataStatus);

?>
<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
         <div class="small-box bg-default">
            <div class="inner">
              <h3><?=$model->countToday?></h3>

              <p>BILANGAN ADUAN HARI INI</p>
            </div>
            <div class="icon">
              <i class="fa fa-comments"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
           <div class="small-box bg-default">
            <div class="inner">
              <h3><?=$model->countThisMonth?></h3>

              <p>BILANGAN ADUAN BULAN INI</p>
            </div>
            <div class="icon">
              <i class="fa fa-comments"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-default">
            <div class="inner">
              <h3><?=$model->countThisYear?></h3>

              <p>BILANGAN ADUAN TAHUN INI</p>
            </div>
            <div class="icon">
              <i class="fa fa-comments"></i>
            </div>
            
          </div>
		  </div>
        <div class="col-lg-3 col-xs-6">
           <div class="small-box bg-default">
            <div class="inner">
              <h3><?=$model->countLastYear?></h3>

              <p>BILANGAN ADUAN TAHUN LEPAS</p>
            </div>
            <div class="icon">
              <i class="fa fa-comments"></i>
            </div>
            
          </div>
      </div>
	  
	  </div>
<h4>TAHUN <?=date('Y')?></h4>
<div class="row">
<div class="col-md-4">


<div>
<div >
<div >
Klasifikasi Aduan
</div>

</div>
<div >
<?php 

/* $result = StaffStats::staffByPositionStatus();
$status = ArrayHelper::map($result, 'id','staff_label');
$data = ArrayHelper::map($result, 'id','count_staff'); */
$status = $model->dataType[0];
$data = $model->dataType[1];

echo ChartJs::widget([
    'type' => 'pie',
    'id' => 'position_status',
    'options' => [
        'height' => 200,
        'width' => 400,
    ],
    'data' => [
        'radius' =>  "90%",
        'labels' => $status, // Your labels
        'datasets' => [
            [
                'data' => $data, // Your dataset
                'label' => '',
                'backgroundColor' => [
                        '#ADC3FF',
                        '#FF9A9A',
						'#76e8bf',
						'#e876c4',
						'#e4e876',
						'#76e8e2',
                ],
                'borderColor' =>  [
                        '#fff',
                        '#fff',
                        '#fff'
                ],
                'borderWidth' => 1,
                'hoverBorderColor'=>["#999","#999","#999"],                
            ]
        ]
    ],
    'clientOptions' => [
        'legend' => [
            'display' => true,
            'position' => 'bottom',
            'labels' => [
                'fontSize' => 10,
                'fontColor' => "#425062",
            ]
        ],
        'tooltips' => [
            'enabled' => true,
            'intersect' => true
        ],
        'hover' => [
            'mode' => false
        ],
        'maintainAspectRatio' => false,

    ],

])

?>
</div></div>


</div>
<div class="col-md-4"><div >
<div >
<div >
Status Aduan
</div>

</div>
<div>
<?php 

/* $result = StaffStats::staffByPositionStatus();
$status = ArrayHelper::map($result, 'id','staff_label');
$data = ArrayHelper::map($result, 'id','count_staff'); */
$status = $model->dataStatus[0];
$data = $model->dataStatus[1];

echo ChartJs::widget([
    'type' => 'pie',
    'id' => 'aduan_status',
    'options' => [
        'height' => 200,
        'width' => 400,
    ],
    'data' => [
        'radius' =>  "90%",
        'labels' => $status, // Your labels
        'datasets' => [
            [
                'data' => $data, // Your dataset
                'label' => '',
                'backgroundColor' => [
                        '#ADC3FF',
                        '#FF9A9A',
						'#76e8bf',
						'#e876c4',
						'#e4e876',
						'#76e8e2',
                ],
                'borderColor' =>  [
                        '#fff',
                        '#fff',
                        '#fff'
                ],
                'borderWidth' => 1,
                'hoverBorderColor'=>["#999","#999","#999"],                
            ]
        ]
    ],
    'clientOptions' => [
        'legend' => [
            'display' => true,
            'position' => 'bottom',
            'labels' => [
                'fontSize' => 10,
                'fontColor' => "#425062",
            ]
        ],
        'tooltips' => [
            'enabled' => true,
            'intersect' => true
        ],
        'hover' => [
            'mode' => false
        ],
        'maintainAspectRatio' => false,

    ],

])

?>
</div></div></div>
<div class="col-md-4">

<div >
<div >
<div >
Kategori Aduan
</div>

</div>
<div>
<?php 

/* $result = StaffStats::staffByPositionStatus();
$status = ArrayHelper::map($result, 'id','staff_label');
$data = ArrayHelper::map($result, 'id','count_staff'); */
$status = $model->dataTopic[0];
$data = $model->dataTopic[1];

echo ChartJs::widget([
    'type' => 'pie',
    'id' => 'jenis',
    'options' => [
        'height' => 200,
        'width' => 400,
    ],
    'data' => [
        'radius' =>  "90%",
        'labels' => $status, // Your labels
        'datasets' => [
            [
                'data' => $data, // Your dataset
                'label' => '',
                'backgroundColor' => [
                        '#ADC3FF',
                        '#FF9A9A',
						'#76e8bf',
						'#e876c4',
						'#e4e876',
						'#76e8e2',
                ],
                'borderColor' =>  [
                        '#fff',
                        '#fff',
                        '#fff'
                ],
                'borderWidth' => 1,
                'hoverBorderColor'=>["#999","#999","#999"],                
            ]
        ]
    ],
    'clientOptions' => [
        'legend' => [
            'display' => true,
            'position' => 'bottom',
            'labels' => [
                'fontSize' => 10,
                'fontColor' => "#425062",
            ]
        ],
        'tooltips' => [
            'enabled' => true,
            'intersect' => true
        ],
        'hover' => [
            'mode' => false
        ],
        'maintainAspectRatio' => false,

    ],

])

?>
</div></div>


</div>
</div>

