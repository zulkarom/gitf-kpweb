<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $summary array */
/* @var $totalActiveAcademicStaff int */
/* @var $distinctHeadResearcherStaff int */
/* @var $overallPercentage float */
/* @var $byYear array */
/* @var $byCategory array */
/* @var $byType array */

$this->title = 'Grant Stats';
$this->params['breadcrumbs'][] = ['label' => 'Grants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$grantCount = isset($summary['grant_count']) ? (int) $summary['grant_count'] : 0;
$sumAmount = isset($summary['sum_amount']) ? (float) $summary['sum_amount'] : 0;
$extendedCount = isset($summary['extended_count']) ? (int) $summary['extended_count'] : 0;

$safeByYear = [];
foreach ($byYear as $r) {
    $safeByYear[] = [
        'year' => (int) ($r['year'] ?? 0),
        'distinct_staff' => (int) ($r['distinct_staff'] ?? 0),
        'total_staff' => (int) ($r['total_staff'] ?? 0),
        'percentage' => (float) ($r['percentage'] ?? 0),
    ];
}
?>

<div class="grant-stats">

    <p>
        <?= Html::a('Back to Grants', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <div class="box-header"><b>Total Grants</b></div>
                <div class="box-body">
                    <h3 style="margin:0"><?= $grantCount ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header"><b>Total Amount</b></div>
                <div class="box-body">
                    <h3 style="margin:0"><?= Yii::$app->formatter->asDecimal($sumAmount, 2) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header"><b>Extended Grants</b></div>
                <div class="box-body">
                    <h3 style="margin:0"><?= $extendedCount ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header"><b>Head Researcher Coverage (Internal Staff)</b></div>
                <div class="box-body">

            

                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Year</th>
                                            <th style="width:180px">Distinct Staff</th>
                                            <th style="width:180px">Total Staff</th>
                                            <th style="width:160px">Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($safeByYear as $row) { ?>
                                        <tr>
                                            <td><?= (int) $row['year'] ?></td>
                                            <td><?= (int) $row['distinct_staff'] ?></td>
                                            <td><?= (int) $row['total_staff'] ?></td>
                                            <td><?= Yii::$app->formatter->asDecimal((float) $row['percentage'], 2) ?>%</td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="grantCoverageByYearChart" style="height:260px;"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php
    $chartLabels = [];
    $chartValues = [];
    foreach ($safeByYear as $row) {
        $chartLabels[] = (string) $row['year'];
        $chartValues[] = round((float) $row['percentage'], 2);
    }

    $chartLabelsJson = json_encode($chartLabels);
    $chartValuesJson = json_encode($chartValues);

    $catLabels = [];
    $catCounts = [];
    foreach (($byCategory ?? []) as $r) {
        $catLabels[] = (string) ($r['category'] ?? 'N/A');
        $catCounts[] = (int) ($r['grant_count'] ?? 0);
    }
    $catLabelsJson = json_encode($catLabels);
    $catCountsJson = json_encode($catCounts);

    $this->registerJsFile('https://www.gstatic.com/charts/loader.js', ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJs(<<<JS
google.charts.load('current', {packages: ['corechart']});
google.charts.setOnLoadCallback(drawGrantCoverageByYear);
google.charts.setOnLoadCallback(drawGrantByCategoryPie);

function drawGrantCoverageByYear() {
    var labels = {$chartLabelsJson};
    var values = {$chartValuesJson};
    var rows = [['Year', 'Coverage (%)']];
    for (var i = 0; i < labels.length; i++) {
        rows.push([String(labels[i] || ''), Number(values[i] || 0)]);
    }

    var data = google.visualization.arrayToDataTable(rows);
    var options = {
        height: 260,
        legend: { position: 'none' },
        colors: ['#3c8dbc'],
        vAxis: { viewWindow: { min: 0, max: 100 }, format: '0\'%\'' },
        chartArea: {width: '80%', height: '70%'}
    };

    var el = document.getElementById('grantCoverageByYearChart');
    if (!el) { return; }
    var chart = new google.visualization.ColumnChart(el);
    chart.draw(data, options);
}

function drawGrantByCategoryPie() {
    var labels = {$catLabelsJson};
    var counts = {$catCountsJson};
    var rows = [['Category', 'Total']];
    for (var i = 0; i < labels.length; i++) {
        rows.push([labels[i] || 'N/A', Number(counts[i] || 0)]);
    }

    var data = google.visualization.arrayToDataTable(rows);

    var options = {
        is3D: true,
        height: 260,
        legend: {
            position: 'bottom',
            textStyle: {fontSize: 10, color: '#425062'}
        },
        chartArea: {width: '95%', height: '70%'}
    };

    var el = document.getElementById('grantByCategoryPie');
    if (!el) { return; }
    var chart = new google.visualization.PieChart(el);
    chart.draw(data, options);
}
JS, \yii\web\View::POS_END);
    ?>

    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header"><b>By Category</b></div>
                <div class="box-body">
                    <div id="grantByCategoryPie"></div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th style="width:120px">Count</th>
                                    <th style="width:180px">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($byCategory as $row) { ?>
                                <tr>
                                    <td><?= Html::encode($row['category']) ?></td>
                                    <td><?= (int) $row['grant_count'] ?></td>
                                    <td><?= Yii::$app->formatter->asDecimal((float) $row['sum_amount'], 2) ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-header"><b>By Type</b></div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th style="width:120px">Count</th>
                                    <th style="width:180px">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($byType as $row) { ?>
                                <tr>
                                    <td><?= Html::encode($row['type']) ?></td>
                                    <td><?= (int) $row['grant_count'] ?></td>
                                    <td><?= Yii::$app->formatter->asDecimal((float) $row['sum_amount'], 2) ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
