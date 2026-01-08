<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\Semester;
use yii\helpers\ArrayHelper;
use backend\modules\postgrad\models\StudentRegister;
use backend\modules\postgrad\models\PgSetting;

/* @var $this yii\web\View */
/* @var $activeCount integer */
/* @var $studyMode array */
/* @var $programLevel array */
/* @var $years array */
/* @var $byCountryRows array */
/* @var $countries array */
/* @var $byFieldRows array */
/* @var $fields array */

$this->title = 'Sistem Pemantauan Akademik Pascasiswazah (Research)';
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
        $statusDaftarLabels = [];
        $statusDaftarCounts = [];
        $statusDaftarColors = [];
        foreach (($statusDaftarRows ?? []) as $r) {
            $code = array_key_exists('status_daftar', $r) ? $r['status_daftar'] : null;
            $cnt = isset($r['cnt']) ? (int)$r['cnt'] : 0;
            $val = ($code === null || $code === '') ? null : (int)$code;
            $statusDaftarLabels[] = StudentRegister::statusDaftarText($val);
            $statusDaftarCounts[] = $cnt;
            $statusDaftarColors[] = StudentRegister::statusDaftarChartColor($val);
        }

        $statusAktifLabels = [];
        $statusAktifCounts = [];
        $statusAktifColors = [];
        foreach (($statusAktifRows ?? []) as $r) {
            $code = array_key_exists('status_aktif', $r) ? $r['status_aktif'] : null;
            $cnt = isset($r['cnt']) ? (int)$r['cnt'] : 0;
            $val = ($code === null || $code === '') ? null : (int)$code;
            $statusAktifLabels[] = StudentRegister::statusAktifText($val);
            $statusAktifCounts[] = $cnt;
            $statusAktifColors[] = StudentRegister::statusAktifChartColor($val);
        }

        $statusDaftarLabelsJson = json_encode($statusDaftarLabels);
        $statusDaftarCountsJson = json_encode(array_map('intval', $statusDaftarCounts));
        $statusDaftarColorsJson = json_encode($statusDaftarColors);
        $statusAktifLabelsJson = json_encode($statusAktifLabels);
        $statusAktifCountsJson = json_encode(array_map('intval', $statusAktifCounts));
        $statusAktifColorsJson = json_encode($statusAktifColors);

        $this->registerJsFile('https://www.gstatic.com/charts/loader.js', ['position' => \yii\web\View::POS_HEAD]);
        $this->registerJs(<<<JS
google.charts.load('current', {packages: ['corechart']});
google.charts.setOnLoadCallback(drawStudentStatusDaftarPie);
google.charts.setOnLoadCallback(drawStudentStatusAktifPie);

function drawStudentStatusDaftarPie() {
    var labels = {$statusDaftarLabelsJson};
    var counts = {$statusDaftarCountsJson};
    var colors = {$statusDaftarColorsJson};
    var rows = [['Status', 'Total']];
    for (var i = 0; i < labels.length; i++) {
        rows.push([labels[i] || 'N/A', counts[i] || 0]);
    }

    var data = google.visualization.arrayToDataTable(rows);

    var slices = {};
    for (var j = 0; j < rows.length - 1; j++) {
        slices[j] = {offset: 0.06};
    }

    var options = {
        is3D: true,
        height: 200,
        width: 400,
        colors: colors,
        slices: slices,
        legend: {
            position: 'bottom',
            textStyle: {fontSize: 10, color: '#425062'}
        },
        chartArea: {width: '90%', height: '80%'}
    };

    var el = document.getElementById('studentStatusDaftarPie');
    if (!el) { return; }
    var chart = new google.visualization.PieChart(el);
    chart.draw(data, options);
}

function drawStudentStatusAktifPie() {
    var labels = {$statusAktifLabelsJson};
    var counts = {$statusAktifCountsJson};
    var colors = {$statusAktifColorsJson};
    var rows = [['Status', 'Total']];
    for (var i = 0; i < labels.length; i++) {
        rows.push([labels[i] || 'N/A', counts[i] || 0]);
    }

    var data = google.visualization.arrayToDataTable(rows);

    var slices = {};
    for (var j = 0; j < rows.length - 1; j++) {
        slices[j] = {offset: 0.06};
    }

    var options = {
        is3D: true,
        height: 200,
        width: 400,
        colors: colors,
        slices: slices,
        legend: {
            position: 'bottom',
            textStyle: {fontSize: 10, color: '#425062'}
        },
        chartArea: {width: '90%', height: '80%'}
    };

    var el = document.getElementById('studentStatusAktifPie');
    if (!el) { return; }
    var chart = new google.visualization.PieChart(el);
    chart.draw(data, options);
}
JS, \yii\web\View::POS_END);
    ?>

    

    <div class="row">
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Pecahan Pelajar Mengikut Status Daftar</h3></div>
                <div class="box-body">
                    <div id="studentStatusDaftarPie"></div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Status Daftar</th>
                                <th style="width:120px;">Bilangan</th>
                                <th style="width:120px;">Peratus (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $rows = isset($statusDaftarRows) ? $statusDaftarRows : [];
                        $sum = 0;
                        foreach ($rows as $r) {
                            $sum += isset($r['cnt']) ? (int)$r['cnt'] : 0;
                        }

                        foreach ($rows as $r) {
                            $code = array_key_exists('status_daftar', $r) ? $r['status_daftar'] : null;
                            $cnt = isset($r['cnt']) ? (int)$r['cnt'] : 0;
                            $val = ($code === null || $code === '') ? null : (int)$code;
                            $pct = $sum > 0 ? round(($cnt / $sum) * 100, 1) : 0;
                        ?>
                            <tr>
                                <td><?= StudentRegister::statusDaftarOutlineLabel($val) ?></td>
                                <td><?= Html::a((string)$cnt, ['index', 'semester_id' => $semester_id ?? null, 'StudentPostGradSearch[study_mode_rc]' => 'research', 'StudentPostGradSearch[status_daftar]' => $val]) ?></td>
                                <td><?= Html::encode(number_format($pct, 1)) ?></td>
                            </tr>
                        <?php } ?>
                            <tr>
                                <th>Grand Total</th>
                                <th><?= (int)$sum ?></th>
                                <th><?= $sum > 0 ? '100.0' : '0.0' ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Pecahan Pelajar Mengikut Status Aktif</h3></div>
                <div class="box-body">
                    <div id="studentStatusAktifPie"></div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Status Aktif</th>
                                <th style="width:120px;">Bilangan</th>
                                <th style="width:120px;">Peratus (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $rows2 = isset($statusAktifRows) ? $statusAktifRows : [];
                        $sum2 = 0;
                        foreach ($rows2 as $r) {
                            $sum2 += isset($r['cnt']) ? (int)$r['cnt'] : 0;
                        }

                        foreach ($rows2 as $r) {
                            $code2 = array_key_exists('status_aktif', $r) ? $r['status_aktif'] : null;
                            $cnt2 = isset($r['cnt']) ? (int)$r['cnt'] : 0;
                            $val2 = ($code2 === null || $code2 === '') ? null : (int)$code2;
                            $pct2 = $sum2 > 0 ? round(($cnt2 / $sum2) * 100, 1) : 0;
                        ?>
                            <tr>
                                <td><?= StudentRegister::statusAktifLabel($val2) ?></td>
                                <td><?= Html::a((string)$cnt2, ['index', 'semester_id' => $semester_id ?? null, 'StudentPostGradSearch[study_mode_rc]' => 'research', 'StudentPostGradSearch[status_aktif]' => $val2]) ?></td>
                                <td><?= Html::encode(number_format($pct2, 1)) ?></td>
                            </tr>
                        <?php } ?>
                            <tr>
                                <th>Grand Total</th>
                                <th><?= (int)$sum2 ?></th>
                                <th><?= $sum2 > 0 ? '100.0' : '0.0' ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-8">

        <div class="row">

        <style>
    .kpi-row { display:flex; gap:14px; align-items:stretch; flex-wrap:nowrap; }
    .kpi-card { flex: 1 1 0; background:#fff; border:1px solid #e5e7eb; border-radius:10px; padding:16px 18px; box-shadow:0 1px 2px rgba(0,0,0,.06); display:flex; align-items:center; justify-content:space-between; min-height:84px; }
    .kpi-card .kpi-text { line-height:1.1; }
    .kpi-card .kpi-title { margin:0; font-size:13px; color:#6b7280; font-weight:600; letter-spacing:.3px; }
    .kpi-card .kpi-value { margin:6px 0 0; font-size:28px; color:#111827; font-weight:700; }
    .kpi-icon { width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; position:relative; background:#e5e7eb; }
    .kpi-narrow.kpi-red .kpi-icon > span,
    .kpi-narrow.kpi-yellow .kpi-icon > span,
    .kpi-narrow.kpi-green  .kpi-icon > span { display:none; }
    .kpi-narrow.kpi-red .kpi-icon::after,
    .kpi-narrow.kpi-yellow .kpi-icon::after,
    .kpi-narrow.kpi-green  .kpi-icon::after { content:""; width:18px; height:18px; border-radius:50%; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); }
    .kpi-narrow.kpi-red .kpi-icon::after { background:#d9534f; }
    .kpi-narrow.kpi-yellow .kpi-icon::after { background:#f0ad4e; }
    .kpi-narrow.kpi-green .kpi-icon::after { background:#5cb85c; }
    .kpi-narrow { flex-basis: 33.333%; }
    @media (max-width: 1400px){ .kpi-row { flex-wrap:wrap; } .kpi-narrow { flex-basis: calc(33.333% - 14px); } }
    @media (max-width: 992px){ .kpi-narrow { flex-basis: calc(50% - 14px); } }
    @media (max-width: 768px){ .kpi-narrow { flex-basis: 100%; } }
        </style>

        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Supervisors (Traffic Light)</h3></div>
                <div class="box-body">
                    <?php
                        $supGreen = PgSetting::trafficLightLabel('supervisor', 'green');
                        $supYellow = PgSetting::trafficLightLabel('supervisor', 'yellow');
                        $supRed = PgSetting::trafficLightLabel('supervisor', 'red');
                    ?>
                    <div class="kpi-row">
                        <div class="kpi-card kpi-narrow kpi-green">
                            <div class="kpi-text">
                                <p class="kpi-title"><?= Html::encode($supGreen) ?></p>
                                <p class="kpi-value"><?= (int)(($supervisorTraffic['green'] ?? 0)) ?></p>
                            </div>
                            <div class="kpi-icon"><span class="fa fa-circle"></span></div>
                        </div>
                        <div class="kpi-card kpi-narrow kpi-yellow">
                            <div class="kpi-text">
                                <p class="kpi-title"><?= Html::encode($supYellow) ?></p>
                                <p class="kpi-value"><?= (int)(($supervisorTraffic['yellow'] ?? 0)) ?></p>
                            </div>
                            <div class="kpi-icon"><span class="fa fa-circle"></span></div>
                        </div>
                        <div class="kpi-card kpi-narrow kpi-red">
                            <div class="kpi-text">
                                <p class="kpi-title"><?= Html::encode($supRed) ?></p>
                                <p class="kpi-value"><?= (int)(($supervisorTraffic['red'] ?? 0)) ?></p>
                            </div>
                            <div class="kpi-icon"><span class="fa fa-circle"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Examination Committee (Traffic Light)</h3></div>
                <div class="box-body">
                    <?php
                        $cmGreen = PgSetting::trafficLightLabel('exam_committee', 'green');
                        $cmYellow = PgSetting::trafficLightLabel('exam_committee', 'yellow');
                        $cmRed = PgSetting::trafficLightLabel('exam_committee', 'red');
                    ?>
                    <div class="kpi-row">
                        <div class="kpi-card kpi-narrow kpi-green">
                            <div class="kpi-text">
                                <p class="kpi-title"><?= Html::encode($cmGreen) ?></p>
                                <p class="kpi-value"><?= (int)(($committeeTraffic['green'] ?? 0)) ?></p>
                            </div>
                            <div class="kpi-icon"><span class="fa fa-circle"></span></div>
                        </div>
                        <div class="kpi-card kpi-narrow kpi-yellow">
                            <div class="kpi-text">
                                <p class="kpi-title"><?= Html::encode($cmYellow) ?></p>
                                <p class="kpi-value"><?= (int)(($committeeTraffic['yellow'] ?? 0)) ?></p>
                            </div>
                            <div class="kpi-icon"><span class="fa fa-circle"></span></div>
                        </div>
                        <div class="kpi-card kpi-narrow kpi-red">
                            <div class="kpi-text">
                                <p class="kpi-title"><?= Html::encode($cmRed) ?></p>
                                <p class="kpi-value"><?= (int)(($committeeTraffic['red'] ?? 0)) ?></p>
                            </div>
                            <div class="kpi-icon"><span class="fa fa-circle"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">


        <div class="col-md-4">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?= (int)($overallRc['research'] ?? 0) ?></h3>
                    <p>Jumlah Pelajar Pascasiswazah</p>
                    <p style="margin:8px 0 0; font-size:14px;">
                        Local: <strong><?= (int)($localCount ?? 0) ?></strong> |
                        International: <strong><?= (int)($internationalCount ?? 0) ?></strong>
                    </p>
                </div>
                <div class="icon"><i class="fa fa-globe"></i></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <?php $masterTotal = (int)($masterModes[1] ?? 0) + (int)($masterModes[2] ?? 0); ?>
                    <h3><?= $masterTotal ?></h3>
                    <p>Jumlah Pelajar Sarjana (Master)</p>
                    <p style="margin:8px 0 0; font-size:14px;">
                        Sepenuh Masa: <strong><?= (int)($masterModes[1] ?? 0) ?></strong> |
                        Separuh Masa: <strong><?= (int)($masterModes[2] ?? 0) ?></strong>
                    </p>
                </div>
                <div class="icon"><i class="fa fa-book"></i></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-red">
                <div class="inner">
                    <?php $phdTotal = (int)($phdModes[1] ?? 0) + (int)($phdModes[2] ?? 0); ?>
                    <h3><?= $phdTotal ?></h3>
                    <p>Jumlah Pelajar PhD</p>
                    <p style="margin:8px 0 0; font-size:14px;">
                        Sepenuh Masa: <strong><?= (int)($phdModes[1] ?? 0) ?></strong> |
                        Separuh Masa: <strong><?= (int)($phdModes[2] ?? 0) ?></strong>
                    </p>
                </div>
                <div class="icon"><i class="fa fa-flask"></i></div>
            </div>
        </div>
    </div>

         <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Pecahan Pelajar Mengikut Negara</h3></div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">Negara</th>
                                <th colspan="2">Research</th>
                                <th rowspan="2">Jumlah</th>
                            </tr>
                            <tr>
                                <th>PhD</th>
                                <th>Master</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sumResearchPhd = 0; $sumResearchMaster = 0;
                        $sumTotal = 0;
                        foreach ($byCountryRows as $r) {
                            $id = (int)($r['nationality'] ?? 0);
                            if (!$id) { continue; }
                            $name = isset($countries[$id]) ? $countries[$id]->country_name : ('ID ' . $id);
                            $researchPhd = isset($r['research_phd_cnt']) ? (int)$r['research_phd_cnt'] : 0;
                            $researchMaster = isset($r['research_master_cnt']) ? (int)$r['research_master_cnt'] : 0;
                            $total = isset($r['cnt']) ? (int)$r['cnt'] : ($researchPhd + $researchMaster);
                            $sumResearchPhd += $researchPhd;
                            $sumResearchMaster += $researchMaster;
                            $sumTotal += $total;
                        ?>
                            <tr>
                                <td><?= Html::encode($name) ?></td>
                                <td><?= Html::a((string)$researchPhd, ['research', 'semester_id' => $semester_id ?? null, 'StudentPostGradSearch[nationality]' => $id, 'StudentPostGradSearch[pro_level]' => 4]) ?></td>
                                <td><?= Html::a((string)$researchMaster, ['research', 'semester_id' => $semester_id ?? null, 'StudentPostGradSearch[nationality]' => $id, 'StudentPostGradSearch[pro_level]' => 3]) ?></td>
                                <td><?= $total ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th>Grand Total</th>
                            <th><?= (int)$sumResearchPhd ?></th>
                            <th><?= (int)$sumResearchMaster ?></th>
                            <th><?= (int)$sumTotal ?></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

             <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Pecahan Pelajar Mengikut Bidang Pengajian (Research)</h3></div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Bidang Pengajian</th>
                                <th>PhD</th>
                                <th>Master</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sumPhd = 0; $sumMaster = 0; $sumTotal = 0;
                        foreach ($byFieldRows as $r) {
                            $id = (int)($r['field_id'] ?? 0);
                            if (!$id) { continue; }
                            $name = isset($fields[$id]) ? $fields[$id]->field_name : ('ID ' . $id);
                            $phd = isset($r['phd_cnt']) ? (int)$r['phd_cnt'] : 0;
                            $master = isset($r['master_cnt']) ? (int)$r['master_cnt'] : 0;
                            $total = isset($r['cnt']) ? (int)$r['cnt'] : ($phd + $master);
                            $sumPhd += $phd;
                            $sumMaster += $master;
                            $sumTotal += $total;
                        ?>
                            <tr>
                                <td><?= Html::encode($name) ?></td>
                                <td><?= Html::a((string)$phd, ['research', 'semester_id' => $semester_id ?? null, 'StudentPostGradSearch[field_id]' => $id, 'StudentPostGradSearch[pro_level]' => 4, 'StudentPostGradSearch[status_aktif]' => StudentRegister::STATUS_AKTIF_AKTIF]) ?></td>
                                <td><?= Html::a((string)$master, ['research', 'semester_id' => $semester_id ?? null, 'StudentPostGradSearch[field_id]' => $id, 'StudentPostGradSearch[pro_level]' => 3, 'StudentPostGradSearch[status_aktif]' => StudentRegister::STATUS_AKTIF_AKTIF]) ?></td>
                                <td><?= $total ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th>Grand Total</th>
                            <th><?= (int)$sumPhd ?></th>
                            <th><?= (int)$sumMaster ?></th>
                            <th><?= (int)$sumTotal ?></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>



    

</div>
