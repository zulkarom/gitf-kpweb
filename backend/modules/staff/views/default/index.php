<?php 

use dosamigos\chartjs\ChartJs;
use backend\modules\staff\models\StaffStats;
use backend\modules\staff\models\Staff;
use backend\modules\staff\models\StaffWorkingStatus;
use backend\models\Faculty;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Staff Summary';

?>


<?php
    $totalActive = (int)Staff::find()->where(['staff_active' => 1])->count();
    $totalInactive = (int)Staff::find()->where(['staff_active' => 0])->count();
    $totalFkp = (int)Staff::find()->where(['staff_active' => 1, 'faculty_id' => 1])->count();
    $totalOtherFaculty = (int)Staff::find()->where(['staff_active' => 1])->andWhere(['<>', 'faculty_id', 1])->count();
    $totalInternational = (int)Staff::find()
        ->where(['staff_active' => 1])
        ->andWhere(['<>', 'nationality', 'MY'])
        ->andWhere(['<>', 'nationality', ''])
        ->count();

    $byFaculty = (new \yii\db\Query())
        ->select([
            'f.id AS faculty_id',
            'f.faculty_name AS faculty_name',
            'COUNT(s.id) AS total'
        ])
        ->from(['s' => Staff::tableName()])
        ->leftJoin(['f' => Faculty::tableName()], 'f.id = s.faculty_id')
        ->where(['s.staff_active' => 1])
        ->groupBy(['f.id', 'f.faculty_name'])
        ->orderBy(['total' => SORT_DESC])
        ->all();

    $byWorkStatus = (new \yii\db\Query())
        ->select([
            'w.id AS work_id',
            'w.work_name AS work_name',
            'COUNT(s.id) AS total'
        ])
        ->from(['s' => Staff::tableName()])
        ->leftJoin(['w' => StaffWorkingStatus::tableName()], 'w.id = s.working_status')
        ->where(['s.staff_active' => 1])
        ->groupBy(['w.id', 'w.work_name'])
        ->orderBy(['total' => SORT_DESC])
        ->all();
?>


<div class="row" style="margin-bottom:15px;">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?= $totalFkp ?></h3>
                <p>FKP Staff (Active)</p>
            </div>
            <div class="icon"><i class="fa fa-users"></i></div>
            <a href="<?= Yii::$app->urlManager->createUrl(['/staff/staff/index']) ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?= $totalInternational ?></h3>
                <p>International Staff (Active)</p>
            </div>
            <div class="icon"><i class="fa fa-globe"></i></div>
            <a href="<?= Yii::$app->urlManager->createUrl(['/staff/staff/index']) ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?= $totalOtherFaculty ?></h3>
                <p>Other Faculty (Active)</p>
            </div>
            <div class="icon"><i class="fa fa-exchange"></i></div>
            <a href="<?= Yii::$app->urlManager->createUrl(['/staff/staff/external']) ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?= $totalInactive ?></h3>
                <p>Transfered/Quit</p>
            </div>
            <div class="icon"><i class="fa fa-user-times"></i></div>
            <a href="<?= Yii::$app->urlManager->createUrl(['/staff/staff/inactive']) ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>


<div class="row">
<div class="col-md-6">
<div class="box">
<div class="box-header">
<div class="box-title">
Working Status (Active)
</div>
</div>
<div class="box-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Status</th>
                    <th style="width:120px; text-align:right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($byWorkStatus as $row) : ?>
                    <tr>
                        <td>
                            <?php if (isset($row['work_id']) && $row['work_id'] !== null) : ?>
                                <?= Html::a(
                                    Html::encode($row['work_name'] ?: '(Not Set)'),
                                    ['/staff/staff/index', 'StaffSearch' => ['working_status' => (int)$row['work_id'], 'staff_active' => 1]]
                                ) ?>
                            <?php else : ?>
                                <?= Html::encode($row['work_name'] ?: '(Not Set)') ?>
                            <?php endif; ?>
                        </td>
                        <td style="text-align:right;"><span class="label label-primary"><?= (int)$row['total'] ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>



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

$academicCount = (int)($data[0] ?? 0);
$adminCount = (int)($data[1] ?? 0);

$this->registerJsFile('https://www.gstatic.com/charts/loader.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJs(<<<JS
google.charts.load('current', {packages: ['corechart']});
google.charts.setOnLoadCallback(drawStructurePie);

function drawStructurePie() {
    var data = google.visualization.arrayToDataTable([
        ['Type', 'Total'],
        ['Academic', {$academicCount}],
        ['Administrative', {$adminCount}]
    ]);

    var options = {
        is3D: true,
        height: 200,
        width: 400,
        colors: ['#ADC3FF', '#FF9A9A'],
        legend: {
            position: 'bottom',
            textStyle: {fontSize: 10, color: '#425062'}
        },
        chartArea: {width: '90%', height: '80%'}
    };

    var chart = new google.visualization.PieChart(document.getElementById('structurePie'));
    chart.draw(data, options);
}
JS, \yii\web\View::POS_END);

?>

<div id="structurePie"></div>

</div>
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

$statusLabelsJson = json_encode($status);
$statusCountsJson = json_encode(array_map('intval', $data));

$this->registerJs(<<<JS
google.charts.setOnLoadCallback(drawPositionStatusPie);

function drawPositionStatusPie() {
    var labels = {$statusLabelsJson};
    var counts = {$statusCountsJson};
    var rows = [['Status', 'Total']];
    for (var i = 0; i < labels.length; i++) {
        rows.push([labels[i], counts[i] || 0]);
    }

    var data = google.visualization.arrayToDataTable(rows);

    var options = {
        is3D: true,
        height: 200,
        width: 400,
        colors: ['#ADC3FF', '#FF9A9A', '#76e8bf', '#e876c4', '#e4e876', '#76e8e2'],
        legend: {
            position: 'bottom',
            textStyle: {fontSize: 10, color: '#425062'}
        },
        chartArea: {width: '90%', height: '80%'}
    };

    var chart = new google.visualization.PieChart(document.getElementById('positionStatusPie'));
    chart.draw(data, options);
}
JS, \yii\web\View::POS_END);

?>

<div id="positionStatusPie"></div>

</div>
</div>


</div>

<div class="col-md-6">
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
       
		'width' => 260,
		'height' => 220
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


</div>



<div class="row">
<div class="col-md-6">






</div>

<div class="col-md-8">

<div class="box">
<div class="box-header">
<div class="box-title">
Staff By Faculty (Active)
</div>
</div>
<div class="box-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Faculty</th>
                    <th style="width:120px; text-align:right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($byFaculty as $row) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= Html::encode($row['faculty_name'] ?: '(No Faculty)') ?></td>
                        <td style="text-align:right;"><span class="label label-primary"><?= (int)$row['total'] ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>

</div>

<div class="col-md-4">



</div>

<div class="col-md-4">





</div>

</div>

