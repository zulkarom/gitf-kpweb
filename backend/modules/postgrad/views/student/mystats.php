<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
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

$this->title = 'Statistik Pelajar Di Bawah Seliaan Saya';
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="postgrad-stats">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Ringkasan Pelajar Di Bawah Seliaan</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 35%;">Jumlah Pelajar Aktif</th>
                                    <td><?= (int)$activeCount ?></td>
                                </tr>
                                <tr>
                                    <th>Research / Coursework</th>
                                    <td>
                                        Research: <strong><?= (int)($overallRc['research'] ?? 0) ?></strong>
                                        &nbsp;|
                                        Coursework: <strong><?= (int)($overallRc['coursework'] ?? 0) ?></strong>
                                    </td>
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
                                <th>Coursework</th>
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
                                <td><?= (string)$coursework ?></td>
                                <td><?= $total ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th>Grand Total</th>
                            <th><?= (int)$sumResearch ?></th>
                            <th><?= (int)$sumCoursework ?></th>
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
