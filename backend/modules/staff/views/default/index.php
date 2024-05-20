<?php 

use dosamigos\chartjs\ChartJs;
use backend\modules\staff\models\StaffStats;
use yii\helpers\ArrayHelper;

$this->title = 'Staff Summary';

?>


<div class="row">
<div class="col-md-8">


<div class="box">
<div class="box-header">

<div class="box-title">

Staff By Position
</div>
</div>
<div class="box-body"><?php 

$position_result = StaffStats::staffByPosition();
$position = ArrayHelper::map($position_result, 'id','position_name');
$position_data = ArrayHelper::map($position_result, 'id','count_staff');
$position = array_values($position);
$position_data = array_values($position_data);

echo ChartJs::widget([
    'type' => 'horizontalBar',
    'options' => [
       
        'width' => 300,
		'height' => 300
    ],
    'data' => [
        'labels' => $position,
        'datasets' => [
            [
                'label' => "Total Staff",
                'backgroundColor' => '#327fa8',
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => $position_data
            ],
        ]
    ]
]);
?></div>
</div>



</div>

<div class="col-md-4">



<div class="box">
<div class="box-header">
<div class="box-title">

Academic/Administrative
</div>

</div>
<div class="box-body"><?php 

$result = StaffStats::staffByType();
$data = ArrayHelper::map($result, 'is_academic','count_staff');
$data = array_values($data);
//print_r($data);

echo ChartJs::widget([
    'type' => 'pie',
    'id' => 'structurePie',
    'options' => [
        'height' => 200,
        'width' => 400,
    ],
    'data' => [
        'radius' =>  "90%",
        'labels' => ['Academic', 'Administrative'], // Your labels
        'datasets' => [
            [
                'data' => $data, // Your dataset
                'label' => '',
                'backgroundColor' => [
                        '#ADC3FF',
                        '#FF9A9A',
                    'rgba(190, 124, 145, 0.8)'
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
    'plugins' =>
        new \yii\web\JsExpression("
        [{
            afterDatasetsDraw: function(chart, easing) {
                var ctx = chart.ctx;
                chart.data.datasets.forEach(function (dataset, i) {
                    var meta = chart.getDatasetMeta(i);
                    if (!meta.hidden) {
                        meta.data.forEach(function(element, index) {
                            // Draw the text in black, with the specified font
                            ctx.fillStyle = 'rgb(0, 0, 0)';

                            var fontSize = 13;
                            var fontStyle = 'normal';
                            var fontFamily = 'Helvetica';
                            ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                            // Just naively convert to string for now
                            var dataString = dataset.data[index].toString();

                            // Make sure alignment settings are correct
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';

                            var padding = 5;
                            var position = element.tooltipPosition();
                            ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
                        });
                    }
                });
            }
        }]")
])

?></div>
</div>



<div class="box">
<div class="box-header">
<div class="box-title">

Position Status
</div>

</div>
<div class="box-body"><?php 

$result = StaffStats::staffByPositionStatus();
$status = ArrayHelper::map($result, 'id','staff_label');
$data = ArrayHelper::map($result, 'id','count_staff');
$status = array_values($status);
$data = array_values($data);

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

?></div>
</div>

</div>

</div>

