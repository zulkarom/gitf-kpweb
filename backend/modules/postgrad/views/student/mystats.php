<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Semester;

/* @var $this yii\web\View */
/* @var $semester_id int|null */
/* @var $activeCount integer */
/* @var $studyMode array */
/* @var $programLevel array */
/* @var $years array */
/* @var $byCountryRows array */
/* @var $countries array */
/* @var $byFieldRows array */
/* @var $fields array */
/* @var $overallRc array */
/* @var $localCount integer */
/* @var $internationalCount integer */
/* @var $masterRc array */
/* @var $phdModes array */
/* @var $mainSupervisorCount integer */
/* @var $secondSupervisorCount integer */
/* @var $committeeStats array */

$this->title = 'Statistik Pelajar Di Bawah Seliaan Saya';
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="postgrad-stats">

    <?php
        $semesterOptions = ArrayHelper::map(
            Semester::find()->orderBy(['id' => SORT_DESC])->all(),
            'id',
            function($s){ return $s->longFormat(); }
        );
    ?>
    <div class="box box-default">
        <div class="box-body">
            <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['stats']]); ?>
            <div class="row">
                <div class="col-md-6">
                    <?= Html::label('Semester', 'semester_id', ['class' => 'control-label']) ?>
                    <?= Html::dropDownList('semester_id', $semester_id ?? null, $semesterOptions, ['class' => 'form-control', 'prompt' => 'Choose', 'id' => 'semester_id']) ?>
                </div>
                <div class="col-md-6" style="padding-top:25px">
                    <?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?php
        $studyModeLabels = ['Full-time', 'Part-time'];
        $studyModeCounts = [(int)($studyMode[1] ?? 0), (int)($studyMode[2] ?? 0)];
        $studyModeLabelsJson = json_encode($studyModeLabels);
        $studyModeCountsJson = json_encode($studyModeCounts);

        $programLevelLabels = ['Master', 'PhD'];
        $programLevelCounts = [(int)($programLevel['master'] ?? 0), (int)($programLevel['phd'] ?? 0)];
        $programLevelLabelsJson = json_encode($programLevelLabels);
        $programLevelCountsJson = json_encode($programLevelCounts);

        $this->registerJsFile('https://www.gstatic.com/charts/loader.js', ['position' => \yii\web\View::POS_HEAD]);
        $this->registerJs(<<<JS
google.charts.load('current', {packages: ['corechart']});
google.charts.setOnLoadCallback(drawMyStudyModePie);
google.charts.setOnLoadCallback(drawMyProgramLevelPie);

function drawMyStudyModePie() {
    var labels = {$studyModeLabelsJson};
    var counts = {$studyModeCountsJson};
    var rows = [['Mode', 'Total']];
    for (var i = 0; i < labels.length; i++) {
        rows.push([labels[i], counts[i] || 0]);
    }
    var data = google.visualization.arrayToDataTable(rows);
    var options = {
        height: 240,
        legend: { position: 'bottom' },
        chartArea: {width: '90%', height: '75%'}
    };
    var el = document.getElementById('myStudyModePie');
    if (!el) { return; }
    var chart = new google.visualization.PieChart(el);
    chart.draw(data, options);
}

function drawMyProgramLevelPie() {
    var labels = {$programLevelLabelsJson};
    var counts = {$programLevelCountsJson};
    var rows = [['Level', 'Total']];
    for (var i = 0; i < labels.length; i++) {
        rows.push([labels[i], counts[i] || 0]);
    }
    var data = google.visualization.arrayToDataTable(rows);
    var options = {
        height: 240,
        legend: { position: 'bottom' },
        chartArea: {width: '90%', height: '75%'}
    };
    var el = document.getElementById('myProgramLevelPie');
    if (!el) { return; }
    var chart = new google.visualization.PieChart(el);
    chart.draw(data, options);
}
JS, \yii\web\View::POS_END);
    ?>
    <div class="row">
        <div class="col-md-6">

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Supervision</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 35%;">Jumlah Pelajar Aktif</th>
                                    <td>Total: <?= (int)$activeCount ?> | Main Supervisor: <?= (int)($mainSupervisorCount ?? 0) ?> | Second Supervisor: <?= (int)($secondSupervisorCount ?? 0) ?></td>
                                </tr>
                                <tr>
                                    <th>Tempatan / Antarabangsa</th>
                                    <td>
                                        Local: <strong><?= (int)($localCount ?? 0) ?></strong>
                                        &nbsp;|
                                        International: <strong><?= (int)($internationalCount ?? 0) ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Pelajar Sarjana (Master)</th>
                                    <td>
                                        <?php $masterTotal = (int)($masterRc['research'] ?? 0) + (int)($masterRc['coursework'] ?? 0); ?>
                                        Jumlah: <strong><?= $masterTotal ?></strong>
                                        &nbsp;|
                                        Research: <strong><?= (int)($masterRc['research'] ?? 0) ?></strong>
                                        &nbsp;|
                                        Coursework: <strong><?= (int)($masterRc['coursework'] ?? 0) ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Pelajar PhD</th>
                                    <td>
                                        <?php $phdTotal = (int)($phdModes[1] ?? 0) + (int)($phdModes[2] ?? 0); ?>
                                        Jumlah: <strong><?= $phdTotal ?></strong>
                                        &nbsp;|
                                        Sepenuh Masa: <strong><?= (int)($phdModes[1] ?? 0) ?></strong>
                                        &nbsp;|
                                        Separuh Masa: <strong><?= (int)($phdModes[2] ?? 0) ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="box box-default">
                        <div class="box-header with-border"><h3 class="box-title">Study Mode</h3></div>
                        <div class="box-body">
                            <div id="myStudyModePie"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-default">
                        <div class="box-header with-border"><h3 class="box-title">Program Level</h3></div>
                        <div class="box-body">
                            <div id="myProgramLevelPie"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Examination Committee</h3>
                </div>
                <div class="box-body">
                    <?php
                        $traffic = (string)($committeeStats['total_color'] ?? 'red');
                        $circleColor = '#d9534f';
                        if ($traffic === 'green') {
                            $circleColor = '#5cb85c';
                        } elseif ($traffic === 'yellow') {
                            $circleColor = '#f0ad4e';
                        }
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Chairman</span>
                                    <span class="info-box-number"><?= (int)($committeeStats['chairman'] ?? 0) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">D. Chairman</span>
                                    <span class="info-box-number"><?= (int)($committeeStats['deputy'] ?? 0) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Examiner 1</span>
                                    <span class="info-box-number"><?= (int)($committeeStats['examiner1'] ?? 0) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Examiner 2</span>
                                    <span class="info-box-number"><?= (int)($committeeStats['examiner2'] ?? 0) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-gray"><i class="fa fa-circle" style="color:<?= Html::encode($circleColor) ?>;"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total</span>
                                    <span class="info-box-number"><?= (int)($committeeStats['total'] ?? 0) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Pecahan Pelajar Mengikut Negara</h3></div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Negara</th>
                                <th>Research</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sumResearch = 0; $sumCoursework = 0; $sumTotal = 0;
                        foreach ($byCountryRows as $r) {
                            $id = (int)($r['nationality'] ?? 0);
                            if (!$id) { continue; }
                            $name = isset($countries[$id]) ? $countries[$id]->country_name : ('ID ' . $id);
                            $research = isset($r['research_cnt']) ? (int)$r['research_cnt'] : 0;
                            $coursework = isset($r['coursework_cnt']) ? (int)$r['coursework_cnt'] : 0;
                            $total = isset($r['cnt']) ? (int)$r['cnt'] : ($research + $coursework);
                            $sumResearch += $research;
                            $sumCoursework += $coursework;
                            $sumTotal += $total;
                        ?>
                            <tr>
                                <td><?= Html::encode($name) ?></td>
                                <td><?= (string)$research ?></td>
                                <td><?= $total ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th>Grand Total</th>
                            <th><?= (int)$sumResearch ?></th>
                            <th><?= (int)$sumTotal ?></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Pecahan Pelajar Mengikut Bidang Pengajian</h3></div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Bidang Pengajian</th>
                                <th>Bilangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($byFieldRows as $r) {
                            $id = (int)($r['field_id'] ?? 0);
                            if (!$id) { continue; }
                            $name = isset($fields[$id]) ? $fields[$id]->field_name : ('ID ' . $id);
                        ?>
                            <tr>
                                <td><?= Html::encode($name) ?></td>
                                <td><?= (int)$r['cnt'] ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
