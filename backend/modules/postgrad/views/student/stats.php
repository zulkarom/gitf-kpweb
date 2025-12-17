<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\Semester;
use yii\helpers\ArrayHelper;
use backend\modules\postgrad\models\StudentRegister;

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
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Pecahan Pelajar Mengikut Status Daftar (Aktif)</h3></div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Status Daftar</th>
                                <th style="width:120px;">Bilangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $rows = isset($statusDaftarRows) ? $statusDaftarRows : [];
                        $sum = 0;
                        foreach ($rows as $r) {
                            $code = array_key_exists('status_daftar', $r) ? $r['status_daftar'] : null;
                            $cnt = isset($r['cnt']) ? (int)$r['cnt'] : 0;
                            $sum += $cnt;
                            $val = ($code === null || $code === '') ? null : (int)$code;
                        ?>
                            <tr>
                                <td><?= StudentRegister::statusDaftarLabel($val) ?></td>
                                <td><?= Html::a((string)$cnt, ['index', 'semester_id' => $semester_id ?? null, 'StudentPostGradSearch[status_daftar]' => $val, 'StudentPostGradSearch[status_aktif]' => StudentRegister::STATUS_AKTIF_AKTIF]) ?></td>
                            </tr>
                        <?php } ?>
                            <tr>
                                <th>Grand Total</th>
                                <th><?= (int)$sum ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Pecahan Pelajar Mengikut Status Aktif</h3></div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Status Aktif</th>
                                <th style="width:120px;">Bilangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $rows2 = isset($statusAktifRows) ? $statusAktifRows : [];
                        $sum2 = 0;
                        foreach ($rows2 as $r) {
                            $code2 = array_key_exists('status_aktif', $r) ? $r['status_aktif'] : null;
                            $cnt2 = isset($r['cnt']) ? (int)$r['cnt'] : 0;
                            $sum2 += $cnt2;
                            $val2 = ($code2 === null || $code2 === '') ? null : (int)$code2;
                        ?>
                            <tr>
                                <td><?= StudentRegister::statusAktifLabel($val2) ?></td>
                                <td><?= Html::a((string)$cnt2, ['index', 'semester_id' => $semester_id ?? null, 'StudentPostGradSearch[status_aktif]' => $val2]) ?></td>
                            </tr>
                        <?php } ?>
                            <tr>
                                <th>Grand Total</th>
                                <th><?= (int)$sum2 ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-8">

         <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Pecahan Pelajar Mengikut Negara</h3></div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">Negara</th>
                                <th colspan="2">Research</th>
                                <th colspan="2">Coursework</th>
                                <th rowspan="2">Jumlah</th>
                            </tr>
                            <tr>
                                <th>PhD</th>
                                <th>Master</th>
                                <th>PhD</th>
                                <th>Master</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sumResearchPhd = 0; $sumResearchMaster = 0;
                        $sumCourseworkPhd = 0; $sumCourseworkMaster = 0;
                        $sumTotal = 0;
                        foreach ($byCountryRows as $r) {
                            $id = (int)($r['nationality'] ?? 0);
                            if (!$id) { continue; }
                            $name = isset($countries[$id]) ? $countries[$id]->country_name : ('ID ' . $id);
                            $researchPhd = isset($r['research_phd_cnt']) ? (int)$r['research_phd_cnt'] : 0;
                            $researchMaster = isset($r['research_master_cnt']) ? (int)$r['research_master_cnt'] : 0;
                            $courseworkPhd = isset($r['coursework_phd_cnt']) ? (int)$r['coursework_phd_cnt'] : 0;
                            $courseworkMaster = isset($r['coursework_master_cnt']) ? (int)$r['coursework_master_cnt'] : 0;
                            $total = isset($r['cnt']) ? (int)$r['cnt'] : ($researchPhd + $researchMaster + $courseworkPhd + $courseworkMaster);
                            $sumResearchPhd += $researchPhd;
                            $sumResearchMaster += $researchMaster;
                            $sumCourseworkPhd += $courseworkPhd;
                            $sumCourseworkMaster += $courseworkMaster;
                            $sumTotal += $total;
                        ?>
                            <tr>
                                <td><?= Html::encode($name) ?></td>
                                <td><?= Html::a((string)$researchPhd, ['research', 'semester_id' => $semester_id ?? null, 'StudentPostGradSearch[nationality]' => $id, 'StudentPostGradSearch[pro_level]' => 4]) ?></td>
                                <td><?= Html::a((string)$researchMaster, ['research', 'semester_id' => $semester_id ?? null, 'StudentPostGradSearch[nationality]' => $id, 'StudentPostGradSearch[pro_level]' => 3]) ?></td>
                                <td><?= Html::a((string)$courseworkPhd, ['coursework', 'semester_id' => $semester_id ?? null, 'StudentPostGradSearch[nationality]' => $id, 'StudentPostGradSearch[pro_level]' => 4]) ?></td>
                                <td><?= Html::a((string)$courseworkMaster, ['coursework', 'semester_id' => $semester_id ?? null, 'StudentPostGradSearch[nationality]' => $id, 'StudentPostGradSearch[pro_level]' => 3]) ?></td>
                                <td><?= $total ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th>Grand Total</th>
                            <th><?= (int)$sumResearchPhd ?></th>
                            <th><?= (int)$sumResearchMaster ?></th>
                            <th><?= (int)$sumCourseworkPhd ?></th>
                            <th><?= (int)$sumCourseworkMaster ?></th>
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

    <div class="row">
        <div class="col-md-6">
           
        </div>

        <div class="col-md-6">
           
        </div>
    </div>

    

</div>
