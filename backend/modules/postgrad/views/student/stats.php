<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $activeCount integer */
/* @var $studyMode array */
/* @var $programLevel array */
/* @var $years array */
/* @var $byCountryRows array */
/* @var $countries array */
/* @var $byFieldRows array */
/* @var $fields array */

$this->title = 'Sistem Pemantauan Akademik Pascasiswazah';
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="postgrad-stats">

    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?= (int)$activeCount ?></h3>
                    <p>Jumlah Pelajar Pascasiswazah</p>
                    <p style="margin:8px 0 0; font-size:14px;">
                        Research: <strong><?= (int)($overallRc['research'] ?? 0) ?></strong> |
                        Coursework: <strong><?= (int)($overallRc['coursework'] ?? 0) ?></strong>
                    </p>
                </div>
                <div class="icon"><i class="fa fa-graduation-cap"></i></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?= (int)$activeCount ?></h3>
                    <p>Jumlah Pelajar Pascasiswazah</p>
                    <p style="margin:8px 0 0; font-size:14px;">
                        Local: <strong><?= (int)($localCount ?? 0) ?></strong> |
                        International: <strong><?= (int)($internationalCount ?? 0) ?></strong>
                    </p>
                </div>
                <div class="icon"><i class="fa fa-globe"></i></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <?php $masterTotal = (int)($masterRc['research'] ?? 0) + (int)($masterRc['coursework'] ?? 0); ?>
                    <h3><?= $masterTotal ?></h3>
                    <p>Jumlah Pelajar Sarjana (Master)</p>
                    <p style="margin:8px 0 0; font-size:14px;">
                        Research: <strong><?= (int)($masterRc['research'] ?? 0) ?></strong> |
                        Coursework: <strong><?= (int)($masterRc['coursework'] ?? 0) ?></strong>
                    </p>
                </div>
                <div class="icon"><i class="fa fa-book"></i></div>
            </div>
        </div>

        <div class="col-md-3">
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

   

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Senarai Pelajar Mengikut Negara</h3></div>
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
                                <td><?= Html::a((string)$research, ['research', 'StudentPostGradSearch[nationality]' => $id]) ?></td>
                                <td><?= Html::a((string)$coursework, ['coursework', 'StudentPostGradSearch[nationality]' => $id]) ?></td>
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
                <div class="box-header with-border"><h3 class="box-title">Senarai Pelajar Mengikut Bidang Pengajian</h3></div>
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
